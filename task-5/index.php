<?php
$str_1="Первая строка "; 
echo 'Длина первой строки = '.mb_strlen($str_1).'<br>'; 
$str_2="Вторая строка"; 
echo 'Длина второй строки = '.mb_strlen($str_2).'<br>';
$str_3='строка';// подстрока
$p=mb_strstr($str_1,$str_3);
echo 'поиск подстроки:  '.$p.'<br>';
$sr=strcmp($str_1,$str_2 );// сравнение строк
echo $sr;
?>