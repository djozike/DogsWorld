<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
if($_SESSION[id]){
$adat="<center><big><u>Balt� Gimn�zium</u></big><br><br>
R�szek:<br>
<a href=#elso class='feherlink'>Az iskola kezd�s</a><br>
<a href=#masodik class='feherlink'>Ilyen nincs!!</a> <br>
<a href=#harmadik class='feherlink'>A pletyka</a> <br>
<a href=#negyedik class='feherlink'>Az Inform�tor</a> <br>
<a href=#otodik class='feherlink'>A csel</a> <br>
<a href=#hatodik class='feherlink'>Soha t�bb�</a> <br>
<a href=#hetedik class='feherlink'>Sorsfordulok</a> <br>
<a href=#nyolcadik class='feherlink'>Szerelmi �letek</a> <br>
<a href=#kilencedik class='feherlink'>A verseny</a> <br>
<a href=#tizedik class='feherlink'>Fi�k: se vel�k, se n�lk�l�k</a> <br>
<a href=#tizenegyedik class='feherlink'>Meglepet�sek</a> <br>
<a href=#tizenkettedik class='feherlink'>A titkosh�dol�</a> <br>
<br><br>
<big><big><big><a id=elso>Az iskola kezd�s</a></big></big></big><br><img src=http://www.kepfeltoltes.hu/121009/www.tvn.hu_c91be24998882703f17cbb5688080a3f_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=masodik>Ilyen nincs!!</a></big></big></big><br><img src=http://kepfeltoltes.hu/121010/www.tvn.hu_c91be24998882703f17cbb5688080a3f_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=harmadik>A pletyka</a></big></big></big><br><img src=http://kepfeltoltes.hu/121011/www.tvn.hu_c91be24998882703f17cbb5688080a3f_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=negyedik>Az Inform�tor</a></big></big></big><br><img src=http://kepfeltoltes.hu/121012/www.tvn.hu_c91be24998882703f17cbb5688080a3f_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=otodik>A csel</a></big></big></big><br><img src=http://kepfeltoltes.hu/121013/126_www.kepfeltoltes.hu_.jpg><br><br>
<big><big><big><a id=hatodik>Soha t�bb�</a></big></big></big><br><img src=http://kepfeltoltes.hu/121015/49d5b5b84ed5c196fdbc44ec85d7d11b-d32rt4z_www.kepfeltoltes.hu_.jpg><br><br>
<big><big><big><a id=hetedik>Sorsfordulok</a></big></big></big><br><img src=http://kepfeltoltes.hu/121016/126_www.kepfeltoltes.hu_.jpg><br><br>
<big><big><big><a id=nyolcadik>Szerelmi �letek</a></big></big></big><br><img src=http://kepfeltoltes.hu/121016/www.tvn.hu_c91be24998882703f17cbb5688080a3f_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=kilencedik>A verseny</a></big></big></big><br><img src=http://kepfeltoltes.hu/121017/kutya_2_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=tizedik>Fi�k: se vel�k, se n�lk�l�k</a></big></big></big><br><img src=http://kepfeltoltes.hu/121018/NemetJuhaszkutya5_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=tizenegyedik>Meglepet�sek</a></big></big></big><br><img src=http://kepfeltoltes.hu/121019/736991094kutya_2_www.kepfeltoltes.hu_.png><br><br>
<big><big><big><a id=tizenkettedik>A titkosh�dol�</a></big></big></big><br><img src=http://kepfeltoltes.hu/121020/49d5b5b84ed5c196fdbc44ec85d7d11b-d32rt4z_www.kepfeltoltes.hu_.jpg><br><br>



</center>";

oldal($adat);
}else{header("Location: index.php");}
?>