FROM php:8.2-fpm

# Update and install necessary packages
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libwebp-dev \
        libxpm-dev \
        zip \
        unzip \
        git

# Install and enable PHP extensions
RUN docker-php-ext-configure gd \
        --with-jpeg \
        --with-freetype \
        --with-webp \
        --with-xpm \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql \
    && docker-php-ext-enable gd mysqli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Increase upload size
RUN echo "upload_max_filesize = 1000M" >> /usr/local/etc/php/conf.d/uploads.ini
RUN echo "post_max_size = 1000M" >> /usr/local/etc/php/conf.d/uploads.ini

# Increase memory limit
RUN echo "memory_limit = 1000M" >> /usr/local/etc/php/conf.d/memory_limit.ini
