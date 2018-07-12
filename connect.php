<?php
	try
	{
		$connect=new PDO("mysql:host=localhost;dbname=telecha1_mmd_food;charset=utf8mb4","telecha1","19vjc8ZzQ5");
		return $connect;
	}
	catch(PDOException $error)
	{
		echo "Error in connect to Database";
	}
?>