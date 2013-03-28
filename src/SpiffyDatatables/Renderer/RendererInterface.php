<?php

namespace SpiffyDatatables\Renderer;

use SpiffyDatatables\Datatable;

interface RendererInterface
{
    /**
     * Renders the HTML for the Datatable.
     *
     * @param string $id
     * @param Datatable $datatable
     * @param array $attributes
     * @return string
     */
    public function renderHtml($id, Datatable $datatable, array $attributes = array());

    /**
     * Renders the Javascript for the Datatable.
     *
     * @param string $id
     * @param Datatable $datatable
     * @return string
     */
    public function renderJavascript($id, Datatable $datatable);
}