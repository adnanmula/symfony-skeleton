UID=$(shell id -u)
GID=$(shell id -g)
FILE=docker-compose.yml

# Docker
build: ## docker-compose build
	UID=${UID} GID={GID} docker-compose -f ${FILE} build

up: ## up all containers
	UID=${UID} GID=${GID} docker-compose -f ${FILE} up -d

stop: ## stop all containers
	UID=${UID} GID=${GID} docker-compose -f ${FILE} stop

down: ## down all containers
	UID=${UID} GID=${GID} docker-compose -f ${FILE} down

bash: ## gets inside a php container
	UID=${UID} GID={GID} docker-compose -f ${FILE} exec --user=${UID} php sh

ps: ## status from all containers
	docker-compose -f ${FILE} ps

# Dependencies
install: ## install dependencies
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "composer install"

update: ## update dependencies
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "composer update"

# Environment
init: ## initialize environment
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "console skeleton:env:init"

.PHONY: migrations
migrations: ## run grumphp
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "console skeleton:env:migrations"

createdb: ## run grumphp
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "console skeleton:env:database"

.PHONY: fixtures
fixtures: ## run grumphp
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "console skeleton:env:fixtures"

# Tools
.PHONY: tests
tests: ## execute project unit tests
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "phpunit --order=random"

stan: ## check phpstan
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "php -d memory_limit=256M bin/phpstan analyse -c phpstan.neon"

cs: ## check code style
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "phpcs --standard=phpcs.xml.dist"

grump: ## run grumphp
	docker-compose -f ${FILE} exec --user=${UID} php sh -c "grumphp run"