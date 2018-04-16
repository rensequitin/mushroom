	<?php
		session_start();
		include('php/db_backup_library.php');
		$link1 = mysql_connect('localhost', 'root', '');
		$sql1 = 'DROP DATABASE mushroomsisigdb';
		mysql_query($sql1, $link1);
			
		
		$dbbackup = new db_backup;
		create:
		$sql = $dbbackup->connect("localhost","root","","mushroomsisigdb");
		if($sql){
			$dbbackup->backup();
			if($dbbackup->db_import("restore/mushroomsisigdb.sql")){
				$_SESSION['Alert']="import";
				echo "Success";
				header('location:backup-restore.php');exit;
			}
		}
		else{
			//echo "Cant find database";
			$link = mysql_connect('localhost', 'root', '');
			$sql = 'CREATE DATABASE mushroomsisigdb';
				if (mysql_query($sql, $link)) {
					goto create;
					//echo "Database my_db created successfully\n";
				} else {
					echo 'Error creating database: ' . mysql_error() . "\n";
				}
		}
	?>
	