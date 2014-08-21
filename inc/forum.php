<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and $_POST[topic]){
if($_POST[uzenet]=="" or $_POST[uzenet]==" "){
$_SESSION[hiba]=hiba("Nem irtál be semmit!");
header("Location: ../forum.php?topic=". $_POST[topic]);
}else{
$uzenet=ubb_forum($_POST[uzenet]);
mysql_query("INSERT INTO forum VALUES ('','-". $_POST[topic] ."','". $_SESSION[id] ."','', NOW(), '". $uzenet ."')");
mysql_query("UPDATE forumtema SET forumtema_ido = NOW() WHERE forumtema_id = '". $_POST[topic] ."'");
header("Location: ../forum.php?tema=". $_POST[topic]);

}
}else{
header("Location: ../index.php");
}
?>
