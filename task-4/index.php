<?php
$f_2 = file( "file.txt" ); 
$n_str = 2; // Какую строчку нужно отредактировать 
 $f_2[ $n_str ] = "Новое значение"; 
$f = fopen( "file.txt" , "w" ); 
for( $i = 0; $i < count( $f_2 ); $i++ )
{ 
    fwrite( $f , $f_2[$i]  );
    } 
    fclose($f);
?>