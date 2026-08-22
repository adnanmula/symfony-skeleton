UID=$(shell id -u)
GID=$(shell id -g)
FILE=docker-compose.yml

# Docker
build: ## docker-compose build
	UID=${UID} GID={GID} docker compose -f ${FILE} build

up: ## up all containers
	UID=${UID} GID=${GID} docker compose -f ${FILE} up -d

stop: ## stop all containers
	UID=${UID} GID=${GID} docker compose -f ${FILE} stop

down: ## down all containers
	UID=${UID} GID=${GID} docker compose -f ${FILE} down

bash: ## gets inside a php container
	UID=${UID} GID={GID} docker compose -f ${FILE} exec --user=${UID} php-fpm sh

ps: ## status from all containers
	docker compose -f ${FILE} ps

# Dependencies
install: ## install dependencies
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "composer install"

update: ## update dependencies
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "composer update"

# Environment
clear: ## clear cache
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "console cache:clear"

init: ## initialize environment
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "console environment:init"

.PHONY: migrations
migrations: ## run phinx migrations
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "console environment:migrations"

createdb: ## create db
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "console skeleton:env:database"

.PHONY: fixtures
fixtures: ## load fixtures
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "console environment:fixtures"

# Tools
.PHONY: tests
tests: ## execute project unit tests
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "phpunit"

stan: ## check phpstan
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "php -d memory_limit=256M bin/phpstan analyse -c phpstan.neon"

cs: ## check code style
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "phpcs --standard=phpcs.xml.dist"

grump: ## run grumphp
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "grumphp run"

mutation: ## run mutation tests
	docker compose -f ${FILE} exec --user=${UID} php-fpm sh -c "infection --threads=4"