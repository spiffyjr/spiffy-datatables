<?php

namespace SpiffyDatatablesTest\View\Helper;

use SpiffyDatatables\Datatable as Source;
use SpiffyDatatables\View\Helper\Datatable;
use SpiffyTest\Framework\TestCase;

class DatatableTest extends TestCase
{
    public function testInvokeMethod()
    {
        $datatable = new Source();

        $columns = $datatable->getColumns();
        $columns->add();
        $columns->add(array('sTitle' => 'Second'));

        $helper = new Datatable();
        $helper->setView($this->getServiceManager()->get('ViewManager')->getRenderer());
        $helper('foo', $datatable, array('class' => 'test'));
    }
}