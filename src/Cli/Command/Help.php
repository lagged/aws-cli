<?php
namespace Lagged\AWS\Cli\Command;

use Lagged\AWS\Cli\Command as Command;

class Help extends Command
{
    public function __construct(\Lagged\AWS\Config $config = null)
    {
    }

    public function Help()
    {
        $data = array();
        foreach (glob(__DIR__ . '/*.php') as $file) {
            $data[] = $this->getOptionName(substr(basename($file), 0, -4));
        }
        return $data;
    }
}