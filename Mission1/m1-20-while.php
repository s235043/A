<?php
    $items = array("Ken", "Alice", "Judy", "BOSS", "Bob");
    
    $i = 0;
    $count = count($items);
    
    while ($i < $count) {
        $item = $items[$i];
        echo $item ." is at work.<br />";
        
        $i++;
    }
?>