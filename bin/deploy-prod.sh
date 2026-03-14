#!/bin/sh
set -e

echo "🚀 Deploying to production"

DC="docker compose --env-file .env --env-file .env.local -f compose.prod.yaml"

git config pull.rebase true && git pull origin main

# Build new images while current containers keep serving traffic
$DC build

# Swap to new containers (fast — images are already built)
$DC up -d --wait

# Database migrations
$DC exec php bin/console doctrine:migrations:migrate --no-interaction --all-or-nothing

# Symfony/Sulu post-deploy (assets are compiled at Docker build time)
$DC exec php bin/console assets:install --env=prod
$DC exec php bin/console cache:clear --env=prod
$DC exec php bin/console cache:warmup --env=prod

echo "✅ Deploy complete"
