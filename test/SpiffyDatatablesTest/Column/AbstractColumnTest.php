<?php

namespace SpiffyDatatablesTest\Column;

use SpiffyDatatables\Column\Column;
use SpiffyDatatablesTest\Assets\SimpleEntity;

class AbstractColumnTest extends \PHPUnit_Framework_TestCase
{
    public function testGetValueFallsBackTomDataIfPresent()
    {
        $data   = array('name' => 'foo');
        $column = new Column();
        $column->set('mData', 'name');

        $this->assertEquals('foo', $column->getValueFromData($data));
    }

    public function testExceptionThrownWhenGetValueIsGivenInvalidData()
    {
        $data = array('name' => 'foo');

        $column = new Column();
        $column->setMethod('name');
        $column->getValueFromData($data);
        $column->getValueFromData((object) $data);

        $this->setExpectedException('InvalidArgumentException', 'array or object expected');
        $column->getValueFromData(false);
    }

    public function testExceptionIsThrownWhenNoMethodGiven()
    {
        $column = new Column();
        $this->setExpectedException('RuntimeException', 'invalid or missing method for data retrieval');
        $column->getValueFromData(array());
    }

    public function testGetValueFromAnObject()
    {
        $column = new Column();
        $column->setMethod('name');

        $data = new SimpleEntity();
        $data->setId(1)
             ->setName('foo')
             ->public = true;

        $closure = function($data) {
            /** @var $data SimpleEntity */
            return $data->getId();
        };

        $column->setMethod('getName');
        $this->assertEquals('foo', $column->getValueFromData($data));

        $column->setMethod($closure);
        $this->assertEquals(1, $column->getValueFromData($data));

        $column->setMethod('public');
        $this->assertEquals(true, $column->getValueFromData($data));
    }

    public function testGetValueFromAnObjectThrowsExceptionOnMissingProperty()
    {
        $column = new Column();
        $column->setMethod('name');

        $this->setExpectedException('InvalidArgumentException', 'no property "name" or accessor "getName" exists in data object');
        $column->getValueFromData((object) array());
    }

    public function testGetValueFromAnArrayThrowsExceptionOnMissingKey()
    {
        $column = new Column();
        $column->setMethod('name');

        $this->setExpectedException('InvalidArgumentException', 'no key "name" exists in data array');
        $column->getValueFromData(array());
    }

    public function testGetValueFromAnArray()
    {
        $column = new Column();
        $column->setMethod('name');

        $data = array('name' => 'foo');
        $this->assertEquals('foo', $column->getValueFromData($data));

        $closure = function($data) {
            return $data['name'];
        };
        $column->setMethod($closure);
        $this->assertEquals('foo', $column->getValueFromData($data));
    }
}