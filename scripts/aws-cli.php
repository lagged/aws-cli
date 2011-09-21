#!/usr/bin/env php
<?php
/**
 * aws-cli.php
 *
 * Run this script for all tasks, etc..
 *
 * @category Cli
 * @package  Lagged\AWS
 * @author   Till Klampaeckel <till@lagged.biz>
 * @version  GIT: $Id$
 * @license  http:// The New BSD License
 * @link     http://lagged.biz/
 */

/**
 * @desc Import classes.
 */
use Lagged\AWS\Cli as Cli;
use Lagged\AWS\Config as Config;

/**
 * @desc Define the environment.
 */
$env = 'pear';

if ('@package_release@' == '@' . 'package_release' . '@') {
    $env = 'source';
}

$path   = '';
$vendor = '';
$src    = '';

if ($env == 'source') {
    $path   = dirname(__DIR__);
    $vendor = $path . '/vendor/aws-sdk-for-php';
    $src    = $path . '/src/';
    $etc    = $path . '/etc/aws-cli.ini';
} else {
    $vendor = 'AWSSDKforPHP'; // include_path
    $src    = '';
    $etc    = '/etc/aws-cli.ini';
}

// FIXME: absolute path?
require_once $vendor . '/sdk.class.php';

try {
    require_once $src . 'Lagged/AWS/Autoload.php';
    spl_autoload_register(array('Lagged\AWS\Autoload', 'load'));

    $config = new Config($etc);

    $cli     = new Cli($_SERVER['argv']);
    $command = $cli->getCommand();
    $cmdObj  = new $command($config);

    $task   = $cli->getTask();
    $values = $cli->getValues();

    $data = $cmdObj->execute($task, $values); //var_dump($data);

    $text = new Cli\Text($task);
    echo $text->setResponse($data)->output();
    exit($text->getExitCode());

} catch (Exception $e) {
    //var_dump($e);
    echo $e->getMessage() . PHP_EOL;
    exit($e->getCode());
}
