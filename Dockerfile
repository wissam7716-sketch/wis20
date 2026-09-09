FROM php:8.2-apache

# تعديل بورت Apache ليستمع على البورت الممرر من Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html/
WORKDIR /var/www/html/

CMD ["apache2-foreground"]
