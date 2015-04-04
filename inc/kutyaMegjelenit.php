<?
include("sql.php");
include("session.php");
include("oop.php");
header("Content-Type: text/html; charset=ISO-8859-2");
$kuty=new kutya();
$kuty->GetKutyaByID($_GET[id]);
///majd fejleszteni
$tanul="";
if($kuty->Tanult("IR")){ $tanul.="Írni</br>"; }
if($kuty->Tanult("SZ")){ $tanul.="Számolni</br>"; }
if($kuty->Tanult("BR")){ $tanul.="Lottózni</br>"; }
if($kuty->Tanult("ER")){ $tanul.="Érettségizni</br>"; }
if($kuty->Tanult("FU")){ $tanul.="Fül befogása</br>"; }
if($kuty->Tanult("KE")){ $tanul.="Kereskedés</br>"; }
if($kuty->Tanult("VE")){ $tanul.="Kvíz</br>"; }
echo '
<p align=right><a href = "javascript:void(0)" onclick = "info(1)" class="feherlink">Bezár [x]</a></p>
<TABLE BORDER="0">
<tr>
<td><table border="0"><tr><td align=left>Név:</td><td>'. $kuty->NevMegjelenitRanggal() .'</td></tr>
<tr><td align=left>Sorszám:</td><td>'. $kuty->id .'</td></tr>
<tr><td align=left>Fajta:</td><td>'. kutyaszamtonev($kuty->fajta) .'</td></tr>
<tr><td align=left>Nem:</td><td>'. $kuty->nem .'</td></tr>
<tr><td align=left>Pénz:</td><td id="penz">'. penz($kuty->penz) .'</td></tr>
<tr><td align=left>Gének:</td><td id="genek">'. $kuty->GenMegjelenit() .'</td></tr>
<tr><td align=left valign=top>Leckék:</td><td>'. $tanul .'</td></tr></table><br>

<table><tr><th align=left>Egészség: </th><th align=right>'. $kuty->egeszseg .'%</th></tr><tr><td colspan=2>'. $kuty->EgeszsegCsik($kuty->egeszseg*2) .'</td></tr><tr><th align=left>Súly: </th><th align=right>'. $kuty->suly .'%</th></tr><tr><td colspan=2>'. $kuty->SulyCsik($kuty->suly*2) .'</td></tr></table><br>

<table border=0 cellpadding=0 cellspacing=0><tr><th align=left colspan=7>Étel: (még <span id=\"kajakiir\">'. $kuty->kaja .'</span> napra elég van) 
</th></tr><tr id="talak">'. $kuty->Talak().'</tr></table>


</td>
<td>
<TABLE BORDER="0"><tr><td align=center>'. $kuty->NevMegjelenitRanggal() .' már '. $kuty->kor .' napja született!</td></tr><tr><td>'. $kuty->Kep() .'</td></tr></TABLE>
</td></tr>
</TABLE>';
?>