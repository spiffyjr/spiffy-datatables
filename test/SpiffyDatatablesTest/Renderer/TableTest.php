<?php

namespace SpiffyDatatablesTest\Renderer;

use SpiffyDatatables\Datatable;
use SpiffyDatatables\Renderer\Table;

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

    public function setUp()
    {
        $this->datatable = new Datatable();
        $this->renderer  = new Table();

        $columns = $this->datatable->getColumns();
        $options = $this->datatable->getOptions();

        $columns->add(array('sTitle' => 'One'))
                ->add(array('sTitle' => 'Two'))
                ->add(array('sTitle' => 'Three'))
                ->add();

        $options->set('bAutoWidth', true)
                ->set('bJQueryUI', true);
    }

    public function testFullMarkupIsRenderer()
    {
        $expected = file_get_contents(__DIR__ . '/../_files/datatable/table_markup.html');
        $result   = $this->renderer->renderHtml('foo', $this->datatable, array('class' => 'bar'));

        $this->assertEquals($expected, $result);
    }

    public function testJavascriptRenderedWithOptions()
    {
        $expected = file_get_contents(__DIR__ . '/../_files/datatable/table_javascript.js');
        $result   = $this->renderer->renderJavascript('foo', $this->datatable);

        $this->assertEquals($expected, $result);
    }
}