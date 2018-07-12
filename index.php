<?php
/**
 * Created by PhpStorm.
 * User: Amir ZR
 * Date: 4/11/2018
 * Time: 5:10 PM
 */

include "proc/connect.php";

if (isset($_GET["m"]) && $_GET["m"] >= 1) {
    $con0 = $GLOBALS["connect"];
    $get_smovie_sql = "SELECT * FROM movies WHERE id=" . $_GET["m"];
    $get_smovie_res = $con0->prepare($get_smovie_sql);
    $get_smovie_res->execute();
    if ($row_smovie = $get_smovie_res->fetch(PDO::FETCH_ASSOC)) {
        $sfolder = $row_smovie["folder"];
        header("Location: https://moovie.in/movie/" . $sfolder);
    }

}

if (isset($_GET["sub"]) && $_GET["sub"] != "") {
    header("Location: https://moovie.in/files/subtitle/" . $_GET["sub"] . ".srt");
}

if (isset($_GET["f"]) && $_GET["f"] != "" && isset($_GET["l"]) && $_GET["l"] != "") {
    $con01 = $GLOBALS["connect"];
    $get_smovie_sql = "SELECT * FROM movies WHERE id=" . $_GET["f"];
    $get_smovie_res = $con01->prepare($get_smovie_sql);
    $get_smovie_res->execute();
    if ($row_smovie = $get_smovie_res->fetch(PDO::FETCH_ASSOC)) {
        $links_array = json_decode($row_smovie["links"], true);

        $ind = 0;
        $find_index = 0;
        foreach ($links_array as $val) {

            if ($val["level"] == $_GET["l"]) {
                $find_index = $ind;
            }
            $ind=$ind+1;
        }
        header("Location: " . $links_array[$find_index]["link"]);
    }
}


$today = date("y-m-d");
$have_admin_panel_modal = "0";
if (!isset($_COOKIE["admin-panel-modal-" . $today])) {
    $have_admin_panel_modal = "1";
    setcookie("admin-panel-modal-" . $today, "1", time() + 432000, "/");
}

?>


