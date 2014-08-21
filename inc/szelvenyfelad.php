<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and ($_POST[szam1]) and ($_POST[szam2]) and ($_POST[szam3])){
if(($_POST[szam1]!=$_POST[szam2])and ($_POST[szam1]!=$_POST[szam3]) and ($_POST[szam2]!=$_POST[szam3])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
if(mysql_num_rows($leker)>0){
while($kutya=mysql_fetch_object($leker)){
if(substr_count($kutya->kutya_tanul,"BR")!=0){
if($LOTTO>$kutya->kutya_penz){
$_SESSION[hiba]=hiba("Nincs elég pénzed!<br>");
header("Location: ../lotto.php");

}else{
//szam rendezes
if($_POST[szam1]>$_POST[szam2]){
$szam2=$_POST[szam1];
$szam1=$_POST[szam2];
}else{
$szam2=$_POST[szam2];
$szam1=$_POST[szam1];
}
if($szam2<$_POST[szam3]){
$szam3=$_POST[szam3];
}else{
if($_POST[szam3]>$szam1){
$szam3=$szam2;
$szam2=$_POST[szam3];
}else{
$szam3=$szam2;
$szam2=$szam1;
$szam1=$_POST[szam3];
}
}
$ellenoriz=mysql_query("SELECT * FROM lottoszelveny WHERE lottoszelveny_kid =". $_SESSION[id] . " and lottoszelveny_szam1 =". $szam1 ." and lottoszelveny_szam2 =". $szam2 ." and lottoszelveny_szam3 =". $szam3 ."");
if(mysql_num_rows($ellenoriz)==0){

$handle = fopen("../data/lottonyeremeny.txt", "r");
$nyeremeny=fread($handle, filesize("../data/lottonyeremeny.txt"))+$LOTTO;
fclose($handle);
$handle = fopen("../data/lottonyeremeny.txt", "w");
fwrite($handle, $nyeremeny);
fclose($handle);
$newpenz=$kutya->kutya_penz-$LOTTO;
mysql_query("UPDATE kutya SET kutya_penz = '". $newpenz ."' WHERE kutya_id = '". $_SESSION[id] ."'");
mysql_query("INSERT INTO lottoszelveny VALUES ('". $_SESSION[id] ."', '". $szam1 ."', '". $szam2 ."', '". $szam3 ."')");
$_SESSION[hiba]=ok("Sikeres szelvény vásárlás!<br>");
header("Location: ../lotto.php");
}else{
$_SESSION[hiba]=hiba("Kétszer ugyanolyan szelvényt nem vehetsz!<br>");
header("Location: ../lotto.php");
}
}
}else{
header("Location: ../index.php");
}
}
}else{
header("Location: ../index.php");
}
}else{
$_SESSION[hiba]=hiba("Különbözõ számokat adj meg!<br>");
header("Location: ../lotto.php");
}
}else{
header("Location: ../index.php");
}
?>
