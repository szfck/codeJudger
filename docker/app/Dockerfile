FROM ubuntu:18.04

RUN apt-get update
RUN apt-get install -y g++ vim wget

# Apache2
RUN apt-get install -y apache2
RUN echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf

# remove index.php from the base URL
RUN echo "<Directory /var/www/>\n\tAllowOverride All\n</Directory>" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite

RUN apache2ctl configtest

# PHP
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get install -yq --no-install-recommends \
    libapache2-mod-php7.2 \
    php7.2-cli \
    php7.2-json \
    php7.2-curl \
    php7.2-fpm \
    php7.2-gd \
    php7.2-ldap \
    php7.2-mbstring \
    php7.2-mysql \
    php7.2-soap \
    php7.2-sqlite3 \
    php7.2-xml \
    php7.2-zip \
    php7.2-intl

# PHP Unit 
WORKDIR /usr/bin
RUN wget -O phpunit https://phar.phpunit.de/phpunit-7.phar
RUN chmod +x phpunit
RUN apt-get install -y php-xdebug

WORKDIR /var/www/html
