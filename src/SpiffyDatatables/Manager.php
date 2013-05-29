<?php

namespace SpiffyDatatables;

use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Manager
 * @package SpiffyDatatables
 */
class Manager extends ServiceManager implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config = null)
    {
        if ($config) {
            $config->configureServiceManager($this);
        }

        $this->addInitializer(function($object) {
            if ($object instanceof ServiceLocatorAwareInterface) {
                $object->setServiceLocator($this->getServiceLocator());
            }
        });

        $this->addInitializer(function($object) {
            if (method_exists($object, 'init')) {
                $object->init();
            }
        });
    }
}