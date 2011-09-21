<?php
/**
 * Lagged\AWS\Cli\Text
 *
 * @category Cli
 * @package  Lagged\AWS
 * @author   Till Klampaeckel <till@lagged.biz>
 * @version  GIT: $Id$
 * @license  http:// The New BSD License
 * @link     http://lagged.biz/
 */

namespace Lagged\AWS\Cli;

/**
 * Lagged\AWS\Cli\Text
 *
 * @category Cli
 * @package  Lagged\AWS
 * @author   Till Klampaeckel <till@lagged.biz>
 * @version  Release: @package_version@
 * @license  http:// The New BSD License
 * @link     http://lagged.biz/
 */
class Text
{
    /**
     * @var string $exitCode
     */
    protected $exitCode;

    /**
     * @var mixed $data Response of the Command class.
     */
    protected $data;

    /**
     * @var string $task
     */
    protected $task;

    /**
     * __construct()
     *
     * @param string $task
     *
     * @return $this
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Return the exit code.
     *
     * @return string
     * @see    self::output()
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * Inject response from the command class.
     *
     * @return $this
     */
    public function setResponse($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Output.
     *
     * @return string
     * @uses   self::$exitCode
     */
    public function output()
    {
        $output = "You executed: {$this->task}" . PHP_EOL . PHP_EOL;

        if (is_bool($this->data)) {
            if ($this->data === true) {
                $output         .= "Success!" . PHP_EOL;
                $this->exitCode  = '0';
                return $output;
            }
            $output         .= "Unknown?!";
            $this->exitCode  = '-1';
            return $output;
        }

        if (!is_array($this->data)) {
            $output         .= "Error: No data..." . PHP_EOL;
            $this->exitCode  = '2';
            return $output;
        }

        foreach ($this->data as $key => $value) {
            if (!is_array($value)) {
                if (!is_numeric($key)) {
                    $output .= ' * ' . $key . ': ';
                }
                $output .= $value . PHP_EOL;
                continue;
            }
            $output .= ' * ' . key($value) . ': ' . current($value);
        }
        $output         .= PHP_EOL;
        $this->exitCode  = '0';
        return $output;
    }
}