cs:
	./vendor/bin/php-cs-fixer fix --verbose --allow-risky yes

cs_dry_run:
	./vendor/bin/php-cs-fixer fix --verbose --allow-risky yes --dry-run

test:
	./vendor/bin/phpunit --coverage-text
