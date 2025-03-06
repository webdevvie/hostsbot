#!/usr/bin/env bash
cd $(dirname $0)
rm composer.lock
composer install --no-dev --prefer-dist >/dev/null 2>&1
composer dump >/dev/null 2>&1
pakket.phar build . hostsbot.phar
cd $(dirname $0)
chmod +x hostsbot.phar
mv hostsbot.phar hostsbot
composer install >/dev/null 2>&1
cd ..
