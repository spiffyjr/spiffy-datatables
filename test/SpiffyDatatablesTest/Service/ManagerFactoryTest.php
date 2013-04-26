<?php

namespace SpiffyDatatablesTest;

use SpiffyDatatables\Column\Collection;
use SpiffyDatatables\Options;
use SpiffyTest\Framework\TestCase;

class ManagerFactoryTest extends TestCase
{
    public function testInstanceOfManagerReturned()
    {
        $this->assertInstanceOf(
            'SpiffyDatatables\Manager',
            $this->getServiceManager()->get('SpiffyDatatables\Manager')
        );
    }

    public function testDatatableCreatedCorrectlyFromConfig()
    {
        $manager   = $this->getServiceManager()->get('SpiffyDatatables\Manager');
        /** @var \SpiffyDatatables\Datatable $datatable */
        $datatable = $manager->get('foo');
        $this->assertInstanceOf('SpiffyDatatables\Datatable', $datatable);

        $expected = new Options(array('bProcessing' => true));
        $this->assertEquals($expected, $datatable->getOptions());

        $expected = new Collection();
        $expected->add(array('sTitle' => 'foo #1'))
                 ->add(array('sTitle' => 'foo #2'));

        $this->assertEquals($expected, $datatable->getColumns());
    }
}