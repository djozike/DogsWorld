<?php
include("inc/sql.php");
include("inc/session.php");
include("inc/functions.php");
if(isset($_SESSION['nev'])){
header("Location: kutyam.php");
}else{
$js='<SCRIPT LANGUAGE="JavaScript">';
$js.="
function ChangeCamel(i)
{
document.getElementById('kutya').src = 'pic/kutyak/'+i+'1.png';
}</SCRIPT><form method=POST action=inc/regisztracio.php>";



$adat="<center><big><big><u>�j kutya regisztr�ci�</big></big></u></center><br><center>�j kutya regisztr�ci�j�hoz meg kell adnod n�h�ny adatot. Figyelmes l�gy mivel a jelsz� �s e-mail c�m kiv�tel�vel m�r nem v�ltoztathatsz rajt. Az e-mail c�med bizalmasan kezelj�k. K�rj�k, a te �rdekedben min�l bonyolultabb jelsz�t adj meg. A jobb oldali k�pen l�thatod hogy fog kin�zni a kuty�d. A regisztr�ci� gomb megnyom�s�val egyben az �ltal�nos Felhaszn�l�i Felt�teleket �s Adatv�delmi szab�lyzatot is elfogadod.</center><br>
<center><table border=0><tr><td>". $js ."
<table><tr><td align=left>Kuty�d neve:</td><td><input type=text name='nev'></td><td align=left><small>min 3, max 16 karakter</small></td></tr>
<tr><td align=left>Jelsz�:</td><td><input type=password name='jelszo'></td><td align=left><small>min 4, max 16 karakter</small></td></tr>
<tr><td align=left>Jelsz� �jra:</td><td><input type=password name='jelszo2'></td></tr>
<tr><td align=left>E-mail:</td><td><input type=text name='mail'></td><td align=left><small>max 40 karakter</small></td></tr>
<tr><td align=left>Kuty�d fajt�ja:</td><td>";
$adat.='<SELECT name="haz" onchange="ChangeCamel(this.options[this.options.selectedIndex].value);">';
$fajtak=mysql_query("SELECT * FROM fajta WHERE fajta_id > '-1' ORDER BY fajta_nev ");
while($fajta=mysql_fetch_object($fajtak)){
$adat.='<OPTION value="'.  $fajta->fajta_file .'">'. $fajta->fajta_nev .'</OPTION>';
}

$adat.='</SELECT>
</td></tr>
<tr><td align=left>Kuty�d neme:</td><td><SELECT name=nem>
<option value=0 selected>V�lassz!</option><option value=1>N�st�ny</option><option value=2>Kan</option></td></tr><tr><td></td><td></td><td><input type=submit name=rendben value=Regisztr�ci� style="width:100px;"></td></tr>
</table></form>
</td><td><IMG SRC="pic/kutyak/Akita1.png" NAME="kutya" id="kutya" style="float:right" / ></td></tr></table>';
if(isset($_SESSION[hiba])){
$adat.=$_SESSION[hiba];
$_SESSION[hiba]="";
}
$adat.='</center>';
oldal($adat);
}
?>
