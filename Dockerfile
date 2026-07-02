FROM php:8.2-apache

# PHP dosyalarını sunucunun içine kopyala
COPY . /var/www/html/

# Portu ayarla
EXPOSE 80
