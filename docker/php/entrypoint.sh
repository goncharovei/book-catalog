#!/bin/sh
set -e

echo "==> Starting entrypoint..."

# ------------------------------------------------------------------
# 1. Проверяем наличие .env
# ------------------------------------------------------------------
if [ ! -f /var/www/.env ]; then
    if [ -f /var/www/.env.example ]; then
        echo "==> .env not found, copying from .env.example"
        cp /var/www/.env.example /var/www/.env
    else
        echo "==> WARNING: .env and .env.example not found!"
    fi
fi

# ------------------------------------------------------------------
# 2. Устанавливаем composer-зависимости, если vendor пуст
# ------------------------------------------------------------------
if [ ! -f /var/www/vendor/autoload.php ]; then
    echo "==> Installing composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
else
    echo "==> Composer dependencies already installed, skipping."
fi

# ------------------------------------------------------------------
# 3. Устанавливаем node-зависимости и собираем фронт (если есть)
# ------------------------------------------------------------------
if [ -f /var/www/package.json ]; then
    # Устанавливаем node_modules, если их нет
    if [ ! -d /var/www/node_modules ]; then
        echo "==> Installing npm dependencies..."
        npm install || { echo "==> ERROR: npm install failed."; }
    else
        echo "==> npm dependencies already installed, skipping."
    fi

    # Собираем фронт, если нет манифеста Vite
    if [ ! -f /var/www/public/build/manifest.json ]; then
        echo "==> Building frontend assets..."
        if npm run build; then
            echo "==> Frontend assets built successfully."
        else
            echo "==> ERROR: npm run build FAILED. Application may not render correctly."
            echo "==> Debug manually: docker compose exec app npm run build"
        fi
    else
        echo "==> Frontend assets already built, skipping."
    fi
fi

# ------------------------------------------------------------------
# 4. Ждём готовности MySQL
# ------------------------------------------------------------------
if [ -n "$DB_HOST" ]; then
    echo "==> Waiting for MySQL at $DB_HOST:${DB_PORT:-3306}..."
    MAX_TRIES=30
    TRIES=0
    until mysqladmin ping -h"$DB_HOST" -P"${DB_PORT:-3306}" -u"$DB_USERNAME" -p"$DB_PASSWORD" --silent 2>/dev/null; do
        TRIES=$((TRIES + 1))
        if [ "$TRIES" -ge "$MAX_TRIES" ]; then
            echo "==> ERROR: MySQL is not responding after $MAX_TRIES attempts. Continuing anyway..."
            break
        fi
        echo "    ...waiting ($TRIES/$MAX_TRIES)"
        sleep 2
    done
    echo "==> MySQL is up."
fi

# ------------------------------------------------------------------
# 5. Генерируем APP_KEY, если его нет
# ------------------------------------------------------------------
if [ -f /var/www/.env ] && ! grep -q "^APP_KEY=base64:" /var/www/.env; then
    echo "==> Generating application key..."
    php artisan key:generate --force || echo "==> WARNING: key:generate failed."
fi

# ------------------------------------------------------------------
# 6. Выполняем миграции (можно отключить через RUN_MIGRATIONS=false)
# ------------------------------------------------------------------
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "==> Running migrations..."
    php artisan migrate --force || echo "==> WARNING: migrations failed."
fi

# ------------------------------------------------------------------
# 7. Права на storage и bootstrap/cache
# ------------------------------------------------------------------
echo "==> Fixing permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true

# ------------------------------------------------------------------
# 8. Очищаем и прогреваем кэш (опционально)
# ------------------------------------------------------------------
if [ "${CACHE_WARMUP:-false}" = "true" ]; then
    echo "==> Warming up caches..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "==> Entrypoint finished. Starting: $@"

# ------------------------------------------------------------------
# 9. Передаём управление основной команде (php-fpm)
# ------------------------------------------------------------------
exec "$@"
