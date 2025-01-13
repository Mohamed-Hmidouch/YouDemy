FROM php:8.2-apache


RUN a2enmod rewrite
WORKDIR /var/www/html
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
	chmod +x /usr/local/bin/composer && \
	ln -s /usr/local/bin/composer /usr/bin/composer && \
	export PATH="$PATH:/usr/local/bin"

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
COPY ./conf.d/xdebug.ini "${PHP_INI_DIR}/conf.d"
WORKDIR /var/www