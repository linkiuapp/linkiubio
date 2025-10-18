#!/bin/bash

echo "🚀 Deploying Liniu to Production..."

# 1. Verificar que estamos en producción
if [ "$APP_ENV" != "production" ]; then
    echo "⚠️  WARNING: APP_ENV is not 'production'"
    echo "Current APP_ENV: $APP_ENV"
    read -p "Continue anyway? (y/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# 2. Git pull
echo "📥 Pulling latest changes..."
git pull origin staging

# 3. Composer install
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# 4. NPM install y build
echo "📦 Installing JS dependencies..."
npm ci

echo "🔨 Building assets..."
npm run build

# 5. Migrations (con confirmación)
read -p "🗄️  Run migrations? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
fi

# 6. Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 7. Optimize
echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Storage link (si no existe)
if [ ! -L "public/storage" ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link
fi

# 9. Permisos
echo "🔐 Setting permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "✅ Deploy completed successfully!"
echo ""
echo "🧪 Please verify:"
echo "   1. Check https://staging.linkiu.bio"
echo "   2. Open DevTools Console"
echo "   3. Verify NO console.logs appear"
echo "   4. Verify Security Warning appears"

