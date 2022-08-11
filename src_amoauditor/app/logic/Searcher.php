<?php

namespace Nosekpt\Amoauditor\App\Logic;

use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;

class Searcher
{
    private const STRLEN = 150; //длина выводимой строки
    private const STROFF = 50;  //максимальное расстояние от начала строки до искомого значения

    private string $widgetPatch;
    public function __construct(PathProvaider $path)
    {
        $this->widgetPatch = $path->getWidgetPath();
    }

    public function search(string $searchParam, string $jsFilePath): array {
        $searchResultInJsFile = [];
        exec('grep -n '.$searchParam." ".$jsFilePath, $searchResultInJsFile);

        //обрезка обусфицированного кода
        for ($i = 0; $i < count($searchResultInJsFile); $i++) {
            $result = explode(':', $searchResultInJsFile[$i],2);
            $result[1] = trim($result[1]);
            $position = strpos($result[1], $searchParam);
            $count = substr_count($result[1], $searchParam);
            $result[0].=' ('.$count.')';

            $result[1] = substr(
                $result[1],
                $position > self::STROFF ? $position - self::STROFF : 0,
                self::STRLEN
            );

            $searchResultInJsFile[$i] = implode(": \t\t", $result);
        }

        return $searchResultInJsFile;
    }

    public function searchJsFiles() : array {
        $jsFiles = [];
        exec("find ".$this->widgetPatch." -type f"." -name *.js"." -print", $jsFiles);
        return $jsFiles;
    }
}