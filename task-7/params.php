<?php
 while (list($num,$var) = each($params)) {
  if (!empty($_POST[$var])) 
   $$var = htmlspecialchars($_POST[$var]);
  else $$var = '';
 }
?>