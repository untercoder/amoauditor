<?php


namespace Nosekpt\Amoauditor\App\Core\Commands;


use Nosekpt\Amoauditor\App\Core\PathProvaider;

abstract class Command
{
    protected PathProvaider $pathMap;

    /**
     * Command constructor.
     * @param PathProvaider $pathMap
     */
    public function __construct(PathProvaider $pathMap)
    {
        $this->pathMap = $pathMap;
    }

    abstract public function work();
}