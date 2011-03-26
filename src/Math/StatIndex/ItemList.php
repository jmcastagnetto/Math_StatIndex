<?php
namespace Math\StatIndex {/* {{{ */
    use Math\StatIndex\Item;

    class ItemList{/* {{{ */

        private $_entries;

        /**
         * Constructor
         *
         * @access public
         */
        public function __construct() {/* {{{ */
            $this->_entries = array();
        }/* }}} */

        /**
         * Add an Item object to the ItemList
         *
         * @param object Math\StatIndex\Item 
         * @access public
         */
        public function addItem(Item $item) {/* {{{ */
            $this->_entries[$item->getName()] = $item;
        }/* }}} */

        /**
         * Removes an Item object from the ItemList
         *
         * @param string $name Item's name
         * @access public
         */
        public function removeItem($name) {/* {{{ */
            if (array_key_exists($name, $this->_entries)){
                unset($this->_entries[$name]);
            }
        }/* }}} */

        /**
         * Gets an Item from the ItemList using it's name
         *
         * @param string $name The name of the item
         * @return object Math\StatIndex\Item|null A valid object if it exists, null otherwise
         * @access public
         */
        public function getItem($name) {/* {{{ */
            if (array_key_exists($name, $this->_entries)){
                return $this->_entries[$name];
            } else {
                return null;
            }
        }/* }}} */

        /**
         * Returns the list of items as an array of Math\StatIndex\Item
         *
         * @return array of Math\StatIndex\Item objects
         * @access public
         */
        public function getItems() {/* {{{ */
            return $this->_entries;
        }/* }}} */

        /**
         * Returns the an array with the names/keys for the items
         *
         * @return array of strings
         * @access public
         */
        public function getItemsNames() {/* {{{ */
            return array_keys($this->_entries);
        }/* }}} */

        /**
         * Returns the number of items in the list
         *
         * @return numeric size of the item list
         * @access public
         */
        public function size() {/* {{{ */
            return count($this->_entries);
        }/* }}} */

        /**
         * Returns an \ArrayIterator of the ItemList
         *
         * @return object \ArrayIterator
         * @access public
         */
        public getIterator() {/* {{{ */
            return new \ArrayIterator(this->_entries);
        }/* }}} */

        /**
         * Builds a list from an array of arrays
         *
         * @param array of array with the items data
         * @return Math\StatIndex\ItemList
         * @static
         * @access public
         */
        public static function &fromArray(array $items) {/* {{{ */
            $list = new ItemList();
            foreach ($items as $name=>$item) {
                if (!is_array($item)) {
                    throw new \
                }
                $importance = (isset($item['importance'])) ? $item['importance'] : 1;
                $list->addItem(new Item($name, $item['value'], $item['quantity'], $importance));
            }
            return $list;
        }/* }}} */

    }/* }}} */

}/* }}} */
?>
