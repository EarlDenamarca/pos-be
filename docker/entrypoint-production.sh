#!/bin/sh

mv .env.production .env

if [ ! -f 'vendor/autoload.php' ]; then
    composer install
    php artisan key:generate
fi

/usr/sbin/apache2ctl -D FOREGROUND
# php artisan serve --host=0.0.0.0