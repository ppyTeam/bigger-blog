#!/bin/bash

# update composer
composer update

php artisan migrate

# update npm
cnpm update