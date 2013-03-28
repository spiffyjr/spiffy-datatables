<?php

namespace SpiffyDatatablesTest;

use SpiffyDatatables\Datatable;
use SpiffyDatatables\Renderer\Table;

class DatatableTest extends \PHPUnit_Framework_TestCase
{
    public function testColumnCollectionIsLazyLoaded()
    {
        $datatable = new Datatable();
        $this->assertInstanceOf('SpiffyDatatables\Column\Collection', $datatable->getColumns());
    }

    public function rendererIsLazyLoaded()
    {
        $datatable = new Datatable();
        $this->assertInstanceOf('SpiffyDatatables\Renderer\Table', $datatable->getRenderer());
    }

    public function testConfigIsLazyLoaded()
    {
        $datatable = new Datatable();
        $this->assertInstanceOf('SpiffyDatatables\DatatableOptions', $datatable->getOptions());
    }

    public function testRenderHtmlProxiesToRenderer()
    {
        $datatable = new Datatable();
        $renderer  = new Table();

        $datatable->setRenderer($renderer);
        $datatable->getOptions()->setOptions(array('bAutoWidth' => true));
        $datatable->getColumns()->add(array('sName' => 'one', 'sTitle' => 'Column One'));

        $this->assertEquals(
            $renderer->renderHtml('foo', $datatable, array('class' => 'test')),
            $datatable->renderHtml('foo', array('class' => 'test'))
        );
    }

    public function testRenderJavascriptProxiesToRenderer()
    {
        $datatable = new Datatable();
        $renderer  = new Table();

        $datatable->setRenderer($renderer);
        $datatable->getOptions()->setOptions(array('bAutoWidth' => true));
        $datatable->getColumns()->add(array('sName' => 'one', 'sTitle' => 'Column One'));

        $this->assertEquals(
            $renderer->renderJavascript('foo', $datatable),
            $datatable->renderJavascript('foo')
        );
    }
}