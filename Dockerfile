FROM smraalm/php:3.3
WORKDIR /var/www/html
COPY site.conf /etc/nginx/sites-available/default
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --quiet
COPY .env.example .env
COPY . .
RUN composer dump-autoload
RUN php artisan key:generate

RUN chmod 777 -R /var/www/html/storage /var/www/html/public
