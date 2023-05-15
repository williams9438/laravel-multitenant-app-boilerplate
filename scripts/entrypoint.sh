#!/bin/sh

#!/bin/sh

if [ "$DATABASE" = "postgres" ]
then
    echo "Waiting for postgres..."

    while ! nc -z $SQL_HOST $SQL_PORT; do
      sleep 0.1
    done

    echo "PostgreSQL started"
fi

##############################################################################
# install dependencies
##############################################################################

composer install -n

# create super user admin account
php artisan key:generate

exec "$@"