<?php

namespace SpiffyDatatablesTest\Renderer;

use SpiffyDatatables\DataResult;
use SpiffyDatatables\Datatable;
use SpiffyDatatables\Renderer\Table;
use SpiffyDatatablesTest\Assets\SimpleEntity;

class TableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Datatable
     */
    protected $datatable;

    /**
     * @var Table
     */
    protected $renderer;

    /**
     * @var SimpleEntity
     */
    protected $row1;

    /**
     * @var SimpleEntity
     */
    protected $row2;

    public function setUp()
    {
        $this->datatable = new Datatable();
        $this->renderer  = new Table();

        $columns = $this->datatable->getColumns();
        $options = $this->datatable->getOptions();

        $columns->add(array('sTitle' => 'One', 'mData' => 'id'))
                ->add(array('sTitle' => 'Two', 'mData' => 'name'))
                ->add(array('bVisible' => false, 'method' => 'public'));

        $options->set('bAutoWidth', true)
                ->set('bJQueryUI', true);

        $row1 = new SimpleEntity();
        $row1->setId(1)
             ->setName('foo')
             ->setPublic('yep');

        $row2 = new SimpleEntity();
        $row2->setId(2)
             ->setName('bar')
             ->setPublic('nope');

        $this->row1 = $row1;
        $this->row2 = $row2;
    }

    public function testServerSideMarkupIsRenderedUsingOptions()
    {
        $this->datatable->getOptions()->set('bServerSide', true);

        $expected = file_get_contents(__DIR__ . '/../_files/datatable/table_serverside_markup.html');
        $result   = $this->renderer->renderHtml('foo', $this->datatable, array('class' => 'bar'));
        $this->assertEquals($expected, $result);
    }

    public function testServerSideMarkupIsRendererdFromDataResult()
    {
        $data = array($this->row1, $this->row2);
        $this->datatable->setDataResult(new DataResult($data, 10, count($data)));

        $expected = file_get_contents(__DIR__ . '/../_files/datatable/table_serverside_markup.html');
        $result   = $this->renderer->renderHtml('foo', $this->datatable, array('class' => 'bar'));
        $this->assertEquals($expected, $result);
    }

    public function testStaticMarkupIsRendered()
    {
        $data = array($this->row1, $this->row2);
        $this->datatable->setDataResult(new DataResult($data, count($data)));

        $expected = file_get_contents(__DIR__ . '/../_files/datatable/table_static_markup.html');
        $result   = $this->renderer->renderHtml('foo', $this->datatable, array('class' => 'bar'));
        $this->assertEquals($expected, $result);
    }

    public function testJavascriptOptionsRendered()
    {
        $expected = file_get_contents(__DIR__ . '/../_files/datatable/table_javascript_options.json');
        $result   = $this->renderer->renderOptionsJavascript($this->datatable);
        $this->assertEquals($expected, $result);
    }

    public function testJavascriptRendered()
    {
        $expected = file_get_contents(__DIR__ . '/../_files/datatable/table_javascript.js');
        $result   = $this->renderer->renderJavascript('foo', $this->datatable);
        $this->assertEquals($expected, $result);
    }

    public function testToJsonHandlesExpressions()
    {
        $result = $this->renderer->toJson(array('foo' => 'function() { }'), array('foo'));
        $this->assertEquals('{"foo":function() { }}', $result);
    }
}