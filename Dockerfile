FROM php:8.3-alpine AS production

WORKDIR /var/www/

# Not Ubuntu
RUN apk add --no-cache \
    npm \
    icu-dev \
    libxml2-dev \
    oniguruma-dev \
    openssl-dev \
    bzip2-dev \
    curl-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    freetype-dev \
    libzip-dev \
    mysql-client \
    && docker-php-ext-install \
    pdo pdo_mysql mbstring

COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy package files and install Node dependencies
COPY package*.json ./
RUN npm i
RUN npm i @rollup/rollup-linux-x64-gnu --save-optional

# Build Vue/Vite assets for production
RUN npm run build

# Remove unnecessary files
RUN rm -rf node_modules


# Copy Laravel application files into the container
COPY . /var/www

# Encrypt the .env file (this step should be done locally before building the image)
COPY .env.encrypted /var/www/.env.encrypted

# Setup environment
#RUN if [ ! -f /var/www/.env ]; then cp /var/www/.env.example /var/www/.env; fi
#RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000

HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 CMD [ "curl", "--fail", "http://localhost:8000/up"]

CMD ["sh", "-c", "php artisan env:decrypt --key=$ENCRYPTION_KEY && php -S 0.0.0.0:8000 -t public"]
