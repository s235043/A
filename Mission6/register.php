<?php
session_start();
require_once 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'ユーザー名とパスワードを入力してください。';
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $error = 'このユーザー名は既に使用されています。';
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashed_password]);
            header('Location: login.php?status=success');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>ユーザー登録</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo h($error); ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="ユーザー名" required>
            <input type="password" name="password" placeholder="パスワード" required>
            <button type="submit">登録</button>
        </form>
        <p><a href="login.php">ログインはこちら</a></p>
    </div>
</body>
</html>