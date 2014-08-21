<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
if($_POST[nev]!="" and $_POST[lakhely]!="" and $_POST[leiras]!="" and ($_POST[nem]==1 or $_POST[nem]==2) and ($_POST[suly]>0 and $_POST[suly]<19)){
if(hosszellenorzes($_POST[nev],3,24)==1){
$_SESSION[hiba]=hiba("Nem megfelelõ hosszú név!");
header("Location: ../beallitas.php");
}else{
if(hosszellenorzes($_POST[lakhely],2,32)==1){
$_SESSION[hiba]=hiba("Nem megfelelõ hosszú lakhely!");
header("Location: ../beallitas.php");
}else{
if(checkdate($_POST[honap],$_POST[nap],$_POST[ev])==TRUE){
$ellenoriz=mysql_query("SELECT * FROM adatlap WHERE adatlap_id = '". $_SESSION[id] ."'");
if(mysql_num_rows($ellenoriz)==0){
mysql_query("INSERT INTO adatlap VALUES ('". $_SESSION[id] ."', '1', NOW(), '0', '". $_POST[nev] ."', '". $_POST[lakhely] ."', '". $_POST[nem] ."', '". $_POST[ev] ."-". $_POST[honap] ."-". $_POST[nap] ."', '". $_POST[suly] ."', '". $_POST[magassag] ."', '". $_POST[hajszin] ."', '". $_POST[szemszin] ."', '". $_POST[leiras] ."', '". $_POST[hatterszin] ."')");

$_SESSION[hiba]=ok("Sikeres modósítás!");
header("Location: ../beallitas.php");
}else{
mysql_query("UPDATE adatlap SET adatlap_frissit = NOW(), adatlap_nev = '". $_POST[nev] ."', adatlap_lakhely = '". $_POST[lakhely] ."', adatlap_nem = '". $_POST[nem] ."', adatlap_szulido = '". $_POST[ev] ."-". $_POST[honap] ."-". $_POST[nap] ."', adatlap_suly = '". $_POST[suly] ."', adatlap_magassag = '". $_POST[magassag] ."', adatlap_haj = '". $_POST[hajszin] ."', adatlap_szem = '". $_POST[szemszin] ."', adatlap_leiras = '". $_POST[leiras] ."', adatlap_hatter = '". $_POST[hatterszin] ."' WHERE adatlap_id = '". $_SESSION[id] ."'");
$_SESSION[hiba]=ok("Sikeres modósítás!");
header("Location: ../beallitas.php");
}
}else{
$_SESSION[hiba]=hiba("Nem valós születési dátumot adtál meg!");
header("Location: ../beallitas.php");
}
}
}
}elseif(isset($_GET[aktiv])){
if($_GET[aktiv]==0){
mysql_query("UPDATE adatlap SET adatlap_aktiv = '0' WHERE adatlap_id = '". $_SESSION[id] ."'");
}elseif($_GET[aktiv]==1){
mysql_query("UPDATE adatlap SET adatlap_aktiv = '1' WHERE adatlap_id = '". $_SESSION[id] ."'");
}else{}
header("Location: ../beallitas.php");
}else{
$_SESSION[hiba]=hiba("Nem töltöttél ki minden adatot!");
header("Location: ../beallitas.php");
}
}else{
header("Location: ../index.php");
}
?>
