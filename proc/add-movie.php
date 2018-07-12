<?php
/**
 * Created by PhpStorm.
 * User: Amir ZR
 * Date: 4/7/2018
 * Time: 12:45 PM
 */
header('Content-Type: text/html; charset=utf-8');
include("connect.php");
include("image-func.php");
include('SrtParser/srtFile.php');

$ref = parse_url($_SERVER['HTTP_REFERER']);
if ($ref["host"] == "moovie.in") {
    $fa_name = $_POST["faname"];
    $en_name = $_POST["enname"];
    $desc = $_POST["desc"];
    $trailer = $_POST["trailer"];
    $points = $_POST["points"];
    $genre = $_POST["genre"];
    $folder = "";
    $links = $_POST["links"];


    if (((isset($fa_name) && $fa_name != "") || (isset($en_name) && $en_name != "")) && isset($desc) && $desc != "" && isset($trailer) && $trailer != "" && isset($points) && $points != "" && isset($genre) && $genre != "" && isset($links) && $links != "") {

        $folder = strtolower(str_replace(" ", "-", $_POST["enname"]));
        $folder_temp = $folder;
        $folder_path = "../movie/" . $folder;
        $name_adding = 0;
        while (file_exists($folder_path) == "1") {
            $name_adding++;
            $folder_path = "../movie/" . $folder_temp . "-" . $name_adding;
            $folder = $folder_temp . "-" . $name_adding;
        }


        $con = $GLOBALS["connect"];
        $add_sql = "INSERT INTO movies VALUES (NULL, ?, ?, ?, ?, ?,?,?, ?)";
        $add_result = $con->prepare($add_sql);
        $add_result->bindvalue(1, $fa_name);
        $add_result->bindvalue(2, $en_name);
        $add_result->bindvalue(3, $folder);
        $add_result->bindvalue(4, $desc);
        $add_result->bindvalue(5, $trailer);
        $add_result->bindvalue(6, $points);
        $add_result->bindvalue(7, $genre);
        $add_result->bindvalue(8, $links);
        if ($add_result->execute()) {

            //find this movie id
            $con2 = $GLOBALS["connect"];
            $find_id_sql = "SELECT * FROM movies WHERE folder=?";
            $find_id_res = $con2->prepare($find_id_sql);
            $find_id_res->bindvalue(1, $folder);
            $find_id_res->execute();
            if ($row = $find_id_res->fetch(PDO::FETCH_ASSOC)) {

                $this_movie_id = $row["id"];
                move_uploaded_file($_FILES["cover"]["tmp_name"], "../files/cover/" . $this_movie_id . ".jpg");
                resize_image("../files/cover/" . $this_movie_id . ".jpg", $_FILES["cover"]["type"], 350, 500, 0);



                mkdir($folder_path);

                $myfile = fopen($folder_path . "/index.php", "w");
                $write_php = '<?php $this_movie = ' . $this_movie_id . ';include($_SERVER["DOCUMENT_ROOT"]."/assets/movie-page.php");?>';
                fwrite($myfile, $write_php);


                mkdir("../trailer/" . $folder);

                $myfile = fopen("../trailer/" . $folder . "/index.php", "w");
                $write_php = '<?php $this_movie = ' . $this_movie_id . ';include($_SERVER["DOCUMENT_ROOT"]."/assets/trailer.php");?>';
                fwrite($myfile, $write_php);




                if (isset($_FILES["subtitleSrt"])) {
                    move_uploaded_file($_FILES["subtitleSrt"]["tmp_name"], "../files/subtitle/" . $this_movie_id . ".srt");

                    //convert to vtt


                    $srt = new \SrtParser\srtFile("../files/subtitle/" . $this_movie_id . ".srt");
                    $srt->setWebVTT(true);
                    $srt->build(true);
                    $srt->save("../files/subtitle/" . $this_movie_id . ".vtt", true);




                }


                echo "1";


            }


        }

    }

}


?>