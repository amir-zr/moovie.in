<?php
header('Content-Type: text/html; charset=utf-8');
$message = file_get_contents("php://input");
$arrayMessage = json_decode($message, true);

$token = "471929891:AAHEV_fyfyo7cmxDHNRtWynYOITnldr6_-M";
$chat_id = $arrayMessage['message']['from']['id'];
$user_id = $arrayMessage['message']['from']['username'];
$user_fname = $arrayMessage['message']['from']['first_name'];
$command = $arrayMessage['message']['text'];

$html="<b>Amir</b> <i>Ziari</i>\n<a href='htps://moovie.in'>Visit Moovie.in Website</a>";
$text2_encode = urlencode($html);
if ($command == "/chat_id") {
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $chat_id;
    file_get_contents($url);
} else if ($command == "/test") {
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $text2_encode ."&parse_mode=html";
    file_get_contents($url);
}
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

$msg = $arrayMessage['message']['document']['file_id'];
$url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $msg;
file_get_contents($url);

/*$url = "https://api.telegram.org/bot" . $token . "/sendDocument?chat_id=" . $chat_id . "&document=BQADBAADggEAAu_38FBUedLb8CM25AI";
file_get_contents($url);*/