<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
mysql_query("UPDATE falka SET falka_vezetohelyettes = 0 WHERE falka_vezetohelyettes = '". $_SESSION[id] ."'");
header("Location: ../falka.php");
}else{
header("Location: ../index.php");
}
?>
