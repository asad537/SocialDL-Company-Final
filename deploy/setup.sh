#!/bin/bash
# =============================================================================
# SocialDL Production Setup Script
# Target: Ubuntu 22.04 LTS
# =============================================================================
# Usage: sudo bash deploy/setup.sh
# =============================================================================

set -e

echo "============================================"
echo "  SocialDL Production Setup"
echo "  Target: Ubuntu 22.04 LTS"
echo "============================================"

# ── 1. System Updates ────────────────────────────────────────────────────────
echo "[1/8] Updating system packages..."
apt update && apt upgrade -y

# ── 2. Install Core Dependencies ─────────────────────────────────────────────
echo "[2/8] Installing core dependencies..."
apt install -y \
    nginx \
    mysql-server \
    redis-server \
    supervisor \
    ffmpeg \
    aria2 \
    python3 \
    python3-pip \
    python3-venv \
    curl \
    unzip \
    git \
    software-properties-common

# ── 3. Install PHP + Extensions ──────────────────────────────────────────────
echo "[3/8] Installing PHP 8.1 + extensions..."
add-apt-repository -y ppa:ondrej/php
apt update
apt install -y \
    php8.1-fpm \
    php8.1-cli \
    php8.1-mysql \
    php8.1-redis \
    php8.1-mbstring \
    php8.1-xml \
    php8.1-curl \
    php8.1-zip \
    php8.1-gd \
    php8.1-bcmath \
    php8.1-intl

# ── 4. Install Composer ─────────────────────────────────────────────────────
echo "[4/8] Installing Composer..."
if ! command -v composer &> /dev/null; then
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
fi

# ── 5. Install yt-dlp ───────────────────────────────────────────────────────
echo "[5/8] Installing yt-dlp..."
# System-wide install
curl -L https://github.com/yt-dlp/yt-dlp/releases/latest/download/yt-dlp -o /usr/local/bin/yt-dlp
chmod a+rx /usr/local/bin/yt-dlp

# Also install in project venv
cd /var/www/socialdl
python3 -m venv venv
venv/bin/pip install --upgrade yt-dlp

# ── 6. Configure Redis ──────────────────────────────────────────────────────
echo "[6/8] Configuring Redis..."
# Optimize Redis for production
cat >> /etc/redis/redis.conf << 'REDIS_EOF'

# SocialDL Optimizations
maxmemory 256mb
maxmemory-policy allkeys-lru
tcp-keepalive 60
timeout 300
REDIS_EOF
systemctl restart redis-server
systemctl enable redis-server

# ── 7. Configure MySQL ──────────────────────────────────────────────────────
echo "[7/8] Configuring MySQL..."
mysql -e "CREATE DATABASE IF NOT EXISTS socialdl CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -e "CREATE USER IF NOT EXISTS 'socialdl'@'localhost' IDENTIFIED BY 'CHANGE_THIS_PASSWORD';"
mysql -e "GRANT ALL PRIVILEGES ON socialdl.* TO 'socialdl'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

# ── 8. Deploy Application ───────────────────────────────────────────────────
echo "[8/8] Deploying application..."
cd /var/www/socialdl

# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Install Redis PHP package
composer require predis/predis

# Create storage directories
mkdir -p storage/app/downloads storage/app/hls storage/app/temp
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Update .env for production
sed -i 's/CACHE_DRIVER=file/CACHE_DRIVER=redis/' .env
sed -i 's/QUEUE_CONNECTION=sync/QUEUE_CONNECTION=redis/' .env
sed -i 's/APP_ENV=local/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env

# Run migrations
php artisan migrate --force

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# ── Deploy nginx config ──────────────────────────────────────────────────
cp deploy/nginx.conf /etc/nginx/sites-available/socialdl
ln -sf /etc/nginx/sites-available/socialdl /etc/nginx/sites-enabled/socialdl
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl restart nginx

# ── Deploy Supervisor config ─────────────────────────────────────────────
cp deploy/supervisor.conf /etc/supervisor/conf.d/socialdl.conf
supervisorctl reread
supervisorctl update
supervisorctl start socialdl-workers:*

# ── Setup cron for Laravel scheduler ─────────────────────────────────────
(crontab -u www-data -l 2>/dev/null; echo "* * * * * cd /var/www/socialdl && php artisan schedule:run >> /dev/null 2>&1") | crontab -u www-data -

echo ""
echo "============================================"
echo "  ✅ SocialDL Setup Complete!"
echo "============================================"
echo ""
echo "  Services running:"
echo "    ✓ nginx"
echo "    ✓ php8.1-fpm"
echo "    ✓ redis-server"
echo "    ✓ mysql"
echo "    ✓ supervisor (queue workers)"
echo ""
echo "  Binaries installed:"
echo "    ✓ yt-dlp: $(yt-dlp --version)"
echo "    ✓ ffmpeg: $(ffmpeg -version 2>&1 | head -1)"
echo "    ✓ aria2c: $(aria2c --version 2>&1 | head -1)"
echo ""
echo "  IMPORTANT:"
echo "    1. Update .env with your actual database password"
echo "    2. Update .env APP_URL to your domain"
echo "    3. Update deploy/nginx.conf server_name"
echo "    4. Run: php artisan key:generate"
echo "    5. Setup SSL via Cloudflare or certbot"
echo ""
