<?php
/**
 * Lagged\AWS\Cli\Command\Help
 *
 * @category Cli
 * @package  Lagged\AWS
 * @author   Till Klampaeckel <till@lagged.biz>
 * @version  GIT: $Id$
 * @license  http:// The New BSD License
 * @link     http://lagged.biz/
 */
namespace Lagged\AWS\Cli\Command;

/**
 * @desc Import class
 */
use Lagged\AWS\Cli\Command as Command;

/**
 * Lagged\AWS\Cli\Command\Help
 *
 * @category Cli
 * @package  Lagged\AWS
 * @author   Till Klampaeckel <till@lagged.biz>
 * @version  GIT: $Id$
 * @license  http:// The New BSD License
 * @link     http://lagged.biz/
 */
class Help extends Command
{
    /**
     * __construct
     *
     * Empty, because this class just displays available options.
     *
     * Not very pretty, need to re-think this.
     *
     * @param \Lagged\AWS\Config
     *
     * @return $this
     */
    public function __construct(\Lagged\AWS\Config $config = null)
    {
    }

    /**
     * List all available options.
     *
     * @return array
     */
    public function Help()
    {
        $data = array();
        foreach (glob(__DIR__ . '/*.php') as $file) {
            $data[] = $this->getOptionName(substr(basename($file), 0, -4));
        }
        return $data;
    }
}