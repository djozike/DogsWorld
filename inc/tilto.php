<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
if($_POST[nev]!=""){
$leker=mysql_query("SELECT kutya_nev, kutya_id FROM kutya WHERE kutya_nev = '". $_POST[nev] ."'");
if(mysql_num_rows($leker)>0){
while($kutya=mysql_fetch_object($leker)){
if($kutya->kutya_id==$_SESSION[id]){
$_SESSION[hiba]=hiba("Magadat nem tilthatód le!");
header("Location: ../uzenetek.php?page=tilto");
}else{
$leker1=mysql_query("SELECT * FROM tilto WHERE tilto_tiltott = '". $kutya->kutya_id ."' and tilto_tilto = '". $_SESSION[id] ."'");
if(mysql_num_rows($leker1)>0){
$_SESSION[hiba]=hiba("Már szerepel a tiltólistádon ez a név!");
header("Location: ../uzenetek.php?page=tilto");
}else{
mysql_query("INSERT INTO tilto values ('". $_SESSION[id] ."','". $kutya->kutya_id ."')");
$_SESSION[hiba]=ok("Sikeres felvétel!");
header("Location: ../uzenetek.php?page=tilto");
}
}
}
}else{
$_SESSION[hiba]=hiba("Nem létezõ nevet adtál meg!");
header("Location: ../uzenetek.php?page=tilto");
}
}else{
$_SESSION[hiba]=hiba("Nem adtál meg nevet!");
header("Location: ../uzenetek.php?page=tilto");
}
}else{
header("Location: ../index.php");
}
?>