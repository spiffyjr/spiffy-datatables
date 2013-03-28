<?php

namespace SpiffyDatatables\Options;

abstract class AbstractOptions
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * Options that are not verified.
     *
     * @var array
     */
    protected $extraOptions = array();

    /**
     * An array of keys that are JSON expressions and should be taken literally (closures, for example).
     *
     * @var array
     */
    protected $jsonExpressions = array();

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->setOptions($options);
    }

    /**
     * @param array $extraOptions
     * @return AbstractOptions
     */
    public function setExtraOptions($extraOptions)
    {
        $this->extraOptions = $extraOptions;
        return $this;
    }

    /**
     * @return array
     */
    public function getExtraOptions()
    {
        return $this->extraOptions;
    }

    /**
     * Set the options.
     *
     * @param array $options
     * @return AbstractOptions
     */
    public function setOptions(array $options)
    {
        foreach($options as $key => $value) {
            $this->set($key, $value);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return array_merge($this->options, $this->extraOptions);
    }

    /**
     * @param string $key
     * @param string|bool|null|int $value
     * @return AbstractOptions
     */
    public function set($key, $value)
    {
        $this->validateKey($key);
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return string|bool|null|int
     */
    public function get($key)
    {
        $this->validateKey($key);
        return $this->options[$key];
    }

    /**
     * @return array
     */
    public function getJsonExpressions()
    {
        return $this->jsonExpressions;
    }

    /**
     * @param string $key
     * @throws \InvalidArgumentException if key does not exist
     * @return void
     */
    protected function validateKey($key)
    {
        if (!array_key_exists($key, $this->options)) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown option "%s"',
                $key
            ));
        }
    }
}