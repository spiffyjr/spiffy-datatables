<?php

namespace SpiffyDatatables\View\Helper;

use SpiffyDatatables\Datatable as Source;
use Zend\View\Helper\AbstractHtmlElement;

class Datatable extends AbstractHtmlElement
{
    public function __invoke($id, Source $datatable, array $attributes = array())
    {
        $this->getView()->inlineScript()->prependScript($datatable->renderJavascript($id));
        return $datatable->renderHtml($id, $attributes);
    }
}