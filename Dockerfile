FROM php:8.3-cli

# Cài các dependency cần thiết
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Làm việc tại thư mục /app
WORKDIR /app

# Copy toàn bộ mã nguồn Laravel vào
COPY . .

# Cài thư viện Laravel
RUN composer install

# Mở port 8000
EXPOSE 8000

# Lệnh mặc định: php artisan serve
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]