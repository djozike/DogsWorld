<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
include("inc/oop.php");
include("inc/stilus.php");
if(isset($_SESSION[id])){
$kutyuli = new kutya;
$kutyuli->GetKutyaByID($_SESSION[id]);
if($kutyuli->rang>=2){
///fuggvenyek
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
///menu
$oldal="<center><big><u>Adminisztrációs felület</u></big><br><br><a href=admin.php class='feherlink'>Általános</a> | <a href=admin.php?p=j class='feherlink'>Játékok</a> |<a href=admin.php?p=t class='feherlink'>Tiltások</a> | <a href=admin.php?p=s class='feherlink'>Statisztika</a><br>". $_SESSION[hiba] ."<br><script src=\"script/admin.js\"></script>";
///ip tiltások
$tiltottipksql=mysql_query("SELECT * FROM oldaliptilt");
$tablazat="A jelenleg tiltott IP címek a következõk:<br>";
 if(mysql_num_rows($tiltottipksql)>0)
 {
        $tablazat.="<table border=0><tr><th align=center>IP</th><th align=center width=360>Megjegyzés</th><th></th></tr>";
               while($tiltottak=mysql_fetch_object($tiltottipksql) )
               {
               
                     $tablazat.="<tr><td align=center><a href=kutyak.php?ip=". $tiltottak->oldaliptilt_ip ."&hol=belep class='feherlink'>". $tiltottak->oldaliptilt_ip ."</a></td><td align=left>". htmlentities($tiltottak->oldaliptilt_megjegyzes) ."</td><td><a href=inc/oldaliptilt.php?ip=". $tiltottak->oldaliptilt_ip ."><img src=pic/kuka.png></a></td></tr>";
               }
 
        $tablazat.="</table>";
 }else{
    $tablazat.=ok("Nincs tiltott IP!");
 
 }
///kutya tiltások
$tiltottipksql=mysql_query("SELECT * FROM oldaltilt");
$KutyakTablazat="A jelenleg tiltott kutyák a következõk:<br>";
 if(mysql_num_rows($tiltottipksql)>0)
 {
        $KutyakTablazat.="<table border=0><tr><th align=center>Kutya</th><th align=center>Tiltó</th><th align=center width=75>Idõ</th><th></th></tr>";
               while($tiltottak=mysql_fetch_object($tiltottipksql) )
               {
               
                     $KutyakTablazat.="<tr><td align=center>". idtonev($tiltottak->oldaltilt_kid) ."</td><td align=center>". idtonev($tiltottak->oldaltilt_tilto) ."</td><td align=right>". $tiltottak->oldaltilt_ido ." napra</td><td align=right><form action=inc/mtilto.php method=POST><input type=hidden name=id value=". $tiltottak->oldaltilt_kid ."><input type=hidden name=ido value=5><input type='image' src=pic/kuka.png style='border: 0px; width: 30px;'></form></td></tr>";
               }
 
        $KutyakTablazat.="</table>";
 }else{
    $KutyakTablazat.=ok("Nincs tiltott kutya!");
 
 }
 ////forum tiltások
 $tiltottipksql=mysql_query("SELECT * FROM forumtilt");
 $forumtiltas="A jelenleg tiltott kutyák a következõk:<br>";
  if(mysql_num_rows($tiltottipksql)>0)
 {
         $forumtiltas.="<table border=0><tr><th align=center>Kutya</th><th align=center width=75>Idõ</th></tr>";
               while($tiltottak=mysql_fetch_object($tiltottipksql) )
               {
               
                     $forumtiltas.="<tr><td align=center>". idtonev($tiltottak->forumtilt_kid) ."</td><td align=right>". $tiltottak->forumtilt_ido ." napra</td></tr>";
               }
 
         $forumtiltas.="</table>";
 }else{
     $forumtiltas.=ok("Nincs tiltott kutya!");
 
 }
 ///moderatorlista
 $ModLista="Jelenleg az oldalon valamilyen rangot betöltök:<br><table border=0><tr><th width=150>Név</th><th width=150>Rang</th><tr>";
  $moderator=mysql_query("SELECT * FROM moderator");
       while($modi=mysql_fetch_object($moderator))
       {
       $kuty=new kutya();
       $kuty->GetKutyaByID($modi->mod_kutya);
        $ModLista.="<tr><td>". $kuty->NevmegjelenitLinkelve() ."</td><td>". rangtotext($modi->mod_rang) ."</td></tr>";
       
       }
 $ModLista.="</table>";
 ///penzkuldes
 $handle = fopen("data/csont.txt", "r");
 $kuldheto=penz(fread($handle, filesize("data/csont.txt")));
 if($_SESSION[id] == 1)
 {
	$kuldheto="VÉGTELEN";
 }
fclose($handle);

$handle = fopen("data/csontkuldes.txt", "r");
$penzkuldesek=explode("\n", fread($handle, filesize("data/csontkuldes.txt")));
$penzkuldesekformazva="<table>";
for($i=0; $i<sizeof($penzkuldesek); $i++)
{
$ido=explode("Küldõ: ", str_replace("Idõ: ", "", $penzkuldesek[$i]));
$kuldo=explode("Kapó: ", $ido[1]);
$kapo=explode("Összeg: ", $kuldo[1]);
$penzkuldesekformazva.="<tr><td>". $ido[0] ."</td><td>". $kuldo[0] ."</td><td>". $kapo[0] ."</td><td>". $kapo[1] ."</td></tr>";
}
$penzkuldesekformazva.="</table>";
fclose($handle);
$PenztKuld="Pénz küldése esetén, nem tõled vonodik le az összeg, hanem a Nemzeti csont bankból kerül kiutalásra.<br><u>Küldhetõ csont: </u>". $kuldheto ."<br>
		        Kutya név: <input type=text name=kutya id=kutya> Pénz: <input type=text name=penz style='width:50px;' id=penz> ossa  <input type=submit name=ok value='Elküld' style='width:60px;' onclick=\"penzKuldes()\">
				<div id=\"penzKuldesUzenet\"></div><div id=\"penzKuldesekSzoveg\" onclick=\"penzKuldesekMutat()\">Eddigi pénzküldések megmutatása</div><div id=\"penzKuldesek\" style='height: 200px; overflow-y: auto; display:none'>". $penzkuldesekformazva ."</div>";
///rangbeallitas
$RangBeallit="Itt beállíthatod, hogy az adótt kutya felhasználó, moderátor, fõmoderátor, vagy adminisztrátor legyen.<br>
		        <form method=POST action=inc/rangvalt.php>Kutya név: <input type=text name=kutya> Rang: <select name=rang><option value=0>Felhasználó</option><option value=1>Moderátor</option><option value=2>Fõmoderátor</option><option value=3>Adminisztrátor</option></select>  <input type=submit name=ok value='Elküld' style='width:60px;'> </form>";
///blog iras beallitasok
if($BLOGIRASTANULAS==1)
{
	$checked="checked";
}
else
{
	$checked="";
}
$BlogIras="Új blog bejegyzés és kommentelés feltételeit állthatód itt be.
		        <br>Minimális kor (0 esetén nincs minimális): <input type=text name=blognapok id=blognapok value=". $BLOGIRASMINNAP ."><br><input type=checkbox name=iraslecke id=iraslecke style='width:10px;' ". $checked .">Új bejegyzés/kommenteléshez tudni kell irni<br><input type=submit name=ok value='Mentés' style='width:60px;' onclick=\"blogbeallitas()\">";
				
				
///csont statisztikak
$CsontStat="<table border=0>";
$penz=mysql_query("SELECT sum(kutya_penz) osszpenz FROM `kutya`");
$kutya=mysql_query("SELECT * FROM kutya");
$penzeskutya=mysql_query("SELECT * FROM kutya WHERE kutya_penz > '0'");
while($penzki=mysql_fetch_object($penz)){
$CsontStat.="<tr><td>Összes csont:</td><td>". penz($penzki->osszpenz) ."</td></tr>";
$CsontStat.="<tr><td>Átlag 1 kutyára jutó csont:</td><td>". penz(round($penzki->osszpenz/mysql_num_rows($kutya), 2)) ."/kutya</td></tr>";
$atlagfelettikutya=mysql_query("SELECT * FROM kutya WHERE kutya_penz > '". round($penzki->osszpenz/mysql_num_rows($kutya), 0) ."'");
$CsontStat.="<tr><td>Átlagnál gazdagabb kutyák:</td><td>". mysql_num_rows($atlagfelettikutya) ." db</td></tr>";
$CsontStat.="<tr><td>Csonttal rendelkezõ kutyák:</td><td>". mysql_num_rows($penzeskutya) ." db (". round(mysql_num_rows($penzeskutya)/mysql_num_rows($kutya)*100,2) ."%)</td></tr>";
$koncrata=mysql_query(" SELECT * FROM `kutya` ORDER BY kutya_penz DESC LIMIT 5");
$top5penz=0;
while($konc=mysql_fetch_object($koncrata)){
$top5penz+=$konc->kutya_penz;
}
$CsontStat.="<tr><td>Csont koncentrációs ráta:</td><td>". round(($top5penz/$penzki->osszpenz)*100,2) ." %</td></tr>";
}
$CsontStat.="</table>";
////kutya statisztikák
$KutyaStat="<table border=0>";
$osszkutya=mysql_num_rows(mysql_query("SELECT * FROM `kutya`"));
$KutyaStat.="<tr><td>Oldalon regisztrált kutyák:</td><td>". $osszkutya ." db</td></tr>";
$osszipkutya=mysql_query("SELECT DISTINCT * FROM `kutya` GROUP BY kutya_regip");
$KutyaStat.="<tr><td>Oldalon különbözõ IP-rõl regisztrált kutyák:</td><td>". mysql_num_rows($osszipkutya) ." db</td></tr>";
$szineskutya=mysql_num_rows(mysql_query("SELECT * FROM `kutya` WHERE kutya_betuszin<>'774411'"));
$KutyaStat.="<tr><td>Színes nevû kutyák:</td><td>". $szineskutya ." db (". round(($szineskutya/$osszkutya)*100,2) ." %)</td></tr>";
$makutya=mysql_query("SELECT * FROM `kutya` WHERE kutya_belepido > '". $ma ."'");
$KutyaStat.="<tr><td>Ma meglátogatott kutyák:</td><td>". mysql_num_rows($makutya) ." db</td></tr>";
$maipkutya=mysql_query("SELECT DISTINCT * FROM `kutya` WHERE kutya_belepido > '". $ma ."' GROUP BY kutya_belepip");
$KutyaStat.="<tr><td>Ma különbözõ IP-rõl meglátogatott kutyák:</td><td>". mysql_num_rows($maipkutya) ." db</td></tr>";
$KutyaStat.="</table>";
///jatek statisztikak
$JatekStat="<table>";
$egyszam=mysql_num_rows(mysql_query("SELECT * FROM `egyszampontok`"));
$JatekStat.="<tr><td>Ezen a héten egyszámjátékot játszott kutyák:</td><td>". $egyszam ." db (". round(($egyszam/$osszkutya)*100,2) ."%)</td></tr>";
$JatekStat.="</table>";
///fajta stat
$FajtaStat='<div id="grafikon"></div><script>

var width = 500,
    height = 500,
    radius = Math.min(width, height) / 2;

var color = d3.scale.ordinal()
    .range(["#1273a2", "#3283a2", "#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#fa6c00", "#ff8000"]);

var arc = d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.db; });

