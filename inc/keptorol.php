<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
unlink("../pic/user/". $_SESSION[id] .".png");
unlink("../pic/user/". $_SESSION[id] .".gif");
header("Location: ../beallitas.php");
}else{header("Location: ../index.php");}
?>
