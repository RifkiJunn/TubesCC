#!/bin/bash

# Copy nginx config to enable Laravel public folder
cp /home/site/wwwroot/default /etc/nginx/sites-available/default
service nginx reload

cd /home/site/wwwroot

# Run package discovery (skipped during CI build)
php artisan package:discover --ansi

# Run migrations with seeding
php artisan migrate --seed --force

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link if not exists
php artisan storage:link 2>/dev/null || true
