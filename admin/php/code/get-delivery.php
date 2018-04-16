<?php
	require_once("class.database.php");
	
	$val = $_GET['val'];
	
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
		$rows = $db->get_rows($exist);
		if($rows>=1){
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
				if($div==1){
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
			echo "*";
			
				$len = $div;
				$activelabel = "active";
				$id= '';		
			
				
				for($i=1; $i<=$len; $i++){

					if($i<3){
						$id= 'active';
					}
					else{
						$id= '';					
					}
					echo "<label val='$i' class='$activelabel' id='$id' style='height:23px; width:30px; margin-left:2px; border:solid 1.5pt #5cb85c; cursor:pointer; padding-left:6.5px; padding-right:6.5px;'> $i </label>";
					$activelabel ="";
				}
		}
		else{
			echo "*";
			echo "<label class='active' id='active' style='height:23px; width:30px; margin-left:2px; border:solid 1.5pt #5cb85c; cursor:pointer; padding-left:6.5px; padding-right:6.5px;'> 1 </label>";
		}
		
		
		/* <td><button onclick='view_orders({$code});'>View Order</button></td> */
	
	
?>

	