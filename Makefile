SOURCES=./src ./tests

fixPhpCs:
	php ./vendor/bin/phpcbf $(SOURCES)

fix: fixPhpCs

testPhpCs:
	php ./vendor/bin/phpcs $(SOURCES)

testPhpStan:
	php ./vendor/bin/phpstan analyze $(SOURCES)

test: testPhpCs testPhpStan
