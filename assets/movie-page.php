<?php
/**
 * Created by PhpStorm.
 * User: Amir ZR
 * Date: 4/11/2018
 * Time: 5:10 PM
 */

include($_SERVER["DOCUMENT_ROOT"] . "/proc/connect.php");
/*$this_movie*/

$today = date("y-m-d");
$have_admin_panel_modal = "0";

/*if (!isset($_COOKIE["admin-panel-modal-" . $today])) {
    $have_admin_panel_modal = "1";
    setcookie("admin-panel-modal-" . $today, "1", time() + 432000, "/");
}*/


$con1 = $GLOBALS["connect"];
$get_movie_sql = "SELECT * FROM movies WHERE id=" . $this_movie;
$get_movie_res = $con1->prepare($get_movie_sql);
$get_movie_res->execute();
$row_movie = array();
$row_movie = $get_movie_res->fetch(PDO::FETCH_ASSOC);

$links_array = json_decode($row_movie["links"], true);
$links_length= count($links_array);


$view_detail=$_GET["c"]."-m-".$this_movie."-".$_SERVER["REMOTE_ADDR"];
$con1 = $GLOBALS["connect"];
$get_view_sql = "SELECT * FROM `channels` WHERE 1";
$get_view_res = $con1->prepare($get_view_sql);
$get_view_res->execute();
$row_view = $get_view_res->fetch(PDO::FETCH_ASSOC);
$view_detail_array=explode(",",$row_view["view-detail"]);
if(!in_array($view_detail,$view_detail_array)){
    $new_view_detail=$row_view["view-detail"].$view_detail.",";
    $new_view=intval($row_view["view"])+1;

    $con3 = $GLOBALS["connect"];
    $set_view_sql = "UPDATE `channels` SET `view-detail`='".$new_view_detail."',`view`='".$new_view."' WHERE 1";
    $set_view_res = $con3->prepare($set_view_sql);
    $set_view_res->execute();

}


?>


