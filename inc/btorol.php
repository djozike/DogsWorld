<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and ($_GET[id])){
$leker=mysql_query("SELECT * FROM blog WHERE blog_id = '". $_GET[id] ."' and blog_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($leker)>0){
mysql_query("DELETE FROM blog WHERE blog_id = '". $_GET[id] ."'");
mysql_query("DELETE FROM komment WHERE komment_blog = '". $_GET[id] ."'");
header("Location: ../blog.php?id=". $_SESSION[id]);
}
}else{
header("Location: ../index.php");
}
?>
