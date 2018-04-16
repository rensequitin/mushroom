<?php
	require_once("class.database.php");
	
	$category = $_GET['category'];
	
	$db = MushroomDB::getInstance();
	

		$sql = "Select * from mushroom_foods where food_category = '$category' AND food_status = 'Active' order by food_time ASC";
		$exist = $db->checkExist($sql) or die(mysql_error());
		while($row = $db->fetch_array($exist)){
			$pic = $row['food_image'];
			$code = $row['food_code'];
			$name = $row['food_name'];
			$price = $row['food_price'];
			echo "<tr>
				<td><img src='{$pic}' width='80' height='60'</td>
				<td style='line-height:45px;'>{$code}</td>
				<td style='line-height:45px;'>{$name}</td>
				<td style='line-height:45px;'>{$price}</td>
				<td style='position:relative;top:10px; left:-40px;'><button value='{$code}'onclick='viewFoods(this.value);'>Edit</button>
				<button style='position:relative;top:-26px; left:80px;'>Delete</button></td>
			</tr>";
		}
	
?>
	