FROM php:7.4-apache

WORKDIR /var/www/html

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

EXPOSE 80

CMD ["apache2-foreground"]