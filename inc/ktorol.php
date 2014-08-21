<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and ($_GET[id])){

$modi=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
$leker=mysql_query("SELECT * FROM komment INNER JOIN blog ON komment.komment_blog = blog.blog_id WHERE komment_id = '". $_GET[id] ."'");
if(mysql_num_rows($leker)>0){
while($blog=mysql_fetch_object($leker)){
if($blog->blog_kutya==$_SESSION[id] or (mysql_num_rows($modi)>0)){
mysql_query("DELETE FROM komment WHERE komment_id = '". $_GET[id] ."'");
header("Location: ../blog.php?blog=". $blog->blog_id ."#kommentek");
}else{
header("Location: ../index.php");
}
}
}else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
