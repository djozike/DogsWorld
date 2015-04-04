<?php
include("inc/sql.php");
include("inc/session.php");
include("inc/oop.php");
if(isset($_SESSION[id])){
$adat="<center><u>Piac</u><br><br>
<style>
.black_overlay{
			display: none;
			position: absolute;
			top: 27%;
			left: 14%;
			width: 745px;
			height: 630px;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: absolute;
			top: 25%;
			left: 12%;
			width: 710px;
			height: 600px;
			padding: 6px;
			border: 11px solid #cc9866;
			background-image:url('pic/keret3.gif');
			z-index:1002;
			overflow: auto;
		}
	</style>
	<script>
	var xmlhttp;
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
  }
function AjaxAdatKuld(url, callback)
{
xmlhttp.onreadystatechange = function() {
  if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
    callback(xmlhttp.responseText);
  }
};

xmlhttp.open(\"GET\",url, true);
xmlhttp.send();
}
	
function info(id)
{
if(document.getElementById(\"light\").style.display=='block'){
document.getElementById(\"light\").style.display='none';
document.getElementById(\"fade\").style.display='none';
}
else{
		url=\"inc/kutyaMegjelenit.php?id=\"+id;
  	AjaxAdatKuld(url, function(){ 
		document.getElementById(\"light\").innerHTML=arguments[0];
		document.getElementById(\"light\").style.display='block';
		document.getElementById(\"fade\").style.display='block';
  });

}
}

function confirmBuy(id)
{
  if (confirm(\"Biztos meg akarod venni a kutyát?\")) {
    document.location = \"inc/kutyavesz.php?id=\"+id;
  }
} 
function confirmRemove(id)
{
  if (confirm(\"Biztos visszavonod a piacról?\")) {
    document.location = \"inc/visszavon.php?id=\"+id;
  }
}
	</script>";
$adat.='<div id="fade" class="black_overlay"></div><div id="light" class="white_content"><p align=right><a href = "javascript:void(0)" onclick = "info(0)" class="feherlink">Bezár [x]</a></p>
</div>';

$kutyus=new kutya();
$kutyus->GetKutyaByID($_SESSION[id]);

belepido($_SESSION[nev]);
$adat.="A piacon kutyákat adhatsz-vehetsz. A piaci árnak csak ". $PIACELADSZAZALEK*100 ."%-át kapod meg, mivel a kereskedésnek vannak költségei. Tehát ha 5 csontért eladtál egy kutyát csak ". penz(5*100*$PIACELADSZAZALEK) ." kerül jóváírásra nálad. Az eladott kutyáért járó pénzt mindig az a kutya kapja, akivel kiraktad a piacra az eladó kutyát.<br><br>";
if($kutyus->Tanult("KE")){
	$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=475></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr><tr><td background=pic/hatter8.gif colspan=3 align=center>
	<table><tr><td>Név:</td><td><form method=POST action=inc/elad.php><input type=text name=nev></td><td>Jelszó:</td><td><input type=password name=jelszo></td><td>Ár:</td><td>
	<select name=ar style='width:70px;'>";
	for($i=$PIACMINAR;$i<=$PIACMAXAR;$i++){
		$adat.="<option value=$i>".$i." csont</option>";
	}
	$adat.="</select></td><td><input type=submit value=Elad style='width:70px;'></form></td></tr></table>
	</td><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></tr></table>";
}else{
	$adat.=hiba("Nem adhatsz el kutyát, mivel nem tanultad meg a kereskedést!");
}
$adat.="<br>". banner() ."<br>";
$adat.=$_SESSION[hiba];
$_SESSION[hiba]="";
switch($_GET[rendez]){
case 1:
$rendez="kutya.kutya_nev";
break;
case 2:
$rendez="kutya.kutya_fajta";
break;
case 3:
$rendez="kutya.kutya_kor DESC";
break;
case 4:
$rendez="kutya.kutya_penz DESC";
break;
case 5:
$rendez="kutya.kutya_egeszseg DESC";
break;
case 6:
$rendez="kutya.kutya_suly DESC";
break;
case 7:
$rendez="piac.piac_ar DESC";
break;
default:
$rendez="piac.piac_id";
break;
}
$eladok=mysql_query("SELECT * FROM piac INNER JOIN  kutya on piac.piac_aru = kutya.kutya_id ORDER BY ". $rendez);
if(mysql_num_rows($eladok)>0){

if($kutyus->rang > 0){
	$nev2="<th align=center>Eladó</th>";
}
$adat.="<br>
<table border=0 cellpadding=0 cellspacing=0><tr background=pic/hatter8.gif><th align=center><a href=piac.php?rendez=2 class='feherlink'>#</a></th><th align=center width=120><a href=piac.php?rendez=1 class='feherlink'>Név</a></th>". $nev2 ."<th align=center width=80><a href=piac.php?rendez=3 class='feherlink'>Kor</a></th><th align=center width=100><a href=piac.php?rendez=4 class='feherlink'>Pénz</a></th><th align=center width=80><a href=piac.php?rendez=5 class='feherlink'>Egészség</a></th><th align=center width=80><a href=piac.php?rendez=6 class='feherlink'>Súly</a></th><th align=center width=80><a href=piac.php?rendez=7 class='feherlink'>Ár</a></th><th></th><td></td></tr>";
$szin="keret3";
while($elado=mysql_fetch_object($eladok)){

if($kutyus->rang > 0){
	$nev2="<td align=center>". idtonev($elado->piac_elado) ."</td>";
}
if($_SESSION[id]==$elado->piac_elado){
	$event="<a href = \"javascript:void(0)\" onclick = \"confirmRemove(". $elado->piac_id .")\" class='feherlink'>Visszavonom</a>";
}else{
	$event="<a href = \"javascript:void(0)\" onclick = \"confirmBuy(". $elado->piac_id .")\" class='feherlink'>Megveszem</a>";
}

$eladokutyus=new kutya();
$eladokutyus->GetKutyaByID($elado->kutya_id);

$adat.="<tr background=pic/". $szin .".gif><td><img src=pic/kutyak/". kutyaszamtofile($elado->kutya_fajta) . $elado->kutya_szin .".png width=30 heigth=20></td><td align=center>". $eladokutyus->NevMegjelenitRanggalLinkelve() . "</td>".$nev2 ."<td align=center>". $elado->kutya_kor ." nap</td><td align=center>". penz($elado->kutya_penz) ."</td><td align=center>". $elado->kutya_egeszseg ."%</td><td align=center>". $elado->kutya_suly ."%</td><td align=center>". $elado->piac_ar ." csont</td><td><a href = \"javascript:void(0)\" onclick = \"info(". $elado->kutya_id .")\" class=\"feherlink\">Részletek...</a></td><td align=center>". $event ."</td></tr>";
if($szin=="keret3")
      {
      $szin="hatter8";
      }else{
      $szin="keret3";
      }
}
$adat.="</table>";
}else{
$adat.=ok("<br>Nincsen eladó kutya!");
}

$adat.="</center>";
oldal($adat);
}else{

header("Location: index.php");
}
?>
