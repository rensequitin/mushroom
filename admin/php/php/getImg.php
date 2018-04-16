<?php
if (isset($_SESSION['User'])){
		$user = $_SESSION['User'];
		$sql = "Select * from mushroom_users where user_username = '$user'";
		$exist = $db->checkExist($sql) or die(mysql_error());
		$check = $db->get_rows($exist);
			if($check){
				$row = $db->fetch_array($exist);
				$pic = $row['user_picture'];
				$name = $row['user_fullname'];
				$contact = $row['user_contact'];
				$address = $row['user_address'];
				$province = $row['user_province'];
				$city = $row['user_city'];
				$complete_address = $address.", ".$city.", ".$province;	
				$_SESSION['Name'] = $name;
				$_SESSION['Contact'] = $contact;
				$_SESSION['Address'] = $complete_address;
			}
	}
	else{
		$pic = "profile/user.png";
		$name = "Full Name";
		$contact = "Contact Number";	
		$complete_address = "Complete Address";
		
	}
?>