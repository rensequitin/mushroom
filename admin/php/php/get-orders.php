<?php
	require_once("class.database.php");
	
	$val = $_GET['val'];
	
	$db = MushroomDB::getInstance();
		
		$sql = "Update mushroom_delivery set delivery_read = 'Seen' where delivery_code ='$val'";
		$exist = $db->checkExist($sql) or die(mysql_error());
			if($exist){
				$total = 0;
				$sql = "Select * from mushroom_orders where delivery_code ='$val'";
				$exist = $db->checkExist($sql) or die(mysql_error());
				while($row = $db->fetch_array($exist)){
					$foods = $row['order_foods'];
					$quantity = $row['order_quantity'];
					$price = $row['order_price'];
					$subtotal = $row['order_subtotal'];
					$total += $subtotal;
					echo "<tr>
						<td>{$foods}</td>
						<td>{$quantity}</td>
						<td>{$price}.00</td>
						<td>{$subtotal}.00</td>
					</tr>";
				}
			}
		
		echo "<tr>
			<td colspan='2'></td>
			<td>Total: </td>
			<td>&#x20B1;{$total}</td>
			</tr>";
		echo "<tr>
			<td colspan='4'><button class='btn btn-primary' type='button'>Delivered</button></td>
			</tr>";
	
	
?>
	