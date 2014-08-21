<?php
include("sql.php");
include("functions.php");
include("session.php");
if(isset($_SESSION[id]) and $_GET[id]){
$ellenoriz=mysql_query("SELECT * FROM piac WHERE piac_id = '". $_GET[id] ."' and piac_elado <> '". $_SESSION[id] ."'");
if(mysql_num_rows($ellenoriz)>0){
while($elado=mysql_fetch_object($ellenoriz)){
$penzem=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutyam=mysql_fetch_object($penzem)){
if($elado->piac_ar*100>$kutyam->kutya_penz){
$_SESSION[hiba]=hiba("Nincs elég pénzed, hogy megvedd ezt a kutyát!");
header("Location: ../piac.php");
}else{
$kijelenkez=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $elado->piac_aru ."'");
while($logout=mysql_fetch_object($kijelenkez)){
mysql_query("DELETE FROM session WHERE nev = '". $logout->kutya_nev ."'");

$ujjelszo=rand(100000000,999999999);
$levonandopenz=$elado->piac_ar*100;
$jovairandopenz=$elado->piac_ar*80;

$leiras="Szia!<br>Jó hírem van. Sikerült eladnod a <b>". $logout->kutya_nev ."</b> nevû kutyát az érte járó ". penz($jovairandopenz) ." összeget jováírtuk ennél a kutyádnál.";
mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $elado->piac_elado ."', NOW(), 0, 0, 1, 0)");
$leiras="Szia!<br>Megvásároltad a <b>". $logout->kutya_nev ."</b> nevû kutyát az érte járó ". penz($levonandopenz) ." összeget levonttuk tõled. A belépéshez szükséges adatok a következõk:<br>
Név: ". $logout->kutya_nev ."<br>Jelszó:". $ujjelszo ."<br><br>Jó kutyázást!";
mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $_SESSION[id] ."', NOW(), 0, 0, 1, 0)");
mysql_query("UPDATE kutya SET kutya_jelszo = '". $ujjelszo ."', kutya_email = '". $kutyam->kutya_email ."' WHERE kutya_id = '". $elado->piac_aru ."'");
$eladok=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $elado->piac_elado ."'");
while($ujpenzp=mysql_fetch_object($eladok)){
$kellpenz=$ujpenzp->kutya_penz+$jovairandopenz;
mysql_query("UPDATE kutya SET kutya_penz = '". $kellpenz ."' WHERE kutya_id = '". $elado->piac_elado ."'");
}
$eladokk=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($ujpenzm=mysql_fetch_object($eladokk)){
$kellpenzz=$ujpenzm->kutya_penz-$levonandopenz;
mysql_query("UPDATE kutya SET kutya_penz = '". $kellpenzz ."' WHERE kutya_id = '". $_SESSION[id] ."'");
}

mysql_query("DELETE FROM piac WHERE piac_id = '". $elado->piac_id ."'");
$_SESSION[hiba]=ok("Sikeressen megvásároltad a kutyát, levélben megkaptad a jelszavát!");
header("Location: ../piac.php");
}
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
