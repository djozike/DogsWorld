<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and ($_GET[uid])){
$leker=mysql_query("SELECT * FROM forum WHERE forum_id = '". $_GET[uid] ."'");
if(mysql_num_rows($leker)>0){
while($lekere=mysql_fetch_object($leker)){
if($lekere->forum_topic>0){
$lekerke=mysql_query("SELECT * FROM falka WHERE falka_id = '". $lekere->forum_topic ."'");
while($falka=mysql_fetch_object($lekerke)){
$jogok=explode('|',$falka->falka_jogok);
if(($falka->falka_vezeto==$_SESSION[id]) or ($falka->falka_vezetohelyettes==$_SESSION[id] and $jogok[0]==1)){
mysql_query("DELETE FROM forum WHERE forum_id = ". $_GET[uid] ."");
header("Location: ../falkaforum.php");
}else{
header("Location: ../index.php");
}
}
}else{
header("Location: ../index.php");
}
}
}else{
header("Location: ../index.php");
}}else{
header("Location: ../index.php");
}
?>
