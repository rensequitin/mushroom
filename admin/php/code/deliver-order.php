<?php
	require_once("class.database.php");
	
	$val = $_GET['val'];
	$codeVal = $_GET['code'];
	$db = MushroomDB::getInstance();
		
		$sql = "Update mushroom_delivery set delivery_status = 'Delivered', delivery_served = 'Sana' where delivery_code ='$codeVal'";
		$exist = $db->checkExist($sql) or die(mysql_error());
			if($exist){
				echo ("Success");
				//include('table-orders.php');
			}
	
	
?>
	