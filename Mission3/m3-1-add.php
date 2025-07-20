<?php
// 元となるデータを配列で用意（1 件）
$user = [
  'id ' => 4,
  'name' => 'Dさん',
  'email' => 'ddd@d.com',
  'password' => 'ddddd'
];

// CSV ファイル名
$filename = 'member.csv';
//ファイルを 'a' モードで開く（追記）
$fp = fopen($filename, 'a');

// csv フォーマットで書き出しする
fputcsv($fp, $user);

//ファイルを閉じる
fclose($fp);

echo "CSVファイル[{$filename}]にデータを追記しました。";

?>