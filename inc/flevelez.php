<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$falkakell=mysql_query("SELECT * FROM falka WHERE falka_vezeto = '". $_SESSION[id] ."' or falka_vezetohelyettes = '". $_SESSION[id] ."'");
if(mysql_num_rows($falkakell)>0){
while($falka=mysql_fetch_object($falkakell)){
$jogok=explode('|',$falka->falka_jogok);
if(($falka->falka_vezeto == $_SESSION[id]) or ($falka->falka_vezetohelyettes==$_SESSION[id] and $jogok[1]==1)){

if($_POST[uzenet]!=""){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_falka = '". $falka->falka_id ."'");
while($kellid=mysql_fetch_object($leker)){
if($kellid->kutya_falkakorlevel==0){
if($kellid->kutya_id==$_SESSION[id]){
}else{

$tilto=mysql_query("SELECT * FROM tilto WHERE tilto_tiltott = '". $_SESSION[id] ."' and tilto_tilto = '". $kellid->kutya_id ."'");
if(mysql_num_rows($tilto)>0){
}else{
$tartalom=str_replace("<","&lt;",$_POST[uzenet]);
$tartalom=str_replace("[center]","<center>",$tartalom);
$tartalom=str_replace("[/center]","</center>",$tartalom);
$tartalom=str_replace("[color=","<font color=",$tartalom);
$tartalom=str_replace("[/color]","</font>",$tartalom);
$tartalom=str_replace("[img]","<img src=",$tartalom);
$tartalom=str_replace("[/img]",">",$tartalom);
$tartalom=str_replace("]",">",$tartalom);


mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $tartalom ."', '". $_SESSION[id] ."', '". $kellid->kutya_id ."', NOW(), 0, 0, 0, 0)");
}

}
}
}
$_SESSION[hiba]="<br>". ok("Sikeres kézbesítés!");
header("Location: ../falkalevel.php");
}else{
$_SESSION[hiba]="<br>". hiba("Nem adtál meg minden szükséges adatot!");
header("Location: ../falkalevel.php");
}
}
}
}else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
