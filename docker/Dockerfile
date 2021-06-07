FROM php:8-apache

ARG BUILD_ARGUMENT_ENV=prod
ARG UID=1000
ARG GID=1000
ENV USERNAME=www-data
ENV APP_HOME /var/www/html

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=Europe/Amsterdam

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \

    # I don't even know what this all is
    && apt-get install -y nano curl libzip-dev zip unzip git supervisor sqlite3 libcap2-bin libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libc-client-dev libkrb5-dev python2 \

    # php extensions
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-install mbstring \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install -j$(nproc) imap \
    && docker-php-source delete \

    # install composer
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \

    # install node
    && curl -sL https://deb.nodesource.com/setup_15.x | bash - \
    && apt-get install -y nodejs \

    # some sql clients
    && apt-get install -y mariadb-client \
    && apt-get install -y postgresql-client \

    # cleanup
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# apparentally we want swoole
RUN pecl channel-update https://pecl.php.net/channel.xml \
    && pecl install swoole

# set default conf
COPY vhosts.config /etc/apache2/sites-available/000-default.conf

# remove all default files inside app home
RUN rm -r $APP_HOME

# create document root, fix permissions for www-data user and change owner to www-data
RUN mkdir -p /home/$USERNAME && chown $USERNAME:$USERNAME /home/$USERNAME \
    && usermod -u $UID $USERNAME -d /home/$USERNAME \
    && groupmod -g $GID $USERNAME \
    && chown -R ${USERNAME}:${USERNAME} $APP_HOME

# enable apache mods
RUN a2enmod rewrite && a2enmod headers

COPY start-container /usr/local/bin/start-container
COPY start-prod /usr/local/bin/start-prod
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY php.ini /usr/local/etc/php/php.ini
RUN chmod +x /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-prod

ENTRYPOINT ["start-container"]
