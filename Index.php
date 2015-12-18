<?php
// http://mathworld.wolfram.com/IndexNumber.html

namespace Math\StatIndex;

    /**
     * Class Index
     * @package Math\StatIndex
     */
/**
 * Class Index
 * @package Math\StatIndex
 */
class Index {

    /**
     * @var
     */
    private $_currList;
    /**
     * @var
     */
    private $_refList;
    /**
     * @var
     */
    private $_indexes;
    /**
     * @var
     */
    private $_itemNames;
    /**
     * @var bool
     */
    private $_validData = false;

    /**
     * StatIndex constructor.
     *
     * @param \Math\StatIndex\ItemList $current
     * @param \Math\StatIndex\ItemList $reference
     */
    public function __construct(ItemList $current,
                                ItemList $reference) {
        $this->setCurrentAndReferenceData($current, $reference);
    }

    /**
     * @param \Math\StatIndex\ItemList $current
     * @param \Math\StatIndex\ItemList $reference
     *
     * @return bool
     * @throws \Math\StatIndex\StatIndexException
     */
    public function setData(ItemList $current,
                            ItemList $reference) {
        return $this->setCurrentAndReferenceData($current, $reference);
    }

    /**
     * @param \Math\StatIndex\ItemList $current
     * @param \Math\StatIndex\ItemList $reference
     *
     * @return bool
     * @throws \Math\StatIndex\StatIndexException
     */
    public function setCurrentAndReferenceData(ItemList $current,
                                               ItemList $reference) {
        // validate lists
        $sizeCheck = ($current->size() === $reference->size());
        $diff = array_diff($current->getItemsNames(), $reference->getItemsNames());
        $namesCheck = empty($diff);

        $this->_validData = $sizeCheck && $namesCheck;
        $this->validData();  // raise an exception if something is amiss
        $this->_indexes = array();
        $this->_currList = $current;
        $this->_itemNames = $current->getItemsNames();
        $this->_refList = $reference;

        return $this->_validData;
    }

    /**
     * @throws \Math\StatIndex\StatIndexException
     */
    private function validData() {
        if (!$this->_validData) {
            throw new StatIndexException('Inconsistent current and reference data, cannot compute index');
        }
    }

    /**
     * @return \Math\StatIndex\float
     * @throws \DivisionByError
     * @throws \Math\StatIndex\StatIndexException
     */
    function mitchellIndex():float {
        $this->validData();
        // estimate the index if it was not calculated previously
        if (!isset($this->_indexes['mitchell'])) {
            $numeratorSum = 0;
            $denominatorSum = 0;
            foreach ($this->_itemNames as $name) {
                $currItem = $this->_currList->getItem($name);
                $refItem = $this->_refList->getItem($name);
                $numeratorSum += $currItem->getValue() * $refItem->getImportance();
                $denominatorSum += $refItem->getValue() * $refItem->getImportance();
            }
            if ($denominatorSum == 0) {
                throw new \DivisionByError('Division by zero while estimating Mitchell\'s Index');
            }
            $this->_indexes['mitchell'] = ($numeratorSum / $denominatorSum);
        }
        return $this->_indexes['mitchell'];
    }

    /**
     * @return \Math\StatIndex\float|mixed
     * @throws \DivisionByError
     * @throws \Math\StatIndex\StatIndexException
     */
    public function paascheIndex():float {
        $this->validData();
        if (!isset($this->_indexes['paasche'])) {
            $numeratorSum = 0;
            $denominatorSum = 0;
            foreach ($this->_itemNames as $name) {
                $currItem = $this->_currList->getItem($name);
                $refItem = $this->_refList->getItem($name);
                $numeratorSum += $currItem->getValue() * $currItem->getQuantity();
                $denominatorSum += $refItem->getValue() * $currItem->getQuantity();
            }
            if ($denominatorSum == 0) {
                throw new \DivisionByError('Division by zero while estimating Paasche\'s Index');
            }
            $this->_indexes['paasche'] = ($numeratorSum / $denominatorSum);
        }
        return $this->_indexes['paasche'];
    }

    /**
     * @return \Math\StatIndex\float|mixed
     * @throws \DivisionByError
     */
    function laspeyresIndex():float {
        $this->validData();
        if (!isset($this->_indexes['laspeyres'])) {
            $numeratorSum = 0;
            $denominatorSum = 0;
            foreach ($this->_itemNames as $name) {
                $currItem = $this->_currList->getItem($name);
                $refItem = $this->_refList->getItem($name);
                $numeratorSum += $currItem->getValue() * $refItem->getQuantity();
                $denominatorSum += $refItem->getValue() * $refItem->getQuantity();
            }
            if ($denominatorSum == 0) {
                throw new \DivisionByError('Division by zero while estimating Laspeyres\' Index');
            }
            $this->_indexes['laspeyres'] = ($numeratorSum / $denominatorSum);
        }
        return $this->_indexes['laspeyres'];
    }

