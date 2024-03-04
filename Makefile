init: docker-down-clear build up
restart: down up

build:
	docker-compose build --pull

up:
	docker-compose up -d

down:
	docker-compose down

docker-down-clear:
	docker-compose down --remove-orphans --volumes

sh:
	docker-compose exec php sh

#######################################################################################
MAKEFLAGS += --no-builtin-rules

.DEFAULT_GOAL := help
.PHONY: help
help:
	@printf "\033[33mUsage:\033[0m\n  make TARGET\n\033[33m\nAvailable Commands:\n\033[0m"
	@grep -E '^[a-zA-Z-]+:.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  [32m%-27s[0m %s\n", $$1, $$2}'

PHP=$(shell which php)

JOBS=$(shell nproc)

#PHP Lint
PHPLINT=vendor/bin/phplint
PHPLINT_ARGS=-c tools/lint/phplint.yml

# PHP CS-Fixer
PHP_CS_FIXER=vendor/bin/php-cs-fixer fix
PHP_CS_FIXER_ARGS=--cache-file=var/cache/.php_cs.cache --verbose --config=tools/csfixer/.php-cs-fixer.php --allow-risky=yes

# PHPUnit
PHPUNIT=-c tools/phpunit

app-install: ## Install Api project
	$(DISABLE_XDEBUG) bin/console doctrine:schema:update --complete --force
	$(DISABLE_XDEBUG) bin/console doctrine:fixtures:load --group=Required --group=Demo -n

app-test-install: ## Install test Api project with required fixtures
	$(DISABLE_XDEBUG) bin/console doctrine:schema:update --complete --force --env=test
	$(DISABLE_XDEBUG) bin/console doctrine:fixtures:load --group=Required -n --env=test

lint: phplint symfony-lint cs-check ## Run all fast checks

phplint: ## Runs linters
	$(PHP) $(PHPLINT) $(PHPLINT_ARGS)

symfony-lint:
	bin/console lint:yaml config --parse-tags
	bin/console lint:container

cs-check: ## Runs code style check without fix
	PHP_CS_FIXER_IGNORE_ENV=1 $(PHP) $(PHP_CS_FIXER) $(PHP_CS_FIXER_ARGS)  --diff --dry-run --stop-on-violation

cs-fix: ## Runs code style check with fix
	PHP_CS_FIXER_IGNORE_ENV=1 $(PHP) $(PHP_CS_FIXER) $(PHP_CS_FIXER_ARGS) --diff
	LC_ALL=C sort -u .gitignore -o .gitignore

tests: ## Runs All tests
	bin/phpunit $(PHPUNIT)

requirements: lint tests
