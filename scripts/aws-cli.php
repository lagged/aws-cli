#!/usr/bin/env php
<?php
use Lagged\AWS\Cli as Cli;
use Lagged\AWS\Config as Config;

$env = 'pear';

if (strpos('@package_release@', '@package') === 0) {
    $env = 'source';
}

$path   = '';
$vendor = '';
$src    = '';

if ($env == 'source') {
    $path   = dirname(__DIR__);
    $vendor = $path . '/vendor';
    $src    = $path . '/src';
    $etc    = $path . '/etc/config.ini';
}

// FIXME: absolute path?
require_once $vendor . '/aws-sdk-for-php/sdk.class.php';

try {
    require_once $src . '/Autoload.php';
    spl_autoload_register(array('Lagged\AWS\Autoload', 'load'));

    $config = new Config($etc);

    $cli     = new Cli($_SERVER['argv']);
    $command = $cli->getCommand();
    $cmdObj  = new $command($config);

    $task   = $cli->getTask();
    $values = $cli->getValues();
    
    $data = $cmdObj->execute($task, $values); //var_dump($data);

    echo "You executed: {$task}" . PHP_EOL . PHP_EOL;

    if (!is_array($data)) {
        echo "Error: No data..." . PHP_EOL;
        exit(2);
    }

    foreach ($data as $key => $value) {
        if (!is_array($value)) {
            if (!is_numeric($key)) {
                echo ' * ' . $key . ': ';
            }
            echo $value . PHP_EOL;
            continue;
        }
        echo ' * ' . key($value) . ': ' . current($value);
    }
    echo PHP_EOL;
    exit(0);

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    exit($e->getCode());
}