<?php

namespace SpiffyDatatables\Column;

class Collection implements \Iterator
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
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->columns[$this->index];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return isset($this->columns[$this->index]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->index = 0;
    }
}