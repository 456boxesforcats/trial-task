FROM php:8.1-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
WORKDIR /var/www/html
COPY public /var/www/html
COPY .env /var/www
COPY composer.json /var/www
COPY scripts /var/www/scripts
COPY vendor /var/www/vendor
EXPOSE 80