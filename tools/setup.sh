#!/bin/bash


# clear
php artisan config:clear
php artisan route:clear
php artisan view:clear



# install composer
echo ""
echo "Install composer modules ? (y/n)"
read -p "(Default: y):" Install_Composer
if [ -z $Install_Composer ]; then
    Install_Composer="y"
fi
if [[ $Install_Composer == y || $Install_Composer == Y ]]; then
    composer install
    echo ""
    echo "Action complete !"
fi



# install node_modules
echo ""
echo "Install NodeJS modules ? (optional) (y/n)"
read -p "(Default: n):" Install_NodeJS
if [ -z $Install_NodeJS ]; then
    Install_NodeJS="n"
fi
if [[ $Install_NodeJS == y || $Install_NodeJS == Y ]]; then

    # check no-bin-links
    echo ""
    echo "With no-bin-links option ? (Helpful in virtual environment) (y/n)"
    read -p "(Default: n):" With_No_Bin_Links
    if [ -z $With_No_Bin_Links ]; then
        With_No_Bin_Links="n"
    fi
    if [[ $With_No_Bin_Links == y || $With_No_Bin_Links == Y ]]; then
        With_No_Bin_Links="--no-bin-links"
    else
        With_No_Bin_Links=""
    fi

    sudo env PATH=$PATH npm i -g cross-env webpack@^2.2.0 --registry=https://registry.npm.taobao.org/
    SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass npm i node-sass $With_No_Bin_Links --registry=https://registry.npm.taobao.org/
    npm i $With_No_Bin_Links --registry=https://registry.npm.taobao.org/

    echo ""
    echo "Action complete !"
fi



# check .env file
if [ -f ./.env ]; then
    echo ""
    echo "The .env file is exist. Reset it ? (y/n)"
    read -p "(Default: y):" Reset_Env
    if [ -z $Reset_Env ]; then
        Reset_Env="y"
    fi
else
    Reset_Env="y"
fi


if [[ $Reset_Env == y || $Reset_Env == Y ]]; then

    # copy .env file
    cp -f .env.example .env


    # app information
    # generate app key
    APP_KEY=`php artisan key:generate --show`
    sed -i 's@^APP_KEY=.*@APP_KEY='$APP_KEY'@' ./.env

    # set APP_URL
    echo ""
    echo "Blog site url (domain or ip, with http(s)://)"
    read -p "(Default: http://localhost):" APP_URL
    if [ -z $APP_URL ]; then
        APP_URL="http://localhost"
    fi
    sed -i 's@^APP_URL=.*@APP_URL='$APP_URL'@' ./.env

    # set APP_ENV
    echo ""
    echo "Current environment ? ([l]ocal/[p]roduction)"
    read -p "(Default: local):" APP_ENV
    if [ -z $APP_ENV ]; then
        APP_ENV="l"
    fi
    if [[ $APP_ENV == p || $APP_ENV == P ]]; then
        APP_ENV="production"
    else
        APP_ENV="local"
    fi
    sed -i 's@^APP_ENV=.*@APP_ENV='$APP_ENV'@' ./.env

    # set APP_DEBUG
    echo ""
    echo "Debug ? (Only worked if current environment is local) (y/n)"
    read -p "(Default: n):" APP_DEBUG
    if [ -z $APP_DEBUG ]; then
        APP_DEBUG="n"
    fi
    if [[ $APP_DEBUG == y || $APP_DEBUG == Y ]]; then
        APP_DEBUG="true"
    else
        APP_DEBUG="false"
    fi
    sed -i 's@^APP_DEBUG=.*@APP_DEBUG='$APP_DEBUG'@' ./.env


    clear
    # db information
    # set DB_CONNECTION
    echo ""
    echo "Database driver ? (mysql, pgsql, sqlite, sqlsrv) (mysql)"
    read -p "(Default: mysql):" DB_CONNECTION
    if [ -z $DB_CONNECTIONG ]; then
        DB_CONNECTION="mysql"
    fi
    sed -i 's@^DB_CONNECTION=.*@DB_CONNECTION='$DB_CONNECTION'@' ./.env

    # set DB_HOST
    echo ""
    echo "Database host ? (localhost)"
    read -p "(Default: localhost):" DB_HOST
    if [ -z $DB_HOST ]; then
        DB_HOST="localhost"
    fi
    sed -i 's@^DB_HOST=.*@DB_HOST='$DB_HOST'@' ./.env

    # set DB_PORT
    echo ""
    echo "Database port ? (3306)"
    read -p "(Default: 3306):" DB_PORT
    if [ -z $DB_PORT ]; then
        DB_PORT="3306"
    fi
    sed -i 's@^DB_PORT=.*@DB_PORT='$DB_PORT'@' ./.env

    # set DB_DATABASE
    echo ""
    echo "Database name ?"
    read DB_DATABASE
    sed -i 's@^DB_DATABASE=.*@DB_DATABASE='${DB_DATABASE//@/\\@}'@' ./.env

    # set DB_USERNAME
    echo ""
    echo "Database username ?"
    read DB_USERNAME
    sed -i 's@^DB_USERNAME=.*@DB_USERNAME='${DB_USERNAME//@/\\@}'@' ./.env

    # set DB_PASSWORD
    echo ""
    echo "Database password ?"
    read -s DB_PASSWORD
    sed -i 's@^DB_PASSWORD=.*@DB_PASSWORD='${DB_PASSWORD//@/\\@}'@' ./.env

    echo ""
    echo "Action complete !"
fi



# install
php artisan config:cache
php artisan migrate:install
php artisan migrate --force
php artisan db:seed --force --class SetupRBAC
php artisan db:seed --force --class SetupSeeder

echo ""
echo "Action complete !"



# optimize
if [[ $APP_ENV == production ]]; then
    php artisan config:cache
    php artisan route:cache
    php artisan optimize
else
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan optimize
fi




# Clear Cache

# php artisan config:clear
# php artisan route:clear
# php artisan view:clear
# php artisan clear-compiled


# Optimize
# php artisan config:cache
# php artisan route:cache
# php artisan optimize