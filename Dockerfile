FROM nanoninja/php-fpm
RUN apt-get update \
    && apt-get install -y \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer