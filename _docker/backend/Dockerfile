FROM php:7.4.19-fpm-buster 

WORKDIR /srv

LABEL AUTHOR "Eduardo Luz <eduardo@eduardo-luz.com>"
LABEL PROJECT "API Mock Server" 
LABEL PROJECT_URL "https://github.com/eduluz1976/api-mock-server"

ENV APP_TMP_DATA=/tmp

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y git unzip 


# Installing Composer v2
# RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
#     && php composer-setup.php \
#     && php -r "unlink('composer-setup.php');" \
#     && mv composer.phar /bin/composer

RUN cd /tmp && git clone https://github.com/phpredis/phpredis.git && cd phpredis && phpize && ./configure && make && make install && cd .. && rm -rf phpredis

COPY _docker/backend/conf/www.conf /etc/php7/php-fpm.d/
COPY  _docker/backend/scripts /root/scripts
COPY ./app /srv

RUN chmod +x /root/scripts/*

HEALTHCHECK --interval=5s --timeout=10s --start-period=5s --retries=3 CMD [ "/root/scripts/healthcheck.sh" ]

