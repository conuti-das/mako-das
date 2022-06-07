include .env

WEBSERVER_CONTAINER := webserver
DOCKER_COMPOSE := docker-compose
MAKE := make
HOST := http://localhost
EGREP := egrep
################################################################
## Docker
################################################################

start: ## Starts the application for local development
	$(DOCKER_COMPOSE) up --remove-orphans -d
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) composer install
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) composer dumpautoload
	@echo "The App is available at ${HOST}:${WEBSERVER_PORT}"
	@echo "The Api is available at ${HOST}:${WEBSERVER_PORT}/api"
	@echo "The Api Swagger UI is available at ${HOST}:${WEBSERVER_PORT}/api/docs"
	@echo "The Admin is available at ${HOST}:${WEBSERVER_PORT}/admin"
	@echo "The phpMyAdmin is available at ${HOST}:${PHPMYADMIN_PORT}"
	@echo "The Database port is ${DB_PORT}"
	@echo "The Memcached port is ${MEMCACHED_PORT}"

stop: ## Stop the entire docker compose stack
	$(DOCKER_COMPOSE) stop

down: ## Shutdown all containers but leaving volumes
	$(DOCKER_COMPOSE) down

clean: ## Shutdown and removes all containers from the docker compose stack
	$(DOCKER_COMPOSE) down -v

clean-dist: ## Stops and removes all containers from the docker compose stack, as well as their images
	$(DOCKER_COMPOSE) down --rmi all -v

shell: ## Run a shell inside the webserver container
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) bash

logs: ## Call the logs from the entire stack, and follow them (like tail -f)
	$(DOCKER_COMPOSE) logs --follow

################################################################
## Composer
################################################################

install: ## Run composer install
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) composer install

dumpautoload: ## Run composer dumpautoload
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) composer dumpautoload

update-lock: ## Updates composer.lock
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) composer update --lock

################################################################
## Symfony
################################################################

cache-clear: ## Run cache:clear
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console cache:clear

cache-clear-test: ## Run cache:clear for the test environment
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console cache:clear --env=test

doctrine-cache-clear-metadata: ## Run doctrine:cache:clear-metadata
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:cache:clear-metadata

doctrine-cache-clear-query: ## Run doctrine:cache:clear-query
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:cache:clear-query

doctrine-schema-update: ## Run doctrine:schema:update
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:schema:update --env=dev --force

doctrine-schema-update-test: ## Run doctrine:schema:update --env=test
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:schema:update --env=test --force

doctrine-schema-drop: ## Run doctrine:schema:drop - drops all the tables without the database
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:schema:drop --env=dev --full-database --force

doctrine-schema-drop-test: ## Run doctrine:schema:drop - drops all the tables without the database for test
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:schema:drop --env=test --full-database --force

doctrine-schema-validate: ## Run doctrine:schema:validate
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:schema:validate --env=dev

doctrine-schema-validate-test: ## Run doctrine:schema:validate for test
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:schema:validate --env=test

doctrine-migrations-migrate: ## Run doctrine:migrations:migrate
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:migrations:migrate --env=dev

doctrine-migrations-migrate-test: ## Run doctrine:migrations:migrate for test
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:migrations:migrate --env=test

migration: ## Make migration
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console make:migration --env=dev

migration-test: ## Make migration for test
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console make:migration --env=test

doctrine-fixtures-load: ## Run doctrine:fixtures:load
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:fixtures:load --env=dev

################################################################
## Codeception
################################################################

codeception-build: ## Run codeception build by config changes
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php vendor/bin/codecept build

codeception-unit: ## Run codeception unit tests
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php vendor/bin/codecept run --steps --env=test unit

codeception-functional: ## Run codeception functional tests
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php vendor/bin/codecept run --steps --env=test functional

codeception-api: ## Run codeception api tests
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php vendor/bin/codecept run --steps --env=test api

################################################################
## API Platform
################################################################

jwt-generate-keypair: ## Run lexik:jwt:generate-keypair
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) bin/console lexik:jwt:generate-keypair

jwt-overwrite-keypair: ## Run lexik:jwt:generate-keypair with overwrite
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) bin/console lexik:jwt:generate-keypair --overwrite
