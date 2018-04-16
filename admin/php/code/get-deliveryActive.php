<?php
	require_once("class.database.php");
	
	$val = $_GET['val'];
	$active = $_GET['active'];
	
	$db = MushroomDB::getInstance();
	
	$sql = "";
	$count = 0;
	$div = 0;
	$class = "";
	
	if($val=="all"){
		$sql = "Select * from mushroom_delivery where delivery_status='Pending' order by delivery_seconds desc";
	}
	else{
		$sql = "Select * from mushroom_delivery where delivery_status='Pending' AND delivery_read ='$val' order by delivery_seconds desc";
	}
		
		$exist = $db->checkExist($sql) or die(mysql_error());
		if($exist){
			while($row = $db->fetch_array($exist)){
				if($count==0){
					$div++;
				}
				$code = $row['delivery_code'];
				$customer = $row['delivery_customer'];
				$contact = $row['delivery_contact'];
				$date = $row['delivery_date'];
				$time = $row['delivery_time'];
				$address = $row['delivery_address'];
				$read = $row['delivery_read'];
				$count++;
				if($div==$active){
					$class='active';
				}
				else{
					$class='';
				}
				echo "<tr id='{$read}'>
					<td seen='$div' class='$class'>{$code}</td>
					<td seen='$div' class='$class'>{$customer}</td>
					<td seen='$div' class='$class'>{$contact}</td>
					<td seen='$div' class='$class'>{$date}</td>
					<td seen='$div' class='$class'>{$time}</td>
					<td seen='$div' class='$class'>{$address}</td>
					<td seen='$div' class='$class' align='center'><button onclick='view_orders({$code});' class='btn btn-success'>Order Details</button></td>				
				</tr>";
				if($count==4){
					$count = 0;
				}
			}
			
		}
		else{
			echo "";
			
		}
		
		
		/* <td><button onclick='view_orders({$code});'>View Order</button></td> */
	
	
?>