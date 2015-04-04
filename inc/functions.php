<?php
///valtozok
$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
$datum=getdate();
$ma=mktime(0,0,0,$datum['mon'],$datum['mday'],$datum['year']);
$most=$datum[0];
//név
$SITENAME="Dogs World";
//árak
$FALKAALAPIT=5;
$FALKASZINESNEV=2800;
$SZINESNEV=800;
$TURBO=100;
$LOTTO=15;
$KAJA=20;
$GENKUTAT=100;
$UZENOFAL=75;
$UZENOFAL_SZINES=25;
///jutaélok
$PENZKULDOSZAZALEK=0.9;
$PIACELADSZAZALEK=0.8;
//torles
$LEVELTORLES=14;
///legjobb gazda
$LEGJOBBGAZDANYEREMENY=10;
$LEGJOBBGAZDANAP=10;
///EGYSZAM
$EGYSZAMNYEREMENY[0]=300;
$EGYSZAMNYEREMENY[1]=200;
$EGYSZAMNYEREMENY[2]=100;
///fagyasztas
$FAGYASZTMINAP=5;
$FAGYASZTIDO=20;
//piac
$PIACMINAR=2;
$PIACMAXAR=12;
///blog es komment iras
if(file_exists("../data/blogiras.txt"))
{
$blogirasAdatok = fopen("../data/blogiras.txt", "r");
$blogIras=explode("|", fread($blogirasAdatok, filesize("../data/blogiras.txt")));
fclose($blogirasAdatok);
}
elseif(file_exists("./data/blogiras.txt"))
{
$blogirasAdatok = fopen("./data/blogiras.txt", "r");
$blogIras=explode("|", fread($blogirasAdatok, filesize("./data/blogiras.txt")));
fclose($blogirasAdatok);
}
else{
$blogIras[0]=5;
$blogIras[1]=1;
}

