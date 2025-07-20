<?php
    $filename = "mission 2.txt";
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["comment"])) {
        
        $comment = $_POST["comment"];
        
        $fp = fopen($filename, "w");
        fwrite($fp, $comment);
        fclose($fp);

        if ($comment == "完成") {
            $message = "おめでとう！";
        } else {
            $message = $comment . " を受け付けました";
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Mission 2-2</title>
    </head>
    <body>
    
        <form action="" method="post">
            <input type="text" name="comment" placeholder="コメント">
            <input type="submit" name="submit" value="送信">
        </form>
    
        <?php 
            if (!empty($message)) {
                echo "<p>" . $message . "</p>";
            }
        ?>
    
    </body>
</html>