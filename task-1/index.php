<?php
 $a=file('file.txt');
 $n=1;
 foreach ($a as $line) 
  echo $n++.'. '.$line.'<br>';
?>
