<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and $_GET[id]){
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$uzenetowner=mysql_query("SELECT * FROM uzenofal WHERE uzenofal_id = '". $_GET[id] ."'");
while($kutya=mysql_fetch_object($uzenetowner)){
$leiras="Szia!<br>Sajnos a ". idtonev($_SESSION[id]) ." nevû moderátor törölte az üzenõfalról az üzeneted, valószínüleg valami szabályellenes dolgót írtál ki. Az üzenõfalra írás költségét nem áll módunkban visszadni. Ha részleteket szeretnél tudni a tiltás okáról, írj a moderátornak.";
$level=mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $kutya->uzenofal_kid ."', NOW(), 0, 0, 1, 0)");
}
mysql_query("DELETE FROM uzenofal WHERE uzenofal_id = '". $_GET[id] ."'");
header("Location: ../uzenofal.php?page=utolso20");
}else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
