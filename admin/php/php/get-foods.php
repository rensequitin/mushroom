<?php
	require_once("class.database.php");
	
	$id = $_GET['id'];
	
	$db = MushroomDB::getInstance();
	
	$sql = "Select * from mushroom_foods where food_code = '$id'";
	$exist = $db->checkExist($sql) or die(mysql_error());
	
	while($row = $db->fetch_array($exist)){
			$food_img = $row['food_image'];
			$food_name= $row['food_name'];
			$food_price= $row['food_price'];
	}
	
	echo $food_img."*".$food_name."*".$food_price;
?>