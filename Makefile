WEBSERVER_SERVICE := webserver
DOCKER_COMPOSE := docker-compose

start: ## Starts the application for local development
	@docker-compose up --remove-orphans -d

clean: ## Stops and removes all containers from the docker compose stack
	@docker-compose down -v

clean-dist: ## Stops and removes all containers from the docker compose stack, as well as their images
	@docker-compose down --rmi all -v

stop: ## Stop the entire docker compose stack
	@docker-compose down

build: ## build docker
	@docker-compose build
