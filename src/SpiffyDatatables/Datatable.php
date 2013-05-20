<?php

namespace SpiffyDatatables;

use SpiffyDatatables\Column\Collection;
use SpiffyDatatables\Renderer\RendererInterface;
use SpiffyDatatables\Renderer\Table;
use Zend\Json\Json;

class Datatable
{
    /**
     * @var DataResult
     */
    protected $dataResult;

    /**
     * @var Collection
     */
    protected $columns;

    /**
     * @var Options
     */
    protected $options;

    /**
     * @var RendererInterface
     */
    protected $renderer;

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

    /**
     * @return bool
     */
    public function isServerSide()
    {
        return $this->getOptions()->get('bServerSide') ||
            $this->getDataResult()->getFilteredResultCount() !== null;
    }

    /**
     * @param \SpiffyDatatables\DataResult $dataResult
     * @return Datatable
     */
    public function setDataResult(DataResult $dataResult)
    {
        $this->dataResult = $dataResult;
        return $this;
    }

    /**
     * @return \SpiffyDatatables\DataResult
     */
    public function getDataResult()
    {
        if (!$this->dataResult instanceof DataResult) {
            $this->dataResult = new DataResult(array(), 0);
        }
        return $this->dataResult;
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
     * @param Options $options
     * @return Datatable
     */
    public function setOptions(Options $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return Options
     */
    public function getOptions()
    {
        if (!$this->options instanceof Options) {
            $this->options = new Options();
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
     * Proxies to getRenderer()->renderOptionsJavascript();
     *
     * @var array|null $options
     * @return string
     */
    public function renderOptionsJavascript(array $options = array())
    {
        return $this->getRenderer()->renderOptionsJavascript($this, $options);
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