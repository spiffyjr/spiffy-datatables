<?php

namespace SpiffyDatatables;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;
use Zend\ServiceManager\ServiceManager;

class DatatableManager extends AbstractPluginManager
{
    /**
     * {@inheritDoc}
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof AbstractDatatable) {
            throw new Exception\InvalidDatatableException(sprintf(
                'Datatable of type %s is invalid; must implement %s\DatatableInterface',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
                __NAMESPACE__
            ));
        }
    }
}