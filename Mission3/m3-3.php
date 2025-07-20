<?php
    $filename = "m3-3.csv";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["name"]) && !empty($_POST["comment"])) {

        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $date = date("Y/m/d H:i:s");

        if (file_exists($filename)) {
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
            $postNum = count($lines) + 1;
        } else {
            $postNum = 1;
        }

        $newData = [$postNum, $name, $comment, $date];

        $fp = fopen($filename, "a");

        fputcsv($fp, $newData);

        fclose($fp);
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Mission 3-3</title>
    </head>
    <body>
    
        <h1>簡易掲示板</h1>
    
        <form action="" method="post">
            <input type="text" name="name" placeholder="名前">
            <input type="text" name="comment" placeholder="コメント">
            <input type="submit" name="submit" value="送信">
        </form>
    
    </body>
</html>