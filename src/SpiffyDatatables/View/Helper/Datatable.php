<?php

namespace SpiffyDatatables\View\Helper;

use SpiffyDatatables\Datatable as Source;
use Zend\View\Helper\AbstractHtmlElement;

class Datatable extends AbstractHtmlElement
{
    /**
     * @param string $id
     * @param Source $datatable
     * @param array $attributes
     * @return string
     */
    public function __invoke($id, Source $datatable, array $attributes = array())
    {
        $js = sprintf('$(function() { %s });', $datatable->renderJavascript($id));

        $this->getView()->inlineScript()->prependScript($js);
        return $datatable->renderHtml($id, $attributes);
    }
}