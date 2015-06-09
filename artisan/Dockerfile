FROM ubuntu

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y php5-common php5-cli php5-mcrypt php5-mysql php5-apcu php5-gd php5-imagick php5-curl php5-intl && php5enmod mcrypt

ADD laravel.ini /etc/php5/cli/conf.d/

RUN usermod -u 1000 www-data

WORKDIR /var/www/laravel

ENTRYPOINT ["php", "artisan"]
CMD ["--help"]
