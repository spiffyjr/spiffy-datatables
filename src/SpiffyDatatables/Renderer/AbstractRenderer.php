<?php

namespace SpiffyDatatables\Renderer;

use SpiffyDatatables\Column\Collection;
use Zend\Escaper\Escaper;
use Zend\Json\Expr;
use Zend\Json\Json;

abstract class AbstractRenderer implements RendererInterface
{
    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @param Escaper $escaper
     * @return AbstractRenderer
     */
    public function setEscaper($escaper)
    {
        $this->escaper = $escaper;
        return $this;
    }

    /**
     * @return \Zend\Escaper\Escaper
     */
    public function getEscaper()
    {
        if (!$this->escaper instanceof Escaper) {
            $this->escaper = new Escaper();
        }
        return $this->escaper;
    }

    /**
     * Converts an associative array to a string of tag attributes.
     *
     * @access public
     *
     * @param array $attribs From this array, each key-value pair is
     * converted to an attribute name and value.
     *
     * @return string The XHTML for the attributes.
     */
    protected function htmlAttribs($attribs)
    {
        $xhtml   = '';
        $escaper = $this->getEscaper();
        foreach ((array) $attribs as $key => $val) {
            $key = $escaper->escapeHtmlAttr($key);

            if (('on' == substr($key, 0, 2)) || ('constraints' == $key)) {
                // Don't escape event attributes; _do_ substitute double quotes with singles
                if (!is_scalar($val)) {
                    // non-scalar data should be cast to JSON first
                    $val = \Zend\Json\Json::encode($val);
                }
                // Escape single quotes inside event attribute values.
                // This will create html, where the attribute value has
                // single quotes around it, and escaped single quotes or
                // non-escaped double quotes inside of it
                $val = str_replace('\'', '&#39;', $val);
            } else {
                if (is_array($val)) {
                    $val = implode(' ', $val);
                }
                $val = $escaper->escapeHtmlAttr($val);
            }

            if ('id' == $key) {
                $val = $this->normalizeId($val);
            }

            if (strpos($val, '"') !== false) {
                $xhtml .= " $key='$val'";
            } else {
                $xhtml .= " $key=\"$val\"";
            }

        }
        return $xhtml;
    }

    /**
     * Normalize an ID
     *
     * @param  string $value
     * @return string
     */
    protected function normalizeId($value)
    {
        if (strstr($value, '[')) {
            if ('[]' == substr($value, -2)) {
                $value = substr($value, 0, strlen($value) - 2);
            }
            $value = trim($value, ']');
            $value = str_replace('][', '-', $value);
            $value = str_replace('[', '-', $value);
        }
        return $value;
    }

    /**
     * @param Collection $columns
     * @return string
     */
    protected function columnsToJson(Collection $columns)
    {
        $result = array();
        /** @var $column \SpiffyDatatables\Column\AbstractColumn */
        foreach($columns as $column) {
            $result[] = new Expr($this->toJson($column->getData(), $column->getJsonExpressions()));
        }
        return $this->toJson($result);
    }

    /**
     * @param array $input
     * @param array $expressionKeys
     * @return string
     */
    public function toJson(array $input, array $expressionKeys = array())
    {
        foreach($input as $key => $value) {
            if (in_array($key, $expressionKeys)) {
                $input[$key] = new Expr($value);
            }
        }

        if (empty($input)) {
            $input = (object) $input;
        }

        return Json::encode($input, false, array('enableJsonExprFinder' => true));
    }
}