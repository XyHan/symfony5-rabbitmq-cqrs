FROM php:8.0-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN usermod -u 1000 www-data
RUN mkdir -p /home/www-data
RUN pecl install channel://pecl.php.net/xdebug-3.0.4

EXPOSE 80

RUN apt-get update -qq && \
    apt-get install -qy \
    supervisor \
    git \
    gnupg \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    librabbitmq-dev \
    libssh-dev \
    unzip \
    zip && \

    docker-php-ext-configure zip && \
    docker-php-ext-install bcmath sockets -j$(nproc) intl opcache pdo_mysql zip && \

    # Extract PHP source
    docker-php-source extract &&\
    # Create directory for amqp extension
    mkdir /usr/src/php/ext/amqp &&\
    # Download AMQP master branch files to extension directory
    curl -L https://github.com/php-amqp/php-amqp/archive/master.tar.gz | tar -xzC /usr/src/php/ext/amqp --strip-components=1 &&\
    # Install amqp extension using built-in docker binary
    docker-php-ext-install amqp &&\
    # Delete PHP source
    docker-php-source delete &&\

    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \

COPY conf/php.ini /usr/local/etc/php/conf.d/php.ini
COPY conf/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY conf/supervisord.conf /etc/supervisor/supervisord.conf
CMD ["/usr/bin/supervisord", "-n"]

#entry point
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set up the command arguments.
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
