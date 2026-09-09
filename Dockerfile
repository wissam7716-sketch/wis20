FROM php:8.2-fpm

RUN apt-get update && apt-get install -y nginx && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html
WORKDIR /var/www/html

RUN echo 'server { \
    listen 8080; \
    root /var/www/html; \
    index Namero.php index.php; \
    location / { \
        try_files $uri $uri/ /Namero.php?$query_string; \
    } \
    location ~ \.php$ { \
        include fastcgi_params; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
    } \
}' > /etc/nginx/sites-available/default

EXPOSE 8080

CMD ["sh", "-c", "php-FPM -D && nginx -g 'daemon off;'"]
