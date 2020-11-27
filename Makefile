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

install: ## install dependencies
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "php bin/composer.phar install"

update: ## update dependencies
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "php bin/composer.phar update"

.PHONY: tests
tests: ## execute project unit tests
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "phpunit --order=random"

stan: ## check phpstan
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "php -d memory_limit=256M bin/phpstan analyse -c phpstan.neon"

cs: ## check code style
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "phpcs --standard=phpcs.xml.dist"

ps: ## status from all containers
	docker-compose -f ${FILE} ps

grump: ## run grumphp
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "grumphp run"