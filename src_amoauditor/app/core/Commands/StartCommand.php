<?php


namespace Nosekpt\Amoauditor\App\Core\Commands;


use Exception;
use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;
use Nosekpt\Amoauditor\App\Logic\Searcher;
use Nosekpt\Amoauditor\App\Logic\WorkService;


class StartCommand extends Command
{
    private array $searchList;
    private Searcher $searcher;
    private int $auditCounter;

    public function __construct(PathProvaider $pathMap)
    {
        parent::__construct($pathMap);
        $this->searchList = $this->resObj->getSearchList();
        $this->searcher = new Searcher($pathMap);
        $this->auditCounter = 0;
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
            $this->auditCounter += 1;
            $widget->clearWorkSpace($this->pathMap->getWidgetPath());
            $widget->extract($this->pathMap->getWidgetPath());
            ConsoleSay::borderConsole($this->auditCounter);
            $this->audit();
            //print_r(json_encode($this->audit(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        }
    }

    private function audit() : array
    {
        $auditListing = [];
        $auditListingInJsFile = [];
        $allJsFiles = $this->searcher->searchJsFiles();
        foreach ($allJsFiles as $jsFile) {
            ConsoleSay::successConsole(["body" => "Поиск в " . $jsFile]);
            foreach ($this->searchList as $searchParam => $description) {
                $searchResult = $this->searcher->search($searchParam, $jsFile);
                if(!empty($searchResult)) {
                    $param = str_replace('"','', $searchParam);
                    $param = str_replace('\\', '', $param);

                    ConsoleSay::commentConsole(['body' => $description]);
                    foreach ($searchResult as $result) {
                        ConsoleSay::searchConsole([
                            'body' => $result,
                            'param' => $param,
                        ]);
                    }
                    ConsoleSay::newLineConsole();
                }
                $auditListingInJsFile[] = ['description' => $description, 'searchResult' => $searchResult];
            }
            $auditListing[$jsFile] = $auditListingInJsFile;
            $auditListingInJsFile = [];
        }
        return $auditListing;
    }


    private function initExist() : bool
    {
        if (file_exists($this->pathMap->getZipPath()) and file_exists($this->pathMap->getWidgetPath())) {
            return true;
        } else {
            return false;
        }
    }

}