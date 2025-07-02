#!/bin/sh

if [ ! -f 'vendor/autoload.php' ]; then
    composer install
    php artisan key:generate
    php artisan storage:link
    php artisan passport:client --password
fi

# npm install -g laravel-echo-server
# laravel-echo-server start

# service supervisor start
/usr/sbin/apache2ctl -D FOREGROUND
# php artisan serve --host=0.0.0.0