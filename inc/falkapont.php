<?php
$falkas=mysql_query("SELECT * FROM `falka`",$kapcsolat);
while($leker=mysql_fetch_object($falkas)){
falkapont($leker->falka_id);
}
?>
