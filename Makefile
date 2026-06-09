

.PHONY: ci
ci: cs-check phpstan test

.PHONY: cs-check
cs-check:
	php ./vendor/bin/php-cs-fixer check

.PHONY: cs-fix
cs-fix:
	php ./vendor/bin/php-cs-fixer fix

.PHONY: test
test:
	php ./vendor/bin/phpunit

.PHONY: phpstan
phpstan:
	php ./vendor/bin/phpstan

.PHONY: install
install:
	docker run --rm -u "$$(id -u):$$(id -g)" -v "$$(pwd):/app" -w /app composer:2 composer install --ignore-platform-reqs
