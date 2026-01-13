# Stage 1: Build Assets
FROM node:20 AS build-assets
WORKDIR /app
COPY package.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Final Image
FROM dunglas/frankenphp:php8.3

# Environment Variables for Production
ENV PHP_OPCACHE_ENABLE=1 \
    PHP_OPCACHE_ENABLE_CLI=1 \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS=0 \
    PHP_OPCACHE_REVALIDATE_FREQ=0 \
    COMPOSER_ALLOW_SUPERUSER=1

# Install system dependencies (Minimal for runtime)
# zip/unzip/git needed for composer interactions or specific libs
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    redis \
    opcache

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# --- COMPOSER CACHE LAYER ---
# Copy only composer files first to leverage Docker cache
COPY composer.json composer.lock ./

# Install dependencies (No scripts, no autoloader yet)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# --- APP COPY LAYER ---
# Copy existing application directory contents
COPY . /app

# Copy built assets from the build-assets stage
COPY --from=build-assets /app/public/build /app/public/build

# Finish Composer (Dump autoload & Scripts)
# Create directories and set permissions
RUN mkdir -p /app/storage/framework/sessions \
    /app/storage/framework/views \
    /app/storage/framework/cache \
    /app/bootstrap/cache \
    && chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Finish Composer (Dump autoload & Scripts)
RUN composer dump-autoload --optimize && \
    composer run-script post-root-package-install



# Copy supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port
EXPOSE 80

# Entrypoint
ENTRYPOINT ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
