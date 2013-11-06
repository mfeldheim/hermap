#!/bin/sh
if [ -z "$1" ]
then
   vendor/bin/phpunit --bootstrap tests/bootstrap.php --stderr tests
else
   vendor/bin/phpunit --bootstrap tests/bootstrap.php --stderr --coverage-html target/reports tests
fi
