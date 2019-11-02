<?php 
unlink( "file.txt" ); // Удаление файла
 rmdir( "folder1/" ); // Удаление директории. Внимание, папка должна быть пустой 
 copy( "from.txt" , "to.txt" ); // Копирование. 
 rename( "old_name.txt" , "new_name.txt" ); // Переименование. 
?>