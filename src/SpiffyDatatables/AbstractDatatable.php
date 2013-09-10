<?php

namespace SpiffyDatatables;

use SpiffyDatatables\Column\Collection;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorAwareInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

abstract class AbstractDatatable implements HydratorAwareInterface
{
    /**
     * @var DataResult
     */
    protected $dataResult;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var Collection
     */
    protected $columns;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * Used to setup the datatable. This is automatically called if the
     * datatable is retrieved from the datatable manager.
     *
     * @return void
     */
    public function init()
    {}

    /**
     * @return bool
     */
    public function isServerSide()
    {
        return isset($this->options['bServerSide']);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (!$this->dataResult) {
            return array();
        }

        $hydrator = $this->getHydrator();
        $result   = array();
        foreach ($this->dataResult->getData() as $data) {
            if (is_object($data)) {
                $data = $hydrator->extract($data);
            }
            $result[] = $data;
        }
        return $result;
    }

    /**
     * @param array|DataResult $dataResult
     * @throws \InvalidArgumentException
     * @return Datatable
     */
    public function setDataResult($dataResult)
    {
        if (is_array($dataResult)) {
            $dataResult = new DataResult($dataResult);
        }

        if (!$dataResult instanceof DataResult) {
            throw new \InvalidArgumentException('DataResult must be an array or instanceof DataResult');
        }
        $this->dataResult = $dataResult;
        return $this;
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

    /**
     * {@inheritDoc}
     */
    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getHydrator()
    {
        if (!$this->hydrator instanceof HydratorInterface) {
            $this->hydrator = new ClassMethods();
        }
        return $this->hydrator;
    }
}