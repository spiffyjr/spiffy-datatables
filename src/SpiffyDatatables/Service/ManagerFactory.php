<?php

namespace SpiffyDatatables\Service;

use SpiffyDatatables\Manager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config        = $serviceLocator->get('Configuration');
        $config        = $config['spiffydatatables'];
        $factoryConfig = array();

        if (isset($config['factory_config'])) {
            $factoryConfig = (array) $config['factory_config'];
            unset($config['factory_config']);
        }

        $manager = new Manager(new Config($config));

        foreach($factoryConfig as $name => $config) {
            $manager->setFactory($name, new DatatableFactory($config));
        }

        return $manager;
    }
}