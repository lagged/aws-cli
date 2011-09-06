#!/usr/bin/env php
<?php
use Lagged\AWS\Cli as Cli;

try {
    require_once dirname(__DIR__) . '/src/Autoload.php';
    spl_autoload_register(array('Lagged\AWS\Autoload', 'load'));

    $cli     = new Cli($_SERVER['argv']);
    $command = $cli->getCommand();
    $cmdObj  = new $command($conf);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    exit($e->getCode());
}