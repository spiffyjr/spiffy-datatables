<?php

namespace SpiffyDatatables\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DatatableFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Datatable
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Zend\View\HelperPluginManager $serviceLocator */
        $sl = $serviceLocator->getServiceLocator();
        return new Datatable($sl->get('SpiffyDatatables\DatatableManager'));
    }
}