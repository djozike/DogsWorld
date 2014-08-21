<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[nev])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if($kutya->kutya_falka==0){

$adat="<center><big><u>Új Falka</u></big><br><br>Figyelem a falka megalapításához ki kell töltened a név mezõt<br> és mindenképpen kell a kutyádnál 5 ossának lennie.<br><br>". $_SESSION[hiba] ."<form method=POST action=inc/falapit.php><table border=0><tr><td>Név:<td><input type=text name=nev><td><small>min 3, max 40 karakter</small></tr>
<tr><td align=center colspan=3>Leírás: (UBB kódokhoz segítség itt)</td></tr><tr><td align=center colspan=3><textarea name=leiras cols=50 rows=12></textarea></td></tr><tr><td align=left>Háttérszín:<td align=right>#<input type=text name=hatterszin><td><small>6 karakteres HEX kód, segítség <a href=http://www.drpeterjones.com/colorcalc/ class='feherlink' target=_blank>itt</a></small></tr>
<tr><td align=left>Háttérkép:<td align=right>http://<input type=text name=hatterkep><td></tr><tr><td align=center colspan=3><input type=submit value=Elküld></td></tr></table></form><br><br>". banner() ."</center>";
$_SESSION[hiba]="";
}else{
header("Location: falka.php?id=". $kutya->kutya_falka);
}
}
oldal($adat);
}else{header("Location: index.php");}
	?>
