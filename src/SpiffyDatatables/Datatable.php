<?php

namespace SpiffyDatatables;

use SpiffyDatatables\Column\Collection;
use SpiffyDatatables\Renderer\RendererInterface;
use SpiffyDatatables\Renderer\Table;
use Zend\Json\Json;

class Datatable
{
    /**
     * An array of entities for static data output.
     *
     * @var array
     */
    protected $staticData = array();

    /**
     * @var Collection
     */
    protected $columns;

    /**
     * @var DatatableOptions
     */
    protected $options;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * @param array $staticData
     * @return Datatable
     */
    public function setStaticData($staticData)
    {
        $this->staticData = $staticData;
        return $this;
    }

    /**
     * @return array
     */
    public function getStaticData()
    {
        return $this->staticData;
    }

    /**
     * @param Collection $columns
     * @return Datatable
     */
    public function setColumns(Collection $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @return \SpiffyDatatables\Column\Collection
     */
    public function getColumns()
    {
        if (!$this->columns instanceof Collection) {
            $this->columns = new Collection();
        }
        return $this->columns;
    }

    /**
     * @param DatatableOptions $options
     * @return Datatable
     */
    public function setOptions(DatatableOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return DatatableOptions
     */
    public function getOptions()
    {
        if (!$this->options instanceof DatatableOptions) {
            $this->options = new DatatableOptions();
        }
        return $this->options;
    }

    /**
     * @param RendererInterface $renderer
     * @return Datatable
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * @return \SpiffyDatatables\Renderer\RendererInterface
     */
    public function getRenderer()
    {
        if (!$this->renderer instanceof RendererInterface) {
            $this->renderer = new Table();
        }
        return $this->renderer;
    }

    /**
     * Proxies to getRenderer()->renderJavascript();
     *
     * @var string $id
     * @return string
     */
    public function renderJavascript($id)
    {
        return $this->getRenderer()->renderJavascript($id, $this);
    }

    /**
     * Proxies to getRenderer()->renderHtml();
     *
     * @var string $id
     * @var array $attributes
     * @return string
     */
    public function renderHtml($id, array $attributes = array())
    {
        return $this->getRenderer()->renderHtml($id, $this, $attributes);
    }
}