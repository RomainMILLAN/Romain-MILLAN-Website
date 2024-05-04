#
# Made by Romain Millan © 2023-2024
#
.DEFAULT_GLOBAL = help

SF=symfony
CONSOLE=$(SF) console
SF_COMPOSER=$(SF) composer
NPM=npm
PHPCONSOLE=php bin/console


##
## —— Utils ⚙️ ————————————————————————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

install:		## Start project
install: vendors start asset
# install: config vendors npm start assets

restart:	## Restart project
restart: stop start

stop:		## Stop project
stop: symfony-stop
# stop: symfony-stop

start: 	## Start project
start: symfony-start asset
# start: symfony-start

##
## —— Symfony 🧱 ————————————————————————————————————————————————————————————————
symfony-start: 	## Start symfony server
	@$(SF) server:start -d

symfony-stop: 	## Stop symfony server
	@$(SF) server:stop

##
## —— Dependencies 📁 ————————————————————————————————————————————————————————————————
vendors:	## Install php dependencies
	@$(SF_COMPOSER) install

vendor-build:	## Install php dependencies
	@composer install --no-dev --optimize-autoloader

##
## —— Cache 🗃️ ————————————————————————————————————————————————————————————————
cc:			## Clear cache
	$(CONSOLE) ca:cl -e $(or $(ENV), 'dev')

##
## —— Assets ✨ ————————————————————————————————————————————————————————————————
asset:		## Build assets
	$(CONSOLE) sass:build

watch:		## Watch assets
	$(CONSOLE) sass:build --watch

compile:	## Asset Mapper Compile
compile: remove-last-assets asset
	$(CONSOLE) asset-map:compile

remove-last-assets:
	rm -rf public/assets

##
## —— Database 💿 ————————————————————————————————————————————————————————————————
db-init: 	## Init project's database
	$(CONSOLE) d:d:drop -n --force --if-exists
	$(CONSOLE) d:d:create -q

db-diff:   	## Creates doctrine migration
	$(CONSOLE) doc:mi:diff

db-migrate:	## Runs doctrine migration
	$(CONSOLE) d:m:migrate -n

db-fixtures:	## Load fixtures
	$(CONSOLE) doctrine:fixtures:load -n --append

db-reload:	## Reloads project's data
ifeq (, $(shell which symfony))
db-reload: CONSOLE=php bin/console
endif
db-reload: db-init db-migrate

##
## —— Tests 📊 ————————————————————————————————————————————————————————————————
test-init:
	@rm -rf var/error-screenshots var/browser
#	@$(CONSOLE) doctrine:schema:drop -e test --force -q
#	@$(CONSOLE) doctrine:schema:create -e test -q
#	@$(CONSOLE) doctrine:fixtures:load --no-interaction -e test -q
	@$(CONSOLE) cache:clear -e test -q

test:		## Execute tests
ifndef FILTER
test: test-init
endif
	@symfony php vendor/bin/phpunit --filter=$(or $(FILTER), '.')

infection:
	@XDEBUG_MODE=coverage symfony php vendor/bin/infection --min-msi=100 --min-covered-msi=100 --threads=8

coverage:	## Execute coverage tests
coverage: test-init
	@XDEBUG_MODE=coverage symfony php bin/phpunit --coverage-html var/coverage/html --coverage-xml var/coverage/xml/ --log-junit=var/coverage/junit.xml
	@XDEBUG_MODE=coverage vendor/bin/infection --threads=$(shell nproc) --skip-initial-tests $(ARGS) --coverage=var/coverage --skip-initial-tests

##
## —— Code Quality ✅ ————————————————————————————————————————————————————————————————
psalm:		## Run psalm
	@symfony php vendor/bin/psalm $(ARGS) --no-cache

phpstan:	## Run phpstan
	@symfony php vendor/bin/phpstan analyse

ecs:		## Coding standards
	@symfony php vendor/bin/ecs check --fix

quality: ecs phpstan

##
## —— Deploiement ☁️ ————————————————————————————————————————————————————————————————
include .env
server-preprod := "prod"
server := "prod"
domain-preprod := "/opt/stacks/preprod-romainmillanwebsite/project"
domain := "/opt/stacks/prod-romainmillanwebsite/project"

prod:	## Deploy on prod
prod:
	@echo "🚩 Deploying to preproduction server ($(server))"
	@ssh -A $(server) 'cd $(domain) && git pull origin main && make deploy'

preprod:	## Deploy on preprod
preprod:
	@echo "🚩 Deploying to preproduction server ($(server-preprod))"
	@ssh -A $(server-preprod) 'cd $(domain-preprod) && git pull origin main && make deploy'

# Règle pour déployer
deploy: vendor-build
	@echo "🗃️ Dump configuration"
	@composer dump-env $(APP_ENV)
	@echo "✨ Install and Compile assets"
	@$(MAKE) compile
	@echo "🗑️ Clear cache"
	@php bin/console cache:clear
	@echo "🌱 Warmup cache"
	@php bin/console cache:warmup
