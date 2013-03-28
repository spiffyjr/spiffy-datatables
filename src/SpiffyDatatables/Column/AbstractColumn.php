<?php

namespace SpiffyDatatables\Column;

use Closure;
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
     * The method for retrieving data from a data object. Can be a property name,
     * method, or a closure. The closure will receive the data object as the
     * first argument.
     *
     * @var string
     */
    protected $method;

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

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        if (isset($options['method'])) {
            $this->setMethod($options['method']);
            unset($options['method']);
        }
        parent::__construct($options);
    }

    /**
     * Gets the columns value from data.
     *
     * @throws \RuntimeException when missing or invalid method
     * @throws \InvalidArgumentException when invalid data is passed
     * @param array|object $data
     * @return mixed
     */
    public function getValueFromData($data)
    {
        $method = $this->method ? $this->method : $this->get('mData');

        if (is_array($data)) {
            if (is_string($method)) {
                if (isset($data[$method])) {
                    return $data[$method];
                }
                throw new \InvalidArgumentException(sprintf(
                    'no key "%s" exists in data array',
                    $method
                ));
            } else if ($method instanceof Closure) {
                return $method($data);
            }
        } else if (is_object($data)) {
            if (is_string($method)) {
                $accessor = null;
                $vars     = get_object_vars($data);

                if (array_key_exists($method, $vars)) {
                    return $vars[$method];
                } else if (method_exists($data, $method)) {
                    return $data->$method();
                } else {
                    $transform = function($letters) {
                        return strtoupper(array_shift($letters));
                    };
                    $accessor = preg_replace_callback('/(_.)/', $transform, $method);
                    $accessor = 'get' . ucfirst($method);
                    $methods  = get_class_methods($data);
                    if (in_array($accessor, $methods)) {
                        return $data->$accessor();
                    }
                }
                throw new \InvalidArgumentException(sprintf(
                    'no property "%s" or accessor "%s" exists in data object',
                    $method,
                    $accessor
                ));
            } else if ($method instanceof Closure) {
                return $method($data);
            }
        } else {
            throw new \InvalidArgumentException('array or object expected');
        }
        throw new \RuntimeException('invalid or missing method for data retrieval');
    }

    /**
     * @param string $method
     * @return AbstractColumn
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}