# Fix Docker Stacks for Production Deployment

## Context

The current Docker setup has several issues: assets are built *after* the container starts (not baked into the image), the entrypoint runs `composer install` in production, `docker compose down` causes full downtime during deploys, `network_mode: host` is used unnecessarily, and Node.js is left in the final production image. This plan restructures the Docker infrastructure for a clean, reliable production deployment while preserving the existing dev workflow.

**Constraint**: Sulu admin assets (`assets/admin/`) remain a separate manual step via `sulu:build`. Only the 4 Webpack Encore builds (app, front, panel, signature) are baked into the production image.

---

## Files to Modify

| File | Action |
|------|--------|
| `Dockerfile` | Restructure with Node.js builder stage |
| `frankenphp/docker-entrypoint.sh` | Make production-aware |
| `compose.yaml` | Make environment-neutral |
| `compose.override.yaml.dist` | Add dev build target |
| `compose.override.yaml` | Regenerate from .dist |
| `compose.prod.yaml` | Rewrite: proper networking, volumes, logging |
| `compose.prod.override.yaml` | **Delete** |
| `bin/deploy-prod.sh` | Rewrite for minimal downtime |
| `.dockerignore` | Add `node_modules/`, `public/build/` |
| `Makefile` | Fix `prod` target |

---

## Step 1: Fix `.dockerignore`

Add missing exclusions to reduce build context size:

```diff
+ node_modules/
+ public/build/
+ assets/admin/node_modules/
```

(`vendor/` is already excluded on line 29.)

---

## Step 2: Restructure Dockerfile (multi-stage with Node.js builder)

Replace the current 3-stage Dockerfile with 5 stages:

### Stage 1: `frankenphp_base` (mostly unchanged)
- Remove `VOLUME /app/var/` directive (causes issues with named volumes; volume management done via compose)
- Merge `pdo_pgsql` into the main `install-php-extensions` call

### Stage 2: `frankenphp_dev` (unchanged)

### Stage 3: `prod_deps` (new — composer dependencies)
- Copy `composer.json`, `composer.lock`, `symfony.*`
- Run `composer install --no-dev --no-autoloader --no-scripts`
- Copy full source, run `dump-autoload`, `dump-env prod`, `post-install-cmd`
- This stage produces the complete PHP app with vendor

### Stage 4: `assets_builder` (new — Node.js for website assets)
- Base: `node:22-slim`
- Copy `vendor/` from `prod_deps` (needed for `file:vendor/...` references in package.json)
- Copy `package.json`, `yarn.lock`, `webpack*.config.js`, `tsconfig.json`, `assets/{app,front,panel,signature}/`
- Run `yarn install --frozen-lockfile && yarn run build`
- Outputs: `public/build/{app,front,panel,signature}/`

### Stage 5: `frankenphp_prod` (final image)
- PHP production config (ini, opcache preload)
- Copy full app from `prod_deps`
- Overlay built assets from `assets_builder`
- **No Node.js in final image**

BuildKit builds stages 3→4 in sequence, but stage 4 starts as soon as stage 3 finishes. The final image only contains PHP + compiled assets.

---

## Step 3: Make entrypoint production-aware

File: `frankenphp/docker-entrypoint.sh`

Changes:
1. **Remove** the "create project from skeleton" block (lines 7-23) — leftover scaffolding from Symfony Docker template
2. **Remove** `composer clear` (not needed, wastes time)
3. **Guard** `composer install` with `if [ "$APP_ENV" != 'prod' ]` — in production, deps are baked into the image
4. **Keep** database wait loop + migration logic (needed in both envs)
5. **Keep** ACL permissions for `var/`

---

## Step 4: Restructure compose files

### 4a. `compose.yaml` (base — environment-neutral)

Changes from current:
- **Remove** `target: frankenphp_dev` from php build — override files set the target
- **Remove** `APP_ENV: ${APP_ENV:-dev}` — override files set this
- **Add** `depends_on: database: condition: service_healthy` on php service
- **Add** `profiles: ["dev"]` on `node` service (only needed in dev)

### 4b. `compose.override.yaml.dist` (dev)

Add the previously-base settings:
- `target: frankenphp_dev`
- `APP_ENV: dev`
- Override node service with `profiles: []` (removes the restriction, always starts in dev)
- Rest unchanged (bind mounts, xdebug, mailpit, db port)

### 4c. `compose.prod.yaml` (rewrite)

```yaml
services:
  php:
    build:
      context: .
      target: frankenphp_prod
    environment:
      APP_ENV: prod
      APP_SECRET: ${APP_SECRET}
      DATABASE_URL: postgresql://${POSTGRES_USER}:${POSTGRES_PASSWORD}@database:5432/${POSTGRES_DB}?serverVersion=${POSTGRES_VERSION:-16}&charset=utf8
    ports:
      - "${HTTP_PORT:-80}:80"
      - "${HTTPS_PORT:-443}:443/tcp"
      - "${HTTPS_PORT:-443}:443/udp"
    volumes:
      - caddy_data:/data
      - caddy_config:/config
    logging:
      driver: "json-file"
      options:
        max-size: "10m"
        max-file: "3"

  database:
    logging:
      driver: "json-file"
      options:
        max-size: "10m"
        max-file: "3"

volumes:
  caddy_data:
  caddy_config:
  database_data:
```

Key changes:
- **Remove** `network_mode: host` — use proper Docker bridge networking with configurable port mapping (HTTP_PORT/HTTPS_PORT env vars for custom ports behind external reverse proxy)
- **Remove** `env_file: [.env, .env.local]` — prod image has `composer dump-env prod` baked in; env vars set via compose `environment` block
- **Remove** `./var:/app/var` bind mount — let the container manage its own var/ directory
- **Add** `caddy_data`/`caddy_config` volumes — persist TLS certificates
- **Add** log rotation config

### 4d. Delete `compose.prod.override.yaml`

Redundant (only repeated `network_mode: host`).

---

## Step 5: Rewrite deploy script

File: `bin/deploy-prod.sh`

```sh
#!/bin/sh
set -e

echo "Deploying to production"

COMPOSE_CMD="docker compose --env-file .env --env-file .env.local -f compose.yaml -f compose.prod.yaml"

# Pull latest code
git config pull.rebase true && git pull origin main

# Build and replace only the php container (database stays up)
$COMPOSE_CMD up -d --no-deps --build php

echo "Deployment complete"
```

Key improvements:
- **No `docker compose down`** — only the php service is rebuilt/replaced, database stays up
- **No post-deploy `npm install`/`npm run build`** — assets are baked into the image
- `--no-deps` prevents database from being recreated
- Entrypoint still handles migrations on startup

---

## Step 6: Fix Makefile `prod` target

Line 209: remove `git restore package-lock.json` (file doesn't exist in repo, project uses `yarn.lock`):

```makefile
prod:
	@echo "Deploying in production project."
	@ssh -A $(SERVER) 'cd $(DOMAIN) && ./bin/deploy-prod.sh'
```

---

## Verification

1. **Dev workflow**: Run `make config && make start` — should work unchanged
2. **Production image build**: `docker build --target frankenphp_prod -t rmw-php:prod .` — verify it completes with assets in `public/build/{app,front,panel,signature}/`
3. **Production stack**: `docker compose -f compose.yaml -f compose.prod.yaml up -d` — verify php connects to database via Docker DNS, site accessible on configured ports
4. **Deploy**: Run `bin/deploy-prod.sh` — verify no full downtime, database stays up throughout
