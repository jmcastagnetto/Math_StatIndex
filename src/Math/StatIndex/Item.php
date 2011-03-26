<?php
namespace Math\StatIndex { /* {{{ */
    class Item { /* {{{ */
        
        private $_name;
        private $_value;
        private $_quantity;
        private $_importance;
        
        /**
         * Constructor
         *
         * @param string $name name of the item
         * @param numeric $value value of the item
         * @param numeric $quantity quantity of the time
         * @param numeric $importance importance/weight of the item
         * @return Math\StatIndex\Item object
         * @access public
         */
        public function __construct($name, $value, $quantity, $importance = 1) {/* {{{ */
            $this->_name = strval($name);
            $this->_value = floatval($value);
            $this->_quantity = floatval($quantity);
            $this->_importance = floatval($importance);
        }/* }}} */

        /**
         * Returns the name of the item
         *
         * @return string
         * @acces public
         */
        public function getName() {/* {{{ */
            return $this->_name;
        }/* }}} */

        /**
         * Returns the value of the item
         *
         * @return numeric
         * @acces public
         */
        public function getValue() {/* {{{ */
            return $this->_value;
        }/* }}} */

        /**
         * Returns the quantity of the item
         *
         * @return numeric
         * @acces public
         */
        public function getQuantity() {/* {{{ */
            return $this->_quantity;
        }/* }}} */

        /**
         * Returns the importance/weight of the item
         *
         * @return numeric
         * @acces public
         */
        public function getImportance() {/* {{{ */
            return $this->_importance;
        }/* }}} */

    } /* }}} */
} /* }}} */
?>
