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

    /**
     * Return all available methods.
     *
     * @return array
     */
    public function Help()
    {
        $r = new \ReflectionClass(__CLASS__);
        $t = $r->getMethods(\ReflectionMethod::IS_PUBLIC);

        $tasks = array();
        foreach ($t as $m) {
            $n = $m->name;
            if (substr($n, 0, 2) == '__') {
                continue;
            }
            if (ucfirst($n) !== $n) {
                continue;
            }
            $tasks[] = $this->getOptionName($n);
        }
        return $tasks;
    }

    /**
     * @param string $elb
     */
    public function Instances($elb)
    {
        $opts                      = array();
        $opts['LoadBalancerNames'] = $elb;

        $r = $this->elb->describe_load_balancers($opts);

        $this->checkResponse($r);

        $m = $r->body->DescribeLoadBalancersResult->LoadBalancerDescriptions->member->to_array();
        return $m['Instances'];
    }

    public function Listall()
    {
        $r = $this->elb->describe_load_balancers();

        $this->checkResponse($r);

        $result = $r->body->DescribeLoadBalancersResult;
        if (!isset($result->LoadBalancerDescriptions)) {
            return array();
        }
        $data = array();
        foreach ($result->LoadBalancerDescriptions as $elb) {
            $m = $elb->member->to_array(); //var_dump($m);
            $data[$m['LoadBalancerName']] = $m['CanonicalHostedZoneName'];
        }
        return $data;
    }

    /**
     * @param string $elb
     * @param string $instance
     */
    public function Register()
    {
        if (func_num_args() < 2) {
            throw new \InvalidArgumentException("Not enough parameters given.");
        }
        $elb       = func_get_arg(0);
        $instances = array();
        for ($x=1; $x<func_num_args(); ++$x) {
            $instances[] = array('InstanceId' => func_get_arg($x));
        }

        $r = $this->elb->register_instances_with_load_balancer($elb, $instances);
        $this->checkResponse($r);
        var_dump($r);
    }

    /**
     * @param string $elb
     * @param string $instance
     */
    public function Unregister()
    {
        if (func_num_args() < 2) {
            throw new \InvalidArgumentException("Not enough parameters given.");
        }
        $elb       = func_get_arg(0);
        $instances = array();
        for ($x=1; $x<func_num_args(); ++$x) {
            $instances[] = array('InstanceId' => func_get_arg($x));
        }
        $r = $this->elb->unregister_instances_with_load_balancer($elb, $instances);
        $this->checkResponse($r);
        var_dump($r);
    }
}
