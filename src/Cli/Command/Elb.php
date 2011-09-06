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
     * @param \Lagged\AWS\Config $config
     *
     * @return $this
     * @uses   parent::__construct()
     * @uses   parent::$key
     * @uses   parent::$secret
     * @throws \LogicException When the configuration is not proper.
     */
    public function __construct(\Lagged\AWS\Config $config = null)
    {
        parent::__construct($config);
        $this->elb = new \AmazonELB($this->key, $this->secret); 
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
