<?php
header('Content-Type: text/html; charset=utf-8');
$message = file_get_contents("php://input");
$arrayMessage = json_decode($message, true);

$token = "300589563:AAFVEG3Ks2kW53jbFpTFHDaMJYGB6bPP_8o";
$chat_id = $arrayMessage['message']['from']['id'];
$user_id = $arrayMessage['message']['from']['username'];
$user_fname = $arrayMessage['message']['from']['first_name'];
$command = $arrayMessage['message']['text'];

/*include "connect.php";
include "category.php";
$con = $GLOBALS["connect"];
$user_exist_res = $con->prepare("SELECT * FROM `users` WHERE `chat_id`=$chat_id");
$user_exist_res->execute();
$user_exist = $user_exist_res->rowCount();
if ($user_exist == "0") {
    $con2 = $GLOBALS["connect"];
    $user_add = $con2->prepare("INSERT INTO `users`(`id`, `name`, `chat_id`, `state`) VALUES (NULL,'$user_fname','$chat_id','')");
    $user_add->execute();
}*/

$msg=json_encode($arrayMessage['message']);
$url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $msg;
file_get_contents($url);
/*
$url = "https://api.telegram.org/bot" . $token . "/sendVideo?chat_id=" . $chat_id . "&video=BAADBAADDwIAAvb6kVBg2p2mMY0LwgI";
file_get_contents($url);*/