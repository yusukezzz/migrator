<?php namespace Migrations\Console;

use Psr\Log\InvalidArgumentException;

class AutoloadCommand extends \Illuminate\Console\Command
{
    /**
     * @var string
     */
    protected $name = 'dump-autoload';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        system("composer dump-autoload");
    }
}
