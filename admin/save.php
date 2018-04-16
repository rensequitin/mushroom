	<?php
		include('php/db_backup_library.php');
		session_start();
		date_default_timezone_set('Asia/Manila');
		echo $date = date("m-d-y");
		echo "*".$time = date("h-iA");
		$secs = time();
		$dbbackup = new db_backup;
		$name = "mushroomsisigdb($date  $time)";
		$sql = $dbbackup->connect("localhost","root","","mushroomsisigdb");
		if($sql){
			$dbbackup->backup();		
			if($dbbackup->save("files/","$name")){
				$_SESSION['Alert']="save";
				echo "Backup Saved Successfully";
				header('location:backup-restore.php');exit;
			}
		}
		else{
			echo "No database found";
		}
	?>
	