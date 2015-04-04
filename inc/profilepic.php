<?php
include("session.php");
include("functions.php");

function is_ani($filename) {
    if(!($fh = @fopen($filename, 'rb')))
        return false;
    $count = 0;
    //an animated gif contains multiple "frames", with each frame having a
    //header made up of:
    // * a static 4-byte sequence (\x00\x21\xF9\x04)
    // * 4 variable bytes
    // * a static 2-byte sequence (\x00\x2C)

    // We read through the file til we reach the end of the file, or we've found
    // at least 2 frame headers
    while(!feof($fh) && $count < 2) {
        $chunk = fread($fh, 1024 * 100); //read 100kb at a time
        $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00\x2C#s', $chunk, $matches);
    }

    fclose($fh);
    return $count > 1;
}


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
if(is_ani($_FILES['upload_img']['tmp_name']))
{
	$url="../pic/user/". $_SESSION["id"] .".gif";
	move_uploaded_file($_FILES['upload_img']['tmp_name'], $url);
}
else
{
	$url="../pic/user/". $_SESSION["id"] .".png";
	imagepng($im,$url);
}
$_SESSION["hiba"]=ok("Sikeres kép feltöltés!");
header("Location: ../beallitas.php");
}

}}

}else{
header("Location: ../index.php");
}
?>
