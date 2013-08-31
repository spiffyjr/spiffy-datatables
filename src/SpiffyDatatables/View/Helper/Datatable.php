<?php

namespace SpiffyDatatables\View\Helper;

use SpiffyDatatables\AbstractDatatable;
use SpiffyDatatables\DatatableManager;
use Zend\Json\Expr;
use Zend\Json\Json;
use Zend\View\Helper\AbstractHtmlElement;

class Datatable extends AbstractHtmlElement
{
    /**
     * @var DatatableManager
     */
    protected $manager;

    /**
     * @var array
     */
    protected $jsonExpressions = array();

    /**
     * @param DatatableManager $manager
     */
    public function __construct(DatatableManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param string|AbstractDatatable|null $nameOrDatatable
     * @return $this
     */
    public function __invoke($nameOrDatatable = null)
    {
        if ($nameOrDatatable) {
            if (is_string($nameOrDatatable)) {
                return $this->manager->get($nameOrDatatable);
            }
            return $nameOrDatatable;
        }
        return $this;
    }

    /**
     * Injects the Datatable javascript using the inlineScript helper.
     *
     * @param string|null $nameOrDatatable
     * @param string|null $id
     * @param string $placement prepend, append, or set
     */
    public function injectJs($nameOrDatatable, $id = null, $placement = 'APPEND')
    {
        $js = sprintf('$(function() { %s });', $this->renderJavascript($nameOrDatatable, $id));
        $this->getView()->inlineScript('script', $js, $placement);
    }

    /**
     * Renders the HTML for the Datatable.
     *
     * @param string|AbstractDatatable $nameOrDatatable
     * @param string|null $id
     * @param array $attributes
     * @return string
     */
    public function renderHtml($nameOrDatatable, $id = null, array $attributes = array())
    {
        if ($id) {
            $attributes['id'] = $id;
        }

        if (!isset($attributes['id'])) {
            $attributes['id'] = $this->extractId($nameOrDatatable);
        }

        if (!$nameOrDatatable instanceof AbstractDatatable) {
            $nameOrDatatable = $this->manager->get($nameOrDatatable);
        }

        $columns    = $nameOrDatatable->getColumns();
        $tableStart = sprintf('<table%s>%s', $this->htmlAttribs($attributes), PHP_EOL);
        $header     = '';

        if ($columns->count() > 0) {
            $header = str_repeat(' ', 4) . '<thead>' . PHP_EOL;
            $header.= str_repeat(' ', 8) . '<tr>' . PHP_EOL;

            /** @var $column \SpiffyDatatables\Column\AbstractColumn */
            foreach($nameOrDatatable->getColumns() as $column) {
                $title  = $column->getOption('sTitle') ? $column->getOption('sTitle') : '';
                $style  = ($column->getOption('bVisible') === false) ? ' style="display:none;"' : '';
                $header.= sprintf("%s<th%s>%s</th>%s", str_repeat(' ', 12), $style, $title, PHP_EOL);
            }

            $header  .= str_repeat(' ', 8) . '</tr>' . PHP_EOL;
            $header  .= str_repeat(' ', 4) . '</thead>' . PHP_EOL;
        }

        $body = str_repeat(' ', 4) . '<tbody>' . PHP_EOL;

        if ($nameOrDatatable->isServerSide()) {
            $body.= $this->getServerSideBody($nameOrDatatable);
        } else {
            $body.= $this->getStaticBody($nameOrDatatable);
        }

        $body.= str_repeat(' ', 4) . '</tbody>' . PHP_EOL;
        $tableEnd = '</table>';

        return $tableStart . $header . $body . $tableEnd;
    }

    /**
     * Renders the Javascript for the Datatable.
     *
     * @param string|AbstractDatatable $nameOrDatatable
     * @param string|null $id
     * @return string
     */
    public function renderJavascript($nameOrDatatable, $id = null)
    {
        if (!$id) {
            $id = $this->extractId($nameOrDatatable);
        }
        return sprintf(
            '$("#%s").dataTable(%s);',
            $id,
            $this->renderOptionsJavascript($nameOrDatatable)
        );
    }

    /**
     * Renders only the options portion of the Javascript for Datatables. Useful for setting up
     * javascript instead of using the built in methods. If no custom options are passed in then the
     * options for the datatable are used.
     *
     * @param string|AbstractDatatable $nameOrDatatable
     * @param array|null $options
     * @return string
     */
    public function renderOptionsJavascript($nameOrDatatable, array $options = null)
    {
        if (!$nameOrDatatable instanceof AbstractDatatable) {
            $nameOrDatatable = $this->manager->get($nameOrDatatable);
        }

        $options              = $options ? $options : $nameOrDatatable->getOptions();
        $options['aoColumns'] = $nameOrDatatable->getColumns()->toArray();

        foreach($options as $key => $value) {
            if (in_array($key, $this->jsonExpressions)) {
                $input[$key] = new Expr($value);
            }
        }

        // datatables fails with [] instead of {} so cast to object to avoid that
        if (empty($options)) {
            $options = (object) $options;
        }

        $json = Json::encode($options, false, array('enableJsonExprFinder' => true));
        return Json::prettyPrint($json, array('indent' => "    "));
    }

    /**
     * @param AbstractDatatable $datatable
     * @return string
     */
    protected function getServerSideBody(AbstractDatatable $datatable)
    {
        $output = str_repeat(' ', 8) . '<tr>';
        $output.= sprintf(
            '<td colspan="%d">Loading data ...</td>',
            count($datatable->getColumns()->getColumns())
        );
        $output.= '</tr>' . PHP_EOL;

        return $output;
    }

    /**
     * @param string|AbstractDatatable $nameOrDatatable
     * @return string
     */
    protected function extractId($nameOrDatatable)
    {
        if (is_string($nameOrDatatable)) {
            return preg_replace('/[^a-z_-]+/', '', strtolower($nameOrDatatable));
        }

        return 'datatable';
    }

    /**
     * @param AbstractDatatable $datatable
     * @throws \RuntimeException
     * @return string
     */
    protected function getStaticBody(AbstractDatatable $datatable)
    {
        $output = '';

        foreach($datatable->getData() as $row) {
            $output.= str_repeat(' ', 8) . '<tr>' . PHP_EOL;

            /** @var $column \SpiffyDatatables\Column\AbstractColumn */
            foreach($datatable->getColumns() as $column) {
                $style  = ($column->getOption('bVisible') === false) ? ' style="display:none;"' : '';
                $value  = $column->getValue($row);

                if (is_object($value)) {
                    $value = '[object]';
                } else if (is_array($value)) {
                    $value = '[array]';
                }

                $output.= sprintf("%s<td%s>%s</td>%s", str_repeat(' ', 12), $style, $value, PHP_EOL);
            }

            $output.= str_repeat(' ', 8) . '</tr>' . PHP_EOL;
        }

        return $output;
    }
}
