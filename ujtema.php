<?php
include("inc/sql.php");
include("inc/session.php");
include("inc/functions.php");
if(isset($_SESSION[id])){
if(isset($_GET[topic])){
$adat='<center><a href=forum.php class="feherlink">F�rum</a> | <a href=forum.php?oldal=chat class="feherlink">Chat</a><br>
<br><big><big><b><u>�j t�ma l�trehoz�sa</u></b></big></big><br><br>�j t�ma l�trehoz�s�hoz megkell adn�d a t�me nev�t �s egy kis le�r�st �rni, hogy mir�l sz�l a t�ma. Figyelem a t�ma le�r�s�ban �s nev�ben sem lehet semmi szab�lys�rt� tartalom.<br><br>';
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if(substr_count($kutya->kutya_tanul,"IR")==0){
$adat.=hiba("Nem tudsz �j t�m�t l�trehozni, mivel a kuty�d nem tanult meg �rni!");
}else{
$tilte=mysql_query("SELECT * FROM forumtilt WHERE forumtilt_kid = '". $_SESSION[id] ."'");
$iptilte=mysql_query("SELECT * FROM forumiptilt WHERE forumiptilt_ip = '". $ip ."'");
if(mysql_num_rows($tilte)>0){
while($tilto=mysql_fetch_object($tilte)){
$adat.=hiba(">Sajnos letiltottak a f�rumr�l, ez�rt nem hozhatsz l�tre �j t�m�t m�g ". $tilto->forumtilt_ido ." napig!");
}
}elseif(mysql_num_rows($iptilte)>0){
while($tilto=mysql_fetch_object($iptilte)){
$adat.=hiba("Sajnos letiltott�k az IP c�med a f�rumr�l, ez�rt nem hozhatsz l�tre �j t�m�t err�l a sz�m�t�g�pr�l m�g ". $tilto->forumiptilt_ido ." napig!");
}
}else{
$adat.="<table><tr><td align=right>T�ma neve:</td><td align=left><form action=inc/newtopic.php method=POST><input type=hidden name=tema value=". $_GET[topic] ."><input type=text name=nev maxlength=25></td><td><small>max. 25 karakter</small></td></tr>
<tr><td align=right>T�ma le�r�sa:</td><td align=left><textarea maxlength=100 name=leiras></textarea></td><td><small>Max. 100 karakter</small></td></tr>
<tr><td align=right></td><td align=left><input type=submit value='Elk�ld'></form></td><td></td></tr></table>";


}}}
oldal($adat);
}else{
header("Location: forum.php");
}
}else{
header("Location: index.php");
}
?>
