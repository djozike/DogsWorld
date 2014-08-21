<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
$leker2=mysql_query("SELECT * FROM falka WHERE falka_id = '". $kutya->kutya_falka ."'");
while($falka=mysql_fetch_object($leker2)){
if($falka->falka_vezeto==$_SESSION[id]){
if(isset($_GET[nev])){
$leker3=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_GET[nev] ."' and kutya_falka = '". $kutya->kutya_falka ."'");
if(mysql_num_rows($leker3)>0){
if($_GET[nev]==$_SESSION[id]){
$_SESSION[hiba]=hiba("<br>Saját magadnak nem lehetsz a helyettese is!<br>");
header("Location: ../falkabealit.php");
}else{
mysql_query("UPDATE falka SET falka_vezetohelyettes = '". $_GET[nev] ."' WHERE falka_id = '". $falka->falka_id ."'");
$_SESSION[hiba]=ok("<br>Sikeres módosítás!<br>");
header("Location: ../falkabealit.php");
}}else{
header("Location: ../index.php");
}
}elseif($_POST[nev]){
$leker3=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_POST[nev] ."' and kutya_falka = '". $kutya->kutya_falka ."'");
if(mysql_num_rows($leker3)>0){
if($_POST[nev]==$_SESSION[id]){
$_SESSION[hiba]=hiba("<br>Te már most is falkavezér vagy!<br>");
header("Location: ../falkabealit.php");
}else{
if($_POST[nev]==$falka->falka_vezetohelyettes){
mysql_query("UPDATE falka SET falka_vezetohelyettes = '0', falka_vezeto = '". $_POST[nev] ."' WHERE falka_id = '". $falka->falka_id ."'");
header("Location: ../falkabealit.php");
}else{
mysql_query("UPDATE falka SET falka_vezeto = '". $_POST[nev] ."' WHERE falka_id = '". $falka->falka_id ."'");
header("Location: ../falkabealit.php");
}
}
}else{
header("Location: ../index.php");
}
}elseif(isset($_POST[kell])){
if($_POST[falkakepvideo]=="on"){
$falkak=1;
}else{
$falkak=0;
}
mysql_query("UPDATE falka SET falka_kepvideo = '". $falkak ."' WHERE falka_id = '". $falka->falka_id ."'");
$_SESSION[hiba]=ok("Sikeres változtatás!<br>");
header("Location: ../falkabealit.php");

}else{
header("Location: ../index.php");
}
}else{
header("Location: ../falka.php");
}
}
}
}else{
header("Location: ../index.php");
}
?>