<html>
<head>
    <meta charset="UTF-8">
    <title>تماشای آنلاین فیلم و سریال</title>
    <meta name="description"
          content="تماشای آنلاین جدیدترین و بهترین فیلم ها و سریال های ایران و جهان با کیفیت های مختلف و زیرنویس فارسی">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:url" content="https://moovie.in"/>
    <meta property="og:title" content="تماشای آنلاین فیلم و سریال"/>
    <meta property="og:site_name" content="مووی : تماشای آنلاین فیلم و سریال"/>
    <meta property="og:image" content="https://moovie.in/assets/img/movie-poster.jpg"/>
    <link rel="stylesheet" href="https://moovie.in/assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700,800" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="https://moovie.in/assets/img/favicon.png"/>
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

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

        #site-title {
            background-color: #f8f9fa;
            text-align: center;
            height: 58px;
        }

        ::placeholder {
            color: #fff;
        }

        #moovie-logo {
            background-image: url("assets/img/televisions.svg");
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

            background-image: url("assets/img/white-search.svg");
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

        .carousel-cell {

            width: 20%;
            height: 400px;

        }

        .carousel-cell a {
            width: 100%;
            height: 100%;
            display: inline-block;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .dot {
            background-color: #fff !important;
            width: 12px !important;
            height: 12px !important;
        }

        .flickity-page-dots {
            bottom: 25px !important;
        }

        #new-movie-container {
            overflow: hidden;
        }

        #new-movie-title {

            padding: 20px 0 6px;
            text-align: center;

        }

        #new-movie-title h1 {

            font-family: teshrin-bold;
            font-size: 20px;
            text-align: center;
            margin: 0;
            background-color: #FF533D;
            display: inline-block;
            padding: 10px 16px;
            margin: 0 auto;
            color: #fff;
            border-radius: 50px;

        }

        .movie {
            display: inline-block;
            width: 20%;
            vertical-align: top;
            padding: 15px;
            float: left;
            text-align: right;
        }

        .movie a {
            width: 100%;
            height: 300px;
            display: block;
            background-size: cover;
            background-position: 50%;
            border-radius: 5px;
            position: relative;
            overflow: hidden;
        }

        .movie-detail-gradient {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 50%, #000 100%);
            height: 120%;
            position: absolute;
            width: 100%;
            margin-top: -10%;
            transition: all 0.3s ease 0s;
        }

        .movie-detail-gradient:hover {

            transform: translateY(-33px);

        }

        .movie-detail {
            bottom: 6px;
            position: absolute;
            text-align: right;
            direction: rtl;
            width: 100%;
            padding: 0 14px;

        }

        .movie-points::before {

            content: "";
            display: inline-block;
            width: 16px;
            height: 16px;
            background-image: url("https://moovie.in/assets/img/star.svg");
            margin-left: 5px;
            vertical-align: top;
            margin-top: 1px;

        }

        .movie-points {

            font-size: 14px;
            color: #fff;
            padding: 0 4px;

        }

        .movie h2 {

            font-family: 'teshrin-medium';
            font-size: 20px;
            padding: 10px 4px 4px 4px;
            color: #fff;

        }

        .movie h3 {

            color: #fff;
            font-family: 'teshrin-regular';
            font-size: 16px;
            padding: 0 4px;
            white-space: nowrap;
        }

        .play-img {
            position: absolute;
            width: 45px;
            height: 45px;
            background-image: url("https://moovie.in/assets/img/white-play.svg");
            left: 50%;
            top: -80%;
            background-size: contain;
            transition: all 0.3s ease 0s;
            transform: scale(0);
            margin-left: -22.5px;
        }

        .movie-detail-gradient:hover .play-img {

            transform: scale(1);

        }

        #my-pagination {
            display: inline-block;
            padding: 24px;
        }

        .page-link:hover {
            color: #FF533D;
        }

        .page-link {
            color: #FF533D;
        }

        .page-item.active .page-link {
            background-color: #FF533D;
            border-color: #FF533D;
        }

        #building {
            background-color: #feca57;
            margin: 0;
            padding: 12px;
            color: #1e1e1e;
            text-align: center;
            direction: rtl;
        }

        @media (min-width: 780px) and (max-width: 1200px) {
            .carousel-cell {
                width: 25%;
                height: 380px;
            }
        }

        @media (min-width: 480px) and (max-width: 779px) {
            .carousel-cell {
                width: 33.33%;
                height: 360px;
            }
        }

        @media (min-width: 340px) and (max-width: 479px) {
            .carousel-cell {
                width: 50%;
                height: 360px;
            }
        }

        @media (min-width: 0px) and (max-width: 339px) {
            .carousel-cell {
                width: 100%;
                height: 340px;
            }
        }

        @media (min-width: 0px) and (max-width: 700px) {
            #new-movie-title h1 {
                font-size: 16px;
            }
        }

        @media (min-width: 760px) and (max-width: 960px) {
            .movie {
                width: 25%;
                padding: 10px;
            }

            .movie-detail {
                bottom: 12px;
            }
        }

        @media (min-width: 470px) and (max-width: 759px) {
            .movie {
                width: 33%;
                padding: 8px;
            }

            .movie-detail {
                bottom: 14px;
            }
        }

        @media (min-width: 330px) and (max-width: 469px) {
            .movie {
                width: 50%;
                padding: 6px;
            }

            .movie-detail {
                bottom: 16px;
            }
        }

        @media (min-width: 0px) and (max-width: 329px) {
            .movie {
                width: 100%;
                padding: 10px;
            }

            .movie-detail {
                bottom: 2px;
            }
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
    <div id="slider-wrapper">
        <div class="main-carousel">
            <?php
            $con = $GLOBALS["connect"];
            $get_movie_id_sql = "SELECT * FROM slider";
            $get_movie_id_res = $con->prepare($get_movie_id_sql);
            $get_movie_id_res->execute();
            $slider_movie_id = array();
            while ($row_movie_id = $get_movie_id_res->fetch(PDO::FETCH_ASSOC)) {
                $slider_movie_id[] = $row_movie_id["movie-id"];
            }

            $con1 = $GLOBALS["connect"];
            $get_slider_sql = "SELECT * FROM movies WHERE id IN( " . implode(",", $slider_movie_id) . ")";
            $get_slider_res = $con1->prepare($get_slider_sql);
            $get_slider_res->execute();
            while ($row_slider = $get_slider_res->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="carousel-cell"><a href="https://moovie.in/movie/' . $row_slider["folder"] . '/" style="background-image: url(https://moovie.in/files/cover/' . $row_slider["id"] . '.jpg)"></a></div>';
            }
            ?>
        </div>
    </div>


    <div id="new-movie">
        <div id="new-movie-title">
            <h1>جدیدترین فیلم ها و سریال ها</h1>
        </div>
        <div id="new-movie-container">

            <?php
            if (isset($_GET["page"]) && $_GET["page"] >= 1) {
                $from = intval($_GET["page"]) * 20;
            } else {
                $from = 0;
            }

            $con1 = $GLOBALS["connect"];
            $get_movie_sql = "SELECT * FROM movies ORDER BY id DESC LIMIT $from,20";
            $get_movie_res = $con1->prepare($get_movie_sql);
            $get_movie_res->execute();
            while ($row_movie = $get_movie_res->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="movie"><a href="https://moovie.in/movie/' . $row_movie["folder"] . '" style="background-image: url(https://moovie.in/files/cover/' . $row_movie["id"] . '.jpg)">
                    <div class="movie-detail-gradient">
                        <div class="movie-detail">
                            <span class="movie-points">' . $row_movie["points"] . '</span>
                            <h2>' . $row_movie["en-name"] . '</h2>
                            <h3>' . $row_movie["genre"] . '</h3>
                            <span class="play-img"></span>
                        </div>
                    </div>
                </a></div>';
            }
            ?>
        </div>
    </div>


    <?php

    if (!isset($_GET["page"]) || $_GET["page"] <= 1) {
        $perev_disable = "disabled";
    } else {
        $perev_disable = "";
    }

    if (isset($_GET["page"]) && $_GET["page"] >= 1) {
        $perev_page = intval($_GET["page"]) - 1;
        $next_page = intval($_GET["page"]) + 1;
        $this_page = $_GET["page"];
    } else {
        $perev_page = 1;
        $next_page = 2;
        $this_page = 1;

    }

    ?>

    <nav id="my-pagination">
        <ul class="pagination">
            <li class="page-item <?php echo $perev_disable ?>">
                <a class="page-link" href="https://moovie.in/?page=<?php echo $perev_page ?>" tabindex="-1">قبلی</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#"><?php echo $this_page ?> <span class="sr-only">(current)</span></a>
            </li>
            <li class="page-item">
                <a class="page-link" href="https://moovie.in/?page=<?php echo $next_page ?>">بعدی</a>
            </li>
        </ul>
    </nav>

    <p id="building">
        سایت در دست ساخت می باشد ، تا کامل شدن سایت با ما همراه باشید...
        <a href="https://t.me/moovie_in_support" target="_blank">تماس با ما</a>
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
                    <a href="https://t.me/iLoveMyBro" target="_blank">تماس با ما</a>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

<script type="text/javascript">
    $('.main-carousel').flickity({
        // options
        cellAlign: 'left',
        prevNextButtons: false,
        wrapAround: true,
        contain: true,
        autoPlay: true,
        autoPlay: 5000
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
