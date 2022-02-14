#!/bin/sh

HEALTH_CHECK_VALUE=$(cat /proc/1/status | head | grep php-fpm)

if [ "${HEALTH_CHECK_VALUE}" = "Name:	php-fpm" ]
then
    exit 0;
fi

exit 1

