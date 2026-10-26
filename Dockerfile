# Build frontend assets.
FROM node:22-alpine AS assets
WORKDIR /src
COPY package*.json ./
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi
COPY . .
RUN npm run build

# Build/run Laravel with PHP-FPM.
FROM php:8.4-fpm AS app

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libzip-dev libicu-dev libonig-dev \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql mbstring bcmath pcntl zip intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
COPY . .

# Install locked production dependencies when composer.lock is available.
RUN if [ -f composer.lock ]; then \
        composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader; \
    else \
        composer update --no-dev --prefer-dist --no-interaction --optimize-autoloader; \
    fi

# Copy the compiled Vite assets from the frontend build.
COPY --from=assets /src/public/build/ /var/www/html/public/build/

RUN mkdir -p storage/framework/cache storage/framework/sessions \
    storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]

# Nginx image with Laravel's public directory and custom configuration.
FROM nginx:alpine AS web
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=app /var/www/html/public/ /var/www/html/public/
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]

# Kubernetes-specific Nginx image.
FROM nginx:alpine AS web-k8s
COPY k8s/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=app /var/www/html/public/ /var/www/html/public/
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
