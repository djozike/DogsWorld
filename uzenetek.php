<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[nev])){
function menu(){
include("inc/sql.php");
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$mod=" | <a href=uzenetek.php?page=bejelent class='feherlink'>Bejelentett levelek</a>";
}
$adat="<center><a href=uzenetek.php class='feherlink'>Bej�v� �zenetek</a> | <a href=uzenetek.php?page=kimeno class='feherlink'>Kimen� �zenetek</a> | <a href=uzenetek.php?page=tilto class='feherlink'>Tilt�lista</a>". $mod ."<br><br><a href=uzenetek.php?page=uzenetir><img src=pic/levelneki.jpg alt='Lev�l �r�s' border=0></a> <a href=uzenetek.php?page=penztkuld><img src=pic/penzneki.jpg alt='Lev�l �r�s' border=0></a></center>";

return $adat;
}
if($_GET[page]=="kimeno"){
$adat=menu();
$adat.="<center>A villog� levelet, a c�mzett m�g nem olvasta el!<br>
A t�rl�sre kattintva csak az elk�ld�tt levelek list�r�l t�rl�dik a lev�l, a c�mzett
m�g mindig elolvashatja!<br>". hiba("Figyelem! a ". $LEVELTORLES ." napn�l r�gebbi olvasott levelek automatikusan t�rl�dnek.") ."</center><br>";
$leker=mysql_query("SELECT * FROM uzenetek WHERE uzenet_kuldo = '". $_SESSION[id] ."' and uzenet_torol_kuldo = '0' ORDER BY uzenet_id DESC");
if(mysql_num_rows($leker)>0){
$adat.="<center><table><tr><td><td width=200 align=center>N�v<td width=200 align=center>Id�<td align=50></tr>";
while($uzenet=mysql_fetch_object($leker)){
$nevet=mysql_query("SELECT kutya_nev, kutya_betuszin FROM kutya WHERE kutya_id = '". $uzenet->uzenet_kapo ."'");
if(mysql_num_rows($nevet)>0){
while($kutyaja=mysql_fetch_object($nevet)){
if($kutyaja->kutya_betuszin=="774411"){
$kapo=htmlentities($kutyaja->kutya_nev);
}else{
$kapo="<font color=#". $kutyaja->kutya_betuszin .">". htmlentities($kutyaja->kutya_nev) ."</font>";
}
}
}else{
$kapo="<i>T�r�lt kutya</i>";
}$kep=2;
if($uzenet->uzenet_olvas==0){$kep="";}

$adat.="<tr><td><a href=uzenetek.php?id=". $uzenet->uzenet_id  ."><img src=pic/level". $kep .".gif border=0></a><td align=center><a href=uzenetek.php?id=". $uzenet->uzenet_id  ." class='feherlink'>". $kapo ."</a><td>". str_replace("-",".",$uzenet->uzenet_ido) ."<td align=right><a href=inc/torol.php?id=". $uzenet->uzenet_id ."><img src=pic/kuka.png border=0></a></tr>";

}
$adat.="</table></center>";
}else{
$adat.="<center>". hiba("Nincs kimen� �zeneted!") ."</center>";
}
}elseif($_GET[page]=="tilto"){
$adat=menu();
$adat.="<center>Ha valaki �lland�an zaklat �s m�r nem vagy r� k�v�ncsi,<br> itt letilthat�d �s nem kapsz t�le t�bb levelet!";
if($_SESSION[hiba]!=""){
$adat.="<br>". $_SESSION[hiba];
$_SESSION[hiba]="";}
$leker=mysql_query("SELECT * FROM `kutya` WHERE `kutya_id`='". $_SESSION[id] ."'");
while($user=mysql_fetch_object($leker)){
if(substr_count($user->kutya_tanul,"FU")==0){
$adat.=hiba("<br>M�g nem tanulta meg a kuty�d a f�l�t befogni, ez�rt nem tilthatsz le senkit!");
}else{
$adat.="<table><tr><td>Kutya neve:</td><td><form method=POST action=inc/tilto.php><input type=text name=nev></td><td><input type=submit value=Elk�ld style='width:60px'></form></td></tr></table><br>";
$lekeres=mysql_query("SELECT * FROM tilto WHERE tilto_tilto = '". $_SESSION[id] ."'");
if(mysql_num_rows($lekeres)>0){
$adat.="<table border=0>";
while($kutya=mysql_fetch_object($lekeres)){
$lekeres2=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $kutya->tilto_tiltott ."'");
while($kutyak=mysql_fetch_object($lekeres2)){
if($kutyak->kutya_betuszin=="774411"){
$adat.="<tr><td><li></td><td align=left width=80><a href=kutyak.php?id=". $kutyak->kutya_id ." class='feherlink'>". htmlentities($kutyak->kutya_nev) ."</a></td><td><a href=inc/tiltotorol.php?id=". $kutyak->kutya_id ."><img src=pic/kuka.png border=0></a></td></tr>";
}else{
$adat.="<tr><td><li></td><td align=left width=80><a href=kutyak.php?id=". $kutyak->kutya_id ." class='feherlink'><font color=#". $kutyak->kutya_betuszin .">". htmlentities($kutyak->kutya_nev) ."</font></a></td><td><a href=inc/tiltotorol.php?id=". $kutyak->kutya_id ."><img src=pic/kuka.png border=0></a></td></tr>";
}
}
}
$adat.="</table>";
}else{
$adat.=ok("Nincs senki a tilt�list�don!");
}
$adat.="</center>";
}}
}elseif($_GET[page]=="uzenetir"){
if(isset($_GET[uid])){
$leker=mysql_query("SELECT kutya_nev, kutya_betuszin FROM kutya WHERE kutya_id = '". $_GET[uid] ."'");
if(mysql_num_rows($leker)>0){
while($neve=mysql_fetch_object($leker)){
if($neve->kutya_betuszin=="774411"){
$cimzett="<input type=hidden name=nev value='". $neve->kutya_nev ."'>". htmlentities($neve->kutya_nev);
}else{
$cimzett="<input type=hidden name=nev value='". $neve->kutya_nev ."'><font color=#". $neve->kutya_betuszin .">". htmlentities($neve->kutya_nev) ."</font>";
}
}
}else{
$cimzett="<input type=text name=nev>";
}
}else{
$cimzett="<input type=text name=nev>";
}
$adat="<form method=POST action=inc/levelez.php><center><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td align=left width=580>
<br><center><big><big><b>�zenet �r�s</b></big></big></center><br>
<center><table><tr><td>
<table border=0><tr><td align=left>Felad�:<td align=right>". htmlentities($_SESSION[nev]) ."</tr><tr><td align=left>C�mzett:</td><td align=right>". $cimzett ."</tr></table>
</td><td width=15></td><td width=300><b>Figyelem!</b> Az �zenetben haszn�lhatod a k�vetkez� UBB k�dokat is!<br>[center]...[/center] - k�z�pre igaz�t�s<br>[img]k�p link[/img] - k�p beszur�s<br>[color=sz�n]...[/color] - sz�veg sz�nez�s</td></tr></table><br>�zeneted:<br><TEXTAREA name='uzenet' cols=50 rows=12></TEXTAREA><br><br><input type=submit name=Elkuld value=K�ld�s></form>". $_SESSION[hiba] ."</center><br>
</td><th width=11 background=pic/keret.jpg></th></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th width=11 background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table></center>";
$_SESSION[hiba]="";
}elseif($_GET[page]=="penztkuld"){

if(isset($_GET[uid])){
$leker=mysql_query("SELECT kutya_nev, kutya_betuszin FROM kutya WHERE kutya_id = '". $_GET[uid] ."'");
if(mysql_num_rows($leker)>0){
while($neve=mysql_fetch_object($leker)){
if($neve->kutya_betuszin=="774411"){
$cimzett="<input type=hidden name=nev value='". $neve->kutya_nev ."'>". htmlentities($neve->kutya_nev);
}else{
$cimzett="<input type=hidden name=nev value='". $neve->kutya_nev ."'><font color=#". $neve->kutya_betuszin .">". htmlentities($neve->kutya_nev) ."</font>";
}
}
}else{
$cimzett="<input type=text name=nev>";
}
}else{
$cimzett="<input type=text name=nev>";
}$ar="";
for($i=2;$i<10;$i++){
$ar.="<option value=". $i .">". $i ." csont</option>";
}
$adat='<script src="script/levelez.js"></script>';
$adat.="<form method=POST action=inc/levelez.php><center><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td align=left width=580>
<br><center><big><big><b>P�nz k�ld�s</b></big></big></center><br>
<center><table><tr><td>
<table border=0><tr><td align=left>Felad�:<td align=right>". htmlentities($_SESSION[nev]) ."</tr><tr><td align=left>C�mzett:</td><td align=right>". $cimzett ."</tr><tr><td align=left>�sszeg:</td><td align=right><select name=penz id=penzselect onchange='KapottPenz(".$PENZKULDOSZAZALEK.")'>". $ar ."</select></td></tr><tr><td>Meg�rkez� �sszeg:</td><td id=megerkezoosszeg>". Penz(200*$PENZKULDOSZAZALEK) ."</td></tr></table>
</td><td width=15></td><td width=300><b>Figyelem!</b> A megjegyz�sben nem haszn�lhatsz UBB k�dokat!<br>A k�ldeni kiv�nt �sszegb�l levon�sra ker�l ". (1-$PENZKULDOSZAZALEK)*100 ."% k�zbes�t�si d�j! Teh�t ha 5 csontot k�ldesz csak ". penz($PENZKULDOSZAZALEK*100*5) ." �rkezik meg!</td></tr></table><br>Megjegyz�s:<br><TEXTAREA name='uzenet' cols=50 rows=12></TEXTAREA><br><br><input type=submit name=Elkuld value=K�ld�s></form>". $_SESSION[hiba] ."</center><br>
</td><th width=11 background=pic/keret.jpg></th></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th width=11 background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table></center>";
$_SESSION[hiba]="";
}elseif($_GET[page]=="bejelent"){
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$adat=menu() ."<center>Itt a m�sok �ltal szab�lytalannak v�lt mag�nleveleket l�that�d,<br> mivel szab�lyellenesnek jelentett�k beleolvashatsz a levelekbe.
<br><br>";
$leker=mysql_query("SELECT * FROM uzenetek WHERE uzenet_tipus > 0 ORDER BY uzenet_id DESC");
if(mysql_num_rows($leker)>0){
$adat.="<table><tr><td><td width=200 align=center>K�ld� neve<td width=200 align=center>Bejelent� neve<td width=200 align=center>Id�<td align=50></tr>";
while($uzi=mysql_fetch_object($leker)){
$lekerbejelent=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $uzi->uzenet_tipus ."'");
$lekerkapo=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $uzi->uzenet_kuldo ."'");
while($bej=mysql_fetch_object($lekerbejelent)){
while($kaponeve=mysql_fetch_object($lekerkapo)){
if($kaponeve->kutya_betuszin=="774411"){
$kapo=htmlentities($kaponeve->kutya_nev);
}else{
$kapo="<font color=#". $kaponeve->kutya_betuszin .">". htmlentities($kaponeve->kutya_nev) ."</font>";
}
if($bej->kutya_betuszin=="774411"){
$bejelent=htmlentities($bej->kutya_nev);
}else{
$bejelent="<font color=#". $bej->kutya_betuszin .">". htmlentities($bej->kutya_nev) ."</font>";
}
$adat.="<tr><td><a href=uzenetek.php?id=". $uzi->uzenet_id  ."><img src=pic/level2.gif border=0></a><td align=center><a href=uzenetek.php?id=". $uzi->uzenet_id  ." class='feherlink'>". $kapo ."</a><td align=center><a href=uzenetek.php?id=". $uzi->uzenet_id  ." class='feherlink'>". $bejelent ."</a></td><td>". $uzi->uzenet_ido ."<td align=right><a href=inc/bejtorol.php?id=". $uzi->uzenet_id ."><img src=pic/kuka.png border=0></a></tr>";
}
}
}