$BLOGIRASMINNAP=$blogIras[0];
$BLOGIRASTANULAS=$blogIras[1];
///HIBAUZENETEK
///levelezes
$NINCSLEVEL=hiba("<font size=+2>Nincsennek betölthetõ üzenetek!</font>");
///fuggvenyek
function veletlen($mitol, $meddig, $hany)
{
$veletlenek[0]=rand($mitol,$meddig);
$db=1;
while($db<$hany)
{
$veletlen=rand($mitol,$meddig);
if(!in_array($veletlen, $veletlenek))
{
$veletlenek[$db]=$veletlen;
$db++;
}
}
sort($veletlenek);
return $veletlenek;
}
function uzenofal(){
include("sql.php");
$lekeres=mysql_query("SELECT * FROM uzenofal ORDER BY uzenofal_id DESC LIMIT 20");
while($uzenetek=mysql_fetch_object($lekeres)){
$szoveg=htmlentities($uzenetek->uzenofal_uzenet);
$szoveg=str_replace(":s:","<img src=pic/barat.gif style='vertical-align: text-bottom;'>",$szoveg);
$szoveg=str_replace(":l:","<img src=pic/letter.gif style='vertical-align: text-bottom;'>",$szoveg);
$szoveg=str_replace(":p:","<img src=pic/money.gif style='vertical-align: text-bottom;'>",$szoveg);
$szoveg=str_replace(":f:","<img src=pic/falka.gif style='vertical-align: text-bottom;'>",$szoveg);
$szoveg=str_replace(":c:","<img src=pic/mod3.gif style='vertical-align: text-bottom;'>",$szoveg);
if($uzenetek->uzenofal_szin!=774411){
$uzenet="<font color=#". $uzenetek->uzenofal_szin .">". $szoveg ."</font>";
}else{
$uzenet=$szoveg;
}
if($uzenetek->uzenofal_tipus!=6){
$uzenet="<a href=kattint.php?id=". $uzenetek->uzenofal_id ." class='feherlink'>". $uzenet ."</a>";
}
echo " ". $uzenet ." | ";
}
}
function horoszkop($szulev){
$tomb=explode("-",$szulev);

if((($tomb[1]==12) && ($tomb[2]>21)) or (($tomb[1]==1) && ($tomb[2]<21))){
$horoszkop="bak";
}else if((($tomb[1]==1) && ($tomb[2]>20)) or (($tomb[1]==2) && ($tomb[2]<20))){
$horoszkop="vízöntõ";
}else if((($tomb[1]==2) && ($tomb[2]>19)) or (($tomb[1]==3) && ($tomb[2]<21))){
$horoszkop="halak";
}else if((($tomb[1]==3) && ($tomb[2]>20)) or (($tomb[1]==4) && ($tomb[2]<21))){
$horoszkop="kos";
}else if((($tomb[1]==4) && ($tomb[2]>20)) or (($tomb[1]==5) && ($tomb[2]<21))){
$horoszkop="bika";
}else if((($tomb[1]==5) && ($tomb[2]>20)) or (($tomb[1]==6) && ($tomb[2]<22))){
$horoszkop="ikrek";
}else if((($tomb[1]==6) && ($tomb[2]>21)) or (($tomb[1]==7) && ($tomb[2]<23))){
$horoszkop="rák";
}else if((($tomb[1]==7) && ($tomb[2]>22)) or (($tomb[1]==8) && ($tomb[2]<23))){
$horoszkop="oroszlán";
}else if((($tomb[1]==8) && ($tomb[2]>22)) or (($tomb[1]==9) && ($tomb[2]<23))){
$horoszkop="szûz";
}else if((($tomb[1]==9) && ($tomb[2]>22)) or (($tomb[1]==10) && ($tomb[2]<23))){
$horoszkop="mérleg";
}else if((($tomb[1]==10) && ($tomb[2]>22)) or (($tomb[1]==11) && ($tomb[2]<22))){
$horoszkop="skorpió";
}else if((($tomb[1]==11) && ($tomb[2]>21)) or (($tomb[1]==12) && ($tomb[2]<22))){
$horoszkop="nyilas";
}else{ $horoszkop="hibás dátum";}

return $horoszkop;
}
function kor($szulev){
$tomb=explode("-",$szulev);
$datum=getdate();
$ev=$datum['year']-$tomb[0];
if(($datum['mon']<$tomb[1]) or (($datum['mon']==$tomb[1]) and ($datum['mday']<$tomb[2]))){
$ev--;
}
return $ev;
}
function kortodatum($kor, $set){
if($set=="min"){
$datum=getdate();
$datum['year']=$datum['year']-$kor;
$kesz=$datum['year']. "" . $datum['mon']. "" . $datum['mday'];
}else{
///max
$datum=getdate(time()-60*60*24);
$datum['year']=$datum['year']-$kor-1;
$kesz=$datum['year']. "" . $datum['mon']. "" . $datum['mday'];
}
return $kesz;
}
function penz($penz){
if($penz==0){
$kiir="0 csont";
}else{
$csont=$penz/100;
$csont=intval($csont);
$ossa=$penz-($csont*100);
if($csont==0){
$kiir=$ossa." ossa";
return $kiir;
}else{
if($ossa==0){
$kiir=$csont ." csont";
}else{
$kiir=$csont ." csont ". $ossa ." ossa";
}
}
}
return $kiir;
}
function elteltido($ido){
$most=time();
$eltelt=$most-$ido;
if($eltelt>3600*24*60){
$kiir="több mint 2 hónapja";
}else if($eltelt>3600*24*30){
$kiir="több mint 1 hónapja";
}else if($eltelt>3600*24*28){
$kiir="több mint 4 hete";
}else if($eltelt>3600*24*21){
$kiir="több mint 3 hete";
}else if($eltelt>3600*24*14){
$kiir="több mint 2 hete";
}else if($eltelt>3600*24*7){
$kiir="több mint 1 hete";
}else if($eltelt>3600*24*6){
$kiir="6 napja";
}else if($eltelt>3600*24*5){
$kiir="5 napja";
}else if($eltelt>3600*24*4){
$kiir="4 napja";
}else if($eltelt>3600*24*3){
$kiir="3 napja";
}else if($eltelt>3600*24*2){
$kiir="2 napja";
}else if($eltelt>3600*24){
$kiir="1 napja";
}else if($eltelt>3600){
$kiir=intval($eltelt/3600)." órája és ". intval(($eltelt-(intval($eltelt/3600)*3600))/60) ." perce";
}else if(($eltelt<3600) and ($eltelt>60)){
$kiir=intval($eltelt/60) ." perce";
}else if($eltelt<60){
$kiir="éppen pár pillanattal ez elõtt";
}else{$kiir="nem tudni mikor";}
return $kiir;
}
function ubb_adatlap($szoveg){
include_once("oop.php");
$szoveg=str_replace("<","&lt;",$szoveg);

$szoveg=str_replace("[b]","<B>",$szoveg);
$szoveg=str_replace("[B]","<B>",$szoveg);
$szoveg=str_replace("[/b]","</B>",$szoveg);
$szoveg=str_replace("[/B]","</B>",$szoveg);
$szoveg=str_replace("[u]","<U>",$szoveg);
$szoveg=str_replace("[U]","<U>",$szoveg);
$szoveg=str_replace("[/u]","</U>",$szoveg);
$szoveg=str_replace("[/U]","</U>",$szoveg);
$szoveg=str_replace("[i]","<I>",$szoveg);
$szoveg=str_replace("[I]","<I>",$szoveg);
$szoveg=str_replace("[/i]","</I>",$szoveg);
$szoveg=str_replace("[/I]","</I>",$szoveg);
$szoveg=str_replace("[center]","<CENTER>",$szoveg);
$szoveg=str_replace("[CENTER]","<CENTER>",$szoveg);
$szoveg=str_replace("[/center]","</CENTER>",$szoveg);
$szoveg=str_replace("[/CENTER]","</CENTER>",$szoveg);
$szoveg=str_replace("[right]","<p align=right>",$szoveg);
$szoveg=str_replace("[RIGHT]","<<p align=right>",$szoveg);
$szoveg=str_replace("[/right]","</p>",$szoveg);
$szoveg=str_replace("[/RIGHT]","</p>",$szoveg);
$szoveg=str_replace("[img]","<img border=0 src=",$szoveg);
$szoveg=str_replace("[/img]",">",$szoveg);
$szoveg=str_replace("[IMG]","<img border=0 src=",$szoveg);
$szoveg=str_replace("[/IMG]",">",$szoveg);
$szoveg=str_replace("[LINK=","<a target=_blank href=",$szoveg);
$szoveg=str_replace("[/LINK]","</a>",$szoveg);
$szoveg=str_replace("[link=","<a target=_blank href=",$szoveg);
$szoveg=str_replace("[/link]","</a>",$szoveg);
$szoveg=str_replace("[color=","<font color=",$szoveg);
$szoveg=str_replace("[/color]","</font>",$szoveg);
$szoveg=str_replace("[COLOR=","<font color=",$szoveg);
$szoveg=str_replace("[/COLOR]","</font>",$szoveg);
$szoveg=str_replace("[YOUTUBE]http://www.youtube.com/watch?v=","<object width=425 height=344><param name=allowFullScreen value=true></param><param name=allowscriptaccess value=always></param><embed src=http://www.youtube.com/v/",$szoveg);
$szoveg=str_replace("[YOUTUBE]http://youtube.com/watch?v=","<object width=425 height=344><param name=allowFullScreen value=true></param><param name=allowscriptaccess value=always></param><embed src=http://www.youtube.com/v/",$szoveg);
$szoveg=str_replace("[YOUTUBE]https://www.youtube.com/watch?v=","<object width=425 height=344><param name=allowFullScreen value=true></param><param name=allowscriptaccess value=always></param><embed src=http://www.youtube.com/v/",$szoveg);
$szoveg=str_replace("[YOUTUBE]https://youtube.com/watch?v=","<object width=425 height=344><param name=allowFullScreen value=true></param><param name=allowscriptaccess value=always></param><embed src=http://www.youtube.com/v/",$szoveg);
$szoveg=str_replace("[YOUTUBE]youtube.com/watch?v=","<object width=425 height=344><param name=allowFullScreen value=true></param><param name=allowscriptaccess value=always></param><embed src=http://www.youtube.com/v/",$szoveg);
$szoveg=str_replace("[youtube]http://www.youtube.com/watch?v=","<object width=425 height=344><param name=allowFullScreen value=true></param><param name=allowscriptaccess value=always></param><embed src=http://www.youtube.com/v/",$szoveg);
$szoveg=str_replace("[youtube]http://youtube.com/watch?v=","<object width=425 height=344><param name=allowFullScreen value=true></param><param name=allowscriptaccess value=always></param><embed src=http://www.youtube.com/v/",$szoveg);
$szoveg=str_replace("[youtube]https://www.youtube.com/watch?v=","<object width=425 height=344><param name=allowFullScreen value=true></param><param name=allowscriptaccess value=always></param><embed src=http://www.youtube.com/v/",$szoveg);
$szoveg=str_replace("[youtube]https://youtube.com/watch?v=","<object width=425 height=344><param name=allowFullScreen value=true></param><param name=allowscriptaccess value=always></param><embed src=http://www.youtube.com/v/",$szoveg);
$szoveg=str_replace("[youtube]youtube.com/watch?v=","<object width=425 height=344><param name=allowFullScreen value=true></param><param name=allowscriptaccess value=always></param><embed src=http://www.youtube.com/v/",$szoveg);
$szoveg=str_replace("[/YOUTUBE]"," type=application/x-shockwave-flash allowscriptaccess=always allowfullscreen=true width=425 height=344></embed></object>",$szoveg);
$szoveg=str_replace("[/youtube]"," type=application/x-shockwave-flash allowscriptaccess=always allowfullscreen=true width=425 height=344></embed></object>",$szoveg);
$szoveg=str_replace("[marquee]","<marquee>",$szoveg);
$szoveg=str_replace("[MARQUEE]","<marquee>",$szoveg);
$szoveg=str_replace("[/marquee]","</marquee>",$szoveg);
$szoveg=str_replace("[/MARQUEE]","</marquee>",$szoveg);
$szovegek=explode("[/nev]",$szoveg);
for($i=0;$i<sizeof($szovegek);$i++)
{
  $seged[$i]=explode("[nev]", $szovegek[$i]);
  $user[$i]=$seged[$i][1];
  $kuty=new kutya();
  if($kuty->GetKutyaByNev($user[$i]))
  {
      $szoveg=str_replace("[nev]". $user[$i] ."[/nev]", $kuty->NevMegjelenitLinkelve(),$szoveg);
  }
  else{
     $szoveg=str_replace("[nev]". $user[$i] ."[/nev]", $user[$i],$szoveg);
  }
  
  }
$szoveg=str_replace("]",">",$szoveg);

return $szoveg;
}
function ubb_forum($szoveg){
include_once("oop.php");
$szoveg=str_replace("<","&lt;",$szoveg);

$szoveg=str_replace("[b]","<B>",$szoveg);
$szoveg=str_replace("[B]","<B>",$szoveg);
$szoveg=str_replace("[/b]","</B>",$szoveg);
$szoveg=str_replace("[/B]","</B>",$szoveg);
$szoveg=str_replace("[u]","<U>",$szoveg);
$szoveg=str_replace("[U]","<U>",$szoveg);
$szoveg=str_replace("[/u]","</U>",$szoveg);
$szoveg=str_replace("[/U]","</U>",$szoveg);
$szoveg=str_replace("[i]","<I>",$szoveg);
$szoveg=str_replace("[I]","<I>",$szoveg);
$szoveg=str_replace("[/i]","</I>",$szoveg);
$szoveg=str_replace("[/I]","</I>",$szoveg);
$szoveg=str_replace("[center]","<CENTER>",$szoveg);
$szoveg=str_replace("[CENTER]","<CENTER>",$szoveg);
$szoveg=str_replace("[/center]","</CENTER>",$szoveg);
$szoveg=str_replace("[/CENTER]","</CENTER>",$szoveg);
$szoveg=str_replace("[right]","<p align=right>",$szoveg);
$szoveg=str_replace("[RIGHT]","<<p align=right>",$szoveg);
$szoveg=str_replace("[/right]","</p>",$szoveg);
$szoveg=str_replace("[/RIGHT]","</p>",$szoveg);
$szoveg=str_replace("[LINK=","<a target=_blank href=",$szoveg);
$szoveg=str_replace("[/LINK]","</a>",$szoveg);
$szoveg=str_replace("[link=","<a target=_blank href=",$szoveg);
$szoveg=str_replace("[/link]","</a>",$szoveg);
$szoveg=str_replace("[color=","<font color=",$szoveg);
$szoveg=str_replace("[/color]","</font>",$szoveg);
$szoveg=str_replace("[COLOR=","<font color=",$szoveg);
$szoveg=str_replace("[/COLOR]","</font>",$szoveg);

$szoveg=str_replace("[youtube]","",$szoveg);
$szoveg=str_replace("[YOUTUBE]","",$szoveg);
$szoveg=str_replace("[/youtube]","",$szoveg);
$szoveg=str_replace("[/YOUTUBE]","",$szoveg);
$szovegek=explode("[/nev]",$szoveg);
for($i=0;$i<sizeof($szovegek);$i++)
{
  $seged[$i]=explode("[nev]", $szovegek[$i]);
  $user[$i]=$seged[$i][1];
  $kuty=new kutya();
  if($kuty->GetKutyaByNev($user[$i]))
  {
      $szoveg=str_replace("[nev]". $user[$i] ."[/nev]", $kuty->NevMegjelenitLinkelve(),$szoveg);
  }
  else{
     $szoveg=str_replace("[nev]". $user[$i] ."[/nev]", $user[$i],$szoveg);
  }
  
  }
$szoveg=str_replace("]",">",$szoveg);

return $szoveg;
}
function email($mail){
if(substr_count($mail,"@")==0){return 1;}
if(substr_count($mail,".")==0){return 1;}
if((strlen($mail)-strrpos($mail,"."))<3){return 1;}
return 0;
}
function oldal($adat){
header("Content-Type: text/html; charset=ISO-8859-2");
include("inc/head.php");
echo '<div style="width:940px;margin:auto;">
  <div class="keret_01"></div>
  <div style="position:absolute;">
    <div class="logo"></div>';
///menu
if(isset($_SESSION[id])){
$kelle="";
$uzi=mysql_query("SELECT * FROM uzenetek WHERE uzenet_kapo = '". $_SESSION[id] ."' and uzenet_olvas = '0'");
if(mysql_num_rows($uzi)>0){
$kelle=2;
}
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."' and mod_rang > '1' ");
$admin='';
if(mysql_num_rows($modie)>0)
{
$admin='<div class="menu" style="position:absolute; top:260px; left:240px; width:30px"><a href="admin.php" style="margin-right:0px;">Admin</a></div>';
}
echo "<script>
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
regititle=\"DogsWorld - legyen egy saját virtuális kutyád\";
ujtitle=\"Új üzeneted érkezett...\"
ujuzenet=0;
window.setInterval(function() {
    	url=\"inc/levelez.php?level=\";
  	AjaxAdatKuld(url, function(){ 
		if(arguments[0]>0){
		document.getElementById(\"levelek\").style.backgroundImage=\"url('pic/letter2.gif')\";
		ujuzenet=arguments[0];
		}
		else
		{
		ujuzenet=0;
		document.getElementById(\"levelek\").style.backgroundImage=\"url('pic/letter.gif')\";
		}
  });
}, 1800);

window.setInterval(function() {
    if(ujuzenet>0)
	{
		if(document.title==regititle)
		{
			document.title=ujtitle;
		}
		else
		{
			document.title=regititle;
		}
	}
	else
	{
		document.title=regititle;
	}
}, 1000);
</script>";
echo '<div class="menu" style="position:absolute; top:226px; left:350px; width:590px">

<a href="uzenetek.php" style="background-image:url(pic/letter'. $kelle .'.gif);margin-right:0px;" id="levelek">Üzenetek</a> <a href="uzenetek2.php" style="margin-left:0px;margin-right:0px;padding-left: 0px;">Új</a>
<a href="kutyak.php" style="background-image:url(pic/list.gif);">Kuty&aacute;k</a>
<a href="forum.php" style="background-image:url(pic/forum.gif);" >Fórum</a>
<a href="falka.php" style="background-image:url(pic/falka.gif); margin-top:2px;" >Falka</a>
<a href="adatlapok.php" style="background-image:url(pic/adatlap.gif); margin-top:4px;" >Adatlapok</a>
<a href="segitseg.php" style="background-image:url(pic/help.gif); margin-top:7px;" >Segíts&eacute;g</a>		 

</div>';
echo $admin .' <div class="menu" style="position:absolute; top:260px; left:340px; width:557px">
		   <a href="kutyam.php" style="background-image:url(pic/mydog.gif);" >&nbsp;Kutyám</a>
  		   <a href="baratok.php" style="background-image:url(pic/barat.gif);" >Barátlista</a>
  		   <a href="blog.php" style="background-image:url(pic/blog.gif);" >Blog</a>
  		   <a href="piac.php" style="background-image:url(pic/money.gif);" >Piac</a>
		   <a href="beallitas.php" style="background-image:url(pic/setting.gif);" >Be&aacute;ll&iacute;t&aacute;sok</a>
       <a href="logout.php" style="float:right; padding-left:2px; margin-right:0px;" >Kil&eacute;p&eacute;s</a>			 
		 </div>';
}else{
echo '<div class="menu" style="position:absolute; top:226px; left:350px; width:590px">

<a href="ujkutya.php" style="background-image:url(pic/mydog.gif);" >&nbsp;Új kutya</a>
<a href="szuloknek.php" style="background-image:url(pic/help.gif);" >Szülõknek</a>
<a href="index.php" style="background-image:url(pic/barat.gif);" >Fõoldal</a>
</div>';
}
echo '<div style="position:absolute; top:250px;">
<a href="uzenofal.php" class="link" style="position:absolute; top:43px; left:43px; font-size:15px; font-weight:bold;">&Uuml;zen&#337;fal:</a>



<div style="position:absolute; left:122px; top:42px; width:768px; height:25px;">
 <marquee style="color:#AA3311; font-size:18px"';echo" onmouseover='stop();' onmouseout='start();'>";
 uzenofal(); 
echo '</marquee></div>
 <div style="position:absolute; top:93px; left:-6px;">
<div style="background:url(pic/keret2.gif); width:48px; height:32px;"></div> 
<div style="background:url(pic/keret3.gif); width:846px; height:32px; position:absolute; left:48px; top:0px;"> </div>	
<div style="background:url(pic/keret4.gif); width:48px; height:32px; position:absolute; left:892px; top:0px;"> </div>	


<table width="940" border="0" cellspacing="0" cellpadding="0" summary="" style="background:url(pic/keret5.gif); background-repeat:repeat-y; height:400px">
       <tr >
<td width="48" valign="top" > </td>
<td valign="top" valign="top">';		 
echo $adat;
echo '</td><td width="48" valign="top" > </td></tr>
  <tr >
         <td valign="bottom" ><div style="background:url(pic/keret6.gif); width:48px; height:31px"></div></td>
	 <td>
         <td valign="bottom" ><div style="background:url(pic/keret8.gif); width:48px; height:31px"></div></td>
       </tr></table>
 <div class="keret_09"> </div>



</div>
 
	    
</div>
  </div>
  </div>
</div>';

echo "<script type=\"text/javascript\">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-16189096-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";

echo '</body>
</html>';
}
function hiba($szoveg){
return "<font color=#FF0000>". $szoveg ."</font>";
}
function ok($szoveg){
return "<font color=#007100>". $szoveg ."</font>";
}
function hosszellenorzes($szoveg,$min,$max){
if(strlen($szoveg)<$min){
return 1;
}
if(strlen($szoveg)>$max){
return 1;
}
return 0;
}
function kutyanevtoszam($szoveg){
include("sql.php");
$kell=mysql_query("SELECT * FROM fajta WHERE fajta_file = '". $szoveg ."'");
while($kutya=mysql_fetch_object($kell)){
return $kutya->fajta_id;
}
}
function kutyanevtogen($szoveg){
include("sql.php");
$kell=mysql_query("SELECT * FROM fajta WHERE fajta_file = '". $szoveg ."'");
while($kutya=mysql_fetch_object($kell)){
return $kutya->fajta_gen;
}
}
function kutyagentoszam($szoveg){
include("sql.php");
$kell=mysql_query("SELECT * FROM fajta WHERE fajta_gen = '". $szoveg ."'");
while($kutya=mysql_fetch_object($kell)){
return $kutya->fajta_id;
}
}
function kutyaszamtofile($szoveg){
include("sql.php");
$kell=mysql_query("SELECT * FROM fajta WHERE fajta_id = '". $szoveg ."'");
while($kutya=mysql_fetch_object($kell)){
return $kutya->fajta_file;
}
}
function kutyaszamtonev($szoveg){
include("sql.php");
$kell=mysql_query("SELECT * FROM fajta WHERE fajta_id = '". $szoveg ."'");
while($kutya=mysql_fetch_object($kell)){
return $kutya->fajta_nev;
}
}
function kutyaszamtogen($szoveg){
include("sql.php");
$kell=mysql_query("SELECT * FROM fajta WHERE fajta_id = '". $szoveg ."'");
while($kutya=mysql_fetch_object($kell)){
return $kutya->fajta_gen;
}
}
function kutyaszamtoszinszam($szoveg){
include("sql.php");
$kell=mysql_query("SELECT * FROM fajta WHERE fajta_id = '". $szoveg ."'");
while($kutya=mysql_fetch_object($kell)){
return $kutya->fajta_szin;
}
}
function nem($nem){
if($nem==2){
return "kan";
}else{
return "szuka";
}
}
function kerekit($szam){
if($szam>100){
return 100;
}elseif($szam<0){
return 0;
}else{
return $szam;
}
}
function belepido($nev){
include("sql.php");
$most=time();
$datumozas=mysql_query("UPDATE `kutya` SET `kutya_belepido` = '". $most ."' WHERE `kutya_nev` = '". $nev ."'");

}
function linker($id,$nev){
include("sql.php");
$leker=mysql_query("SELECT * FROM `kutya` WHERE `kutya_id` = '". $id ."' and `kutya_nev` = '". $nev ."'");
if(mysql_num_rows($leker)==0){
return htmlentities($nev);
}else{
return idtonev($id);
}
}
function linker_falka($id,$nev){
include("sql.php");
$leker=mysql_query("SELECT * FROM `falka` WHERE `falka_id` = '". $id ."' and `falka_nev` = '". $nev ."'");
if(mysql_num_rows($leker)==0){
return htmlentities($nev);
}else{

$visszater="<a href=falka.php?id=". $id ." class='barna'>". falkaidtonev($id) ."</a>";
return $visszater;
}
}
function idtonev($id){
include_once("oop.php");
$k=new kutya();
if($k->GetKutyaByID($id))
{
 return $k->NevMegjelenitRanggalLinkelve();
}else{
 return "<i>Törölt Kutya</i>";
}
}
function szamtosuly($num){
switch($num){
case 1:
$suly="20 kg alatt";
break;
case 2:
$suly="20-24 kg";
break;
case 3:
$suly="25-29 kg";
break;
case 4:
$suly="30-34 kg";
break;
case 5:
$suly="35-39 kg";
break;
case 6:
$suly="40-44 kg";
break;
case 7:
$suly="45-49 kg";
break;
case 8:
$suly="50-54 kg";
break;
case 9:
$suly="55-59 kg";
break;
case 10:
$suly="60-64 kg";
break;
case 11:
$suly="65-69 kg";
break;
case 12:
$suly="70-74 kg";
break;
case 13:
$suly="75-79 kg";
break;
case 14:
$suly="80-84 kg";
break;
case 15:
$suly="85-89 kg";
break;
case 16:
$suly="90-94 kg";
break;
case 17:
$suly="95-100 kg";
break;
case 18:
$suly="100 kg felett";
break;
}
return $suly;
}
function szamtomagassag($num){
switch($num){
case 1:
$magassag="100 cm alatt";
break;
case 2:
$magassag="100-109 cm";
break;
case 3:
$magassag="110-119 cm";
break;
case 4:
$magassag="120-129 cm";
break;
case 5:
$magassag="130-139 cm";
break;
case 6:
$magassag="140-149 cm";
break;
case 7:
$magassag="150-159 cm";
break;
case 8:
$magassag="160-169 cm";
break;
case 9:
$magassag="170-179 cm";
break;
case 10:
$magassag="180-189 cm";
break;
case 11:
$magassag="190-199 cm";
break;
case 12:
$magassag="200 cm felett";
break;
}
return $magassag;
}
function szamtohajszin($num){
switch($num){
case 1:
$hajszin="Szõke";
break;
case 2:
$hajszin="Szõkésbarna";
break;
case 3:
$hajszin="Barna";
break;
case 4:
$hajszin="Fekete";
break;
case 5:
$hajszin="Vörös";
break;
case 6:
$hajszin="Õsz";
break;
case 7:
$hajszin="Egyéb szín";
break;
}
return $hajszin;
}
function szamtoszemszin($num){
switch($num){
case 1:
$szemszin="kék";
break;
case 2:
$szemszin="kékeszöld";
break;
case 3:
$szemszin="zöld";
break;
case 4:
$szemszin="zöldesbarna";
break;
case 5:
$szemszin="barna";
break;
case 6:
$szemszin="fekete";
break;
}
return $szemszin;
}
function banner(){
$szoveg='<a href=http://dogsworld.uw.hu/nevelde/index.html><img src=http://dogsworld.uw.hu/pic/banner.gif border=0></a>';
return $szoveg;
}

function falkatorol($falka){
include("sql.php");
if(file_exists("../pic/falka/". $falka .".png")){
unlink("../pic/falka/". $falka .".png");
}
mysql_query("DELETE FROM falkatilto WHERE falkatilto_falka = '". $falka ."'");
mysql_query("DELETE FROM forum WHERE forum_topic = '". $falka ."'");
mysql_query("DELETE FROM falka WHERE falka_id = '". $falka ."'");
mysql_query("UPDATE kutya SET kutya_falka = 0 WHERE kutya_falka = '". $falka ."'");

}

function hetnapja($nap){
switch($nap){
case "Sunday":
$newnap="Vasárnap";
break;
case "Saturday":
$newnap="Szombat";
break;
case "Monday":
$newnap="Hétfõ";
break;
case "Tuesday":
$newnap="Kedd";
break;
case "Wednesday":
$newnap="Szerda";
break;
case "Thursday":
$newnap="Csütörtök";
break;
case "Friday":
$newnap="Péntek";
break;
}
return $newnap;
}
function falkapont($falkaid){
include("sql.php");
$pont=0;
$ipk=mysql_query("SELECT DISTINCT kutya_belepip FROM `kutya` WHERE kutya_falka = '". $falkaid ."'");
while($owners=mysql_fetch_object($ipk)){
$szamol=mysql_query("SELECT (kutya_kor * kutya_egeszseg /100) AS kutya_falkapont FROM kutya WHERE kutya_falka='". $falkaid ."' and kutya_belepip = '". $owners->kutya_belepip ."' and kutya_fagyasztva = '0' ORDER BY kutya_falkapont DESC limit 1");
while($eddigikutyak=mysql_fetch_object($szamol)){
$pont+=$eddigikutyak->kutya_falkapont;
}
}
mysql_query("UPDATE `falka` SET falka_pont = '". $pont ."' WHERE falka_id = '". $falkaid ."'",$kapcsolat);

}

function delete_hsz($tema_id)
{
	$rows = mysql_query("SELECT forum_id FROM forum WHERE forum_topic = '-". $tema_id ."' ORDER BY forum_id ASC LIMIT 50");
	$forum_ids = array();
	while($data = mysql_fetch_object($rows))
	{
		$forum_ids[] = $data->forum_id;
	}

	if (sizeof($forum_ids))
	{
		mysql_query("DELETE FROM forum WHERE forum_id IN (" . implode(', ', $forum_ids) . ")");
	}
}
//level listazas
function uzenet_listazas($en, $te)
{
include("sql.php");
include_once("stilus.php");
global $NINCSLEVEL;
$leker=mysql_query("SELECT * 
FROM uzenetek 
WHERE uzenet_kapo = '". $te ."' and uzenet_kuldo = '". $en ."' and uzenet_torol_kuldo = '0'
or uzenet_kapo = '". $en ."' and uzenet_kuldo = '". $te. "' and uzenet_torol_kapo = '0'
ORDER BY uzenet_ido");
$adat="";
if(mysql_num_rows($leker)>0)
{
while($uzenet=mysql_fetch_object($leker)){
if($uzenet->uzenet_olvas==0){
	if($uzenet->uzenet_kapo==$en)
	{
		$adat.=Uzenet($uzenet->uzenet_kuldo,$uzenet->uzenet_id, nl2br($uzenet->uzenet_tartalom), $uzenet->uzenet_ido, "cf7082", "cf8c98");
	}
	else
	{
		$adat.=Uzenet($uzenet->uzenet_kuldo,$uzenet->uzenet_id, nl2br($uzenet->uzenet_tartalom), $uzenet->uzenet_ido, "6fc7ff", "9fdaff");
	}
}else{
$adat.=Uzenet($uzenet->uzenet_kuldo,$uzenet->uzenet_id, nl2br($uzenet->uzenet_tartalom), $uzenet->uzenet_ido, "e6ba8e", "e7c8a9");
}
}
return $adat;
}
else{
return $NINCSLEVEL;
}
}
function uj_lotto_nyeroszam()
{
include("sql.php");
mysql_query("DELETE FROM lottonyeroszam");

$szam=veletlen(1,10,3);
mysql_query("INSERT INTO lottonyeroszam VALUES('". $szam[0] ."','". $szam[1] ."','". $szam[2] ."')");
}
function osszes_uzenet_listazasa($ki)
{
include("sql.php");
include_once("stilus.php");
$leker=mysql_query("SELECT * FROM
(SELECT uzenet_kapo FROM uzenetek 
WHERE uzenet_kuldo = '". $ki ."' and uzenet_torol_kuldo = '0' 
UNION 
SELECT uzenet_kuldo as uzenet_kapo 
FROM uzenetek
WHERE uzenet_kapo = '". $ki ."' and uzenet_torol_kapo = '0') levelezesek
LEFT JOIN (SELECT * FROM uzenetek WHERE (uzenet_kuldo = '". $ki ."' and uzenet_torol_kuldo = '0') or (uzenet_kapo = '". $ki ."' and uzenet_torol_kapo = '0') ORDER BY uzenet_ido DESC) uzi
ON levelezesek.uzenet_kapo = uzi.uzenet_kapo or levelezesek.uzenet_kapo = uzi.uzenet_kuldo
GROUP BY levelezesek.uzenet_kapo
ORDER BY uzenet_ido DESC");
if(mysql_num_rows($leker)>0){
$adat="";
while($uzenet=mysql_fetch_object($leker)){
$kutya=new kutya();
if($uzenet->uzenet_kapo!=$ki)
{
	$kutya->GetKutyaByID($uzenet->uzenet_kapo);
}
else
{
	$kutya->GetKutyaByID($uzenet->uzenet_kuldo);
}

if($uzenet->uzenet_olvas==0){
	$oldal="uzenetek2.php";
	if($uzenet->uzenet_kapo==$ki)
	{
		$adat.=Uzenet($kutya->id, $uzenet->uzenet_id, "<a href=". $oldal ."?id=". $kutya->id ." class='feherlink'>".nl2br($uzenet->uzenet_tartalom)."</a>", $uzenet->uzenet_ido, "cf7082", "cf8c98");
	}
	else
	{
		$adat.=Uzenet($kutya->id, $uzenet->uzenet_id, "<a href=". $oldal ."?id=". $kutya->id ." class='feherlink'>".nl2br($uzenet->uzenet_tartalom)."</a>", $uzenet->uzenet_ido, "6fc7ff", "9fdaff");
		
	}
}else{
$adat.=Uzenet($kutya->id, $uzenet->uzenet_id, "<a href=". $oldal ."?id=". $kutya->id ." class='feherlink'>".nl2br($uzenet->uzenet_tartalom)."</a>", $uzenet->uzenet_ido, "e6ba8e", "e7c8a9");
}

}
}else{
$adat.=hiba("Nincsennek üzeneteid!");
}
return $adat;
}
function falkaidtonev($id)
{
$falkale=mysql_query("SELECT * FROM falka WHERE falka_id = '". $id ."'");
if(mysql_num_rows($falkale)==0)
{
	return "<i>Törölt falka</i>";
}
else
{
while($falka=mysql_fetch_object($falkale))
{
if($falka->falka_szin=="774411")
{
	return htmlentities($falka->falka_nev);
}else{
	return "<font color=#". $falka->falka_szin .">". htmlentities($falka->falka_nev) ."</font>";
}
}
}
}
?>