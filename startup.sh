#!/bin/bash

# startup.sh - Azure Web App Startup Script for Laravel

# Navigate to web root
cd /home/site/wwwroot

# Install Composer dependencies if needed
if [ ! -d "vendor" ]; then
    composer install --no-dev --optimize-autoloader
fi

# Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Run Laravel optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM
php-fpm
