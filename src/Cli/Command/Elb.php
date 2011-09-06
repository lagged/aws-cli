<?php
namespace Lagged\AWS\Cli\Command;

use Lagged\AWS\Cli\Command as Command;

class Elb extends Command
{
    /**
     * @var \AmazonELB $elb
     */
    protected $elb;

    /**
     * __construct
     *
     * @param array $config
     *
     * @return $this
     */
    public function __construct(array $config = null)
    {
        $this->elb = new \AmazonELB(); 
    }

    /**
     * Map calls to {@link self::$elb}
     *
     * @param string $method
     * @param mixed  $args
     */
    public function __call($method, $args)
    {
        return call_user_func_array(
            array($this->elb, $method),
            $args
        );
    }
}