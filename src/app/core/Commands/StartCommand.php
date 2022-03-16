<?php


namespace Nosekpt\Amoauditor\App\Core\Commands;


use Exception;
use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;

class StartCommand extends Command
{
    public function work()
    {
        try {
            if($this->initExist()) {
                if($this->serverExist()) {
                    ConsoleSay::commentConsole(['body' => "Для прекращения работы Ctrl + C:"]);
                    ConsoleSay::successConsole(['body' => "Жду архив с виджетом:"]);
                    while (true) {

                        sleep(2);
                    }
                }else {
                    throw new Exception("Не поднят локальный сервер: выполни: php -S localhost:80 /report");
                }

            } else {
                throw new Exception('Отсутствуют рабочии директории: выполни php amoauditor.php init');
            }

        } catch (Exception $exception) {
            ConsoleSay::errorConsole([$exception->getMessage()]);
        }

    }

    private function initExist() {
        if(file_exists($this->pathMap->getZipPath()) and file_exists($this->pathMap->getZipPath())) {
            return true;
        } else {
            return false;
        }
    }

    private function serverExist(): bool {
        $ch = curl_init('http://localhost:1010/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        if($http_code === 200) {
            return true;
        } else {
            return false;
        }
    }
}