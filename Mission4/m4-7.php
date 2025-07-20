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
// bindParam の引数（:name など）は 4-2 でどんな名前のカラムを設定したかで変える必要がある。
$id = 1;  // 変更する投稿番号
$name = "赤坂イチロー";
$comment = "おっはよー！";  // 変更したい名前、変更したいコメントは自分で決めること
$sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id ';
$stmt = $pdo->prepare($sql);
// プレースホルダに変数をあてがう
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
 
// 実行
$stmt->execute();

// $row の添字（[ ]内）は、4-2 で作成したカラムの名称に合わせる必要があります。
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
 
// ループして、取得したデータを表示
foreach ($results as $row) {
  // $row の中にはテーブルのカラム名が入る
  echo $row['id'].',';
  echo $row['name'].',';
  echo $row['comment'].'<br />';
  echo "<hr>";
}

?>