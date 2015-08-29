#!/bin/bash
echo "create .env file ..."
cp -n .env.example .env
echo "opening .env file in your editor ..."
sleep 2
editor .env
echo "installing dependencies using composer"
composer install
echo "publish vendor files"
php artisan vendor:publish
echo "generate new keys ..."
php artisan key:generat
php artisan jwt:generate
echo "apply migrations"
php artisan migrate
echo "create a new administrator"
php artisan admin:administrators --new
echo "runnig server"
php artisan serve &
echo "opening browser"
xdg-open "http://localhost:8000/" &
echo "Done !"
