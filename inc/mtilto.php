<?php
include("session.php");
include("sql.php");
include("oop.php");
if(isset($_SESSION[id]) and ($_POST[id]) and ($_POST[ido])){
$kutyuli = new kutya;
$kutyuli->GetKutyaByID($_SESSION[id]);
if($kutyuli->rang>0){
switch($_POST[ido]){
case 5:
$ido=0;
break;
case 4:
$ido=10;
break;
case 2:
$ido=2;
break;
case 3:
$ido=5;
break;
default:
$ido=1;
break;
}
$kutyus = new kutya;
if($kutyus->GetKutyaByID($_POST[id]))
{
$kutyus->TiltOldalrol($_SESSION[id],$ido);
if($ido!=0){
$leiras="Szia!<br>Sajnos a ". idtonev($_SESSION[id]) ." nevû moderátor tiltotta a kutyád az oldalról, valószínûleg valami súlyos szabályellenes dolgot követtél el. Ha részleteket szeretnél tudni a tiltás okáról, írj a moderátornak.";
$kutyus->SendUzenet(0, $leiras);
}
}
if($ido!=0){
header("Location: ../kutyak.php?id=". $_POST[id]);
}
else{
header("Location: ../admin.php?p=t");
}
}
}else{
header("Location: ../index.php");
}
?>
