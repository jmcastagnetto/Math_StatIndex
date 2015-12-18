<?php
// TO DO: change this example
    require_once 'Index.php';

    // made up values
    $currArr = array(
            'pear'   => array('value' => 3.18, 'quantity' => 1),
            'apple'  => array('value' => 2.56, 'quantity' => 3),
            'orange' => array('value' => 2.05, 'quantity' => 2),
            'papaya' => array('value' => 3.89, 'quantity' => 0.8),
            'banana' => array('value' => 1.02, 'quantity' => 5)
        );

    $refArr = array(
            'pear'   => array('value' => 2.12, 'quantity' => 0.9),
            'apple'  => array('value' => 1.89, 'quantity' => 4),
            'orange' => array('value' => 1.67, 'quantity' => 2.1),
            'papaya' => array('value' => 2.15, 'quantity' => 0.2),
            'banana' => array('value' => 0.49, 'quantity' => 4.2)
        );

    $currList =& Math_StatIndex_ItemList::fromArray($currArr);
    $refList =& Math_StatIndex_ItemList::fromArray($refArr);
    $index = new Math_StatIndex($currList, $refList);

    /*
    echo "Mitchell Index: ".$index->mitchellIndex()."\n";
    echo "Paasche Index: ".$index->paascheIndex()."\n";
    */
    print_r($index->allIndexes());
    //var_dump($index);
