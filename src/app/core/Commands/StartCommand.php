<?php


namespace Nosekpt\Amoauditor\App\Core\Commands;


use Exception;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;
use Nosekpt\Amoauditor\App\Logic\WidgetController;
use Shasoft\Console\Console;

class StartCommand extends Command
{

    public function work()
    {
        try {
            if ($this->initExist()) {
                if ($this->serverExist()) {
                    ConsoleSay::commentConsole(['body' => $this->getMessage('comment-ctrlc')]);
                    ConsoleSay::successConsole(['body' => $this->getMessage('comment-widget')]);
                    while (true) {
                        $this->start();
                        sleep(1);
                    }
                } else {
                    throw new Exception($this->getMessage('err-server-off'));
                }

            } else {
                throw new Exception($this->getMessage('err-work-dir'));
            }

        } catch (Exception $exception) {
            ConsoleSay::errorConsole([$exception->getMessage()]);
        }

    }

    private function start() {
        $widget = WidgetController::Observer($this->pathMap);
        if (isset($widget)) {
            $widget->clearWorkSpace($this->pathMap->getWidgetPath());
            ConsoleSay::successConsole(['body' => $widget->getWidgetZipPath()]);
            $widget->extract($this->pathMap->getWidgetPath());
        }
    }

    private function initExist()
    {
        if (file_exists($this->pathMap->getZipPath()) and file_exists($this->pathMap->getZipPath())) {
            return true;
        } else {
            return false;
        }
    }

    private function serverExist(): bool
    {
        $ch = curl_init('http://localhost:1010/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        if ($http_code === 200) {
            return true;
        } else {
            return false;
        }
    }
}