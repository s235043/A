<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$edit_id = '';
$edit_name = '';
$edit_comment = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['delete_submit'])) {
        if (!empty($_POST['delete_id']) && !empty($_POST['delete_pass'])) {
            $delete_id = $_POST['delete_id'];
            $delete_pass = $_POST['delete_pass'];
            $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
            $stmt->execute([$delete_id, $_SESSION['user_id']]);
            $post = $stmt->fetch();
            if ($post && password_verify($delete_pass, $post['password'])) {
                if ($post['image_name']) {
                    $image_path = 'images/' . $post['image_name'];
                    if (file_exists($image_path)) { unlink($image_path); }
                }
                $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
                $stmt->execute([$delete_id]);
                header('Location: index.php');
                exit;
            } else {
                $error = 'IDが違うか、パスワードが一致しません。';
            }
        } else {
            $error = '削除対象IDとパスワードを入力してください。';
        }
    }
    elseif (isset($_POST['edit_submit'])) {
        if (!empty($_POST['edit_id']) && !empty($_POST['edit_pass'])) {
            $edit_id_to_load = $_POST['edit_id'];
            $edit_pass = $_POST['edit_pass'];
            $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
            $stmt->execute([$edit_id_to_load, $_SESSION['user_id']]);
            $post = $stmt->fetch();
            if ($post && password_verify($edit_pass, $post['password'])) {
                $edit_id = $post['id'];
                $edit_comment = $post['comment'];
            } else {
                $error = 'IDが違うか、パスワードが一致しません。';
            }
        } else {
            $error = '編集対象IDとパスワードを入力してください。';
        }
    }
    elseif (isset($_POST['post_submit'])) {
        $comment = $_POST['comment'];
        $password = $_POST['password'];
        $edit_post_id = $_POST['edit_post_id'];
        $user_id = $_SESSION['user_id'];
        
        if (!empty($comment) && !empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            if (!empty($edit_post_id)) {
                $stmt = $pdo->prepare("UPDATE posts SET comment = ?, password = ? WHERE id = ? AND user_id = ?");
                $stmt->execute([$comment, $hashed_password, $edit_post_id, $user_id]);
            } else {
                $image_name = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                    $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    if (in_array($file_ext, $allowed_extensions)) {
                        $image_name = uniqid('img_', true) . '.' . $file_ext;
                        $destination = 'images/' . $image_name;

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                        } else {
                            $error = 'ファイルのアップロードに失敗しました。imagesディレクトリの権限を確認してください。';
                            $image_name = null;
                        }

                    } else {
                        $error = '許可されていないファイル形式です。';
                    }
                }
                
                if (empty($error)) {
                    $stmt = $pdo->prepare("INSERT INTO posts (user_id, comment, password, image_name) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$user_id, $comment, $hashed_password, $image_name]);
                }
            }
            if(empty($error)) {
                header('Location: index.php');
                exit;
            }
        } else {
            $error = 'コメントとパスワードは必須です。';
        }
    }
}

$posts_stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at ASC");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メイン掲示板</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>チームタスク掲示板</h1>
        <div class="header-info">
            <span>ようこそ、<?php echo h($_SESSION['username']); ?>さん</span>
            <a href="logout.php">ログアウト</a>
        </div>
    </header>
    <div class="container">
        <h2><?php echo $edit_id ? '投稿編集' : '新規投稿'; ?></h2>
        <?php if ($error): ?>
            <p class="error"><?php echo h($error); ?></p>
        <?php endif; ?>
        
        <form action="index.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="edit_post_id" value="<?php echo h($edit_id); ?>">
            <textarea name="comment" rows="4" placeholder="タスクや連絡事項を入力" required><?php echo h($edit_comment); ?></textarea>
            <input type="password" name="password" placeholder="パスワード" required>
            <?php if (!$edit_id): ?>
                <label>画像ファイル (任意):</label>
                <input type="file" name="image">
            <?php endif; ?>
            <button type="submit" name="post_submit"><?php echo $edit_id ? '更新' : '投稿'; ?></button>
        </form>

        <hr>
        <div class="forms-grid">
            <form action="index.php" method="post">
                <h3>投稿削除</h3>
                <input type="number" name="delete_id" placeholder="削除対象ID" required>
                <input type="password" name="delete_pass" placeholder="パスワード" required>
                <button type="submit" name="delete_submit" class="delete-btn">削除</button>
            </form>
            <form action="index.php" method="post">
                <h3>投稿編集</h3>
                <input type="number" name="edit_id" placeholder="編集対象ID" required>
                <input type="password" name="edit_pass" placeholder="パスワード" required>
                <button type="submit" name="edit_submit">編集</button>
            </form>
        </div>
        <hr>

        <h2>投稿一覧</h2>
        <div class="post-list">
            <?php 
            $display_num = 1; 
            foreach ($posts_stmt as $row): 
            ?>
                <div class="post">
                    <p>
                        <strong><?php echo $display_num; ?>. <?php echo h($row['username']); ?></strong> 
                        <span class="post-date">(<?php echo $row['created_at']; ?>)</span>
                        <span class="post-id-display">[投稿ID: <?php echo $row['id']; ?>]</span>
                    </p>
                    <p><?php echo nl2br(h($row['comment'])); ?></p>
                    <?php if ($row['image_name']): ?>
                        <img src="images/<?php echo h($row['image_name']); ?>" alt="投稿画像">
                    <?php endif; ?>
                </div>
            <?php 
            $display_num++;
            endforeach; 
            ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
