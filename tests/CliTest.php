<?php
class CliTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for {@link self::getCommandProvider()}.
     *
     * @return array
     */
    public static function getCommandProvider()
    {
        return array(
            array(array('src/aws-cli.php', '--elb'), 'Lagged\AWS\Cli\Command\Elb'),
            array(array('--elb'), 'Lagged\AWS\Cli\Command\Elb'),
        );
    }

    /**
     * @dataProvider getCommandProvider
     */
    public function testGetCommand($args, $class)
    {
        $cli  = new Lagged\AWS\Cli($args);
        $this->assertEquals($class, $cli->getCommand());
    }
}