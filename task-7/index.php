<html>
 <head>
  <meta http-equiv="Content-Type" 
   content="text/html; charset=windows-1251">
  <title>Сервис для загрузки файла</title>
 </head>
<body><div align="center">
<?php
 require_once "functions.php";
 $params = array ('ok');
 require_once ("params.php"); 
?>
<form action="index.php" method="post"
  enctype="multipart/form-data">
 <input type="file" name="url">
 <input type="submit" name="ok" 
  value="Загрузить"></form>

<?php
if (empty($ok)) return;
 $error =  $file = ''; 
 $load = true;
 $need_move= true;
 if (isset($_FILES['url']) and !empty($_FILES['url']['tmp_name'])) {
  $file = $_FILES['url']['tmp_name'];
  $file_size = $_FILES['url']['size'];
  $php_max_size = min(let_to_num(ini_get('post_max_size')),
   let_to_num(ini_get('upload_max_filesize')));
  $max_size=min(MAX_SIZE,$php_max_size);
  if ($file_size > $max_size) {
   $error .= '<br>Слишком большой по объёму файл. Ограничение в настройках '.
    ($max_size==MAX_SIZE?'скрипта (config.php)':
    'PHP (см. настройки post_max_size,upload_max_filesize)').
    ': '.$max_size.' байт';
   $load=false;
  }
  if ($_FILES['url']['error']!=UPLOAD_ERR_OK) {
   $error .= '<br>Сервер вернул ошибку закачки файла. Код ошибки: '.
    $_FILES['url']['error'];
   $load=false;
  }
  $path_parts = pathinfo($_FILES['url']['name']);
  $filetype = strtolower($path_parts['extension']);
  $filename = FOLDER.'/'.cyr2lat(strtolower($path_parts['basename']));
  $is_pic = true;
  switch ($filetype) {
   case "jpeg":
   case "jpg": 
   case "gif": 
   case "png": break;
   default:  $is_pic=false;
  }
  if ($is_pic) {
   $size = getimagesize($file);
   $width = $size[0];
   $height = $size[1];
   if ($width>MAX_WIDTH or $height>MAX_HEIGHT) {
    $ver = gdVersion();
    if (USE_GDLIB=='1') {
     if ($ver>1) {
      $new_size = get_new_size($width,$height,MAX_WIDTH,MAX_HEIGHT);
      $r=tumbmaker ($file,$filename,$new_size[0],$new_size[1]);
      if (!$r) {
       $error .= '<br>Не удалось программно уменьшить изображение. 
        Пожалуйста, проверьте работу библиотеки GBLib или загрузите 
        картинку меньшего размера. Установки из настроек сайта: 
        ширина до '.MAX_WIDTH.', высота до '.MAX_HEIGHT.' пикс.';
       $load=false;
      }
      else $need_move=false; 
     }
     else {
      $error .= '<br>В настройках сайта включено масштабирование 
       больших изображений, но библиотека GDLib недоступна. 
       Пожалуйста, настройте её или загрузите картинку меньшего размера. 
       Установки из настроек сайта: ширина до '.MAX_WIDTH.', высота до '.
       MAX_HEIGHT.' пикс.';
      $load=false;
     }
    }
    else {
     $error .= '<br>Превышен максимальный размер рисунка. Установки 
      из настроек сайта: ширина до '.MAX_WIDTH.', высота до '.MAX_HEIGHT.
      ' пикс. Автоматическое масштабирование изображений: выключено';
     $load=false;
    }
   }
  }
  if ($load) {
   if ($need_move) {
    if (move_uploaded_file ($file,$filename)) {
     chmod ($filename,0644);
    }
    else {
     $error .= '<br>Не удалось закачать файл '.$filename.' из временного '.
     $file.'<br>Информация для отладки: ';
     print_r($_FILES);
    }
   }
  }
 }
 else {
  $error .= '<br>Файл не передан.';
  if (!empty($_FILES['url']['error'])) 
   $error .=' Код ошибки: '.$_FILES['url']['error'];
 }
 if (file_exists($file)) @unlink ($file);
 if (!empty($error)) {
  print 'Возникли проблемы!'.$error;
 }
 else {
  print 'Файл загружен, вот он: 
   <a href="'.$filename.'" target="_blank">'.$filename.'</a>';
 }
?>
</div></body>
</html>