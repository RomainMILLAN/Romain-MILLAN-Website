#
# Made by Romain Millan © 2023-2024
#
.DEFAULT_GLOBAL = help

SF=symfony
CONSOLE=$(SF) console
COMPOSER=$(SF) composer
NPM=npm
ENV ?= dev

##
## —— Utils ⚙️ ————————————————————————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

install:		## Start project
install: submodules vendors start proxy assets

restart:	## Restart project
restart: stop start

stop:		## Stop project
stop: symfony-stop
	@$(SF) proxy:stop

start: 	## Start project
start: submodules symfony-start assets
	@$(SF) proxy:start

proxy:
	@$(SF) proxy:domain:attach romainmillan

##
## —— Symfony 🧱 ————————————————————————————————————————————————————————————————
symfony-start: 	## Start symfony server
	@$(SF) server:start -d

symfony-stop: 	## Stop symfony server
	@$(SF) server:stop

##
## —— Dependencies 📁 ————————————————————————————————————————————————————————————————
submodules:		## Initialise and update submodule
	@git submodule update --init --recursive

vendors:	## Install php dependencies
	@$(COMPOSER) install

vendor-build:	## Install php dependencies
	@composer install --no-dev --optimize-autoloader

npm:		## Install front dependencies (server)
	$(NPM) install

##
## —— Cache 🗃️ ————————————————————————————————————————————————————————————————
cc:			## Clear cache
	$(CONSOLE) ca:cl -e $(or $(ENV), 'dev')

##
## —— Assets ✨ ————————————————————————————————————————————————————————————————
assets:		## Build assets - dev version
assets:	npm
	$(NPM) run dev

build:		## Build assets - prod version
build: npm
	$(NPM) run build

watch:		## Watch assets
	$(NPM) run watch
##
## —— Code Quality ✅ ————————————————————————————————————————————————————————————————
phpstan:	## Run phpstan
	@symfony php vendor/bin/phpstan analyse

ecs:		## Coding standards
	@symfony php vendor/bin/ecs check --fix

quality: ecs phpstan

##
## —— Deploiement ☁️ ————————————————————————————————————————————————————————————————
COMPOSER_FILE=./composer.json
PACKAGE_FILE=./package.json
ENV_FILE=./.env

bump:
	@if [ -z "$(VERSION)" ]; then \
		echo "Erreur : Vous devez fournir une nouvelle version avec VERSION=x.x.x"; \
		exit 1; \
	fi
	@echo "Mise à jour de la version dans composer.json, package.json et .env vers $(VERSION)"
	@sed -i '' 's/"version": *"[0-9]*\.[0-9]*\.[0-9]*"/"version": "$(VERSION)"/' $(COMPOSER_FILE)
	@sed -i '' 's/"version": *"[0-9]*\.[0-9]*\.[0-9]*"/"version": "$(VERSION)"/' $(PACKAGE_FILE)
	@sed -i '' 's/^VERSION=.*/VERSION=$(VERSION)/' $(ENV_FILE)

deploy: vendor-build
	@echo "🗃️ Dump configuration for $(ENV) environment"
	@composer dump-env $(ENV)
	@echo "🗑️ Clear cache"
	@php bin/console cache:clear
	@echo "🌱 Warmup cache"
	@php bin/console cache:warmup