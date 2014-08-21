<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_POST['ossz'])){
for($i=1; $i<=$_POST['ossz']; $i++)
{
if(isset($_POST[$i])){
mysql_query("UPDATE uzenetek SET uzenet_torol_kapo = '1', uzenet_olvas = '1' WHERE uzenet_id = '". $_POST[$i] ."' and uzenet_kapo = '". $_SESSION[id] ."'");
}
    }
    header("Location: ../uzenetek.php");
}
elseif(isset($_GET['id']))
{
mysql_query("UPDATE uzenetek SET uzenet_torol_kapo = '1', uzenet_olvas = '1' WHERE uzenet_kuldo = '". $_GET[id] ."' and uzenet_kapo = '". $_SESSION[id] ."'");
mysql_query("UPDATE uzenetek SET uzenet_torol_kuldo = '1' WHERE uzenet_kuldo = '". $_SESSION[id] ."' and uzenet_kapo = '". $_GET[id] ."'");

}
else
{
echo("hiba");
}
?>
