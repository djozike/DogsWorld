<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$hazase=mysql_query("SELECT * FROM hazassag WHERE hazassag_ferj = '". $_SESSION[id] ."' or hazassag_feleseg = '". $_SESSION[id] ."'");
if(mysql_num_rows($hazase)>0){
$vanekolyok=mysql_query("SELECT * FROM kolyok WHERE kolyok_apa = '". $_SESSION[id] ."' or kolyok_anya = '". $_SESSION[id] ."'");
if(mysql_num_rows($vanekolyok)>0){
header("Location: ../index.php");
}else{
while($hazas=mysql_fetch_object($hazase)){
if(rand(1,2)==1){
$tulaj=$hazas->hazassag_feleseg;
}else{
$tulaj=$hazas->hazassag_ferj;
}
$nem=rand(1,2);
mysql_query("INSERT INTO kolyok VALUES ('','". $hazas->hazassag_feleseg ."','". $hazas->hazassag_ferj ."', '". $ma ."', '". $_SESSION[id] ."', '". $tulaj ."', '". $nem ."')");
header("Location: ../kutyam.php");
}
}
}else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
