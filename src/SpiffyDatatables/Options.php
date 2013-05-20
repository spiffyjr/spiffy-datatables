<?php

namespace SpiffyDatatables;

use SpiffyDatatables\Options\AbstractOptions;

/**
 * Class Options
 *
 * All options in this class reference http://datatables.net/usage/features and http://datatables.net/usage/options.
 * For options that are new to datatables but not yet handled in this method you can use the setExtraOptions() method.
 * All values default to null which will fallback to the defaults for datatables.
 *
 * @package SpiffyDatatables
 */
class Options extends AbstractOptions
{
    /**
     * An array of keys that are JSON expressions and should be taken literally (closures, for example).
     *
     * @var array
     */
    protected $jsonExpressions = array();

    /**
     * @var array
     */
    protected $data = array(
        // features
        'aaData'          => null,
        'bAutoWidth'      => null,
        'bDeferRender'    => null,
        'bFilter'         => null,
        'bInfo'           => null,
        'bJQueryUI'       => null,
        'bLengthChange'   => null,
        'bPaginate'       => null,
        'bProcessing'     => null,
        'bScrollInfinite' => null,
        'bServerSide'     => null,
        'bSort'           => null,
        'bSortClasses'    => null,
        'bStateSave'      => null,
        'sScrollX'        => null,
        'sScrollY'        => null,

        // options
        'bDestroy'        => null,
        'bRetreive'       => null,
        'bScrollAutoCss'  => null,
        'bScrollCollapse' => null,
        'bSortCellsTop'   => null,
        'iCookieDuration' => null,
        'iDeferLoading'   => null,
        'iDisplayLength'  => null,
        'iDisplayStart'   => null,
        'iScrollLoadGap'  => null,
        'iTabIndex'       => null,
        'oSearch'         => null,
        'sAjaxDataProp'   => null,
        'sAjaxSource'     => null,
        'sCookiePrefix'   => null,
        'sPaginationType' => null,
        'sDom'            => null
    );

    /**
     * @return array
     */
    public function getJsonExpressions()
    {
        return $this->jsonExpressions;
    }
}