# Set Default ARG PHP VERSION
ARG PHP_VERSION=8.3-cli-alpine
FROM php:${PHP_VERSION}

# ARG From docker-compose.yml
ARG user
ARG uid
ARG DB_DRIVER

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    nodejs \
    npm \
    ${PHPIZE_DEPS}

# Install PHP extensions secara dinamis
RUN set -eux; \
    docker-php-ext-install zip mbstring exif pcntl bcmath gd \
    && if [ "$DB_DRIVER" = "mysql" ]; then \
        docker-php-ext-install pdo_mysql; \
    elif [ "$DB_DRIVER" = "pgsql" ]; then \
        apk add --no-cache postgresql-dev && docker-php-ext-install pdo_pgsql; \
    fi

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN adduser -u $uid -h /home/$user -s /bin/sh -D $user \
    && addgroup $user www-data \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
