# MPSync app

The MPSync app is used to automatically synchronize market partners between the powercloud instances.

## Clone the project

Add your **public ssh key** in your account in https://gitlab.com/.

```bash
cd ~/projects
```

```bash
git clone git@gitlab.com:cu-powercloud/MPSync.git
```

#### Start the project

```bash
make start
```

#### Run composer install

```bash
make install
```

#### Stop the entire docker compose stack

```bash
make stop
```

#### Stop and removes all containers from the docker compose stack

```bash
make clean
```

To check all available make commands please open **Makefile**

## Endpoints

#### The Application

http://localhost:8009/

#### The Backend / Admin

http://localhost:8009/admin

#### The API

http://localhost:8009/api

#### phpMyAdmin

http://localhost:8010

#### Mysql

* host: localhost
* port: 4306
* user: root
* password: root
* database: MPSync

