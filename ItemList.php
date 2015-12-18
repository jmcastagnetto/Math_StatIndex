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
     *
     * @param array $items
     *
     * @return \Math\StatIndex\ItemList
     */
    public static function fromArray(array $items) {
        $list = new ItemList();
        foreach ($items as $name => $item) {
            $importance = (isset($item['importance'])) ? floatval($item['importance']) : 1.0;
            $list->addItem(new Item((string) $name, $item['value'], $item['quantity'], $importance));
        }
        return $list;
    }

    /**
     * @param \Math\StatIndex\Item $item
     */
    public function addItem(Item $item) {
        $this->_entries[$item->getName()] = $item;
    }

    /**
     * @param string $name
     */
    public function removeItem(string $name) {
        unset($this->_entries[$name]);
    }

    /**
     * @param \Math\StatIndex\string|string $name
     *
     * @return \Math\StatIndex\Item|mixed
     */
    public function getItem(string $name):Item {
        return $this->_entries[$name];
    }

    /**
     * @return array
     */
    public function getItems():array {
        return $this->_entries;
    }

    /**
     * @return array
     */
    public function getItemsNames():array {
        return array_keys($this->_entries);
    }

    /**
     * @return int|\Math\StatIndex\int
     */
    public function size():int {
        return count($this->_entries);
    }
}
