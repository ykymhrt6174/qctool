FROM php:8.4-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Node
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 全コピー
COPY . .

# Laravel
RUN composer install --no-dev --optimize-autoloader

# ⭐ Viteここ絶対この順番
RUN npm install
RUN npm run build

# ⭐ 超重要チェック
RUN ls -la public/build

EXPOSE 10000

CMD ["sh", "-c", "\
php artisan config:clear && \
php artisan cache:clear && \
php artisan migrate --force && --seed --force && \
php artisan serve --host=0.0.0.0 --port=${PORT:-10000} \
"]