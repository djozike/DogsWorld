<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and ($_GET[id])){
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$leker=mysql_query("SELECT * FROM falka WHERE falka_id = '". $_GET[id] ."'");
if(mysql_num_rows($leker)>0){
falkatorol($_GET[id]);
$leiras="Szia!<br>Sajnos a ". idtonev($_SESSION[id]) ." nev� moder�tor t�r�lte a falk�d, val�sz�n�leg valami szab�lyellenes le�r�st k�sz�tett�l. Ha r�szleteket szeretn�l tudni a t�rl�s ok�r�l, �rj a moder�tornak.";
$level=mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $_POST[id] ."', NOW(), 0, 0, 1, 0)");
header("Location: ../falka.php");
}
}
}else{
header("Location: ../index.php");
}
?>
