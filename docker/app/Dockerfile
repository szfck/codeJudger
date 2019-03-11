FROM ubuntu:16.04

RUN apt-get update
RUN apt-get install -y g++ vim

# Apache2
RUN apt-get install -y apache2
RUN echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf

# remove index.php from the base URL
RUN echo "<Directory /var/www/>\n\tAllowOverride All\n</Directory>" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite

RUN apache2ctl configtest

# PHP
RUN apt-get install -y php-pear php-fpm php-dev php-zip php-curl php-xmlrpc php-gd php-mysql php-mbstring php-xml libapache2-mod-php
