<?php
echo 'mapStuff phpunit tests.' . PHP_EOL;
echo 'boostrapping testsuite' . PHP_EOL;
echo '----------------------' . PHP_EOL;

@ini_set( 'display_errors', true );
@ini_set( 'display_startup_errors', true );
@set_include_path( '.' );

require './vendor/autoload.php';

$loader = new \Composer\Autoload\ClassLoader();
$loader->add('Geo', array('./src', './tests'));
$loader->register();

echo PHP_EOL . 'INCLUDE PATH:' . PHP_EOL;
echo get_include_path() . PHP_EOL . PHP_EOL;
echo '----------------------' . PHP_EOL . PHP_EOL;
