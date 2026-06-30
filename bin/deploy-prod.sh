#!/bin/sh
set -e

echo "=== Deploying Website ==="

DC="docker compose --env-file .env --env-file .env.local -f compose.prod.yaml"

echo "Pulling latest changes..."
git config pull.rebase true && git pull origin main

echo "Updating submodules..."
git submodule sync
git submodule update --init --recursive

echo "Clearing local cache..."
rm -rf var/cache

echo "Building Docker images..."
$DC build --no-cache

echo "Starting new containers (zero-downtime swap)..."
$DC up -d

echo "Waiting for containers to be healthy..."
timeout=120
elapsed=0
while [ $elapsed -lt $timeout ]; do
    unhealthy=$($DC ps --format json 2>/dev/null | grep -c '"unhealthy"\|"starting"' || true)
    if [ "$unhealthy" = "0" ]; then
        echo "All containers are healthy."
        break
    fi
    sleep 5
    elapsed=$((elapsed + 5))
    echo "  Waiting... ($elapsed/${timeout}s)"
done

if [ $elapsed -ge $timeout ]; then
    echo "Warning: Some containers may not be healthy yet."
fi

echo "Running database migrations..."
$DC exec -T php bin/adminconsole doctrine:migrations:migrate --no-interaction --all-or-nothing

echo "Installing assets..."
$DC exec -T php bin/adminconsole assets:install --env=prod

echo "Purging cache..."
$DC exec -T php rm -rf var/cache/admin var/cache/website var/cache/preview

echo "Warming up cache (admin + website)..."
$DC exec -T php bin/adminconsole cache:warmup --env=prod
$DC exec -T php bin/console      cache:warmup --env=prod

echo "Reloading FrankenPHP workers with warm cache..."
$DC restart php

echo ""
echo "=== Deployment complete ==="
$DC ps
