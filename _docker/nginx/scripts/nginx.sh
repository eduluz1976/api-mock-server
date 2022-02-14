#!/bin/sh
export DOLLAR='$'
# envsubst < /root/app.conf.tpl > /etc/nginx/conf.d/default.conf
envsubst < /root/nginx.conf.tpl > /etc/nginx/nginx.conf

nginx -g "daemon off;"