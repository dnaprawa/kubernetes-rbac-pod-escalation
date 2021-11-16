FROM php:7-apache

LABEL MAINTAINER Damian Naprawa
LABEL EMAIL akademia@wkontenerach.pl

COPY index.php /var/www/html/index.php
