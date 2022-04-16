<?php
namespace Nosekpt\Amoauditor\App\Core\Commands;

use Exception;
use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;
use Nosekpt\Amoauditor\App\Core\ResProviderClass;

class InitCommand extends Command
{
    public function work(): void
    {
        try {
            if (file_exists($this->pathMap->getZipPath()) and file_exists($this->pathMap->getWidgetPath()) and
                file_exists($this->pathMap->getReportPath())) {
                throw new Exception($this->getMessage('work-dir-created'));
            }
            if (!file_exists($this->pathMap->getZipPath())) {
                $zip = mkdir($this->pathMap->getZipPath(), );
            }
            if (!file_exists($this->pathMap->getWidgetPath())) {
                $widget = mkdir($this->pathMap->getWidgetPath(), );
            }

            if ($zip and $widget) {
                ConsoleSay::successConsole([
                    'body' => $this->getMessage('work-dir-success')
                ]);
            }
        } catch (Exception $exception) {
            ConsoleSay::errorConsole([$exception->getMessage()]);
        }

    }

}