<?php
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザ名';
$password = 'パスワード';

try {
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $sql_users = "CREATE TABLE IF NOT EXISTS users ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "username VARCHAR(255) NOT NULL UNIQUE,"
        . "password VARCHAR(255) NOT NULL,"
        . "created_at DATETIME DEFAULT CURRENT_TIMESTAMP"
        . ");";
    
    $pdo->query($sql_users);

    $sql_posts = "CREATE TABLE IF NOT EXISTS posts ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "user_id INT NOT NULL,"
        . "comment TEXT NOT NULL,"
        . "image_name VARCHAR(255),"
        . "password VARCHAR(255) NOT NULL,"
        . "created_at DATETIME DEFAULT CURRENT_TIMESTAMP,"
        . "FOREIGN KEY (user_id) REFERENCES users(id)"
        . ");";

    $pdo->query($sql_posts);

} catch (PDOException $e) {
    exit("データベースエラー: " . $e->getMessage());
}
?>