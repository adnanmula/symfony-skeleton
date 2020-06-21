UID=$(shell id -u)
GID=$(shell id -g)
FILE=docker-compose.yml

bash: ## gets inside a php container
	UID=${UID} GID={GID} docker-compose -f ${FILE} exec --user=${UID} php sh

build: ## docker-compose build
	UID=${UID} GID={GID} docker-compose -f ${FILE} build

up: ## up all containers
	UID=${UID} GID=${GID} docker-compose -f ${FILE} up -d

stop: ## stop all containers
	UID=${UID} GID=${GID} docker-compose -f ${FILE} stop

down: ## down all containers
	UID=${UID} GID=${GID} docker-compose -f ${FILE} down

init: ## initialize environment
	UID=${UID} GID=${GID} docker-compose -f ${FILE} run php php bin/console skeleton:env:init