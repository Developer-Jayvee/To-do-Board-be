#!/bin/bash
set -e




composer install --no-dev --optimize-autoloader


php artisan key:generate


php artisan migrate --force


php artisan db:seed --class=CategorySeed || echo "continuing..."


php artisan passport:install -y || echo "continuing..."

#
php artisan passport:client --personal --name="ToDoBoard" || echo "continuing..."


php artisan cache:clear


exec "$@"
