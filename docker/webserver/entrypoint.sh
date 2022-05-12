#!/usr/bin/env bash

# install composer
composer install -n --no-progress --no-suggest

exec "$@"
