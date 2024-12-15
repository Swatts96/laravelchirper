#!/bin/bash

# Run migrations
php artisan migrate --force

# Start Apache in the foreground
exec apache2-foreground