<html>
<head>
    <meta charset="UTF-8">
    <title>تماشای آنلاین فیلم <?php echo $row_movie["fa-name"] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://moovie.in/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://moovie.in/assets/css/video-js.css">
    <link rel="stylesheet" href="https://moovie.in/assets/css/videojs-resolution-switcher.css">
    <link rel="stylesheet" href="https://moovie.in/assets/css/videojs.watermark.css">
    <link rel="shortcut icon" type="image/png" href="https://moovie.in/assets/img/favicon.png"/>
    <link rel="stylesheet" href="https://moovie.in/assets/css/videojs.vast.vpaid.css">

    <meta property="og:url" content="https://moovie.in/movie/<?php echo $row_movie["folder"] ?>"/>
    <meta property="og:title" content="تماشای آنلاین فیلم <?php echo $row_movie["fa-name"] ?>"/>
    <meta property="og:site_name" content="مووی : تماشای آنلاین فیلم و سریال"/>
    <meta property="og:video" content="<?php echo $links_array[$links_length-1]["link"]?>">
    <meta property="og:video:url" content="<?php echo $links_array[$links_length-1]["link"]?>">
    <meta property="og:video:secure_url" content="<?php echo $links_array[$links_length-1]["link"]?>">
    <meta property="og:video:type" content="video/mp4">
    <meta property="og:video:width" content="640">
    <meta property="og:video:height" content="360">
    <meta property="og:image" content="https://moovie.in/assets/img/movie-poster.jpg"/>
    <meta name="twitter:card" content="player"/>
    <meta name="twitter:site" content="@moovie_in"/>
    <meta name="twitter:title" content="تماشای آنلاین فیلم <?php echo $row_movie["fa-name"] ?>"/>
    <meta name="twitter:description" content=""/>
    <meta name="twitter:image" content="https://moovie.in/assets/img/movie-poster.jpg"/>
    <meta name="twitter:image:width" content="640"/>
    <meta name="twitter:image:height" content="360"/>
    <meta name="twitter:player" content="https://moovie.in/assets/player.php?id=<?php echo $this_movie ?>&c=<?php echo $_GET["c"] ?>"/>
    <meta name="twitter:player:width" content="640"/>
    <meta name="twitter:player:height" content="360"/>


    <style>

        @font-face {
            font-family: "teshrin-light";
            src: url("https://moovie.in/assets/font/TeshrinARLT-Light.ttf");
        }

        @font-face {
            font-family: "teshrin-regular";
            src: url("https://moovie.in/assets/font/TeshrinARLT-Regular.ttf");
        }

        @font-face {
            font-family: "teshrin-medium";
            src: url("https://moovie.in/assets/font/TeshrinARLT-Medium.ttf");
        }

        @font-face {
            font-family: "teshrin-bold";
            src: url("https://moovie.in/assets/font/TeshrinARLT-Bold.ttf");
        }

        * {
            font-family: 'teshrin-regular';
        }
        ::placeholder {
            color: #fff;
        }
        #site-title {
            background-color: #f8f9fa;
            text-align: center;
            height: 58px;
        }

        #moovie-logo {
            background-image: url("https://moovie.in/assets/img/televisions.svg");
            background-size: cover;
            display: inline-block;
            width: 38px;
            height: 38px;
            background-repeat: no-repeat;
            margin-top: 8px;
            vertical-align: middle;
        }

        #moovie-title {

            display: inline-block;
            margin-left: 6px;
            font-family: 'teshrin-medium';
            font-size: 20px;
            font-weight: 600;
            vertical-align: bottom;
            line-height: 27px;
            text-align: right;
            direction: rtl;

        }

        #main-wrapper {
            text-align: center;
        }

        #search-area {
            background-color: #FF533D;
        }

        #search-box {
            border-radius: 50px;
            padding: 5px 12px;
            width: 300px;
            position: relative;
            margin: auto;
            padding: 10px;
        }

        #search-box input {
            background-color: rgba(0, 0, 0, 0);
            border: none;
            width: 100%;
            text-align: right;
            direction: rtl;
            color: #fff;
        }

        #search-box button {

            background-image: url("https://moovie.in/assets/img/white-search.svg");
            content: "";
            display: block;
            width: 20px;
            height: 20px;
            background-size: cover;
            background-repeat: no-repeat;
            position: absolute;
            background-color: rgba(0, 0, 0, 0);
            border: none;
            top: 50%;
            margin-top: -10px;
            left: 11px;
            cursor: pointer;
        }

        #movie-page-wrapper {
            padding: 20px;
        }

        #video {
            display: block;
            width: 640px;
            height: 330px;
            margin: 0 auto 20px;
        }

        #movie-details {
            width: 640px;
            display: inline-block;
        }

        #movie-name {

            text-align: right;
            font-family: 'teshrin-medium';
            color: #222f3e;
            font-size: 20px;

        }

        #movie-desc {
            text-align: right;
            line-height: 30px;
            direction: rtl;
            text-align: right;
        }

        #dl-box a {
            width: 100px;
            display: inline-block;
            background-color: #000;
            text-decoration: none;
            color: #fff;
            background-color: #FF533D;
            border-radius: 4px;
            padding: 10px 0;
            margin: 10px;
        }

        #building {
            background-color: #feca57;
            margin: 0;
            padding: 12px;
            color: #1e1e1e;
            text-align: center;
            direction: rtl;
        }

        @media (min-width: 0px) and (max-width: 680px) {
            #video {
                display: block;
                width: 100%;
                height: 200px;
                margin: 0 auto 20px;
            }

            #movie-details {
                width: 100%;
            }

        }

        ::cue {
            font-size: 1.5em !important;
            font-family: 'teshrin-medium';
            line-height: 1.7em;
            direction: rtl;
            /* padding: 20px !important; */
            /* border-radius: 12px !important; */
            text-align: center;
            background-color: rgba(0,0,0,0.8);
        }

        @media (min-width: 800px) {
            ::cue {
                font-size: 0.8em !important;
                line-height: 1.4em;
            }
        }



    </style>


    <style>



        .video-js .vjs-menu-button-inline.vjs-slider-active,.video-js .vjs-menu-button-inline:focus,.video-js .vjs-menu-button-inline:hover,.video-js.vjs-no-flex .vjs-menu-button-inline {
            width: 10em
        }

        .video-js .vjs-controls-disabled .vjs-big-play-button {
            display: none!important
        }

        .video-js .vjs-control {
            width: 3em
        }

        .video-js .vjs-menu-button-inline:before {
            width: 1.5em
        }

        .vjs-menu-button-inline .vjs-menu {
            left: 3em
        }

        .vjs-paused.vjs-has-started.video-js .vjs-big-play-button,.video-js.vjs-ended .vjs-big-play-button,.video-js.vjs-paused .vjs-big-play-button {
            display: block
        }

        .video-js .vjs-load-progress div,.vjs-seeking .vjs-big-play-button,.vjs-waiting .vjs-big-play-button {
            display: none!important
        }

        .video-js .vjs-mouse-display:after,.video-js .vjs-play-progress:after {
            padding: 0 .4em .3em
        }

        .video-js.vjs-ended .vjs-loading-spinner {
            display: none;
        }

        .video-js.vjs-ended .vjs-big-play-button {
            display: block !important;
        }

        .video-js *,.video-js:after,.video-js:before {
            box-sizing: inherit;
            font-size: inherit;
            color: inherit;
            line-height: inherit
        }

        .video-js.vjs-fullscreen,.video-js.vjs-fullscreen .vjs-tech {
            width: 100%!important;
            height: 100%!important
        }

        .video-js {
            font-size: 14px;
            overflow: hidden
        }

        .video-js .vjs-control {
            color: inherit
        }

        .video-js .vjs-menu-button-inline:hover,.video-js.vjs-no-flex .vjs-menu-button-inline {
            width: 8.35em
        }

        .video-js .vjs-volume-menu-button.vjs-volume-menu-button-horizontal:hover .vjs-menu .vjs-menu-content {
            height: 3em;
            width: 6.35em
        }

        .video-js .vjs-control:focus:before,.video-js .vjs-control:hover:before {
            text-shadow: 0 0 1em #fff,0 0 1em #fff,0 0 1em #fff
        }

        .video-js .vjs-spacer,.video-js .vjs-time-control {
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-flex: 1 1 auto;
            -moz-box-flex: 1 1 auto;
            -webkit-flex: 1 1 auto;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }

        .video-js .vjs-time-control {
            -webkit-box-flex: 0 1 auto;
            -moz-box-flex: 0 1 auto;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            width: auto
        }

        .video-js .vjs-time-control.vjs-time-divider {
            width: 14px
        }

        .video-js .vjs-time-control.vjs-time-divider div {
            width: 100%;
            text-align: center
        }

        .video-js .vjs-time-control.vjs-current-time {
            margin-left: 1em
        }

        .video-js .vjs-time-control .vjs-current-time-display,.video-js .vjs-time-control .vjs-duration-display {
            width: 100%
        }

        .video-js .vjs-time-control .vjs-current-time-display {
            text-align: right
        }

        .video-js .vjs-time-control .vjs-duration-display {
            text-align: left
        }

        .video-js .vjs-play-progress:before,.video-js .vjs-progress-control .vjs-play-progress:before,.video-js .vjs-remaining-time,.video-js .vjs-volume-level:after,.video-js .vjs-volume-level:before,.video-js.vjs-live .vjs-time-control.vjs-current-time,.video-js.vjs-live .vjs-time-control.vjs-duration,.video-js.vjs-live .vjs-time-control.vjs-time-divider,.video-js.vjs-no-flex .vjs-time-control.vjs-remaining-time {
            display: none
        }

        .video-js.vjs-no-flex .vjs-time-control {
            display: table-cell;
            width: 4em
        }

        .video-js .vjs-progress-control {
            position: absolute;
            left: 0;
            right: 0;
            width: 100%;
            height: .5em;
            top: -.5em
        }

        .video-js .vjs-progress-control .vjs-load-progress,.video-js .vjs-progress-control .vjs-play-progress,.video-js .vjs-progress-control .vjs-progress-holder {
            height: 100%
        }

        .video-js .vjs-progress-control .vjs-progress-holder {
            margin: 0
        }

        .video-js .vjs-progress-control:hover {
            height: 1.5em;
            top: -1.5em
        }

        .video-js .vjs-control-bar {
            -webkit-transition: -webkit-transform .1s ease 0s;
            -moz-transition: -moz-transform .1s ease 0s;
            -ms-transition: -ms-transform .1s ease 0s;
            -o-transition: -o-transform .1s ease 0s;
            transition: transform .1s ease 0s
        }

        .video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-active .vjs-control-bar,.video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-inactive .vjs-control-bar,.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-active .vjs-control-bar,.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-inactive .vjs-control-bar,.video-js.vjs-has-started.vjs-playing.vjs-user-inactive .vjs-control-bar {
            visibility: visible;
            opacity: 1;
            -webkit-backface-visibility: hidden;
            -webkit-transform: translateY(3em);
            -moz-transform: translateY(3em);
            -ms-transform: translateY(3em);
            -o-transform: translateY(3em);
            transform: translateY(3em);
            -webkit-transition: -webkit-transform 1s ease 0s;
            -moz-transition: -moz-transform 1s ease 0s;
            -ms-transition: -ms-transform 1s ease 0s;
            -o-transition: -o-transform 1s ease 0s;
            transition: transform 1s ease 0s
        }

        .video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-active .vjs-progress-control,.video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-inactive .vjs-progress-control,.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-active .vjs-progress-control,.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-inactive .vjs-progress-control,.video-js.vjs-has-started.vjs-playing.vjs-user-inactive .vjs-progress-control {
            height: .25em;
            top: -.25em;
            pointer-events: none;
            -webkit-transition: height 1s,top 1s;
            -moz-transition: height 1s,top 1s;
            -ms-transition: height 1s,top 1s;
            -o-transition: height 1s,top 1s;
            transition: height 1s,top 1s
        }

        .video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-active.vjs-fullscreen .vjs-progress-control,.video-js.not-hover.vjs-has-started.vjs-paused.vjs-user-inactive.vjs-fullscreen .vjs-progress-control,.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-active.vjs-fullscreen .vjs-progress-control,.video-js.not-hover.vjs-has-started.vjs-playing.vjs-user-inactive.vjs-fullscreen .vjs-progress-control,.video-js.vjs-has-started.vjs-playing.vjs-user-inactive.vjs-fullscreen .vjs-progress-control {
            opacity: 0;
            -webkit-transition: opacity 1s ease 1s;
            -moz-transition: opacity 1s ease 1s;
            -ms-transition: opacity 1s ease 1s;
            -o-transition: opacity 1s ease 1s;
            transition: opacity 1s ease 1s
        }

        .video-js.vjs-live .vjs-live-control {
            margin-left: 1em
        }

        .video-js .vjs-big-play-button {
            top: 50%;
            left: 50%;
            margin-left: -1em;
            margin-top: -1em;
            width: 2em;
            height: 2em;
            line-height: 2em;
            border: none;
            border-radius: 50%;
            font-size: 3.5em;
            background-color: rgba(0,0,0,.45);
            color: #fff;
            -webkit-transition: border-color .4s,outline .4s,background-color .4s;
            -moz-transition: border-color .4s,outline .4s,background-color .4s;
            -ms-transition: border-color .4s,outline .4s,background-color .4s;
            -o-transition: border-color .4s,outline .4s,background-color .4s;
            transition: border-color .4s,outline .4s,background-color .4s
        }

        .video-js .vjs-menu-button-popup .vjs-menu {
            left: -3em
        }

        .video-js .vjs-menu-button-popup .vjs-menu .vjs-menu-content {
            background-color: transparent;
            width: 12em;
            left: -1.5em;
            padding-bottom: .5em
        }

        .video-js .vjs-menu-button-popup .vjs-menu .vjs-menu-item,.video-js .vjs-menu-button-popup .vjs-menu .vjs-menu-title {
            background-color: #151b17;
            margin: .3em 0;
            padding: .5em;
            border-radius: .3em
        }

        .video-js .vjs-menu-button-popup .vjs-menu .vjs-menu-item.vjs-selected {
            background-color: #2483d5
        }

        .video-js .vjs-big-play-button {
            background-color: rgba(0,0,0,0.5);
            font-size: 4.5em;
            border-radius: 50%;
            height: 2em !important;
            line-height: 2em !important;
            margin-top: -1em !important
        }

        .video-js:hover .vjs-big-play-button,.video-js .vjs-big-play-button:focus,.video-js .vjs-big-play-button:active {
            background-color: #ff533d
        }

        .video-js .vjs-loading-spinner {
            border-color: #ff533d
        }

        .video-js .vjs-control-bar2 {
            background-color: #000000
        }

        .video-js .vjs-control-bar {
            background-color: rgba(0,0,0,0.3) !important;
            color: #ffffff;
            font-size: 13px
        }

        .video-js .vjs-play-progress,.video-js  .vjs-volume-level {
            background-color: #FF533D
        }

        .video-js .vjs-load-progress {
            background: rgba(255,255,255,0.3);
        }

        .video-js .vjs-menu-button-popup .vjs-menu .vjs-menu-item.vjs-selected {
            background-color: #FF533D;
        }

        .video-js .vjs-control-bar {
            background-color: rgba(0,0,0,0.9) !important;
            color: #fff;
            font-size: 13px;
        }

        .vjs-custom-waiting .vjs-loading-spinner
        {
            display: block;
        }
        .video-js.vjs-custom-waiting .vjs-loading-spinner:before,
        .video-js.vjs-custom-waiting .vjs-loading-spinner:after
        {
            /* I just copied the same animation as in the default css file */
            -webkit-animation: vjs-spinner-spin 1.1s cubic-bezier(0.6, 0.2, 0, 0.8) infinite, vjs-spinner-fade 1.1s linear infinite;
            animation: vjs-spinner-spin 1.1s cubic-bezier(0.6, 0.2, 0, 0.8) infinite, vjs-spinner-fade 1.1s linear infinite;
        }

        /*Modal code*/
        #admin-panel-modal {
            direction: rtl;
        }

        .close {
            position: absolute;
            left: 12px;
            top: 20px;
        }

        #admin-panel-modal .modal-body p {

            width: 95%;
            margin: 0px auto 20px;
            line-height: 28px;

        }
        #admin-panel-modal .modal-body a {

            display: inline-block;
            background-color: #2e86de;
            padding: 8px 20px;
            border-radius: 5px;
            color: #fff;

        }

        #building a {

            display: block;
            background-color: #ff6b6b;
            width: 106px;
            color: #fff;
            border-radius: 5px;
            padding: 7px 0;
            margin: 13px auto 5px;

        }

    </style>



