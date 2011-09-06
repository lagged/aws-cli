<?php
class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Lagged\AWS\Config $config
     */
    protected $config;

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        $file         = dirname(__DIR__) . '/etc/config.ini';
        $this->config = new Lagged\AWS\Config($file);
    }

    /**
     * Basic test to see if our values end up in expected objects.
     *
     * @return void
     */
    public function testThis()
    {
        $aws = $this->config->aws;

        $this->assertInstanceOf('stdClass', $aws);
        $this->assertObjectHasAttribute('key', $aws);
        $this->assertObjectHasAttribute('secret', $aws);
    }

    /**
     * __isset
     *
     * @return void
     */
    public function testIsset()
    {
        $this->assertTrue(isset($this->config->aws));
    }

    /**
     * @expectedException \RangeException
     */
    public function testException()
    {
        $this->config->cloud;
    }
}