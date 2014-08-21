<?php
include("session.php");
include("sql.php");
include("oop.php");
if(isset($_SESSION[id]) and ($_GET[egyszam])){
$kuty=new kutya();
if($kuty->GetKutyaByID($_SESSION[id]))
{
if($kuty->egyszamproba==-1)
{
header("Location: ../index.php");
}
else{
echo $kuty->EgyszamMegjelenit($kuty->EgyszamTipp($_GET[egyszam]));
}
}
else
{
header("Location: ../index.php");
}
}else{header("Location: ../index.php");}
?>
