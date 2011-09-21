<?php
require_once 'PHPUnit/Autoload.php';

require_once dirname(__DIR__) . '/src/Lagged/AWS/Autoload.php';
spl_autoload_register(array('Lagged\AWS\Autoload', 'load'));
