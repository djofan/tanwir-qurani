#!/bin/sh
set -e

# Generate APP_KEY kalau belum ada (Render inject via env var, jadi biasanya udah ada)
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Link storage (buat upload file Filament)
php artisan storage:link || true

# Cache config, route, view biar lebih cepat
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migration otomatis tiap deploy
php artisan migrate --force

# Jalankan server, pakai $PORT dari Render (default 8080 kalau gak di-set)
php artisan serve --host 0.0.0.0 --port "${PORT:-8080}"
