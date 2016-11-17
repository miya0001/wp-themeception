#!/usr/bin/env bash

set -ex;

DB_USER=root
DB_NAME=wp-behat-tests

WP_TITLE='Welcome to the WordPress'
WP_DESC='Hello World!'

if [ ! $WP_PATH ]; then
  WP_PATH=/tmp/wp-tests
fi

if [ -e $WP_PATH ]; then
  rm -fr $WP_PATH
fi

if [ ! $DB_PASS ]; then
  DB_PASS=""
  mysql -e "drop database IF EXISTS \`$DB_NAME\`;" -uroot
  mysql -e "create database IF NOT EXISTS \`$DB_NAME\`;" -uroot
else
  mysql -e "drop database IF EXISTS \`$DB_NAME\`;" -uroot -p"$DB_PASS"
  mysql -e "create database IF NOT EXISTS \`$DB_NAME\`;" -uroot -p"$DB_PASS"
fi

if [ ! $WP_VERSION ]; then
  WP_VERSION=latest
fi

if [ ! $WP_PORT ]; then
  WP_PORT=8080
fi

curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli-nightly.phar
chmod 755 ./wp-cli-nightly.phar

./wp-cli-nightly.phar core download --path=$WP_PATH --locale=en_US --version=$WP_VERSION --force

./wp-cli-nightly.phar core config \
--path=$WP_PATH \
--dbhost=localhost \
--dbname="$DB_NAME" \
--dbuser="$DB_USER" \
--dbpass="$DB_PASS" \
--dbprefix=wp_ \
--locale=en_US \
--extra-php <<PHP
define( 'JETPACK_DEV_DEBUG', true );
define( 'WP_DEBUG', true );
PHP

./wp-cli-nightly.phar core install \
--path=$WP_PATH \
--url=http://127.0.0.1:$WP_PORT \
--title="WordPress" \
--admin_user="admin" \
--admin_password="admin" \
--admin_email="admin@example.com"

./wp-cli-nightly.phar rewrite structure "/archives/%post_id%" --path=$WP_PATH

./wp-cli-nightly.phar option update blogname "$WP_TITLE" --path=$WP_PATH
./wp-cli-nightly.phar option update blogdescription "$WP_DESC" --path=$WP_PATH

./wp-cli-nightly.phar user create editor editor@example.com --role=editor --user_pass=editor --path=$WP_PATH

./wp-cli-nightly.phar plugin install wordpress-importer --activate --path=$WP_PATH
curl -o /tmp/themeunittestdata.wordpress.xml https://raw.githubusercontent.com/WPTRT/theme-unit-test/master/themeunittestdata.wordpress.xml
./wp-cli-nightly.phar import /tmp/themeunittestdata.wordpress.xml --authors=create --path=$WP_PATH > /dev/null 2>&1

if [ $WP_THEME ]; then
  ./wp-cli-nightly.phar theme install $WP_THEME --activate --path=$WP_PATH --force
fi

./wp-cli-nightly.phar plugin install https://github.com/miya0001/theme-review-helper/archive/master.zip --activate --path=$WP_PATH
