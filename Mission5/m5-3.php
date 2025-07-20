<?php
    $dsn = 'mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザ名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $edit_id = '';
    $edit_name = '';
    $edit_comment = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["delete_submit"])) {
            if (!empty($_POST["delete_id"])) {
                $delete_id = $_POST["delete_id"];
                $sql = 'DELETE FROM tbtest_m5 WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
                $stmt->execute();
            }
  
        } elseif (isset($_POST["edit_submit"])) {
            if (!empty($_POST["edit_id"])) {
                $edit_id_to_load = $_POST["edit_id"];
                $sql = 'SELECT * FROM tbtest_m5 WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $edit_id_to_load, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch();
                
                if ($result) {
                    $edit_id = $result['id'];
                    $edit_name = $result['name'];
                    $edit_comment = $result['comment'];
                }
            }

        } elseif (isset($_POST["post_submit"])) {
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $edit_post_id = $_POST["edit_post_id"];

            if (!empty($edit_post_id)) {
                $date = date("Y/m/d H:i:s");
                $sql = 'UPDATE tbtest_m5 SET name=:name, comment=:comment, date=:date WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':id', $edit_post_id, PDO::PARAM_INT);
                $stmt->execute();

            } else {
                $date = date("Y/m/d H:i:s");
                $sql = $pdo->prepare("INSERT INTO tbtest_m5 (name, comment, date) VALUES (:name, :comment, :date)");
                $sql->bindParam(':name', $name, PDO::PARAM_STR);
                $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql->bindParam(':date', $date, PDO::PARAM_STR);
                $sql->execute();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Mission 5-3</title>
    </head>
    <body>
        <h1>掲示板</h1>

        <form action="" method="post">
            <input type="hidden" name="edit_post_id" value="<?php echo htmlspecialchars($edit_id); ?>">
            <input type="text" name="name" placeholder="名前" value="<?php echo htmlspecialchars($edit_name); ?>" required>
            <input type="text" name="comment" placeholder="コメント" value="<?php echo htmlspecialchars($edit_comment); ?>" required>
            <input type="submit" name="post_submit" value="送信">
        </form>
        
        <hr>

        <form action="" method="post">
            <input type="number" name="delete_id" placeholder="削除対象番号">
            <input type="submit" name="delete_submit" value="削除">
        </form>

        <hr>

        <form action="" method="post">
            <input type="number" name="edit_id" placeholder="編集対象番号">
            <input type="submit" name="edit_submit" value="編集">
        </form>

        <hr>
        
        <h2>投稿一覧</h2>
        <?php
        $sql = 'SELECT * FROM tbtest_m5';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();

        foreach ($results as $row) {
            echo "<div>";
            echo "<strong>" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ". ";
            echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</strong>";
            echo " (" . htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8') . ")<br>";
            echo "<p style='margin-left: 1em;'>" . nl2br(htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8')) . "</p>";
            echo "</div><hr>";
        }
        ?>
    </body>
</html>