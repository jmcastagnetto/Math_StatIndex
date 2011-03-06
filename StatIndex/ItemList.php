<?php

    require_once 'PEAR.php';
    //require_once 'Math/StatIndex/Item.php';
    require_once 'Item.php';

    class Math_StatIndex_ItemList {

        var $_entries;

        function Math_StatIndex_ItemList() {
            $this->_entries = array();
        }

        /**
         * @static
         */
        function &fromArray($items) {
            $list = new Math_StatIndex_ItemList();
            foreach ($items as $name=>$item) {
                $importance = (isset($item['importance'])) ? $item['importance'] : 1;
                $list->addItem(new Math_StatIndex_Item($name, $item['value'], $item['quantity'], $importance));
            }
            return $list;
        }

        function addItem($item) {
            if (!is_a($item, 'Math_StatIndex_Item')){
                return PEAR::raiseError('Incorrect parameter type, expecting a Math_StatIndex_Item object');
            }
            $this->_entries[$item->getName()] = $item;
        }

        function removeItem($name) {
            if (!is_a($item, 'Math_StatIndex_Item')){
                return PEAR::raiseError('Incorrect parameter type, expecting a Math_StatIndex_Item object');
            }
            unset($this->_entries[$name]);
        }

        function getItem($name) {
            return $this->_entries[$name];
        }

        function getItems() {
            return $this->_entries;
        }

        function getItemsNames() {
            return array_keys($this->_entries);
        }

        function size() {
            return count($this->_entries);
        }
    }

?>
