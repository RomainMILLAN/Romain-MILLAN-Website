#
# Made by Romain Millan © 2023-2024
#
.DEFAULT_GLOBAL = help

D=docker
DC=$(D) compose

##
## —— Utils ⚙️ ————————————————————————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

config: ## Instqll the project
	@cp compose.override.yaml.dist compose.override.yaml

##
## —— Docker 🐳 ————————————————————————————————————————————————————————————————
docker-start: 	## Start dockers containers
	@$(DC) up -d --build

docker-stop: 	## Stop dockers containers
	@$(DC) stop

docker-down: 	## Down dockers containers
	@$(DC) down
