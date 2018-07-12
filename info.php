<?php

include ("connect.php");
$con1 = $GLOBALS["connect"];
$get_admin_sql = "CREATE TABLE IF NOT EXISTS `food_menu_category` (
  `menu_id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(100) NOT NULL,
  `menu_image` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";
$get_admin_res = $con1->prepare($get_admin_sql);
$get_admin_res->execute();


?>

