<?php
include("session.php");
include("functions.php");
if(isset($_SESSION['id']) && ($_FILES['upload_img'])){

if (!is_uploaded_file( $_FILES['upload_img']['tmp_name'] )){
$_SESSION["hiba"]=hiba("Ismeretlen hiba!");
  header("Location: ../beallitas.php");
}else{
if (!in_array($_FILES['upload_img']['type'],array('image/jpeg','image/gif','image/png' ,'image/pjpeg'))){
$_SESSION["hiba"]=hiba("Nem megfelelõ file formátum!");
   header("Location: ../beallitas.php");
}else{
if ($_FILES['upload_img']['size']>256*1024){
$_SESSION["hiba"]=hiba("Túl nagy méretû kép!");
  header("Location: ../beallitas.php");
}else{
switch($_FILES['upload_img']['type']){
  case 'image/jpeg': $im = imagecreatefromjpeg ($_FILES['upload_img']['tmp_name']); break;
  case 'image/pjpeg': $im = imagecreatefromjpeg ($_FILES['upload_img']['tmp_name']); break;
  case 'image/gif': $im = imagecreatefromgif ($_FILES['upload_img']['tmp_name']); break;
  case 'image/png': $im = imagecreatefrompng ($_FILES['upload_img']['tmp_name']); break;
}
$url="../pic/user/". $_SESSION["id"] .".png";
imagepng($im,$url);
$_SESSION["hiba"]=ok("Sikeres kép feltöltés!");
header("Location: ../beallitas.php");
}

}}

}else{
header("Location: ../index.php");
}
?>
