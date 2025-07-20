<?php
  // ファイル名
  $filename = "m_1-25.txt";
 
  // ファイルが存在すれば実行
  if (file_exists($filename)) {
    // ファイルの内容を、変数 $lines に1行1要素の配列として定義
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
 
    // 配列の内容でループ
    foreach($lines as $line){
      echo $line . "<br />";
    }
  }
?>