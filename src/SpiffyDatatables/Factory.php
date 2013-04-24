<?php

namespace SpiffyDatatables;

use SpiffyDatatables\Column\Collection;

/**
 * Class Factory
 * @package SpiffyDatatables
 */
class Factory
{
    /**
     * @throws \RuntimeException on instantiation
     */
    public function __construct()
    {
        throw new \RuntimeException(
            'Factory should not be instantiated: use the create() method'
        );
    }

    /**
     * @param array $spec
     * @return Datatable
     */
    public static function create(array $spec)
    {
        $datatable = new Datatable();

        if (isset($spec['columns'])) {
            $datatable->setColumns(Collection::factory($spec['columns']));
        }

        if (isset($spec['options'])) {
            $datatable->getOptions()->setData($spec['options']);
        }

        return $datatable;
    }
}