var svg = d3.select("#grafikon").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

	
d3.json("/stat/stat.php", function(error, data) {

  data.forEach(function(d) {
    d.db = +d.db;
  });

	var g = svg.selectAll(".arc")
      .data(pie(data))
    .enter().append("g")
      .attr("class", "arc");

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color(d.data.fajta); });

  g.append("text")
      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
      .attr("dy", ".35em")
      .style("text-anchor", "middle")
      .style("font-size", "10px")
      .text(function(d) { return d.data.fajta; });

});

</script>';
///Lotto beallitasok
if(isset($_POST[lottonyero]))
{
uj_lotto_nyeroszam();
}
$osszipkutya=mysql_query("SELECT * FROM `lottonyeroszam`");
while($nyeroszamok=mysql_fetch_object($osszipkutya)){
$lotto="Eheti lottó nyerõszámok:<br>". $nyeroszamok->lottonyeroszam1 .", ". $nyeroszamok->lottonyeroszam2 .", ". $nyeroszamok->lottonyeroszam3;
}
$lottony=mysql_num_rows(mysql_query("SELECT DISTINCT lottoszelveny_kid FROM `lottoszelveny` GROUP BY `lottoszelveny_kid`"));
$lottot=mysql_num_rows(mysql_query("SELECT * FROM lottoszelveny INNER JOIN lottonyeroszam ON lottoszelveny_szam1 = lottonyeroszam1 and lottoszelveny_szam2 = lottonyeroszam2 and lottoszelveny_szam3 = lottonyeroszam3"));

