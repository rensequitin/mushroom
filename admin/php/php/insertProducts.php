<?php
	require_once("class.database.php");
	
	$food = $_GET['food_code'];
	$quantity = $_GET['quantity'];
	
	$db = MushroomDB::getInstance();
	
	if(isset($_SESSION['Cart'])){
		$val = 0;
		foreach ($_SESSION['Cart'] as $cart => $items) {
			if($cart==$food){
				$_SESSION['Cart'][$food] = $_SESSION['Cart'][$food]+ $quantity;
				$val = 1;
			}
		}
		
		if(!$val){
		$add = array($food => $quantity);
		$_SESSION['Cart']+= $add;
		}
	}
	else{
		$_SESSION['Cart']= array($food => $quantity);
	}
	

?>