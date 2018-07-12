<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/proc/connect.php");
if (!isset($_SESSION["is-admin-login"]) || $_SESSION["is-admin-login"] != "moo2017") {
    header('Location: https://moovie.in/admin/');
}

$fa_name_placeholder = 'نام فارسی فیلم';
$en_name_placeholder = 'نام انگلیسی فیلم';
$trailer_placeholder = 'لینک پیش نمایش فیلم';
$points_placeholder = 'امتیاز فیلم';
$genre_placeholder = 'ژانر فیلم';

$level_placeholder = "1";
$quality_placeholder = "1080p";
$link_placeholder = "لینک فیلم";


?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Moovie Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://moovie.in/assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700,800" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="https://moovie.in/assets/img/favicon.png"/>

    <style>

        #main-container {
            padding: 15px 0 15px 0;
        }

        #movie-info-container, #movie-links-container {
            text-align: center;
        }

        #movie-info-title, #movie-links-title {
            margin-bottom: 14px;
        }

        .title-bottom-border {
            width: 45%;
            height: 5px;
            background-color: #FF533D;
            display: block;
            margin: 0 auto;
            border-radius: 5px;
        }

        table {
            width: 100%;
        }

        td {
            padding: 6px !important;
        }

        #movie-links-container input {
            width: 100%;
        }

        #movie-links-container span {
            padding: 0 4px 0 4px;
        }

        .btn-add-container {
            display: block;
            text-align: center;
            width: 100%;
            margin-top: 20px;
        }

        .btn-add {
            background-color: #FF533D;
            font-weight: 700;
            color: #fff;
            padding: 12px 25px;
            transition: all 0.3s ease 0s;
        }

        .btn-add:hover {
            background-color: #ed503c;
        }

        nav a {
            color: #FF533D;
            transition: all 0.3s ease 0s;
        }

        nav a:hover {
            color: #ed503c;
        }

        @media (max-width: 575.98px) {
            #movie-links-container {
                margin-top: 14px;
            }

            .container {
                width: 90%;
            }

            #movie-links-container td {
                padding: 6px !important;
            }

            h1 {
                font-size: 1.7rem;
            }
        }

        /*Small devices (landscape phones, 576px and up)*/
        @media (min-width: 576px) and (max-width: 767.98px) {
            #movie-links-container {
                margin-top: 14px;
            }

            .container {
                width: 90%;
            }

            #movie-links-container td {
                padding: 6px !important;
            }

            h1 {
                font-size: 1.7rem;
            }
        }

        .invalid-text {
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
        }

        input[type=text].ng-invalid.ng-touched, textarea.ng-invalid.ng-touched {
            border-color: #dc3545;
        }

        .red-delete {
            background-image: url("../assets/img/white-delete.svg");
            background-color: #ed503c;
        }

        .green-add {
            background-image: url("../assets/img/white-add.svg");
            background-color: #10ac84;
        }

        .links-button {
            width: 28px;
            height: 28px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-position: center;
            background-size: 18px;
            background-repeat: no-repeat;
        }

        /*Medium devices (tablets, 768px and up)*/
        @media (min-width: 768px) and (max-width: 991.98px) {
            ...
        }

        /*Large devices (desktops, 992px and up)*/
        @media (min-width: 992px) and (max-width: 1199.98px) {
            ...
        }

        /*Extra large devices (large desktops, 1200px and up)*/
        @media (min-width: 1200px) {
            ...
        }

        @font-face {
            font-family: "teshrin-medium";
            src: url("https://moovie.in/assets/font/TeshrinARLT-Medium.ttf");
        }

        * {
            font-family: 'teshrin-medium';
        }

        #all-movie td img {
            width: 100px;
        }

        #all-movie td {
            vertical-align: middle;
        }

        .table {
            text-align: center;
        }

        .show-button {
            background-color: #007bff;
            width: 110px;
            padding: 11px 0px;
            color: #fff;
            display: block;
            border-radius: 5px;
            text-decoration: none;
        }

        .show-button:hover {
            color: #fff;
        }

        .show-button:first-child {
            margin-bottom: 8px;
        }

        .send-button {

            background-color: #10ac84;
            width: 110px;
            padding: 11px 0px;
            color: #fff;
            display: block;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            margin-bottom: 8px;
            cursor: pointer;
        }

        td label {

            margin-left: 4px;

        }

        #convert-btn {
            margin-left: 8px;
        }

        #movie-info-container textarea {
            height: 400px !important;

        }

        .right-text {
            text-align: right;
            direction: rtl;
        }

        .loading {
            display: none;
            width: 30px;
            height: 30px;
            background-image: url("https://moovie.in/assets/img/loading.gif");
            background-position: center;
            background-size: cover;
            vertical-align: middle;
        }

        :disabled {
            cursor: not-allowed;
        }

        .tiny-title-bottom-border {
            width: 10%;
            height: 3px;
            background-color: #FF533D;
            display: block;
            border-radius: 5px;

        }

        .tiny-title-wrapper {
            margin-bottom: 16px;
        }

        .tiny-title-wrapper h5 {
            text-align: left;
        }

    </style>
