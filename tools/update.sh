#!/bin/bash

# update composer
composer install

php artisan migrate

# check arg
if [[ $1 == '--no-bin-links' ]]; then
    sudo env PATH=$PATH npm up -g cross-env webpack --registry=https://registry.npm.taobao.org/
    SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass npm up node-sass --no-bin-links --registry=https://registry.npm.taobao.org/

    for package in $(npm outdated --parseable --depth=0 --registry=https://registry.npm.taobao.org/ | cut -d: -f2)
    do
        npm i "$package" --no-bin-links --registry=https://registry.npm.taobao.org/
    done
else
    sudo env PATH=$PATH npm up -g webpack --registry=https://registry.npm.taobao.org/
    SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass npm up node-sass --registry=https://registry.npm.taobao.org/

    for package in $(npm outdated --parseable --depth=0 --registry=https://registry.npm.taobao.org/ | cut -d: -f2)
    do
        npm i "$package" --registry=https://registry.npm.taobao.org/
    done
fi

# build js and css files
npm run prod