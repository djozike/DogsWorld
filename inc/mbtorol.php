<?php
include("session.php");
include("sql.php");
include("oop.php");
if(isset($_SESSION[id]) and ($_GET[id])){
$kuty=new kutya();
$kuty->getKutyaByID($_SESSION[id]);
if($kuty->rang>0){
$leker=mysql_query("SELECT * FROM blog WHERE blog_id = '". $_GET[id] ."'");
if(mysql_num_rows($leker)>0){
while($kutyi=mysql_fetch_object($leker)){
$leiras="Szia!<br>Sajnos a ". addslashes($kuty->NevMegjelenitLinkelve()) ." nev� moder�tor t�r�lte az egyik blogbejegyz�sed, val�sz�n�leg valami szab�lyellenes tartalom szerepelt benne. Ha r�szleteket szeretn�l tudni a t�rl�s ok�r�l, �rj a moder�tornak.";
$sql="INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $kutyi->blog_kutya ."', NOW(), 0, 0, 0, 0)";
mysql_query($sql);
}
mysql_query("DELETE FROM blog WHERE blog_id = '". $_GET[id] ."'");
mysql_query("DELETE FROM komment WHERE komment_blog = '". $_GET[id] ."'");
header("Location: ../blog.php");
}
}
}else{
header("Location: ../index.php");
}
?>
