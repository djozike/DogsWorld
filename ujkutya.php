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



$adat="<center><big><big><u>Új kutya regisztráció</big></big></u></center><br><center>Új kutya regisztrációjához meg kell adnod néhány adatot. Figyelmes légy mivel a jelszó és e-mail cím kivételével már nem változtathatsz rajt. Az e-mail címed bizalmasan kezeljük. Kérjük, a te érdekedben minél bonyolultabb jelszót adj meg. A jobb oldali képen láthatod hogy fog kinézni a kutyád. A regisztráció gomb megnyomásával egyben az Általános Felhasználói Feltételeket és Adatvédelmi szabályzatot is elfogadod.</center><br>
<center><table border=0><tr><td>". $js ."
<table><tr><td align=left>Kutyád neve:</td><td><input type=text name='nev'></td><td align=left><small>min 3, max 16 karakter</small></td></tr>
<tr><td align=left>Jelszó:</td><td><input type=password name='jelszo'></td><td align=left><small>min 4, max 16 karakter</small></td></tr>
<tr><td align=left>Jelszó újra:</td><td><input type=password name='jelszo2'></td></tr>
<tr><td align=left>E-mail:</td><td><input type=text name='mail'></td><td align=left><small>max 40 karakter</small></td></tr>
<tr><td align=left>Kutyád fajtája:</td><td>";
$adat.='<SELECT name="haz" onchange="ChangeCamel(this.options[this.options.selectedIndex].value);">';
$fajtak=mysql_query("SELECT * FROM fajta WHERE fajta_id > '-1' ORDER BY fajta_nev ");
while($fajta=mysql_fetch_object($fajtak)){
$adat.='<OPTION value="'.  $fajta->fajta_file .'">'. $fajta->fajta_nev .'</OPTION>';
}

$adat.='</SELECT>
</td></tr>
<tr><td align=left>Kutyád neme:</td><td><SELECT name=nem>
<option value=0 selected>Válassz!</option><option value=1>Nõstény</option><option value=2>Kan</option></td></tr><tr><td></td><td></td><td><input type=submit name=rendben value=Regisztráció style="width:100px;"></td></tr>
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
