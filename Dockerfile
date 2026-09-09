FROM php:8.2-apache
EXPOSE 80
COPY . /var/www/html/
WORKDIR /var/www/html/
CMD ["apache2-foreground"]