</head>
<body>


<div id="main-wrapper">
    <header>
        <div id="site-title">
            <span id="moovie-logo"></span>
            <span id="moovie-title">آنلاین ببینید...</span>
        </div>
        <div id="search-area">
            <div id="search-box">
                <input type="text" placeholder="فیلم مورد نظرتو جستجو کن">
                <button type="button"></button>
            </div>
        </div>
    </header>


    <div id="movie-page-wrapper">
        <video id="video" class="video-js vjs-default-skin" controls preload="auto" width="640" height="264" data-setup=''>
            <?php
            if(file_exists($_SERVER["DOCUMENT_ROOT"]."/files/subtitle/".$row_movie["id"].".vtt")){
                echo '<track kind="captions" src="https://moovie.in/files/subtitle/'.$row_movie["id"].'.vtt" srclang="en" label="Persian" default>';
            }
            ?>
            <p class="vjs-no-js">برای مشاهده این ویدیو باید جاوا اسکریپت مرورگر خود را فعال کنید.
                <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
        </video>
        <div id="movie-details">
            <p id="movie-name"><?php echo $row_movie["fa-name"] ?></p>

            <p id="movie-desc"><?php echo str_replace("\n","</br>",$row_movie["description"]) ?></p>

            <div id="dl-box">
                <p>دانلود با لینک مستقیم</p>

                <?php
                foreach ($links_array as $value){
                    echo '<a href="'.$value["link"].'">'.$value["quality"].'</a>';
                }

                echo '<a href="https://moovie.in/files/subtitle/'.$row_movie["id"].'.srt">زیرنویس فارسی</a>';


                ?>

            </div>
        </div>
    </div>

    <p id="building">
        سایت در دست ساخت می باشد ، تا کامل شدن سایت با ما همراه باشید...
        <a href="https://t.me/iLoveMyBro" target="_blank">تماس با ما</a>
    </p>
    <!-- Modal -->
    <div class="modal fade" id="admin-panel-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">نمایش آنلاین</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        ادمین های عزیز
                        </br>
                        برای دریافت پنل مدیریت و قابلیت نمایش آنلاین برای کانال تلگرامی خود ، با ما در تماس باشید.
                    </p>
                    <a href="https://t.me/moovie_in_support" target="_blank">تماس با ما</a>
                </div>
            </div>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://moovie.in/assets/js/videojs_5_13.js"></script>

