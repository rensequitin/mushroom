<?php
	require_once("class.database.php");
	
	$db = MushroomDB::getInstance();
		
		$total = 0;
		$sql = "Select * from mushroom_delivery where delivery_notify ='No'";
		$exist = $db->checkExist($sql) or die(mysql_error());
		
		$row = $db->get_rows($exist);
		
		if($row>=1){
			if($row==1){
				echo "You have $row new message";
			}
			else{
				echo "You have $row new messages";
			}
			$sql = "Update mushroom_delivery set delivery_notify ='Yes' where 1";
			$exist = $db->checkExist($sql) or die(mysql_error());
		}
		else{
			echo "0";
		}
	
?>
	