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
            array(array('--help'), 'Lagged\AWS\Cli\Command\Help'),
            array(array('--elb=foo'), 'Lagged\AWS\Cli\Command\Elb'),
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

    public function testGetTask()
    {
        $args = array('--elb', '--help');
        $cli  = new Lagged\AWS\Cli($args);
        $this->assertEquals('Help', $cli->getTask());
    }

    public static function getValuesProvider()
    {
        return array(
            array(array('--elb', '--instances=ELBNAME'), array('ELBNAME')),
            array(array('--elb', '--foo=bar,foo'), array('bar','foo')),
            array(array('--elb=foo', '--register=bar'), array('foo','bar')),
            array(array('--elb=bib-elb-test', '--register=bar,foo'), array('bib-elb-test','bar','foo')),
        );
    }

    /**
     * @dataProvider getValuesProvider
     */
    public function testGetTaskValues($args, $expectedValues)
    {
        $cli  = new Lagged\AWS\Cli($args);

        $values = $cli->getValues();

        $this->assertInternalType('array', $values);
        $this->assertEquals($expectedValues, $values);
    }
}
