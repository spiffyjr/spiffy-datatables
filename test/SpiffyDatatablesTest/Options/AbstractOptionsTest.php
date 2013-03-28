<?php

namespace SpiffyDatatablesTest\Options;

use SpiffyDatatablesTest\Assets\JsonOptions;
use SpiffyDatatablesTest\Assets\SimpleOptions;

class AbstractOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testOptionsAreSetOnConstruction()
    {
        $expected = array('foo' => 'foo', 'bar' => 'bar');
        $options  = new SimpleOptions($expected);

        $this->assertEquals($expected, $options->getOptions());
    }

    public function testExtraOptionsAreSetAndReturned()
    {
        $expected = array(
            'foo' => 'foo',
            'bar' => 'bar',
            'baz' => 'baz',
        );
        $options = new SimpleOptions(array('foo' => 'foo', 'bar' => 'bar'));
        $options->setExtraOptions(array('baz' => 'baz'));

        $this->assertEquals($expected, $options->getOptions());
    }

    public function testSetThrowsExceptionOnInvalidKey()
    {
        $options = new SimpleOptions();
        $options->set('foo', 'foo');

        $this->setExpectedException('InvalidArgumentException', 'Unknown option "doesnotexist"');
        $options->set('doesnotexist', true);
    }

    public function testGetThrowsExceptionOnInvalidKey()
    {
        $options = new SimpleOptions();
        $options->get('foo');

        $this->setExpectedException('InvalidArgumentException', 'Unknown option "doesnotexist"');
        $options->get('doesnotexist');
    }
}