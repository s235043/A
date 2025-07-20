<?php
  $str = "2";
  $filename = "m_1-25.txt";
 
  $fp = fopen($filename,"a");
  fwrite($fp, $str.PHP_EOL);
  fclose($fp);
 
  echo "書き込み成功！";
?>