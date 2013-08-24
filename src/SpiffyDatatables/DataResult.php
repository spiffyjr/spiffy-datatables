<?php

namespace SpiffyDatatables;

use Zend\Stdlib\Hydrator\HydratorAwareInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

class DataResult implements HydratorAwareInterface
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
     * @var null|HydratorInterface
     */
    protected $hydrator;

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
        if ($this->hydrator instanceof HydratorInterface) {
            $result = array();
            foreach ($this->data as $data) {
                if (is_object($data)) {
                    $data = $this->hydrator->extract($data);
                }
                $result[] = $data;
            }
            return $result;
        }
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
        return $this->hydrator;
    }
}