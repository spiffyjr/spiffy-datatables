<?php

namespace SpiffyDatatablesTest\Column;

use SpiffyDatatables\Column\Collection;
use SpiffyDatatables\Column\Column;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $input = array(
            array(
                'sName' => 'foo',
            ),
            array(
                'sName' => 'bar'
            )
        );

        $expected = new Collection();
        $expected->add(array('sName' => 'foo'))
                 ->add(array('sName' => 'bar'));

        $this->assertEquals($expected, Collection::factory($input));
    }

    public function testExceptionThrownOnInvalidSpec()
    {
        $columns = new Collection();
        $columns->add();

        $this->setExpectedException(
            'InvalidArgumentException',
            'Invalid spec type: expected null, array, or instance of SpiffyDatatable\Column\AbstractColumn'
        );
        $columns->add(true);
    }

    public function testExceptionThrownOnGetWithInvalidName()
    {
        $columns = new Collection();
        $columns->add();
        $columns->get(0);

        $this->setExpectedException('OutOfBoundsException', 'Invalid column index');
        $columns->get(1);
    }

    public function testAddingColumnWithColumnObject()
    {
        $expected = new Column(array(
            'sName'  => 'foo',
            'sTitle' => 'Test Column'
        ));

        $columns = new Collection();
        $columns->add($expected);

        $this->assertEquals($expected, $columns->get(0));
    }

    public function testAddingColumnWithNull()
    {
        $expected = new Column();
        $columns  = new Collection();
        $columns->add();

        $this->assertEquals($expected, $columns->get(0));
    }

    public function testAddingColumnWithAnArray()
    {
        $expected = new Column(array(
            'sName'  => 'foo',
            'sTitle' => 'Test Column'
        ));

        $columns = new Collection();
        $columns->add(array(
            'sName'  => 'foo',
            'sTitle' => 'Test Column'
        ));

        $this->assertEquals($expected, $columns->get(0));
    }

    public function testExceptionThrownWhenGetIsNotAnInt()
    {
        $this->setExpectedException('InvalidArgumentException', 'Index must be an integer');
        $columns = new Collection();
        $columns->add();
        $columns->get(false);
    }
}