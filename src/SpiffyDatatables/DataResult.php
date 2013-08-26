<?php

namespace SpiffyDatatables;

use Zend\Stdlib\Hydrator\HydratorAwareInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

class DataResult
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $filteredResultCount;

    /**
     * @var int
     */
    protected $totalResultCount;

    /**
     * @param mixed $data
     * @param int|null $totalResultCount
     * @param int|null $filteredResultCount
     */
    public function __construct($data, $totalResultCount = null, $filteredResultCount = null)
    {
        $this->data                = $data;
        $this->totalResultCount    = $totalResultCount ? $totalResultCount : count($data);
        $this->filteredResultCount = $filteredResultCount;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getTotalResultCount()
    {
        return $this->totalResultCount;
    }

    /**
     * @return int
     */
    public function getFilteredResultCount()
    {
        return $this->filteredResultCount;
    }
}