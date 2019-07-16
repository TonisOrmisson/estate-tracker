FROM hermsi/alpine-fpm-php

RUN docker-php-ext-install mysqli pdo pdo_mysql

# get compser
RUN	apk update && \
	apk upgrade && \
	apk add --update curl openssl && \
	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  && \
	chmod +x /usr/local/bin/composer && \
	apk del curl openssl

# set key for getting private repos
RUN	apk add --update openssh
ADD id_rsa /root/.ssh/id_rsa
RUN chmod 600 /root/.ssh/id_rsa

RUN	apk add --update git

# Create known_hosts
RUN touch /root/.ssh/known_hosts
# Add bitbuckets key
RUN ssh-keyscan bitbucket.org >> /root/.ssh/known_hosts

#add mysql-client for running tests
RUN	apk add --update mysql-client