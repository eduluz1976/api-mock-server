#!/bin/sh
export DOLLAR='$'
envsubst < /root/site-admin.conf > /etc/nginx/conf.d/site-admin.conf
envsubst < /root/site-api.conf > /etc/nginx/conf.d/site-api.conf
envsubst < /root/nginx.conf > /etc/nginx/nginx.conf

nginx -g "daemon off;"