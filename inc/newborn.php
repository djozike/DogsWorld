<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$hazase=mysql_query("SELECT * FROM hazassag WHERE hazassag_ferj = '". $_SESSION[id] ."' or hazassag_feleseg = '". $_SESSION[id] ."'");
if(mysql_num_rows($hazase)>0){
$vanekolyok=mysql_query("SELECT * FROM kolyok WHERE kolyok_apa = '". $_SESSION[id] ."' or kolyok_anya = '". $_SESSION[id] ."'");
if(mysql_num_rows($vanekolyok)>0){
if(isset($_POST[nev]) and $_POST[jelszo]){
if(hosszellenorzes($_POST[nev],3,16)==1){
$_SESSION[hibas]=hiba("Nem megfelelõ hosszú név!");
header("Location: ../kutyam.php");
}else{
if(hosszellenorzes($_POST[jelszo],4,16)==1){
$_SESSION[hibas]=hiba("Nem megfelelõ hosszú jelszó!");
header("Location: ../kutyam.php");
}else{
$nevellenoriz=mysql_query("SELECT * FROM kutya WHERE kutya_nev = '". $_POST[nev] ."'");
if(mysql_num_rows($nevellenoriz)>0){
$_SESSION[hibas]=hiba("Már foglalt ez a név!");
header("Location: ../kutyam.php");
}else{
while($kolyok=mysql_fetch_object($vanekolyok)){
$apja=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $kolyok->kolyok_apa ."'");
$anyja=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $kolyok->kolyok_anya  ."'");
while($apa=mysql_fetch_object($apja)){
while($anya=mysql_fetch_object($anyja)){

$nem=$kolyok->kolyok_nem;
$apagen=explode("|", $apa->kutya_gen);
$anyagen=explode("|", $anya->kutya_gen);

$rand_gen = veletlen(0,7, 4);   
$gen=$apagen[$rand_gen[0]] ."|". $apagen[$rand_gen[1]] ."|". $apagen[$rand_gen[2]] ."|".  $apagen[$rand_gen[3]] ."|";

$rand_gen = veletlen(0,7, 4); 
$gen.=$anyagen[$rand_gen[0]] ."|". $anyagen[$rand_gen[1]] ."|". $anyagen[$rand_gen[2]] ."|".  $anyagen[$rand_gen[3]];

$genek=explode("|", $gen);
$farkas=true;
for($i=0; $i<7; $i++)
{
   for($j=$i+1; $j<8; $j++)
   {
    if($genek[$i]==$genek[$j])
    {
		$farkas=false;
    }
   }
}
if($farkas==true){
$faj=-2;
}else{
$faj=kutyagentoszam($genek[rand(0,7)]);
}
//szin meghatarozas
$genszum= 0;
for($i=0; $i<8; $i++)
{
	$genszum += kutyagentoszam($genek[$i]);
}
$szin=($genszum % (kutyaszamtoszinszam($faj)))+1;
if($_SESSION[id]==$kolyok->kolyok_apa)
{
	$mail=$apa->kutya_email;
}else{
	$mail=$anya->kutya_email;
}
if(mysql_query("DELETE FROM kolyok WHERE kolyok_apa = ". $kolyok->kolyok_apa ." and kolyok_anya = ". $kolyok->kolyok_anya ."")){
mysql_query("INSERT INTO `kutya` VALUES ('', '". $_POST['nev'] ."', '". $_POST['jelszo'] ."', '". $faj ."','". $gen ."','". $szin ."','774411' , '". $nem ."', '". $mail ."', 1, 0, 50, 20, 0, 0,'', ". $apa->kutya_id .",'". $apa->kutya_nev ."',". $anya->kutya_id .",'". $anya->kutya_nev ."',0,0,'". $ip ."','','". $ma ."','',0,0,0,0,0,2,0)",$kapcsolat);
}
header("Location: ../kutyam.php");
}
}
}
}
}
}
}else{
$_SESSION[hibas]=hiba("Nem adtál meg minden adatot!");
header("Location: ../kutyam.php");
}
}else{
header("Location: kolyok.php");
}
}else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
