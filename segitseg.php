<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");

function rangtotext($rang)
{
    switch($rang){
      case 1: 
       return "Moderátor";
      case 2:
        return "Fõmoderátor";
      case 3:
        return "Adminisztrátor";
      default:
        return "Felhasználó"; 
    }
}

if($_GET[page]=="gyik"){
$adat="<center><big><big>Gyakran ismételt kérdések</big></big></center><br><br>
<u>Mi ez az oldal?</u><br>
Ez egy nevelde oldal, ahol kutyát gondozhatsz virtuálisan. Mindennap etetned kell és belépned hozzá különben meghal.<br>
<u>Mi az a csont, ossa?</u><br>
Az oldal fizetõeszközei. Az ossa a csont váltóeszköze. 1 csont 100 ossát ér. A rendszer automatikusan váltja át õket, neked nem kell vele törõdnöd.<br>
<u>Hogyan szerezhetek csontot?</u><br>
A csontszerzésnek több módja is van, az érettségizés megtanulása, ". $LEGJOBBGAZDANAP ." napig folyamatosan látogatni a kutyád, megnyerni az egyszám játékot, ha az általad vezettet falka elsõ lesz egyik héten, vagy egyéb játékok. Ezen kívül nincs más lehetõség, emelt díjas SMSsel nem tudsz csontot rendelni és ez nem is fog bevezetésre kerülni.<br>
<u>Miért nem lehet emeltdíjas SMSsel csontot rendelni?</u><br>
Ezt az oldalt elsõsorban kiskorúak látogatják akiknek, nincsen saját keresetük és nem szeretnénk a szüleitek zsebébõl kivenni a pénzt.<br>
<u>Hogyan tudom tanítani a kutyám?</u><br>
A kutyám menüpontban a lap alján a bal szélén a könyv alatt tudod.<br>
<u>Miért nem tudok a forumba írni?</u><br>
Tiltva vagy, vagy nem tanultad még meg az írást.<br>
<u>Hogyan lehet más színû a nevem?</u><br>
A beállítás menüben veheted meg 8 csontért.<br>
<u>Hogyan lehet más színû a kutyám?</u><br>
Nem lehet, csak a kölyök kutyák lehetnek más színûek, a regisztráltak nem.<br>
<u>Milyen méretû képet tegyek be háttérnek a falkánál, blognál, adatlapnál?</u><br>
A falka háttér 840, a blog 844, az adatlap pedig szintén 844 pixel széles.<br>
<u>Lehetek moderátor?</u><br>
A moderátorokat mi választjuk, majd megkeresünk Téged, ha szeretnénk hogy az legyél.<br>
<u>Hogyan tudok én is neveldét csinálni?</u><br>
A nevelde készítés egy nagyon bonyolult folyamat, elõtte rendelkezned kell alaposabb programozási tudással, aminek a megszerzése akár egy évet is igénybe vehet, nem beszélve magának az oldalnak az elkészítésérõl, ami ugyancsak pár hónap.<br>
<u>Segítesz nekem neveldét csinálni?</u><br>
Nem, egy ilyen nevelde készítése nagyon sok idõt vesz igénybe és sajnos nincs idõm segíteni, vagy megcsinálni helyetted. Ha bele szeretnél vágni, nézz körbe a programozas.lap.hu vagy a php.net oldalakon, annál többet én se tudok segíteni.<br>
<u>Mit tegyek, ha észrevettem egy hibát?</u><br>
Lehetõleg ne használd a hibás részét az oldalnak addig, amíg nincs kijavítva és szólj a hibáról egy moderátornak.<br>
<u>Mit tegyek ha még van kérdésem?</u><br>
Olvasd el még egyszer a segítség részt, ha még mindig nem találtál választ akkor kérdezd meg a fórumon ha ott se tudnak segíteni akkor fordulj egy moderátorhoz, ha õ sem tud akkor írj levelet Ezüst Nyílnak.";

}elseif($_GET[page]=="szabaly"){
$adat="<center><big><big>Szabályzat</big></big></center><br><br>
1. Az oldal hivatalos nyelve a magyar. Magyarul írj, vagy legalább a mondandód fele magyarul legyen, ez alól kivételek az idézetek (zeneszövegek).<br>
2. Tilos bármely olyan tartalom elhelyezése (írásbeli,képi) amely pornográf, közízlésbe ütközõ, politikai vagy szélsõséges nézeteket tartalmaz.<br>
3. Tilos bármely tartalom duplikált elhelyezése (egymás után kétszeri üzenet beküldés).<br>
4. Tilos az oldal nem rendeltetésszerû használata, szándékos károkozás benne.(fórum széthúzása)<br>
5. Ha a felhasználó bármely hibát észlel köteles azt jelentenie.<br>
6. Tilos az oldal hibásan mûködõ elemeibõl adódó elõnyszerzés.<br>
7. A fórumon a megfelelõ téma használata kötelezõ (falkahirdetések a falka témába, hirdetések a piacra, minden más segítség vagy társalgó).<br>
8. A moderátorok választása az adminisztrátor feladata. A választás felkéréses alapon mûködik, ezért tilos többszöri kéregetés a moderátor jogért.<br>
9. Kutyád eladni csak a piacon szabad, a piacon árult kutyát csak az üzenõfalon vagy a fórum megfelelõ témájában lehet hirdetni (Blogban, adatlapon nem).<br>
10. A különbözõ honlap, falka és egyéb hirdetéseket csak az üzenõfalon vagy a fórum megfelelõ témájában lehet elhelyezni (Blogban, adatlapon nem). <br>
11. Tilos bármely hatályba lépett magyarországi törvény megszegése.<br>
12. A szabályok megszegésért a moderátorok törölhetik az üzeneted, blog bejegyzésed, adatlapod, falkád.<br>
13. A moderátoroknak kötelességük egyszer figyelmeztetni a törlés elõtt.</center>";
}elseif($_GET[page]=="ismerteto"){
$adat="<center><big><big>Oldal</big></big></center><br><center><table border=0>
<tr><td align=left><a href=segitseg.php?page=ismerteto#kodok class='feherlink'>Kódok</a></td></tr><tr><td align=left><a href=segitseg.php?page=ismerteto#egszsuly class='feherlink'>Egészség, súly</a></td></tr>
<tr><td align=left><a href=segitseg.php?page=ismerteto#genek class='feherlink'>Gének</a></td></tr><tr><td align=left><a href=segitseg.php?page=ismerteto#adminmod class='feherlink'>Adminok, moderátorok</a></td></tr>
<tr><td align=left><a href=segitseg.php?page=ismerteto#legjobbgazda class='feherlink'>Legjobb gazda cím</a></td></tr><tr><td align=left><a href=segitseg.php?page=ismerteto#egyszam class='feherlink'>Egyszám játék</a></td></tr>
</table></center>
<br><center><big><big><a id=kodok>Az oldalon használható kódok</a></big></big></center>
[b]<b>Félkövér betû</b>[/b]<br>
 [u]<u>Aláhúzott betû</u>[/u]<br>
 [i]<i>Dõlt betû</i>[/i]<br>
 [center]Középre igazítás[/center]<br>
 [right]Jobbra igazítás[/right]<br>
 [img]Beszúrni kívánt kép url-je[/img]<br>
 [link= url]Link szövege[/link]<br>
 [youtube]A videó url-je [/youtube]<br>
 [color=szinkód]Szinezni kívánt szöveg[/color]<br>
 [nev]Adott nevû kutyának a neve színezve, linkelve[/nev]</center>
 
 <br><br><center><big><big><a id=egszsuly>A kutya egészségének és súlyának változása</a></big></big></center>
<br><center>
<table border=0><tr><th></th><th align=CENTER>Saláta</th><th align=CENTER>Táp</th><th align=CENTER>Fagyi</th><th align=CENTER>Étel nélkül</th></tr>
<tr><th align=CENTER>80% súly<br>alatt</th><td align=CENTER>+0% Egészség<br>+0% Súly</td><td align=CENTER>+1% Egészség<br>+0,5% Súly</td><td align=CENTER>+2% Egészség<br>+1% Súly</td><td align=CENTER>-5% Egészség<br>-2,5% Súly</td></tr>
<tr><th align=CENTER>80% - 90%<br>közötti súly</th><td align=CENTER>-1% Egészség<br>+0% Súly</td><td align=CENTER>+0% Egészség<br>+0,5% Súly</td><td align=CENTER>+1% Egészség<br>+1% Súly</td><td align=CENTER>-6% Egészség<br>-2,5% Súly</td></tr>
<tr><th align=CENTER>90% súly<br>felett</th><td align=CENTER>-2% Egészség<br>+0% Súly</td><td align=CENTER>-1% Egészség<br>+0,5% Súly</td><td align=CENTER>+0% Egészség<br>+1% Súly</td><td align=CENTER>-7% Egészség<br>-2,5% Súly</td></tr></table>
    <br>
 
A súlyod és az egészséged is maximum 100% lehet. 0% egészségnél meghal a kutyád és feltámasztani se lehet, tehát nagyon figyelj az egészségére! Ha 20% alatt van, a jelzõ csík pirossá válik, hogy felhívja a figyelmed. A táblázatból az is kiderül hogy nem érdemes 80% feletti súlyt elérned, tehát erre ügyelj. 

 <br><br><center><big><big><a id=genek>Gének</a></big></big></center>
 Minden kutya 8 darab génnel rendelkezik. Ezek a gének befolyásolják a születendõ kölyök fajtáját. A fajtiszta kutyák esetében ez a 8 gén mind ugyanaz. Az a kutya fajtiszta, amelyiket úgy regisztráltál az oldalra és nem kölyökként született. Kölyök esetén 4 gént örököl az apjától, 4-et az anyjától, az hogy melyikeket, teljesen véletlenszerû. A létrejött génláncból egy gén dönti el, milyen fajta lesz a születendõ kölyök. Az hogy melyik, véletlenszerû. Ha esetleg olyan kölyök születik, akinek mind a 8 génje különbözõ, akkor az farkas fajtájúként születik meg.<br><br>
 Fajták és hozzájuk tartozó gén rövidítések:<br><table border=0><tr><th align=center>Fajta</th><th align=center>Gén</th></tr>";
$fajtak=mysql_query("SELECT * FROM fajta WHERE fajta_id > '-1' ORDER BY fajta_nev ");
while($fajta=mysql_fetch_object($fajtak)){
$adat.='<tr><td>'.  $fajta->fajta_nev .'</td><td>'. $fajta->fajta_gen .'</td></tr>';
}
///admin. moderator
$adat.="</table>
<br><br><center><big><big><a id=adminmod>Adminok, moderátorok</a></big></big></center> Az oldalon ténykednek olyanok is, akik feladata az oldal megfelelõ használatának ellenõrzése, szabályok betartatása, ezen személyeket moderátoroknak nevezzük. Ezen feladatok ellátásához joguk van látni melyik kutya melyik IP címrõl lépett be, ki melyik kutyát árulja, stb. Ezen kutyák koordinátorai, vezetõi a fõmoderátorok. Õk hasonló jogkörrel rendelkeznek mint a moderátorok, de kiegészül azzal, hogy a felhasználóknál lévõ pénzt is látják. 
Ezen szintek felett áll az adminisztrátor, amelyek feladata az oldal fejlesztése, hibák javítása, újítások bevezetése. Hogy a felhasználók könnyebben tudják azonosítani az adminisztrátorokat, moderátorokat a nevük mellett különbözõ csillag jelzi a rangjukat:
<table><tr><td><img src=pic/mod1.gif></td><td>Moderátor</td></tr>
<tr><td><img src=pic/mod2.gif></td><td>Fõmoderátor</td></tr>
<tr><td><img src=pic/mod3.gif></td><td>Adminisztrátor</td></tr></table>Illetve a jelenlegi adminisztrátorok, moderátorok listája:<table>";
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
$adat.="<br><center><big><big><a id=legjobbgazda>Legjobbgazda cím</a></big></big></center>A Legjobbgazda cím elnyeréséhez ". $LEGJOBBGAZDANAP ." napig kell látogatnod a kutyád. Ha ezt elérted a napok száma automatikusan lenullázódik minden kutyánál amihez a te IP címedrõl léptek be, és a te kutyád megkapja a nyereményét.
<br><br><center><big><big><a id=egyszam>Egyszám játék</a></big></big></center>Az egyszám játék egy \"kitalálós\" játék. Csak akkor játszhatod, ha a kutyád már megtanult számolni. A játék célja, hogy minden nap, minél kevesebb tippbõl kitalálj egy 1 és 75 közötti számot. Az alapján, hogy hány tippbõl találtad ki a táblázatnak megfelelõ pontot kapsz:
<table border=0><tr><th align=center>Tippek</th><th align=center>Pontszám</th></tr>
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
<tr><td align=center>több</td><td align=center>1</td></tr></table>A pontokat egy hétig gyûjtheted (hétfõ-vasárnap), és aszerint, hogy mennyi pontot gyüjtöttél kerülsz rangsorolásra(az aktuális állást láthatod az egyszám statisztika fülön). A legjobb ". SIZEOF($EGYSZAMNYEREMENY) ." kerül díjazásra.  Nyeremények: ";
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
$adat="<center><big><big><br><br><a href=segitseg.php?page=szabaly class='feherlink'>Szabályzat</a><br><a href=segitseg.php?page=ismerteto class='feherlink'>Oldal</a><br><a href=segitseg.php?page=gyik class='feherlink'>Gyakran ismételt kérdések</a></big></big><br><br><br>". banner() ."</center>";
}
oldal($adat);
?>