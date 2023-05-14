FROM php:8.2-rc-fpm
LABEL maintainer="Williams Olawale (olawalewilliams9438@gmail.com)"

##############################################################################
# Set work directory
##############################################################################
WORKDIR /app

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
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


##############################################################################
# Install git
############################################################################## 
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


##############################################################################
# Create a new user
##############################################################################
RUN adduser --disabled-password --gecos '' developer


##############################################################################
# Add user to the group
##############################################################################
RUN chown -R developer:www-data /var/www

RUN chmod 755 /var/www


##############################################################################
# Switch to this user
##############################################################################
USER developer

##############################################################################
# install dependencies
##############################################################################
COPY composer.json /var/www/html/
RUN composer install

##############################################################################
# Copy our code across
##############################################################################
COPY . /var/www/html/


# Expose listen ports
EXPOSE 9000



