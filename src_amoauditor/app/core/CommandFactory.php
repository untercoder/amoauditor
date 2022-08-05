<?php


namespace Nosekpt\Amoauditor\App\Core;

use ErrorException;
use Nosekpt\Amoauditor\App\Core\Commands\Command;
use Nosekpt\Amoauditor\App\Core\Commands\HelpCommand;
use Nosekpt\Amoauditor\App\Core\Commands\InitCommand;
use Nosekpt\Amoauditor\App\Core\Commands\StartCommand;
use Nosekpt\Amoauditor\App\Core\ResProviderClass;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;


class CommandFactory
{

    private Command $objCommand;
    private PathProvaider $pathMap;
    private ResProviderClass $resObj;

    /**
     * CommandFactory constructor.
     * @param PathProvaider $pathMap
     */
    public function __construct(PathProvaider $pathMap)
    {
        $this->resObj = new ResProviderClass($pathMap);
        $this->pathMap = $pathMap;
    }


    /**
     * @param array $argv
     * @return Command
     */
    public function __invoke(array $argv): Command
    {
        $inputCommand = $argv[1];
        if(!isset($inputCommand)) {
            $inputCommand = 'help';
        }
        $commands = $this->resObj->getCommandsList();
        try {
            if (isset($commands[$inputCommand])) {
                switch ($inputCommand) {
                    case "init":
                        $this->objCommand = new InitCommand($this->pathMap);
                        break;
                    case "help":
                        $this->objCommand = new HelpCommand($this->pathMap, $commands);
                        break;
                    case "start":
                        $this->objCommand = new StartCommand($this->pathMap);
                        break;
                }
            } else {
                $message = $this->resObj->getMessages(get_class($this));
                throw new ErrorException($message['command-not-found']);
            }
        } catch (ErrorException $exception) {
            ConsoleSay::errorConsole([$exception->getMessage()]);
            die();
        }

        return $this->objCommand;

    }

}