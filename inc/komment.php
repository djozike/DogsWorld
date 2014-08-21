<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and $_POST[komment]!="" and $_POST[blog]!="0"){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if($kutyaja->kutya_betuszin=="774411"){
$nev1=htmlentities($kutya->kutya_nev);
}else{
$nev1="<font color=#". $kutya->kutya_betuszin .">". htmlentities($kutya->kutya_nev) ."</font>";
}
$uzenet=ubb_forum($_POST[komment]);
mysql_query("INSERT INTO komment VALUES ('','". $_SESSION[id] ."','". $nev1 ."', NOW(), '". $uzenet ."', '". $_POST[blog] ."')");
header("Location: ../blog.php?blog=". $_POST[blog] ."#kommentek");

}
}elseif(isset($_SESSION[id]) and $_POST[blog]!="0")
{
header("Location: ../blog.php?blog=". $_POST[blog] ."#kommentek");
}else{
header("Location: ../index.php");
}
?>
