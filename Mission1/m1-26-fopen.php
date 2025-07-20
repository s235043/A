<?php
  // ファイル名
  $filename = "m_1-25.txt";
 
  // ファイルを読み込み専用（'r'モード）で開く
  $fp = fopen("m_1-25.txt", "r");
 
  if ($fp) {
    // ファイルの終わりまで1行ずつ読み込む（ループ）
    while ( $line = fgets($fp) ) {
      echo $line . "<br />" ;
    }
    // ファイルを閉じる
    fclose($fp);
  }
?>