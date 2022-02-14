FROM php:7.4.19-fpm-buster 

WORKDIR /srv

LABEL AUTHOR "Eduardo Luz <eduardo@eduardo-luz.com>"
LABEL PROJECT "API Mock Server" 
LABEL PROJECT_URL "https://github.com/eduluz1976/api-mock-server"

ENV APP_TMP_DATA=/tmp

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y git unzip 


# Installing Composer v2
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /bin/composer
#      # && php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \

COPY _docker/backend/conf/www.conf /etc/php7/php-fpm.d/
COPY  _docker/backend/scripts /root/scripts
COPY ./app /srv

RUN chmod +x /root/scripts/*

HEALTHCHECK --interval=5s --timeout=10s --start-period=5s --retries=3 CMD [ "/root/scripts/healthcheck.sh" ]

