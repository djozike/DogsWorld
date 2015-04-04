<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
if(isset($_SESSION[id])){
$en=new kutya();
$en->GetKutyaByID($_SESSION[id]);
if(( ($BLOGIRASTANULAS==1 and $en->Tanult("IR")) or $BLOGIRASTANULAS==0) and (($BLOGIRASMINNAP!=0 and $BLOGIRASMINNAP <= $en->kor) or $BLOGIRASMINNAP==0))
{
$ujblog="<a href=ujbejegyzes.php><img src=pic/ujblog.jpg></a>";
}
$menu=$ujblog ."<br><a href=blog.php class='feherlink'>Friss blogok</a> | <a href=blog.php?id=". $_SESSION[id] ." class='feherlink'>Saját blogom</a> | <a href=blog.php?baratok=". $_SESSION[id] ." class='feherlink'>Barátaim blogjai</a> | <a href=blog.php?kommentek=". $_SESSION[id] ." class='feherlink'>Kommentjeim</a><br>";

if(isset($_GET[id])){
$kutyus=new kutya();
$kutyus->GetKutyaByID($_GET[id]);
if($kutyus->id != 0){
$adat="<center><big><big>". $kutyus->NevMegjelenitRanggalLinkelve()  ." blogja</a></big></big><br>";
if($kutyus->id==$_SESSION[id]){
$adat.="<br>". $menu ."<br>";
}
$adat.="<br><u>Eddigi bejegyzések ebben a blogban:</u><br>";
if(isset($_GET[oldal])){
$oldal=$_GET[oldal];
}else{
$oldal=0;
}
$szamol=mysql_query("SELECT * FROM blog WHERE blog_kutya = '". $kutyus->id ."' ORDER BY blog_id DESC");
$bejegyzes=mysql_query("SELECT * FROM blog WHERE blog_kutya = '". $kutyus->id."' ORDER BY blog_id DESC limit ". $oldal .", 20");
$db=mysql_num_rows($szamol);
if(mysql_num_rows($bejegyzes)>0){
while($blog=mysql_fetch_object($bejegyzes)){
$kommentek=mysql_query("SELECT * FROM komment WHERE komment_blog = '". $blog->blog_id ."'");
$adat.="<br><table border=0 bgcolor=#ffffff width=740><tr><td align=center>

<table border=0 width=720 cellpadding=0 cellspacing=0><tr background=pic/hatter8.gif><td align=left>&nbsp;". htmlentities($blog->blog_cim) ."</td><td width=220 align=right>Idõ: ". str_replace("-",".",$blog->blog_ido) ."&nbsp;</td>
</td></tr><tr><td colspan=2 align=left><div style='width: 720px; overflow-x: auto;'>". substr(ubb_forum($blog->blog_bejegyzes),0,270) ."...</div></td></tr><tr><td colspan=2 align=right><a href=blog.php?blog=". $blog->blog_id ."#kommentek class='feherlink'>Kommentek(". mysql_num_rows($kommentek) .")</a> <a href=blog.php?blog=". $blog->blog_id ." class='feherlink'>Részletek...</a></td></tr></table>
</table>";
}
if($oldal!=0){$adat.="<a href=blog.php?id=". $_GET[id] ."&oldal=". ($oldal-20) ." class='feherlink'>Elõzõ 20 bejegyzés</a>";}
if($oldal< ($db-20)){$adat.=" <a href=blog.php?id=". $_GET[id] ."&oldal=". ($oldal+20) ." class='feherlink'>Következõ 20 bejegyzés</a>";}

}else{
$adat.=hiba("<br>Nincs még egy bejegyzés se ebben a blogban!");
}
}else{
$adat=hiba("<center><br><br><br><br>Nincs ilyen blog!</center>");
}
}elseif(isset($_GET[blog])){
$blogs=mysql_query("SELECT * FROM blog WHERE blog_id = '". $_GET[blog] ."'");
if(mysql_num_rows($blogs)>0){
while($blog=mysql_fetch_object($blogs)){
$kutyus=new kutya();
$kutyus->GetKutyaByID($blog->blog_kutya);

$moderator="";
if($en->rang > 0){
$moderator='<script>
function Delete() {
  if (confirm("Biztos törölni szeretnéd ezt a bejegyzést?")) {
    document.location = "inc/mbtorol.php?id='. $blog->blog_id .'";
  }
}
</script>';
$moderator.="<a href='javascript:Delete()' class='feherlink'>Törlés</a> ";
}
$adat="<center><big><big><a href=kutyak.php?id=". $kutya->kutya_id ." class='barna'>". $kutyus->NevMegjelenitRanggalLinkelve()  ." blogja</font></a></big></big><br><br>
<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=800></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center><table border=0><tr><td align=left width=400>". htmlentities($blog->blog_cim)   ."</td><td align=right width=400>". $moderator ."<a href=blog.php?id=". $blog->blog_kutya ." class='feherlink'>Blog fõoldal</a> Idõ: ". str_replace("-",".",$blog->blog_ido) ."</td></tr>
</table>";
if($blog->blog_kutya == $_SESSION[id] ){
$adat.='<script>
function confirmDelete() {
  if (confirm("Biztos törölni szeretnéd ezt a bejegyzést?")) {
    document.location = "inc/btorol.php?id='. $blog->blog_id .'";
  }
}
</script>';
$adat.="<tr bgcolor=#ffffff><td align=center colspan=3><a href=ujbejegyzes.php?id=". $blog->blog_id ." class='feherlink'>Szerkesztés</a> <a href='javascript:confirmDelete()' class='feherlink'>Törlés</a></td></tr>";
}
$korabbi=mysql_query("SELECT * FROM blog WHERE blog_kutya = '". $blog->blog_kutya ."' and blog_id < ". $blog->blog_id ." ORDER BY blog_id DESC limit 1");
while($koran=mysql_fetch_object($korabbi)){
$korabban="<a href=blog.php?blog=". $koran->blog_id ." class='feherlink'>Elõzõ bejegyzés</a>";
}
$kesobbi=mysql_query("SELECT * FROM blog WHERE blog_kutya = '". $blog->blog_kutya ."' and blog_id > ". $blog->blog_id ." ORDER BY blog_id ASC limit 1");
while($keson=mysql_fetch_object($kesobbi)){
$kesobb="<a href=blog.php?blog=". $keson->blog_id ." class='feherlink'>Következõ bejegyzés</a>";
}
if($korabban!="" or $kesobb!=""){
$adat.="<tr bgcolor=#ffffff><td align=left colspan=3><table width=800><tr><td align=left width=400>". $korabban ."</td><td align=right width=400>". $kesobb ."</td></tr></table></td></tr>";
}
$adat.='	<script type="text/javascript">
		function viewMore(div) {
			obj = document.getElementById(div);
			col = document.getElementById("x" + div);
 
			if (obj.style.display == "none") {
				obj.style.display = "block";
			} else {
				obj.style.display = "none";
			}
		}
	</script>';
$adat.="<tr bgcolor=#ffffff><td align=left colspan=3 class='forum'><div style='width: 810px; overflow-x: auto;'>". nl2br(ubb_adatlap($blog->blog_bejegyzes)) ."</div>

</td></tr><tr><td background=pic/hatter8.gif colspan=3 height=2></td></tr>

<tr bgcolor=#ffffff><td colspan=3 align=center>";
if(( ($BLOGIRASTANULAS==1 and $en->Tanult("IR")) or $BLOGIRASTANULAS==0) and (($BLOGIRASMINNAP!=0 and $BLOGIRASMINNAP <= $en->kor) or $BLOGIRASMINNAP==0))
{
$ujkomi="<input type=hidden name=blog value=". $blog->blog_id ."><textarea name=komment cols=50></textarea><br><input type=submit value=Elküld>";
}
else{
	$ujkomi=hiba("Nem irhatsz új kommentet, mivel");
	if($BLOGIRASTANULAS==1 and !$en->Tanult("IR"))
	{
		$ujkomi.=hiba(" nem tanultál meg írni");
	}
	if(($BLOGIRASMINNAP!=0 and $BLOGIRASMINNAP > $en->kor))
	{
		$ujkomi.=hiba(" fiatalabb vagy mint ". $BLOGIRASMINNAP ." nap");
	}
	$ujkomi.=hiba(".");
}
$adat.="<a href=javascript:viewMore(\"two\"); class=\"barna\">Új komment írása:</a><form action=inc/komment.php method=POST><p id=\"two\" style=\"display:none\">". $ujkomi ."</p></form></td></tr><tr bgcolor=#ffffff><td colspan=3 align=center><a id=kommentek>Kommentek:</a>";

$kommentek=mysql_query("SELECT * FROM komment WHERE komment_blog = '". $blog->blog_id ."' ORDER BY komment_id DESC");
if(mysql_num_rows($kommentek)>0){
while($komment=mysql_fetch_object($kommentek)){
if(file_exists("pic/user/". $komment->komment_kid .".png")){
$kep="<a href=pic/user/". $komment->komment_kid .".png target=_blank><img src=pic.php?id=". $komment->komment_kid ."&size=100 border=0></a>";
}
elseif(file_exists("pic/user/". $komment->komment_kid .".gif")){
$kep="<a href=pic/user/". $komment->komment_kid .".gif target=_blank><img src=\"pic/user/". $komment->komment_kid .".gif\" border=0  width=100 height=100></a>";
}
else{
$kep="<img src=pic/user/avatar.jpg border=0 width=100 height=100>";
}
if($blog->blog_kutya==$_SESSION[id] or $en->rang > 0){
$torol="<a href=inc/ktorol.php?id=". $komment->komment_id ." class='feherlink'>Törlés</a>";
}
$adat.="<table border=0 width=750 CELLSPACING=0 CELLPADDING=0><tr background=pic/hatter8.gif><td align=left class='forum' colspan=2>
<table border=0 width=750 CELLSPACING=0 CELLPADDING=0><tr><td align=left><a href=kutyak.php?id=". $komment->komment_kid ." class='feherlink'>". $komment->komment_nev ."</a></td><td align=right>". $torol ." ". str_replace("-",".",$komment->komment_ido) ."</td></tr></table>
</td></tr>
<tr><td background=pic/hatter8.gif align=center height=105 valign=top width=110><center>". $kep ." </center></td><td align=left valign=top width=640 class='forum'><div style='width: 640px; overflow-x: auto;'>". nl2br($komment->komment_komment) ."</td></tr></table><br>";
}
}else{
$adat.=hiba("<br>Nincsenek még kommentek!");
}
$adat.="</td></tr><tr><td width=11 height=11 background=pic/balalso3.jpg></td><td bgcolor=#ffffff></td><td width=11 height=11 background=pic/jobbalso3.jpg></td></tr>
</td></tr></table>";

}
}else{
$adat=hiba("<center><br><br><br><br>Nincs ilyen blog!</center>");
}
}else
{

 if(isset($_GET[kommentek]))
 {
 $sql=mysql_query("SELECT DISTINCT * FROM komment INNER JOIN blog ON komment.komment_blog = blog.blog_id WHERE komment.komment_kid = '". $_SESSION[id] ."' GROUP BY komment.komment_blog ORDER BY komment.komment_id DESC limit 25");
 $hibacs="<big>". ok("Nincsenek még kommentjeid.") . "</big>";
 $title="Legutóbbi Kommentjeim";
 $title2="Legutóbbi Kommentjeim";
 }
 elseif(isset($_GET[baratok]))
 {
  $sql=mysql_query("select * from blog inner join kutya on blog.blog_kutya = kutya.kutya_id where blog_kutya in (select baratlista_barat from baratlista where baratlista_owner = '". $_SESSION[id] ."') order by blog_id desc limit 10");
  $hibacs=hiba("<br>Nincsenek még barátaid vagy a barátaidnak blogbejegyzéseik!");
  $title="Barátaim blogjai";
  $title2="Barátaim legutóbbi blog bejegyzései";
 }
 else
 {
  $sql=mysql_query("SELECT * FROM blog INNER JOIN kutya ON blog.blog_kutya = kutya.kutya_id ORDER BY blog_id DESC limit 10");
  $hibacs=hiba("<br>Nincsenek még blogbejegyzések az oldalon!");
  $title="Blog";
  $title2="Legfrissebb blog bejegyzések";
 }
 
 $adat="<center><big><big>". $title ."</big></big><br><br>". $menu ."<br><u>". $title2 .":</u>";
 
  if(mysql_num_rows($sql)==0)
  {
     $adat.=$hibacs;
  }else{
      while($blog=mysql_fetch_object($sql))
      {
        $kommentek=mysql_query("SELECT * FROM komment WHERE komment_blog = '". $blog->blog_id ."'");
        $adat.="<br><table border=0 bgcolor=#ffffff width=740><tr><td align=center>
        <table border=0 width=720 cellpadding=0 cellspacing=0><tr><td align=left background=pic/hatter8.gif width=70%>". htmlentities($blog->blog_cim) ."</td><td width=220 align=right background=pic/hatter8.gif>Idõ: ". str_replace("-",".",$blog->blog_ido) ."&nbsp;</td>
        </td></tr><tr><td colspan=2 align=left><div style='width: 720px; overflow-x: auto;'>". substr(ubb_forum($blog->blog_bejegyzes),0,270) ."...</div></td></tr><tr><td colspan=2 align=right>Szerzõ: ". idtonev($blog->blog_kutya) ." <a href=blog.php?blog=". $blog->blog_id ."#kommentek class='feherlink'>Kommentek(". mysql_num_rows($kommentek) .")</a> <a href=blog.php?blog=". $blog->blog_id ." class='feherlink'>Részletek...</a></td></tr></table>
        </table>";
      
      }
  
  }
 $adat.="</center>";
}
$adat.="</center>";
oldal($adat);
}else{
header("Location: index.php");
}
?>
