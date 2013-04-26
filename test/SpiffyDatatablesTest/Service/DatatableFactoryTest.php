<?php

namespace SpiffyDatatablesTest;

use SpiffyDatatables\Options;
use SpiffyDatatables\Service\DatatableFactory;
use SpiffyTest\Framework\TestCase;

class DatatableFactoryTest extends TestCase
{
    public function testInstanceOfManagerReturned()
    {
        $factory = new DatatableFactory(array());

        $this->assertInstanceOf(
            'SpiffyDatatables\Datatable',
            $factory->createService($this->getServiceManager())
        );
    }
}