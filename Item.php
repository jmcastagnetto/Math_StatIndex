<?php

namespace Math\StatIndex;

class Item {

    private $_params;

    function __construct(string $name, float $value, float $quantity, float $importance = 1) {
        $this->_params = [
            "name"       => $name,
            "value"      => $value,
            "quantity"   => $quantity,
            "importance" => $importance,
            ];
        }

    function __get(string $name) {
        return $this->_params[$name];
    }

}
