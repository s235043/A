<?php
    $filename = "m3-4.csv";

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
        <title>Mission 3-4</title>
    </head>
    <body>
    
        <h1>簡易掲示板</h1>
    
        <form action="" method="post">
            <input type="text" name="name" placeholder="名前">
            <input type="text" name="comment" placeholder="コメント">
            <input type="submit" name="submit" value="送信">
        </form>
    
        <hr>
    
        <h2>投稿一覧</h2>
        <?php
        if (file_exists($filename)) {
            $fp = fopen($filename, "r");
    
            while ($data = fgetcsv($fp)) {
                $postNum = htmlspecialchars($data[0], ENT_QUOTES, 'UTF-8');
                $name = htmlspecialchars($data[1], ENT_QUOTES, 'UTF-8');
                $comment = htmlspecialchars($data[2], ENT_QUOTES, 'UTF-8');
                $date = htmlspecialchars($data[3], ENT_QUOTES, 'UTF-8');
    
                echo "<div>";
                echo "<strong>{$postNum}. {$name}</strong> ({$date})<br>";
                echo "<span>{$comment}</span>";
                echo "</div><hr>";
            }
    
            fclose($fp);
        }
        ?>
    
    </body>
</html>