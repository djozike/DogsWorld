<?php
include("inc/session.php");
if(isset($_GET[size])){
$meret=$_GET[size];
}else{
$meret=200;
}
if(isset($_SESSION["nev"]) && ($_GET["id"])){
header("Content-type: image/png");
$kep = imagecreatefrompng("pic/user/". $_GET["id"] .".png");
list($width, $height) = getimagesize("pic/user/". $_GET["id"] .".png");
if($width==$meret && $height==$meret)
{
imagegif($kep);
}elseif($width>$meret && $height>$meret)
{
if($width>$height){
$newwidth=$width/($height/$meret);
$newheight=$meret;
$thumb = imagecreatetruecolor($newwidth, $newheight);
$thump = imagecreatetruecolor($meret, $meret);
imagecopyresized($thumb, $kep, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
imagecopy($thump,$thumb,0,0,($newwidth/2)-($meret/2),0,$newwidth,$meret);
imagegif($thump);

}elseif($width<$height){
$newwidth=$meret;
$newheight=$height/($width/$meret);
$thumb = imagecreatetruecolor($newwidth, $newheight);
$thump = imagecreatetruecolor($meret, $meret);
imagecopyresized($thumb, $kep, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
imagecopy($thump,$thumb,0,0,0,($newheight/2)-($meret/2),$meret,$newheight);
imagegif($thump);
}else{
$newwidth=$meret;
$newheight=$meret;
$thumb = imagecreatetruecolor($newwidth, $newheight);
imagecopyresized($thumb, $kep, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
imagegif($thumb);
}
}else{
///itt tartunk
if($width>$height){
$newwidth=$width/($height/$meret);
$newheight=$meret;
$thumb = imagecreatetruecolor($newwidth, $newheight);
$thump = imagecreatetruecolor($meret, $meret);
imagecopyresized($thumb, $kep, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
imagecopy($thump,$thumb,0,0,($newwidth/2)-($meret/2),0,$newwidth,$meret);
imagegif($thump);
}elseif($width<$height){
$newwidth=$meret;
$newheight=$height/($width/$meret);
$thumb = imagecreatetruecolor($newwidth, $newheight);
$thump = imagecreatetruecolor($meret, $meret);
imagecopyresized($thumb, $kep, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
imagecopy($thump,$thumb,0,0,0,($newheight/2)-($meret/2),$meret,$newheight);
imagegif($thump);
}else{
$newwidth=$meret;
$newheight=$meret;
$thumb = imagecreatetruecolor($newwidth, $newheight);
imagecopyresized($thumb, $kep, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
imagepng($thumb);
}

}


}else{
header("Location: index.php");
}
?>
