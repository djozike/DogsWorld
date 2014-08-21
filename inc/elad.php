<?php
include("sql.php");
include("functions.php");
include("session.php");
if(isset($_SESSION[id])){
if($_POST[nev]!="" and $_POST[jelszo]!="" and $_POST[ar]>0 and $_POST[ar]<13){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_nev = '". $_POST[nev] ."' and kutya_jelszo = '". $_POST[jelszo] ."'");
if(mysql_num_rows($leker)>0){
while($kutya=mysql_fetch_object($leker)){
$ellenoriz=mysql_query("SELECT * FROM piac WHERE piac_aru = '". $kutya->kutya_id ."'");
if(mysql_num_rows($ellenoriz)>0){
$_SESSION[hiba]=hiba("Ez a kutya már szerepel a piacon!");
header("Location: ../piac.php");
}else{
mysql_query("INSERT INTO piac VALUES ('', '". $_SESSION[id] ."','". $kutya->kutya_id ."', '". $_POST[ar] ."', '". $ma ."')");
$_SESSION[hiba]=ok("Sikeresen elhelyezted ezt a kutyát a piacon!");
header("Location: ../piac.php");
}
}
}else{
$_SESSION[hiba]=hiba("Hibás név vagy jelszó!");
header("Location: ../piac.php");
}
}else{
$_SESSION[hiba]=hiba("Nem adtál meg minden szükséges adatot!");
header("Location: ../piac.php");
}
}else{
header("Location: ../index.php");
}
?>
