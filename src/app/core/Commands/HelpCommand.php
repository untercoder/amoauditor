<?php


namespace Nosekpt\Amoauditor\App\Core\Commands;


use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Shasoft\Console\Console;
use Nosekpt\Amoauditor\App\Core\ResProviderClass;

class HelpCommand extends Command
{

    private array $commandsList;
    private ResProviderClass $resObj;

    /**
     * HelpCommand constructor.
     * @param PathProvaider $pathMap
     * @param array $commands
     */
    public function __construct(PathProvaider $pathMap, array $commands)
    {
        $this->resObj = new ResProviderClass($pathMap);
        $this->commandsList = $commands;
        parent::__construct($pathMap);
    }


    public function work()
    {
        Console::indent(0)->color('light_green')->write("Amoauditor v 0.0")->enter();
        Console::indent(0)->writeln('');
        $message = $this->resObj->getMessages(get_class($this));
        Console::indent(0)->color('yellow')->write($message['server-off'])->enter();
        Console::indent(0)->writeln('');
        Console::indent(1)->color('white')->write("Commands: ")->enter();
        foreach ($this->commandsList as $commandName => $commandDescription) {
            Console::indent(0)->color('light_green')->write($commandName.' - ')->color('white')->write($commandDescription)->enter();
        }
        Console::indent(0)->writeln('');
    }
}