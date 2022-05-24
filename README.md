# The MPSync app

The app automatically synchronizes the missing **market partners** and/or **expired SSL email certificates** from each powercloud instance with the external service provided by Conuti.

## Clone the project

Add your **public ssh key** in your account in https://gitlab.com/.

```bash
cd ~/projects
```

```bash
git clone git@gitlab.com:cu-powercloud/MPSync.git
```

#### 1. Start the project

```bash
make start
```

#### 2. Database Schema Update

```bash
make doctrine-schema-update
```

```bash
make doctrine-schema-update-test
```

#### 3. Load the Demo Data

```bash
make doctrine-fixtures-load
```

#### 4. Generate the .pem keys for the API Platform JWT

This command should only be run once when initially installing the environment.

```bash
make jwt-generate-keypair
```

You should have .pem files in the "/config/jwt/" folder

If you want to recreate the .pem keys, use:

```bash
make jwt-overwrite-keypair
```

#### 5. Run the tests

```bash
make codeception-build
```

```bash
make codeception-unit
```

```bash
make codeception-functional
```

```bash
make codeception-api
```

To check all available make commands please open **Makefile**

## Endpoints

#### The Application

http://localhost:8009/

#### The Backend / Admin

http://localhost:8009/admin

#### The API

http://localhost:8009/api

#### The API Swagger UI

http://localhost:8009/api/docs

#### phpMyAdmin

http://localhost:8010

#### Mysql

* host: localhost
* port: 4306
* user: root
* password: root
* database: app
* test database: app

