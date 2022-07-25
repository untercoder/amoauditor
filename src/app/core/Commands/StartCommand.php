<?php


namespace Nosekpt\Amoauditor\App\Core\Commands;


use Exception;
use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;
use Nosekpt\Amoauditor\App\Logic\Searcher;
use Nosekpt\Amoauditor\App\Logic\WorkService;
use Nosekpt\Amoauditor\App\Helpers\Writer;


class StartCommand extends Command
{
    private array $searchList;
    private Searcher $searcher;
    public function __construct(PathProvaider $pathMap)
    {
        parent::__construct($pathMap);
        $this->searchList = $this->resObj->getSearchList();
        $this->searcher = new Searcher($pathMap);
    }


    public function work()
    {
        try {
            if ($this->initExist()) {
                ConsoleSay::commentConsole(['body' => $this->getMessage('comment-ctrlc')]);
                ConsoleSay::successConsole(['body' => $this->getMessage('comment-widget')]);
                while (true) {
                    $this->start();
                    sleep(1);
                }
            } else {
                throw new Exception($this->getMessage('err-work-dir'));
            }

        } catch (Exception $exception) {
            ConsoleSay::errorConsole([$exception->getMessage()]);
        }

    }

    private function start()
    {
        $widget = WorkService::Observer($this->pathMap);
        if (isset($widget)) {
            $widget->clearWorkSpace($this->pathMap->getWidgetPath());
            ConsoleSay::successConsole(['body' => $widget->getWidgetZipPath()]);
            $widget->extract($this->pathMap->getWidgetPath());
            $allJsFiles = $this->searcher->searchJsFiles();
            foreach ($allJsFiles as $jsFile) {
                ConsoleSay::successConsole(["body"=>"Поиск в ".$jsFile]);
                foreach ($this->searchList as $searchParam => $description) {
                    ConsoleSay::commentConsole(['body' => $description]);
                    $searchResult = $this->searcher->search($searchParam, $jsFile);
                    print_r($searchResult);
                }
            }
        }
    }

    private function initExist()
    {
        if (file_exists($this->pathMap->getZipPath()) and file_exists($this->pathMap->getWidgetPath())
            and file_exists($this->pathMap->getReportPath())) {
            return true;
        } else {
            return false;
        }
    }

}