<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if($kutya->kutya_falka==0){
if($_POST[nev]!=""){
if($kutya->kutya_penz<$FALKAALAPIT){
$_SESSION[hiba]=hiba("<br>Nincs elég pénzed!");
header("Location: ../falkaalapit.php");
}else{
if(hosszellenorzes($_POST[nev],3,40)==1){
$_SESSION[hiba]=hiba("Nem megfelelõ hosszú név!");
header("Location: ../falkaalapit.php");
}else{
$leker2=mysql_query("SELECT * FROM falka WHERE falka_nev = '". $_POST[nev] ."'");
if(mysql_num_rows($leker2)>0){
$_SESSION[hiba]=hiba("Már van ilyen nevû falka!");
header("Location: ../falkaalapit.php");
}else{
$newpenz=$kutya->kutya_penz-$FALKAALAPIT;
$pont=$kutya->kutya_egeszseg*$kutya->kutya_kor/100;
mysql_query("INSERT IGNORE INTO falka VALUES('', '". $_POST[nev] ."', '". $ma ."','774411', '". $_SESSION[id] ."', '0', '". $pont ."', '". $_POST[leiras] ."', '". $_POST[hatterszin] ."', '". $_POST[hatterkep] ."', '1|0|0|0',0)");
$idkell=mysql_query("SELECT * FROM falka WHERE falka_nev = '". $_POST[nev] ."'");
while($falka=mysql_fetch_object($idkell)){
$fid=$falka->falka_id;
}
mysql_query("UPDATE kutya SET kutya_falka = '". $fid ."', kutya_penz = '". $newpenz ."', kutya_falkaido = '". $ma ."' WHERE kutya_id = '". $_SESSION[id] ."'");
header("Location: ../falkaalapit.php");
}}}
}else{
$_SESSION[hiba]=hiba("<br>Nem adtál meg falka nevet!");
header("Location: ../falkaalapit.php");
}
}else{
header("Location: ../falka.php?id=". $kutya->kutya_falka);
}
}
}else{header("Location: ../index.php");}
	?>
