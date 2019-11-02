<?php
 foreach($params as $num => $var) {
  if (!empty($_POST[$var])) 
   $$var = htmlspecialchars($_POST[$var]);
  else $$var = '';
 }
?>