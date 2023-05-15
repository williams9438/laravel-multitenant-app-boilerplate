#!/bin/sh

if [ "$DATABASE" = "postgres" ]
then
    echo "Waiting for postgres..."

    while ! nc -z $DB_HOST $DB_PORT; do
      sleep 0.1
    done

    echo "PostgreSQL started"
fi

##############################################################################
# install dependencies
##############################################################################

# composer install -n

# # generate project key
# php artisan key:generate

# Database migrate
php artisan migrate --force

exec "$@"