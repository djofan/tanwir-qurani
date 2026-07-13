# ===== Stage 1: Build frontend assets (Vite) =====
FROM node:20-alpine AS node-build
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# ===== Stage 2: PHP app =====
FROM php:8.3-cli-alpine

# Install system deps + PHP extensions Laravel/Filament butuhkan
RUN apk add --no-cache \
    git \
    unzip \
    libpq \
    postgresql-dev \
    sqlite-dev \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pdo_sqlite \
    intl \
    zip \
    mbstring \
    opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy source code
COPY . .

# Copy built assets dari stage node-build
COPY --from=node-build /app/public/build ./public/build

# Install dependency PHP (production, tanpa dev deps)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permission untuk storage & cache
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["docker-entrypoint.sh"]
