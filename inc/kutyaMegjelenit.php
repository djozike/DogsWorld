<?
include("sql.php");
include("session.php");
include("oop.php");
header("Content-Type: text/html; charset=ISO-8859-2");
$kuty=new kutya();
$kuty->GetKutyaByID($_GET[id]);
///majd fejleszteni
$tanul="";
if($kuty->Tanult("IR")){ $tanul.="�rni</br>"; }
if($kuty->Tanult("SZ")){ $tanul.="Sz�molni</br>"; }
if($kuty->Tanult("BR")){ $tanul.="Lott�zni</br>"; }
if($kuty->Tanult("ER")){ $tanul.="�retts�gizni</br>"; }
if($kuty->Tanult("FU")){ $tanul.="F�l befog�sa</br>"; }
if($kuty->Tanult("KE")){ $tanul.="Keresked�s</br>"; }
if($kuty->Tanult("VE")){ $tanul.="Kv�z</br>"; }
echo '
<p align=right><a href = "javascript:void(0)" onclick = "info(1)" class="feherlink">Bez�r [x]</a></p>
<TABLE BORDER="0">
<tr>
<td><table border="0"><tr><td align=left>N�v:</td><td>'. $kuty->NevMegjelenitRanggal() .'</td></tr>
<tr><td align=left>Sorsz�m:</td><td>'. $kuty->id .'</td></tr>
<tr><td align=left>Fajta:</td><td>'. kutyaszamtonev($kuty->fajta) .'</td></tr>
<tr><td align=left>Nem:</td><td>'. $kuty->nem .'</td></tr>
<tr><td align=left>P�nz:</td><td id="penz">'. penz($kuty->penz) .'</td></tr>
<tr><td align=left>G�nek:</td><td id="genek">'. $kuty->GenMegjelenit() .'</td></tr>
<tr><td align=left valign=top>Leck�k:</td><td>'. $tanul .'</td></tr></table><br>

<table><tr><th align=left>Eg�szs�g: </th><th align=right>'. $kuty->egeszseg .'%</th></tr><tr><td colspan=2>'. $kuty->EgeszsegCsik($kuty->egeszseg*2) .'</td></tr><tr><th align=left>S�ly: </th><th align=right>'. $kuty->suly .'%</th></tr><tr><td colspan=2>'. $kuty->SulyCsik($kuty->suly*2) .'</td></tr></table><br>

<table border=0 cellpadding=0 cellspacing=0><tr><th align=left colspan=7>�tel: (m�g <span id=\"kajakiir\">'. $kuty->kaja .'</span> napra el�g van) 
</th></tr><tr id="talak">'. $kuty->Talak().'</tr></table>


</td>
<td>
<TABLE BORDER="0"><tr><td align=center>'. $kuty->NevMegjelenitRanggal() .' m�r '. $kuty->kor .' napja sz�letett!</td></tr><tr><td>'. $kuty->Kep() .'</td></tr></TABLE>
</td></tr>
</TABLE>';
?>