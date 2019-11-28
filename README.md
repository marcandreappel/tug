# Tug

Up and running with small Docker dev environments.

## Install

Tug is just a small set of files that sets up a local Docker-based dev environment per project. There is nothing to install globally, except Docker itself!

This is all there is to using it:

```bash
composer require marcandreappel/tug
php artisan vendor:publish --provider="MarcAndreAppel\Tug\TugServiceProvider"

# Run this once to initialize project
# Must run with "bash" until initialized
bash tug init

./tug start
```

Head to `http://localhost` in your browser and see your Laravel site!

## Lumen

If you're using Lumen, you'll need to copy the Tug files over manually instead of using `php artisan vendor:publish`. You can do this with this command:

    cp -R vendor/shipping-docker/tug/docker-files/{tug,docker-compose.yml,docker} .

and then you'll be able to install and continue as normal.


## Multiple Environments

Tug attempts to bind to port 80 and 3306 on your machine, so you can simply go to `http://localhost` in your browser.

However, if you run more than one instance of Tug, you'll get an error when starting it; Each port can only be used once. To get around this, use a different port per project by setting the `APP_PORT` and `MYSQL_PORT` environment variables in one of two ways:

Within the `.env` file:

```
APP_PORT=8080
MYSQL_PORT=33060
```

Or when starting Tug:

```bash
APP_PORT=8080 MYSQL_PORT=33060 ./tug start
```

Then you can view your project at `http://localhost:8080` and access your database locally from port `33060`;

## Sequel Pro

Since we bind the MySQL to port `3306`, SequelPro can access the database directly.

![sequel pro access](https://s3.amazonaws.com/sfh-assets/tug-sequel-pro.png)

The password for user `root` is set by environment variable `DB_PASSWORD` from within the `.env` file.

> The port setting must match the `MYSQL_PORT` environment variable, which defaults to `3306`.

## Common Commands

Here's a list of built-in helpers you can use. Any command not defined in the `tug` script will default to being passed to the `docker-compose` command. If not command is used, it will run `docker-compose ps` to list the running containers for this environment.

### Show Tug Version or Help

```bash
# shows tug current version
$ tug --version # or [ -v | version ]

# shows tug help
$ tug --help # or [ -H | help ]
```

### Starting and Stopping Tug

```bash
# Start the environment
./tug start

## This is equivalent to
./tug up -d

# Stop the environment
./tug stop

## This is equivalent to
./tug down
```

### Development

```bash
# Use composer
./tug composer <cmd>
./tug comp <cmd> # "comp" is a shortcut to "composer"

# Use artisan
./tug artisan <cmd>
./tug art <cmd> # "art" is a shortcut to "artisan"

# Run tinker REPL
./tug tinker # "tinker" is a shortcut for "artisan tinker"

# Run phpunit tests
./tug test

## Example: You can pass anything you would to phpunit to this as well
./tug test --filter=some.phpunit.filter
./tug test tests/Unit/SpecificTest.php


# Run npm
./tug npm <cmd>

## Example: install deps
./tug npm install

# Run yarn

./tug yarn <cmd>

## Example: install deps
./tug yarn install

# Run gulp
./tug gulp <cmd>
```

### Docker Commands

As mentioned, anything not recognized as a built-in command will be used as an argument for the `docker-compose` command. Here's a few handy tricks:

```bash
# Both will list currently running containers and their status
./tug
./tug ps

# Check log output of a container service
./tug logs # all container logs
./tug logs app # nginx | php logs
./tug logs mysql # mysql logs
./tug logs redis # redis logs

## Tail the logs to see output as it's generated
./tug logs -f # all logs
./tug logs -f app # nginx | php logs

## Tail Laravel Logs
./tug exec app tail -f /var/www/html/storage/logs/laravel.log

# Start a bash shell inside of a container
# This is just like SSH'ing into a server
# Note that changes to a container made this way will **NOT**
#   survive through stopping and starting the tug environment
#   To install software or change server configuration, you'll need to
#     edit the Dockerfile and run: ./tug build
./tug exec app bash

# Example: mysqldump database "homestead" to local file system
#          We must add the password in the command line this way
#          This creates files "homestead.sql" on your local file system, not
#          inside of the container
# @link https://serversforhackers.com/c/mysql-in-dev-docker
./tug exec mysql mysqldump -u root -psecret homestead > homestead.sql
```


## What's included?

The aim of this project is simplicity. It includes:

* PHP 7.3
* MySQL 5.7
* Redis ([latest](https://hub.docker.com/_/redis/))
* NodeJS ([latest](https://hub.docker.com/_/node/)), with Yarn & Gulp

## How does this work?

If you're unfamiliar with Docker, try out this [Docker in Development](https://serversforhackers.com/s/docker-in-development) course, which explains important topics in how this is put together.

If you want to see how this workflow was developed, check out [Shipping Docker](https://serversforhackers.com/shipping-docker) and signup for the free course module which explains building this Docker workflow.

## Supported Systems

Tug requires Docker, and currently only works on Windows, Mac and Linux.

> Windows requires running Hyper-V.  Using Git Bash (MINGW64) and WSL are supported.  Native
  Windows is still under development.

| Mac                                                                      |                                              Linux                                              |                                     Windows                                      |
| ------------------------------------------------------------------------ | :---------------------------------------------------------------------------------------------: | :------------------------------------------------------------------------------: |
| Install Docker on [Mac](https://docs.docker.com/docker-for-mac/install/) | Install Docker on [Debian](https://docs.docker.com/engine/installation/linux/docker-ce/debian/) | Install Docker on [Windows](https://docs.docker.com/docker-for-windows/install/) |
|                                                                          | Install Docker on [Ubuntu](https://docs.docker.com/engine/installation/linux/docker-ce/ubuntu/) |                                                                                  |
|                                                                          | Install Docker on [CentOS](https://docs.docker.com/engine/installation/linux/docker-ce/centos/) |                                                                                  |
