<?php

namespace SpiffyDatatables;

use SpiffyDatatables\Column\Collection;

class Datatable
{
    /**
     * @var DataResult
     */
    protected $dataResult;

    /**
     * @var Collection
     */
    protected $columns;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @return bool
     */
    public function isServerSide()
    {
        return isset($this->options['bServerSide']) || $this->getDataResult()->getFilteredResultCount() !== null;
    }

    /**
     * @param DataResult $dataResult
     * @return Datatable
     */
    public function setDataResult(DataResult $dataResult)
    {
        $this->dataResult = $dataResult;
        return $this;
    }

    /**
     * @return DataResult
     */
    public function getDataResult()
    {
        if (!$this->dataResult instanceof DataResult) {
            $this->dataResult = new DataResult(array(), 0);
        }
        return $this->dataResult;
    }

    /**
     * @param Collection $columns
     * @return Datatable
     */
    public function setColumns(Collection $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getColumns()
    {
        if (!$this->columns instanceof Collection) {
            $this->columns = new Collection();
        }
        return $this->columns;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
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