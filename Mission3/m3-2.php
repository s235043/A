<?php
// CSV ファイル名
$filename = 'member.csv';
// member.csv を読み込む
$fp = fopen($filename, 'r');

// ループ前：テーブルタグを作成し、テーブルヘッダーで見出しを作る
echo '<table border="1">
      <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Mail</th>
      <th>Password</th>
      </tr>';
 
// ループ：while 文で CSV ファイルのデータを 1 つずつ繰り返し読み込む
while($data = fgetcsv($fp)){
  // テーブルセルに配列の値を格納
  echo '<tr>';
  echo '<td>'.$data[0].'</td>';
  echo '<td>'.$data[1].'</td>';
  echo '<td>'.$data[2].'</td>';
  echo '<td>'.$data[3].'</td>';
  echo '</tr>';
}
 
// ループ後：テーブルの閉じタグを付ける
echo '</table>';

// ファイルを閉じる
fclose($fp);
?>