<?php
class CommandTest extends \PHPUnit_Framework_TestCase
{
    public function testAllCommands()
    {
        $help = new Lagged\AWS\Cli\Command\Help;
        $this->assertInternalType('array', $help->Help());
    }
}
