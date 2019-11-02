<?php
 require_once "config.php";
 function gdVersion() {
  $gdv=@gd_info();
  $ver=$gdv['GD Version'];
  $v=0;
  if (preg_match(
   "/.*([0-9]+)\.([0-9]+)\.([0-9]+).*/", 
   $ver, $r)) $v=$r[1];  
  return $v;
 }

 function get_new_size ($width, $height, $max_width, $max_height) {
  $w=$width; $h=$height;
  $dw=$max_width/$width; 
  $dh=$max_height/$height;
  if ($width>$max_width and 
      $height>$max_height) {
   if ($dw<$dh) { $w=$max_width; $h=floor($height*$dw); 
   }
   else { 
    $h=$max_height; $w=floor($width*$dh); 
   }  
  }
  else if ($width>$max_width and 
           $height<=$max_height) {
   $w=$max_width; $h=floor($height*$dw);
  }
  else if ($width<=$max_width and 
           $height>$max_height) {
   $h=$max_height; $w=floor($width*$dh);
  }
  return array ($w, $h);
 }

 function tumbmaker ($src, $dest, $width, $height, $rgb=0xFFFFFF, $quality=65) {
  if (!file_exists($src)) return false;
  $size = getimagesize($src);
  if ($size === false) return false;
  $format = 
    strtolower(substr($size['mime'], 
    strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) 
   return false;
  $x_ratio = $width / $size[0];
  $y_ratio = $height / $size[1];
  $ratio = min($x_ratio, $y_ratio);
  $use_x_ratio = ($x_ratio == $ratio);
  $new_width = $use_x_ratio ? $width : 
       floor($size[0] * $ratio);
  $new_height = !$use_x_ratio ? $height : 
       floor($size[1] * $ratio);
  $new_left = $use_x_ratio ? 0 : 
       floor(($width - $new_width) / 2);
  $new_top = !$use_x_ratio ? 0 : 
       floor(($height - $new_height) / 2);
  $isrc = $icfunc($src);
  $idest = imagecreatetruecolor
                        ($width, $height);
  imagefill ($idest, 0, 0, $rgb);
  imagecopyresampled ($idest, $isrc, 
   $new_left, $new_top, 0, 0,$new_width, 
   $new_height, $size[0], $size[1]);
  imagejpeg($idest, $dest, $quality);
  imagedestroy($isrc);
  imagedestroy($idest);
  return true;
 }

 function let_to_num($v){ 
  $l = substr($v, -1);
  $ret = substr($v, 0, -1);
  switch(strtoupper($l)){
   case 'P': $ret *= 1024;
   case 'T': $ret *= 1024;
   case 'G': $ret *= 1024;
   case 'M': $ret *= 1024;
   case 'K': $ret *= 1024;
   break;
  }
  return $ret;
 }

 function cyr2lat ($text) {
 $cyr2lat_replacements = array (
"А"=>"a","Б"=>"b","В"=>"v","Г"=>"g","Д"=>"d",
"Е"=>"e","Ё"=>"yo","Ж"=>"dg","З"=>"z","И"=>"i",
"Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
"О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
"У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
"Ш"=>"sh","Щ"=>"csh","Ъ"=>"","Ы"=>"i","Ь"=>"",
"Э"=>"e","Ю"=>"yu","Я"=>"ya",
"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
"е"=>"e","ё"=>"yo","ж"=>"dg","з"=>"z","и"=>"i",
"й"=>"y","к"=>"k","л"=>"l","м"=>"m","н"=>"n",
"о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
"у"=>"u","ф"=>"f","х"=>"h","ц"=>"ts","ч"=>"ch",
"ш"=>"sh","щ"=>"sch","ъ"=>"","ы"=>"i","ь"=>"",
"э"=>"e","ю"=>"yu","я"=>"ya",
"-"=>"_"," "=>"_" );
 return strtr ($text, $cyr2lat_replacements);
 }
?>