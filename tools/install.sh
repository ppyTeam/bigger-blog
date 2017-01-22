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
    su - root -c "npm i -g cross-env webpack@^2.2.0 --registry=https://registry.npm.taobao.org/"
    SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass npm i node-sass --no-bin-links --registry=https://registry.npm.taobao.org/
    npm i --no-bin-links --registry=https://registry.npm.taobao.org/
else
    su - root -c "npm i -g webpack@^2.2.0 --registry=https://registry.npm.taobao.org/"
    SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass npm i node-sass --registry=https://registry.npm.taobao.org/
    npm i --registry=https://registry.npm.taobao.org/
fi