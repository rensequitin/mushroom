<?php
	require_once("class.database.php");
	$db = MushroomDB::getInstance();
	
	$product_val= "";
	$product_value = "";
	$total = 0;

	foreach ($_SESSION['Cart'] as $cart => $cartItems) {
			$sql = "Select * from mushroom_foods where food_code = '$cart'";
			$exist = $db->checkExist($sql) or die(mysql_error());
			if($exist){
				$row = $db->fetch_array($exist);
				$foods = $row['food_name'];
				$food_price = $row['food_price'];
				
				$total = (float)$food_price * (float)$cartItems;
				$product_val = $foods."*".$cartItems."*".$food_price."*".$total.",";
				$product_value .= $product_val;
			}
	}
	echo $product_value;

?>