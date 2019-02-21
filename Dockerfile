FROM ubuntu:16.04
MAINTAINER kchen9530@gmail.com

CMD chown -R mysql:mysql /var/lib/mysql /var/run/mysqld; \ 
    service apache2 restart; \
    service mysql restart; \
    echo "welcome :)"; \ 
    /bin/bash

RUN apt-get update
RUN apt-get install -y g++ vim

# Apache2
RUN apt-get install -y apache2
RUN echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf
RUN apache2ctl configtest

# PHP
RUN apt-get install -y php-pear php-fpm php-dev php-zip php-curl php-xmlrpc php-gd php-mysql php-mbstring php-xml libapache2-mod-php

# Mysql
ENV MYSQL_PWD 123456
RUN echo "mysql-server mysql-server/root_password password $MYSQL_PWD" | debconf-set-selections
RUN echo "mysql-server mysql-server/root_password_again password $MYSQL_PWD" | debconf-set-selections
RUN apt-get -y install mysql-server

