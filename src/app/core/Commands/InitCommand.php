<?php


namespace Nosekpt\Amoauditor\App\Core\Commands;

use Exception;
use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;
use Nosekpt\Amoauditor\App\Core\ResProviderClass;

class InitCommand extends Command
{
    private ResProviderClass $resObj;

    public function __construct(PathProvaider $pathMap)
    {
        $this->resObj = new ResProviderClass($pathMap);
        parent::__construct($pathMap);
    }

    public function work(): void
    {
        $message = $this->resObj->getMessages(get_class($this));
        try {
            if (file_exists($this->pathMap->getZipPath()) and file_exists($this->pathMap->getWidgetPath()) and
                file_exists($this->pathMap->getReportPath())) {
                throw new Exception($message['work-dir-created']);
            }
            if (!file_exists($this->pathMap->getZipPath())) {
                $zip = mkdir($this->pathMap->getZipPath(), 777);
            }
            if (!file_exists($this->pathMap->getWidgetPath())) {
                $widget = mkdir($this->pathMap->getWidgetPath(), 777);
            }

            if (!file_exists($this->pathMap->getReportPath())) {
                $report = mkdir($this->pathMap->getReportPath(), 777);
                copy($this->pathMap->getResViewPath() . DIRECTORY_SEPARATOR . 'index_report.php', $this->pathMap->getReportPath() . DIRECTORY_SEPARATOR . 'index.php');
            }

            if ($zip and $widget and $report) {
                ConsoleSay::successConsole([
                    'body' => $message['work-dir-success']
                ]);
            }
        } catch (Exception $exception) {
            ConsoleSay::errorConsole([$exception->getMessage()]);
        }

    }

}