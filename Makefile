include .env

WEBSERVER_CONTAINER := webserver
DOCKER_COMPOSE := docker-compose
HOST := http://localhost

################################################################
## Docker
################################################################

start: ## Starts the application for local development
	$(DOCKER_COMPOSE) up --remove-orphans -d
	@echo "The App is available at ${HOST}:${WEBSERVER_PORT}"
	@echo "The Api is available at ${HOST}:${WEBSERVER_PORT}/api"
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

build: ## Build docker
	$(DOCKER_COMPOSE) build

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

doctrine-schema-drop: ## Run doctrine:schema:drop - drops all the tables without the database
	$(DOCKER_COMPOSE) exec $(WEBSERVER_CONTAINER) php bin/console doctrine:schema:drop --env=dev --full-database --force

doctrine-fixtures-load: ## Run doctrine:fixtures:load
	@docker-compose exec $(WEBSERVER_SERVICE) php bin/console doctrine:fixtures:load
