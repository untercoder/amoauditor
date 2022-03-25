<?php

namespace Nosekpt\Amoauditor\App\Logic;

use ErrorException;
use Nosekpt\Amoauditor\App\Core\PathProvaider;
use Nosekpt\Amoauditor\App\Helpers\ConsoleSay;
use ZipArchive;

class WidgetController
{
    private string $widgetZipPath;
    private ZipArchive $zipManager;

    /**
     * WidgetController constructor.
     * @param string $widgetZip
     */
    public function __construct(string $widgetZip)
    {
        $this->zipManager = new ZipArchive;
        $this->widgetZipPath = $widgetZip;
    }

    public static function Observer(PathProvaider $path): ?WidgetController
    {
        $pathWidgetZip = $path->getZipPath() . DIRECTORY_SEPARATOR . 'widget.zip';
        if (file_exists($pathWidgetZip)) {
            return new WidgetController($pathWidgetZip);
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getWidgetZipPath(): string
    {
        return $this->widgetZipPath;
    }

    public function extract(string $toExtract)
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

    public function clearWorkSpace(string $widgetWorkSpace) {
        if (file_exists($widgetWorkSpace.DIRECTORY_SEPARATOR)) {
            foreach (glob($widgetWorkSpace.DIRECTORY_SEPARATOR.'*') as $file) {
                if(is_dir($file)) {
                    $this->clearWorkSpace($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($widgetWorkSpace);
        }
    }



}