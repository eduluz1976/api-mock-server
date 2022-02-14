FROM nginx:alpine

LABEL AUTHOR "Eduardo Luz <eduardo@eduardo-luz.com>"
LABEL PROJECT "API Mock Server" 
LABEL PROJECT_URL "https://github.com/eduluz1976/api-mock-server/"



WORKDIR /srv

COPY _docker/nginx/nginx.conf /root/nginx.conf.tpl

COPY _docker/nginx/scripts /root/scripts

COPY _docker/nginx/static/index.html /srv/healthcheck/health/index.html

# COPY nginx.conf /etc/nginx/nginx.conf
RUN apk update && apk add bash

RUN chmod +x /root/scripts/*



HEALTHCHECK --interval=5s --timeout=10s --start-period=5s --retries=3 CMD [ "/root/scripts/healthcheck.sh" ]

CMD [ "/root/scripts/nginx.sh" ]

EXPOSE 8080
EXPOSE 8081

