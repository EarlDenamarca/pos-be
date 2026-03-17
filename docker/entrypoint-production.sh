#!/bin/sh

mv .env.production .env

if [ ! -f 'vendor/autoload.php' ]; then
    composer install
    php artisan key:generate
fi

if [ ! -f 'storage/oauth-private.key' ] || [ ! -f 'storage/oauth-public.key' ]; then
    php artisan passport:keys --force
fi

chown www-data:www-data storage/oauth-private.key storage/oauth-public.key
chmod 600 storage/oauth-private.key storage/oauth-public.key
chmod -R 775 bootstrap/cache
chown -R www-data:www-data bootstrap/cache storage

php artisan optimize:clear

/usr/sbin/apache2ctl -D FOREGROUND
# php artisan serve --host=0.0.0.0
