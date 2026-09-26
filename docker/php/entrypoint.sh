#!/bin/sh
set -e

echo "==> Starting entrypoint..."

# ------------------------------------------------------------------
# Check if .env exists
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
# Install composer dependencies if vendor is empty
# ------------------------------------------------------------------
if [ ! -f /var/www/vendor/autoload.php ]; then
    echo "==> Installing composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
else
    echo "==> Composer dependencies already installed, skipping."
fi

# ------------------------------------------------------------------
# Install node dependencies and build frontend assets (if any)
# ------------------------------------------------------------------
if [ -f /var/www/package.json ]; then
    # Install node_modules if missing
    if [ ! -d /var/www/node_modules ]; then
        echo "==> Installing npm dependencies..."
        npm install || { echo "==> ERROR: npm install failed."; }
    else
        echo "==> npm dependencies already installed, skipping."
    fi

    # Build frontend assets if the Vite manifest is missing
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
# Generate APP_KEY if not set
# ------------------------------------------------------------------
if [ -f /var/www/.env ] && ! grep -q "^APP_KEY=base64:" /var/www/.env; then
    echo "==> Generating application key..."
    php artisan key:generate --force || echo "==> WARNING: key:generate failed."
fi

# ------------------------------------------------------------------
# Run migrations (can be disabled via RUN_MIGRATIONS=false)
# ------------------------------------------------------------------
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "==> Running migrations..."
    php artisan migrate --force || echo "==> WARNING: migrations failed."
fi

# ------------------------------------------------------------------
# Permissions for storage and bootstrap/cache
# ------------------------------------------------------------------
echo "==> Fixing permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true

# ------------------------------------------------------------------
# Clear and warm up caches (optional)
# ------------------------------------------------------------------
if [ "${CACHE_WARMUP:-false}" = "true" ]; then
    echo "==> Warming up caches..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "==> Entrypoint finished. Starting: $@"

# ------------------------------------------------------------------
# Exec main process (php-fpm)
# ------------------------------------------------------------------
exec "$@"
