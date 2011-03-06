<?php
    // http://mathworld.wolfram.com/IndexNumber.html

    require_once 'PEAR.php';
    require_once './StatIndex/Item.php';
    require_once './StatIndex/ItemList.php';

    class Math_StatIndex {

        var $_currList;
        var $_refList;
        var $_indexes;
        var $_itemNames;
        var $_validData = false;

        function Math_StatIndex($current, $reference) {
            $this->setCurrentAndReferenceData($current, $reference);
        }

        function setData($current, $reference) {
            return $this->setCurrentAndReferenceData($current, $reference);
        }

        function setCurrentAndReferenceData($current, $reference) {
 
            if (!is_a($current, 'Math_StatIndex_ItemList')) {
                return PEAR::raiseError('Invalid parameter, expecting a '
                                .'Math_StatIndex_ItemList object with current data.');
            }
            if (!is_a($reference, 'Math_StatIndex_ItemList')) {
                return PEAR::raiseError('Invalid parameter, expecting a '
                                .'Math_StatIndex_ItemList object with reference data.');
            }

            // validate lists
            $sizeCheck = ($current->size() == $reference->size());
            $diff = array_diff($current->getItemsNames(), $reference->getItemsNames());
            $namesCheck = empty($diff);
            $valid = $sizeCheck && $namesCheck;
            if ($valid == false) {
                return PEAR::raiseError('Inconsistent input paramaters');
            }

            // if all went well so far...
            $this->_indexes = array();
            $this->_currList = $current;
            $this->_itemNames = $current->getItemsNames();
            $this->_refList = $reference;
            $this->_validData = true;
            
            return true;
        }

        function mitchellIndex() {
            if (!$this->_validData) {
                return PEAR::raiseError('Inconsistent current and reference data, cannot compute index');
            }
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
                    return PEAR::raiseError('Division by zero');
                }
                $this->_indexes['mitchell'] = ($numeratorSum/$denominatorSum);
            }
            return $this->_indexes['mitchell'];
        }

        function paascheIndex() {
            if (!$this->_validData) {
                return PEAR::raiseError('Inconsistent current and reference data, cannot compute index');
            }
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
                    return PEAR::raiseError('Division by zero');
                }
                $this->_indexes['paasche'] = ($numeratorSum/$denominatorSum);
            }
            return $this->_indexes['paasche'];
        }

        function laspeyresIndex() {
            if (!$this->_validData) {
                return PEAR::raiseError('Inconsistent current and reference data, cannot compute index');
            }
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
                    return PEAR::raiseError('Division by zero');
                }
                $this->_indexes['laspeyres'] = ($numeratorSum/$denominatorSum);
            }
            return $this->_indexes['laspeyres'];
        }

        function bowleyIndex() {
            if (!$this->_validData) {
                return PEAR::raiseError('Inconsistent current and reference data, cannot compute index');
            }
            if (!isset($this->_indexes['bowley'])) {
                $this->_indexes['bowley'] = 0.5 * ($this->paascheIndex() + $this->laspeyresIndex());
            }
            return $this->_indexes['bowley'];
        }

        function fisherIndex() {
            if (!$this->_validData) {
                return PEAR::raiseError('Inconsistent current and reference data, cannot compute index');
            }
            if (!isset($this->_indexes['fisher'])) {
                $this->_indexes['fisher'] = sqrt($this->paascheIndex() * $this->laspeyresIndex());
            }
            return $this->_indexes['fisher'];
        }

        function marshallEdgeworthIndex() {
            if (!$this->_validData) {
                return PEAR::raiseError('Inconsistent current and reference data, cannot compute index');
            }
            if (!isset($this->_indexes['marshall-edgeworth'])) {
                $numeratorSum = 0;
                $denominatorSum = 0;
                foreach ($this->_itemNames as $name) {
                    $currItem = $this->_currList->getItem($name);
                    $refItem = $this->_refList->getItem($name);
                    $numeratorSum += $currItem->getValue() * ($currItem->getQuantity() + $refItem->getQuantity());
                    $denominatorSum += ($refItem->getValue() * $refItem->getQuantity()) + 
                               ($currItem->getValue() * $currItem->getQuantity()) ;
                }
                if ($denominatorSum == 0) {
                    return PEAR::raiseError('Division by zero');
                }
                $this->_indexes['marshall-edgeworth'] = ($numeratorSum/$denominatorSum);
            }
            return $this->_indexes['marshall-edgeworth'];
        }

        function walshIndex() {
            if (!$this->_validData) {
                return PEAR::raiseError('Inconsistent current and reference data, cannot compute index');
            }
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
                    return PEAR::raiseError('Division by zero');
                }
                $this->_indexes['walsh'] = ($numeratorSum/$denominatorSum);
            }
            return $this->_indexes['walsh'];
        }

        function harmonicMeanIndex() {
            if (!$this->_validData) {
                return PEAR::raiseError('Inconsistent current and reference data, cannot compute index');
            }
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
                    return PEAR::raiseError('Division by zero');
                }
                $this->_indexes['harmonic-mean'] = ($numeratorSum/$denominatorSum);
            }
            return $this->_indexes['harmonic-mean'];
        }

        function geometricMeanIndex() {
            if (!$this->_validData) {
                return PEAR::raiseError('Inconsistent current and reference data, cannot compute index');
            }
            if (!isset($this->_indexes['geometric-mean'])) {
                $product = 1;
                $inverseExponent = 0;
                foreach ($this->_itemNames as $name) {
                    $currItem = $this->_currList->getItem($name);
                    $refItem = $this->_refList->getItem($name);
                    $refTotal = $refItem->getValue() * $refItem->getQuantity();
                    $product *= pow(($currItem->getValue()/$refItem->getValue()), $refTotal);
                    if (is_infinite($product)) {
                        return PEAR::raiseError('Math overflow when computing geometric mean index');
                    }
                    $inverseExponent += $refTotal;
                }
                $this->_indexes['geometric-mean'] = pow($product, 1/$inverseExponent);
            }
            return $this->_indexes['geometric-mean'];
        }

        // prime candidate for PEAR_ErrorStack
        function allIndexes() {
            if (PEAR::isError($ret = $this->mitchellIndex())) {
                return $ret;
            }
            if (PEAR::isError($ret = $this->paascheIndex())){
                return $ret;
            }
            if (PEAR::isError($ret = $this->laspeyresIndex())){
                return $ret;
            }
            if (PEAR::isError($ret = $this->bowleyIndex())){
                return $ret;
            }
            if (PEAR::isError($ret = $this->fisherIndex())){
                return $ret;
            }
            if (PEAR::isError($ret = $this->marshallEdgeworthIndex())){
                return $ret;
            }
            if (PEAR::isError($ret = $this->walshIndex())){
                return $ret;
            }
            if (PEAR::isError($ret = $this->harmonicMeanIndex())){
                return $ret;
            }
            if (PEAR::isError($ret = $this->geometricMeanIndex())){
                return $ret;
            }
            return $this->_indexes;
        }
    }
?>
