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

## First run

#### 1. Start the project

```bash
make start
```

With this command you will
* start the docker environment
* install all dependencies with composer

#### 2. Prepare the DEV environment

```bash
make update
```

With this command you will
* run all migrations for DEV and TEST database
* fix autoload
* clean cache

#### 3. Load the Demo Data

```bash
make doctrine-fixtures-load
```

With this command you add the **predefined demo data** for the DEV environment.

The TEST environment uses fake objects for each test, which are removed after each test.

#### 4. Generate the .pem keys for the API Platform JWT

This command should **only be run once** when initially installing the environment.

```bash
make jwt-generate-keypair
```

You should have .pem files in the "/config/jwt/" folder

If you want to recreate the .pem keys, use:

```bash
make jwt-overwrite-keypair
```

## Every next run

#### 1. Load the Demo Data

If your development environment is not running, you can start it again with:

```bash
make start
```

With this command you will
* run all migrations for DEV and TEST database
* fix autoload
* clean cache

#### 2. Update the DEV and TEST environment

After changes in the code, especially the database, you need to create the new migration file with:

```bash
make migration
```

If there are any changes, you will have a newly generated file in the /migrations/ folder.

After that you can update the DEV and TEST environment with:

```bash
make update
```

With this command you will
* run all migrations for DEV and TEST database
* fix autoload
* clean cache

## Run the tests

#### Build the test environment

```bash
make codeception-build
```

#### Run all tests in one command

```bash
make codeception-all
```

#### Run unit tests only

```bash
make codeception-unit
```

#### Run functional tests only

```bash
make codeception-functional
```

#### Run api tests only

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
* test database: app_test

