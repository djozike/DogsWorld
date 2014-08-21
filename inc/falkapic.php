<?php
include("session.php");
include("functions.php");
if(isset($_SESSION['id']) && ($_FILES['upload_img'])){
$leker=mysql_query("SELECT * from falka WHERE falka_vezeto = '". $_SESSION['id'] ."'");
if(mysql_num_rows($leker)>0){
while($falka=mysql_fetch_object($leker)){
if (!is_uploaded_file( $_FILES['upload_img']['tmp_name'] )){
$_SESSION["hiba"]=hiba("Ismeretlen hiba!<br>");
  header("Location: ../falkabealit.php");
}else{
if (!in_array($_FILES['upload_img']['type'],array('image/jpeg','image/gif','image/png' ,'image/pjpeg'))){
$_SESSION["hiba"]=hiba("Nem megfelelõ file formátum!<br>");
   header("Location: ../falkabealit.php");
}else{
if ($_FILES['upload_img']['size']>56*1024){
$_SESSION["hiba"]=hiba("Túl nagy méretû kép!<br>");
  header("Location: ../falkabealit.php");
}else{
switch($_FILES['upload_img']['type']){
  case 'image/jpeg': $im = imagecreatefromjpeg ($_FILES['upload_img']['tmp_name']); break;
  case 'image/pjpeg': $im = imagecreatefromjpeg ($_FILES['upload_img']['tmp_name']); break;
  case 'image/gif': $im = imagecreatefromgif ($_FILES['upload_img']['tmp_name']); break;
  case 'image/png': $im = imagecreatefrompng ($_FILES['upload_img']['tmp_name']); break;
}
$url="../pic/falka/". $falka->falka_id .".png";
imagepng($im,$url);
$_SESSION["hiba"]=ok("Sikeres kép feltöltés!<br>");
header("Location: ../falkabealit.php");
}

}}
}
}else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
