<?php
$img = $_POST["url"];	
$img_name = substr($img_name, strrpos("/", $img_name));
echo $img_name;
//header("content-disposition: attachment; filename='$img_name'");
//header("content-type: image/jpeg");

//readfile($img); 
?>