#!/bin/sh
echo "🚀 Deploying to production"

git config pull.rebase true && git pull origin main

docker compose down

docker compose --env-file .env --env-file .env.local -f compose.yaml -f compose.prod.yaml up --build -d

docker compose exec php npm install &&
docker compose exec php npm run build
