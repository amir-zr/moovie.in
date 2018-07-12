<?php
header('Content-Type: text/html; charset=utf-8');
$message = file_get_contents("php://input");
$arrayMessage = json_decode($message, true);

$token = "300589563:AAFVEG3Ks2kW53jbFpTFHDaMJYGB6bPP_8o";
$chat_id = $arrayMessage['message']['from']['id'];
$user_id = $arrayMessage['message']['from']['username'];
$user_fname = $arrayMessage['message']['from']['first_name'];
$command = $arrayMessage['message']['text'];

include "connect.php";
include "category.php";
$con = $GLOBALS["connect"];
$user_exist_res = $con->prepare("SELECT * FROM `users` WHERE `chat_id`=$chat_id");
$user_exist_res->execute();
$user_exist = $user_exist_res->rowCount();
if ($user_exist == "0") {
    $con2 = $GLOBALS["connect"];
    $user_add = $con2->prepare("INSERT INTO `users`(`id`, `name`, `chat_id`, `state`) VALUES (NULL,'$user_fname','$chat_id','')");
    $user_add->execute();
}

$keyboards = array(
    'start' => array(
        array('جستجو 🔍', 'سریال 🎞', 'فیلم 🎬'),
        array('تبلیغات 🎯', 'کانال ما 📽','آموزش 📄'),
    ),
    'movie' => array(
        array('بازگشت ⬅️', 'صفحه اصلی 🏠'),
        array('مجبوب ترین ها 💛', 'جدیدترین ها 🆕'),
        array('خارجی 🇺🇸', 'ایرانی 🇮🇷')
    ),
);


if ($command == '/start') {
    $poets = array(
        'keyboard' => $keyboards["start"],
        'resize_keyboard' => TRUE,
        'one_time_keyboard' => TRUE,
    );

    $jsonPoets = json_encode($poets);
    $text = "دنبال چی میگردی؟👇";
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $text . "&reply_markup=" . $jsonPoets;
    file_get_contents($url);
} else if ($command == "فیلم 🎬") {
    //$hide_keyboard= json_encode(array('hide_keyboard' => true));
    $poets = array(
        'keyboard' => $keyboards["movie"],
        'resize_keyboard' => TRUE,
        'one_time_keyboard' => TRUE,
    );

    $jsonPoets = json_encode($poets);
    $text = ":فیلم 🎬";
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $text . "&reply_markup=" . $jsonPoets;
    file_get_contents($url);
} elseif ($command == "جدیدترین ها 🆕") {

    $poets = array(
        'keyboard' => array(),
        'resize_keyboard' => TRUE,
        'one_time_keyboard' => TRUE,
    );

    $con3 = $GLOBALS["connect"];
    $new_movies_res = $con3->prepare("SELECT * FROM `movies` ORDER BY id DESC LIMIT 10");
    $new_movies_res->execute();

    while ($new_movies = $new_movies_res->fetch(PDO::FETCH_ASSOC)) {
        $poets["keyboard"][] = array($new_movies["name"]);
    }

    $jsonPoets = json_encode($poets);

    $text = "جدیدترین ها ?";
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $text . "&reply_markup=" . $jsonPoets;
    file_get_contents($url);

    /*$url= "https://api.telegram.org/bot".$token."/sendVideo?chat_id=".$chat_id;
    $post = array(
        'video'     => new CURLFile(realpath("4k.mp4"))
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec($ch);*/
} elseif ($command == "/check") {
    $url = "https://api.telegram.org/bot" . $token . "/getChatMember?chat_id=@movie_serie&user_id=" . $chat_id;
    $a = file_get_contents($url);


    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $a . "&reply_markup=" . $hide_keyboard;
    file_get_contents($url);
}
elseif ($command == "/movie") {

    $url = "https://api.telegram.org/bot" . $token . "/sendVideo?chat_id=" . $chat_id . "&video=BAADBAADDwIAAvb6kVBg2p2mMY0LwgI";
    file_get_contents($url);
}elseif ($command == "آموزش 📄") {

    $text="برای آموزش نحوه دانلود و ذخیره کردن فیلم در اندروید و ios به کانال @amo_zeshi مراجعه کنید";
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=".$text;
    file_get_contents($url);
} else {
    /*$con3 = $GLOBALS["connect"];
    $find_movie_res = $con3->prepare("SELECT * FROM `movies` WHERE `name`='" . $command . "'");
    $find_movie_res->execute();
    if ($find_movie = $find_movie_res->fetch(PDO::FETCH_ASSOC)) {

        $file_arr = json_decode($find_movie["files"], TRUE);

        $poets = array(
            'keyboard' => array(
                array('بازگشت ⬅️', 'صفحه اصلی 🏠'),
                ),
            'resize_keyboard' => TRUE,
            'one_time_keyboard' => TRUE,
        );

        if (isset($file_arr["teaser"])) {
            $poets["keyboard"][] = array("تیزر فیلم  🎞");
        }

        if (isset($file_arr["1080"])) {
            $poets["keyboard"][] = array("1080P 📥");
        }

        if (isset($file_arr["720"])) {
            $poets["keyboard"][] = array("720P 📥");
        }

        if (isset($file_arr["480"])) {
            $poets["keyboard"][] = array("480P 📥");
        }

        $jsonPoets = json_encode($poets);


        $url = "https://api.telegram.org/bot" . $token . "/sendPhoto?chat_id=" . $chat_id . "&photo=" . $find_movie["cover"] . "&caption=" . $find_movie["name"] . "&reply_markup=" . $jsonPoets;
        file_get_contents($url);


    }*/

    $updates = $telegram->getWebhookUpdates();

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=".$aaa;
    file_get_contents($url);

}
