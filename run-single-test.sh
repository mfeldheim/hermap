#!/bin/sh
vendor/bin/phpunit --bootstrap tests/bootstrap.php --stderr tests/$1
