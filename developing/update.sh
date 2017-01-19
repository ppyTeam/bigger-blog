#!/bin/bash

# update composer
composer install

php artisan migrate

# check arg
if [[ $1 == '--no-bin-links' ]]; then
    npm up -g cross-env webpack@^2.2.0 --registry=https://registry.npm.taobao.org/
else
    cnpm up -g cross-env webpack@^2.2.0
fi

# build js and css files
npm run prod