<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
mysql_query("DELETE FROM adatlap WHERE adatlap_id = ". $_GET[id]);
$leiras="Szia!<br>Sajnos a ". idtonev($_SESSION[id]) ." nev� moder�tor t�r�lte az adatlapod, val�sz�n�leg valami szab�lyellenes tartalom volt rajta. Ha r�szleteket szeretn�l tudni a t�rl�s ok�r�l, �rj a moder�tornak.";
$level=mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $_GET[id] ."', NOW(), 0, 0, 1, 0)");

header("Location: ../adatlapok.php");
}else{header("Location: ../index.php");}
}else{header("Location: ../index.php");}
?>
