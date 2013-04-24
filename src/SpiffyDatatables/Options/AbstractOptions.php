<?php

namespace SpiffyDatatables\Options;

abstract class AbstractOptions
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * Data that is not verified.
     *
     * @var array
     */
    protected $extraData = array();

    /**
     * An array of keys that are JSON expressions and should be taken literally (closures, for example).
     *
     * @var array
     */
    protected $jsonExpressions = array();

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->setData($data);
    }

    /**
     * @param array $extraData
     * @return AbstractOptions
     */
    public function setExtraData($extraData)
    {
        $this->extraData = $extraData;
        return $this;
    }

    /**
     * @return array
     */
    public function getExtraData()
    {
        return $this->extraData;
    }

    /**
     * @param array $data
     * @return AbstractOptions
     */
    public function setData(array $data)
    {
        foreach($data as $key => $value) {
            $this->set($key, $value);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $merged = array_merge($this->data, $this->extraData);

        foreach($merged as $key => $value) {
            if (null === $value) {
                unset($merged[$key]);
            }
        }
        return $merged;
    }

    /**
     * @param string $key
     * @param string|bool|null|int $value
     * @return AbstractOptions
     */
    public function set($key, $value)
    {
        $this->validateKey($key);
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return string|bool|null|int
     */
    public function get($key)
    {
        $this->validateKey($key);
        return $this->data[$key];
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
        if (!array_key_exists($key, $this->data)) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown option "%s"',
                $key
            ));
        }
    }
}