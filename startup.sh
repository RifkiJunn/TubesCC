#!/bin/bash

# Navigate to app directory
cd /home/site/wwwroot

# Ensure storage directories exist with proper permissions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 777 storage
chmod -R 775 bootstrap/cache

# Copy nginx config and reload
if [ -f "/home/site/wwwroot/default" ]; then
    cp /home/site/wwwroot/default /etc/nginx/sites-available/default
    service nginx reload
fi

# Run Laravel optimizations
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Only run migrations if not already done
php artisan migrate --force 2>/dev/null || true

# Rebuild cache (after directories exist)
php artisan config:cache
php artisan route:cache

# Create storage link if not exists
php artisan storage:link 2>/dev/null || true
