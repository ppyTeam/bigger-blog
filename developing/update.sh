#!/bin/bash

# update composer
composer update

php artisan migrate

# check arg
if [[ $1 == '--no-bin-links' ]]; then
    npm up --registry=https://registry.npm.taobao.org/ --no-bin-links
else
    cnpm up
fi

# build js and css files
npm run prod