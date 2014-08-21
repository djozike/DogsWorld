<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[nev]) and $_POST[tanul]){
$kutyus=mysql_query("SELECT * FROM `kutya` WHERE `kutya_id` = '". $_SESSION[id] ."'",$kapcsolat);
while($elker=mysql_fetch_object($kutyus)){
if($elker->kutya_tanult!=$ma){
if(substr_count($elker->kutya_tanul,$_POST[tanul])==0){
$datumozas=mysql_query("UPDATE `kutya` SET `kutya_tanult` = '". $ma ."' WHERE `kutya_id` = '". $_SESSION[id] ."'");
$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $_SESSION[id] ."' and `tanul_mit` = '". $_POST[tanul] ."'",$kapcsolat);
if(mysql_num_rows($tudas)==0){
switch($_POST[tanul])
{
case IR:
$lecke=2;
break;
case SZ:
$lecke=4;
break;
case BR:
$lecke=9;
break;
case ER:
$lecke=11;
break;
case FU:
$lecke=6;
break;
case KE:
$lecke=9;
break;
case VE:
$lecke=11;
break;
}
$iras=mysql_query("INSERT INTO `tanul` VALUES ('". $_SESSION[id] ."', '". $_POST[tanul] ."', '". $lecke ."')",$kapcsolat);
header("Location: ../kutyam.php");
}else{
while($kellr=mysql_fetch_object($tudas)){
$leckeszam=$kellr->tanul_lecke-1;
}
if($leckeszam==0){
$megtanult=$elker->kutya_tanul;
$megtanult.=$_POST[tanul] ."|";
mysql_query("DELETE FROM `tanul` WHERE `tanul_id` = '". $_SESSION[id] ."' and `tanul_mit` = '". $_POST[tanul] ."'");
if($_POST[tanul]=="ER"){
$penz=$elker->kutya_penz+100;
mysql_query("UPDATE `kutya` SET `kutya_penz` = '". $penz ."',`kutya_tanul` = '". $megtanult ."' WHERE `kutya_id` = '". $_SESSION[id] ."'");
}else{
mysql_query("UPDATE `kutya` SET `kutya_tanul` = '". $megtanult ."' WHERE `kutya_id` = '". $_SESSION[id] ."'");
}
header("Location: ../kutyam.php");
}else{
mysql_query("UPDATE `tanul` SET `tanul_lecke` = '". $leckeszam ."' WHERE `tanul_id` = '". $_SESSION[id] ."' and `tanul_mit` = '". $_POST[tanul] ."'");
header("Location: ../kutyam.php");
}
}
}else{ header("Location: ../index.php"); }

}
}
}else{header("Location: ../index.php");}
	?>
