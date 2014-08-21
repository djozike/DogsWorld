<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and ($_GET[id])){
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$leker=mysql_query("SELECT * FROM forum WHERE forum_id = '". $_GET[id] ."'");
if(mysql_num_rows($leker)>0){
while($uzi=mysql_fetch_object($leker)){
mysql_query("DELETE FROM forum WHERE forum_id = '". $_GET[id] ."'");


$leker2=mysql_query("SELECT * FROM forum WHERE forum_topic = '". $uzi->forum_topic ."' ORDER BY forum_id DESC limit 1");

while($uzi2=mysql_fetch_object($leker2)){
mysql_query("UPDATE forumtema SET forumtema_ido = ". $uzi2->forum_ido ." WHERE forumtema_id = '". $uzi->forum_topic ."'");
}
header("Location: ../forum.php?tema=". abs($uzi->forum_topic));
}
}
}
}else{
header("Location: ../index.php");
}
?>
