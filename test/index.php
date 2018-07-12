<?php
/**
 * Created by PhpStorm.
 * User: AmirZR
 * Date: 6/5/2018
 * Time: 7:35 PM
 */



require('SrtParser/srtFile.php');

try{
    $srt = new \SrtParser\srtFile("1.srt");
    $srt->setWebVTT(true);
    $srt->build(true);
    $srt->save("webvtt.vtt", true);
}
catch(Exeption $e){
    echo "Error: ".$e->getMessage()."\n";
}

?>