<?php
	require_once("class.database.php");
	$user = $_GET['username'];
	$pass = md5($_GET['password']);

	$db = MushroomDB::getInstance();
	
	$db->set_user($user);
	$db->set_pass($pass);

	
	$sql1 = "Select * from mushroom_admin where Username = '$user' and Password = '$pass'";
	$exist = $db->checkExist($sql1) or die(mysql_error());
	$check = $db->get_rows($exist);
	
	if($check){
		$_SESSION['User'] = $user;
		echo "admin";		
	}
	else{
		$sql = "Select * from mushroom_users where user_username = '$user' and user_password ='$pass'";
		$exist2 = $db->checkExist($sql) or die(mysql_error());
		$check2 = $db->get_rows($exist2);
			if($check2>=1){
				$_SESSION['User'] = $user;
				echo "user";		
			}
			else{
				echo "Invalid username or password";
			}
	}
?>