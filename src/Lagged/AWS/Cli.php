<?php
/**
 * Lagged\AWS\Cli
 *
 * @category Cli
 * @package  Lagged\AWS
 * @author   Till Klampaeckel <till@lagged.biz>
 * @version  GIT: $Id$
 * @license  http:// The New BSD License
 * @link     http://lagged.biz/
 */

namespace Lagged\AWS;

/**
 * Lagged\AWS\Cli
 *
 * @category Cli
 * @package  Lagged\AWS
 * @author   Till Klampaeckel <till@lagged.biz>
 * @version  Release: @package_version@
 * @license  http:// The New BSD License
 * @link     http://lagged.biz/
 */
class Cli
{
    /**
     * @var array $argv
     */
    protected $argv;

    /**
     * @var string $command
     * @see self::parseArgv()
     * @see self::getCommand()
     */
    protected $command;

    /**
     * @var string $task
     * @see self::parseArgv()
     * @see self::getTask()
     */
    protected $task;

    /**
     * @var array $values
     * @see self::parseArgv()
     * @see self::getValues()
     */
    protected $values;

    /**
     * __construct
     *
     * @param array $argv
     *
     * @return $this
     */
    public function __construct(array $argv)
    {
        $this->argv = $argv;
    }

    /**
     * Return the command class (string).
     *
     * @return string
     * @uses   self::parseArgv()
     */
    public function getCommand()
    {
        $this->parseArgv();
        return $this->command;
    }

    /**
     * Task to execute!
     *
     * @return string
     */
    public function getTask()
    {
        $this->parseArgv();
        return $this->task;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        $this->parseArgv();
        return $this->values;
    }

    /**
     * Extract the command.
     *
     * @param string $str
     *
     * @return string
     */
    protected function extractCommand($str)
    {
        if (!strstr($str, '=')) {
            return $str;
        }
        list($command, $value) = explode('=', $str);
        return $command;
    }

    /**
     * Extract the task from --task=foo
     *
     * @param string $str
     *
     * @return string
     * @uses   self::extractCommand()
     */
    protected function extractTask($str)
    {
        return $this->extractCommand($str);
    }

    /**
     * Extract value from --foo=bar
     *
     * @param string $str
     *
     * @return array
     */
    protected function extractValue($str)
    {
        $value = array();
        if (strstr($str, '=') !== false) {
            list($task, $value_str) = explode('=', $str);
            if (!empty($value_str)) {
                $value = explode(',', $value_str);
            }
        }
        return $value;
    }

    /**
     * Convert an argument to the script into a 'PHP name'.
     *
     * @param string $arg
     *
     * @return string
     */
    protected function getPhpName($arg)
    {
        $phpName = ucfirst(strtolower(str_replace('--', '', $arg)));
        return $phpName;
    }

    /**
     * Parse the arguments to script. This doesn't validate user input.
     *
     * @return void
     * @uses   self::$argv
     * @uses   self::$command
     */
    protected function parseArgv()
    {
        /**
         * @desc When executed with 'php scripts/aws-cli' - remove script
         */
        if (strstr($this->argv[0], 'aws-cli')) {
            array_shift($this->argv);
        }

        $command = @$this->argv[0];
        $value1  = $this->extractValue($command);
        $command = $this->extractCommand($command);

        if (empty($command)) {
            throw new \InvalidArgumentException("Need to provide a command.", 1);
        }
        $className  = __NAMESPACE__ . '\Cli\Command\\';
        $className .= $this->getPhpName($command);

        $this->command = $className;

        $value2 = array();

        if (isset($this->argv[1])) {
            $task       = $this->extractTask($this->argv[1]);
            $value2     = $this->extractValue($this->argv[1]);
            $this->task = $this->getPhpName($task);
        } else {
            // usage
        }
        $this->values = array_merge($value1, $value2);
    }
}