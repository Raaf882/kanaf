FROM php:8.3-cli

# System packages
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    sqlite3 \
    libsqlite3-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm

# PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    mbstring \
    zip \
    exif \
    pcntl

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# App directory
WORKDIR /app

# Copy files
COPY . .

# Install Composer dependencies
RUN composer install --ignore-platform-reqs --no-dev --prefer-dist --no-interaction

# Install frontend dependencies
RUN npm install

# Build assets
RUN npm run build

# Permissions
RUN chmod -R 775 storage bootstrap/cache database

EXPOSE 10000

CMD php artisan key:generate --force && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}