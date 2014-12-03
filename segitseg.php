<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");

function rangtotext($rang)
{
    switch($rang){
      case 1: 
       return "Moder�tor";
      case 2:
        return "F�moder�tor";
      case 3:
        return "Adminisztr�tor";
      default:
        return "Felhaszn�l�"; 
    }
}

if($_GET[page]=="gyik"){
$adat="<center><big><big>Gyakran ism�telt k�rd�sek</big></big></center><br><br>
<u>Mi ez az oldal?</u><br>
Ez egy nevelde oldal, ahol kuty�t gondozhatsz virtu�lisan. Mindennap etetned kell �s bel�pned hozz� k�l�nben meghal.<br>
<u>Mi az a csont, ossa?</u><br>
Az oldal fizet�eszk�zei. Az ossa a csont v�lt�eszk�ze. 1 csont 100 oss�t �r. A rendszer automatikusan v�ltja �t �ket, neked nem kell vele t�r�dn�d.<br>
<u>Hogyan szerezhetek csontot?</u><br>
A csontszerz�snek t�bb m�dja is van, az �retts�giz�s megtanul�sa, ". $LEGJOBBGAZDANAP ." napig folyamatosan l�togatni a kuty�d, megnyerni az egysz�m j�t�kot, ha az �ltalad vezettet falka els� lesz egyik h�ten, vagy egy�b j�t�kok. Ezen k�v�l nincs m�s lehet�s�g, emelt d�jas SMSsel nem tudsz csontot rendelni �s ez nem is fog bevezet�sre ker�lni.<br>
<u>Mi�rt nem lehet emeltd�jas SMSsel csontot rendelni?</u><br>
Ezt az oldalt els�sorban kiskor�ak l�togatj�k akiknek, nincsen saj�t kereset�k �s nem szeretn�nk a sz�leitek zseb�b�l kivenni a p�nzt.<br>
<u>Hogyan tudom tan�tani a kuty�m?</u><br>
A kuty�m men�pontban a lap alj�n a bal sz�l�n a k�nyv alatt tudod.<br>
<u>Mi�rt nem tudok a forumba �rni?</u><br>
Tiltva vagy, vagy nem tanultad m�g meg az �r�st.<br>
<u>Hogyan lehet m�s sz�n� a nevem?</u><br>
A be�ll�t�s men�ben veheted meg 8 csont�rt.<br>
<u>Hogyan lehet m�s sz�n� a kuty�m?</u><br>
Nem lehet, csak a k�ly�k kuty�k lehetnek m�s sz�n�ek, a regisztr�ltak nem.<br>
<u>Milyen m�ret� k�pet tegyek be h�tt�rnek a falk�n�l, blogn�l, adatlapn�l?</u><br>
A falka h�tt�r 840, a blog 844, az adatlap pedig szint�n 844 pixel sz�les.<br>
<u>Lehetek moder�tor?</u><br>
A moder�torokat mi v�lasztjuk, majd megkeres�nk T�ged, ha szeretn�nk hogy az legy�l.<br>
<u>Hogyan tudok �n is neveld�t csin�lni?</u><br>
A nevelde k�sz�t�s egy nagyon bonyolult folyamat, el�tte rendelkezned kell alaposabb programoz�si tud�ssal, aminek a megszerz�se ak�r egy �vet is ig�nybe vehet, nem besz�lve mag�nak az oldalnak az elk�sz�t�s�r�l, ami ugyancsak p�r h�nap.<br>
<u>Seg�tesz nekem neveld�t csin�lni?</u><br>
Nem, egy ilyen nevelde k�sz�t�se nagyon sok id�t vesz ig�nybe �s sajnos nincs id�m seg�teni, vagy megcsin�lni helyetted. Ha bele szeretn�l v�gni, n�zz k�rbe a programozas.lap.hu vagy a php.net oldalakon, ann�l t�bbet �n se tudok seg�teni.<br>
<u>Mit tegyek, ha �szrevettem egy hib�t?</u><br>
Lehet�leg ne haszn�ld a hib�s r�sz�t az oldalnak addig, am�g nincs kijav�tva �s sz�lj a hib�r�l egy moder�tornak.<br>
<u>Mit tegyek ha m�g van k�rd�sem?</u><br>
Olvasd el m�g egyszer a seg�ts�g r�szt, ha m�g mindig nem tal�lt�l v�laszt akkor k�rdezd meg a f�rumon ha ott se tudnak seg�teni akkor fordulj egy moder�torhoz, ha � sem tud akkor �rj levelet Ez�st Ny�lnak.";

}elseif($_GET[page]=="szabaly"){
$adat="<center><big><big>Szab�lyzat</big></big></center><br><br>
1. Az oldal hivatalos nyelve a magyar. Magyarul �rj, vagy legal�bb a mondand�d fele magyarul legyen, ez al�l kiv�telek az id�zetek (zenesz�vegek).<br>
2. Tilos b�rmely olyan tartalom elhelyez�se (�r�sbeli,k�pi) amely pornogr�f, k�z�zl�sbe �tk�z�, politikai vagy sz�ls�s�ges n�zeteket tartalmaz.<br>
3. Tilos b�rmely tartalom duplik�lt elhelyez�se (egym�s ut�n k�tszeri �zenet bek�ld�s).<br>
4. Tilos az oldal nem rendeltet�sszer� haszn�lata, sz�nd�kos k�rokoz�s benne.(f�rum sz�th�z�sa)<br>
5. Ha a felhaszn�l� b�rmely hib�t �szlel k�teles azt jelentenie.<br>
6. Tilos az oldal hib�san m�k�d� elemeib�l ad�d� el�nyszerz�s.<br>
7. A f�rumon a megfelel� t�ma haszn�lata k�telez� (falkahirdet�sek a falka t�m�ba, hirdet�sek a piacra, minden m�s seg�ts�g vagy t�rsalg�).<br>
8. A moder�torok v�laszt�sa az adminisztr�tor feladata. A v�laszt�s felk�r�ses alapon m�k�dik, ez�rt tilos t�bbsz�ri k�reget�s a moder�tor jog�rt.<br>
9. Kuty�d eladni csak a piacon szabad, a piacon �rult kuty�t csak az �zen�falon vagy a f�rum megfelel� t�m�j�ban lehet hirdetni (Blogban, adatlapon nem).<br>
10. A k�l�nb�z� honlap, falka �s egy�b hirdet�seket csak az �zen�falon vagy a f�rum megfelel� t�m�j�ban lehet elhelyezni (Blogban, adatlapon nem). <br>
11. Tilos b�rmely hat�lyba l�pett magyarorsz�gi t�rv�ny megszeg�se.<br>
12. A szab�lyok megszeg�s�rt a moder�torok t�r�lhetik az �zeneted, blog bejegyz�sed, adatlapod, falk�d.<br>
13. A moder�toroknak k�teless�g�k egyszer figyelmeztetni a t�rl�s el�tt.</center>";
}elseif($_GET[page]=="ismerteto"){
$adat="<center><big><big>Oldal</big></big></center><br><center><table border=0>
<tr><td align=left><a href=segitseg.php?page=ismerteto#kodok class='feherlink'>K�dok</a></td></tr><tr><td align=left><a href=segitseg.php?page=ismerteto#egszsuly class='feherlink'>Eg�szs�g, s�ly</a></td></tr>
<tr><td align=left><a href=segitseg.php?page=ismerteto#genek class='feherlink'>G�nek</a></td></tr><tr><td align=left><a href=segitseg.php?page=ismerteto#adminmod class='feherlink'>Adminok, moder�torok</a></td></tr>
<tr><td align=left><a href=segitseg.php?page=ismerteto#legjobbgazda class='feherlink'>Legjobb gazda c�m</a></td></tr><tr><td align=left><a href=segitseg.php?page=ismerteto#egyszam class='feherlink'>Egysz�m j�t�k</a></td></tr>
</table></center>
<br><center><big><big><a id=kodok>Az oldalon haszn�lhat� k�dok</a></big></big></center>
[b]<b>F�lk�v�r bet�</b>[/b]<br>
 [u]<u>Al�h�zott bet�</u>[/u]<br>
 [i]<i>D�lt bet�</i>[/i]<br>
 [center]K�z�pre igaz�t�s[/center]<br>
 [right]Jobbra igaz�t�s[/right]<br>
 [img]Besz�rni k�v�nt k�p url-je[/img]<br>
 [link= url]Link sz�vege[/link]<br>
 [youtube]A vide� url-je [/youtube]<br>
 [color=szink�d]Szinezni k�v�nt sz�veg[/color]<br>
 [nev]Adott nev� kuty�nak a neve sz�nezve, linkelve[/nev]</center>
 
 <br><br><center><big><big><a id=egszsuly>A kutya eg�szs�g�nek �s s�ly�nak v�ltoz�sa</a></big></big></center>
<br><center>
<table border=0><tr><th></th><th align=CENTER>Sal�ta</th><th align=CENTER>T�p</th><th align=CENTER>Fagyi</th><th align=CENTER>�tel n�lk�l</th></tr>
<tr><th align=CENTER>80% s�ly<br>alatt</th><td align=CENTER>+0% Eg�szs�g<br>+0% S�ly</td><td align=CENTER>+1% Eg�szs�g<br>+0,5% S�ly</td><td align=CENTER>+2% Eg�szs�g<br>+1% S�ly</td><td align=CENTER>-5% Eg�szs�g<br>-2,5% S�ly</td></tr>
<tr><th align=CENTER>80% - 90%<br>k�z�tti s�ly</th><td align=CENTER>-1% Eg�szs�g<br>+0% S�ly</td><td align=CENTER>+0% Eg�szs�g<br>+0,5% S�ly</td><td align=CENTER>+1% Eg�szs�g<br>+1% S�ly</td><td align=CENTER>-6% Eg�szs�g<br>-2,5% S�ly</td></tr>
<tr><th align=CENTER>90% s�ly<br>felett</th><td align=CENTER>-2% Eg�szs�g<br>+0% S�ly</td><td align=CENTER>-1% Eg�szs�g<br>+0,5% S�ly</td><td align=CENTER>+0% Eg�szs�g<br>+1% S�ly</td><td align=CENTER>-7% Eg�szs�g<br>-2,5% S�ly</td></tr></table>
    <br>
 
A s�lyod �s az eg�szs�ged is maximum 100% lehet. 0% eg�szs�gn�l meghal a kuty�d �s felt�masztani se lehet, teh�t nagyon figyelj az eg�szs�g�re! Ha 20% alatt van, a jelz� cs�k piross� v�lik, hogy felh�vja a figyelmed. A t�bl�zatb�l az is kider�l hogy nem �rdemes 80% feletti s�lyt el�rned, teh�t erre �gyelj. 

 <br><br><center><big><big><a id=genek>G�nek</a></big></big></center>
 Minden kutya 8 darab g�nnel rendelkezik. Ezek a g�nek befoly�solj�k a sz�letend� k�ly�k fajt�j�t. A fajtiszta kuty�k eset�ben ez a 8 g�n mind ugyanaz. Az a kutya fajtiszta, amelyiket �gy regisztr�lt�l az oldalra �s nem k�ly�kk�nt sz�letett. K�ly�k eset�n 4 g�nt �r�k�l az apj�t�l, 4-et az anyj�t�l, az hogy melyikeket, teljesen v�letlenszer�. A l�trej�tt g�nl�ncb�l egy g�n d�nti el, milyen fajta lesz a sz�letend� k�ly�k. Az hogy melyik, v�letlenszer�. Ha esetleg olyan k�ly�k sz�letik, akinek mind a 8 g�nje k�l�nb�z�, akkor az farkas fajt�j�k�nt sz�letik meg.<br><br>
 Fajt�k �s hozz�juk tartoz� g�n r�vid�t�sek:<br><table border=0><tr><th align=center>Fajta</th><th align=center>G�n</th></tr>";
$fajtak=mysql_query("SELECT * FROM fajta WHERE fajta_id > '-1' ORDER BY fajta_nev ");
while($fajta=mysql_fetch_object($fajtak)){
$adat.='<tr><td>'.  $fajta->fajta_nev .'</td><td>'. $fajta->fajta_gen .'</td></tr>';
}
///admin. moderator
$adat.="</table>
<br><br><center><big><big><a id=adminmod>Adminok, moder�torok</a></big></big></center> Az oldalon t�nykednek olyanok is, akik feladata az oldal megfelel� haszn�lat�nak ellen�rz�se, szab�lyok betartat�sa, ezen szem�lyeket moder�toroknak nevezz�k. Ezen feladatok ell�t�s�hoz joguk van l�tni melyik kutya melyik IP c�mr�l l�pett be, ki melyik kuty�t �rulja, stb. Ezen kuty�k koordin�torai, vezet�i a f�moder�torok. �k hasonl� jogk�rrel rendelkeznek mint a moder�torok, de kieg�sz�l azzal, hogy a felhaszn�l�kn�l l�v� p�nzt is l�tj�k. 
Ezen szintek felett �ll az adminisztr�tor, amelyek feladata az oldal fejleszt�se, hib�k jav�t�sa, �j�t�sok bevezet�se. Hogy a felhaszn�l�k k�nnyebben tudj�k azonos�tani az adminisztr�torokat, moder�torokat a nev�k mellett k�l�nb�z� csillag jelzi a rangjukat:
<table><tr><td><img src=pic/mod1.gif></td><td>Moder�tor</td></tr>
<tr><td><img src=pic/mod2.gif></td><td>F�moder�tor</td></tr>
<tr><td><img src=pic/mod3.gif></td><td>Adminisztr�tor</td></tr></table>Illetve a jelenlegi adminisztr�torok, moder�torok list�ja:<table>";
  $moderator=mysql_query("SELECT * FROM moderator");
       while($modi=mysql_fetch_object($moderator))
       {
       $kuty=new kutya();
       $kuty->GetKutyaByID($modi->mod_kutya);
        $ModLista.="<tr><td>". $kuty->NevmegjelenitLinkelve() ."</td><td>". rangtotext($modi->mod_rang) ."</td></tr>";
       
       }
 $ModLista.="</table>";
$adat.=$ModLista;

//legjobbgazda, egyszam	
$adat.="<br><center><big><big><a id=legjobbgazda>Legjobbgazda c�m</a></big></big></center>A Legjobbgazda c�m elnyer�s�hez ". $LEGJOBBGAZDANAP ." napig kell l�togatnod a kuty�d. Ha ezt el�rted a napok sz�ma automatikusan lenull�z�dik minden kuty�n�l amihez a te IP c�medr�l l�ptek be, �s a te kuty�d megkapja a nyerem�ny�t.
<br><br><center><big><big><a id=egyszam>Egysz�m j�t�k</a></big></big></center>Az egysz�m j�t�k egy \"kital�l�s\" j�t�k. Csak akkor j�tszhatod, ha a kuty�d m�r megtanult sz�molni. A j�t�k c�lja, hogy minden nap, min�l kevesebb tippb�l kital�lj egy 1 �s 75 k�z�tti sz�mot. Az alapj�n, hogy h�ny tippb�l tal�ltad ki a t�bl�zatnak megfelel� pontot kapsz:
<table border=0><tr><th align=center>Tippek</th><th align=center>Pontsz�m</th></tr>
<tr><td align=center>1</td><td align=center>25</td></tr>
<tr><td align=center>2</td><td align=center>18</td></tr>
<tr><td align=center>3</td><td align=center>15</td></tr>
<tr><td align=center>4</td><td align=center>12</td></tr>
<tr><td align=center>5</td><td align=center>10</td></tr>
<tr><td align=center>6</td><td align=center>8</td></tr>
<tr><td align=center>7</td><td align=center>6</td></tr>
<tr><td align=center>8</td><td align=center>4</td></tr>
<tr><td align=center>9</td><td align=center>3</td></tr>
<tr><td align=center>10</td><td align=center>2</td></tr>
<tr><td align=center>t�bb</td><td align=center>1</td></tr></table>A pontokat egy h�tig gy�jtheted (h�tf�-vas�rnap), �s aszerint, hogy mennyi pontot gy�jt�tt�l ker�lsz rangsorol�sra(az aktu�lis �ll�st l�thatod az egysz�m statisztika f�l�n). A legjobb ". SIZEOF($EGYSZAMNYEREMENY) ." ker�l d�jaz�sra.  Nyerem�nyek: ";
for($i=0; $i<SIZEOF($EGYSZAMNYEREMENY);$i++)
{
$adat.=($i+1).". helyezet ". penz($EGYSZAMNYEREMENY[$i]);
if($i==SIZEOF($EGYSZAMNYEREMENY)-1)
{
$adat.=".";
}else{
$adat.=", ";
}
}
}else{
$adat="<center><big><big><br><br><a href=segitseg.php?page=szabaly class='feherlink'>Szab�lyzat</a><br><a href=segitseg.php?page=ismerteto class='feherlink'>Oldal</a><br><a href=segitseg.php?page=gyik class='feherlink'>Gyakran ism�telt k�rd�sek</a></big></big><br><br><br>". banner() ."</center>";
}
oldal($adat);
?>