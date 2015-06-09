docker-laravel
==============

Just a litle Docker POC in order to have a complete stack for running Laravel into Docker containers using docker-compose tool.

# Installation

First, clone this repository:

```bash
$ git clone --recursive git@github.com:meroje/laravel-realtime.git
```

Then, run:

```bash
$ docker-compose up
```

You are done, you can visite your Laravel application on the following URL: `http://localhost` (and access Kibana on `http://localhost:81`)

Optionally, you can build your Docker images separately by running:

```bash
$ docker build -t laravel/code code
$ docker build -t laravel/php-fpm php-fpm
$ docker build -t laravel/nginx nginx
```

# How it works?

Here are the `docker-compose` built images:

* `application`: This is the Laravel application code container,
* `db`: This is the MySQL database container (can be changed to postgresql or whatever in `docker-compose.yml` file),
* `php`: This is the PHP-FPM container in which the application volume is mounted,
* `nginx`: This is the Nginx webserver container in which application volume is mounted too,
* `elk`: This is a ELK stack container which uses Logstash to collect logs, send them into Elasticsearch and visualize them with Kibana.

This results in the following running containers:

```bash
> $ docker-compose ps
        Name                      Command               State              Ports
        -------------------------------------------------------------------------------------------
        docker_application_1   /bin/bash                        Up
        docker_db_1            /entrypoint.sh mysqld            Up      0.0.0.0:3306->3306/tcp
        docker_elk_1           /usr/bin/supervisord -n -c ...   Up      0.0.0.0:81->80/tcp
        docker_nginx_1         nginx                            Up      443/tcp, 0.0.0.0:80->80/tcp
        docker_php_1           php5-fpm -F                      Up      9000/tcp
```

# Read logs

You can access Nginx and Laravel application logs in the following directories into your host machine:

* `logs/nginx`
* `logs/laravel`

# Use Kibana!

You can also use Kibana to visualize Nginx & Laravel logs by visiting `http://localhost:81`.
