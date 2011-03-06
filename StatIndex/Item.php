<?php

    class Math_StatIndex_Item {
        
        var $_name;
        var $_value;
        var $_quantity;
        var $_importance;
        
        function Math_StatIndex_Item($name, $value, $quantity, $importance = 1) {
            $this->_name = strval($name);
            $this->_value = floatval($value);
            $this->_quantity = floatval($quantity);
            $this->_importance = floatval($importance);
        }

        function getName() {
            return $this->_name;
        }

        function getValue() {
            return $this->_value;
        }

        function getQuantity() {
            return $this->_quantity;
        }

        function getImportance() {
            return $this->_importance;
        }

    }

?>
