# Gracefully stolen from https://github.com/christopherarter/laravel-docker-production and https://github.com/laravel/sail

FROM alpine:3.13

#ARG BUILD_ARGUMENT_ENV=prod

ENV TZ=Europe/Amsterdam

# Install packages and remove default server definition
RUN apk --no-cache add \
  bash \
  curl \
  git \
  nano \
  nginx \
  npm \
  openssh \
  php8 \
  php8-ctype \
  php8-curl \
  php8-dom \
  php8-fileinfo \
  php8-fpm \
  php8-gd \
  php8-intl \
  php8-json \
  php8-mbstring \
  php8-mysqli \
  php8-opcache \
  php8-openssl \
  php8-phar \
  php8-session \
  php8-simplexml \
  php8-xml \
  php8-tokenizer \
  php8-xmlreader \
  php8-xmlwriter \
  php8-zlib \
  shadow \
  supervisor \
  sqlite \
  && rm /etc/nginx/conf.d/default.conf

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Create symlink so programs depending on `php` still function
RUN ln -s /usr/bin/php8 /usr/bin/php

# Configure nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY fpm-pool.conf /etc/php8/php-fpm.d/www.conf
COPY php.ini /etc/php8/conf.d/custom.ini

# Configure supervisord
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy start container scripts
COPY start-container /usr/local/bin/start-container
COPY start-prod /usr/local/bin/start-prod
COPY server-deploy /usr/local/bin/server-deploy
RUN chmod +x /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-prod
RUN chmod +x /usr/local/bin/server-deploy

# Setup document root
RUN mkdir -p /var/www/html

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
# Create document root, fix permissions for nobody user and change owner to nobody
RUN mkdir -p /home/nobody && \
    chown nobody:nobody /home/nobody &&\
    usermod -u 1000 nobody -d /home/nobody &&\
    groupmod -g 1000 nobody && \
    chown -R nobody:nobody /var/www/html && \
    chown -R nobody:nobody /run && \
    chown -R nobody:nobody /var/lib/nginx && \
    chown -R nobody:nobody /var/log/nginx

# Switch to use a non-root user from here on
USER nobody

# Add ssh key folder
RUN mkdir -p  ~/.ssh && \
    chmod 700  ~/.ssh

 # Create ssh key and fix permissions
RUN ssh-keygen -q -t rsa -N '' -f ~/.ssh/id_rsa \
    && chmod 600 ~/.ssh/id_rsa && \
    && chmod 600 ~/.ssh/id_rsa.pub \
    && echo "PUBLIC KEY:" \
    && cat ~/.ssh/id_rsa.pub

# Add application
WORKDIR /var/www/html
COPY --chown=nobody . /var/www/html

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
ENTRYPOINT ["start-container"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
