<?php

namespace SpiffyDatatablesTest;

use SpiffyDatatables\Column\Collection;
use SpiffyDatatables\Factory;
use SpiffyDatatables\Options;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testRuntimeExceptionThrownOnInstantiation()
    {
        $this->setExpectedException(
            'RuntimeException',
            'Factory should not be instantiated: use the create() method'
        );
        new Factory();
    }

    public function testDatatableIsReturned()
    {
        $this->assertInstanceOf('SpiffyDatatables\Datatable', Factory::create(array()));
    }

    public function testFactoryHandlesOptionsDefinition()
    {
        $spec = array(
            'options' => array(
                'bProcessing' => true,
                'bServerSide' => true
            )
        );

        $expected = new Options();
        $expected->set('bProcessing', true)
                 ->set('bServerSide', true);

        $this->assertEquals($expected, Factory::create($spec)->getOptions());
    }

    public function testFactoryHandlesColumnsDefinition()
    {
        $spec = array(
            'columns' => array(
                array(
                    'sName' => 'foo',
                ),
                array(
                    'sName' => 'bar'
                )
            )
        );

        $expected = new Collection();
        $expected->add(array('sName' => 'foo'))
                 ->add(array('sName' => 'bar'));

        $this->assertEquals($expected, Factory::create($spec)->getColumns());
    }
}