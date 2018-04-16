<?php
	require_once("class.database.php");
	
	
	
	$db = MushroomDB::getInstance();
	//$code = $db->generateCode();
	if(isset($_SESSION['Cart'])){
	generate:
	$code = $db->generateCode();
	$name = $_SESSION['Name'];
	$contact = $_SESSION['Contact'];
	$address = $_SESSION['Address'];
	$date = date('F d, Y',strtotime('+8 hours'));
	$time = date('h:i A',strtotime('+8 hours'));	
	$secs = time();
	//echo $time;
	//echo $secs."<br>";
	//echo $secs + 40;
	//echo $code;
	//echo $user;
	$sql = "Select * from mushroom_delivery where delivery_code = '$code'";
	$exist = $db->checkExist($sql) or die(mysql_error());
	
	$check = $db->get_rows($exist);
		if($check>=1){
			goto generate;
		}
		else{
			$sql = "Insert into mushroom_delivery values('$code','$name','$contact','$date','$time','$secs','$address','Pending','Unseen','','No')";
			$exist = $db->checkExist($sql) or die(mysql_error());
				if($exist){
					foreach ($_SESSION['Cart'] as $cart => $cartItems) {
						$sql = "Select * from mushroom_foods where food_code = '$cart'";
						$exist = $db->checkExist($sql) or die(mysql_error());
						if($exist){
							$row = $db->fetch_array($exist);
							$foods = $row['food_name'];
							$food_price = $row['food_price'];
							
							$total = (float)$food_price * (float)$cartItems;
							
							$sql1 = "Insert into mushroom_orders values('$code','$foods','$cartItems','$food_price','$total')";
							$exist1 = $db->checkExist($sql1) or die(mysql_error());
						}
					}
					echo "Thank you";
					unset($_SESSION['Cart']);
				}
		}
	}
	else{
		echo "Error";
	}
?>