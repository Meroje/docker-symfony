FROM ubuntu

# Set the env variable DEBIAN_FRONTEND to noninteractive
ENV DEBIAN_FRONTEND noninteractive

# Fix locales
RUN locale-gen en_US.UTF-8 && dpkg-reconfigure locales

# Enable universe & src repo's
RUN echo "deb http://archive.ubuntu.com/ubuntu trusty main restricted universe\ndeb-src http://archive.ubuntu.com/ubuntu trusty main restricted universe\ndeb http://archive.ubuntu.com/ubuntu trusty-updates main restricted universe\ndeb-src http://archive.ubuntu.com/ubuntu trusty-updates main restricted universe\n" > /etc/apt/sources.list

# Install build tools for nginx
RUN apt-get update && \
    apt-get install build-essential wget -y && \
    apt-get build-dep nginx-full -y && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

ENV NGINX_VERSION 1.9.1

# Nginx
RUN cd /usr/src/ && wget http://nginx.org/download/nginx-${NGINX_VERSION}.tar.gz && tar xf nginx-${NGINX_VERSION}.tar.gz && rm -f nginx-${NGINX_VERSION}.tar.gz
# Extra modules
ADD nginx-push-stream-module /usr/src/nginx-push-stream-module
# Compiling nginx
RUN cd /usr/src/nginx-${NGINX_VERSION} && ./configure \
    --prefix=/etc/nginx \
    --conf-path=/etc/nginx/nginx.conf \
    --error-log-path=/var/log/nginx/error.log \
    --sbin-path=/usr/sbin \
    --http-client-body-temp-path=/var/lib/nginx/body \
    --http-fastcgi-temp-path=/var/lib/nginx/fastcgi \
    --http-log-path=/var/log/nginx/access.log \
    --http-proxy-temp-path=/var/lib/nginx/proxy \
    --http-scgi-temp-path=/var/lib/nginx/scgi \
    --http-uwsgi-temp-path=/var/lib/nginx/uwsgi \
    --lock-path=/var/lock/nginx.lock \
    --pid-path=/var/run/nginx.pid \
    --with-http_addition_module \
    --with-http_dav_module \
    --with-http_geoip_module \
    --with-http_gzip_static_module \
    --with-http_image_filter_module \
    --with-http_realip_module \
    --with-http_stub_status_module \
    --with-http_ssl_module \
    --with-http_sub_module \
    --with-http_xslt_module \
    --with-ipv6 \
    --with-debug \
    --with-sha1=/usr/include/openssl \
    --with-md5=/usr/include/openssl \
    --add-module=/usr/src/nginx-push-stream-module

RUN cd /usr/src/nginx-${NGINX_VERSION} && make && make install
# Create the /var/lib/nginx directory (for temp paths)
RUN mkdir -p /var/lib/nginx

ADD nginx.conf /etc/nginx/
ADD laravel.conf /etc/nginx/sites-available/

RUN mkdir -p /etc/nginx/sites-enabled && ln -s /etc/nginx/sites-available/laravel.conf /etc/nginx/sites-enabled/laravel

RUN mkdir -p /etc/nginx/conf.d && echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

VOLUME ["/var/cache/nginx"]

EXPOSE 80 443

CMD ["nginx", "-g", "daemon off;"]