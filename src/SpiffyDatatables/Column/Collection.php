<?php

namespace SpiffyDatatables\Column;

use Countable;
use Iterator;

class Collection implements Countable, Iterator
{
    /**
     * @var int
     */
    protected $index = 0;

    /**
     * An array of columns indexed by column name which maps to the sName config
     * value for the column. If sName is changed on the column it will be overwritten
     * by the collection on retrieval.
     *
     * @var array
     */
    protected $columns = array();

    /**
     * Factory to create a column collection.
     *
     * @param array $spec
     * @return Collection
     */
    public static function factory(array $spec)
    {
        $collection = new Collection();
        foreach($spec as $columnDef) {
            $collection->add($columnDef);
        }
        return $collection;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        $columns = array();
        foreach($this->columns as $name => $column) {
            $columns[$name] = $this->get($name);
        }
        return $columns;
    }

    /**
     * @param null|array|AbstractColumn $spec
     * @return Collection
     * @throws \InvalidArgumentException on invalid spec type
     */
    public function add($spec = null)
    {
        if (is_null($spec)) {
            $spec = new Column();
        } else if (is_array($spec)) {
            $spec = new Column($spec);
        } else if (!$spec instanceof AbstractColumn) {
            throw new \InvalidArgumentException(
                'Invalid spec type: expected null, array, or instance of SpiffyDatatable\Column\AbstractColumn'
            );
        }

        $this->columns[] = $spec;
        return $this;
    }

    /**
     * Gets a column by name. Overrides the sName property of the column on
     * retrieval.
     *
     * @param int $index
     * @throws \InvalidArgumentException when the index is not an integer
     * @throws \OutOfBoundsException when an invalid index is passed.
     * @return AbstractColumn
     */
    public function get($index)
    {
        if (!is_int($index)) {
            throw new \InvalidArgumentException('Index must be an integer');
        }
        if (!isset($this->columns[$index])) {
            throw new \OutOfBoundsException('Invalid column index');
        }
        return $this->columns[$index];
    }

    /**
     * Converts Collection to array representation..
     */
    public function toArray()
    {
        $result = array();

        /** @var $column Column */
        foreach($this->getColumns() as $column) {
            $result[] = $column->getOptions();
        }
        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->columns[$this->index];
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return isset($this->columns[$this->index]);
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->columns);
    }
}