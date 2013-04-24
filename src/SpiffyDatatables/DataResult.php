<?php

namespace SpiffyDatatables;

/**
 * Class DataResult
 * @package SpiffyDatatables
 */
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

    public function __construct($data, $totalResultCount, $filteredResultCount = null)
    {
        $this->data                = $data;
        $this->totalResultCount    = $totalResultCount;
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