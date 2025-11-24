FROM php:8.2-apache
RUN apt-get update \
	&& docker-php-ext-install -j$(nproc) mysqli \
    && rm -rf /var/lib/apt/lists/*