$handle = fopen("data/lottonyeremeny.txt", "r");
$nyeremeny=fread($handle, filesize("data/lottonyeremeny.txt"));
fclose($handle);

if($lottot==0)
	$nyer="0 csont";
else
	$nyer=penz(round($nyeremeny/$lottot));
$lotto.="<table>
<tr><td>Ezen a héten lottózó kutyák:</td><td>". $lottony." db (". round(($lottony/$osszkutya)*100,2) ."%)</td></tr>
<tr><td>Ezen a héten várható telitalálatás szelvények:</td><td>". $lottot." db</td></tr>
<tr><td>Ezen a héten várható nyeremény szelvényenként:</td><td>". $nyer ."</td></tr>
<tr><td align=center rowspan=2><form method=POST action=admin.php?p=j><input type=submit value=\"Új Nyerõszámok Generálása\" name=lottonyero style='width: 250px;'></form></tr>
</table>";

 if($_GET[p]=='t'){
$oldal.="<u>IP tiltása az oldalról</u>
    ". VilagosMenu(500, "<Table border=0><tr><td align=center><form method=POST action=inc/oldaliptilt.php>IP cím: <input type=text name=ip></td></tr><tr><td align=center>Megjegyzés:<br><textarea name='megjegyzes' cols=26 rows=5></textarea></td></tr> <tr><td align=center><input type=submit name=ok value='Elküld' style='width:60px;'></form></td></tr></table>") ." 
		    <br><br>

    <u>Oldalról tiltott IP-k listája</u>
   ". VilagosMenu(500, $tablazat) ."
    <br><br>
    
   <u>Oldalról tiltott kutyák listája</u>
   ". VilagosMenu(500, $KutyakTablazat) ."
    <br><br>
    
   <u>Fórumról tiltott kutyák listája</u>
   ". VilagosMenu(500, $forumtiltas) ."
    <br><br>";
}else if($_GET[p]=='s'){
	$oldal.="<script src=\"http://d3js.org/d3.v3.min.js\"></script>";
    $oldal.="<u>Csont statisztikák</u>
   ". VilagosMenu(500, $CsontStat) ."
    <br><br>";
    
   $oldal.="<u>Kutya statisztikák</u>
   ". VilagosMenu(500, $KutyaStat) ."
    <br><br>";
	
	$oldal.="<u>Játék statisztikák</u>
   ". VilagosMenu(500, $JatekStat) ."
    <br><br>";
	
	$oldal.="<u>Fajta statisztikák</u>
   ". VilagosMenu(500, $FajtaStat) ."
    <br><br>";

}else if($_GET[p]=='j')
{
	if($kutyuli->rang>2){ 
		$oldal.="<u>Lottó</u>
				". VilagosMenu(500, $lotto) ."
				<br><br>";
	}
}
else{    
    $oldal.="<u>Monderátorok listája</u>
    ". VilagosMenu(500, $ModLista) ."
    <br><br>";
    
    if($kutyuli->rang>2){ 
    $oldal.="<u>Pénz küldése</u>
    ". VilagosMenu(500, $PenztKuld) ."
   <br><br>
   
   <u>Blog bejegyzések és kommentek</u>
    ". VilagosMenu(500, $BlogIras) ."
   <br><br>
   
    <u>Rang beállítása</u>
    ". VilagosMenu(500, $RangBeallit) ."
   <br><br>";
    }
  }
$oldal.="</center>";
$_SESSION[hiba]='';
oldal($oldal);
}
    else{
      header("Location: index.php");
    }
}else{header("Location: index.php");}
	?>
