FROM php:7.4-cli

ENV APP_TMP_DATA=/tmp

WORKDIR /srv

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y git unzip libzip-dev zip \
    && docker-php-ext-install zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    # && php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /bin/composer

RUN cd /tmp && git clone https://github.com/phpredis/phpredis.git && cd phpredis && phpize && ./configure && make && make install && cd .. && rm -rf phpredis

ENTRYPOINT [ "sleep", "infinity" ]