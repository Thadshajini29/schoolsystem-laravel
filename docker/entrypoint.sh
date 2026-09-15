#!/bin/sh
set -e

echo "==> Preparing application environment..."

# Generate app key if missing
if [ -z "$APP_KEY" ]; then
    echo "==> Generating application key..."
    php artisan key:generate --force
fi

# Ensure storage directories and permissions
mkdir -p /var/www/storage/framework/cache/data
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/logs
mkdir -p /var/www/storage/app/public

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Create public storage link
echo "==> Linking storage directory..."
php artisan storage:link || true

# Wait for database connection
echo "==> Waiting for database connection..."
until php artisan db:monitor > /dev/null 2>&1 || php -r "
try {
    new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    exit(0);
} catch (Exception \$e) {
    exit(1);
}"; do
    echo "Database unavailable, waiting 3 seconds..."
    sleep 3
done

# Run database migrations
echo "==> Running database migrations..."
php artisan migrate --force

# Cache configuration, routes, and views for production
if [ "$APP_ENV" = "production" ]; then
    echo "==> Caching application configuration..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "==> Starting application service..."
exec "$@"
