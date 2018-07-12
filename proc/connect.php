<?php
	try
	{
		$connect=new PDO("mysql:host=localhost;dbname=mooviein_main;charset=utf8mb4","mooviein","506Qff4Ofb");
		return $connect;
	}
	catch(PDOException $error)
	{
		echo "Error in connect to database!";
	}
?>