<?php

namespace SpiffyDatatables\Renderer;

use SpiffyDatatables\Datatable;
use Zend\Json\Expr;
use Zend\Json\Json;

class Table extends AbstractRenderer
{
    /**
     * Renders the HTML for the Datatable.
     *
     * @param string $id
     * @param Datatable $datatable
     * @param array $attributes
     * @return string
     */
    public function renderHtml($id, Datatable $datatable, array $attributes = array())
    {
        // force the id
        $attributes['id'] = $id;

        $tableStart = sprintf('<table%s>%s', $this->htmlAttribs($attributes), PHP_EOL);
        $header     = str_repeat(' ', 4) . '<tr>' . PHP_EOL;

        /** @var $column \SpiffyDatatables\Column\AbstractColumn */
        foreach($datatable->getColumns() as $column) {
            $title  = $column->get('sTitle') ? $column->get('sTitle') : '';
            $header.= str_repeat(' ', 8) . '<th>' . $title . '</th>' . PHP_EOL;
        }

        $header  .= str_repeat(' ', 4) . '</tr>' . PHP_EOL;
        $tableEnd = '</table>';

        return $tableStart . $header . $tableEnd;
    }

    /**
     * Renders the Javascript for the Datatable.
     *
     * @param string $id
     * @param Datatable $datatable
     * @return string
     */
    public function renderJavascript($id, Datatable $datatable)
    {
        $options              = $datatable->getOptions()->getOptions();
        $options['aoColumns'] = new Expr($this->columnsToJson($datatable->getColumns()));

        $start   = sprintf('$("#%s").dataTable(', $id);
        $options = $this->toJson($options, $datatable->getOptions()->getJsonExpressions());
        $end     = ');';

        return $start . Json::prettyPrint($options, array('indent' => "    ")) . $end;
    }
}
