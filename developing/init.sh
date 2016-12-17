#!/bin/bash

# install composer
composer install

# generate app key
php artisan key:generate

# fill data (only once)
php artisan migrate:install

php artisan migrate

php artisan db:seed

# check arg
if [[ $1 == '--no-bin-links' ]]; then
    npm i --registry=https://registry.npm.taobao.org/ --no-bin-links
else

    # install global cnpm
    npm i cnpm -g --registry=https://registry.npm.taobao.org/
    cnpm i
fi