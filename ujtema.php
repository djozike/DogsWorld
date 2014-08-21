<?php
include("inc/sql.php");
include("inc/session.php");
include("inc/functions.php");
if(isset($_SESSION[id])){
if(isset($_GET[topic])){
$adat='<center><a href=forum.php class="feherlink">Fórum</a> | <a href=forum.php?oldal=chat class="feherlink">Chat</a><br>
<br><big><big><b><u>Új téma létrehozása</u></b></big></big><br><br>Új téma létrehozásához megkell adnód a téme nevét és egy kis leírást írni, hogy mirõl szól a téma. Figyelem a téma leírásában és nevében sem lehet semmi szabálysértõ tartalom.<br><br>';
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if(substr_count($kutya->kutya_tanul,"IR")==0){
$adat.=hiba("Nem tudsz új témát létrehozni, mivel a kutyád nem tanult meg írni!");
}else{
$tilte=mysql_query("SELECT * FROM forumtilt WHERE forumtilt_kid = '". $_SESSION[id] ."'");
$iptilte=mysql_query("SELECT * FROM forumiptilt WHERE forumiptilt_ip = '". $ip ."'");
if(mysql_num_rows($tilte)>0){
while($tilto=mysql_fetch_object($tilte)){
$adat.=hiba(">Sajnos letiltottak a fórumról, ezért nem hozhatsz létre új témát még ". $tilto->forumtilt_ido ." napig!");
}
}elseif(mysql_num_rows($iptilte)>0){
while($tilto=mysql_fetch_object($iptilte)){
$adat.=hiba("Sajnos letiltották az IP címed a fórumról, ezért nem hozhatsz létre új témát errõl a számítógéprõl még ". $tilto->forumiptilt_ido ." napig!");
}
}else{
$adat.="<table><tr><td align=right>Téma neve:</td><td align=left><form action=inc/newtopic.php method=POST><input type=hidden name=tema value=". $_GET[topic] ."><input type=text name=nev maxlength=25></td><td><small>max. 25 karakter</small></td></tr>
<tr><td align=right>Téma leírása:</td><td align=left><textarea maxlength=100 name=leiras></textarea></td><td><small>Max. 100 karakter</small></td></tr>
<tr><td align=right></td><td align=left><input type=submit value='Elküld'></form></td><td></td></tr></table>";


}}}
oldal($adat);
}else{
header("Location: forum.php");
}
}else{
header("Location: index.php");
}
?>
