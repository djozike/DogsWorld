<?
include("../inc/sql.php");
include("../inc/oop.php");
echo("[");
$sql=mysql_query("SELECT kutya_fajta, count(kutya_fajta) as db FROM kutya GROUP BY kutya_fajta ORDER BY db DESC limit 10");
$i=0;
while($er=mysql_fetch_object($sql)){
echo("{\"fajta\":\"". kutyaszamtonev($er->kutya_fajta) ."\", \"db\":". $er->db ."}");
$i++;
if($i<10)
{
echo", ";
}
}

echo("]");
?>