<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["comment"])) {
        
        $comment = $_POST["comment"];
        
        $message = $comment . "を受け付けました";
        
    } else {
        $message = "";
    }
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Mission 2-1</title>
    </head>
    <body>
    
        <form action="" method="post">
            <input type="text" name="comment" placeholder="コメント">
            <input type="submit" value="送信">
        </form>

        <?php 
            echo $message; 
        ?>
        
    </body>
</html>