

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
