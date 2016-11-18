#!/usr/bin/env bash

set -ex;

if [ ! $WP_PATH ]; then
  WP_PATH=/tmp/wp-tests
fi

if [ ! $WP_PORT ]; then
  WP_PORT=8080
fi

./wp-cli-nightly.phar server \
--host=0.0.0.0 \
--port=$WP_PORT \
--docroot=$WP_PATH \
--path=$WP_PATH \
--config=bin/php.ini
