<?php

namespace SpiffyDatatables\Column;

use SpiffyDatatables\Options\AbstractOptions;

/**
 * Class AbstractColumn
 *
 * All options in this class reference http://datatables.net/usage/columns. For options that are new to
 * datatables but not yet handled in this method you can use the setExtraOptions() method. All values
 * default to null which will fallback to the defaults for datatables.
 *
 * @package SpiffyDatatables\Column
 */
abstract class AbstractColumn extends AbstractOptions
{
    /**
     * @var array
     */
    protected $options = array(
        'aDataSort'       => null,
        'asSorting'       => null,
        'bSearchable'     => null,
        'bSortable'       => null,
        'bVisible'        => null,
        'fnCreatedCell'   => null,
        'iDataSort'       => null,
        'mData'           => null,
        'mRender'         => null,
        'sCellType'       => null,
        'sClass'          => null,
        'sContentPadding' => null,
        'sDefaultContent' => null,
        'sName'           => null,
        'sSortDataType'   => null,
        'sTitle'          => null,
        'sType'           => null,
        'sWidth'          => null
    );
}