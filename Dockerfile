FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    default-mysql-client


RUN docker-php-ext-install pdo_mysql mbstring bcmath zip

WORKDIR /var/www

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# RUN composer install

EXPOSE 8080

CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
