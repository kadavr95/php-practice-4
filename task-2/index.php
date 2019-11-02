<?php $f = fopen( "file.txt" , "r" );//открытие файла для чтения 
$text = fread( $f ,filesize("file.txt")); 
fclose($f); $text_towr = "Some Text to write in file\n"; 
$f = fopen( "file.txt" , "w" );//открытие файла для записи 
fwrite( $f , $text_towr . $text ); 
$f_1 = file( "file.txt" );
$n_str = 2; // Какую строчку нужно удалить
array_splice( $f_1 , $n_str , 1 ); 
$f = fopen( "file.txt" , "w" );//открытие файла для записи 
for( $i = 0; $i < count( $f_1 ); $i++ )
{ 
    fwrite( $f , $f_1[$i]  );
} 
fclose($f);
?>