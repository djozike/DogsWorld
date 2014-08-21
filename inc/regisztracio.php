<?php
include("sql.php");
include("session.php");
include("functions.php");
if(isset($_SESSION['nev'])){
header("Location: ../kutyam.php");
}elseif(isset($_POST[nev]) and ($_POST[jelszo]) and ($_POST[jelszo2]) and ($_POST[mail]) and ($_POST[haz])  and ($_POST[nem])){

if(hosszellenorzes($_POST[nev],3,16)==1){
$_SESSION['hiba']=hiba("Nem megfelelõ hosszúságú név!");
header("Location: ../ujkutya.php");
}
$user=mysql_query("SELECT * FROM `kutya` WHERE `kutya_nev` = '". $_POST[nev] ."'",$kapcsolat);
if(mysql_num_rows($user)>0){
$_SESSION['hiba']=hiba("Már használatban levõ nevet választottál, kérlek válassz másikat!");
header("Location: ../ujkutya.php");
}
if(hosszellenorzes($_POST[jelszo],4,16)==1){
$_SESSION['hiba']=hiba("Nem megfelelõ hosszúságú jelszó!");
header("Location: ../ujkutya.php");
}
if($_POST[jelszo]!=$_POST[jelszo2]){
$_SESSION['hiba']=hiba("Nem egyeznek a beírt jelszavak!");
header("Location: ../ujkutya.php");
}
if(hosszellenorzes($_POST[mail],0,40)==1){
$_SESSION['hiba']=hiba("Nem megfelelõ hosszúságú e-mail cím!");
header("Location: ../ujkutya.php");
}
if(email($_POST[mail])){
$_SESSION['hiba']=hiba("Nem létezõ e-mail címet adtál meg!");
header("Location: ../ujkutya.php");
}
if($_SESSION['hiba']==""){ 
$gen=kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz])."|".kutyanevtogen($_POST[haz]); 
$sql="INSERT INTO `kutya` VALUES ('', '". $_POST['nev'] ."', '". $_POST['jelszo'] ."', '". kutyanevtoszam($_POST[haz]) ."', '". $gen ."','1','774411' , '". $_POST[nem] ."', '". $_POST['mail'] ."', 1, 0, 50, 20, 0, 0, '','','','','',0,0,'". $ip ."','','". $ma ."','',0,0,0,0,0,2,1)";
mysql_query($sql);
$_SESSION['hiba']=ok("Sikeres regisztráció, a kezdõlapon beléphetsz a kutyádhoz! ");
header("Location: ../ujkutya.php");
}
}else{
$_SESSION['hiba']=hiba("Nem töltöttél ki minden mezzõt!");
header("Location: ../ujkutya.php");
}
?>
