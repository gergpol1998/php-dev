FROM php:8.3-fpm

# Install extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y

# Increase upload size
RUN echo "upload_max_filesize = 1000M" >> /usr/local/etc/php/conf.d/uploads.ini
RUN echo "post_max_size = 1000M" >> /usr/local/etc/php/conf.d/uploads.ini
