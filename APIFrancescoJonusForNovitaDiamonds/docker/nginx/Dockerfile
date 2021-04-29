FROM nginx:alpine
RUN addgroup app && adduser -D -G app app && echo "app ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

COPY --chown=app:app . /home/app/app

EXPOSE 81
EXPOSE 443

CMD ["nginx", "-g", "daemon off;"]