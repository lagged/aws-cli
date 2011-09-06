<?php
namespace Lagged\AWS;

/**
 * This is a very light-weight version of Zend_Config_Ini for our own purposes.
 *
 * @category Config
 * @package  Lagged\AWS
 * @author   Till Klampaeckel <till@lagged.biz>
 * @version  Release: @package_version@
 * @license  http:// The New BSD License
 * @link     http://lagged.biz/
 */
class Config
{
    /**
     * @var mixed $config null or stdClass
     */
    protected $config;

    /**
     * @var string $file
     */
    protected $file;

    /**
     * __construct
     *
     * @param string $file Complete path to the config file.
     *
     * @return $this
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Return a value from {@link self::$config}
     *
     * @param string $var
     *
     * @return mixed
     */
    public function __get($var)
    {
        if ($this->config === null) {
            $this->processIni();
        }
        if (!isset($this->config->$var)) {
            throw new \RangeException("Unknown key '{$var}'.");
        }
        return $this->config->$var;
    }

    /**
     * Parse the .ini file.
     *
     * @return void
     * @uses   self::$file
     * @uses   self::$config
     */
    protected function processIni()
    {
        $config = parse_ini_file($this->file);

        $this->config = new \stdClass;

        foreach ($config as $key => $value) {
            if (strstr($key, '.') === false) {
                $this->config->$key = $value;
                continue;
            }
            $parts = explode('.', $key);

            if (!isset($this->config->$parts[0])) {
                $this->config->$parts[0] = new \stdClass;
            }
            $this->config->$parts[0]->$parts[1] = $value;
        }
    }
}