<?php
include("session.php");
include("sql.php");
include("oop.php");
$kutyus=new kutya();
$kutyus->GetKutyaByID($_SESSION[id]);
$kell=mysql_query("SELECT * FROM `hazassag` WHERE `hazassag_aktiv` = '". $_SESSION[id] ."' or `hazassag_ferj` = '". $_SESSION[id] ."' or `hazassag_feleseg` = '". $_SESSION[id] ."'");
if(isset($_SESSION[id]) and isset($_POST[nev]) and $kutyus->kor>17 and mysql_num_rows($kell)==0){
$leker=mysql_query("SELECT * FROM `kutya` WHERE kutya_nev = '". $_POST[nev] ."'");
if(mysql_num_rows($leker)>0){
while($tars=mysql_fetch_object($leker)){
if($tars->kutya_kor<18){
$_SESSION[hibas]=hiba("Túl fiatal a másik kutya!");
}else{
$mine=mysql_query("SELECT * FROM `kutya` WHERE kutya_id = '". $_SESSION[id] ."'");
while($my=mysql_fetch_object($mine)){
if($my->kutya_nem==$tars->kutya_nem){
$_SESSION[hibas]=hiba("Azonos nemûek nem házasodhatnak!");
}else{
$kelle=mysql_query("SELECT * FROM `hazassag` WHERE `hazassag_aktiv` = '". $tars->kutya_id ."' or `hazassag_ferj` = '". $tars->kutya_id ."' or `hazassag_feleseg` = '". $tars->kutya_id ."'");
if(mysql_num_rows($kelle)>0){
$_SESSION[hibas]=hiba("A másik kutya már házas!");
}else{
if($tars->kutya_nem==2){
$ferj=""; $feleseg=$tars->kutya_id;
}else{
$feleseg=""; $ferj=$tars->kutya_id;
}

$ir=mysql_query("INSERT INTO `hazassag` VALUES ('". $ferj ."', '". $feleseg ."', '', '". $my->kutya_id ."')",$kapcsolat);

}
}
}
}
}
}else{
$_SESSION[hibas]=hiba("Nincs ilyen kutya!");
}
header("Location: ../kutyam.php");
}else{header("Location: ../index.php");}
	?>
