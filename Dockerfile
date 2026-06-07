FROM php:8.4-cli

WORKDIR /var/www

# =========================
# PHP依存
# =========================
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# =========================
# Node.js
# =========================
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# =========================
# Composer
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================
# アプリコピー
# =========================
COPY . .

# =========================
# Laravel依存
# =========================
RUN composer install --no-dev --optimize-autoloader

# =========================
# フロントビルド（超重要）
# =========================
RUN npm install
RUN npm run build

# ★ここ重要：成果物確認
RUN ls -la public/build || true
RUN ls -la public/build/assets || true

# =========================
# ポート
# =========================
EXPOSE 10000

# =========================
# 起動
# =========================
CMD ["sh", "-c", "\
php artisan config:clear && \
php artisan cache:clear && \
php artisan migrate --force && \
php artisan serve --host=0.0.0.0 --port=${PORT:-10000} \
"]