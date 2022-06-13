FROM php:8.1-apache

RUN a2enmod rewrite

RUN apt-get update \
  && apt-get install -y libzip-dev git wget --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

RUN  apt-get update -y && \
     apt-get upgrade -y && \
     apt-get dist-upgrade -y && \
     apt-get -y autoremove && \
     apt-get clean

RUN apt-get install -y p7zip \
    p7zip-full \
    unace \
    zip \
    unzip \
    xz-utils \
    sharutils \
    uudeview \
    mpack \
    arj \
    cabextract \
    file-roller \
    xdg-utils \
    fonts-liberation \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update \
    && apt-get install --no-install-recommends -y memcached libmemcached-tools libzip-dev git  libmemcached-dev \
    && docker-php-ext-configure zip\
    && docker-php-ext-install zip \
    && git clone https://github.com/php-memcached-dev/php-memcached /usr/src/php/ext/memcached && cd /usr/src/php/ext/memcached \
    && docker-php-ext-configure memcached && docker-php-ext-install memcached

CMD ["bash"]

RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

RUN docker-php-ext-install pdo mysqli pdo_mysql;

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www

WORKDIR /var/www/html

COPY apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY entrypoint.sh /entrypoint.sh
COPY . /var/www/html/

RUN chmod +x /entrypoint.sh

CMD ["apache2-foreground"]

ENTRYPOINT ["/entrypoint.sh"]
