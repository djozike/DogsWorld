<?php
$root_path = (defined('ROOT_PATH')) ? ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include("inc/sql.php");
include("inc/session.php");
include("inc/oop.php");
if(isset($_SESSION[id])){

/*	téma azonosítók
*
* 501	= társalgó
* 502	= hírdetések
* 4		= ötletek
* 565	= segítség
* 1		= hibák
*
*/

$tema_id = $_GET[tema] = empty($_GET[tema]) ? 501 : $_GET[tema];

$engedelyezett_temak = array(501, 502, 565, 4, 1);

if (!in_array($tema_id, $engedelyezett_temak))
{
	// elsõdleges téma megjelenítése.
	$tema_id = $_GET[tema] = 501;
}

// fórum fejléc linkek

$tarsalgo	= ($tema_id != 501)	? '<a href="' . $root_path . 'forum.' . $phpEx . '?tema=501"	class="feherlink">Társalgó</a>' : '';
$hirdetesek	= ($tema_id != 502)	? '<a href="' . $root_path . 'forum.' . $phpEx . '?tema=502"	class="feherlink">Hirdetések</a>' : '';
$otletek	= ($tema_id != 4)	? '<a href="' . $root_path . 'forum.' . $phpEx . '?tema=4"		class="feherlink">Ötletek</a>' : '';
$segitseg	= ($tema_id != 565)	? '<a href="' . $root_path . 'forum.' . $phpEx . '?tema=565"	class="feherlink">Segítség</a>' : '';
$hibak		= ($tema_id != 1)	? '<a href="' . $root_path . 'forum.' . $phpEx . '?tema=1"		class="feherlink">Hibák</a>' : '';

$links		= $tarsalgo . (($tarsalgo) ? '&nbsp;&bull;&nbsp;' : '');
$links	   .= $hirdetesek . (($hirdetesek) ? '&nbsp;&bull;&nbsp;' : '');
$links	   .= $otletek . (($otletek) ? '&nbsp;&bull;&nbsp;' : '');
$links	   .= $segitseg . (($segitseg && $hibak) ? '&nbsp;&bull;&nbsp;' : '');
$links	   .= $hibak;

$adat = "<center>{$links}<br \><br \>";

$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if(isset($_GET[tema])){
$leker=mysql_query("SELECT * FROM forumtema WHERE forumtema_id = '". $_GET[tema] ."'");
if(mysql_num_rows($leker)>0)
{
	while($forum=mysql_fetch_object($leker))
	{
		$adat.='<big><b><u>'. htmlentities($forum->forumtema_nev) .'</u></b></big><br><br>';

		if(substr_count($kutya->kutya_tanul,"IR")==0){
		$adat.=hiba("Nem tudsz hozzászolást írni, mivel a kutyád nem tanult meg írni!");
		}else{
		$tilte=mysql_query("SELECT * FROM forumtilt WHERE forumtilt_kid = '". $_SESSION[id] ."'");
		$iptilte=mysql_query("SELECT * FROM forumiptilt WHERE forumiptilt_ip = '". $ip ."'");
		if(mysql_num_rows($tilte)>0){
		while($tilto=mysql_fetch_object($tilte)){
		$adat.=hiba("Sajnos letiltottak a fórumról, ezért nem irhatsz hozzászolást még ". $tilto->forumtilt_ido ." napig!");
		}
		}elseif(mysql_num_rows($iptilte)>0){
		while($tilto=mysql_fetch_object($iptilte)){
		$adat.=hiba("Sajnos letiltották az IP címed a fórumról, ezért nem irhatsz errõl a számítógéprõl hozzászólást még ". $tilto->forumiptilt_ido ." napig!");
		}
		}else{
		$adat.='<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=500></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
		<tr><td background=pic/hatter8.gif colspan=3 align=center><form method=POST action=inc/forum.php><input type=hidden name=topic value='. $_GET[tema] .'>Üzeneted:<br><textarea name=uzenet cols=50 rows=6></textarea><br \><br \><input style="cursor:pointer;" type=submit value="Elküld"></form>
		</td></tr><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table>';
		$adat.=$_SESSION[hiba];
		$_SESSION[hiba]="";
		}}
		$adat.="<br>";
		$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
		if(mysql_num_rows($modie)>0){
		$adat.='<script>
		function confirmDeletem() {
		  if (confirm("Biztos törölni szeretnéd ezt a témát?")) {
			document.location = "inc/mfttorol.php?id='. $forum->forumtema_id .'";
		  }
		}
		</script>';
		$adat.="<u>IP Tiltás</u>
		<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=500></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
		<tr><td background=pic/hatter8.gif colspan=3 align=center>
		<table border=0><tr><td align=right>Tiltandó IP:</td><td><form action=inc/mftiltip.php method=POST><input type=hidden name=fid value=". $forum->forumtema_id ."><input type=text name=ip></td><td>Idõ:</td><td><input type=hidden name=ido value=5>5 nap</td><td><input type=submit value=Elküld></form></td></tr></table>
		</td></tr><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table><br>";
		}
		switch($forum->forumtema_topic){
		case 1:
		$cim="Általános beszélgetés";
		break;
		case 2:
		$cim="Játékok";
		break;
		case 3:
		$cim="Kutyuskanevelde";
		break;
		}
		//$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td align=left width=740><a href=forum.php class='barna'>Fórum</a> -> <a href=forum.php?topic=". $forum->forumtema_topic ." class='barna'>". $cim ."</a> -> <a href=forum.php?tema=". $forum->forumtema_id ." class='barna'>". htmlentities($forum->forumtema_nev) ."</a></td><td></td></tr></table>";
		if($_GET[oldal]>0){
		$oldal=$_GET[oldal];
		}else{ $oldal=0; }
		$topic=$forum->forumtema_id;
		$leker=mysql_query("SELECT * FROM forum WHERE forum_topic = '-". $topic ."' ORDER BY forum_id DESC limit ". $oldal .",25");
		while($forum=mysql_fetch_object($leker)){

		$moderator="";
		$moderator1="";
		$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
		if(mysql_num_rows($modie)>0){
		$moderator1.="<form method=POST action=inc/mftilt.php>";
		$moderator.=" <a href='inc/mutorol.php?id=". $forum->forum_id ."' class='feherlink'>Üzenet Törlése</a> Tiltás <select name=ido style='width: 30px;'><option value=1>1</option>
		<option value=2>2</option><option value=3>3</option><option value=5>5</option><option value=10>10</option></select> napra <input type=hidden name=fid value=". abs($forum->forum_topic) ."><input type=hidden name=kid value=". $forum->forum_kid ."><input type=submit value='Tilt' style='width: 35px; background:#980000;'></form>";
		}
		$tilt="";
		$tilte=mysql_query("SELECT * FROM forumtilt WHERE forumtilt_kid = '". $forum->forum_kid ."'");
		if(mysql_num_rows($tilte)>0){
		while($tilto=mysql_fetch_object($tilte)){
		$tilt=hiba(" (Tiltva ". $tilto->forumtilt_ido ." napig)");
		}}
		$forumozoKutya = new kutya();
		$forumozoKutya->getKutyaByID($forum->forum_kid);
		$adat.=$moderator1 ."<table border=0 width=750 CELLSPACING=0 CELLPADDING=0><tr background=pic/hatter8.gif><td align=left class='forum' colspan=2>
		<table border=0 width=750 CELLSPACING=0 CELLPADDING=0><tr><td align=left>". idtonev($forum->forum_kid). $tilt  ."</td><td align=right>". $moderator . str_replace("-",".",$forum->forum_ido) ."</td></tr></table></td></tr>
		<tr><td background=pic/hatter8.gif align=center height=105 valign=top width=110><center>". $forumozoKutya->Avatar(100) ." </center></td><td align=left valign=top width=640 class='forum'>". nl2br($forum->forum_uzenet) ."</td></tr></table><br>";
		}
		$hozzaszolasszam=mysql_query("SELECT * FROM forum WHERE forum_topic = '-". $topic ."'");
		$hsz_num = mysql_num_rows($hozzaszolasszam);

		if ($oldal < $hsz_num-25)
		{
			$adat.="<a href=forum.php?tema=". $topic ."&oldal=". ($oldal+25) ." class='feherlink'>Elõzõ 25 hozzászolás</a>";

			if ($oldal != 0)
			{
				$adat.="&nbsp;&bull;&nbsp;";
			}
		}

		if ($oldal != 0)
		{
			$adat.="<a href=forum.php?tema=". $topic ."&oldal=". ($oldal-25) ." class='feherlink'>Következõ 25 hozzászolás</a>";
		}

		if ($hsz_num >= 200)
		{
			delete_hsz($tema_id);
		}
	}
}
else
{
	header("Location: forum.php");
}
}else{
if(isset($_GET[topic])){
switch($_GET[topic]){
case 1:
$cim="Általános beszélgetés";
break;
case 2:
$cim="Játékok";
break;
case 3:
$cim="Kutyuskanevelde";
break;
}
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$adat.='<big><big><b><u>'. $cim .'</u></b></big></big><br><br>
<table border=0 cellpadding=0 cellspacing=0><tr><td align=left width=580><a href=forum.php class="barna">Fórum</a> -> <a href=forum.php?topic='. $_GET[topic] .' class="barna">'. $cim .'</a></td><td><a href=ujtema.php?topic='. $_GET[topic] .' class="feherlink">Új téma inditása</a></td></tr></table></th>';
}
$adat.='<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg width=620></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td align=left>
<table><tr><th align=center width=300>Név</th><th align=center>Hozzászolások száma</th><th align=center>Létrehozó</th><th align=center>Utolsó hozzászoló</th></tr>';

$leker2=mysql_query("SELECT * FROM forumtema WHERE forumtema_topic = '". $_GET[topic] ."' ORDER BY forumtema_ido DESC");
while($forum=mysql_fetch_object($leker2)){
if($forum->forumtema_topic == $_GET[topic]){
$szamol=mysql_query("SELECT * FROM forum WHERE forum_topic = '-". $forum->forumtema_id ."'");
$szamol2=mysql_query("SELECT * FROM forum WHERE forum_topic = '-". $forum->forumtema_id ."' ORDER BY forum_id DESC limit 1");
$valaki="-";
while($kutyaszol=mysql_fetch_object($szamol2)){
$valaki=idtonev($kutyaszol->forum_kid);
}
$adat.="<tr><td align=left><a href=forum.php?tema=". $forum->forumtema_id ." class='barna'>". htmlentities($forum->forumtema_nev) ."</a></td><td align=center>". mysql_num_rows($szamol) ." db</td><td align=center>". idtonev($forum->forumtema_kutya) ."</td><td align=center>". $valaki ."</td></tr>";
}}

$adat.='</table>
</td><th width=11 background=pic/keret.jpg></th></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th width=11 background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table>';
}else{
$egyes=mysql_query("SELECT * FROM forumtema WHERE forumtema_topic = '1'");
$kettes=mysql_query("SELECT * FROM forumtema WHERE forumtema_topic = '2'");
$harmas=mysql_query("SELECT * FROM forumtema WHERE forumtema_topic = '3'");
$egyes2=mysql_query("SELECT * FROM `forumtema` INNER JOIN forum ON forumtema.forumtema_id = ABS(forum.forum_topic) WHERE forumtema_topic = '1' ORDER BY forum.forum_id DESC limit 1");
$kettes2=mysql_query("SELECT * FROM `forumtema` INNER JOIN forum ON forumtema.forumtema_id = ABS(forum.forum_topic) WHERE forumtema_topic = '2' ORDER BY forum.forum_id DESC limit 1");
$harmas2=mysql_query("SELECT * FROM `forumtema` INNER JOIN forum ON forumtema.forumtema_id = ABS(forum.forum_topic) WHERE forumtema_topic = '3' ORDER BY forum.forum_id DESC limit 1");    
while($egyes3=mysql_fetch_object($egyes2)){$egyes4=$egyes3->forum_kid;}
while($kettes3=mysql_fetch_object($kettes2)){$kettes4=$kettes3->forum_kid;}
while($harmas3=mysql_fetch_object($harmas2)){$harmas4=$harmas3->forum_kid;}
$adat.='<big><big><b><u>Fórum</u></b></big></big><br><br>
<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg width=620></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td align=left>
<table><tr><th align=center width=400>Név</th><th align=center>Témák száma</th><th align=center>Utolsó hozzászoló</th></tr>
<tr><td align=left><a href=forum.php?topic=1 class="barna"><b>Általános beszélgetés</b></a><br>Általános, kevésbé megkötött témák</td><td align=center>'. mysql_num_rows($egyes) .' db</td><td align=center>'. idtonev($egyes4) .'</td></tr>
<tr><td align=left><a href=forum.php?topic=2 class="barna"><b>Játékok</b></a><br>Fórumon játszható játékok</td><td align=center>'. mysql_num_rows($kettes) .' db</td><td align=center>'. idtonev($kettes4) .'</td></tr>
<tr><td align=left><a href=forum.php?topic=3 class="barna"><b>Kutyuskanevelde</b></a><br>Az oldallal kapcsolatos dolgok</td><td align=center>'. mysql_num_rows($harmas) .' db</td><td align=center>'. idtonev($harmas4) .'</td></tr></table>
</td><th width=11 background=pic/keret.jpg></th></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th width=11 background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table><br>'. banner();
}}
}
$adat.="</center>";
oldal($adat);
}else{

header("Location: index.php");
}
?>