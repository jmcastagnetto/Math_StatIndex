<?php

namespace Math\StatIndex;

/**
 * Class ItemList
 * @package Math\StatIndex
 */
class ItemList {

    /**
     * @var array
     */
    private $_entries = [];

    /**
     * ItemList constructor.
     */
    function __construct() {
        $this->_entries = array();
    }

    /**
     * @static
     */
    public static function fromArray(array $items) {
        $list = new ItemList();
        foreach ($items as $name => $item) {
            $importance = (isset($item['importance'])) ? floatval($item['importance']) : 1.0;
            $list->addItem(new Item($name, $item['value'], $item['quantity'], $importance));
        }
        return $list;
    }

    /**
     * @param \Math\StatIndex\Item $item
     */
    function addItem(Item $item) {
        $this->_entries[$item->getName()] = $item;
    }

    /**
     * @param \Math\StatIndex\Item $name
     */
    function removeItem(Item $name) {
        unset($this->_entries[$name]);
    }

    /**
     * @param \Math\StatIndex\Item $name
     *
     * @return mixed
     */
    function getItem(Item $name) {
        return $this->_entries[$name];
    }

    /**
     * @return array
     */
    function getItems() {
        return $this->_entries;
    }

    /**
     * @return array
     */
    function getItemsNames() {
        return array_keys($this->_entries);
    }

    /**
     * @return int
     */
    function size() {
        return count($this->_entries);
    }
}
