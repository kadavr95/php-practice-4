<?php 
unlink( "file.txt" ); // Удаление файла
 rmdir( "papka1/" ); // Удаление директории. Внимание, папка должна быть пустой 
 copy( "otkuda.txt" , "kuda.txt" ); // Копирование. 
 rename( "chto.txt" , "vo_chto.txt" ); // Переименование. 

?>