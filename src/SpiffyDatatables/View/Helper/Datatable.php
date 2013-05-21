<?php

namespace SpiffyDatatables\View\Helper;

use SpiffyDatatables\Datatable as Source;
use Zend\View\Helper\AbstractHtmlElement;

class Datatable extends AbstractHtmlElement
{
    /**
     * @var string
     */
    protected static $jsFile  = 'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js';

    /**
     * @var string
     */
    protected static $cssFile = 'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css';

    /**
     * @var bool
     */
    protected static $autoRegisterJsFile = true;

    /**
     * @var bool
     */
    protected static $autoRegisterCssFile = true;

    public function __invoke($id, Source $datatable, array $attributes = array())
    {
        if (self::getAutoRegisterJsFile()) {
            $this->getView()->inlineScript()->appendFile(self::getJsFile());
        }

        if (self::getAutoRegisterCssFile()) {
            $this->getView()->headLink()->appendStylesheet(self::getCssFile());
        }

        $js = sprintf('$(function() { %s });', $datatable->renderJavascript($id));

        $this->getView()->inlineScript()->prependScript($js);
        return $datatable->renderHtml($id, $attributes);
    }

    /**
     * @param boolean $autoRegisterCssFile
     * @return Datatable
     */
    public static function setAutoRegisterCssFile($autoRegisterCssFile)
    {
        self::$autoRegisterCssFile = $autoRegisterCssFile;
    }

    /**
     * @return boolean
     */
    public static function getAutoRegisterCssFile()
    {
        return self::$autoRegisterCssFile;
    }

    /**
     * @param boolean $autoRegisterJsFile
     */
    public static function setAutoRegisterJsFile($autoRegisterJsFile)
    {
        self::$autoRegisterJsFile = $autoRegisterJsFile;
    }

    /**
     * @return boolean
     */
    public static function getAutoRegisterJsFile()
    {
        return self::$autoRegisterJsFile;
    }

    /**
     * @param string $cssFile
     */
    public static function setCssFile($cssFile)
    {
        self::$cssFile = $cssFile;
    }

    /**
     * @return string
     */
    public static function getCssFile()
    {
        return self::$cssFile;
    }

    /**
     * @param string $jsFile
     */
    public static function setJsFile($jsFile)
    {
        self::$jsFile = $jsFile;
    }

    /**
     * @return string
     */
    public static function getJsFile()
    {
        return self::$jsFile;
    }
}