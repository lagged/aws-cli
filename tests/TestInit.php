<?php
require_once 'PHPUnit/Autoload.php';

require_once dirname(__DIR__) . '/src/Autoload.php';
spl_autoload_register(array('Lagged\AWS\Autoload', 'load'));