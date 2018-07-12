<?php
header('Content-Type: text/html; charset=utf-8');
include("connect.php");
session_start();

$token = "471929891:AAHEV_fyfyo7cmxDHNRtWynYOITnldr6_-M";
$ref = parse_url($_SERVER['HTTP_REFERER']);
if ($ref["host"] == "moovie.in") {
    if (isset($_GET["movie"]) && $_GET["movie"] != "" && isset($_GET["admin"]) && $_GET["admin"] != "" && isset($_GET["channel"]) && $_GET["channel"] != "") {

        function formatSizeUnits($bytes)
        {
            if ($bytes >= 1073741824) {
                $bytes = number_format($bytes / 1073741824, 1) . ' Gb';
            } elseif ($bytes >= 1048576) {
                $bytes = number_format($bytes / 1048576, 0) . ' Mb';
            } elseif ($bytes >= 1024) {
                $bytes = number_format($bytes / 1024, 0) . ' Kb';
            } elseif ($bytes > 1) {
                $bytes = $bytes . ' bytes';
            } elseif ($bytes == 1) {
                $bytes = $bytes . ' byte';
            } else {
                $bytes = '0 bytes';
            }

            return $bytes;
        }

        function remote_file_size($url)
        {
            # Get all header information
            $data = get_headers($url, true);
            # Look up validity
            if (isset($data['Content-Length']))
                # Return file size
                return (int)$data['Content-Length'];
        }

        ;


        $con1 = $GLOBALS["connect"];
        $get_admin_sql = "SELECT * FROM `admin` WHERE `name`='" . $_GET["admin"] . "'";
        $get_admin_res = $con1->prepare($get_admin_sql);
        $get_admin_res->execute();
        $row_admin = $get_admin_res->fetch(PDO::FETCH_ASSOC);
        $chat_id = $row_admin["chat-id"];

        $con2 = $GLOBALS["connect"];
        $get_movie_sql = "SELECT * FROM `movies` WHERE `id`='" . $_GET["movie"] . "'";
        $get_movie_res = $con2->prepare($get_movie_sql);
        $get_movie_res->execute();
        $row_movie = $get_movie_res->fetch(PDO::FETCH_ASSOC);
        print_r($get_movie_res->errorInfo());
        print_r($row_movie);

        //Post1
        $movie_caption = "🎬 #پخش_آنلاین فیلم " . $row_movie["fa-name"] . "\n" . $row_movie["en-name"] . "\n\n😍 #آنلاین_ببینید و لذت ببرید....😍\n\n🆔 @" . $_GET["channel"] . "";
        $movie_caption_encode = urlencode($movie_caption);
        $movie_cover = "https://moovie.in/files/cover/" . $row_movie["id"] . ".jpg";
        $url = "https://api.telegram.org/bot" . $token . "/sendPhoto?chat_id=" . $chat_id . "&caption=" . $movie_caption_encode . "&photo=" . $movie_cover;
        file_get_contents($url);

        //Post2
        $text_post2 = $row_movie["description"] . "\n\n" . "🎬 پیش نمایش آنلاین فیلم👇" . "\n" . "🎈برای مشاهده پیش نمایش فیلم روی تصویر زیر و یا لینک زیر کلیک کنید👇" . "\n\n" . "🔸 https://moovie.in/trailer/?id=" . $row_movie["id"] . "&c=" . $_GET["channel"] . " 🔸\n\n🆔 @" . $_GET["channel"];
        $text2_encode = urlencode($text_post2);
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $text2_encode;
        file_get_contents($url);


        //Post3

        //get movie size

        $links_array = json_decode($row_movie["links"], true);
        //$links_length= count($links_array);

        $text_file_size = "برای #دانلود از لینک های زیر استفاده کنید👇"."\n\n";
        foreach ($links_array as $value) {

            $size = formatSizeUnits(remote_file_size($value["link"]));
            $text_file_size .= "💽 " . $value["quality"] . " : " . $size . "\n" . "📥 " . $value["quality"] . " : moovie.in/?f=" . $row_movie["id"] . "&l=" . $value["level"] . "\n";

        }


        if(file_exists($_SERVER["DOCUMENT_ROOT"]."/files/subtitle/".$row_movie["id"].".vtt")){
            $text_file_size .= "📥 Subtitle : moovie.in/?sub=".$row_movie["id"];
        }

        $text_file_size .= "\n\n";

        $text_post3 = "🎬 #پخش_آنلاین فیلم " . $row_movie["fa-name"] . "\n" . "🎈جهت تماشای فیلم به صورت آنلاین و با کیفیت های مختلف ، روی تصویر و یا لینک زیر کلیک کنید👇" . "\n\n" .
            "🔸 https://moovie.in/movie/" . $row_movie["folder"] . "/?c=" . $_GET["channel"]." 🔸" . "\n\n" . $text_file_size . "🆔 @" . $_GET["channel"];

        /*  ;*/
        $text3_encode = urlencode($text_post3);
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $text3_encode;
        file_get_contents($url);


        //Post4
        foreach ($links_array as $value){

            if($value["fileId"]>="" and strlen($value["fileId"])>=5){
                $caption=$row_movie["en-name"]."\n".$value["quality"]."\n".$value["desc"]."\n\n"."🆔 @" . $_GET["channel"];
                $caption_encode=urlencode($caption);
                $url = "https://api.telegram.org/bot" . $token . "/sendDocument?chat_id=" . $chat_id . "&document=".$value["fileId"]."&caption=".$caption_encode;
                file_get_contents($url);
            }

        }






        echo "1";

    }
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

/*$msg = $arrayMessage['message']['document']['file_id'];
$url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $msg;
file_get_contents($url);*/

/*$url = "https://api.telegram.org/bot" . $token . "/sendDocument?chat_id=" . $chat_id . "&document=BQADBAADggEAAu_38FBUedLb8CM25AI";
file_get_contents($url);*/


?>