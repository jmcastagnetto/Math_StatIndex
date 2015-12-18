<?php

namespace Math\StatIndex;

/**
 * Class Item
 * @package Math\StatIndex
 */
class Item {

    /**
     * @var array
     */
    private $_params;

    /**
     * Item constructor.
     *
     * @param \Math\StatIndex\string $name
     * @param \Math\StatIndex\float  $value
     * @param \Math\StatIndex\float  $quantity
     * @param \Math\StatIndex\float  $importance
     */
    function __construct(string $name, float $value, float $quantity, float $importance = 1) {
        $this->_params = [
            "name"       => $name,
            "value"      => $value,
            "quantity"   => $quantity,
            "importance" => $importance,
            ];
        }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \Math\StatIndex\StatIndexException
     */
    function __get(string $name) {
        if (array_key_exists($name, $this->_params)) {
            return $this->_params[$name];
        } else {
            throw new StatIndexException("Undefined parameter for item");
        }
    }

}
