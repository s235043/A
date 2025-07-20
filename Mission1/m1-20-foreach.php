<?php
    $items = array("Ken", "Alice", "Judy", "BOSS", "Bob");
    
    foreach ($items as $item){
        if ($item == "BOSS"){
            echo "Good morning $item!<br />";
        }else{
            echo "Hi! $item<br />";
        }
    }
?>