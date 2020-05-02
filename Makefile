SOURCES=./src ./tests

fixPhpCs:
	./vendor/bin/phpcbf $(SOURCES)

fix: fixPhpCs

testPhpCs:
	./vendor/bin/phpcs $(SOURCES)

testPhpStan:
	./vendor/bin/phpstan analyze $(SOURCES)

test: testPhpCs testPhpStan
