<?php


namespace Nosekpt\Amoauditor\App\Core;


class PathProvaider
{

    private string $resPath;
    private string $zipPath;
    private string $widgetPath;
    private string $reportPath;
    private string $resTxtPath;
    private string $resViewPath;

    /**
     * PathProvaider constructor.
     */
    public function __construct(string $corePath)
    {
        $this->resPath = $corePath.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'res';
        $this->zipPath = $corePath.DIRECTORY_SEPARATOR.'zip';
        $this->widgetPath = $corePath.DIRECTORY_SEPARATOR.'widget';
        $this->reportPath = $corePath.DIRECTORY_SEPARATOR.'report';
        $this->resTxtPath = $this->resPath.DIRECTORY_SEPARATOR.'txt';
        $this->resViewPath = $this->resPath.DIRECTORY_SEPARATOR.'view';
    }

    /**
     * @return string
     */
    public function getResPath(): string
    {
        return $this->resPath;
    }

    /**
     * @return string
     */
    public function getZipPath(): string
    {
        return $this->zipPath;
    }

    /**
     * @return string
     */
    public function getWidgetPath(): string
    {
        return $this->widgetPath;
    }

    /**
     * @return string
     */
    public function getReportPath(): string
    {
        return $this->reportPath;
    }

    /**
     * @return string
     */
    public function getResTxtPath(): string
    {
        return $this->resTxtPath;
    }

    /**
     * @return string
     */
    public function getResViewPath(): string
    {
        return $this->resViewPath;
    }




}