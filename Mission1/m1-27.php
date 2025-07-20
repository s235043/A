<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_1-27</title>
    </head>
    <body>
        <form action="" method="post">
            <input type="number" name="num" placeholder="数字を入力してください">
            <input type="submit" name="submit" value="送信">
        </form>
    
        <?php
        $filename = "FizzBuzz.txt";
    
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["num"])) {
            $num = $_POST["num"];
    
            $fp = fopen($filename, "a");
            fwrite($fp, $num . PHP_EOL);
            fclose($fp);
    
            echo "<p>書き込み成功！</p><hr>";
        }
    
        if (file_exists($filename)) {
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
    
            echo "<h2>表示結果</h2>";
            foreach ($lines as $line) {
                $number = intval($line);
                if ($number == 0 && $line !== "0") {
                    continue;
                }
    
                if ($number % 3 == 0 && $number % 5 == 0) {
                    echo "FizzBuzz<br>";
                } elseif ($number % 3 == 0) {
                    echo "Fizz<br>";
                } elseif ($number % 5 == 0) {
                    echo "Buzz<br>";
                } else {
                    echo $number . "<br>";
                }
            }
        }
        ?>
    </body>
</html>