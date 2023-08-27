# Use an official PHP 7.1 image as the base image
FROM php:7.1-apache

# Enable the headers and opcache modules
RUN a2enmod headers && \
    docker-php-ext-install opcache

# Set the working directory within the container
WORKDIR /var/www/html

# Copy the contents of your PHP web application into the container
COPY ./src /var/www/html
COPY ./apachie /etc/apache2


# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libmariadb-dev-compat \
    libmariadb-dev \
    nano

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install and enable the gd extension
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Set up a custom virtual host configuration

WORKDIR /var/www/html/system
# Run Composer install and dump-autoload
RUN composer install --no-dev --optimize-autoloader && \
    composer dump-autoload && \
    a2enmod rewrite

WORKDIR /var/www/html
# Install PDO and PDO MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set ownership and permissions for the web server
RUN chmod -R o+w /var/www/html/system && \
    chown -R www-data:www-data /var/www/html

EXPOSE 80

# Start the Apache web server when the container starts

CMD ["apache2-foreground"]
