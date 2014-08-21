<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[id])){
if($_GET[ig]>-1){
$maxi=$_GET[ig];
}else{
$leker=mysql_query("SELECT * FROM falka ORDER BY falka_pont DESC limit 0, 1");
while($maxpont=mysql_fetch_object($leker)){
$maxi=$maxpont->falka_pont+1;
}
}
$tol=0;
if($_GET[tol]>-1){
$tol=$_GET[tol];
}
$adat.="<center><big><u>Falka keresés</u></big><br><br>

<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=800></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center><form action=falkakeres.php method=GET>
<table boder=0><tr><td align=left><input type=hidden name=keres value=1>Falka név:</td><td align=right><input type=text name=nev value=". $_GET[nev] ."></td><td align=left>Vezetõ név:</td><td align=right><input type=text name=vnev value=". $_GET[vnev] ."></td><td align=left>Pont:</td><td align=right><input type=text name=tol value=". $tol ." style='width: 45px'> - <input type=text name=ig value=". $maxi ." style='width: 45px'></td><td align=left><input type=submit value=Elküld></td></tr>
</table></form>
</td></tr>
<tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=800></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table><br>";
if($_GET[keres]==1){
$adat.="<u>Keresés</u><br><br>";
$oldal=0;
if(isset($_GET[page])){
$oldal=$_GET[page];}
$feltetel="";
if($_GET[nev]!=""){
$feltetel.="and falka_nev LIKE '". $_GET[nev] ."%'";
}
if($_GET[vnev]!=""){
$feltetel.="and kutya_nev LIKE '". $_GET[vnev] ."%'";
}
if($_GET['tol']>-1 and $_GET['ig']>-1){
$feltetel.="and falka_pont > '". $_GET[tol] ."' and falka_pont < '". $_GET[ig] ."'";
}

$lekeres=mysql_query("SELECT * FROM falka, kutya WHERE falka.falka_vezeto = kutya.kutya_id ". $feltetel ." ORDER BY falka_pont DESC limit ". $oldal .", 10");

while($falka=mysql_fetch_object($lekeres)){
if($falka->kutya_betuszin=="774411"){
$nev2=htmlentities($falka->kutya_nev);
}else{
$nev2="<font color=#". $falka->kutya_betuszin .">". htmlentities($falka->kutya_nev) ."</font>";
}
$nap=floor(($ma-$falka->falka_alapitas)/60/60/24);
if(file_exists("pic/falka/". $falka->falka_id .".png")){
$kep="<img src=pic/falka/". $falka->falka_id .".png border=0 height=50 width=150>";
}else{
$kep="<img src=pic/falka/nopic.jpg border=0 width=150 height=50>";
}
$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=770></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center>
<table><tr><td align=center>". $kep ."</td><td width=600>

<table border=0><tr><td align=center width=400><u>". falkaidtonev($falka->falka_id) ."</u></td><td>Vezetõ: <a href=kutyak.php?id=". $falka->falka_vezeto ." class='feherlink'>". $nev2 ."</a></td></tr><tr><td align=left>Ez a falka ". $nap ." napja létezik és már ". $falka->falka_pont ." pontja van.</td><td algin=right><a href=falka.php?id=". $falka->falka_id ." class='feherlink'>Részletek...</a></td></tr></table>

</td></tr></table>

</td></tr><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table><br>";
}


$toplistaa=mysql_query("SELECT * FROM falka, kutya WHERE falka.falka_vezeto = kutya.kutya_id ". $feltetel ." ORDER BY falka_pont DESC");
$feltetels="nev=". $_GET[nev] ."&vnev=". $_GET[vnev] ."&tol=". $_GET[tol] ."&ig=". $_GET[ig] ."&keres=1";
if($oldal!=0){$adat.="<a href=falkakeres.php?page=". ($oldal-10) ."&". $feltetels ." class='feherlink'>Elõzõ 10 falka</a>";}
if($oldal< mysql_num_rows($toplistaa)-10){$adat.=" <a href=falkakeres.php?page=". ($oldal+10) ."&". $feltetels ." class='feherlink'>Következõ 10 falka</a>";}


}else{
$leker=mysql_query("SELECT * FROM falka");
$szam=mysql_num_rows($leker)-10;
if($szam<0)
{
$szam=mysql_num_rows($leker);
}
$lekeres=mysql_query("SELECT * FROM falka ORDER BY falka_id DESC limit ". rand(0,$szam) .", 10");
$adat.="<u>Véletlenszerû 10 falka</u><br><br>";


while($falka=mysql_fetch_object($lekeres)){
$vezetonev=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $falka->falka_vezeto ."'");
while($kell=mysql_fetch_object($vezetonev)){
if($kell->kutya_betuszin=="774411"){
$nev2=htmlentities($kell->kutya_nev);
}else{
$nev2="<font color=#". $kell->kutya_betuszin .">". htmlentities($kell->kutya_nev) ."</font>";
}
}
$nap=floor(($ma-$falka->falka_alapitas)/60/60/24);
if(file_exists("pic/falka/". $falka->falka_id .".png")){
$kep="<img src=pic/falka/". $falka->falka_id .".png border=0 height=50 width=150>";
}else{
$kep="<img src=pic/falka/nopic.jpg border=0 width=150 height=50>";
}
$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=770></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center>
<table><tr><td align=center>". $kep ."</td><td width=600>

<table border=0><tr><td align=center width=400><u>". falkaidtonev($falka->falka_id) ."</u></td><td>Vezetõ: <a href=kutyak.php?id=". $falka->falka_vezeto ." class='feherlink'>". $nev2 ."</a></td></tr><tr><td align=left>Ez a falka ". $nap ." napja létezik és már ". $falka->falka_pont ." pontja van.</td><td algin=right><a href=falka.php?id=". $falka->falka_id ." class='feherlink'>Részletek...</a></td></tr></table>

</td></tr></table>

</td></tr><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table><br>";


}
}
$adat.="</center>";
oldal($adat);
}else{
header("Location: index.php");}
?>
