# ═══════════════════════════════════════════════════════════════════
# SI Qurban — Multi-Stage Docker Build
# Compatible: Windows (Docker Desktop), macOS, Linux
# ═══════════════════════════════════════════════════════════════════

# ────────────────────────────────────────────────────────────────
# Stage 1 — Frontend Assets (Node.js)
# ────────────────────────────────────────────────────────────────
FROM node:22-alpine AS frontend

WORKDIR /app

# Install deps dulu (cache layer)
COPY package.json package-lock.json* ./
RUN npm ci --silent --no-audit

# Copy hanya file yang dibutuhkan untuk build
COPY resources/          resources/
COPY tailwind.config.js  tailwind.config.js
COPY postcss.config.js   postcss.config.js
COPY vite.config.mjs     vite.config.mjs
COPY public/             public/

# Build assets (CSS + JS + Tailwind)
RUN npm run build

# ────────────────────────────────────────────────────────────────
# Stage 2 — PHP Application
# ────────────────────────────────────────────────────────────────
FROM php:8.4-fpm-bookworm AS app

ARG WWWGROUP=1000
ARG WWWUSER=1000

WORKDIR /var/www/html

# ── System dependencies ──────────────────────────────────────────
RUN apt-get update && apt-get install -y --no-install-recommends \
        # Tools
        curl git unzip supervisor nginx \
        # Database clients
        default-mysql-client \
        # PHP extension deps
        libpng-dev libjpeg62-turbo-dev libwebp-dev libfreetype6-dev \
        libzip-dev libgd-dev libonig-dev libxml2-dev \
        libpq-dev \
    && docker-php-ext-configure gd \
        --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_mysql pdo_pgsql \
        gd zip bcmath mbstring xml pcntl \
    && rm -rf /var/lib/apt/lists/*

# ── PHP config (production-ready) ───────────────────────────────
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i \
        -e 's/upload_max_filesize = 2M/upload_max_filesize = 64M/' \
        -e 's/post_max_size = 8M/post_max_size = 64M/' \
        -e 's/memory_limit = 128M/memory_limit = 256M/' \
        "$PHP_INI_DIR/php.ini"

# ── Composer ────────────────────────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ── Non-root user (cross-platform compatible) ───────────────────
RUN groupadd --force -g ${WWWGROUP} www \
    && useradd -ms /bin/bash --no-user-group -g ${WWWGROUP} -u ${WWWUSER} www

# ── Nginx config ─────────────────────────────────────────────────
COPY docker/nginx.conf /etc/nginx/nginx.conf

# ── Supervisor config (manages php-fpm + nginx) ──────────────────
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ── Start script ─────────────────────────────────────────────────
COPY docker/start-container.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

# ── Application source ───────────────────────────────────────────
COPY . .

# ── Frontend build dari Stage 1 ──────────────────────────────────
COPY --from=frontend /app/public/build public/build

# ── Composer install (production, no dev) ────────────────────────
RUN composer install \
        --no-interaction \
        --no-dev \
        --prefer-dist \
        --optimize-autoloader \
    && php artisan package:discover --ansi || true

# ── Permissions ──────────────────────────────────────────────────
RUN chown -R www:www /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 80 8000

CMD ["start-container"]
