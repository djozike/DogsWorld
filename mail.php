<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[id])){
header("Location: kutyak.php");
}else{
if(isset($_GET[id])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_nev = '". $_GET[id] ."'");
if(mysql_num_rows($leker)==0){
$_SESSION['hiba']=hiba("Nincs ilyen nev� kutya!");
header("Location: mail.php");
}else{
while($kutya=mysql_fetch_object($leker)){
$message = "�dv!\nValaki kik�rte az ehhez a mail c�mhez tartoz� bel�p�shez sz�ks�ges adat�kat, ha nem te volt�l k�rlek hagyd figyelmen k�v�l a level�nk. A bel�p�shez sz�ks�ges adataid:\n
Kuty�d neve: ". $kutya->kutya_nev ."\nJelsz�: ". $kutya->kutya_jelszo ."\n\n�dv�zlettel:\nKutyuskanevelde csapata\n\nU.i.: Ez egy automat�n gener�lt lev�l k�rlek ne v�laszolj r�.";
$message = wordwrap($message, 70);
if (mail($kutya->kutya_email, 'Elfelejetett jelsz� ig�nyl�s', $message)){
header("Location: mail.php?ok=1");
}else{
header("Location: mail.php?ok=2");
}}}
}else{
$adat="<center><u><big>Elfelejetett jelsz�</big></u><br><br>";
if(isset($_GET['ok'])){
$adat.="<br><br>";
if($_GET['ok']==1){
$adat.=ok("Sikeressen elk�ldt�k a megadott e-mail c�mre a jelsz�t!</center>");
}else{
$adat.=hiba("Sajnos a mai nap m�r el�rt�k a napi E-mail k�ld�si limit�nk, pr�b�lkozz holnap!</center>");
}
}else{
$adat.="Ha elfejetted a kuty�d jelszav�t �rd be a kuty�d nev�t �s mail c�medre elk�ldj�k a sz�ks�ges adatokat!<br>
Kuty�d neve:<form method=GET action=mail.php><input type=text name=id> <input type=submit value='Elk�ld'></form>". $_SESSION['hiba'] ."</center>";
$_SESSION[hiba]='';
}
oldal($adat);
}}
	?>
