############################################################
# Dockerfile to build Contact HTTP container images
# Based on php:8.0
############################################################

FROM php:8.0-apache

MAINTAINER docker@fabwice.com

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

# Install a sweet ass profile
COPY conf/bashrc ~/.bashrc


RUN apt-get update -qq --fix-missing && \
    apt-get install -qy \
    git \
    gnupg \
    unzip \
    zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \	
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/www/*


# Apache
COPY conf/errors /errors
COPY conf/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY conf/apache.conf /etc/apache2/conf-available/z-app.conf
COPY conf/php.ini /usr/local/etc/php/conf.d/app.ini
COPY conf/htaccess /var/www/html/.htaccess
RUN a2enmod status rewrite remoteip headers

# Copy in required files
COPY app/ /var/www/html/
EXPOSE 80

RUN service apache2 start