$adat.="</table></center>";
}else{
$adat.=ok("Nincs bejentett lev�l!") ."</center>";
}
}else{
$adat=hiba("Nincs jogosults�god az oldal megtekint�s�hez!");
}
}else{
if(isset($_GET[id])){
$leker=mysql_query("SELECT * FROM uzenetek WHERE uzenet_id = '". $_GET[id] ."'");
if(mysql_num_rows($leker)>0){
while($uzenet=mysql_fetch_object($leker)){
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(($_SESSION[id]==$uzenet->uzenet_kapo) || ($_SESSION[id]==$uzenet->uzenet_kuldo) || (mysql_num_rows($modie)>0 && $uzenet->uzenet_tipus!=0)){
$adat.="<center><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td align=left width=500>";
$kuldo="<i>T�r�lt kutya</i>";

if($uzenet->uzenet_kuldo!=0){
$kuldonev=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $uzenet->uzenet_kuldo ."'");
while($kuldoneve=mysql_fetch_object($kuldonev)){
if($kuldoneve->kutya_betuszin=="774411"){
$kuldo=htmlentities($kuldoneve->kutya_nev);
}else{
$kuldo="<font color=#". $kuldoneve->kutya_betuszin .">". htmlentities($kuldoneve->kutya_nev) ."</font>";
}
}
}else{
$kuldo="Dogs World";
}
$kapo="<i>T�r�lt kutya</i>";
$kaponev=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $uzenet->uzenet_kapo ."'");
while($kaponeve=mysql_fetch_object($kaponev)){
if($kaponeve->kutya_betuszin=="774411"){
$kapo=htmlentities($kaponeve->kutya_nev);
}else{
$kapo="<font color=#". $kaponeve->kutya_betuszin .">". htmlentities($kaponeve->kutya_nev) ."</font>";
}
}
if($uzenet->uzenet_kapo==$_SESSION[id]){
mysql_query("UPDATE uzenetek SET uzenet_olvas = 1 WHERE uzenet_id = '". $uzenet->uzenet_id ."'");
}
$adat.='<script>
function confirmDeletem() {
  if (confirm("Biztos bejelented mint szab�lys�rt� lev�l? Ha nem az, te kaphatsz b�ntet�st �rte.")) {
    document.location = "inc/szabalys.php?id='. $uzenet->uzenet_id .'";
  }
}

</script>';
$adat.="<center><table border=0 width=480><tr><td colspan=3><table border=0><tr><td align=left>K�ld�:<td align=right><a href=kutyak.php?id=". $uzenet->uzenet_kuldo ." class='feherlink'>". $kuldo ."</a></td></tr>
<tr><td align=left>C�mzett:<td align=right><a href=kutyak.php?id=". $uzenet->uzenet_kapo ." class='feherlink'>". $kapo ."</a></td></tr>
<tr><td align=left>K�ld�s ideje:<td align=right>". str_replace("-",".",$uzenet->uzenet_ido) ."</td></tr>
</table></td></tr><tr><td colspan=3 height=3 background=pic/keret.jpg></td></tr><tr><td colspan=3 align=left>". nl2br($uzenet->uzenet_tartalom) ."</td></tr><tr><td colspan=3 height=3 background=pic/keret.jpg></td></tr><tr><td align=center><a href=uzenetek.php?page=uzenetir&uid=". $uzenet->uzenet_kuldo ." class=feherlink>V�lasz</a></td><td align=center><a href=inc/torol.php?id=". $uzenet->uzenet_id ." class='feherlink'>T�r�l</a></td><td align=center><a href='javascript:confirmDeletem()' class='feherlink'>Szab�lyzat ellenes lev�l jelz�se</a></td></tr></table></center>";


$adat.="</td><th width=11 background=pic/keret.jpg></th></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th width=11 background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table>". $_SESSION[hiba] ."</center>";
$_SESSION[hiba]="";
}else{ header("Location: uzenetek.php");}
}
}else{ header("Location: uzenetek.php");}
}else{
$adat=menu();
$adat.='<center>Ha levelet szeretn�l t�r�lni kattints a kuk�ra, a villog� leveleket m�g nem olvastad!<br> Ha valami szab�lyzat ellenes tartalmat �szlelsz a lev�lben, kattints a "Szab�lyzat ellenes lev�l jelz�se" gombra.<br>'. hiba("Figyelem! a ".  $LEVELTORLES  ." napn�l r�gebbi olvasott levelek automatikusan t�rl�dnek.") .'</center><br>';

$leker=mysql_query("SELECt * FROM uzenetek WHERE uzenet_kapo = '". $_SESSION[id] ."' and uzenet_torol_kapo = '0' ORDER BY uzenet_id DESC");
if(mysql_num_rows($leker)>0){
$adat.="<center><form action=inc/oszleveltorol.php method=POST><table><tr><td width=280 align=center colspan=3>N�v<td width=200 align=center>Id�<td align=50></tr><input type=hidden name=ossz value=". mysql_num_rows($leker) .">\n";
$i=1;
while($uzenet=mysql_fetch_object($leker)){

if($uzenet->uzenet_kuldo!=0){
$nevet=mysql_query("SELECT kutya_nev, kutya_betuszin FROM kutya WHERE kutya_id = '". $uzenet->uzenet_kuldo ."'");
if(mysql_num_rows($nevet)>0){
while($kutyaja=mysql_fetch_object($nevet)){
if($kutyaja->kutya_betuszin=="774411"){
$kapo=htmlentities($kutyaja->kutya_nev);
}else{
$kapo="<font color=#". $kutyaja->kutya_betuszin .">". htmlentities($kutyaja->kutya_nev) ."</font>";
}
}
}else{
$kapo="<i>T�r�lt kutya</i>";
}
$kep="level2";
if($uzenet->uzenet_olvas==0){$kep="level";}

}else{
$kep="mydog";
$kapo="Dogs World";
}
$adat.="<tr><td align=right><input type=checkbox name=". $i ." value=". $uzenet->uzenet_id ." style='width: 10px' id='". $i ."'></td><td><a href=uzenetek.php?id=". $uzenet->uzenet_id  ."><img src=pic/". $kep .".gif border=0></a><td align=center width=270><a href=uzenetek.php?id=". $uzenet->uzenet_id  ." class='feherlink'>". $kapo ."</a><td>". str_replace("-",".",$uzenet->uzenet_ido) ."<td align=right><a href=inc/torol.php?id=". $uzenet->uzenet_id ."><img src=pic/kuka.png border=0></a></tr> \n";
$i++;

}
$adat.='<SCRIPT LANGUAGE="JavaScript">
<!--

<!-- Begin
function CheckAll()
{ ';
for($i=1; $i<=mysql_num_rows($leker); $i++){
 $adat.="document.getElementById('". $i ."').checked = true ;";
 }
$adat.='}
// End -->
</script>';
$adat.="</table><br><input type=button name=a value='�sszes lev�l kijel�l�se' style='width:170px;' onClick='CheckAll()'>  <input type=submit name=ok value='Kijel�lt levelek t�rl�se' style='width:200px;'></center></form>";
}else{
$adat.="<center>". hiba("Nincs bej�v� �zeneted!") ."</center>";
}
}
}


oldal($adat);
}else{header("Location: index.php");}
	?>
