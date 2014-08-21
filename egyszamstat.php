<?
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
include("inc/stilus.php");
if(isset($_SESSION[id])){
$aktEredmeny="<center><u><big>Eheti TOP 10</big></u></center><table border=0 cellspacing=0><tr><th width=15 align=center>#</th><th width=210 align=center>Név</th><th align=center width=65>Pont</th></tr>";
$useres=mysql_query("SELECT * FROM `egyszampontok` ORDER BY egyszampontok_pont  desc limit 0, 10",$kapcsolat);
$i=1;
while($leker=mysql_fetch_object($useres)){
$kutyus=new kutya();
$kutyus->GetKutyaByID($leker->egyszampontok_kid);
switch($i)
{
case 1:
$szin="bgcolor=#FFD700";
break;
case 2:
$szin="bgcolor=#BFC1C2";
break;
case 3:
$szin="bgcolor=#CD7F32";
break;
default:
$szin="";
break;

}
$aktEredmeny.="<tr ". $szin ."><td align=left>". $i .".</td><td align=left>". $kutyus->NevMegjelenitLinkelve() ."</td><td align=right>". $kutyus->egyszampont ." pont</td></tr>";
$i++;
}
$aktEredmeny.="</table>";

////örökranglista
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


$randlista[]= new OrokranglistaTagok(0,"test",0,0,0);
$eredmenyek=mysql_query("SELECT * FROM `egyszam`",$kapcsolat);
while($er=mysql_fetch_object($eredmenyek))
{
if(keres($er->egyszam_1nev)==0)
{
$randlista[]=new OrokranglistaTagok($er->egyszam_1id,$er->egyszam_1nev,1,0,0);
}else{
$randlista[keres($er->egyszam_1nev)]->arany++;
}
if(keres($er->egyszam_2nev)==0)
{
$randlista[]=new OrokranglistaTagok($er->egyszam_2id,$er->egyszam_2nev,0,1,0);
}else{
$randlista[keres($er->egyszam_2nev)]->ezust++;
}
if(keres($er->egyszam_3nev)==0)
{
$randlista[]=new OrokranglistaTagok($er->egyszam_3id,$er->egyszam_3nev,0,0,1);
}else{
$randlista[keres($er->egyszam_3nev)]->bronz++;
}

}
usort($randlista,"rendez");

$orokEredmeny.="<center><u><big>Örök ranglista</big></u></center><table border=0 cellspacing=0><tr><th width=15 align=center>#</th><th width=200 align=center>Név</th><th align=center width=20><img src=pic/Med_1.png></th><th align=center width=20><img src=pic/Med_2.png></th><th align=center width=20><img src=pic/Med_3.png></th></tr>";
for($i=0; $i<10;$i++)
{
$orokEredmeny.="<tr><td align=left>". ($i+1) .".</td><td align=left>". linker($randlista[$i]->id,$randlista[$i]->nev) ."</td><td align=center>". $randlista[$i]->arany ."</td><td align=center>". $randlista[$i]->ezust ."</td><td align=center>". $randlista[$i]->bronz ."</td></tr>";
}
$orokEredmeny.="</table>";
///regieredmenyek
$regiEredmenyek="<center><u><big>Eddigi Gyõztesek</big></u></center><table><tr><th align=center colspan=3 width=250>Hét</th><th align=center>Gyõztes</th><th align=center>Második</th><th align=center>Harmadik</th></tr>";

$useres=mysql_query("SELECT * FROM `egyszam`ORDER BY egyszam_id desc",$kapcsolat);
while($leker=mysql_fetch_object($useres)){
$idok=explode(" - ",$leker->egyszam_ido);
$regiEredmenyek.="<tr><td align=left width=100>". $idok[0] ."</td><td>- </td><td align=left width=100>". $idok[1] ."</td><td align=center width=150>". linker($leker->egyszam_1id,$leker->egyszam_1nev) ."</a></td><td align=center width=150>". linker($leker->egyszam_2id,$leker->egyszam_2nev) ."</td><td align=center width=150>". linker($leker->egyszam_3id,$leker->egyszam_3nev) ."</td></tr>";
}

$regiEredmenyek.="</table>";

$adat="<center><big><big><u>Egyszám játék statisztika</u></big></big><table border=0 cellpadding=18 cellspacing=0><tr><td>". 
        KeretesMenu(300, $aktEredmeny)."</td><td>". KeretesMenu(300, $orokEredmeny) ."</td></tr></table>". KeretesMenu(650,$regiEredmenyek). "</center>";
oldal($adat);
}else{header("Location: index.php");}
?>
