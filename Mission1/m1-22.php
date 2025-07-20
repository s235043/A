<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>入力フォームを試す</title>
</head>
<body>
  <form action="" method="post">
      <input type="text" name="str"><!-- テキストボックス -->
      <input type="submit" name="submit"><!-- 送信ボタン -->
  </form>
  <?php
    $str = $_POST["str"];
    echo $str;
  ?>
</body>
</html>