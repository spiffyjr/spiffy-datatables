<?php

namespace SpiffyDatatables;

use SpiffyDatatables\Exception\InvalidDatatableException;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\Exception;
use Zend\ServiceManager\ServiceManager;

class DatatableManager extends AbstractPluginManager
{
    /**
     * {@inheritDoc}
     */
    public function __construct(ConfigInterface $configuration = null)
    {
        $this->addInitializer(function (AbstractDatatable $datatable) {
            $datatable->init();
        });
        parent::__construct($configuration);
    }

    /**
     * {@inheritDoc}
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof AbstractDatatable) {
            throw new InvalidDatatableException(sprintf(
                'Datatable of type %s is invalid; must implement %s\DatatableInterface',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
                __NAMESPACE__
            ));
        }
    }
}