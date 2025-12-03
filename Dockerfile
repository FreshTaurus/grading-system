FROM php:8.2-apache

# Install PostgreSQL extension for PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy application files to the web server directory
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Enable Apache mod_rewrite if needed
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

