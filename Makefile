default: help

help:
	@echo "Targets:"
	@echo " - test"
	@echo " - lint"
	@echo " - phploc"
	@echo " - phpcs"

test: lint phploc phpcs phpunit

lint:
	find -name "*.php" -not -path "./vendor/*" | php -l

phploc:
	php vendor/bin/phploc --progress src/ tests/

phpcs:
	php vendor/bin/phpcs --standard=PSR2 --ignore=vendor/ --extensions=php . -n -p
