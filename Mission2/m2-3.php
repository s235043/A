<?php
    $filename = "mission_2-3.txt";
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["comment"])) {
        
        $comment = $_POST["comment"];
        
        $fp = fopen($filename, "a");
        fwrite($fp, $comment . PHP_EOL);
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
        <title>Mission 2-3</title>
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