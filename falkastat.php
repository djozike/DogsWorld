<?
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[nev])){
$adat="<center><table><tr><td>";
//örökranglista
$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td><center><u><big>Örök ranglista falka szerint</big></u></center><table><tr><th width=20></th><th width=210 align=center>Név</th><th align=center width=20><img src=pic/Med_1.png></th><th align=center width=20><img src=pic/Med_2.png></th><th align=center width=20><img src=pic/Med_3.png></th></tr>";

$useres=mysql_query("SELECT count(falkatop_1falkaid) a, `falkatop_1falkaid`, `falkatop_1falka` FROM `falkatop` GROUP BY `falkatop_1falkaid` ORDER BY a DESC LIMIT 0, 5",$kapcsolat);
$i=1;
while($leker=mysql_fetch_object($useres)){
$ezust=mysql_query("SELECT * FROM `falkatop` WHERE falkatop_2falkaid = '". $leker->falkatop_1falkaid ."'");
$bronz=mysql_query("SELECT * FROM `falkatop` WHERE falkatop_3falkaid = '". $leker->falkatop_1falkaid ."'");

$adat.="<tr><td align=left width=20>". $i .".</td><td align=left width=230>". linker_falka($leker->falkatop_1falkaid,$leker->falkatop_1falka) ."</td><td align=center>". $leker->a ."<td align=center>". mysql_num_rows($ezust) ."</td><td align=center>". mysql_num_rows($bronz) ."</td></td></tr>";
$i++;
}
$adat.="</table></td><td width=11 background=pic/keret.jpg></td></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table>";
///
$adat.="</td><td width=120></td><td>";
///vezetõ lista
$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td><center><u><big>Örök ranglista vezetõ szerint</big></u></center><table><tr><th width=20></th><th width=210 align=center>Név</th><th align=center width=20><img src=pic/Med_1.png></th><th align=center width=20><img src=pic/Med_2.png></th><th align=center width=20><img src=pic/Med_3.png></th></tr>";

$useres=mysql_query("SELECT count(falkatop_1falkavezetoid) a, `falkatop_1falkavezetoid`, `falkatop_1falkavezeto` FROM `falkatop` GROUP BY `falkatop_1falkavezetoid` ORDER BY a DESC LIMIT 0, 5",$kapcsolat);
$i=1;
while($leker=mysql_fetch_object($useres)){
$ezust=mysql_query("SELECT * FROM `falkatop` WHERE falkatop_2falkavezetoid  = '". $leker->falkatop_1falkavezetoid ."'");
$bronz=mysql_query("SELECT * FROM `falkatop` WHERE falkatop_3falkavezetoid  = '". $leker->falkatop_1falkavezetoid ."'");

$adat.="<tr><td align=left width=20>". $i .".</td><td align=left width=230>". linker($leker->falkatop_1falkavezetoid,$leker->falkatop_1falkavezeto) ."</td><td align=center>". $leker->a ."<td align=center>". mysql_num_rows($ezust) ."</td><td align=center>". mysql_num_rows($bronz) ."</td></td></tr>";
$i++;
}
$adat.="</table></td><td width=11 background=pic/keret.jpg></td></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table>";
///
$adat.="</td></tr></table>";
////heti lista

$adat.="<br><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td><center><u><big>Eddigi Gyõztesek</big></u></center>
<table><tr><td align=center><i>Hét</i></td><td align=center><i>Gyõztes</i></td><td align=center><i>Második</i></td><td align=center><i>Harmadik</i></td></tr>";

$useres=mysql_query("SELECT * FROM `falkatop`ORDER BY falkatop_id desc",$kapcsolat);
while($leker=mysql_fetch_object($useres)){
$adat.="<tr><td align=center width=190>". $leker->falkatop_ido ."</td><td align=center width=210>". linker_falka($leker->falkatop_1falkaid, $leker->falkatop_1falka) ." (". linker($leker->falkatop_1falkavezetoid,$leker->falkatop_1falkavezeto) .")</td><td align=center width=230>". linker_falka($leker->falkatop_2falkaid, $leker->falkatop_2falka) ." (". linker($leker->falkatop_2falkavezetoid,$leker->falkatop_2falkavezeto) .")</td><td align=center width=210>". linker_falka($leker->falkatop_3falkaid, $leker->falkatop_3falka) ." (". linker($leker->falkatop_3falkavezetoid,$leker->falkatop_3falkavezeto) .")</td></tr>";
}

$adat.="</table></td><td width=11 background=pic/keret.jpg></td></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table></center>";


oldal($adat);
}else{header("Location: index.php");}
?>