</head>

<body ng-app="myApp">
<nav id="navbar-example2" class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="#">Moovie.in</a>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="#add-section">Add Movie</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#movies-section">All Movie</a>
        </li>
    </ul>
</nav>
<div id="main-container" class="container" ng-controller="addMovie">
    <form class="row" name="movie" novalidate>
        <div class="col-sm-12 col-md-6 col-lg-6" id="movie-info-container">
            <div id="movie-info-title">
                <h1>Movie information</h1>
                <span class="title-bottom-border"></span>
            </div>
            <table>
                <tr>
                    <td>FA Name</td>
                    <td>
                        <input placeholder="<?php echo $fa_name_placeholder ?>" type="text" name="faname"
                               ng-model="faname" class="form-control right-text"
                               ng-required="false"></input>
                        <!-- <div class="invalid-text" ng-show="movie.faname.$invalid && movie.faname.$touched">Please enter the title...</div>-->
                    </td>
                </tr>
                <tr>
                    <td>EN Name</td>
                    <td>
                        <input placeholder="<?php echo $en_name_placeholder ?>" type="text" name="enname"
                               ng-model="enname" class="form-control"
                               ng-required="false"></input>
                        <!--<div class="invalid-text" ng-show="movie.enname.$invalid && movie.enname.$touched">Please enter the title...</div>-->
                    </td>
                </tr>
                <tr>
                    <td>Desc</td>
                    <td>
                        <textarea name="desc" ng-model="desc" class="form-control right-text"></textarea>
                        <div class="invalid-text" ng-show="movie.desc.$invalid && movie.desc.$touched">Please enter the
                            description...
                        </div>
                    </td>

                </tr>
                <tr>
                    <td>Trailer</td>
                    <td>
                        <input placeholder="<?php echo $trailer_placeholder ?>" type="url" class="form-control"
                               ng-model="trailer" name="trailer" ng-required="true">
                        <div class="invalid-text" ng-show="movie.trailer.$invalid && movie.trailer.$touched">Please
                            enter the valid url...
                        </div>

                    </td>
                </tr>


                <tr>
                    <td>Points</td>
                    <td>
                        <input placeholder="<?php echo $points_placeholder ?>" placeholder="" type="text"
                               class="form-control" ng-model="points" name="points"
                               ng-required="true">
                        <div class="invalid-text" ng-show="movie.points.$invalid && movie.points.$touched">Please enter
                            the valid url...
                        </div>

                    </td>
                </tr>

                <tr>
                    <td>Genre</td>
                    <td>
                        <input placeholder="<?php echo $genre_placeholder ?>" placeholder="" type="text"
                               class="form-control right-text" ng-model="genre" name="genre"
                               ng-required="true">
                        <div class="invalid-text" ng-show="movie.genre.$invalid && movie.genre.$touched">Please enter
                            the valid url...
                        </div>

                    </td>
                </tr>


                <tr>
                    <td>Cover</td>
                    <td><input type="file" name="cover" ng-model="cover" id="cover-input" hidden ng-required="true">
                        <button type="button" class="btn btn-dark"
                                onclick="document.getElementById('cover-input').click()">Select Cover
                        </button>
                    </td>
                </tr>

                <tr>
                    <td>Subtitle .srt</td>
                    <td><input type="file" name="subtitleSrt" ng-model="subtitleSrt" id="subtitleSrt-input" hidden
                               ng-required="true">
                        <button type="button" class="btn btn-dark"
                                onclick="document.getElementById('subtitleSrt-input').click()">Select Subtitle Srt
                        </button>
                    </td>
                </tr>


            </table>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-6" id="movie-links-container">
            <div>
                <div id="movie-links-title">
                    <h1>Movie Links</h1>
                    <span class="title-bottom-border"></span>
                </div>

                <div class="tiny-title-wrapper">
                    <h5>Player Link</h5>
                    <span class="tiny-title-bottom-border"></span>
                </div>


                <table>
                    <thead>
                    <tr>
                        <th class="col-1">Level</th>
                        <th class="col-2">Quality</th>
                        <th class="col-4">Link</th>
                        <th class="col-2">File id</th>
                        <th class="col-3">Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="col-1"><input placeholder="<?php echo $level_placeholder ?>" type="text"
                                                 class="form-control" id="playerVideoLevel" name="playerVideoLevel"
                                                 ng-model="playerVideoLevel"
                                                 ng-required="false"></td>
                        <td class="col-2"><input placeholder="<?php echo $quality_placeholder ?>" type="text"
                                                 class="form-control" id="playerVideoQuality" name="playerVideoQuality"
                                                 ng-model="playerVideoQuality" ng-required="false"></td>
                        <td class="col-4"><input placeholder="<?php echo $link_placeholder ?>" type="url"
                                                 class="form-control" name="playerVideoLink" ng-model="playerVideoLink"
                                                 ng-required="true"></td>
                        <td class="col-2"><input type="text" class="form-control" name="playerVideoFileId"
                                                 ng-model="playerVideoFileId" ng-required="false"></td>
                        <td class="col-2"><input type="text" class="form-control right-text" name="playerVideoDesc"
                                                 ng-model="playerVideoDesc" ng-required="false"></td>
                        <td class="col-1">
                            <button class="links-button green-add" ng-model="videoAddBtn" ng-click="addLink()"
                                    type="button"></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="invalid-text"
                     ng-show="movie.playerVideoLink.$invalid || movie.playerVideoQuality.$invalid || movie.playerVideoLevel.$invalid">
                    Please
                    Fill all boxes...
                </div>
                <table>
                    <tr ng-repeat="z in playerLinks">
                        <td class="col-1"><input type="text" class="form-control" disabled value="{{ z.playerLevel }}">
                        </td>
                        <td class="col-2"><input type="text" class="form-control" disabled value="{{z.playerQuality}}">
                        </td>
                        <td class="col-4"><input type="text" class="form-control" disabled value="{{z.playerLink}}">
                        </td>
                        <td class="col-2"><input type="text" class="form-control" disabled value="{{z.playerLileId}}">
                        </td>
                        <td class="col-2"><input type="text" class="form-control" disabled value="{{z.playerDesc}}">
                        </td>
                        <td class="col-1">
                            <button class="links-button red-delete" type="button"
                                    ng-click="deleteLink($index)"></button>
                        </td>
                    </tr>
                </table>
            </div>



            <!--Start of file link -->
            <div>

                <div class="tiny-title-wrapper">
                    <h5>File Link</h5>
                    <span class="tiny-title-bottom-border"></span>
                </div>


                <table>
                    <thead>
                    <tr>
                        <th class="col-1">Level</th>
                        <th class="col-2">Quality</th>
                        <th class="col-4">Link</th>
                        <th class="col-2">File id</th>
                        <th class="col-3">Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="col-1"><input placeholder="<?php echo $level_placeholder ?>" type="text"
                                                 class="form-control" id="fileVideoLevel" name="fileVideoLevel"
                                                 ng-model="fileVideoLevel"
                                                 ng-required="false"></td>
                        <td class="col-2"><input placeholder="<?php echo $quality_placeholder ?>" type="text"
                                                 class="form-control" id="fileVideoQuality" name="fileVideoQuality"
                                                 ng-model="fileVideoQuality" ng-required="false"></td>
                        <td class="col-4"><input placeholder="<?php echo $link_placeholder ?>" type="url"
                                                 class="form-control" name="fileVideoLink" ng-model="fileVideoLink"
                                                 ng-required="true"></td>
                        <td class="col-2"><input type="text" class="form-control" name="fileVideoFileId"
                                                 ng-model="fileVideoFileId" ng-required="false"></td>
                        <td class="col-2"><input type="text" class="form-control right-text" name="fileVideoDesc"
                                                 ng-model="fileVideoDesc" ng-required="false"></td>
                        <td class="col-1">
                            <button class="links-button green-add" ng-model="videoAddBtn" ng-click="addLink()"
                                    type="button"></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="invalid-text"
                     ng-show="movie.fileVideoLink.$invalid || movie.fileVideoQuality.$invalid || movie.fileVideoLevel.$invalid">
                    Please
                    Fill all boxes...
                </div>
                <table>
                    <tr ng-repeat="z in fileLinks">
                        <td class="col-1"><input type="text" class="form-control" disabled value="{{ z.fileLevel }}">
                        </td>
                        <td class="col-2"><input type="text" class="form-control" disabled value="{{z.fileQuality}}">
                        </td>
                        <td class="col-4"><input type="text" class="form-control" disabled value="{{z.fileLink}}">
                        </td>
                        <td class="col-2"><input type="text" class="form-control" disabled value="{{z.fileLileId}}">
                        </td>
                        <td class="col-2"><input type="text" class="form-control" disabled value="{{z.fileDesc}}">
                        </td>
                        <td class="col-1">
                            <button class="links-button red-delete" type="button"
                                    ng-click="deleteLink($index)"></button>
                        </td>
                    </tr>
                </table>
            </div>
            <!--End of file link -->
        </div>


        <div class="btn-add-container">
            <button type="button" class="btn btn-add" ng-click="sendMovie()">Add Movie +</button>
            <span class="loading"></span>
        </div>

    </form>


    <?php


    //get last page number

    $con = $GLOBALS["connect"];
    $get_last_page_number_sql = "SELECT COUNT(*) FROM movies;";
    $get_last_page_number_res = $con->prepare($get_last_page_number_sql);
    $get_last_page_number_res->execute();
    $slider_movie_id = array();
    $total_movie = $get_last_page_number_res->fetchColumn();

    $last_page_number = ceil(intval($total_movie) / 20);


    //get user telegram id,s
    $con3 = $GLOBALS["connect"];
    $get_tlgId_sql = "SELECT * FROM admin WHERE name='" . $_SESSION["admin-username"] . "'";
    $get_tlgId_res = $con3->prepare($get_tlgId_sql);
    $get_tlgId_res->execute();
    if ($row_tlgId = $get_tlgId_res->fetch(PDO::FETCH_ASSOC)) {
        $tlgId_array = explode(",", $row_tlgId["channel-id"]);
    }


    ?>

    <div id="all-movie">

        <div id="search-wrapper">
            <input type="text" placeholder="Search your video...">
            <button id="search-submit">Search</button>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Poster</th>
                <th scope="col">Fa-name</th>
                <th scope="col">En-name</th>
                <th scope="col">Points</th>
                <th scope="col">Genre</th>
                <th scope="col">Show</th>
                <th scope="col">Send</th>
            </tr>
            </thead>
            <tbody>

            <?php


            $con2 = $GLOBALS["connect"];
            $get_movie_sql = "SELECT * FROM movies ORDER BY id DESC LIMIT 0,20";
            $get_movie_res = $con2->prepare($get_movie_sql);
            $get_movie_res->execute();
            while ($row_movie = $get_movie_res->fetch(PDO::FETCH_ASSOC)) {


                echo '
                
                <tr>
                <td scope="col">' . $row_movie["id"] . '</td>
                <td scope="col"><img src="https://moovie.in/files/cover/' . $row_movie["id"] . '.jpg"/></td>
                <td scope="col">' . $row_movie["fa-name"] . '</td>
                <td scope="col">' . $row_movie["en-name"] . '</td>
                <td scope="col">' . $row_movie["points"] . '</td>
                <td scope="col">' . $row_movie["genre"] . '</td>
                <td scope="col">
                    <a class="show-button" target="_blank" href="https://moovie.in/movie/' . $row_movie["folder"] . '">Movie</a>
                    <a class="show-button" target="_blank" href="https://moovie.in/trailer/?id=' . $row_movie["id"] . '">Trailer</a>
                </td>
                <td scope="col">
                    <button type="button" ng-click=sendMovieToAdmin("' . $_SESSION["admin-username"] . '",' . $row_movie["id"] . ') class="send-button">Send</button>
                ';


                $tlgId_checkbox_html = "<form>";

                foreach ($tlgId_array as $item) {
                    $tlgId_checkbox_html .= "<input id='check-" . $row_movie["id"] . $item . "' type='radio' data-movie-id='" . $row_movie["id"] . "' name='channel' value='" . $item . "'><label for='check-" . $row_movie["id"] . $item . "'>" . $item . "</label></br>";
                }

                $tlgId_checkbox_html .= "</form>";

                echo $tlgId_checkbox_html;

                echo '
                </td>
            </tr>
                
                ';


            }


            ?>
            </tbody>
        </table>


    </div>


</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://moovie.in/assets/js/bootstrap.min.js"></script>
<script src="https://moovie.in/assets/js/axios.min.js"></script>
<script src="https://moovie.in/assets/js/angular.min.js"></script>
<script src="https://moovie.in/assets/js/app.js"></script>
<script src="https://moovie.in/assets/js/services.js"></script>
<script src="https://moovie.in/assets/js/controllers.js"></script>
</body>
</html>