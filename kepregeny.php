<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
if($_SESSION[id]){
$adat="<center><big><u>Baltó Gimnázium</u></big><br><br>
Részek:<br>
<a href=#elso class='feherlink'>Az iskola kezdés</a><br>
<a href=#masodik class='feherlink'>Ilyen nincs!!</a> <br>
<a href=#harmadik class='feherlink'>A pletyka</a> <br>
<a href=#negyedik class='feherlink'>Az Informátor</a> <br>
<a href=#otodik class='feherlink'>A csel</a> <br>
<a href=#hatodik class='feherlink'>Soha többé</a> <br>
<a href=#hetedik class='feherlink'>Sorsfordulok</a> <br>
<a href=#nyolcadik class='feherlink'>Szerelmi életek</a> <br>
<a href=#kilencedik class='feherlink'>A verseny</a> <br>
<a href=#tizedik class='feherlink'>Fiúk: se velük, se nélkülük</a> <br>
<a href=#tizenegyedik class='feherlink'>Meglepetések</a> <br>
<a href=#tizenkettedik class='feherlink'>A titkoshódoló</a> <br>
<br><br>
<big><big><big><a id=elso>Az iskola kezdés</a></big></big></big><br><img src=http://www.kepfeltoltes.hu/121009/www.tvn.hu_c91be24998882703f17cbb5688080a3f_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=masodik>Ilyen nincs!!</a></big></big></big><br><img src=http://kepfeltoltes.hu/121010/www.tvn.hu_c91be24998882703f17cbb5688080a3f_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=harmadik>A pletyka</a></big></big></big><br><img src=http://kepfeltoltes.hu/121011/www.tvn.hu_c91be24998882703f17cbb5688080a3f_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=negyedik>Az Informátor</a></big></big></big><br><img src=http://kepfeltoltes.hu/121012/www.tvn.hu_c91be24998882703f17cbb5688080a3f_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=otodik>A csel</a></big></big></big><br><img src=http://kepfeltoltes.hu/121013/126_www.kepfeltoltes.hu_.jpg><br><br>
<big><big><big><a id=hatodik>Soha többé</a></big></big></big><br><img src=http://kepfeltoltes.hu/121015/49d5b5b84ed5c196fdbc44ec85d7d11b-d32rt4z_www.kepfeltoltes.hu_.jpg><br><br>
<big><big><big><a id=hetedik>Sorsfordulok</a></big></big></big><br><img src=http://kepfeltoltes.hu/121016/126_www.kepfeltoltes.hu_.jpg><br><br>
<big><big><big><a id=nyolcadik>Szerelmi életek</a></big></big></big><br><img src=http://kepfeltoltes.hu/121016/www.tvn.hu_c91be24998882703f17cbb5688080a3f_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=kilencedik>A verseny</a></big></big></big><br><img src=http://kepfeltoltes.hu/121017/kutya_2_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=tizedik>Fiúk: se velük, se nélkülük</a></big></big></big><br><img src=http://kepfeltoltes.hu/121018/NemetJuhaszkutya5_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=tizenegyedik>Meglepetések</a></big></big></big><br><img src=http://kepfeltoltes.hu/121019/736991094kutya_2_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=tizenkettedik>A titkoshódoló</a></big></big></big><br><img src=http://kepfeltoltes.hu/121020/49d5b5b84ed5c196fdbc44ec85d7d11b-d32rt4z_www.kepfeltoltes.hu_.jpg><br><br>



</center>";

oldal($adat);
}else{header("Location: index.php");}
?>