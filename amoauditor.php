<?php
require_once __DIR__ . "/vendor/autoload.php";

use Nosekpt\Amoauditor\App\Core\CommandFactory;
use Nosekpt\Amoauditor\App\Core\Commands\Command;
use Nosekpt\Amoauditor\App\Core\PathProvaider;


class Starter
{
    private Command $command;
    private PathProvaider $pathMap;

    public function __construct(array $argv)
    {
        $corePath = __DIR__;
        $this->command = $this->listener($argv, new CommandFactory(new PathProvaider($corePath)));
        $this->command->work();
    }

    private function listener(array $argv, $listener)
    {
        return $listener($argv);
    }
}


$amoAuditor = new Starter($argv);


