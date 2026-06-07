FROM php:8.4-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

# PHP依存
RUN composer install --no-dev --optimize-autoloader

# ★フロントここ絶対必要
RUN npm install
RUN npm run build

# 確認（超重要）
RUN ls -la public/build || true

EXPOSE 10000

CMD ["sh", "-c", "\
php artisan config:clear && \
php artisan cache:clear && \
php artisan migrate --force && \
php artisan serve --host=0.0.0.0 --port=${PORT:-10000} \
"]