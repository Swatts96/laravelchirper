# Stage 1: Node.js for building assets
FROM node:18 AS node-build
WORKDIR /app

# Copy package files and install dependencies
COPY package.json package-lock.json ./
RUN npm install

# Copy application source files and build assets
COPY . .
RUN npm run build

# Stage 2: PHP/Apache for Laravel
FROM php:8.3-apache

# Set environment variables and document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN apt-get update && apt-get install -y libzip-dev zip unzip && docker-php-ext-install pdo_mysql zip && a2enmod rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy Laravel application code
COPY . /var/www/html

# Copy built assets from the Node.js stage
COPY --from=node-build /app/public /var/www/html/public

# Install Composer and PHP dependencies
WORKDIR /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Create necessary directories and set writable permissions
RUN mkdir -p /var/www/html/storage /var/www/html/storage/framework/sessions /var/www/html/storage/framework/views /var/www/html/storage/framework/cache /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/storage/framework/sessions /var/www/html/storage/framework/views /var/www/html/storage/framework/cache /var/www/html/bootstrap/cache

# Set permissions for Laravel storage and cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate application key
RUN php artisan key:generate

# Ensure the public/storage symlink is properly set up
RUN php artisan storage:link

# Ensure necessary migrations are run before startup
RUN php artisan migrate --force

# Set CMD to start the Laravel app
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
