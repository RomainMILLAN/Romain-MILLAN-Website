#
# Made by Romain Millan © 2023-2024
#
-include .env.deploy
-include .env
-include .env.local
ifneq ("$(wildcard .env)","")
    export $(shell sed 's/=.*//' .env)
endif
.DEFAULT_GLOBAL = help

D=docker
DC=$(D) compose
DCE=$(DC) exec

##
## —— Utils ⚙️ ————————————————————————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

install: config	docker-start dependencies deploy	## Install project

deploy:	docker-start	## Deploy project into containers
	@echo "✨ Install assets"
	@make assets
	@echo "🚀 Deploy the project"
	$(DCE) php make deploy ENV=$(ENV)

dependencies: vendor assets

vendor:
	$(DCE) php make vendor-build

assets:
	$(DCE) node make build

##
## —— Docker 🐳 ————————————————————————————————————————————————————————————————
docker-start: 	## Start dockers containers
	$(DC) --env-file ./.env.local --env-file ./.env up -d --build

docker-stop: 	## Stop dockers containers
	@$(DC) stop

docker-down: 	## Down dockers containers
	@$(DC) down

##
## —— Configuration 📋 ————————————————————————————————————————————————————————————————
config: env.local app-env.local ## Configure the project
	@cp compose.override.yaml.dist compose.override.yaml

env.local:
	@echo "📝 Configuring env local config"
	@rm -f .env.local
	@touch .env.local
	@echo "###> rm/environment ###" >> .env.local
	@echo "APP_USER_ID=$(shell id -u)" >> .env.local
	@echo "APP_GROUP_ID=$(shell id -g)" >> .env.local
	@echo "###< rm/environment ###" >> .env.local

app-env.local:
	@if [ ! -f ./app/.env.local ]; then \
		@echo "📝 Configuring application env local config" \
		touch ./app/.env.local; \
		echo "###> rm/website ###" >> ./app/.env.local; \
		echo "APP_ENV=$(ENV)" >> ./app/.env.local; \
		echo "APP_DEBUG=0" >> ./app/.env.local; \
		echo "###< rm/website ###" >> ./app/.env.local; \
		echo ".env.local file created."; \
	else \
		echo ".env.local already exists, skipping."; \
	fi

##
## —— Deploiement ☁️ ————————————————————————————————————————————————————————————————
## Only for server(s) deployement

prod: ## Deploy to production server
	@echo "🚩 Deploying to server ($(SERVER))"
	@ssh -A $(SERVER) 'cd $(DOMAIN) && git pull origin main && make deploy'
