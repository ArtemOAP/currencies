FROM php:7.2-fpm
RUN docker-php-ext-install pdo pdo_mysql
RUN mkdir /var/www/app_var/
RUN mkdir /var/www/app_var/cash
RUN mkdir /var/www/app_var/log
RUN  touch /var/www/app_var/log/app.log
RUN  touch /var/www/app_var/cash/config.php
RUN chown -R www-data:www-data /var/www/app_var/
#COPY ../../public/var/log/app.log /var/www/html/public/var/log/
CMD ["php-fpm"]