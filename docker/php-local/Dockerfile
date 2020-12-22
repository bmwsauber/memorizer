FROM php:7.2.5-fpm
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libicu-dev \

    libcurl4-openssl-dev \
    unzip \
    nano \
    git \
    libexif-dev \
    libxrender1 \
    libfontconfig \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) mbstring zip intl curl pdo_mysql tokenizer \
    && docker-php-ext-install exif \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer |  php -- --install-dir=/usr/local/bin --filename=composer
RUN mkdir /app
WORKDIR /app

RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

#RUN yes | pecl install xdebug \
#    && echo "zend_extension=$(find  / -name xdebug.so)" > /usr/local/etc/php/7.1/conf.d/xdebug.ini \
#    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/7.1/conf.d/xdebug.ini \
#    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/7.1/conf.d/xdebug.ini \
#    && echo "xdebug.remote_connect_back=on" >> /usr/local/etc/php/7.1/conf.d/xdebug.ini

RUN usermod -u 1000 www-data