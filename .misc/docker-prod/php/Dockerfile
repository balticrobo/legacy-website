FROM php:7.2

RUN apt-get update -y
RUN apt-get install -y git zip
RUN rm -r /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1

COPY start.sh /opt/docker/
CMD ["/opt/docker/start.sh"]
