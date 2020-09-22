#FROM jwilder/nginx-proxy:0.7.0
FROM nginx:latest
RUN rm /etc/nginx/conf.d/*
COPY nginx.conf /etc/nginx/nginx.conf
RUN apk update && apk add bash
#COPY /etc/nginx/conf.d/test.config /etc/nginx/conf.d/
#left its continer path ===> right its machin path
