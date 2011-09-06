<?php
namespace Lagged\AWS;

class Config
{
    protected $config;
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Return a value from {@link $config}
     */
    public function __get($var)
    {
        if ($this->config === null) {
            $this->processIni();
        }
        if (!isset($this->config->$var)) {
            throw new RangeException("Unknown key '{$var}'.");
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
