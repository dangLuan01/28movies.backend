FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /app

COPY . /app

COPY .env /app/.env

RUN composer install --optimize-autoloader

RUN chown -R www-data:www-data /app && chmod -R 755 /app

RUN apt-get install supervisor -y

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 9000

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]