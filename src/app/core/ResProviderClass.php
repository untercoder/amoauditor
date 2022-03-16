<?php


namespace Nosekpt\Amoauditor\App\Core;

use ErrorException;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;

class ResProviderClass
{
    private const PHP_ENDING = '.php';
    private array $configList = [];
    private PathProvaider $pathMap;

    /**
     * ResProviderClass constructor.
     */
    public function __construct(PathProvaider $pathMap)
    {
        $this->pathMap = $pathMap;
        if ($this->checkResDir()) {
            $configs = scandir($this->pathMap->getResTxtPath());
            foreach ($configs as $config) {
                if (strpos($config, self::PHP_ENDING)) {
                    $this->configList[] = str_replace(self::PHP_ENDING, '', $config);
                }
            }
        }
    }

    /**
     * @return bool
     */
    private function checkResDir(): bool
    {
        try {
            if (!is_dir($this->pathMap->getResPath())) {
                throw new ErrorException('Error!: ' . $this->pathMap->getResPath() . ' not found.');
            } else {
                return true;
            }
        } catch (ErrorException $exception) {
            ConsoleSay::errorConsole([$exception->getMessage()]);
            return false;
        }
    }

    /**
     * @param string $configName
     * @return array
     */

    private function getFromTxtRes(string $configName): array
    {
        try {
            if (!isset($this->configList)) {
                throw new ErrorException("Error!: in " . $this->pathMap->getResTxtPath() . " no configs files in the directory");
            } else {
                if (in_array($configName, $this->configList)) {
                    $path = $this->pathMap->getResTxtPath();
                    return require_once($path.DIRECTORY_SEPARATOR.$configName.self::PHP_ENDING);
                } else {
                    throw new ErrorException("Error!: commands file " . $configName
                        . self::PHP_ENDING . " not found in " . $this->pathMap->getResTxtPath());
                }

            }
        } catch (ErrorException $exeption) {
            ConsoleSay::errorConsole([$exeption->getMessage()]);
        }
    }

    public function getMessages(string $className) {
        $allMessages = $this->getFromTxtRes('messages');
        return $allMessages[$className];
    }

    public function getCommandsList() {
        return $this->getFromTxtRes('commands');
    }

}