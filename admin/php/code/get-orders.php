<?php
	require_once("class.database.php");
	
	$val = $_GET['val'];
	$count = 0;
	$div = 0;
	$class = "";
	$db = MushroomDB::getInstance();
		
		$sql = "Update mushroom_delivery set delivery_read = 'Seen' where delivery_code ='$val'";
		$exist = $db->checkExist($sql) or die(mysql_error());
			if($exist){
				$total = 0;
				$sql = "Select * from mushroom_orders where delivery_code ='$val'";
				$exist = $db->checkExist($sql) or die(mysql_error());
				while($row = $db->fetch_array($exist)){
					if($count==0){
						$div++;
					}
					$count++;
					if($div==1){
						$class='active';
					}
					else{
						$class='';
					}
					$foods = $row['order_foods'];
					$quantity = $row['order_quantity'];
					$price = $row['order_price'];
					$subtotal = $row['order_subtotal'];
					$total += $subtotal;
					echo "<tr>
						<td seen='$div' class='$class'>{$foods}</td>
						<td seen='$div' class='$class'>{$quantity}</td>
						<td seen='$div' class='$class'>{$price}.00</td>
						<td seen='$div' class='$class'>{$subtotal}.00</td>
					</tr>";
					if($count==4){
						$count = 0;
					}
				}
			}
		
		echo "<tr>
			<td colspan='2'></td>
			<td>Total: </td>
			<td>&#x20B1;{$total}.00</td>
			</tr>";
		/* echo "<tr>
			<td colspan='4'><button onclick='deliverOrder($val);' class='btn btn-primary' type='button'>Delivered</button></td>
			</tr>"; */
			
		echo "*";
		echo "<button style='width:204px;' class='btn btn-warning'>DELETE</button>
			  <button onclick='deliverOrder($val);' style='width:204px;' class='btn btn2 btn-success'>DELIVER</button>";
	
	
?>
	