#!/bin/bash

# Navigate to app directory
cd /home/site/wwwroot

# Copy nginx config and reload
if [ -f "/home/site/wwwroot/default" ]; then
    cp /home/site/wwwroot/default /etc/nginx/sites-available/default
    service nginx reload
fi

# Run Laravel optimizations
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Only run migrations if not already done
php artisan migrate --force 2>/dev/null || true

# Create storage link if not exists
php artisan storage:link 2>/dev/null || true
