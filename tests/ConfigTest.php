<?php
class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testThis()
    {
        $file = dirname(__DIR__) . '/etc/config.ini';
        $config = new Lagged\AWS\Config($file);

        $aws = $config->aws;

        $this->assertInstanceOf('stdClass', $aws);
        $this->assertObjectHasAttribute('key', $aws);
        $this->assertObjectHasAttribute('secret', $aws);
    }
}