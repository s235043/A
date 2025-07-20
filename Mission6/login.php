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
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'ユーザー名またはパスワードが違います。';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>チームタスク掲示板</h1>
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <p class="success">ユーザー登録が完了しました。ログインしてください。</p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="error"><?php echo h($error); ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="ユーザー名" required>
            <input type="password" name="password" placeholder="パスワード" required>
            <button type="submit">ログイン</button>
        </form>
        <p><a href="register.php">新規登録はこちら</a></p>
    </div>
</body>
</html>