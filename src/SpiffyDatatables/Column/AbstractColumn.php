<?php

namespace SpiffyDatatables\Column;

/**
 * Class AbstractColumn
 *
 * All options in this class reference http://datatables.net/usage/columns. For options that are new to
 * datatables but not yet handled in this method you can use the setExtraOptions() method. All values
 * default to null which will fallback to the defaults for datatables.
 *
 * @package SpiffyDatatables\Column
 */
abstract class AbstractColumn
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->setOptions($options);
    }

    /**
     * @param array $row
     * @return mixed
     */
    public function getValue(array $row)
    {
        $key = $this->getOption('mDataProp');
        $key = $key ? $key : $this->getOption('mData');
        $key = $key ? $key : $this->getOption('sTitle');

        if (!$key) {
            return null;
        }

        return isset($row[$key]) ? $row[$key] : null;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions($options)
    {
        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getOption($key)
    {
        return isset($this->options[$key]) ? $this->options[$key] : null;
    }
}