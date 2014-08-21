<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[id])){
$adat="<center><big><u>Falkatoplista</u></big><br><br><a href=falkakeres.php class='feherlink'>Inkább keresek a falkák közt</a><br><a href=falka.php class='feherlink'>Megnézem a saját falkám</a><br><a href=falkastat.php class='feherlink'>Eddigi gyõztesek</a><br><br>";
$leker=mysql_query("SELECT * FROM falka ORDER BY falka_pont DESC limit 0, 50");$i=0;
while($falka=mysql_fetch_object($leker)){
$i++;
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
$kep="<img src=pic/falka/". $falka->falka_id .".png?rnd=". rand(1000,9999) ." border=0 height=50 width=150>";
}else{
$kep="<img src=pic/falka/nopic.jpg border=0 width=150 height=50>";
}
$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=770></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center>
<table><tr><td align=center width=20><big><big><big><big>". $i .".</big></big></big></big></td><td align=center>". $kep ."</td><td width=600>

<table border=0><tr><td align=center width=400><u>". falkaidtonev($falka->falka_id) ."</u></td><td>Vezetõ: <a href=kutyak.php?id=". $falka->falka_vezeto ." class='feherlink'>". $nev2 ."</a></td></tr><tr><td align=left>Ez a falka ". $nap ." napja létezik és már ". $falka->falka_pont ." pontja van.</td><td align=right><a href=falka.php?id=". $falka->falka_id ." class='feherlink'>Részletek...</a></td></tr></table>

</td></tr></table>

</td></tr><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table><br>";

///$adat.=$i ." ".$falka->falka_nev ."<br>";

}

$adat.="</center>";
oldal($adat);
}else{
header("Location: index.php");
}
?>
