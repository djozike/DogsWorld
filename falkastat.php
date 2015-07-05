<?
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[nev])){
$adat="<center><table><tr><td>";

class OrokranglistaTagok
{
var $id;
var $nev;
var $arany=0;
var $ezust=0;
var $bronz=0;
   function OrokranglistaTagok($id, $nev, $arany, $ezust, $bronz) {
        $this->id=$id;
        $this->nev=$nev;
        $this->arany=$arany;
        $this->ezust=$ezust;
        $this->bronz=$bronz;
    }
}
//falka kereses
function keres($nev)
{
global $randlista;
for($i=0;$i<sizeof($randlista);$i++)
{
   if($randlista[$i]->nev==$nev)
   {
   return $i;
   }
}
return 0;
}
//vezeto kereses
function keresVezeto($nev)
{
global $vezetorandlista;
for($i=0;$i<sizeof($vezetorandlista);$i++)
{
   if($vezetorandlista[$i]->nev==$nev)
   {
   return $i;
   }
}
return 0;
}
function rendez($a, $b)
{
    if ($a->arany == $b->arany) {
            if ($a->ezust == $b->ezust) {
                       if ($a->bronz == $b->bronz) {
                       return 0;
                       }
                       return ($a->bronz < $b->bronz) ? 1 : -1;
            }
            return ($a->ezust < $b->ezust) ? 1 : -1;
    }
    return ($a->arany < $b->arany) ? 1 : -1;
}
//falka
$randlista[]= new OrokranglistaTagok(0,"test",0,0,0);
$eredmenyek=mysql_query("SELECT * FROM `falkatop`",$kapcsolat);
while($er=mysql_fetch_object($eredmenyek))
{
if(keres($er->falkatop_1falka)==0)
{
$randlista[]=new OrokranglistaTagok($er->falkatop_1falkaid,$er->falkatop_1falka,1,0,0);
}else{
$randlista[keres($er->falkatop_1falka)]->arany++;
}
if(keres($er->falkatop_2falka)==0)
{
$randlista[]=new OrokranglistaTagok($er->falkatop_2falkaid,$er->falkatop_2falka,0,1,0);
}else{
$randlista[keres($er->falkatop_2falka)]->ezust++;
}
if(keres($er->falkatop_3falka)==0)
{
$randlista[]=new OrokranglistaTagok($er->falkatop_3falkaid,$er->falkatop_3falka,0,0,1);
}else{
$randlista[keres($er->falkatop_3falka)]->bronz++;
}

}
//vezeto
$eredmenyek=mysql_query("SELECT * FROM `falkatop`",$kapcsolat);
$vezetorandlista[]= new OrokranglistaTagok(0,"test",0,0,0);
while($er=mysql_fetch_object($eredmenyek))
{
if(keresVezeto($er->falkatop_1falkavezeto)==0)
{
$vezetorandlista[]=new OrokranglistaTagok($er->falkatop_1falkavezetoid,$er->falkatop_1falkavezeto,1,0,0);
}else{
$vezetorandlista[keresVezeto($er->falkatop_1falkavezeto)]->arany++;
}
if(keresVezeto($er->falkatop_2falkavezeto)==0)
{
$vezetorandlista[]=new OrokranglistaTagok($er->falkatop_2falkavezetoid,$er->falkatop_2falkavezeto,0,1,0);
}else{
$vezetorandlista[keresVezeto($er->falkatop_2falkavezeto)]->ezust++;
}
if(keresVezeto($er->falkatop_3falkavezeto)==0)
{
$vezetorandlista[]=new OrokranglistaTagok($er->falkatop_3falkavezetoid,$er->falkatop_3falkavezeto,0,0,1);
}else{
$vezetorandlista[keresVezeto($er->falkatop_3falkavezeto)]->bronz++;
}

}
usort($randlista,"rendez");
usort($vezetorandlista,"rendez");
$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td><center><u><big>Örök ranglista falka szerint</big></u></center><table><tr><th width=20></th><th width=210 align=center>Név</th><th align=center width=20><img src=pic/Med_1.png></th><th align=center width=20><img src=pic/Med_2.png></th><th align=center width=20><img src=pic/Med_3.png></th></tr>";
//örökranglista
for($i=0; $i<10;$i++)
{
	$adat.="<tr><td align=left width=20>". ($i+1) .".</td><td align=left width=230>". linker_falka($randlista[$i]->id,$randlista[$i]->nev) ."</td><td align=center>". $randlista[$i]->arany ."<td align=center>". $randlista[$i]->ezust ."</td><td align=center>". $randlista[$i]->bronz ."</td></td></tr>";
}
$adat.="</table></td><td width=11 background=pic/keret.jpg></td></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table>";
///
$adat.="</td><td width=120></td><td>";
///vezetõ lista
$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td><center><u><big>Örök ranglista vezetõ szerint</big></u></center><table><tr><th width=20></th><th width=210 align=center>Név</th><th align=center width=20><img src=pic/Med_1.png></th><th align=center width=20><img src=pic/Med_2.png></th><th align=center width=20><img src=pic/Med_3.png></th></tr>";
for($i=0; $i<10;$i++)
{
	$adat.="<tr><td align=left width=20>". ($i+1) .".</td><td align=left width=230>". linker($vezetorandlista[$i]->id,$vezetorandlista[$i]->nev) ."</td><td align=center>". $vezetorandlista[$i]->arany ."<td align=center>". $vezetorandlista[$i]->ezust ."</td><td align=center>". $vezetorandlista[$i]->bronz ."</td></td></tr>";
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
