<?php

namespace SpiffyDatatablesTest\Renderer;

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

        $data = array($row1, $row2);

        $this->datatable->setStaticData($data);
    }

    public function testFullMarkupIsRendered()
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