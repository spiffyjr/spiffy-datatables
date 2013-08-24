<?php

namespace SpiffyDatatables;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * Service configuration for the datatable manager (invokables, factories, etc.).
     *
     * @var array
     */
    protected $manager = array();

    /**
     * An array of datatables to register with the datatable manager. This is handled by the
     * SpiffyDatatables\DatatableAbstractFactory.
     *
     * @var array
     */
    protected $datatables = array();

    /**
     * @param array $manager
     * @return $this
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
        return $this;
    }

    /**
     * @return array
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param array $datatables
     * @return $this
     */
    public function setDatatables($datatables)
    {
        $this->datatables = $datatables;
        return $this;
    }

    /**
     * @return array
     */
    public function getDatatables()
    {
        return $this->datatables;
    }
}
