<?php
// 元となるデータを配列で用意
$users = [
  [
    'id ' => 1,
    'name' => 'Aさん',
    'email' => 'aaa@a.com',
    'password' => 'aaaaa'
  ],
  [
    'id ' => 2,
    'name' => 'Bさん',
    'email' => 'bbb@b.com',
    'password' => 'bbbbb'
  ],
  [
    'id ' => 3,
    'name' => 'Cさん',
    'email' => 'ccc@c.com',
    'password' => 'ccccc'
  ],
];

// CSV ファイル名
$filename = 'member.csv';
//ファイルを 'w' モードで開く（上書き）
$fp = fopen($filename, 'w');

// foreach でループ
foreach ($users as $line) {
  // csv フォーマットで書き出しする
  fputcsv($fp, $line);
}

//ファイルを閉じる
fclose($fp);

echo "CSVファイル[{$filename}]を新規作成しました。";

?>