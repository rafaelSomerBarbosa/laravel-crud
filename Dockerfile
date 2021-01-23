from php:7.4-cli

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y supervisor \
    && docker-php-ext-install mysqli pdo pdo_mysql 

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord"]