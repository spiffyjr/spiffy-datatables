<?php

namespace SpiffyDatatables;

use Zend\ServiceManager\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DatatableManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return DatatableManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \SpiffyDatatables\ModuleOptions $options */
        $options = $serviceLocator->get('SpiffyDatatables\ModuleOptions');
        $manager = new DatatableManager(new Config($options->getManager()));

        return $manager;
    }

    /**
     * Generic method for getting from service locator, or creating a class.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $input
     * @throws \RuntimeException if the resource could not be found
     * @return mixed
     */
    protected function get($input, ServiceLocatorInterface $serviceLocator)
    {
        if (is_string($input) && $serviceLocator->has($input)) {
            return $serviceLocator->get($input);
        } else if (class_exists($input)) {
            return new $input;
        }

        throw new \RuntimeException(sprintf(
            'Service "%s" could not be found',
            $input
        ));
    }
}
