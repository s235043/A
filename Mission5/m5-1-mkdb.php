<?php 
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = "CREATE TABLE IF NOT EXISTS tbtest_m5"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name CHAR(32),"
        . "comment TEXT,"
        . "date DATETIME"
        .");";
 
$stmt = $pdo->query($sql);

?>