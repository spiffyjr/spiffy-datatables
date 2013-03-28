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
        $header     = str_repeat(' ', 4) . '<thead>' . PHP_EOL;
        $header    .= str_repeat(' ', 8) . '<tr>' . PHP_EOL;

        /** @var $column \SpiffyDatatables\Column\AbstractColumn */
        foreach($datatable->getColumns() as $column) {
            $title  = $column->get('sTitle') ? $column->get('sTitle') : '';
            $style  = ($column->get('bVisible') === false) ? ' style="display:none;"' : '';
            $header.= sprintf("%s<th%s>%s</th>%s", str_repeat(' ', 12), $style, $title, PHP_EOL);
        }

        $body = str_repeat(' ', 4) . '<tbody>' . PHP_EOL;
        $body.= $this->getStaticBody($datatable);
        $body.= str_repeat(' ', 4) . '</tbody>' . PHP_EOL;

        $header  .= str_repeat(' ', 8) . '</tr>' . PHP_EOL;
        $header  .= str_repeat(' ', 4) . '</thead>' . PHP_EOL;
        $tableEnd = '</table>';

        return $tableStart . $header . $body . $tableEnd;
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

    /**
     * @param Datatable $datatable
     * @return string
     */
    protected function getStaticBody(Datatable $datatable)
    {
        $output = '';

        foreach($datatable->getStaticData() as $row) {
            $output.= str_repeat(' ', 8) . '<tr>' . PHP_EOL;

            /** @var $column \SpiffyDatatables\Column\AbstractColumn */
            foreach($datatable->getColumns() as $column) {
                $style  = ($column->get('bVisible') === false) ? ' style="display:none;"' : '';
                $value  = $column->getValueFromData($row);

                if (is_array($value)) {
                    $value = '[array]';
                } else if (is_object($value)) {
                    $value = '[object]';
                }
                $output.= sprintf("%s<td%s>%s</td>%s", str_repeat(' ', 12), $style, $value, PHP_EOL);
            }

            $output.= str_repeat(' ', 8) . '</tr>' . PHP_EOL;
        }

        return $output;
    }
}
