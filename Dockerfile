FROM vetaweb-app:latest

RUN apt-get update && apt-get install -y libicu-dev \
    && docker-php-ext-install intl \
    && rm -rf /var/lib/apt/lists/*

COPY ./app-entrypoint.sh /usr/local/bin/travel-app-entrypoint
RUN chmod +x /usr/local/bin/travel-app-entrypoint

WORKDIR /var/www

ENTRYPOINT ["travel-app-entrypoint"]
CMD ["php-fpm"]
