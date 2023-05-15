FROM php:8.2-rc-fpm
LABEL maintainer="Williams Olawale (olawalewilliams9438@gmail.com)"

##############################################################################
# Set work directory
##############################################################################
WORKDIR /var/www/html/

##############################################################################
# Install selected extensions and other stuff
############################################################################## 
RUN apt-get update \
  && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  zlib1g-dev \
  libpq-dev \
  libzip-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql zip bcmath gd


##############################################################################
# Install composer (php package manager)
############################################################################## 
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer


##############################################################################
# Install git
############################################################################## 
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


##############################################################################
# Copy our code across
##############################################################################
COPY . /var/www/html/
COPY ./dev_env/.app.env /var/www/html/.env
RUN chmod 755 /var/www


#############################################################################
# install dependencies
##############################################################################
# Composer install
RUN composer install -n

##############################################################################
# Change scripts folder permission
##############################################################################
# RUN chmod +x ./scripts/*

##############################################################################
# add and run as non-root user
##############################################################################
RUN useradd myuser
USER myuser

# Uncomment the below for dev only and use dev 
#server and no need for nginx etc
# CMD ["sh", "./scripts/entrypoint.dev.sh"]
# CMD ["php", "artisan", "migrate", "--force"]

CMD ["php-fpm"]

# Expose listen ports
EXPOSE 9000



