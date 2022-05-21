FROM php:7.4

RUN apt-get update -y && apt-get install -y openssl zip unzip git


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN docker-php-ext-install mysqli pdo pdo_mysql




WORKDIR /app/backend

COPY . .

RUN composer install

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0