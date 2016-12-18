#!/bin/bash

# update composer
composer install

php artisan migrate

# check arg
if [[ $1 == '--no-bin-links' ]]; then
    npm up --no-bin-links --registry=https://registry.npm.taobao.org/
else
    cnpm up
fi

# build js and css files
npm run prod