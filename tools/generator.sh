#!/bin/bash


if [ -f ./.env ]; then
    echo "What do you want to do ?"
    echo "[0] All of below"
    echo "[1] Create 10 posts"
    echo "[2] Create 3 categories"
    echo "[3] Create 5 tags"
    echo "[4] Add tags and categories to latest 10 posts"
    echo "[5] Create 2 nav"

    read Choose
    case $Choose in
    0)
        php artisan db:seed --class DatabaseSeeder
        ;;
    1)
        php artisan db:seed --class PostSeeder
        ;;
    2)
        php artisan db:seed --class CategorySeeder
        ;;
    3)
        php artisan db:seed --class TagSeeder
        ;;
    4)
        php artisan db:seed --class PostTagCategorySeeder
        ;;
    5)
        php artisan db:seed --class NavSeeder
        ;;
    esac

    echo ""
    echo "Action complete !"
else
    echo "You should 'setup' before generate data."
    echo "Use 'npm run setup' first."
fi