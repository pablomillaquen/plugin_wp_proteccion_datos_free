# Dockerfile for WordPress + WooCommerce Development
FROM wordpress:7.1-php8.2-apache

# Install additional PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo_mysql mysqli \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# Configure Apache
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy custom PHP config
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Expose port
EXPOSE 80