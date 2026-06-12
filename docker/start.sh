#!/usr/bin/env bash
set -e

cd /var/www/html

mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

if [ -n "${PORT:-}" ] && [ "$PORT" != "80" ]; then
    sed -ri "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
    sed -ri "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf
fi

php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ "${DEPLOY_RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

exec apache2-foreground
