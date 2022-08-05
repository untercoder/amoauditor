<?php

namespace Nosekpt\Amoauditor\App\Logic;

use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;

class Searcher
{
    private string $widgetPatch;
    public function __construct(PathProvaider $path)
    {
        $this->widgetPatch = $path->getWidgetPath();
    }

    public function search(string $searchParam, string $jsFilePath): array {
        $searchResultInJsFile = [];
        exec('grep -n '.$searchParam." ".$jsFilePath, $searchResultInJsFile);
        return $searchResultInJsFile;
    }

    public function searchJsFiles() : array {
        $jsFiles = [];
        exec("find ".$this->widgetPatch." -type f"." -name *.js"." -print", $jsFiles);
        return $jsFiles;
    }
}