<?php
namespace Lagged\AWS;

/**
 * Lagged\AWS\Autoload
 *
 * @category Autoload
 * @package  Lagged\AWS
 * @author   Till Klampaeckel <till@lagged.biz>
 * @version  Release: @package_version@
 * @license  http:// The New BSD License
 * @link     http://lagged.biz/
 */
class Autoload
{
    /**
     * load
     *
     * Used to autoload libraries.
     *
     * @param string $className Name of the class to load.
     *
     * @return boolean
     */
    public static function load($className)
    {
        $fileName = str_replace('\\', '/', $className);
        if (strpos($fileName, 'Lagged/AWS') !== 0) {
            return false;
        }
        $fileName = substr($fileName, 10);
        return include __DIR__ . $fileName . '.php';
    }
}