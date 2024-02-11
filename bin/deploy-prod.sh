#!/bin/sh
echo "🚀 Deploying to production"
composer install
composer dump-env prod
rm -rf public/assets
php bin/console asset-map:compile
php bin/console cache:clear
php bin/console cache:warmup