<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
include("inc/stilus.php");
if(isset($_SESSION[nev])){
function ujBlog($id,$blogCim,$blogBejegyzes)
{
if($id!='')
{
$id="?id=". $id;
}
return "<script>
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
	function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\"/g, '&quot;');
	}
	function elonezet()
	{
		url=\"inc/elonezet.php?blog=\"+document.getElementById(\"bloog\").value.replace(/\\r\\n|\\r|\\n/g, \"[br]\");
  	AjaxAdatKuld(url, function(){ 
		document.getElementById(\"elonezet\").innerHTML=\"<font color=#ff0000 size=+2>Elõnézet:</font><br><br><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=800></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr><tr><td background=pic/hatter8.gif colspan=3 align=center><table border=0><tr><td align=left width=400>\"+ htmlEntities(document.getElementById(\"cim\").value) +\"</td><td align=right width=400><a href=blog.php?id=". $_SESSION[id] ." class='feherlink'>Blog fõoldal</a> Idõ: 0000.00.00 00:00:00</td></tr></table><tr bgcolor=#ffffff><td align=left colspan=3 class='forum'>\"+ arguments[0] +\"</td></tr><tr><td background=pic/hatter8.gif colspan=3 height=2></td></tr><tr bgcolor=#ffffff><td colspan=3 align=center>Új komment írása:</td></tr><tr><td width=11 height=11 background=pic/balalso3.jpg></td><td bgcolor=#ffffff></td><td width=11 height=11 background=pic/jobbalso3.jpg></td></tr></td></tr></table>\";
  });
	}
</script>
<center>".VilagosMenu(600,	"<form action=inc/ujblog.php". $id ." method=POST>
<big><big>Új bejegyzés írása a blogba</big></big><br><br>
<table><tr><td align=left>Bejegyzés címe:</td><td align=right><input type=text name=cim id=cim maxlength=60 value='". $blogCim ."'></td><td>max. 60 karakter</td></tr>
<tr><td colspan=3 align=center>Bejegyzés:</td></tr><tr><td colspan=3 align=center><textarea name=leiras cols=50 rows=12 id=bloog>". $blogBejegyzes ."</textarea></td></tr><tr><td colspan=3 align=center><input type=button value='Elõnézet' onclick='elonezet()'> <input type=submit value='Elküld'></td></tr></table>").
"<br><div id=\"elonezet\"></div>";
}
if(isset($_GET[id])){
$leker=mysql_query("SELECT * FROM blog WHERE blog_id = '". $_GET[id] ."' and blog_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($leker)>0){
while($blog=mysql_fetch_object($leker)){
$hiba=$_SESSION[hiba];
$adat=ujBlog($_GET[id],$blog->blog_cim,$blog->blog_bejegyzes);
$adat.=$hiba;
$_SESSION[hiba]="";
}
}else{
header("Location: index.php");
}
}else{

$hiba=$_SESSION[hiba];
$adat=ujBlog('','','');
$adat.=$hiba;
$_SESSION[hiba]="";

}
oldal($adat);
}else{
header("Location: index.php");
}
?>
