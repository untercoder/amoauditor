<?php

namespace Nosekpt\Amoauditor\App\Logic;

use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;

class Searcher
{
    private const STRLEN = 150; // длина выводимой строки
    private const STROFF = 50;  // максимальное расстояние от начала строки до искомого значения
    private const STRNUM = 15;   // количество строк, выводимых для циклов

    private string $widgetPatch;
    public function __construct(PathProvaider $path)
    {
        $this->widgetPatch = $path->getWidgetPath();
    }

    public function search(string $searchParam, string $jsFilePath): array {
        $searchResultInJsFile = [];

        if(
            $searchParam === '$.ajax' ||
            $searchParam === '$.post' ||
            $searchParam === '$.get' ||
            $searchParam === 'crm_post'
        ){
            exec(
                'grep -nF --before-context='.self::STRNUM.' --no-group-separator '.
                $searchParam." ".$jsFilePath, $searchResultInJsFile
            );
            for ($i = 0; $i < count($searchResultInJsFile); $i++) {
                $result = preg_split("/[:-]/", $searchResultInJsFile[$i], 2);
                if ($subposition = strpos($result[1], $searchParam)) {
                    $result[1] = substr(
                        $result[1],
                        $subposition > 2*self::STROFF ? $subposition - 2*self::STROFF : 0,
                        self::STRLEN
                    )."\n\n------------------------------------------------------------\n";
                } else {
                    $result[1] = substr(
                        $result[1],
                        -self::STRLEN
                    );
                }
                $searchResultInJsFile[$i] = implode(": \t\t", $result);
            }
            return $searchResultInJsFile;
        }

        exec('grep -nF '.$searchParam." ".$jsFilePath, $searchResultInJsFile);

        // обрезка обусфицированного (и не только) кода
        for ($i = 0; $i < count($searchResultInJsFile); $i++) {
            // отделяем номер строки от текста строки, тримим текст строки
            $result = explode(':', $searchResultInJsFile[$i],2);
            $result[1] = trim($result[1]);

            // находим количество вхождений искомого выражения
            $count = substr_count($result[1], $searchParam);

            // разбиваем строку на подстроки с одним искомым выражением в центре
            $split = explode($searchParam, $result[1]);
            $join = '';
            for ($j = 0; $j < $count; $j++) {
                $substr = implode($searchParam, [$split[$j], $split[$j+1]]);
                $subposition = strpos($substr, $searchParam);
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