FROM hermsi/alpine-fpm-php

RUN docker-php-ext-install pcntl bcmath xml zip intl

# get compser
RUN	apk update && \
	apk upgrade && \
	apk add --update curl openssl && \
	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  && \
	chmod +x /usr/local/bin/composer && \
	apk del curl openssl && \
rm -rf /var/cache/apk/*


#add mysql-client && gitfor running tests
RUN	apk add --update mysql-client git

