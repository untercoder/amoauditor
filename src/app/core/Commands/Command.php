<?php


namespace Nosekpt\Amoauditor\App\Core\Commands;


use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Core\ResProviderClass;

abstract class Command
{
    protected PathProvaider $pathMap;
    protected ResProviderClass $resObj;
    protected array $messages = [];

    /**
     * Command constructor.
     * @param PathProvaider $pathMap
     */
    public function __construct(PathProvaider $pathMap)
    {
        $this->pathMap = $pathMap;
        $this->resObj = new ResProviderClass($pathMap);
    }

    protected function getMessage(string $messageIndex) : string {
        if(empty($this->messages)) {
            $this->messages = $this->resObj->getMessages(get_class($this));
        }

        $message = $this->messages[$messageIndex];
        return $message;
    }

    abstract public function work();
}