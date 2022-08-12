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

        // обрезка обусфицированного (и не только) кода
        for ($i = 0; $i < count($searchResultInJsFile); $i++) {
            // вырезаем конструкции регулярных выражений
            $param = str_replace('"','', $searchParam);
            $param = str_replace('\\', '', $param);

            // отделяем номер строки от текста строки, тримим текст строки
            $result = explode(':', $searchResultInJsFile[$i],2);
            $result[1] = trim($result[1]);

            // находим количество вхождений искомого выражения
            $count = substr_count($result[1], $param);
//            $result[0].=' ('.$count.')';

            // разбиваем строку на подстроки с одним искомым выражением в центре
            $split = explode($param, $result[1]);
            $join = '';
            for ($j = 0; $j < $count; $j++) {
                $substr = implode($param, [$split[$j], $split[$j+1]]);
                $subposition = strpos($substr, $param);
                $substr = substr(
                    $substr,
                    $subposition > self::STROFF ? $subposition - self::STROFF : 0,
                    self::STRLEN
                );
                $join.=$substr."\n\t\t";
            }
            $result[1] = trim($join, " \n\t");

            // добавляем номер строки и количество вхождений к обрезанной строке
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