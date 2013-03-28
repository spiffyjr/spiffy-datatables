<?php

namespace SpiffyDatatablesTest\Assets;

class SimpleEntity
{
    protected $id;

    protected $name;

    public $public;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    public function getPublic()
    {
        return $this->public;
    }
}