<?php
include("sql.php");
include("session.php");
include("functions.php");
if(isset($_SESSION['nev'])){
header("Location: ../kutyam.php");
}elseif(isset($_POST[nev]) and ($_POST[jelszo]) and ($_POST[jelszo2]) and ($_POST[mail]) and ($_POST[haz])  and ($_POST[nem])){

if(hosszellenorzes($_POST[nev],3,16)==1){
$_SESSION['hiba']=hiba("Nem megfelel� hossz�s�g� n�v!");
header("Location: ../ujkutya.php");
}
$user=mysql_query("SELECT * FROM `kutya` WHERE `kutya_nev` = '". $_POST[nev] ."'",$kapcsolat);
if(mysql_num_rows($user)>0){
$_SESSION['hiba']=hiba("M�r haszn�latban lev� nevet v�lasztott�l, k�rlek v�lassz m�sikat!");
header("Location: ../ujkutya.php");
}
if(hosszellenorzes($_POST[jelszo],4,16)==1){
$_SESSION['hiba']=hiba("Nem megfelel� hossz�s�g� jelsz�!");
header("Location: ../ujkutya.php");
}
if($_POST[jelszo]!=$_POST[jelszo2]){
$_SESSION['hiba']=hiba("Nem egyeznek a be�rt jelszavak!");
header("Location: ../ujkutya.php");
}
if(hosszellenorzes($_POST[mail],0,40)==1){
$_SESSION['hiba']=hiba("Nem megfelel� hossz�s�g� e-mail c�m!");
header("Location: ../ujkutya.php");
}
if(email($_POST[mail])){
$_SESSION['hiba']=hiba("Nem l�tez� e-mail c�met adt�l meg!");
header("Location: ../ujkutya.php");
}
if($_SESSION['hiba']==""){ 
$gen=kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz]); 
$sql="INSERT INTO `kutya` VALUES ('', '". $_POST['nev'] ."', '". $_POST['jelszo'] ."', '". kutyanevtoszam($_POST[haz]) ."', '". $gen ."','1','774411' , '". $_POST[nem] ."', '". $_POST['mail'] ."', 1, 0, 50, 20, 0, 0, '','','','','',0,0,'". $ip ."','','". $ma ."','',0,0,0,0,0,2,1)";
mysql_query($sql);
$_SESSION['hiba']=ok("Sikeres regisztr�ci�, a kezd�lapon bel�phetsz a kuty�dhoz! ");
header("Location: ../ujkutya.php");
}
}else{
$_SESSION['hiba']=hiba("Nem t�lt�tt�l ki minden mezz�t!");
header("Location: ../ujkutya.php");
}
?>
