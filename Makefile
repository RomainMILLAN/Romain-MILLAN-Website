.DEFAULT_GLOBAL = help
SHELL:=/bin/bash
OS := $(shell uname -s)

DOCKER=docker
DC=$(DOCKER) compose --env-file .env --env-file .env.docker
DCE=$(DC) exec
PHP=$(DCE) php php
CONSOLE=$(PHP) bin/console
COMPOSER=$(DCE) php composer
NPM=$(DCE) node yarn
ENV ?= dev

##
## —— Utils ⚙️ ————————————————————————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

.PHONY: start
start: build up vendor assets  ## Start project

.PHONY: stop
stop: ## Stop project
	@$(DC) down --remove-orphans
	@rm -rf vendor
	@rm -rf node_modules

.PHONY: up
up: build
	@$(DC) up --pull always -d

.PHONY: build
build:
	@$(DC) build --pull --no-cache

QUEUE_NAME ?= async
VERBOSITY ?= -v
.PHONY: consume
consume: ## Run an async messenger consumer
	@$(CONSOLE) messenger:consume $(QUEUE_NAME) $(VERBOSITY)

##
## —— Dependencies 📁 ————————————————————————————————————————————————————————————————
.PHONY: submodules
submodules:		## Initialise and update submodule
	@git submodule update --init --recursive

.PHONY: composer
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

.PHONY: vendor
vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-progress
vendor: composer

.PHONY: vendor-build
vendor-build:
	@$(DC) php composer install --no-dev --optimize-autoloader

.PHONY: npm
assets-install:
	$(NPM) install

.PHONY: sulu.install
sulu.install: ## Install Sulu CMS (ENV=dev|prod)
	@$(PHP) bin/adminconsole sulu:build $(ENV)

##
## —— Cache 🗃️ ————————————————
.PHONY: cc
cc:			## Clear cache
	$(CONSOLE) ca:cl -e $(or $(ENV), 'dev')

##
## —— Assets ✨ ————————————————
.PHONY: assets
assets:	assets-install  ## Build assets - dev version
	$(NPM) run encore dev

.PHONY: assets-build
assets-build: npm  ## Build assets - prod version
	$(NPM) run build

.PHONY: watch
watch:		## Watch assets
	$(NPM) run encore dev --watch

##
## —— Database 🗃️————————————————
POSTGRES_USER ?= app
POSTGRES_DB ?= app
POSTGRES_PORT ?= 9922
POSTGRES_PASSWORD ?=
DUMP ?= backup_$(shell date +%Y%m%d_%H%M%S).sql

.PHONY: db-diff
db-diff: ## Generate a new migration
	@$(CONSOLE) doctrine:migration:diff

.PHONY: db-migrate
db-migrate: ## Execute all not migrate migrations
	@$(CONSOLE) doctrine:migration:migrate --no-interaction

db-fixtures: ## Load fixtures
	@$(CONSOLE) doctrine:fixtures:load -n --append

.PHONY: db-reset
db-reset: ## Reset database and execute migrations
	@echo "💥 Drop the database."
	@$(CONSOLE) doctrine:database:drop --force
	@echo "🏗️ Create new database."
	@$(CONSOLE) doctrine:database:create
	@echo "🚚 Run all migrations."
	@make db-migrate

.PHONY: db-dump
db-dump: ## Dump database to a SQL file (DUMP=filename.sql, ENV=dev|prod)
ifeq ($(ENV),prod)
	@echo '🗃️ Dumping production database.'
	@PGPASSWORD=$(POSTGRES_PASSWORD) pg_dump -h 127.0.0.1 -p $(POSTGRES_PORT) -U $(POSTGRES_USER) -d $(POSTGRES_DB) --no-owner --no-acl > ./db-backup/$(DUMP)
else
	@echo '🗃️ Dumping development database.'
	@$(DCE) database pg_dump -U $${POSTGRES_USER:-app} -d $${POSTGRES_DB:-app} --no-owner --no-acl > ./db-backup/$(DUMP)
endif
	@echo '✅ Database dumped to db-backup/$(DUMP)'

.PHONY: db-import
db-import: ## Import SQL dump into database (DUMP=filename.sql, ENV=dev|prod)
	@:$(call check_defined, DUMP, sql file)
