
echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

php artisan config:cache
php artisan route:cache

PORT=${PORT:-8000}
echo "Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT
