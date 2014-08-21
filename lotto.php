<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
if(isset($_SESSION[id])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
if(substr_count($leker->kutya_tanul,"BR")==0){
/*
$handle = fopen("data/lottonyeremeny.txt", "r");
$nyeremeny=fread($handle, filesize("data/lottonyeremeny.txt"));
fclose($handle);*/
$l = new lotto();
$nyeremeny=$l->nyeremeny;
for($i=1;$i<11;$i++){
$szamok.="<option value=". $i .">". $i ."</option>";
}
$adat="<center><big><u>Lottó</u></big><br><br>
A lottón 10bõl 3 számot kell helyesen eltalálnod. Hetente van lottóhuzás, csak a telitalálatos nyer. 
Ha több telitalálos is van a nyereményt egyenlõen felosztjuk. Ha viszont nincs egy nyertes sem, a nyeremény áttolodik a következõ hétre. Egy lottó szelvény ára ". penz($LOTTO) .".<br>
Eheti nyeremény: <u><b>". penz($nyeremeny) ."</b></u><br><br>
<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center><u>Új lottószelvény vásárlása</u><br>
<form action=inc/szelvenyfelad.php method=POST><table border=0><tr><td align=center><select name=szam1 style='width: 60px;'>". $szamok ."</select></td>
<td align=center><select name=szam2 style='width: 60px;'>". $szamok ."</select></td>
<td align=center><select name=szam3 style='width: 60px;'>". $szamok ."</select></td>
<td align=center><input type=submit value=Vásáról></td></tr></table></form>
</td><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></tr></table><br>". $_SESSION["hiba"] ."
<u>Jelenlegi szelvényeid:</u><br>";
$_SESSION["hiba"]="";
$ellenoriz=mysql_query("SELECT * FROM lottoszelveny WHERE lottoszelveny_kid =". $_SESSION[id]);
while($szelveny=mysql_fetch_object($ellenoriz)){
$adat.=$szelveny->lottoszelveny_szam1 .", ". $szelveny->lottoszelveny_szam2 .", ". $szelveny->lottoszelveny_szam3 ."<br>";

}
$adat.="<br><br><u>Hírdetés</u><br>". banner() ."</center>";
oldal($adat);
}else{header("Location: index.php");}
}else{header("Location: index.php");}
?>
