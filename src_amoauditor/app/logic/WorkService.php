<?php

namespace Nosekpt\Amoauditor\App\Logic;

use ErrorException;
use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;
use ZipArchive;

class WorkService
{
    private string $widgetZipPath;
    private ZipArchive $zipManager;
    private string $pathWidgetZip;
    /**
     * WorkService constructor.
     * @param string $widgetZip
     */
    public function __construct(string $widgetZip)
    {
        $this->zipManager = new ZipArchive;
        $this->widgetZipPath = $widgetZip;
    }

    public static function Observer(PathProvaider $path) : ?WorkService
    {
        $fileNameArray = glob($path->getZipPath().DIRECTORY_SEPARATOR.'*.zip');
        if(!empty($fileNameArray)) {
            if (file_exists($fileNameArray[0])) {
                return new WorkService($fileNameArray[0]);
            }
        }
        return null;
    }

    /**
     * @return string
     */
    public function getWidgetZipPath(): string
    {
        return $this->widgetZipPath;
    }

    public function extract(string $toExtract) : void
    {
        try {
            if ($this->zipManager->open($this->widgetZipPath)) {
                $this->zipManager->extractTo($toExtract);
                $this->zipManager->close();
                unlink($this->widgetZipPath);
            } else {
                throw new ErrorException("Ошибка извелечения архива!");
            }
        } catch (ErrorException $exception) {
            ConsoleSay::errorConsole([$exception]);
        }
    }

    public function clearWorkSpace(string $widgetWorkSpace) : void {
        exec("rm -rf ".$widgetWorkSpace);
        mkdir($widgetWorkSpace);
    }

}