    /**
     * @return mixed
     */
    function bowleyIndex():float {
        $this->validData();
        if (!isset($this->_indexes['bowley'])) {
            $this->_indexes['bowley'] = 0.5 * ($this->paascheIndex() + $this->laspeyresIndex());
        }
        return $this->_indexes['bowley'];
    }

    /**
     * @return mixed
     */
    function fisherIndex():float {
        $this->validData();
        if (!isset($this->_indexes['fisher'])) {
            $this->_indexes['fisher'] = sqrt($this->paascheIndex() * $this->laspeyresIndex());
        }
        return $this->_indexes['fisher'];
    }

    /**
     * @return mixed
     * @throws \DivisionByError
     */
    function marshallEdgeworthIndex() {
        $this->validData();
        if (!isset($this->_indexes['marshall-edgeworth'])) {
            $numeratorSum = 0;
            $denominatorSum = 0;
            foreach ($this->_itemNames as $name) {
                $currItem = $this->_currList->getItem($name);
                $refItem = $this->_refList->getItem($name);
                $numeratorSum += $currItem->getValue() * ($currItem->getQuantity() + $refItem->getQuantity());
                $denominatorSum += ($refItem->getValue() * $refItem->getQuantity()) +
                    ($currItem->getValue() * $currItem->getQuantity());
            }
            if ($denominatorSum == 0) {
                throw new \DivisionByError('Division by zero while estimating Marshall-Edgeworth\'s Index');
            }
            $this->_indexes['marshall-edgeworth'] = ($numeratorSum / $denominatorSum);
        }
        return $this->_indexes['marshall-edgeworth'];
    }

    /**
     * @return mixed
     * @throws \DivisionByError
     */
    function walshIndex() {
        $this->validData();
        if (!isset($this->_indexes['walsh'])) {
            $numeratorSum = 0;
            $denominatorSum = 0;
            foreach ($this->_itemNames as $name) {
                $currItem = $this->_currList->getItem($name);
                $refItem = $this->_refList->getItem($name);
                $factor = sqrt($currItem->getQuantity() * $refItem->getQuantity());
                $numeratorSum += $currItem->getValue() * $factor;
                $denominatorSum += $refItem->getValue() * $factor;
            }
            if ($denominatorSum == 0) {
                throw new \DivisionByError('Division by zero while estimating Walsh\'s Index');
            }
            $this->_indexes['walsh'] = ($numeratorSum / $denominatorSum);
        }
        return $this->_indexes['walsh'];
    }

    /**
     * @return mixed
     * @throws \DivisionByError
     */
    function harmonicMeanIndex() {
        $this->validData();
        if (!isset($this->_indexes['harmonic-mean'])) {
            $numeratorSum = 0;
            $denominatorSum = 0;
            foreach ($this->_itemNames as $name) {
                $currItem = $this->_currList->getItem($name);
                $refItem = $this->_refList->getItem($name);
                $refValue = $refItem->getValue() * $refItem->getQuantity();
                $numeratorSum += $refValue;
                $denominatorSum += ($refItem->getValue() / $currItem->getValue()) * $refValue;
            }
            if ($denominatorSum == 0) {
                throw new \DivisionByError('Division by zero while estimating the Harmonic Mean Index');
            }
            $this->_indexes['harmonic-mean'] = ($numeratorSum / $denominatorSum);
        }
        return $this->_indexes['harmonic-mean'];
    }

    /**
     * @return mixed
     */
    function geometricMeanIndex() {
        $this->validData();
        if (!isset($this->_indexes['geometric-mean'])) {
            $product = 1;
            $inverseExponent = 0;
            foreach ($this->_itemNames as $name) {
                $currItem = $this->_currList->getItem($name);
                $refItem = $this->_refList->getItem($name);
                $refTotal = $refItem->getValue() * $refItem->getQuantity();
                $product *= pow(($currItem->getValue() / $refItem->getValue()), $refTotal);
                if (is_infinite($product)) {
                    throw new \OverflowException('Math overflow when computing geometric mean index');
                }
                $inverseExponent += $refTotal;
            }
            $this->_indexes['geometric-mean'] = pow($product, 1 / $inverseExponent);
        }
        return $this->_indexes['geometric-mean'];
    }

    /**
     * Convenience method to calculate all the indexes from the current and reference data
     *
     * @return array An associative array with all the indexes
     * @throws StatIndexException if the the data is inconsistent
     */
    function allIndexes() {
        // calculate all indexes
        $this->mitchellIndex();
        $this->paascheIndex();
        $this->laspeyresIndex();
        $this->bowleyIndex();
        $this->fisherIndex();
        $this->marshallEdgeworthIndex();
        $this->walshIndex();
        $this->harmonicMeanIndex();
        $this->geometricMeanIndex();

        return $this->_indexes;
    }
}
