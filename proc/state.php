<?php

include 'connect.php';
$myFile = "../state.txt";
$fh = fopen($myFile, 'a') or die("can't open file");

$con1 = $GLOBALS["connect"];
$get_view_sql = "SELECT * FROM `channels` WHERE 1";
$get_view_res = $con1->prepare($get_view_sql);
$get_view_res->execute();
$row_view = $get_view_res->fetch(PDO::FETCH_ASSOC);

$stringData = date("Y/m/d")." => ".$row_view["view"]."\n";
fwrite($fh, $stringData);

?>