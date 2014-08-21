<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
if(isset($_POST[uzenet])  and $_POST[hova]){
if($_POST[hova]==5 and $_POST[honlap]==""){
$_SESSION[hiba]=hiba("Nem adtál meg minden adatot!");
header("Location: ../uzenofal.php");
}else{
if($_POST[szin]!=0){
$ar=$UZENOFAL+$UZENOFAL_SZINES;
}else{
$ar=$UZENOFAL;
}
$lekeres=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."' and kutya_penz >= '". $ar ."'");
if(mysql_num_rows($lekeres)>0){
switch($_POST[szin]){
case 1:
$szin="696969";
break;
case 2:
$szin="FFD700";
break;
case 3:
$szin="FF8C00";
break;
case 4:
$szin="DAA520";
break;
case 5:
$szin="FF6347";
break;
case 6:
$szin="FF4500";
break;
case 7:
$szin="DC143C";
break;
case 8:
$szin="DC143C";
break;
case 9:
$szin="800000";
break;
case 10:
$szin="9ACD32";
break;
case 11:
$szin="6B8E23";
break;
case 12:
$szin="008000";
break;
case 13:
$szin="6B8E23";
break;
case 14:
$szin="3CB371";
break;
case 15:
$szin="66CDAA";
break;
case 16:
$szin="1E90FF";
break;
case 17:
$szin="6495ED";
break;
case 18:
$szin="4682B4";
break;
case 19:
$szin="305DDB";
break;
case 20:
$szin="008B8B";
break;
case 21:
$szin="9370DB";
break;
case 22:
$szin="FF69B4";
break;
case 23:
$szin="F08080";
break;
case 24:
$szin="6D3AC4";
break;
case 25:
$szin="BA55D3";
break;
case 26:
$szin="8B008B";
break;
case 27:
$szin="4B0082";
break;
case 28:
$szin="774411";
break;
case 29:
$szin="000000";
break;
case 30:
$szin="483D8B";
break;
case 31:
$szin="32CD32";
break;
case 32:
$szin="00FFFF";
break;
case 33:
$szin="D2691E";
break;
case 34:
$szin="FF0000";
break;
default:
$szin="774411";
break;
}
$adat=$_POST[honlap];
if($_POST[hova]==3)
{
$leker=mysql_query("SELECT * FROM blog WHERE blog_id = '". $_POST[blog] ."' and blog_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($leker)>0)
{
$adat=$_POST[blog];
}
}
mysql_query("INSERT INTO uzenofal VALUES ('','". $_SESSION[id] ."', '". $_POST[uzenet] ."', '". $szin ."', '". $_POST[hova] ."', '". $adat ."', NOW(), '0')");
$lista=mysql_query("SELECT * FROM uzenofal ORDER BY uzenofal_id DESC limit 20,20");
while($uzenofal=mysql_fetch_object($lista)){
$leiras="Szia!<br>Az üzeneted, amit kiírtál az üzenõfalra, ". $uzenofal->uzenofal_ido ."tól ". date("Y. m. j G:i:s") ."ig jelent meg és ". $uzenofal->uzenofal_klik ." szer kattintottak rá.";
$level=mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $uzenofal->uzenofal_kid ."', NOW(), 0, 0, 1, 0)");
mysql_query("DELETE FROM uzenofal WHERE uzenofal_id = '". $uzenofal->uzenofal_id ."'");
}

while($kutyus=mysql_fetch_object($lekeres)){
$penz=$kutyus->kutya_penz-$ar;
mysql_query("UPDATE kutya SET kutya_penz = '". $penz ."' WHERE kutya_id = '". $_SESSION[id] ."'");
}

$_SESSION[hiba]=ok("Sikeresen irtál az üzenõfalra!");
header("Location: ../uzenofal.php");
}else{
$_SESSION[hiba]=hiba("Nincs elég pénzed!");
header("Location: ../uzenofal.php");
}
}
}else{
$_SESSION[hiba]=hiba("Nem adtál meg minden adatot!");
header("Location: ../uzenofal.php");
}
}else{
header("Location: ../index.php");
}
?>
