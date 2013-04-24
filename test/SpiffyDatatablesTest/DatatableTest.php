<?php

namespace SpiffyDatatablesTest;

use SpiffyDatatables\DataResult;
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
        $this->assertInstanceOf('SpiffyDatatables\Options', $datatable->getOptions());
    }

    public function testDataResultIsLazyLoaded()
    {
        $datatable = new Datatable();
        $this->assertInstanceOf('SpiffyDatatables\DataResult', $datatable->getDataResult());
    }

    public function testRenderOptionsJavascriptProxiesToRenderer()
    {
        $datatable = new Datatable();
        $renderer  = new Table();

        $datatable->setRenderer($renderer);
        $datatable->getOptions()->setData(array('bAutoWidth' => true));
        $datatable->getColumns()->add(array('sName' => 'one', 'sTitle' => 'Column One'));

        $this->assertEquals(
            $renderer->renderOptionsJavascript($datatable),
            $datatable->renderOptionsJavascript()
        );
    }

    public function testRenderHtmlProxiesToRenderer()
    {
        $datatable = new Datatable();
        $renderer  = new Table();

        $datatable->setRenderer($renderer);
        $datatable->getOptions()->setData(array('bAutoWidth' => true));
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
        $datatable->getOptions()->setData(array('bAutoWidth' => true));
        $datatable->getColumns()->add(array('sName' => 'one', 'sTitle' => 'Column One'));

        $this->assertEquals(
            $renderer->renderJavascript('foo', $datatable),
            $datatable->renderJavascript('foo')
        );
    }

    public function testIsServerSide()
    {
        $datatable = new Datatable();

        $this->assertEquals(false, $datatable->isServerSide());

        $datatable->getOptions()->set('bServerSide', true);
        $this->assertEquals(true, $datatable->isServerSide());

        $datatable->getOptions()->set('bServerSide', null);
        $datatable->setDataResult(new DataResult(array(), 10, 0));
        $this->assertEquals(true, $datatable->isServerSide());
    }
}