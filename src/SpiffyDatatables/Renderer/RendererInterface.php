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
     * Renders only the options portion of the Javascript for Datatables. Useful for custom setting up
     * javascript instead of using the built in methods. If no custom options are passed in then the
     * options for the datatable are used.
     *
     * @param Datatable $datatable
     * @param array|null $options
     * @return string
     */
    public function renderOptionsJavascript(Datatable $datatable, array $options = null);

    /**
     * Renders the Javascript for the Datatable.
     *
     * @param string $id
     * @param Datatable $datatable
     * @return string
     */
    public function renderJavascript($id, Datatable $datatable);
}