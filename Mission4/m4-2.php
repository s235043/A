<?php 
// 記入例；以下は PHP 領域に記載すること。
// 4-2 以降でも毎回接続は必要。
// $dsn の式の中にスペースを入れないこと！

// 【サンプル】
// ・データベース名：tb219876db
// ・ユーザー名：tb-219876
// ・パスワード：ZzYyXxWwVv
// の学生の場合。
 
// DB 接続設定
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
 
// データベース名・ユーザー名・パスワードは、各自の情報で置き換えること

// 4-1 で書いた 「// DB 接続設定」 のコードの下に続けて記載する。
 
$sql = "CREATE TABLE IF NOT EXISTS tbtest_456"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name CHAR(32),"
        . "comment TEXT"
        .");";
 
$stmt = $pdo->query($sql);

?>