<script src="https://moovie.in/assets/js/videojs-resolution-switcher.js"></script>
<script src="https://moovie.in/assets/js/videojs.watermark.js"></script>

<script src="https://moovie.in/assets/js/es5-shim.js"></script>
<script src="https://moovie.in/assets/js/ie8-fix.js"></script>
<script src="https://moovie.in/assets/js/videojs_5.vast.vpaid.js"></script>

<script type="text/javascript">
   videojs('video', {
       controls: true,
       textTrackSettings: true,
       preload: "auto",
       autoplay: false,
       poster:"https://moovie.in/assets/img/movie-poster.jpg",
       plugins: {
           vastClient: {
               "adTagUrl": "https://api.tapsell.ir/v2/pre-roll/5ac88420f697ee0001aab705/vast?secretKey=dgnjoeobbdlgiknhphqgeojshaighhtrehafrhkomoqaacsrthjniarmqdrlcllirshdlk",
               "adsCancelTimeout": 3000,
               "adsEnabled": true,
               "preferredTech":"html5"
           },
           videoJsResolutionSwitcher: {
               default: 'low', // Default resolution [{Number}, 'low', 'high'],
               dynamicLabel: true
           }
       }
   }, function(){
       var player = this;
       window.player = player;
       player.updateSrc([
           <?php
                $src="";
               foreach ($links_array as $value){
                   $res=intval($value["quality"]);
                   $src.="{
               src: '".$value["link"]."',
               type: 'video/mp4',
               label: '".$value["quality"]."',
               res: ".$res."
           },";}
               echo $src;
           ?>


       ]);
       player.on('resolutionchange', function(){
           console.info('Source changed to %s', player.src())
       });

       player.on("waiting", function ()
       {
           this.addClass("vjs-custom-waiting");
       });
       player.on("playing", function ()
       {
           this.removeClass("vjs-custom-waiting");
       });

       <?php

       if (isset($_GET["c"]) && $_GET["c"] != "") {

           $con1 = $GLOBALS["connect"];
           $get_channels_sql = "SELECT * FROM channels";
           $get_channels_res = $con1->prepare($get_channels_sql);
           $get_channels_res->execute();
           $channels_array = array();
           $row_channels = $get_channels_res->fetch(PDO::FETCH_ASSOC);
           $channels_array = explode(",", $row_channels["channels"]);

           if (in_array($_GET["c"], $channels_array)) {

               echo '
                
                player.watermark({
            opacity: 100,
            clickable: true,
            url: "https://t.me/' . $_GET["c"] . '",
            className: "vjs-watermark",
            text: "T.me/' . $_GET["c"] . '",
            debug: false
        });
                
                ';
           }else{

               echo '
                
            player.watermark({
            opacity: 100,
            clickable: true,
            url: "https://t.me/Movie_serie",
            className: "vjs-watermark",
            text: "T.me/Movie_serie",
            debug: false
        });
                
                ';

           }

       }else{

           echo '
                
            player.watermark({
            opacity: 100,
            clickable: true,
            url: "https://t.me/Movie_serie",
            className: "vjs-watermark",
            text: "T.me/Movie_serie",
            debug: false
        });
                
                ';

       }

       ?>

   });



   <?php

   if ($have_admin_panel_modal == "1") {
       echo '$("#admin-panel-modal").modal("show")';
   }

   ?>


   $("#search-box button").click(function () {

       var query = $("#search-box input").val();
       document.location.href = "https://moovie.in/search/?q=" + query;

   });


</script>


</body>
</html>