ifeq ($(ENV),prod)
	@echo '🗃️ Importing into production database.'
	@PGPASSWORD=$(POSTGRES_PASSWORD) psql -h 127.0.0.1 -p $(POSTGRES_PORT) -U $(POSTGRES_USER) -d $(POSTGRES_DB) < ./db-backup/$(DUMP)
else
	@echo '🗃️ Importing into development database.'
	@$(DC) exec -T database psql -U $${POSTGRES_USER:-app} -d $${POSTGRES_DB:-app} < ./db-backup/$(DUMP)
endif
	@echo '✅ Dump ($(DUMP)) has been imported.'

##
## —— Tests 📊 & Code Quality ✅————————————————
.PHONY: test
tests: quality phpunit infection ## Runs quality code & tests

.PHONY: phpunit
phpunit: ## Runs unit tests
ifdef FILTER
	@APP_ENV=test $(PHP) vendor/bin/phpunit --filter $(FILTER)
else ifdef COVERAGE
	@APP_ENV=test XDEBUG_MODE=coverage $(PHP) vendor/bin/phpunit --coverage-html var/phpunit-coverage
else
	@APP_ENV=test $(PHP) vendor/bin/phpunit
endif

.PHONY: infection
infection:
	@APP_ENV=test XDEBUG_MODE=coverage $(PHP) vendor/bin/infection --min-msi=100 --min-covered-msi=100 --threads=8

.PHONY: quality
quality: ecs ## Run quality code tools

.PHONY: ecs
ecs:		## Coding standards
	@$(PHP) vendor/bin/ecs check --fix

##
## —— Configuration 📋 ————————————————
.PHONY: config
config: compose.override.yaml docker.config ## Copy configuration files

.PHONY: docker.config
docker.config: .env.docker.dist
	@echo "📝 Copying .env.docker.dist to .env.docker (only if missing)"
	@if [ ! -f .env.docker ]; then \
		cp .env.docker.dist .env.docker; \
	else \
		echo ".env.docker already exists, skipping"; \
	fi

	@USER_ID=$$(id -u); \
	GROUP_ID=$$(id -g); \
	SED_INPLACE_FLAG=$$( [ "$$(uname)" = "Darwin" ] && echo "-i ''" || echo "-i" ); \
	echo "🔧 Updating APP_USER_ID=$$USER_ID and APP_GROUP_ID=$$GROUP_ID in .env.docker"; \
	sed $$SED_INPLACE_FLAG "s/^APP_USER_ID=.*/APP_USER_ID=$$USER_ID/" .env.docker; \
	sed $$SED_INPLACE_FLAG "s/^APP_GROUP_ID=.*/APP_GROUP_ID=$$GROUP_ID/" .env.docker;

.PHONY: compose.override.yaml
compose.override.yaml: compose.override.yaml.dist
	@echo "📝 Copying compose"
	@cp compose.override.yaml.dist compose.override.yaml

COMPOSER_FILE=./composer.json
PACKAGE_FILE=./package.json
ENV_FILE=./.env

deploy: vendor-build assets-build
	@echo "🚀 Deploying project"
	@echo "📝 Dumping environment variables"
	@composer dump-env $(ENV)
	@echo "🚚 Running migrations"
	@php bin/console doctrine:migrations:migrate --no-interaction
	@echo "🌐 Clearing cache"
	@php bin/console cache:clear
	@echo "🌐 Warmup cache"
	@php bin/console cache:warmup

bump:
	@if [ -z "$(VERSION)" ]; then \
		echo "Erreur : Vous devez fournir une nouvelle version avec VERSION=x.x.x"; \
		exit 1; \
	fi
	@echo "Mise à jour de la version dans composer.json, package.json et .env vers $(VERSION)"
	@sed -i '' 's/"version": *"[0-9]*\.[0-9]*\.[0-9]*"/"version": "$(VERSION)"/' $(COMPOSER_FILE)
	@sed -i '' 's/"version": *"[0-9]*\.[0-9]*\.[0-9]*"/"version": "$(VERSION)"/' $(PACKAGE_FILE)
	@sed -i '' 's/^VERSION=.*/VERSION=$(VERSION)/' $(ENV_FILE)

SERVER ?= server
DOMAIN ?= /
prod:
	@echo "🚀 Deploying in production project."
	@ssh -A $(SERVER) 'cd $(DOMAIN) && git restore package-lock.json && ./bin/deploy-prod.sh'
