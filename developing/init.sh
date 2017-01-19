#!/bin/bash

# install composer
composer install

# generate app key
cp .env.example .env
php artisan key:generate

# install and update
php artisan migrate:install
php artisan migrate

php artisan db:seed

# check arg
if [[ $1 == '--no-bin-links' ]]; then
    npm i -g cross-env webpack@^2.2.0 --registry=https://registry.npm.taobao.org/
    npm i --no-bin-links --registry=https://registry.npm.taobao.org/
else

    # install global cnpm
    npm i cnpm webpack@^2.2.0 -g --registry=https://registry.npm.taobao.org/
    cnpm i
fi