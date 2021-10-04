#!/bin/bash

touch /var/log/xdebug.log && chown www-data:www-data /var/log/xdebug.log

#composer permissions (cache)
chown www-data:www-data -R /usr/local/bin/composer
chown www-data:www-data -R /home/www-data/.composer

exec "$@"
