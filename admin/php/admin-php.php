<?php
	require __DIR__ . '/../autoload.php';
	use Mike42\Escpos\Printer;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	use Mike42\Escpos\PrintConnectors\FilePrintConnector;
	use Mike42\Escpos\EscposImage;
	require_once("class.database.php");

	$db = MushroomDB::getInstance();


	$action = $_GET['action'];

	$action($db);

	function uploadToFolderCloud($db){
		$data = $_GET['data'];
		echo $data;
		$from = "../files/".$data;
		$to = "../cloud/".$data;
		if(copy($from, $to)){

		}

	}

	function uploadToFolderRestore($db){
		$data = $_GET['data'];
		echo $data;
		$from = "../files/".$data;
		$to = "../restore/mushroomsisigdb.sql";
		copy($from, $to);
	}

	function restoreDatabase($db){
		$name = $_GET['name'];

		include('db_backup_library.php');
		$link1 = mysql_connect('localhost', 'root', '');
		$sql1 = 'DROP DATABASE mushroomsisigdb';
		mysql_query($sql1, $link1);


		$dbbackup = new db_backup;
		create:
		$sql = $dbbackup->connect("localhost","root","","mushroomsisigdb");
		if($sql){
			//$dbbackup->backup();
			if($dbbackup->db_import("../restore/mushroomsisigdb.sql")){
				$_SESSION['Alert']="import";
				echo "Success";
				unlink('../restore/mushroomsisigdb.sql');
				header('location:backup-restore.php');exit;
			}
		}
		else{

			$link = mysql_connect('localhost', 'root', '');
			$sql = 'CREATE DATABASE mushroomsisigdb';
				if (mysql_query($sql, $link)) {
					goto create;

				} else {
					echo 'Error creating database: ' . mysql_error() . "\n";
				}
		}
	}

	function sendToCloud(){

		$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$url = $url_array[0];

		require_once 'google-api-php-client/src/Google_Client.php';
		require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
		$client = new Google_Client();
		$client->setClientId('176349010523-sltn4d89kj8998u3rj8glabgl8mq1luu.apps.googleusercontent.com');
		$client->setClientSecret('XQIORa7BS2UbCEUvXEX8Tn6z');
		$client->setRedirectUri($url);
		$client->setScopes(array('https://www.googleapis.com/auth/drive'));
		if (isset($_GET['code'])) {
			$_SESSION['accessToken'] = $client->authenticate($_GET['code']);
			header('location:'.$url);exit;
		} elseif (!isset($_SESSION['accessToken'])) {
			$client->authenticate();
		}
		$files= array();
		$dir = dir('../cloud');
		while ($file = $dir->read()) {
			if ($file != '.' && $file != '..') {
				$files[] = $file;
			}
		}
		$dir->close();
		if (!$_POST) {
			echo "a";
			$_SESSION['Alert'] = "send";
			$client->setAccessToken($_SESSION['accessToken']);
			$service = new Google_DriveService($client);
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$file = new Google_DriveFile();
			foreach ($files as $file_name) {
				$file_path = 'cloud/'.$file_name;
				$mime_type = finfo_file($finfo, $file_path);
				$file->setTitle($file_name);
				$file->setDescription('This is a '.$mime_type.' document');
				$file->setMimeType($mime_type);
				$service->files->insert(
					$file,
					array(
						'data' => file_get_contents($file_path),
						'mimeType' => $mime_type
					)

				);
				$name = $_GET['name'];
				$link = '../cloud/'.$name;
				unlink($link);

				exit;
			}
			finfo_close($finfo);
			header('location:'.$url);exit;
		}

	}

	function uploadDatabase($db){
		//header('Content-Type: text/plain; charset=utf-8');

		//$code = $_GET['code'];
		//$user = $_SESSION['User'];

		$sql_name = $_FILES['myfile']['name'];
		$tmp_name = $_FILES['myfile']['tmp_name'];
		$file_size = $_FILES['myfile']['size'];
		$file_error = $_FILES['myfile']['error'];
		$file_type = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
		if($sql_name){
			if($file_type=='sql'){
				$location="../files/$sql_name";
				move_uploaded_file($tmp_name,$location);
				echo "success";
				$_SESSION['Alert'] = "add";
				/* if($file_size>0 && $file_size<=2148000){
					$location="profile/$pic_name";
					$location2="../profile/$pic_name";

					$sql = "UPDATE mushroom_admin SET admin_picture ='$location' WHERE admin_username ='$user'";
					$exist = $db->checkExist($sql) or die(mysql_error());
						if($exist){
							move_uploaded_file($tmp_name,$location2);
							echo "success";
						}
						else{
							echo "Invalid data";
						}
				}
				else{
					echo "The maximum size for file upload is 2.0mb";
				} */
			}
			else{
				echo "Invalid file type";
			}
		}
		else{
			echo $sql_name;
			//echo "Please select a file!";
		}

	}

	function deleteFile($db){
		$_SESSION['Alert'] = "del";
		$data = $_GET['data'];
		$link = "../files/".$data;
		unlink($link);
	}
	function viewDeliveryTableByCode($db){
		$val = $_GET['val'];
		$sql = "";

		if($val==""){
			$sql = "Select * from mushroom_delivery where delivery_status='Pending' order by delivery_seconds desc";
		}
		else{
			$sql = "Select * from mushroom_delivery where delivery_status='Pending' AND delivery_code ='$val' order by delivery_seconds desc";
		}

		viewTable($db,$sql);
	}

	/* function viewDeliveryTable($db){
		$val = $_GET['val'];
		$sql = "";
		if($val=="all"){
			$sql = "Select * from mushroom_delivery where delivery_status='Pending' order by delivery_seconds desc";
		}
		else{
			$sql = "Select * from mushroom_delivery where delivery_status='Pending' AND delivery_read ='$val' order by delivery_seconds desc";
		}

		viewTable($db,$sql);
	}	 */

	/* function viewTable($db,$sql){
			$sql = $sql;
			$count = 0;
			$div = 0;
			$class = "";
			$exist = $db->checkExist($sql) or die(mysql_error());
			$rows = $db->get_rows($exist);
			if($rows>=1){
				while($row = $db->fetch_array($exist)){
					if($count==0){
						$div++;
						$db->set_divCount($div);
					}
					$count++;
					if($div==1){
						$class='active';
						$db->set_className($class);
					}
					else{
						$class='';
						$db->set_className($class);
					}
					$db->set_deliveryCode($row['delivery_code']);
					$db->set_deliveryCustomer($row['delivery_customer']);
					$db->set_deliveryContact($row['delivery_contact']);
					$db->set_deliveryDate($row['delivery_date']);
					$db->set_deliveryTime($row['delivery_time']);
					$db->set_deliveryAddress($row['delivery_address']);
					$db->set_deliveryRead($row['delivery_read']);

					$db->view_delivery_table();
					if($count==4){
						$count = 0;
					}
				}
				$db->view_button_numbers();

			}
			else{
				echo "<h3 style='font-family:Avenir; position:absolute; top:85px; left:430px;'>NO RECORD FOUND</h3>*";
				echo "<label class='active' id='active' style='height:23px; width:30px; margin-left:2px; border:solid 1.5pt #5cb85c; cursor:pointer; padding-left:6.5px; padding-right:6.5px;'> 1 </label>";
			}
	} */


	/* function viewTableOrders($db){
		$count = 0;
		$div = 0;
		$class = "";
		$val = $_GET['val'];
		$sql = "Update mushroom_delivery set delivery_read = 'Seen' where delivery_code ='$val'";
		$exist = $db->checkExist($sql) or die(mysql_error());
			if($exist){
				$total = 0;
				$sql1 = "Select * from mushroom_orders where delivery_code ='$val'";
				$exist1 = $db->checkExist($sql1) or die(mysql_error());
					while($row = $db->fetch_array($exist1)){
						if($count==0){
							$div++;
							$db->set_divCount($div);
						}
						$count++;
						if($div==1){
							$class='active';
							$db->set_className($class);
						}
						else{
							$class='';
							$db->set_className($class);
						}
						$db->set_foodName($row['order_foods']);
						$db->set_foodQuantity($row['order_quantity']);
						$db->set_foodPrice($row['order_price']);
						$db->set_foodSubtotal($row['order_subtotal']);
						$db->compute_bill();
						$db->view_orders();
						if($count==4){
							$count = 0;
						}
					}
					$db->view_orders_amount();
					$db->view_orders_button($val);
			}
	} */

	function deliverOrder($db){
		$val = $_GET['val'];
		$codeVal = $_GET['code'];
			$sql = "Update mushroom_delivery set delivery_status = 'Completed', delivery_served = 'Sana' where delivery_code ='$codeVal'";
			$exist = $db->checkExist($sql) or die(mysql_error());
				if($exist){
					echo ("Success");
				}
	}

	function viewDate($db){
		date_default_timezone_set('Asia/Manila');
		echo date("h:iA")."*";
		//echo "Sun, 12/10/2017";
		echo date("D, m/d/Y");
	}
	function viewDateIndex($db){
		date_default_timezone_set('Asia/Manila');
		echo date("l, d M Y, h:i A");
	}


	function viewSales($db){
		date_default_timezone_set('Asia/Manila');
		$today =  date("F d, Y");
		$total = 0;
		$sql = "SELECT * from mushroom_delivery WHERE delivery_status ='Completed' AND delivery_archive = 'No' AND delivery_date = '$today'";
		$exist = $db->checkExist($sql);
		$num_rows = $db->get_rows($exist);
			if($num_rows>=1){

				while($row = $db->fetch_array($exist)){

					$code = $row['delivery_code'];
					$sql1 = "SELECT * from mushroom_orders WHERE delivery_code ='$code'";
					$exist1 = $db->checkExist($sql1);
						if($exist1){
							while($rows = $db->fetch_array($exist1)){
								$subtotal = $rows['order_subtotal'];
								$db->set_sales_subtotal($subtotal);
								$total = $db->compute_sales();

							}
						}
						else{
							echo "0";
						}

				}
				echo "<html>&#8369</html>".$total;
			}
			else{
				echo '0';
			}
	}

	function viewMessage($db){
		$count = 0;
		$div = 0;
		$class = "";
		$sql = "SELECT * from mushroom_delivery where delivery_status ='Pending' order by delivery_seconds desc" or die(mysql_error());
		$exist = $db->checkExist($sql);

		if($exist){
			while($row = $db->fetch_array($exist)){
					$total = 0;
					if($count==0){
						$div++;
						$db->set_divCount($div);
					}
					$count++;
					if($div==1){
						$class='active';
						$db->set_className($class);
					}
					else{
						$class='';
						$db->set_className($class);
					}

					$username = $row['delivery_username'];
					//$db->set_orderTime($row['delivery_seconds']);
					$sql1 = "SELECT * from mushroom_users where user_username = '$username'";
					$exist1 = $db->checkExist($sql1);
						if($exist1){
							$row1 = $db->fetch_array($exist1);
							$db->set_user_image($row1['user_picture']);
							$db->set_user_address($row1['user_address']." ".$row1['user_province']." ".$row1['user_city']);
						}

					$code = $row['delivery_code'];
					$orders = 0;
					$sqli = "SELECT * from mushroom_orders where delivery_code = '$code'";
					$exists = $db->checkExist($sqli) or die(mysql_error());
						if($exists){
							while($rows = $db->fetch_array($exists)){
								$total += $rows['order_quantity'];
							}
						}
					//$num = $db->get_rows($exist3);
					//$stat = $row['delivery_status'];

					/* $db->set_deliveryCode($row['delivery_code']);
					$db->set_deliveryCustomer($row['delivery_customer']);
					$db->set_deliveryContact($row['delivery_contact']);
					$db->set_deliveryDate($row['delivery_date']);
					$db->set_deliveryTime($row['delivery_time']);
					$db->set_deliveryServed($row['delivery_served']);
					$db->set_deliveryRead($row['delivery_read']); */
					$db->set_orderTime($row['delivery_seconds']);
					$db->view_message($total);
					if($count==4){
						$count = 0;
					}
				}
			$sql2 = "SELECT * from mushroom_delivery where delivery_status ='Pending'";
				$exist2 = $db->checkExist($sql2);
				$unread = $db->get_rows($exist2);
				echo"*$unread";
				$read="";
				if($unread>1){
					$read = "You have {$unread} unread order";
				}
				else{
					$read = "You have {$unread} unread orders";
				}
				echo "*$read";
		}
	}

	function login($db){
		$user = $_GET['username'];
		$pass = md5($_GET['password']);
		$db->set_user($user);
		$db->set_pass($pass);

			$sql = "Select * from mushroom_admin where admin_username = '$user' and admin_password = '$pass'";
			$exist = $db->checkExist($sql) or die(mysql_error());
			$check = $db->get_rows($exist);
				if($check>=1){
					$_SESSION['Admin'] = $user;
					$activity = "Admin logged in";
					$db->activity_log($activity);
					echo "user";
				}
				else{
					echo "Invalid username or password";
				}
	}

	function logout($db){
		$activity = "Admin logged out";
		$db->activity_log($activity);
		unset($_SESSION['Admin']);
	}

	function viewOrders($db){
		date_default_timezone_set('Asia/Manila');
		$today =  date("F d, Y");
		$sql = "SELECT * from mushroom_delivery WHERE delivery_status='Completed' AND delivery_archive = 'No' AND delivery_date = '$today'";
		$exist = $db->checkExist($sql);
		echo $num_rows = $db->get_rows($exist);
	}

	function viewCompletedOrders($db){

		$sql = "Select * from mushroom_delivery where delivery_status='Completed' and delivery_archive ='No' order by delivery_seconds DESC";
		$exist = $db->checkExist($sql);
		$count = 0;
		$text = "";
		$addText = "";
		if($exist){
			$rows = $db->get_rows($exist);
			if($rows>=1){
				while($row = $db->fetch_array($exist)){
					$count = 0;
					$text = "";
					$addText = "";
					$delivCode = $row['delivery_code'];
					$db->set_deliveryCode($delivCode);
					$db->set_deliveryType($row['delivery_type']);
					$db->set_deliveryCustomer($row['delivery_customer']);
					$db->set_deliveryContact($row['delivery_contact']);
					$db->set_deliveryDate($row['delivery_date']);
					$db->set_deliveryTime($row['delivery_time']);
					$secs = $row['delivery_seconds'];
					$db->set_orderTime($secs);
					$db->set_deliveryServed($row['delivery_served']);
					//$db->set_deliveryRead($row['delivery_read']);
					$sql2 = "Select * from mushroom_orders where delivery_code='$delivCode'";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = $db->fetch_array($exist2)){
							$foodOrder = $row2['order_foods'];
							$qty = $row2['order_quantity'];
							if($count>0){
								$addText = ', ';
							}
							else{
								$addText='';
							}
							$text .= $addText."{$qty}x ".$foodOrder;
							$count++;
						}
					}
					if(strlen($text)>30){
						$text = substr($text,0,30);
						$text = $text."...";
					}

					$db->view_completed_orders($text);

				}


			}
			else{
				echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
			}
		}
		else{
			echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
		}

	}

	function viewReservation($db){

		$sql = "Select * from mushroom_reservation order by reserve_seconds DESC";
		$exist = $db->checkExist($sql);
		$count = 0;
		$text = "";
		$addText = "";
		if($exist){
			$rows = $db->get_rows($exist);
			if($rows>=1){
				while($row = $db->fetch_array($exist)){
					$delivCode = $row['reserve_code'];
					$db->set_deliveryCode($delivCode);
					$db->set_deliveryType('Dine-in');
					$db->set_deliveryCustomer($row['reserve_customer']);
					$db->set_deliveryContact($row['reserve_contact']);
					$db->set_deliveryUsername($row['reserve_username']);
					$secs = $row['reserve_seconds'];
					$db->set_orderTime($secs);
					date_default_timezone_set('Asia/Manila');
					$seconds = $secs;
					$delivery_date = date("h:i A", $seconds);
					$db->set_deliveryTime($delivery_date);

					$count = 0;
					$text = "";
					$addText = "";

					$sql2 = "Select * from mushroom_reservation_orders where reserve_code='$delivCode'";
					$exist2 = $db->checkExist($sql2) or die(mysql_error());
					if($exist2){
						while($row2 = $db->fetch_array($exist2)){
							$foodOrder = $row2['reserve_orders_foods'];
							$qty = $row2['reserve_orders_quantity'];
							if($count>0){
								$addText = ', ';
							}
							else{
								$addText='';
							}
							$text .= $addText."{$qty}x ".$foodOrder;
							$count++;
						}
					}
					if(strlen($text)>45){
						$text = substr($text,0,45);
						$text = $text."...";
					}

					$db->view_reserve_orders($text);

				}


			}
			else{
				echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
			}
		}
		else{
			echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
		}

	}

	function viewSalesReport($db){
		$salesStart = $_GET['salesStart'];
		$salesEnd = $_GET['salesEnd'];
		$category = $_GET['category'];
		$_SESSION['salesStart'] = $salesStart;
		$_SESSION['salesEnd'] = $salesEnd;
		$_SESSION['category'] = $category;
		$sql = "";
		if($category=="All"){
			$sql = "Select * from mushroom_delivery where delivery_sales_date >= '$salesStart' AND delivery_sales_date <= '$salesEnd' and delivery_status = 'Completed' and delivery_archive='No' order by delivery_seconds asc";
		}
		else{
			$sql = "Select * from mushroom_delivery where delivery_sales_date >= '$salesStart' AND delivery_sales_date <= '$salesEnd' and delivery_status = 'Completed' and delivery_archive='No' and delivery_type='$category' order by delivery_seconds asc";
		}

		$exist = $db->checkExist($sql);

		if($exist){
			$rows = $db->get_rows($exist);
			if($rows>=1){
				$fee = 0;
				while($row = $db->fetch_array($exist)){
					$ctr =0;
					//$val = array($row['delivery_date'],$row['delivery_code'],$row['delivery_type']);
					$val = array($row['delivery_code'],$row['delivery_type']);
					$quantity = 0;
					$subtotal = 0;

					$code = $row['delivery_code'];
					$sql2 = "Select * from mushroom_orders where delivery_code = '$code'";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = mysql_fetch_array($exist2)){
							$qty = $row2['order_quantity'];
							$qty = floatval(str_replace(",","",$qty));
							$totals =$row2['order_subtotal'];
							$totals = floatval(str_replace(",","",$totals));
							$quantity += $qty;
							$subtotal += $totals;
						}
						$subtotal = number_format($subtotal,"2");
						array_push($val,$quantity,$subtotal);
						$data = $val;

						echo "<tr>";
						foreach ($data as $value) {
						  echo "<td>$value</td>";
						  $ctr++;

							if($ctr==4){
								//$fees = $row[4];
								$value = floatval(str_replace(",","",$value));
								$fee += $value;
								$ctr =0;
							}
						}
						echo "</tr>";

					}

				}
				$fee = number_format($fee,"2");
				echo "*".$fee;

			}
			else{
				echo "<td colspan='12' align='center'>NO RECORD FOUND</td>";
				echo "*0.00";
			}
		}
		else{
			echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
		}

	}


	function viewSummaryReport($db){
		$salesStart = $_GET['salesStart'];
		$salesEnd = $_GET['salesEnd'];
		$_SESSION['salesStart'] = $salesStart;
		$_SESSION['salesEnd'] = $salesEnd;

	//	$sql = "Select * from mushroom_summary where summary_date >= '$salesStart' AND summary_date <= '$salesEnd' order by summary_quantity DESC";

		$sql = "Select *,CAST(summary_quantity as SIGNED) AS casted_column from mushroom_summary where summary_date >= '$salesStart' AND summary_date <= '$salesEnd' order by casted_column DESC";

		$exist = $db->checkExist($sql);

		if($exist){
			$rows = $db->get_rows($exist);
			if($rows>=1){
				$fee = 0;
				while($row = $db->fetch_array($exist)){
					$ctr =0;
					//$val = array($row['delivery_date'],$row['delivery_code'],$row['delivery_type']);
					$val = array($row['summary_foods'],$row['summary_quantity']);
					$data = $val;
					$quantity = 0;
					$subtotal = 0;
						echo "<tr>";
						//$style = "text-align:left;padding-left:135px;";
						foreach ($data as $value) {
						  echo "<td>$value</td>";
						 // $style = "text-align:right;padding-right:135px;";
						  $ctr++;

							if($ctr==2){
								//$fees = $row[4];
								//$value = floatval(str_replace(",","",$value));
								//$fee += $value;
								$ctr =0;
							}
						}
					/* $code = $row['delivery_code'];
					$sql2 = "Select * from mushroom_orders where delivery_code = '$code'";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = mysql_fetch_array($exist2)){
							$qty = $row2['order_quantity'];
							$qty = floatval(str_replace(",","",$qty));
							$totals =$row2['order_subtotal'];
							$totals = floatval(str_replace(",","",$totals));
							$quantity += $qty;
							$subtotal += $totals;
						}
						$subtotal = number_format($subtotal,"2");
						array_push($val,$quantity,$subtotal);
						$data = $val;

						echo "<tr>";
						foreach ($data as $value) {
						  echo "<td>$value</td>";
						  $ctr++;

							if($ctr==2){
								//$fees = $row[4];
								//$value = floatval(str_replace(",","",$value));
								//$fee += $value;
								$ctr =0;
							}
						}
						echo "</tr>";

					} */

				}

				$fee = number_format($fee,"2");
				echo "*".$fee;

			}
			else{
				echo "<td colspan='12' align='center'>NO RECORD FOUND</td>";
				echo "*0.00";
			}
		}
		else{
			echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
		}

	}

	/* function viewDatabase($db){
		$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$url = $url_array[0];

		require_once 'google-api-php-client/src/Google_Client.php';
		require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
		$client = new Google_Client();
		$client->setClientId('1018968559657-jpdr3i1va1tlfmms5d3pdhvmdscvq4ig.apps.googleusercontent.com');
		$client->setClientSecret('KT_-2-spAQVwWeMAkm7DBqQm');
		$client->setRedirectUri($url);
		$client->setScopes(array('https://www.googleapis.com/auth/drive'));
		if (isset($_GET['code'])) {
			$_SESSION['accessToken'] = $client->authenticate($_GET['code']);
			header('location:'.$url);exit;
		} elseif (!isset($_SESSION['accessToken'])) {
			$client->authenticate();
		}
		$files= array();
		$dir = dir('files');
		while ($file = $dir->read()) {
			if ($file != '.' && $file != '..') {
				$files[] = $file;
			}
		}
		$dir->close();
		if (!empty($_POST)) {
			$client->setAccessToken($_SESSION['accessToken']);
			$service = new Google_DriveService($client);
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$file = new Google_DriveFile();
			foreach ($files as $file_name) {
				$file_path = 'files/'.$file_name;
				$mime_type = finfo_file($finfo, $file_path);
				$file->setTitle($file_name);
				$file->setDescription('This is a '.$mime_type.' document');
				$file->setMimeType($mime_type);
				$service->files->insert(
					$file,
					array(
						'data' => file_get_contents($file_path),
						'mimeType' => $mime_type
					)
				);
			}
			finfo_close($finfo);
			header('location:'.$url);exit;
		}
	} */

	function viewAlert($db){
		if(isset($_SESSION['Alert'])){
			if($_SESSION['Alert']=="save"){
				echo "save";
			}
			else if($_SESSION['Alert']=="import"){
				echo "import";
			}
			else if($_SESSION['Alert']=="del"){
				echo "del";
			}
			else if($_SESSION['Alert']=="add"){
				echo "add";
			}
			else{
				echo "send";
			}
			unset($_SESSION['Alert']);
		}
		else{

		}
	}

	function viewCompletedArchive($db){

		$sql = "Select * from mushroom_delivery where delivery_status='Completed' and delivery_archive ='Yes' order by delivery_seconds DESC";
		$exist = $db->checkExist($sql);
		$count = 0;
		$text = "";
		$addText = "";
		if($exist){
			$rows = $db->get_rows($exist);
			if($rows>=1){
				while($row = $db->fetch_array($exist)){
					$count = 0;
					$text = "";
					$addText = "";
					$delivCode = $row['delivery_code'];
					$db->set_deliveryCode($delivCode);
					$db->set_deliveryType($row['delivery_type']);
					$db->set_deliveryCustomer($row['delivery_customer']);
					$db->set_deliveryContact($row['delivery_contact']);
					$db->set_deliveryDate($row['delivery_date']);
					$db->set_deliveryTime($row['delivery_time']);
					$secs = $row['delivery_seconds'];
					$db->set_orderTime($secs);
					$db->set_deliveryServed($row['delivery_served']);
					//$db->set_deliveryRead($row['delivery_read']);
					$sql2 = "Select * from mushroom_orders where delivery_code='$delivCode'";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = $db->fetch_array($exist2)){
							$foodOrder = $row2['order_foods'];
							$qty = $row2['order_quantity'];
							if($count>0){
								$addText = ', ';
							}
							else{
								$addText='';
							}
							$text .= $addText."{$qty}x ".$foodOrder;
							$count++;
						}
					}
					if(strlen($text)>30){
						$text = substr($text,0,30);
						$text = $text."...";
					}

					$db->view_completed_archive($text);

				}


			}
			else{
				echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
			}
		}
		else{
			echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
		}

	}

	function viewPendingOrders($db){
		/* $val = $_GET['val'];
		$sql = "";

		if($val==""){
			$sql = "Select * from mushroom_delivery where delivery_status='Pending' order by delivery_seconds desc";
		}
		else{
			$sql = "Select * from mushroom_delivery where delivery_status='Pending' AND delivery_code ='$val' order by delivery_seconds desc";
		} */
		$sql = "Select * from mushroom_delivery where delivery_status='Pending' and delivery_archive ='No' order by delivery_seconds ASC";
		$exist = $db->checkExist($sql);
		$count = 0;
		$text = "";
		$addText = "";
		if($exist){
			$rows = $db->get_rows($exist);
			if($rows>=1){
				while($row = $db->fetch_array($exist)){
					$count = 0;
					$text = "";
					$addText = "";
					$delivCode = $row['delivery_code'];
					$db->set_deliveryCode($delivCode);
					$db->set_deliveryType($row['delivery_type']);
					$db->set_deliveryCustomer($row['delivery_customer']);
					$db->set_deliveryContact($row['delivery_contact']);
					$db->set_deliveryDate($row['delivery_date']);
					$db->set_deliveryTime($row['delivery_time']);
					$secs = $row['delivery_seconds'];
					$db->set_orderTime($secs);
					$db->set_deliveryServed($row['delivery_served']);
					//$db->set_deliveryRead($row['delivery_read']);
					$sql2 = "Select * from mushroom_orders where delivery_code='$delivCode'";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = $db->fetch_array($exist2)){
							$foodOrder = $row2['order_foods'];
							$qty = $row2['order_quantity'];
							if($count>0){
								$addText = ', ';
							}
							else{
								$addText='';
							}
							$text .= $addText."{$qty}x ".$foodOrder;
							$count++;
						}
					}
					if(strlen($text)>30){
						$text = substr($text,0,30);
						$text = $text."...";
					}

					$db->view_pending_orders($text);

				}


			}
			else{
				echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
			}
		}
		else{
			echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
		}

	}

	/* function viewReservation($db){
		$sql = "Select * from mushroom_reservation order by reserve_seconds DESC";
		$exist = $db->checkExist($sql) or die(mysql_error());
		$count = 0;
		$text = "";
		$addText = "";
		if($exist){
			$rows = $db->get_rows($exist);
			if($rows>=1){
				while($row = $db->fetch_array($exist)){
					$count = 0;
					$text = "";
					$addText = "";
					$delivCode = $row['reserve_code'];
					$db->set_deliveryCode($delivCode);
					$db->set_deliveryCustomer($row['reserve_customer']);
					$db->set_deliveryContact($row['reserve_contact']);
					$db->set_deliveryUsername($row['reserve_username']);
					$secs = $row['reserve_seconds'];
					$db->set_orderTime($secs);
					date_default_timezone_set('Asia/Manila');
					$seconds = $secs;
					$delivery_date = date("h:i A", $seconds);
					$db->set_deliveryTime($delivery_date);

					$sql2 = "Select * from mushroom_reservation_orders where delivery_code='$delivCode'";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = $db->fetch_array($exist2)){
							$foodOrder = $row2['reserve_order_foods'];
							$qty = $row2['reserve_order_quantity'];
							if($count>0){
								$addText = ', ';
							}
							else{
								$addText='';
							}
							$text .= $addText."{$qty}x ".$foodOrder;
							$count++;
						}
					}
					if(strlen($text)>30){
						$text = substr($text,0,30);
						$text = $text."...";
					}

					$db->view_reserve_orders($text);

				}


			}
			else{
				echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
			}
		}
		else{
			echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
		}

	} */

	function reviewPendingOrders($db){
		$code = $_GET['code'];
		$total_price = 0;
		$sql = "Select * from mushroom_delivery where delivery_code='$code'";
		$exist = $db->checkExist($sql);

		if($exist){

			$rows = $db->get_rows($exist);
			if($rows>=1){
				$row4 = $db->fetch_array($exist);
				$type = $row4['delivery_type'];
				echo $type."*";
				mysql_data_seek( $exist, 0 );
				while($row = $db->fetch_array($exist)){
					$sql2 = "Select * from mushroom_orders where delivery_code='$code'";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = $db->fetch_array($exist2)){
							$food_price = $row2['order_price'];
							//$subtotal = (float)$food_price * (float)$row2['order_quantity'];
							$subtotal = $row2['order_subtotal'];
							$db->set_foodName($row2['order_foods']);
							//$food_price =$food_price;
							$db->set_foodQuantity($row2['order_quantity']);
							$db->set_foodPrice(number_format($food_price,"2"));
							//$subtotal =$subtotal;
							$db->set_foodSubtotal(number_format($subtotal,"2"));
							$total_price += $subtotal;

							$db->show_reviewTable();
						}
					}
					echo "*".$code;
					echo "* ".$row['delivery_date'];
					echo "*".number_format($total_price,"2");
					echo "*".$row['delivery_customer'];
					echo "*".$row['delivery_address'];
					echo "*".$row['delivery_contact'];
					echo "*".$row['delivery_type'];
					//$change = ((double)$payment - (double)$total_price);
					//$change = number_format($change,"2");
					//echo "*".$change;


					//$db->view_pending_orders($text);

				}


			}

		}

	}

	function viewReservationOrders($db){
		$code = $_GET['code'];
		$total_price = 0;
		$sql = "Select * from mushroom_reservation where reserve_code='$code'";
		$exist = $db->checkExist($sql);

		if($exist){

			$rows = $db->get_rows($exist);
			if($rows>=1){
				$row4 = $db->fetch_array($exist);
				/* $type = $row4['delivery_type'];
				echo $type."*";		 */
				mysql_data_seek( $exist, 0 );
				while($row = $db->fetch_array($exist)){
					$sql2 = "Select * from mushroom_reservation_orders where reserve_code='$code'";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = $db->fetch_array($exist2)){
							$food_price = $row2['reserve_orders_price'];
							//$subtotal = (float)$food_price * (float)$row2['order_quantity'];
							$subtotal = $row2['reserve_orders_subtotal'];
							$db->set_foodName($row2['reserve_orders_foods']);
							//$food_price =$food_price;
							$db->set_foodQuantity($row2['reserve_orders_quantity']);
							$db->set_foodPrice(number_format($food_price,"2"));
							//$subtotal =$subtotal;
							$db->set_foodSubtotal(number_format($subtotal,"2"));
							$total_price += $subtotal;

							$db->show_reviewTable();
						}
					}
					echo "*".$code;
					$secs = $row['reserve_seconds'];
					date_default_timezone_set('Asia/Manila');
					$delivery_date = date("F d, Y", $secs);

					//$delivery_date = date("F d, Y", $seconds);
					echo "* ".$delivery_date;
					echo "*".number_format($total_price,"2");
					/* echo "*".$row['delivery_customer'];
					echo "*".$row['delivery_address'];
					echo "*".$row['delivery_contact'];
					echo "*".$row['delivery_type']; */

				}


			}

		}

	}

	/* function viewReservationOrders($db){
		$code = $_GET['code'];
		$total_price = 0;
		$sql = "Select * from mushroom_reservation where reserve_code='$code'";
		$exist = $db->checkExist($sql);

		if($exist){

			$rows = $db->get_rows($exist);
			if($rows>=1){
				$row4 = $db->fetch_array($exist);

				mysql_data_seek( $exist, 0 );
				while($row = $db->fetch_array($exist)){
					$sql2 = "Select * from mushroom_reservation_orders where reserve_code='$code'";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = $db->fetch_array($exist2)){
							$food_price = $row2['reserve_orders_price'];
							//$subtotal = (float)$food_price * (float)$row2['order_quantity'];
							$subtotal = $row2['reserve_orders_subtotal'];
							$db->set_foodName($row2['reserve_orders_foods']);
							//$food_price =$food_price;
							$db->set_foodQuantity($row2['reserve_orders_quantity']);
							$db->set_foodPrice(number_format($food_price,"2"));
							//$subtotal =$subtotal;
							$db->set_foodSubtotal(number_format($subtotal,"2"));
							$total_price += $subtotal;

							$db->view_pending_orders($text);
							//$db->show_reviewTable();
						}
					}
					echo "*".$code;
					$seconds = time();
					$delivery_date = date("F d, Y", $seconds);
					echo "* ".$delivery_date;

				}


			}

		}

	} */

	function viewUsers($db){
		$sql = "SELECT * from mushroom_users";
		$exist = $db->checkExist($sql);
		echo $num_rows = $db->get_rows($exist);
	}

	function viewDeliveredOrder($db){
		$sql = "";
		$code = $_GET['code'];

		if($code==""){
			$sql = "Select * from mushroom_delivery where delivery_status='Delivered' order by delivery_seconds desc";
		}
		else{
			$sql = "Select * from mushroom_delivery where delivery_status='Delivered' AND delivery_code = '$code' order by delivery_seconds desc";
		}
		viewDeliveredTable($db,$sql);
	}

	/* function viewDeliveredTable($db,$sql){
		$sql = $sql;
		$count = 0;
		$div = 0;
		$class = "";
		$exist = $db->checkExist($sql) or die(mysql_error());
		$rows = $db->get_rows($exist);
			if($rows>=1){
				while($row = $db->fetch_array($exist)){
					if($count==0){
						$div++;
						$db->set_divCount($div);
					}
					$count++;
					if($div==1){
						$class='active';
						$db->set_className($class);
					}
					else{
						$class='';
						$db->set_className($class);
					}
					$db->set_deliveryCode($row['delivery_code']);
					$db->set_deliveryCustomer($row['delivery_customer']);
					$db->set_deliveryContact($row['delivery_contact']);
					$db->set_deliveryDate($row['delivery_date']);
					$db->set_deliveryTime($row['delivery_time']);
					$db->set_deliveryServed($row['delivery_served']);
					$db->set_deliveryRead($row['delivery_read']);

					$db->view_delivered_table();
					if($count==4){
						$count = 0;
					}
				}
				$db->view_button_numbers();

			}
			else{
				echo "<h3 style='font-family:Avenir; position:absolute; top:85px; left:430px;'>NO RECORD FOUND</h3>*";
				echo "<label class='active' id='active' style='height:23px; width:30px; margin-left:2px; border:solid 1.5pt #5cb85c; cursor:pointer; padding-left:6.5px; padding-right:6.5px;'> 1 </label>";
			}
	} */


	/* function viewProducts($db){
		$category = $_GET['category'];
		$status = $_GET['status'];
		$sql = "Select * from mushroom_foods where food_category = '$category' AND food_status = '$status' order by food_time ASC";
		$count = 0;
		$div = 0;
		$class = "";
		$exist = $db->checkExist($sql) or die(mysql_error());
		$rows = $db->get_rows($exist);
			if($rows>=1){
				while($row = $db->fetch_array($exist)){
					if($count==0){
						$div++;
						$db->set_divCount($div);
					}
					$count++;
					if($div==1){
						$class='active';
						$db->set_className($class);
					}
					else{
						$class='';
						$db->set_className($class);
					}

					$db->set_productPic($row['food_image']);
					$db->set_productCode($row['food_code']);
					$db->set_productName($row['food_name']);
					$db->set_productPrice($row['food_price']);
					$db->set_productStatus($row['food_status']);

					$db->view_products_table();
					if($count==4){
						$count = 0;
					}
				}
				//$db->view_button_numbers();

			}
			else{
				echo "<h3 style='font-family:Avenir; position:absolute; top:85px; left:430px;'>NO RECORD FOUND</h3>*";
				echo "<label class='active' id='active' style='height:23px; width:30px; margin-left:2px; border:solid 1.5pt #5cb85c; cursor:pointer; padding-left:6.5px; padding-right:6.5px;'> 1 </label>";
			}
	} */

	function addToCart($db){
		$food = $_GET['food_code'];
		$quantity = $_GET['quantity'];
		if(isset($_SESSION['OrderType'])){
			if(isset($_SESSION['POSCart'])){
				$val = 0;
				foreach ($_SESSION['POSCart'] as $cart => $items) {

					if($cart==$food){
						$_SESSION['POSCart'][$food] = $_SESSION['POSCart'][$food]+ $quantity;
						$val = 1;
					}
				}

				if(!$val){
				$add = array($food => $quantity);
				$_SESSION['POSCart']+= $add;

				}
			}
			else{
				$_SESSION['POSCart']= array($food => $quantity);
			}
			echo "success";
		}
		else{
			echo "error";
		}

	}

	function updateName($db){
		echo $name = $_GET['name'];
		if($name==""){
			unset($_SESSION['Customer']);
		}
		else{
			$_SESSION['Customer'] = $name;
		}

	}

	function checkName($db){
		if(isset($_SESSION['Customer'])){
			echo $_SESSION['Customer'];
		}
		else{
			echo "";
		}
	}
	function checkCart($db){
		if(isset($_SESSION['POSCart'])){
			echo "set";
		}
		else{
			echo "unset";
		}
	}

	function updateProfile($db){
		$firstname = $_GET['firstname'];
		$lastname = $_GET['lastname'];
		$email = $_GET['email'];
		$username = $_GET['username'];
			if(isset($_SESSION['Admin'])){
				$account = $_SESSION['Admin'];
			}
		$sql = "Update mushroom_admin set admin_firstname ='$firstname', admin_lastname='$lastname',admin_email ='$email',admin_username='$username' where admin_username ='$account'";
		$check = $db->checkExist($sql);
			if($check){
				$_SESSION['Admin'] = $username;
			}
	}

	function deleteChkbox($db){
		$chk = $_POST['chk'];

		foreach($chk as $food){
			//echo $id." ";
			if(isset($_SESSION['POSCart'])){
				foreach ($_SESSION['POSCart'] as $cart => $items) {
					if($cart==$food){
						//if($quantity==0){
							 unset($_SESSION['POSCart'][$cart]);
							 echo "Successful";
						/* }
						else{
							$_SESSION['POSCart'][$food] = $quantity;
							$total += $_SESSION['POSCart'][$food];
						} */
					}

				}
				$array = 0;
				foreach ($_SESSION['POSCart'] as $cart => $items) {
					$array += $items;
				}
				if($array==0){
						unset($_SESSION['POSCart']);
				}
			}
		}

		/* $result=mysql_query("Delete from tblpractice3 where id ='$id'");
		//echo $id "<br/>";
		if($result){
			echo "ID #" .$id. " Deleted! <a href='main.php'><br/>Home</a>";
		}
		else{
			echo "Error";
		} */


	}

	function updateProduct($db){
		$food = $_GET['food_code'];
		$quantity = $_GET['quantity'];
		$total = 0;

		if(isset($_SESSION['POSCart'])){
			foreach ($_SESSION['POSCart'] as $cart => $items) {
				if($cart==$food){
					if($quantity==0){
						 unset($_SESSION['POSCart'][$cart]);
					}
					else{
						$_SESSION['POSCart'][$food] = $quantity;
						$total += $_SESSION['POSCart'][$food];
					}
				}
				else{
					$total += $items;
				}

			}
			$array = 0;
			foreach ($_SESSION['POSCart'] as $cart => $items) {
				$array += $items;
			}
			if($array==0){
					unset($_SESSION['POSCart']);
			}
		}
		echo $total;
	}

	function reviewOrder($db){
		$payment = $_GET['payment'];
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");

		if(isset($_SESSION['POSCart'])){
			generate5:
			$total_price = 0;
			$code = $db->generateCode();
			$sql = "Select * from mushroom_delivery where delivery_code = '$code'";
			$exist = $db->checkExist($sql);
			$check = $db->get_rows($exist);
				if($check>=1){
					goto generate5;
				}
				else{
					foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
						$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
						$exist1 = $db->checkExist($sql1);

						if($exist1){
							$row = $db->fetch_array($exist1);
							$food_price = $row['food_price'];
							$subtotal = (float)$food_price * (float)$cartItems;
							$db->set_foodName($row['food_name']);
							//$food_price =$food_price;
							$db->set_foodQuantity($cartItems);
							$db->set_foodPrice(number_format($food_price,"2"));
							//$subtotal =$subtotal;
							$db->set_foodSubtotal(number_format($subtotal,"2"));
							$total_price += $subtotal;

							$db->show_reviewTable();
						}
					}
					echo "*".$code;
					echo "*".$date;
					echo "*".number_format($total_price,"2");
					echo "*".number_format($payment,"2");
					$change = ((double)$payment - (double)$total_price);
					$change = number_format($change,"2");
					echo "*".$change;
				}

		}
	}

	function clearCart($db){
		unset($_SESSION['Customer']);
		unset($_SESSION['POSCart']);
		unset($_SESSION['OrderType']);
	}

	function viewPosProducts($db){
		$category = $_GET['category'];

		$sql = "Select * from mushroom_foods where food_category = '$category'and food_status='Active' and food_archive='No' order by food_time ASC";
		$count = 0;
		$div = 0;
		$class = "";
		$exist = $db->checkExist($sql) or die(mysql_error());
		$rows = $db->get_rows($exist);
			if($rows>=1){
				while($row = $db->fetch_array($exist)){

					$db->set_productPic($row['food_image']);
					$db->set_productCode($row['food_code']);
					$db->set_productName($row['food_name']);
					$db->set_productPrice($row['food_price']);
					$db->set_productStatus($row['food_status']);

					$db->view_pos_products_table();

				}

			}
			else{
				echo "<tr style='border-bottom:solid 1px #ccc;'>
						<td class='col-xs-3 col-md-2'></td><td class='col-xs-2'></td>
						<td class='col-xs-6' style='line-height:105px; '><strong id='prod-name'>NO DATA FOUND</strong></td>
						<td class='col-xs-2'></td><td class='col-xs-2'></td></tr>";

			}
	}

	function viewPosFood($db){
		$code = $_GET['code'];

		$sql = "Select * from mushroom_foods where food_code = '$code' order by food_time ASC";
		$count = 0;
		$div = 0;
		$class = "";
		$exist = $db->checkExist($sql) or die(mysql_error());
		$rows = $db->get_rows($exist);

			$row = $db->fetch_array($exist);

			echo "../".$row['food_image']."*";
			echo $row['food_name'];
	}

	function searchPosProducts($db){
		$category = $_GET['category'];
		$code = $_GET['code'];
		if($code!=""){
			$code=$code."%";
			$sql = "Select * from mushroom_foods where food_name LIKE '$code' order by food_time ASC";
		}
		else{
			$sql = "Select * from mushroom_foods where food_category = '$category' order by food_time ASC";
		}

		$count = 0;
		$div = 0;
		$class = "";
		$exist = $db->checkExist($sql);
		if($exist){
			$rows = $db->get_rows($exist);
			if($rows>=1){
				while($row = $db->fetch_array($exist)){
					if($count==0){
						$div++;
						$db->set_divCount($div);
					}
					$count++;
					if($div==1){
						$class='active';
						$db->set_className($class);
					}
					else{
						$class='';
						$db->set_className($class);
					}

					$db->set_productPic($row['food_image']);
					$db->set_productCode($row['food_code']);
					$db->set_productName($row['food_name']);
					$db->set_productPrice($row['food_price']);
					$db->set_productStatus($row['food_status']);

					$db->view_pos_products_table();
					if($count==4){
						$count = 0;
					}
				}
			}
			else{
				echo "<tr style='border-bottom:solid 1px #ccc;'>
						<td class='col-xs-3 col-md-2'></td><td class='col-xs-2'></td>
						<td class='col-xs-6' style='line-height:105px; '><strong id='prod-name'>NO DATA FOUND</strong></td>
						<td class='col-xs-2'></td><td class='col-xs-2'></td></tr>";
			}
		}
		else{
			echo "<tr style='border-bottom:solid 1px #ccc;'>
						<td class='col-xs-3 col-md-2'></td><td class='col-xs-2'></td>
						<td class='col-xs-6' style='line-height:105px; '><strong id='prod-name'>NO DATA FOUND</strong></td>
						<td class='col-xs-2'></td><td class='col-xs-2'></td></tr>";
		}

	}

	function searchQueue($db){
		$code = $_GET['code'];
		$code=$code."%";
		$sql = "Select * from mushroom_queue where queue_code LIKE '$code'";
		$exist = $db->checkExist($sql);
		if($exist){
			$check = $db->get_rows($exist);
			if($check>=1){
				while($row = $db->fetch_array($exist)){
						$code = $row['queue_code'];
						$type = $row['queue_type'];
						$table = $row['queue_table'];
						$secs = $row['queue_seconds'];
						date_default_timezone_set('Asia/Manila');
						$date = date("l <\b\\r> M. d, Y, h:i A", $secs);
						if($type=="Dine-in"){
							echo "<tr style='cursor:pointer;' id='$code' onclick='showQueue(this.id);'>
									<td class='col-xs-1'><label style='position:relative; top:10px;'>table #</label><h3 style='position:relative; left:35px; font-size:45pt;'>$table</h3></td>
									<td class='col-xs-2'><strong>$code</strong><br/><label style='font-weight:normal; cursor:pointer;'>$date</label></td>
									<td class='col-xs-1'><i  class='fa fa-cutlery fa-5x'></i></td>
								  </tr>";
						}
						else if($type=="Take-out"){
							echo "<tr style='cursor:pointer;' id='$code' onclick='showQueue(this.id);'>
									<td class='col-xs-1'><label style='position:relative; top:10px;'>$type</label><h3 style='position:relative; left:35px; font-size:45pt;'><i  class='fa fa-shopping-basket fa-1x'></h3></td>
									<td class='col-xs-2'><strong>$code</strong><br/><label style='font-weight:normal; cursor:pointer;'>$date</label></td>
									<td class='col-xs-1'><i  class='fa fa-cutlery fa-5x'></i></td>
								  </tr>";
						}
						else{
							echo "<tr style='cursor:pointer;' id='$code' onclick='showQueue(this.id);'>
									<td class='col-xs-1'><label style='position:relative; top:10px;'>$type</label><h3 style='position:relative; left:35px; font-size:45pt;'><i  class='fa fa-motorcycle fa-1x'></h3></td>
									<td class='col-xs-2'><strong>$code</strong><br/><label style='font-weight:normal; cursor:pointer;'>$date</label></td>
									<td class='col-xs-1'><i  class='fa fa-cutlery fa-5x'></i></td>
								  </tr>";
						}
				}
			}
			else{
				echo "<td class='col-xs-1' style='font-size:14pt; font-weight:bold;' align='center'>NO DATA FOUND</td>";
			}
		}
		else{
			echo "<td class='col-xs-1' style='font-size:14pt; font-weight:bold;' align='center'>NO DATA FOUND</td>";
		}


	}

	function cancelOrder($db){
		$code = $_GET['code'];
		$sql = "Select * from mushroom_queue where queue_code = '$code'";
			$exist = $db->checkExist($sql);
			if($exist){
				$rows = $db->fetch_array($exist);
				echo $type = $rows['queue_type'];
				$table = $rows['queue_table'];
				if($type=="Dine-in"){
					$sql1 = "Update mushroom_tables set table_status = 'vacant' where table_number ='$table'";
					$exist1 = $db->checkExist($sql1);
				}
				$sql2 = "Delete from mushroom_queue where queue_code = '$code' ";
				$exist2 = $db->checkExist($sql2);
			}
	}

	function viewCart($db){
		$total = 0;
		if(isset($_SESSION['POSCart'])){
			foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$db->set_foodName($row['food_name']);
						$db->set_foodCode($cart);
						$db->set_foodImage($row['food_image']);
						$db->set_foodQuantity($cartItems);
						$db->set_foodPrice($food_price);
						$db->set_foodSubtotal($subtotal);
						$total = $db->compute_bill();
						$db->view_cart();
					}

			}
			//$db->view_button_numbers($active);

		}
		else{
			echo "<td class='col-xs-1' align='center' style='height:100px; font-size:15pt; color:#949494; background-image:url(images/icon-cutlery.png); background-repeat:no-repeat; background-size:100px 60px; background-position: center;'><i> No Open Orders</i><br/><p>Tap the New Order button to start a new order.</p></td>";
		}

		echo "*".number_format($total,"2");
	}

	function viewCartDel($db){
		$total = 0;
		if(isset($_SESSION['POSCart'])){
			foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$db->set_foodName($row['food_name']);
						$db->set_foodCode($cart);
						$db->set_foodImage($row['food_image']);
						$db->set_foodQuantity($cartItems);
						$db->set_foodPrice($food_price);
						$db->set_foodSubtotal($subtotal);
						$total = $db->compute_bill();
						$db->view_cart_del();
					}

			}
			//$db->view_button_numbers($active);

		}
		else{
			echo "<td class='col-xs-1' align='center' style='height:100px; font-size:15pt; color:#949494; background-image:url(images/icon-cutlery.png); background-repeat:no-repeat; background-size:100px 60px; background-position: center;'><i> No Open Orders</i><br/><p>Tap the New Order button to start a new order.</p></td>";
		}

		echo "*".number_format($total,"2");
	}

	function saveEmployee($db){
		$fname = $_GET['firstname'];
		$lname = $_GET['lastname'];
		$email = $_GET['email'];
		$contactno = $_GET['contactno'];
		$user = $_GET['username'];
		$passw = md5($_GET['passw']);
		$gender = $_GET['gender'];
		$secs = time();

		$sql1 = "Select * from mushroom_staff where staff_username = '$user'";
		$exist1 = $db->checkExist($sql1);
		$num_rows = $db->get_rows($exist1);
			if($num_rows>=1){
				echo "same";
			}
			else{
				$sql = "Insert into mushroom_staff values('$fname','$lname','$email','$contactno','$gender','$user','$passw','profile/user.png','$secs','Active','No')";
				$exist = $db->checkExist($sql) or die(mysql_error());
				$name = $fname." ".$lname;
				$activity = "Added New Employee ($name)";
				$db->activity_log($activity);
			}

			/* $sql1 = "Select * from mushroom_staff where staff_username = '$user'";
			$exist1 = $db->checkExist($sql1);
			$row = $db->fetch_array($exist1);
			$name = $row['staff_firstname']." ".$row['staff_lastname']; */


	}

	function generateUsername($db){
		$emailadd = strtolower($_GET['emailadd']);
		$firstname = strtolower($_GET['firstname']);
		$lastname = strtolower($_GET['lastname']);
		$email = explode("@",$emailadd);
		$u1 = $firstname."123"; $u2 = $firstname."321"; $u3 = $firstname."231"; $u4 = $firstname."1234"; $u5 = $lastname."123"; $u6 = $lastname."1234"; $u7 = $lastname."321";
		$u8 = $firstname.$lastname;$u9 = $firstname.$lastname."123";$u10 = $email[0];$u11 = $email[0]."123";$u12 =  $lastname.$firstname;
		$usernames = array($u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$u11,$u12);
		$values = array();
		foreach($usernames as $username){
			$sql = "Select * from mushroom_staff where staff_username='$username'";
			$exist = $db->checkExist($sql);
				if($exist){
					$num = $db->get_rows($exist);
						if($num==0){
							array_push($values,$username);
						}
				}
				else{

				}
		}

		//array_push($val,$quantity,$subtotal);
		if (!empty($values)) {
		    $index = array_rand($values, 1);
			echo $values[$index];
		}
		//$values = array("Kay", "Joe","Susan", "Frank");

	}
	function saveProduct($db){

		//$time = date('h:i A');

		generate4:
		date_default_timezone_set('Asia/Manila');
		$date = date('F d, Y');
		$secs = time();
		//$category = $_GET["category"];
		$name = $_GET["foodName"];
		$price = $_GET["foodPrice"];
		$total_price = 0;
		$category = $db->generateProduct();
		$sql3 = "Select * from mushroom_products where food_category ='$category'";
		$exist3 = $db->checkExist($sql3);
		$check3 = $db->get_rows($exist3);
			if($check3>=1){
				goto generate4;
			}
			else{
				$sql = "Select * from mushroom_products where product_name='$name'";
				$exist = $db->checkExist($sql);
					if($exist){
						$num = $db->get_rows($exist);
							if($num>=1){
								echo "same";
							}
							else{
								$sql1 = "Insert into mushroom_products values('$category','$name','$price','$date','Active','No','$secs')";
								$exist1 = $db->checkExist($sql1);
									if($exist1){
										echo "Successful";
										$activity = "Added new product ($name)";
										$db->activity_log($activity);
									}
							}

					}
			}

	}

	function saveTable($db){

		//$time = date('h:i A');

		generate4:
		date_default_timezone_set('Asia/Manila');
		$date = date('F d, Y');
		$secs = time();
		//$category = $_GET["category"];
		$name = $_GET["tableNo"];
		$total_price = 0;

				$sql = "Select * from mushroom_tables where table_number='$name'";
				$exist = $db->checkExist($sql);
					if($exist){
						$num = $db->get_rows($exist);
							if($num>=1){
								echo "same";
							}
							else{
								$sql1 = "Insert into mushroom_tables values('$name','vacant')";
								$exist1 = $db->checkExist($sql1);
									if($exist1){
										echo "Successful";
										$activity = "Added new table (#$name)";
										$db->activity_log($activity);
									}
							}

					}


	}

	function saveFood($db){
		generate3:
		date_default_timezone_set('Asia/Manila');
		$date = date('F d, Y');
		//$time = date('h:i A');
		$secs = time();
		$category = $_GET["category"];
		//$foodCode = $_GET["foodCode"];
		//$foodCode = $category."_".$foodCode;
		$name = $_GET["foodName"];
		$price = $_GET["foodPrice"];

		$foodCode = $db->generateFood();
		$sql3 = "Select * from mushroom_foods where food_code ='$foodCode'";
		$exist3 = $db->checkExist($sql3);
		$check3 = $db->get_rows($exist3);
			if($check3>=1){
				goto generate3;
			}
			else{
				$sql = "Select * from mushroom_foods where food_name='$name'";
				$exist = $db->checkExist($sql);
					if($exist){
						$num = $db->get_rows($exist);
							if($num>=1){
								echo "same";
							}
							else{
								$sql1 = "Insert into mushroom_foods values('$foodCode','$name','$category','$price','$date','foods/default-image.png','Active','No','$secs')";
								$exist1 = $db->checkExist($sql1) or die(mysql_error());
									if($exist1){
										echo "Successful";
										$activity = "Added new food ($name)";
										$db->activity_log($activity);
									}
							}

					}
			}



	}

	function resetPass($db){
		$user = "admin";
		$pass = md5("admin");
		$sql = "Update mushroom_admin set admin_username ='$user', admin_password ='$pass'";
		$exist = $db->checkExist($sql);
		$activity = "Username and Password reset";
		$db->activity_log($activity);
	}

	function showEditForm($db){
		$category = $_GET["category"];
		$sql = "Select * from mushroom_products where food_category ='$category'";
		$exist = $db->checkExist($sql);
		$row = $db->fetch_array($exist);
		echo $row['product_name'];
		echo "*".$row['product_price'];
	}

	function showEditFoods($db){
		$code = $_GET["code"];
		$sql = "Select * from mushroom_foods where food_code ='$code'";
		$exist = $db->checkExist($sql);
		$row = $db->fetch_array($exist);
		echo $row['food_name'];
		echo "*".$row['food_price'];
	}

	function archiveOrder($db){
		$code = $_GET["code"];
		$sql = "Update mushroom_delivery set delivery_archive = 'Yes' where delivery_code='$code'";
		$exist = $db->checkExist($sql);
	}

	function restoreOrder($db){
		$code = $_GET["code"];
		$sql = "Update mushroom_delivery set delivery_archive = 'No' where delivery_code='$code'";
		$exist = $db->checkExist($sql);
	}

	function deleteProduct($db){
		$category = $_GET["category"];

		$sql1 = "Select * from mushroom_products where food_category = '$category'";
		$exist1 = $db->checkExist($sql1);
		$row = $db->fetch_array($exist1);
		$product = $row['product_name'];
		$activity = "Deleted product ($product)";
		$db->activity_log($activity);

		$sql = "Update mushroom_products set product_archive = 'Yes' where food_category='$category'";
		$exist = $db->checkExist($sql);

		/* $sql = "Select * from mushroom_products where food_category ='$category'";
		$exist = $db->checkExist($sql);
		$row = $db->fetch_array($exist);
		$food_category = $row['food_category'];
		$name = $row['product_name'];
		$price = $row['product_price'];
		$product_date = $row['product_date'];
		$product_status = $row['product_status'];
		$product_time = $row['product_time'];
		$sql1 = "Insert into mushroom_products_archive values('$food_category','$name','$price','$product_date','$product_status','$product_time')";
		$exist1 = $db->checkExist($sql1);
		$sql2 = "Delete from mushroom_products where food_category ='$category'";
		$exist2 = $db->checkExist($sql2); */
	}
	function deleteFood($db){
		$code = $_GET["code"];

		$sql1 = "Select * from mushroom_foods where food_code = '$code'";
		$exist1 = $db->checkExist($sql1);
		$row = $db->fetch_array($exist1);
		$food = $row['food_name'];
		$activity = "Deleted food ($food)";
		$db->activity_log($activity);

		$sql = "Update mushroom_foods set food_archive = 'Yes' where food_code='$code'";
		$exist = $db->checkExist($sql);
		/* $sql = "Select * from mushroom_products where food_category ='$category'";
		$exist = $db->checkExist($sql);
		$row = $db->fetch_array($exist);
		$food_category = $row['food_category'];
		$name = $row['product_name'];
		$price = $row['product_price'];
		$product_date = $row['product_date'];
		$product_status = $row['product_status'];
		$product_time = $row['product_time'];
		$sql1 = "Insert into mushroom_products_archive values('$food_category','$name','$price','$product_date','$product_status','$product_time')";
		$exist1 = $db->checkExist($sql1); */
		/* $sql2 = "Delete from mushroom_foods where food_code ='$code'";
		$exist2 = $db->checkExist($sql2); */
	}

	function editProduct($db){
		$category = $_GET["category"];
		$name = $_GET["name"];
		$price = $_GET["price"];
		$sql = "Update mushroom_products set product_name = '$name', product_price='$price' where food_category='$category'";
		$exist = $db->checkExist($sql);
		$activity = "Edited product ($name)";
		$db->activity_log($activity);
	}

	function editTable($db){
		$category = $_GET["category"];
		$name = $_GET["name"];
		$sql = "Update mushroom_tables set table_number = '$name' where table_number='$category'";
		$exist = $db->checkExist($sql);
		$activity = "Edited table #$category -(#$name)";
		$db->activity_log($activity);
	}

	function editFood($db){
		$code = $_GET["code"];
		$name = $_GET["name"];
		$price = $_GET["price"];
		$sql = "Update mushroom_foods set food_name = '$name', food_price='$price' where food_code='$code'";
		$exist = $db->checkExist($sql);

		$activity = "Edited food ($name)";
		$db->activity_log($activity);
	}

	function showProducts($db){
		$sql = "Select * from mushroom_products where product_archive ='No' order by product_time asc";
		$exist = $db->checkExist($sql);
			if($exist){
			$rows = $db->get_rows($exist);
				if($rows>=1){
					while($row = $db->fetch_array($exist)){
						/* if($count==0){
							$div++;
							$db->set_divCount($div);
						}
						$count++;
						if($div==1){
							$class='active';
							$db->set_className($class);
						}
						else{
							$class='';
							$db->set_className($class);
						} */
						$db->set_productFoodCategory($row['food_category']);
						$db->set_productNameVal($row['product_name']);
						$db->set_productPriceVal($row['product_price']);
						$db->set_productAddedDate($row['product_date']);
						$db->set_productStatusVal($row['product_status']);
						$db->show_products();
						/* if($count==4){
							$count = 0;
						} */
					}
				}
				else{
					echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
				}
			}
			else{
				echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
			}
	}

		function showTables($db){
		$sql = "Select *,CAST(table_number as SIGNED) AS casted_column from mushroom_tables order by casted_column ASC";
		$exist = $db->checkExist($sql);
			if($exist){
			$rows = $db->get_rows($exist);
				if($rows>=1){
					while($row = $db->fetch_array($exist)){
						/* if($count==0){
							$div++;
							$db->set_divCount($div);
						}
						$count++;
						if($div==1){
							$class='active';
							$db->set_className($class);
						}
						else{
							$class='';
							$db->set_className($class);
						} */
						//$db->set_productFoodCategory($row['food_category']);
						$db->set_productNameVal($row['table_number']);
				/* 		$db->set_productPriceVal($row['product_price']);
						$db->set_productAddedDate($row['product_date']); */
						$db->set_productStatusVal($row['table_status']);
						$db->show_tables();
						/* if($count==4){
							$count = 0;
						} */
					}
				}
				else{
					echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
				}
			}
			else{
				echo "<td colspan='12' align='center'>NO DATA FOUND</td>";
			}
	}

	function viewProducts($db){
		$category = $_GET['category'];
		//$status = $_GET['status'];
		//$sql = "Select * from mushroom_foods where food_category = '$category' AND food_status = '$status' order by food_time ASC";
		$sql = "Select * from mushroom_foods where food_category = '$category' and food_archive ='No' order by food_time ASC";
		$exist = $db->checkExist($sql);
			if($exist){
				while($row = $db->fetch_array($exist)){
					/* if($count==0){
						$div++;
						$db->set_divCount($div);
					}
					$count++;
					if($div==1){
						$class='active';
						$db->set_className($class);
					}
					else{
						$class='';
						$db->set_className($class);
					} */
					$db->set_productCode($row['food_code']);
					$db->set_productPic($row['food_image']);
					$db->set_productName($row['food_name']);
					$db->set_productPrice($row['food_price']);
					$db->set_productStatus($row['food_status']);
					$db->set_productDate($row['food_date']);
					$db->show_foods();
					/* if($count==4){
						$count = 0;
					} */
				}

			}
	}

	function viewUsersInfo($db){
		$status = $_GET['category'];
		if($status=="All"){
			$sql = "Select * from mushroom_users order by user_seconds ASC";
		}
		else{
			$sql = "Select * from mushroom_users where user_status = '$status' order by user_seconds ASC";
		}

		$exist = $db->checkExist($sql);
		$numrows = $db->get_rows($exist);
			if($numrows>=1){
				while($row = $db->fetch_array($exist)){

					$db->set_userCode($row['user_username']);
					$db->set_userStatus($row['user_status']);
					$db->set_userName($row['user_fullname']);
					$db->set_userEmail($row['user_email']);
					$db->set_userContact($row['user_contact']);
					$address = $row['user_address'].", ".$row['user_province'].", ".$row['user_city'];
					$db->set_userCompleteAddress($address);
					$db->show_users();

				}

			}
			else{
				echo "<td colspan=12 style='font-size:14pt; font-weight:bold;'>NO DATA FOUND</td>";
			}
	}

	function viewStaffInfo($db){
		$status = $_GET['category'];

		if($status=="All"){
			$sql = "Select * from mushroom_staff order by staff_seconds ASC";
		}
		else{
			$sql = "Select * from mushroom_staff where staff_status = '$status' order by staff_seconds ASC";
		}

		$exist = $db->checkExist($sql);
		$numrows = $db->get_rows($exist);
			if($numrows>=1){
				while($row = $db->fetch_array($exist)){

					$db->set_userCode($row['staff_username']);
					$db->set_userStatus($row['staff_status']);
					$fullname = $row['staff_firstname']." ".$row['staff_lastname'];
					$db->set_userName($fullname);
					$db->set_userEmail($row['staff_email']);
					$db->set_userContact($row['staff_contact']);
					//$address = $row['user_address'].", ".$row['user_province'].", ".$row['user_city'];
					//$db->set_userCompleteAddress($address);

					$db->show_staff();

				}

			}
			else{
				//echo "<td colspan=12 style='font-size:14pt; font-weight:bold;'>NO DATA FOUND</td>";
			}
	}

	function setProductStatus($db){
		$category = $_GET["category"];
		$status = $_GET["status"];
		$sql = "Update mushroom_products set product_status = '$status' where food_category='$category'";
		$exist = $db->checkExist($sql);

		$sql1 = "Select * from mushroom_products where food_category = '$category'";
		$exist1 = $db->checkExist($sql1);
		$row = $db->fetch_array($exist1);
		$product = $row['product_name'];
		$activity = "Changed product status to $status ($product)";
		$db->activity_log($activity);
	}

	function setTableStatus($db){
		$category = $_GET["category"];
		$status = $_GET["status"];
		$sql = "Update mushroom_tables set table_status = '$status' where table_number='$category'";
		$exist = $db->checkExist($sql);

		$activity = "Changed table status to $status (Table No. #$category)";
		$db->activity_log($activity);
	}

	function setUserStatus($db){
		$user = $_GET["code"];
		$status = $_GET["status"];
		$sql = "Update mushroom_users set user_status = '$status' where user_username='$user'";
		$exist = $db->checkExist($sql);

		$sql1 = "Select * from mushroom_users where user_username = '$user'";
		$exist1 = $db->checkExist($sql1);
		$row = $db->fetch_array($exist1);
		$name = $row['user_fullname'];
		$activity = "Changed user's status to $status ($name)";
		$db->activity_log($activity);
	}

	function setStaffStatus($db){
		$user = $_GET["code"];
		$status = $_GET["status"];
		$sql = "Update mushroom_staff set staff_status = '$status' where staff_username='$user'";
		$exist = $db->checkExist($sql);

		$sql1 = "Select * from mushroom_staff where staff_username = '$user'";
		$exist1 = $db->checkExist($sql1);
		$row = $db->fetch_array($exist1);
		$name = $row['staff_firstname']." ".$row['staff_lastname'];
		$activity = "Changed employee's status to $status ($name)";
		$db->activity_log($activity);
	}

	function viewFoodImage($db){
		$code = $_GET["code"];
		$sql = "Select * from mushroom_foods where food_code = '$code'";
		$exist = $db->checkExist($sql);
		$row = $db->fetch_array($exist);
		echo "../".$row['food_image'];
	}

	function saveFoodImage($db){
		//header('Content-Type: text/plain; charset=utf-8');

		$code = $_GET['code'];
		//$user = $_SESSION['User'];
		$pic_name = $_FILES['myfile']['name'];
		$tmp_name = $_FILES['myfile']['tmp_name'];
		$file_size = $_FILES['myfile']['size'];
		$file_error = $_FILES['myfile']['error'];
		$file_type = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
		if($pic_name){
			if($file_type=='jpeg' or $file_type=='jpg' or $file_type=='png'){
				if($file_size>0 && $file_size<=2148000){
					$location="foods/$pic_name";
					$location2="../../foods/$pic_name";

					$sql = "UPDATE mushroom_foods SET food_image='$location' WHERE food_code ='$code'";
					$exist = $db->checkExist($sql) or die(mysql_error());
						if($exist){
							move_uploaded_file($tmp_name,$location2);
							echo "success";
							$sql1 = "Select * from mushroom_foods where food_code = '$code'";
							$exist1 = $db->checkExist($sql1);
							$row = $db->fetch_array($exist1);
							$food = $row['food_name'];
							$activity = "Edited food picture ($food)";
							$db->activity_log($activity);
						}
						else{
							echo "Invalid data";
						}
				}
				else{
					echo "The maximum size for file upload is 2.0mb";
				}
			}
			else{
				echo "Invalid file type";
			}
		}
		else{
			echo "Please select a file!";
		}

	}

	function saveProfileImage($db){
		//header('Content-Type: text/plain; charset=utf-8');

		//$code = $_GET['code'];
		//$user = $_SESSION['User'];
		$user = $_SESSION['Admin'];
		$pic_name = $_FILES['myfile']['name'];
		$tmp_name = $_FILES['myfile']['tmp_name'];
		$file_size = $_FILES['myfile']['size'];
		$file_error = $_FILES['myfile']['error'];
		$file_type = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
		if($pic_name){
			if($file_type=='jpeg' or $file_type=='jpg' or $file_type=='png'){
				if($file_size>0 && $file_size<=2148000){
					$location="profile/$pic_name";
					$location2="../../profile/$pic_name";

					$sql = "UPDATE mushroom_admin SET admin_picture ='$location' WHERE admin_username ='$user'";
					$exist = $db->checkExist($sql) or die(mysql_error());
						if($exist){
							move_uploaded_file($tmp_name,$location2);
							echo "success";
						}
						else{
							echo "Invalid data";
						}
				}
				else{
					echo "The maximum size for file upload is 2.0mb";
				}
			}
			else{
				echo "Invalid file type";
			}
		}
		else{
			echo "Please select a file!";
		}

	}

	function editUserPass($db){
		$user = $_GET['username'];
		$newpass = md5($_GET['newpass']);

		$sql = "Update mushroom_staff set staff_password = '$newpass' where staff_username = '$user'";
		$exist = $db->checkExist($sql) or die(mysql_error());

			$sql1 = "Select * from mushroom_staff where staff_username = '$user'";
			$exist1 = $db->checkExist($sql1);
			$row = $db->fetch_array($exist1);
			$name = $row['staff_firstname']." ".$row['staff_lastname'];
			$activity = "Changed password ($name / Employee)";
			$db->activity_log($activity);
			echo "Password was successfully changed";

		//$pass = md5($_GET['password']);
	}

	function editUsersPass($db){
		$user = $_GET['username'];
		$newpass = md5($_GET['newpass']);

		$sql = "Update mushroom_users set user_password = '$newpass' where user_username = '$user'";
		$exist = $db->checkExist($sql) or die(mysql_error());

			$sql1 = "Select * from mushroom_users where user_username = '$user'";
			$exist1 = $db->checkExist($sql1);
			$row = $db->fetch_array($exist1);
			$name = $row['user_fullname'];
			$activity = "Changed password ($name / Users)";
			$db->activity_log($activity);
			echo "Password was successfully changed";

		//$pass = md5($_GET['password']);
	}

	function changePassword($db){
		$user = $_SESSION['Admin'];
		$current = md5($_GET['currentPass']);
		$new = $_GET['newPass'];
		$con = $_GET['conPass'];

		$sql = "Select * from mushroom_admin where admin_password = '$current'";
		$exist = $db->checkExist($sql) or die(mysql_error());
		$num_rows = $db->get_rows($exist);
			if($num_rows>=1){
				if($new==$con){
					$con = md5($con);
					$sql1 = "Update mushroom_admin set admin_password = '$con' where admin_username = '$user'";
					$exist1 = $db->checkExist($sql1);
				}
				else{
					echo "same";
				}
			}
			else{
				echo "invalid";
			}
		//$pass = md5($_GET['password']);
	}

	/* function viewCategory($db){
		$select = "selected";
		$sql = "Select * from mushroom_products where product_status = 'Active' order by product_time ASC";
		$exist = $db->checkExist($sql) or die(mysql_error());
		$stat = 'active';
		while($row = $db->fetch_array($exist)){
			$product = $row['food_category'];
			$product_name = $row['product_name'];
			$product_price = $row['product_price'];

				echo "<option $select; value='$product'>{$product_name}</option>";

			$select = " ";
		}
	} */

	function setFoodStatus($db){
		$code = $_GET["code"];
		$status = $_GET["status"];
		$sql = "Update mushroom_foods set food_status = '$status' where food_code='$code'";
		$exist = $db->checkExist($sql);

		$sql1 = "Select * from mushroom_foods where food_code = '$code'";
		$exist1 = $db->checkExist($sql1);
		$row = $db->fetch_array($exist1);
		$food = $row['food_name'];
		$activity = "Changed food status to $status ($food)";
		$db->activity_log($activity);
	}

	function changeChoices($db){
		$sql = "Select * from mushroom_products where product_status = 'Active' and product_archive ='No' order by product_time ASC";
		$exist = $db->checkExist($sql);
		$count = 0;
			while($row = $db->fetch_array($exist)){
				$product = $row['food_category'];
				$product_name = $row['product_name'];
				$product_price = $row['product_price'];

				if($count>0){
					$divider = "<li class='divider'></li>";
				}
				else{
					echo $product."*".$product_name."*";
					$divider = "";
				}
				echo "$divider<li><a href='#' onclick='changeValue(this.id,this.name); return false;' id='$product' name='$product_name' ><i class='fa fa-bookmark'></i> $product_name</a></li>";
				$count++;
			}
	}

	function changeDinein($db){
		$sql = "Select *,CAST(table_number as SIGNED) AS casted_column from mushroom_tables where table_status = 'vacant' order by casted_column ASC";
		$exist = $db->checkExist($sql);
		$check = $db->get_rows($exist);
		if($check>=1){
			$count = 0;
				while($row = $db->fetch_array($exist)){
					$table = $row['table_number'];
					$status = $row['table_status'];

					if($count>0){
						$divider = "<li class='divider'></li>";
					}
					else{
						echo $table."*".$table."*";
						$divider = "";
					}
					echo "$divider<li><a href='#' onclick='changeDinein(this.id); return false;' id='$table'><i class='fa fa-circle-o'></i> $table</a></li>";
					$count++;
				}
		}
		else{
			echo "No available*No available*No available";
		}

	}

	function changeAdd($db){
		echo $_SESSION['table'];
		/* $sql = "Select *,CAST(table_number as SIGNED) AS casted_column from mushroom_tables where table_status = 'occupied' order by casted_column ASC";
		$exist = $db->checkExist($sql);
		$check = $db->get_rows($exist);
		if($check>=1){
			$count = 0;
				while($row = $db->fetch_array($exist)){
					$table = $row['table_number'];
					$status = $row['table_status'];

					if($count>0){
						$divider = "<li class='divider'></li>";
					}
					else{
						echo $table."*".$table."*";
						$divider = "";
					}
					echo "$divider<li><a href='#' onclick='changeAdd(this.id); return false;' id='$table'><i class='fa fa-circle-o'></i> $table</a></li>";
					$count++;
				}
		}
		else{
			echo "No available*No available*No available";
		} */
	}

	function newOrder($db){
		$order = $_GET['orderType'];
		$_SESSION['OrderType'] = $order;
		if($order=="DineIn"){
			echo "Dine in";
			unset($_SESSION['Customer']);
		}
		else if($order=="TakeOut"){
			echo "Take out";
			unset($_SESSION['Customer']);
		}
		else if($order=="AddOrd"){
			echo "Add order(s)";
			unset($_SESSION['Customer']);
		}
		else if($order=="Reserve"){
			echo "Reservation";
			if(isset($_SESSION['Customer'])){

			}
			else{
				unset($_SESSION['Customer']);
			}
		}
		else{
			unset($_SESSION['Customer']);
			echo "Undefined";
		}
	}

	function checkType($db){
		unset($_SESSION['Discount']);
		$order = $_SESSION['OrderType'];
		if($order=="DineIn"){
			echo "Dine";
			unset($_SESSION['table']);
		}
		else if($order=="TakeOut"){
			echo "Take";
			unset($_SESSION['table']);
		}
		else if($order=="Reserve"){
			echo "Reserve";
			unset($_SESSION['table']);
		}
		else{
			echo "Add";
		}

	}

	function queueDine($db){

		$table = $_GET['table'];
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$secs = time();
		if(isset($_SESSION['POSCart'])){
			generate2:
			$total_price = 0;
			$code = $db->generateCode();
			$sql = "Select * from mushroom_delivery where delivery_code = '$code'";
			$exist = $db->checkExist($sql);
			$check = $db->get_rows($exist);
				if($check>=1){
					goto generate2;
				}
				else{
					$sql2 = "Insert into mushroom_queue values('$code','Dine-in','$table','','','','$secs','','No')";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
							$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
							$exist1 = $db->checkExist($sql1);

							if($exist1){
								$row = $db->fetch_array($exist1);
								$food_price = $row['food_price'];
								$subtotal = (float)$food_price * (float)$cartItems;
								$food = $row['food_name'];
								$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','No','No')";
								$exist3 = $db->checkExist($sql3);

							}
						}
						$sql4 = "Update mushroom_tables set table_status = 'occupied' where table_number ='$table'";
						$exist4 = $db->checkExist($sql4);
					}
				}
			$activity = "Queued order ($code)";
			$db->activity_log($activity);
			printOrdersDine($db,$table,'Dine-in');
		}
	}

	function reserveOrder($db){

		$name = $_GET['name'];
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$secs = time();
		if(isset($_SESSION['POSCart'])){
			generate2:
			$total_price = 0;
			$code = $db->generateCode();
			$sql = "Select * from mushroom_delivery where delivery_code = '$code'";
			$exist = $db->checkExist($sql);
			$check = $db->get_rows($exist);
				if($check>=1){
					goto generate2;
				}
				else{
					$sql2 = "Insert into mushroom_reservation values('$code','$name','','','$secs')";
					$exist2 = $db->checkExist($sql2) or die(mysql_error());
					if($exist2){
						foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
							$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
							$exist1 = $db->checkExist($sql1) or die(mysql_error());

							if($exist1){
								$row = $db->fetch_array($exist1);
								$food_price = $row['food_price'];
								$subtotal = (float)$food_price * (float)$cartItems;
								$food = $row['food_name'];
								$sql3 = "Insert into mushroom_reservation_orders values('$code','$food','$cartItems','$food_price','$subtotal')";
								$exist3 = $db->checkExist($sql3) or die(mysql_error());

							}
						}
						/* $sql4 = "Update mushroom_tables set table_status = 'occupied' where table_number ='$table'";
						$exist4 = $db->checkExist($sql4); */
					}
				}
			$activity = "Reserved order($name)";
			$db->activity_log($activity);
			//printOrdersDine($db,$table,'Dine-in');
		}
	}

	function queuePaymentDine($db){

		$table = $_GET['table'];
		date_default_timezone_set('Asia/Manila');
		printOrdersDine($db,$table,'Dine-in');
		echo "*".date("D, m/d/Y")."*";
		echo date("h:i A")."*";
		$secs = time();
		$total_price = 0;
		foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
			$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
			$exist1 = $db->checkExist($sql1);

			if($exist1){
				$row = $db->fetch_array($exist1);
				$food_price = $row['food_price'];
				$subtotal = (float)$food_price * (float)$cartItems;
				$food = $row['food_name'];
				$db->set_foodName($food);
				$db->set_foodQuantity($cartItems);
				$db->set_foodPrice(number_format($food_price,"2"));
				$db->set_foodSubtotal(number_format($subtotal,"2"));
				$db->show_reviewTable();
				$total_price += $subtotal;
				//$subtotal = floatval(str_replace(",","",$subtotal));
			}
		}
		echo "*".number_format($total_price,"2");

		/* if(isset($_SESSION['POSCart'])){
			//generate2:
			$total_price = 0;
			//$code = $db->generateCode();
			//$sql = "Select * from mushroom_delivery where delivery_code = '$code'";
			//$exist = $db->checkExist($sql);
			//$check = $db->get_rows($exist);
				if($check>=1){
					goto generate2;
				}
				else{
					$sql2 = "Insert into mushroom_queue values('$code','Dine-in','$table','','','','$secs','','No')";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
							$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
							$exist1 = $db->checkExist($sql1);

							if($exist1){
								$row = $db->fetch_array($exist1);
								$food_price = $row['food_price'];
								$subtotal = (float)$food_price * (float)$cartItems;
								$food = $row['food_name'];
								$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','No')";
								$exist3 = $db->checkExist($sql3);

							}
						}
						$sql4 = "Update mushroom_tables set table_status = 'occupied' where table_number ='$table'";
						$exist4 = $db->checkExist($sql4);
					}
				//}
			printOrdersDine($db,$table,'Dine-in');
		} */
	}

	function queuePaymentTakeout($db){

		date_default_timezone_set('Asia/Manila');
		printOrdersTakeout($db,'Take-out');
		echo "*".date("D, m/d/Y")."*";
		echo date("h:i A")."*";
		$secs = time();
		$total_price = 0;
		foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
			$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
			$exist1 = $db->checkExist($sql1);

			if($exist1){
				$row = $db->fetch_array($exist1);
				$food_price = $row['food_price'];
				$subtotal = (float)$food_price * (float)$cartItems;
				$food = $row['food_name'];
				$db->set_foodName($food);
				$db->set_foodQuantity($cartItems);
				$db->set_foodPrice(number_format($food_price,"2"));
				$db->set_foodSubtotal(number_format($subtotal,"2"));
				$db->show_reviewTable();
				$total_price += $subtotal;

			}
		}
		echo "*".number_format($total_price,"2");


	}

	function queueDelivery($db){

		$code = $_GET["code"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$secs = time();

		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$sql1 = "Select * from mushroom_delivery where delivery_code = '$code'";
			$exist1 = $db->checkExist($sql1);
				if($exist1){
					$row1 = $db->fetch_array($exist1);
					$table = $row1['delivery_table'];
					$type = $row1['delivery_type'];
					$customer = $row1['delivery_customer'];
					$username = $row1['delivery_username'];
					$contact = $row1['delivery_contact'];
					$address = $row1['delivery_address'];
					$sql4 = "Insert into mushroom_queue values('$code','$type','$table','$customer','$username','$contact','$secs','$address','No')";
					$exist4 = $db->checkExist($sql4);
				}



			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer->setTextSize(2,3);
			$printer->text("Order Type:\n");
			$printer->setTextSize(3,2);
			$printer->text("$type\n");
			$printer->feed();

			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();

			$sql2 = "Select * from mushroom_orders where delivery_code = '$code'";
			$exist2 = $db->checkExist($sql2);
				if($exist2){
					while($row2 = $db->fetch_array($exist2)){
						$food_price = $row2['order_price'];
						$subtotal = $row2['order_subtotal'];
						$foodName = $row2['order_foods'];
						$cartItems = $row2['order_quantity'];

						$sql6 = "Insert into mushroom_queue_orders values('$code','$foodName','$cartItems','$food_price','$subtotal','No','No')";
						$exist6 = $db->checkExist($sql6);

						//$subtotal = (float)$food_price * (float)$cartItems;
						//$foodName = $row['food_name'];
						//$food_price = number_format($food_price,"2");
						//$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->setTextSize(1,2);
						$printer->text("{$cartItems}x   $foodName \n");

						/*
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal; */

					}
				}

			$total_price = number_format($total_price,"2");
			$payment = number_format($payment,"2");
			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->setEmphasis(true);
			$printer->text("\n");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item(s): $total_items\n");

			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();

			$datePaid = date('F d, Y');
			$time = date('h:i A');
			$dateSales = date('ymd');


			//$sql3 = "Update mushroom_tables set table_status ='vacant' where table_number ='$table'";
			//$exist3 = $db->checkExist($sql3);

			/* $sql5 = "Select * from mushroom_orders where delivery_code = '$code'";
			$exist5 = $db->checkExist($sql5);
				while($row2 = $db->fetch_array($exist5)){
						$food_price = $row2['order_price'];
						$subtotal = $row2['order_subtotal'];
						$foodName = $row2['order_foods'];
						$cartItems = $row2['order_quantity'];

					} */
			$sql7 = "Delete from mushroom_delivery where delivery_code = '$code' ";
			$exist7 = $db->checkExist($sql7);

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function moveReservation($db){
		$code = $_GET["code"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$secs = time();

		/* $sql1 = "Select * from mushroom_reservation where reserve_code = '$code'";
			$exist1 = $db->checkExist($sql1);
				if($exist1){
					$row1 = $db->fetch_array($exist1);
					$table = $row1['delivery_table'];
					$type = $row1['delivery_type'];
					$customer = $row1['delivery_customer'];
					$username = $row1['delivery_username'];
					$contact = $row1['delivery_contact'];
					$address = $row1['delivery_address'];
					$sql4 = "Insert into mushroom_queue values('$code','$type','$table','$customer','$username','$contact','$secs','$address','No')";
					$exist4 = $db->checkExist($sql4);
				} */
		unset($_SESSION['POSCart']);
		$sql2 = "Select * from mushroom_reservation_orders where reserve_code = '$code'";
			$exist2 = $db->checkExist($sql2);
				if($exist2){
					while($row2 = $db->fetch_array($exist2)){
						$food_price = $row2['reserve_orders_price'];
						$subtotal = $row2['reserve_orders_subtotal'];
						$foodName = $row2['reserve_orders_foods'];
						$cartItems = $row2['reserve_orders_quantity'];

						$sql1 = "Select * from mushroom_foods where food_name = '$foodName'";
						$exist1 = $db->checkExist($sql1);
						$row1 = $db->fetch_array($exist1);
						$_SESSION['OrderType'] = "DineIn";
						$food = $row1['food_code'];
						$quantity = $cartItems;

						if(isset($_SESSION['POSCart'])){
							$val = 0;
							foreach ($_SESSION['POSCart'] as $cart => $items) {

								if($cart==$food){
									$_SESSION['POSCart'][$food] = $_SESSION['POSCart'][$food]+ $quantity;
									$val = 1;
								}
							}

							if(!$val){
							$add = array($food => $quantity);
							$_SESSION['POSCart']+= $add;

							}
						}
						else{
							$_SESSION['POSCart']= array($food => $quantity);
						}
						$sql3 = "Delete from mushroom_reservation where reserve_code ='$code'";
						$exist3 = $db->checkExist($sql3);
						$sql4 = "Delete from mushroom_reservation_orders where reserve_code ='$code'";
						$exist4 = $db->checkExist($sql4);


						//echo "success";

						//$sql6 = "Insert into mushroom_queue_orders values('$code','$foodName','$cartItems','$food_price','$subtotal','No','No')";
						//$exist6 = $db->checkExist($sql6);

						//$subtotal = (float)$food_price * (float)$cartItems;
						//$foodName = $row['food_name'];
						//$food_price = number_format($food_price,"2");
						//$subtotal = number_format($subtotal,"2");
						/* $total_items += $cartItems;
						$printer->setTextSize(1,2);
						$printer->text("{$cartItems}x   $foodName \n");	 */

						/*
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal; */

					}
					$activity = "Accepted reserved order ($code)";
					$db->activity_log($activity);
				}
	}

	function queueDeliverydinein($db){

		$code = $_GET["code"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$secs = time();

		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$sql1 = "Select * from mushroom_delivery where delivery_code = '$code'";
			$exist1 = $db->checkExist($sql1);
				if($exist1){
					$row1 = $db->fetch_array($exist1);
					$table = $row1['delivery_table'];
					$type = $row1['delivery_type'];
					$customer = $row1['delivery_customer'];
					$username = $row1['delivery_username'];
					$contact = $row1['delivery_contact'];
					$address = $row1['delivery_address'];
					$sql4 = "Insert into mushroom_queue values('$code','$type','$table','$customer','$username','$contact','$secs','$address','No')";
					$exist4 = $db->checkExist($sql4);
				}



			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer->setTextSize(2,3);
			$printer->text("Table No.\n");
			$printer->setTextSize(3,2);
			$printer->text("$table\n");
			$printer->feed();
			$printer->setTextSize(1,2);
			$printer->text("Order Type: $type\n");
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();

			$sql2 = "Select * from mushroom_orders where delivery_code = '$code'";
			$exist2 = $db->checkExist($sql2);
				if($exist2){
					while($row2 = $db->fetch_array($exist2)){
						$food_price = $row2['order_price'];
						$subtotal = $row2['order_subtotal'];
						$foodName = $row2['order_foods'];
						$cartItems = $row2['order_quantity'];

						$sql6 = "Insert into mushroom_queue_orders values('$code','$foodName','$cartItems','$food_price','$subtotal','No','No')";
						$exist6 = $db->checkExist($sql6);

						//$subtotal = (float)$food_price * (float)$cartItems;
						//$foodName = $row['food_name'];
						//$food_price = number_format($food_price,"2");
						//$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->setTextSize(1,2);
						$printer->text("{$cartItems}x   $foodName \n");

						/*
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal; */

					}
				}

			$total_price = number_format($total_price,"2");
			$payment = number_format($payment,"2");
			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->setEmphasis(true);
			$printer->text("\n");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item(s): $total_items\n");

			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();

			$datePaid = date('F d, Y');
			$time = date('h:i A');
			$dateSales = date('ymd');


			//$sql3 = "Update mushroom_tables set table_status ='vacant' where table_number ='$table'";
			//$exist3 = $db->checkExist($sql3);

			/* $sql5 = "Select * from mushroom_orders where delivery_code = '$code'";
			$exist5 = $db->checkExist($sql5);
				while($row2 = $db->fetch_array($exist5)){
						$food_price = $row2['order_price'];
						$subtotal = $row2['order_subtotal'];
						$foodName = $row2['order_foods'];
						$cartItems = $row2['order_quantity'];

					} */
			$sql5 = "Update mushroom_tables set table_status = 'occupied' where table_number ='$table'";
			$exist5 = $db->checkExist($sql5);
			$sql7 = "Delete from mushroom_delivery where delivery_code = '$code' ";
			$exist7 = $db->checkExist($sql7);

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function queueTakeout($db){

		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$secs = time();
		if(isset($_SESSION['POSCart'])){
			generate1:
			$total_price = 0;
			$code = $db->generateCode();
			$sql = "Select * from mushroom_delivery where delivery_code = '$code'";
			$exist = $db->checkExist($sql);
			$check = $db->get_rows($exist);
				if($check>=1){
					goto generate1;
				}
				else{
					$sql2 = "Insert into mushroom_queue values('$code','Take-out','','','','','$secs','')";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
							$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
							$exist1 = $db->checkExist($sql1);

							if($exist1){
								$row = $db->fetch_array($exist1);
								$food_price = $row['food_price'];
								$subtotal = (float)$food_price * (float)$cartItems;
								$food = $row['food_name'];
								$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','No')";
								$exist3 = $db->checkExist($sql3);

							}
						}

					}
				}
			printOrdersTakeout($db,'Take-out');
		}
	}

	function addOrder($db){
		$code = $_GET['code'];
		$sql = "Select * from mushroom_queue where queue_code = '$code'";
			$exist = $db->checkExist($sql);
			if($exist){
				$rows = $db->fetch_array($exist);
				$table = $rows['queue_table'];
			}
		echo $table;
		$_SESSION['table'] = $table;
		$_SESSION['OrderType'] = "AddOrd";
		unset($_SESSION['Customer']);
	}

	function queueAdd($db){

		if(isset($_SESSION['table'])){
			$table = $_SESSION['table'];
		}
		//$table = $_GET['table'];

		if(isset($_SESSION['POSCart'])){
			$sql = "Select * from mushroom_queue where queue_table = '$table'";
			$exist = $db->checkExist($sql);
			if($exist){
				$rows = $db->fetch_array($exist);
				$code = $rows['queue_code'];
				$sql4 = "Update mushroom_queue set queue_paid ='No' where queue_code ='$code' ";
				$exist4 = $db->checkExist($sql4);
				foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
					$exist1 = $db->checkExist($sql1);

					if($exist1){
						$row = $db->fetch_array($exist1);
						$food_price = $row['food_price'];
						$food = $row['food_name'];
						$sql2 = "Select * from mushroom_queue_orders where orders_foods = '$food' and queue_code = '$code'";
						$exist2 = $db->checkExist($sql2) or die(mysql_error());
						$check = $db->get_rows($exist2);
						if($check>=1){
							$sql4 = "Select * from mushroom_queue_orders where orders_foods = '$food' and queue_paid = 'No' and queue_code = '$code'";
							$exist4 = $db->checkExist($sql4) or die(mysql_error());
							$check4 = $db->get_rows($exist4);
							if($check4>=1){
								$row2 = $db->fetch_array($exist4);
								$qty = $row2['orders_quantity'];
								$total = (float)$qty + (float)$cartItems;
								$subtotal = (float)$food_price * (float)$total;
								$sql3 = "Update mushroom_queue_orders set orders_quantity='$total', orders_subtotal='$subtotal' where queue_code ='$code' AND orders_foods ='$food' and queue_paid='No'";
								$exist3 = $db->checkExist($sql3);
							}
							else{
								$subtotal = (float)$food_price * (float)$cartItems;
								$sql5 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','No','No')";
								$exist5 = $db->checkExist($sql5);
							}

						}
						else{
							$subtotal = (float)$food_price * (float)$cartItems;
							$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','No','No')";
							$exist3 = $db->checkExist($sql3);
						}

					}
				}

			}
		}
	}
	function showQueue($db){
		unset($_SESSION['Discount']);
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$total_price = 0;
		$count = 0;
		$code = $_GET['code'];
		$_SESSION['Discounted'] = $code;
		$sql1 = "Select * from mushroom_queue where queue_code = '$code'";
		$exist1 = $db->checkExist($sql1);
		$rows = $db->fetch_array($exist1);
		$customer = $rows['queue_customer'];
		$username = $rows['queue_username'];
		$contact = $rows['queue_contact'];
		$address = $rows['queue_address'];
		$secs = $rows['queue_seconds'];
		echo $type = $rows['queue_type'];
		echo "*";
			if($type=="Dine-in"){
				echo $rows['queue_table']."*";
			}

		$sql = "Select * from mushroom_queue_orders where queue_code = '$code'";
		$exist = $db->checkExist($sql);
			while($row = $db->fetch_array($exist)){
				$food_price = $row['orders_price'];
				$paid = $row['queue_paid'];
				$discount = $row['queue_discount'];
				//$subtotal = (float)$food_price * (float)$row['orders_quantity'];
				if($discount=="Yes"){
					$db->set_foodName($row['orders_foods']." (20%)");

				}
				else{
					$db->set_foodName($row['orders_foods']);
					//$db->set_foodSubtotal(number_format($subtotal,"2"));
				}
				$subtotal = $row['orders_subtotal'];
				$db->set_foodSubtotal(number_format($subtotal,"2"));
				//$food_price =$food_price;
				$db->set_foodQuantity($row['orders_quantity']);
				$db->set_foodPrice(number_format($food_price,"2"));
				//$subtotal =$subtotal;

				if($paid=="Yes"){
					$color = "#ff9999";
				}
				else{
					$color = "#fff";
					$total_price += $subtotal;
					$count++;
				}


				$db->show_reviewTableColor($color);
			}
			echo "*".$code;
			echo "*".$date;
			echo "*".number_format($total_price,"2");
			echo "*".$customer;
			echo "*".$address;
			echo "*".$contact;
			echo "*".$count;
			echo "*".date('D, m/d/Y', $secs);
			echo "*".date('h:iA', $secs);
	}

	function discountOrder($db){
		$code = $_GET['code'];
		$total_price = 0;
		if(isset($_SESSION['Discount'])){
			echo "discount*";
			unset($_SESSION['Discount']);
			$sql = "Select * from mushroom_queue_orders where queue_code = '$code' and queue_paid = 'No'";
			$exist = $db->checkExist($sql);
				while($row = $db->fetch_array($exist)){
					$food_price = $row['orders_price'];
					$subtotal = (float)$food_price * (float)$row['orders_quantity'];
					$total_price += $subtotal;
				}

				echo number_format($total_price,"2");
		}
		else{
			echo "discounted*";

			$total = 0;
			$high = 0;
			$low = 0;
			$sql = "Select * from mushroom_queue where queue_code = '$code'";
			$exist = $db->checkExist($sql);

				if($exist){
					$sql1 = "Select * from mushroom_queue_orders where queue_code = '$code' and queue_paid ='No'";
					$exist1 = $db->checkExist($sql1);
					while($row = $db->fetch_array($exist1)){
						$subtotal = $row['orders_subtotal'];
						$food_name = $row['orders_foods'];
						$low = $subtotal;
						//$cartItems = $row2['orders_quantity'];
						if($low>$high){
							$_SESSION['Discount'] = $food_name;
							$high = $subtotal;
						}
					}
					//$food_price = number_format($food_price,"2");
					//$subtotal = number_format($subtotal,"2");

					//$subtotal = floatval(str_replace(",","",$subtotal));


					//$subtotal = (float)$food_price * (float)$cartItems;
					$total = (float)$high * 0.20;
					echo number_format($total,"2");
				}


		}
	}

	function discountPaymentScID($db){

		$total = 0;
		$discount_price = 0;
		$count = 0;
		$cart = 0;
		$discounted = 0;
		$sc = 0;
		$ctr = 0;
		if(isset($_SESSION['POSCart'])){
			foreach ($_SESSION['POSCart'] as $index){
				$cart+= $index;
			}

		}

		if(isset($_SESSION['Discount'])){
			$count = count($_SESSION['Discount']);
			$sc = 1;
		}
		else{
			$sc = 0;
		}

		//echo $count."bbb";
		//echo $count."bbb".$cart."bbb";
		if($count>=$cart){
			echo "0";
			//$_SESSION['Discount'] = array("SC");
		}
		else{
			if($sc==1){
				$add = array("SC");
				array_push($_SESSION['Discount'],$add);
			}
			else{

				$_SESSION['Discount'] = array("SC");
			}
			echo "1";
		}
			$count = count($_SESSION['Discount']);
			$num = count($_SESSION['Discount']);

			$ctr = $count;
			foreach ($_SESSION['POSCart'] as $cartItem => $cartItems) {
				$sql = "Select * from mushroom_foods where food_code = '$cartItem'";
				$exist = $db->checkExist($sql) or die(mysql_error());

				if($exist){
					//echo "\n".$count." ".$ctr;

					$row = $db->fetch_array($exist);
					$food_price = $row['food_price'];
					$subtotal = (float)$food_price * (float)$cartItems;
					$foodName = $row['food_name'];

					//echo "d".$ctr;
					if($ctr > 0){
						if($ctr>=$cartItems){
							$ctr -= $cartItems;
							$discounted_food = (float)$food_price * (float)$cartItems;
							$discount_price = $discounted_food * 0.20;
							$discounted += $discount_price;
							//echo "\n".$ctr."b";
						}
						else{
							$discounted_food = (float)$food_price * (float)$ctr;
							$discount_price = $discounted_food * 0.20;
							$discounted += $discount_price;
							$ctr = 0;
							//echo "\n".$ctr."c";
						}
						//	echo "\n".$cartItems."-".$ctr;
					}


					/* $low = $subtotal;
					//$cartItems = $row2['orders_quantity'];
					if($low>$high){
						$_SESSION['Discount'] = $foodName;
						$high = $subtotal;
					}
					$food_price = number_format($food_price,"2");
					$subtotal = number_format($subtotal,"2");
					//$total_items += $cartItems;

					$total_price += $subtotal; */

				}
			}
			echo "*".number_format($discounted,"2")."*";
			/* $total = (float)$high * 0.20;
			echo number_format($total,"2"); */
			$total_price = 0;
			if(isset($_SESSION['Discount'])){

				if(isset($_SESSION['POSCart'])){
					foreach ($_SESSION['POSCart'] as $cart2 => $cartItems2) {
						$sql2 = "Select * from mushroom_foods where food_code = '$cart2'";
						$exist2 = $db->checkExist($sql2) or die(mysql_error());

						if($exist2){

							$row2 = $db->fetch_array($exist2);
							$food_price2 = $row2['food_price'];
							$subtotal2 = (float)$food_price2 * (float)$cartItems2;
							$foodName2 = $row2['food_name'];
							$food_price2 = number_format($food_price2,"2");
							$subtotal2 = number_format($subtotal2,"2");
							$subtotal2 = floatval(str_replace(",","",$subtotal2));
							//$total_items += $cartItems;
							//echo $subtotal."?".$total_price;
							$total_price += $subtotal2;
						}
					}
				}
				echo number_format($total_price,"2");
			}
	}

	function discountPaymentPwdID($db){

		$total = 0;
		$discount_price = 0;
		$count = 0;
		$cart = 0;
		$discounted = 0;
		$sc = 0;
		$ctr = 0;
		if(isset($_SESSION['POSCart'])){
			foreach ($_SESSION['POSCart'] as $index){
				$cart+= $index;
			}

		}

		if(isset($_SESSION['Discount'])){
			$count = count($_SESSION['Discount']);
			$sc = 1;
		}
		else{
			$sc = 0;
		}

		if($count>=$cart){
			echo "0";
		}
		else{
			if($sc==1){
				$add = array("PWD");
				array_push($_SESSION['Discount'],$add);
			}
			else{

				$_SESSION['Discount'] = array("PWD");
			}
			echo "1";
		}
			$count = count($_SESSION['Discount']);
			$num = count($_SESSION['Discount']);

			$ctr = $count;
			foreach ($_SESSION['POSCart'] as $cartItem => $cartItems) {
				$sql = "Select * from mushroom_foods where food_code = '$cartItem'";
				$exist = $db->checkExist($sql) or die(mysql_error());

				if($exist){
					$row = $db->fetch_array($exist);
					$food_price = $row['food_price'];
					$subtotal = (float)$food_price * (float)$cartItems;
					$foodName = $row['food_name'];

					if($ctr > 0){
						if($ctr>=$cartItems){
							$ctr -= $cartItems;
							$discounted_food = (float)$food_price * (float)$cartItems;
							$discount_price = $discounted_food * 0.20;
							$discounted += $discount_price;
						}
						else{
							$discounted_food = (float)$food_price * (float)$ctr;
							$discount_price = $discounted_food * 0.20;
							$discounted += $discount_price;
							$ctr = 0;
						}
					}
				}
			}
			echo "*".number_format($discounted,"2")."*";
			$total_price = 0;
			if(isset($_SESSION['Discount'])){

				if(isset($_SESSION['POSCart'])){
					foreach ($_SESSION['POSCart'] as $cart2 => $cartItems2) {
						$sql2 = "Select * from mushroom_foods where food_code = '$cart2'";
						$exist2 = $db->checkExist($sql2) or die(mysql_error());

						if($exist2){

							$row2 = $db->fetch_array($exist2);
							$food_price2 = $row2['food_price'];
							$subtotal2 = (float)$food_price2 * (float)$cartItems2;
							$foodName2 = $row2['food_name'];
							$food_price2 = number_format($food_price2,"2");
							$subtotal2 = number_format($subtotal2,"2");
							$subtotal2 = floatval(str_replace(",","",$subtotal2));
							$total_price += $subtotal2;
						}
					}
				}
				echo number_format($total_price,"2");
			}
	}

	function discountPaymentReviewScID($db){

		$total = 0;
		$discount_price = 0;
		$count = 0;
		$cart = 0;
		$discounted = 0;
		$sc = 0;
		$ctr = 0;
		$code = $_SESSION['Discounted'];
		$sql1 = "Select * from mushroom_queue_orders where queue_code = '$code' and queue_paid='No'";
		$exist1 = $db->checkExist($sql1);
			while ($row1 = $db->fetch_array($exist1)) {
				$qtyDiscount = $row1['orders_quantity'];
				$cart+= $qtyDiscount;
			}

		//hello
		/*if(isset($_SESSION['POSCart'])){
			foreach ($_SESSION['POSCart'] as $index){
				$cart+= $index;
			}

		}*/

		if(isset($_SESSION['Discount'])){
			$count = count($_SESSION['Discount']);
			$sc = 1;
		}
		else{
			$sc = 0;
		}

		if($count>=$cart){
			echo "0";
		}
		else{
			if($sc==1){
				$add = array("PWD");
				array_push($_SESSION['Discount'],$add);
			}
			else{

				$_SESSION['Discount'] = array("PWD");
			}
			echo "1";
		}
			$count = count($_SESSION['Discount']);
			$num = count($_SESSION['Discount']);

			$ctr = $count;

			$sql = "Select * from mushroom_queue_orders where queue_code = '$code' and queue_paid='No'";
			$exist = $db->checkExist($sql);
				while ($rows = $db->fetch_array($exist)) {
					$cartItems = $rows['orders_quantity'];
					$food_price = $rows['orders_price'];
					$subtotal = $rows['orders_subtotal'];
					$foodName = $rows['orders_foods'];
					if($ctr > 0){
						if($ctr>=$cartItems){
							$ctr -= $cartItems;
							$discounted_food = (float)$food_price * (float)$cartItems;
							$discount_price = $discounted_food * 0.20;
							$discounted += $discount_price;
						}
						else{
							$discounted_food = (float)$food_price * (float)$ctr;
							$discount_price = $discounted_food * 0.20;
							$discounted += $discount_price;
							$ctr = 0;
						}
					}
					/*$qtyDiscount = $rows['orders_quantity'];
					$cart+= $qtyDiscount;*/
				}
			/*foreach ($_SESSION['POSCart'] as $cartItem => $cartItems) {
				$sql = "Select * from mushroom_foods where food_code = '$cartItem'";
				$exist = $db->checkExist($sql) or die(mysql_error());

				if($exist){
					$row = $db->fetch_array($exist);
					$food_price = $row['food_price'];
					$subtotal = (float)$food_price * (float)$cartItems;
					$foodName = $row['food_name'];

					if($ctr > 0){
						if($ctr>=$cartItems){
							$ctr -= $cartItems;
							$discounted_food = (float)$food_price * (float)$cartItems;
							$discount_price = $discounted_food * 0.20;
							$discounted += $discount_price;
						}
						else{
							$discounted_food = (float)$food_price * (float)$ctr;
							$discount_price = $discounted_food * 0.20;
							$discounted += $discount_price;
							$ctr = 0;
						}
					}
				}
			}*/
			echo "*".number_format($discounted,"2")."*";
			$total_price = 0;
			if(isset($_SESSION['Discount'])){
				$sql2 = "Select * from mushroom_queue_orders where queue_code = '$code' and queue_paid = 'No' ";
				$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = $db->fetch_array($exist2)){
							// $row2 = $db->fetch_array($exist2);
							$cartItems2 = $row2['orders_quantity'];
							$food_price2 = $row2['orders_price'];
							$subtotal2 = $row2['orders_subtotal'];
							$foodName2 = $row2['orders_foods'];
							$food_price2 = number_format($food_price2,"2");
							$subtotal2 = number_format($subtotal2,"2");
							$subtotal2 = floatval(str_replace(",","",$subtotal2));
							$total_price += $subtotal2;
						}
						
					}
				/*if(isset($_SESSION['POSCart'])){
					foreach ($_SESSION['POSCart'] as $cart2 => $cartItems2) {
						$sql2 = "Select * from mushroom_foods where food_code = '$cart2'";
						$exist2 = $db->checkExist($sql2) or die(mysql_error());

						if($exist2){

							$row2 = $db->fetch_array($exist2);
							$food_price2 = $row2['food_price'];
							$subtotal2 = (float)$food_price2 * (float)$cartItems2;
							$foodName2 = $row2['food_name'];
							$food_price2 = number_format($food_price2,"2");
							$subtotal2 = number_format($subtotal2,"2");
							$subtotal2 = floatval(str_replace(",","",$subtotal2));
							$total_price += $subtotal2;
						}
					}
				}*/
				echo number_format($total_price,"2")."bb";
			}
	}

	function discountPaymentReviewPwdID($db){

		$total = 0;
		$discount_price = 0;
		$count = 0;
		$cart = 0;
		$discounted = 0;
		$sc = 0;
		$ctr = 0;
		$code = $_SESSION['Discounted'];
		$sql1 = "Select * from mushroom_queue_orders where queue_code = '$code' and queue_paid='No'";
		$exist1 = $db->checkExist($sql1);
			while ($row1 = $db->fetch_array($exist1)) {
				$qtyDiscount = $row1['orders_quantity'];
				$cart+= $qtyDiscount;
			}

		if(isset($_SESSION['Discount'])){
			$count = count($_SESSION['Discount']);
			$sc = 1;
		}
		else{
			$sc = 0;
		}

		if($count>=$cart){
			echo "0";
		}
		else{
			if($sc==1){
				$add = array("PWD");
				array_push($_SESSION['Discount'],$add);
			}
			else{

				$_SESSION['Discount'] = array("PWD");
			}
			echo "1";
		}
			$count = count($_SESSION['Discount']);
			$num = count($_SESSION['Discount']);

			$ctr = $count;

			$sql = "Select * from mushroom_queue_orders where queue_code = '$code' and queue_paid='No'";
			$exist = $db->checkExist($sql);
				while ($rows = $db->fetch_array($exist)) {
					$cartItems = $rows['orders_quantity'];
					$food_price = $rows['orders_price'];
					$subtotal = $rows['orders_subtotal'];
					$foodName = $rows['orders_foods'];
					if($ctr > 0){
						if($ctr>=$cartItems){
							$ctr -= $cartItems;
							$discounted_food = (float)$food_price * (float)$cartItems;
							$discount_price = $discounted_food * 0.20;
							$discounted += $discount_price;
						}
						else{
							$discounted_food = (float)$food_price * (float)$ctr;
							$discount_price = $discounted_food * 0.20;
							$discounted += $discount_price;
							$ctr = 0;
						}
					}
				}

			echo "*".number_format($discounted,"2")."*";
			$total_price = 0;
			if(isset($_SESSION['Discount'])){
				$sql2 = "Select * from mushroom_queue_orders where queue_code = '$code' and queue_paid = 'No' ";
				$exist2 = $db->checkExist($sql2);
					if($exist2){
						while($row2 = $db->fetch_array($exist2)){
							// $row2 = $db->fetch_array($exist2);
							$cartItems2 = $row2['orders_quantity'];
							$food_price2 = $row2['orders_price'];
							$subtotal2 = $row2['orders_subtotal'];
							$foodName2 = $row2['orders_foods'];
							$food_price2 = number_format($food_price2,"2");
							$subtotal2 = number_format($subtotal2,"2");
							$subtotal2 = floatval(str_replace(",","",$subtotal2));
							$total_price += $subtotal2;
						}
						
					}

				echo number_format($total_price,"2");
			}
	}

	function discountPayment($db){

		//$code = $_GET['code'];
		$total_price = 0;
		if(isset($_SESSION['Discount'])){
			echo "discount*";
			unset($_SESSION['Discount']);

			if(isset($_SESSION['POSCart'])){
				foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$foodName = $row['food_name'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$subtotal = floatval(str_replace(",","",$subtotal));
						//$total_items += $cartItems;
						//echo $subtotal."?".$total_price;
						$total_price += $subtotal;
					}
				}
			}
			echo number_format($total_price,"2");
			/* $sql = "Select * from mushroom_queue_orders where queue_code = '$code' and queue_paid = 'No'";
			$exist = $db->checkExist($sql);
				while($row = $db->fetch_array($exist)){
					$food_price = $row['orders_price'];
					$subtotal = (float)$food_price * (float)$row['orders_quantity'];
					$total_price += $subtotal;
				}

				echo number_format($total_price,"2");		 */
		}
		else{
			echo "discounted*";

			$total = 0;
			$high = 0;
			$low = 0;
			if(isset($_SESSION['POSCart'])){
				foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$foodName = $row['food_name'];
						$low = $subtotal;
						//$cartItems = $row2['orders_quantity'];
						if($low>$high){
							$_SESSION['Discount'] = $foodName;
							$high = $subtotal;
						}
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						//$total_items += $cartItems;

						$total_price += $subtotal;

					}
				}
				$total = (float)$high * 0.20;
				echo number_format($total,"2");
			}
			/* $sql = "Select * from mushroom_queue where queue_code = '$code'";
			$exist = $db->checkExist($sql);

				if($exist){
					$sql1 = "Select * from mushroom_queue_orders where queue_code = '$code' and queue_paid ='No'";
					$exist1 = $db->checkExist($sql1);
					while($row = $db->fetch_array($exist1)){
						$subtotal = $row['orders_subtotal'];
						$food_name = $row['orders_foods'];
						$low = $subtotal;
						//$cartItems = $row2['orders_quantity'];
						if($low>$high){
							$_SESSION['Discount'] = $food_name;
							$high = $subtotal;
						}
					}
					//$food_price = number_format($food_price,"2");
					//$subtotal = number_format($subtotal,"2");

					//$subtotal = floatval(str_replace(",","",$subtotal));


					//$subtotal = (float)$food_price * (float)$cartItems;
					$total = (float)$high * 0.20;
					echo number_format($total,"2");
				} */


		}
	}

	function discountTakeout($db){

		$total_price = 0;
		if(isset($_SESSION['Discount'])){
			echo "discount*";
			unset($_SESSION['Discount']);

			if(isset($_SESSION['POSCart'])){
				foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$foodName = $row['food_name'];
						$food_price = number_format($food_price,"2");
						//$subtotal = number_format($subtotal,"2");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal;
					}
				}
			}
			echo number_format($total_price,"2");

		}
		else{
			echo "discounted*";

			$total = 0;
			$high = 0;
			$low = 0;
			if(isset($_SESSION['POSCart'])){
				foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$foodName = $row['food_name'];
						$low = $subtotal;
						if($low>$high){
							$_SESSION['Discount'] = $foodName;
							$high = $subtotal;
						}
						$food_price = number_format($food_price,"2");
						//$subtotal = number_format($subtotal,"2");

						$total_price += $subtotal;

					}
				}
				$total = (float)$high * 0.20;
				echo number_format($total,"2");
			}
		}
	}

	function viewQueue($db){
		$sql = "Select * from mushroom_queue order by queue_seconds ASC";
		$exist = $db->checkExist($sql);
		$check = $db->get_rows($exist);
			if($check>=1){
				while($row = $db->fetch_array($exist)){
						$code = $row['queue_code'];
						$type = $row['queue_type'];
						$table = $row['queue_table'];
						$secs = $row['queue_seconds'];
						$paid = $row['queue_paid'];
						date_default_timezone_set('Asia/Manila');
						$date = date("l <\b\\r> M. d, Y, h:i A", $secs);
						if($paid=="No"){
							$style = "background-color:#fff; cursor:pointer;";
						}
						else{
							$style = "background-color:#5cb85c; cursor:pointer;";
						}
						if($type=="Dine-in"){
							echo "<tr style='$style' id='$code' onclick='showQueue(this.id);'>
									<td class='col-xs-1'><label style='position:relative; top:10px;'>table #</label><h3 style='position:relative; left:35px; font-size:45pt;'>$table</h3></td>
									<td class='col-xs-2'><strong>$code</strong><br/><label style='font-weight:normal; cursor:pointer;'>$date</label></td>
									<td class='col-xs-1'><i  class='fa fa-cutlery fa-5x'></i></td>
								  </tr>";
						}
						else if($type=="Take-out"){
							echo "<tr style='$style' id='$code' onclick='showQueue(this.id);'>
									<td class='col-xs-1'><label style='position:relative; top:10px;'>$type</label><h3 style='position:relative; left:35px; font-size:45pt;'><i  class='fa fa-shopping-basket fa-1x'></h3></td>
									<td class='col-xs-2'><strong>$code</strong><br/><label style='font-weight:normal; cursor:pointer;'>$date</label></td>
									<td class='col-xs-1'><i  class='fa fa-cutlery fa-5x'></i></td>
								  </tr>";
						}
						else{
							echo "<tr style='$style' id='$code' onclick='showQueue(this.id);'>
									<td class='col-xs-1'><label style='position:relative; top:10px;'>$type</label><h3 style='position:relative; left:35px; font-size:45pt;'><i  class='fa fa-motorcycle fa-1x'></h3></td>
									<td class='col-xs-2'><strong>$code</strong><br/><label style='font-weight:normal; cursor:pointer;'>$date</label></td>
									<td class='col-xs-1'><i  class='fa fa-cutlery fa-5x'></i></td>
								  </tr>";
						}
				}
			}
			else{
				echo "<td class='col-xs-1' style='font-size:14pt; font-weight:bold;' align='center'>NO DATA FOUND</td>";
			}
	}

	function printReceipt($db){
		$code = $_GET["code"];
		$payment = $_GET["payment"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$cashier = "";
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setTextSize(1,1);
			$printer->text("Order ID. $code\n");
			$printer->text("Order Type: Walk-in\n");
			$printer->text("Cashier: $cashier\n");
			$printer->text("$date             $time\n");
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();
			if(isset($_SESSION['POSCart'])){
				foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$foodName = $row['food_name'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
								//$db->set_foodCode($cart);
								//$db->set_foodImage($row['food_image']);
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						$total_price += $subtotal;
					}
				}
			}
			$total_price = number_format($total_price,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item Sold: $total_items\n");
			$printer->text("Total: $total_price\n");
			$printer->text("Payment: $payment\n");
			$change = $payment - $total_price;
			$change = ((double)$payment - (double)$total_price);
			$change = number_format($change,"2");
			$printer->text("Change Due: $change\n\n");

			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->setEmphasis(true);
			$printer->text("-------------CLOSED-------------\n\n");
			$printer->setTextSize(1,1);
			$printer->setEmphasis(false);
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("Thank You\n");
			$printer->text("Please Come Again\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();
			unset($_SESSION['POSCart']);

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}
	/* function printPaymentDineReceipt($db){
		$payment = $_GET["payment"];
		$table = $_GET["table"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$secs = time();
		$cashier = "";



		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql4 = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist4 = $db->checkExist($sql4);
			if($exist4){
				$num = $db->get_rows($exist4);
					if($num>=1){
						$row = $db->fetch_array($exist4);
						$cashier = $row['admin_firstname'];
					}

			}
		}

		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();


			if(isset($_SESSION['POSCart'])){
			generate6:
			$total_price = 0;
			$code = $db->generateCode();
			$sql = "Select * from mushroom_delivery where delivery_code = '$code'";
			$exist = $db->checkExist($sql);
			$check = $db->get_rows($exist);
				if($check>=1){
					goto generate6;
				}
				else{
					$sql2 = "Insert into mushroom_queue values('$code','Dine-in','$table','','','','$secs','','Yes')";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						$printer->setTextSize(1,2);
						$printer->text("-------------------------------\n");
						$printer->setTextSize(1,1);
						$printer->text("Order ID. $code\n");
						$printer->text("Table No. $table\n");
						$printer->text("Order Type: Dine-in\n");
						$printer->text("Cashier: $cashier\n");
						$printer->text("$date              $time\n");
						$printer -> setJustification();
						$printer->setTextSize(1,2);
						$printer->text("-------------------------------\n");
						$printer->setEmphasis(false);
						$printer->setTextSize(1,1);
						$printer -> setJustification();
						$printer->feed();
						foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
							$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
							$exist1 = $db->checkExist($sql1);

							if($exist1){
								$row2 = $db->fetch_array($exist1);
								$food_price = $row2['food_price'];
								$sql3 = "";
								$subtotal = "";
								if(isset($_SESSION['Discount'])){
									$discountedOrder = $_SESSION['Discount'];
									$food = $row2['food_name'];
									if($food==$discountedOrder){

										$subtotal = (float)$food_price * (float)$cartItems;
										$subtotal =  floatval(str_replace(",","",$subtotal));
										$discounted = $subtotal * 0.20;
										$subtotal = $subtotal - $discounted;
										$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','Yes')";
										$food = $food."(20%)";
									}
									else{
										//$subtotal = $row2['orders_subtotal'];
										$subtotal = (float)$food_price * (float)$cartItems;
										$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','No')";
									}
								}
								else{
									//$subtotal = $row2['orders_subtotal'];
									$subtotal = (float)$food_price * (float)$cartItems;
									$food = $row2['food_name'];

									$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','No')";
								}




								$exist3 = $db->checkExist($sql3);
								$food_price = number_format($food_price,"2");
								$subtotal = number_format($subtotal,"2");
								$total_items += $cartItems;
								$printer->setTextSize(1,1);
								$printer->text("$cartItems   $food @$food_price\n");
								$printer->text("        *$subtotal\n");
								$subtotal = floatval(str_replace(",","",$subtotal));
								$total_price += $subtotal;
							}
						}

					}
				}
		}



			$total_price = number_format($total_price,"2");
			$payment = number_format($payment,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item Sold: $total_items\n");
			$printer->text("Total: $total_price\n");
			$printer->text("Payment: $payment\n");
			$payment = floatval(str_replace(",","",$payment));
			$total_price = floatval(str_replace(",","",$total_price));
			$change = ((double)$payment - (double)$total_price);
			$change = number_format($change,"2");
			$printer->text("Change Due: $change\n\n");

			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->setEmphasis(true);
			$printer->text("-------------CLOSED-------------\n\n");
			$printer->setTextSize(1,1);
			$printer->setEmphasis(false);
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("Thank You\n");
			$printer->text("Please Come Again\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();

			$datePaid = date('F d, Y');
			$time = date('h:i A');
			$dateSales = date('ymd');
			$secs = time();

			$sql6 = "Update mushroom_tables set table_status ='occupied' where table_number ='$table'";
			$exist6 = $db->checkExist($sql6);

			$activity = "Paid and queued order ($code)";
			$db->activity_log($activity);

			/* $sql4 = "Insert into mushroom_delivery values('$code','Dine-in','$table','$customer','$username','$contact','$datePaid','$dateSales','$time','$secs','$address','Completed','No','$admin','No')";
			$exist4 = $db->checkExist($sql4);
			$sql5 = "Select * from mushroom_queue_orders where queue_code = '$code'";
			$exist5 = $db->checkExist($sql5);
				while($row2 = $db->fetch_array($exist5)){
						$food_price = $row2['orders_price'];
						$subtotal = $row2['orders_subtotal'];
						$foodName = $row2['orders_foods'];
						$cartItems = $row2['orders_quantity'];
						$sql6 = "Insert into mushroom_orders values('$code','$foodName','$cartItems','$food_price','$subtotal')";
						$exist6 = $db->checkExist($sql6);
					}
			//$sql7 = "Delete from mushroom_queue where queue_code = '$code' ";
			//$exist7 = $db->checkExist($sql7);

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	} */

	function printPaymentDineReceipt($db){
		$payment = $_GET["payment"];
		$table = $_GET["table"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$secs = time();
		$cashier = "";



		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql4 = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist4 = $db->checkExist($sql4);
			if($exist4){
				$num = $db->get_rows($exist4);
					if($num>=1){
						$row = $db->fetch_array($exist4);
						$cashier = $row['admin_firstname'];
					}

			}
		}

		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();


			if(isset($_SESSION['POSCart'])){
			generate6:
			$total_price = 0;
			$code = $db->generateCode();
			$sql = "Select * from mushroom_delivery where delivery_code = '$code'";
			$exist = $db->checkExist($sql);
			$check = $db->get_rows($exist);
				if($check>=1){
					goto generate6;
				}
				else{
					$sql2 = "Insert into mushroom_queue values('$code','Dine-in','$table','','','','$secs','','Yes')";
					$exist2 = $db->checkExist($sql2);
					if($exist2){
						$printer->setTextSize(1,2);
						$printer->text("-------------------------------\n");
						$printer->setTextSize(1,1);
						$printer->text("Order ID. $code\n");
						$printer->text("Table No. $table\n");
						$printer->text("Order Type: Dine-in\n");
						$printer->text("Cashier: $cashier\n");
						$printer->text("$date              $time\n");
						$printer -> setJustification();
						$printer->setTextSize(1,2);
						$printer->text("-------------------------------\n");
						$printer->setEmphasis(false);
						$printer->setTextSize(1,1);
						$printer -> setJustification();
						$printer->feed();

						if(isset($_SESSION['Discount'])){
							$ctr = count($_SESSION['Discount']);
						}

						foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
							$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
							$exist1 = $db->checkExist($sql1);

							if($exist1){
								$row2 = $db->fetch_array($exist1);
								$food_price = $row2['food_price'];
								$sql3 = "";
								$subtotal = "";
								if(isset($_SESSION['Discount'])){
									$discountedOrder = $_SESSION['Discount'];
									$food = $row2['food_name'];

									if($ctr > 0){
										if($ctr>=$cartItems){
											$ctr -= $cartItems;
											$subtotal = (float)$food_price * (float)$cartItems;
											$subtotal =  floatval(str_replace(",","",$subtotal));
											$discounted = $subtotal * 0.20;
											$subtotal = $subtotal - $discounted;
											$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','Yes')";
											$food = $food."(20%)";
											/* $discounted_food = (float)$food_price * (float)$cartItems;
											$discount_price = $discounted_food * 0.20;
											$discounted += $discount_price; */

										}
										else{
											$discounted_subtotal = 0;
											$cartQty = (int)$cartItems - (int)$ctr;
											$subtotal = (float)$food_price * (float)$cartQty;
											$discounted_subtotal += $subtotal;
											$sqli = "Insert into mushroom_queue_orders values('$code','$food','$cartQty','$food_price','$subtotal','Yes','No')";
											$exists3 = $db->checkExist($sqli);

											$subtotal = (float)$food_price * (float)$ctr;
											$subtotal =  floatval(str_replace(",","",$subtotal));
											$discounted = $subtotal * 0.20;
											$subtotal = $subtotal - $discounted;
											$discounted_subtotal += $subtotal;
											$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$ctr','$food_price','$subtotal','Yes','Yes')";
											$food = $food."(20% - ".$ctr."x)";
											/* $discounted_food = (float)$food_price * (float)$ctr;
											$discount_price = $discounted_food * 0.20;
											$discounted += $discount_price; */
											$ctr = 0;
											//echo "\n".$ctr."c";
											$subtotal = $discounted_subtotal;
										}

									}
									else{
										$subtotal = (float)$food_price * (float)$cartItems;
										$food = $row2['food_name'];

										$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','No')";
									}

									/* if($food==$discountedOrder){

										$subtotal = (float)$food_price * (float)$cartItems;
										$subtotal =  floatval(str_replace(",","",$subtotal));
										$discounted = $subtotal * 0.20;
										$subtotal = $subtotal - $discounted;
										$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','Yes')";
										$food = $food."(20%)";
									}
									else{

										$subtotal = (float)$food_price * (float)$cartItems;
										$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','No')";
									}	 */
								}
								else{

									$subtotal = (float)$food_price * (float)$cartItems;
									$food = $row2['food_name'];

									$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','No')";
								}




								$exist3 = $db->checkExist($sql3);
								$food_price = number_format($food_price,"2");
								$subtotal = number_format($subtotal,"2");
								$total_items += $cartItems;
								$printer->setTextSize(1,1);
								$printer->text("$cartItems   $food @$food_price\n");
								$printer->text("        *$subtotal\n");
								$subtotal = floatval(str_replace(",","",$subtotal));
								$total_price += $subtotal;
							}
						}

					}
				}
		}



			$total_price = number_format($total_price,"2");
			$payment = number_format($payment,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item Sold: $total_items\n");
			$printer->text("Total: $total_price\n");
			$printer->text("Payment: $payment\n");
			$payment = floatval(str_replace(",","",$payment));
			$total_price = floatval(str_replace(",","",$total_price));
			$change = ((double)$payment - (double)$total_price);
			$change = number_format($change,"2");
			$printer->text("Change Due: $change\n\n");

			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->setEmphasis(true);
			$printer->text("-------------CLOSED-------------\n\n");
			$printer->setTextSize(1,1);
			$printer->setEmphasis(false);
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("Thank You\n");
			$printer->text("Please Come Again\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();

			$datePaid = date('F d, Y');
			$time = date('h:i A');
			$dateSales = date('ymd');
			$secs = time();

			$sql6 = "Update mushroom_tables set table_status ='occupied' where table_number ='$table'";
			$exist6 = $db->checkExist($sql6);

			$activity = "Paid and queued order ($code)";
			$db->activity_log($activity);


		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function printPaymentTakeoutReceipt($db){
		$payment = $_GET["payment"];
		/* $table = $_GET["table"]; */
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		//$time = date("h:iA");
		$datePaid = date('F d, Y');
		$time = date('h:i A');
		$dateSales = date('ymd');
		$secs = time();
		$cashier = "";



		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql4 = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist4 = $db->checkExist($sql4);
			if($exist4){
				$num = $db->get_rows($exist4);
					if($num>=1){
						$row = $db->fetch_array($exist4);
						$cashier = $row['admin_firstname'];
					}

			}
		}

		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();


			if(isset($_SESSION['POSCart'])){
			generate6:
			$total_price = 0;
			$code = $db->generateCode();
			$sql = "Select * from mushroom_delivery where delivery_code = '$code'";
			$exist = $db->checkExist($sql);
			$check = $db->get_rows($exist);
				if($check>=1){
					goto generate6;
				}
				else{
					$sql2 = "Insert into mushroom_delivery values('$code','Take-out','','','','','$datePaid','$dateSales','$time','$secs','','Completed','No','$admin','No')";
					$exist2 = $db->checkExist($sql2);
					if($exist2){

						$printer->setTextSize(1,2);
						$printer->text("-------------------------------\n");
						$printer->setTextSize(1,1);
						$printer->text("Order ID. $code\n");
						$printer->text("Order Type: Take-out\n");
						$printer->text("Cashier: $cashier\n");
						$printer->text("$date              $time\n");
						$printer -> setJustification();
						$printer->setTextSize(1,2);
						$printer->text("-------------------------------\n");
						$printer->setEmphasis(false);
						$printer->setTextSize(1,1);
						$printer -> setJustification();
						$printer->feed();
						$ctr = 0;
						if(isset($_SESSION['Discount'])){
							$ctr = count($_SESSION['Discount']);
						}
						foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
							$sql1 = "Select * from mushroom_foods where food_code = '$cart'";
							$exist1 = $db->checkExist($sql1);

							if($exist1){
								$row2 = $db->fetch_array($exist1);
								$food_price = $row2['food_price'];
								$subtotal = (float)$food_price * (float)$cartItems;
								$sql3 = "";
								$food = $row2['food_name'];

								$sql5= "Select * from mushroom_summary where summary_date = '$dateSales' and summary_foods='$food'";
								$exist5 = $db->checkExist($sql5) or die(mysql_error());
								$get_rows5 = $db->get_rows($exist5);
									if($get_rows5>=1){
										$rows = $db->fetch_array($exist5);
										$quantity = intval($rows['summary_quantity']);
										$quantity += $cartItems;
										$sql6 = "Update mushroom_summary set summary_quantity ='$quantity' where summary_date = '$dateSales' and summary_foods='$food'";
										$exist6 = $db->checkExist($sql6) or die(mysql_error());

									}
									else{
										$sql6 = "Insert into mushroom_summary values('$food','$cartItems','$dateSales','$secs')";
										$exist6 = $db->checkExist($sql6) or die(mysql_error());

									}

								if(isset($_SESSION['Discount'])){
									$discountedOrder = $_SESSION['Discount'];

									if($ctr > 0){
										if($ctr>=$cartItems){
											$ctr -= $cartItems;
											$subtotal = (float)$food_price * (float)$cartItems;
											$subtotal =  floatval(str_replace(",","",$subtotal));
											$discounted = $subtotal * 0.20;
											$subtotal = $subtotal - $discounted;
											// $sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','Yes')";
											$food = $food."(20%)";			
											$sql3 = "Insert into mushroom_orders values('$code','$food','$cartItems','$food_price','$subtotal')";																	
										}
										else{
											$discounted_subtotal = 0;
											$cartQty = (int)$cartItems - (int)$ctr;
											$subtotal = (float)$food_price * (float)$cartQty;
											$discounted_subtotal += $subtotal;
											// $sqli = "Insert into mushroom_queue_orders values('$code','$food','$cartQty','$food_price','$subtotal','Yes','No')";
											$sqli = "Insert into mushroom_orders values('$code','$food','$cartQty','$food_price','$subtotal')";
											$exists3 = $db->checkExist($sqli);

											$subtotal = (float)$food_price * (float)$ctr;
											$subtotal =  floatval(str_replace(",","",$subtotal));
											$discounted = $subtotal * 0.20;
											$subtotal = $subtotal - $discounted;
											$discounted_subtotal += $subtotal;
											// $sql3 = "Insert into mushroom_queue_orders values('$code','$food','$ctr','$food_price','$subtotal','Yes','Yes')";
											$food1 = $food."(20%)";			
											$sql3 = "Insert into mushroom_orders values('$code','$food1','$ctr','$food_price','$subtotal')";
											$food = $food."(20% - ".$ctr."x)";											
											/* $discounted_food = (float)$food_price * (float)$ctr;
											$discount_price = $discounted_food * 0.20;
											$discounted += $discount_price; */
											$ctr = 0;
											//echo "\n".$ctr."c";
											$subtotal = $discounted_subtotal;
										}
									}
									else{
										$subtotal = (float)$food_price * (float)$cartItems;
										$food = $row2['food_name'];

										// $sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','No')";
										$sql3 = "Insert into mushroom_orders values('$code','$food','$cartItems','$food_price','$subtotal')";
									}				
								}
								else{
									//$subtotal = $row2['orders_subtotal'];
									$food = $row2['food_name'];
									$sql3 = "Insert into mushroom_orders values('$code','$food','$cartItems','$food_price','$subtotal')";
								}
								//$food = $row2['food_name'];
								//$sql3 = "Insert into mushroom_orders values('$code','$food','$cartItems','$food_price','$subtotal')";
								$exist3 = $db->checkExist($sql3);
								$food_price = number_format($food_price,"2");
								$subtotal = number_format($subtotal,"2");
								$total_items += $cartItems;
								$printer->setTextSize(1,1);
								$printer->text("$cartItems   $food @$food_price\n");
								$printer->text("        *$subtotal\n");
								$subtotal = floatval(str_replace(",","",$subtotal));
								$total_price += $subtotal;
							}
						}

						$activity = "Paid and queued order/takeout ($code)";
						$db->activity_log($activity);

					}
				}
		}



			$total_price = number_format($total_price,"2");
			$payment = number_format($payment,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item Sold: $total_items\n");
			$printer->text("Total: $total_price\n");
			$printer->text("Payment: $payment\n");
			$payment = floatval(str_replace(",","",$payment));
			$total_price = floatval(str_replace(",","",$total_price));
			$change = ((double)$payment - (double)$total_price);
			$change = number_format($change,"2");
			$printer->text("Change Due: $change\n\n");

			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->setEmphasis(true);
			$printer->text("-------------CLOSED-------------\n\n");
			$printer->setTextSize(1,1);
			$printer->setEmphasis(false);
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("Thank You\n");
			$printer->text("Please Come Again\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();



		/* 	$sql6 = "Update mushroom_tables set table_status ='occupied' where table_number ='$table'";
			$exist6 = $db->checkExist($sql6); */


		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}
	function printDineReceipt($db){
		$code = $_GET["code"];
		$payment = $_GET["payment"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$cashier = "";
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$sql1 = "Select * from mushroom_queue where queue_code = '$code'";
			$exist1 = $db->checkExist($sql1) or die(mysql_error());
				if($exist1){
					$row1 = $db->fetch_array($exist1);
					$table = $row1['queue_table'];
					$type = $row1['queue_type'];
					$customer = $row1['queue_customer'];
					$username = $row1['queue_username'];
					$contact = $row1['queue_contact'];
					$address = $row1['queue_address'];
				}

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setTextSize(1,1);
			$printer->text("Order ID. $code\n");
			$printer->text("Table No. $table\n");
			$printer->text("Order Type: $type\n");
			$printer->text("Cashier: $cashier\n");
			$printer->text("$date             $time\n");
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();
			$total_price = 0;
			$sql2 = "Select * from mushroom_queue_orders where queue_code = '$code' AND queue_paid ='No'";
			$exist2 = $db->checkExist($sql2);
				if(isset($_SESSION['Discount'])){
					$ctr = count($_SESSION['Discount']);
				}
				if($exist2){
					while($row2 = $db->fetch_array($exist2)){
						$cartItems = $row2['orders_quantity'];
						$food_price = $row2['orders_price'];						
						if(isset($_SESSION['Discount'])){
							$discountedOrder = $_SESSION['Discount'];
							$food = $row2['orders_foods'];

							if($ctr > 0){
								if($ctr>=$cartItems){
									$ctr -= $cartItems;
									$subtotal = (float)$food_price * (float)$cartItems;
									$subtotal =  floatval(str_replace(",","",$subtotal));
									$discounted = $subtotal * 0.20;
									$subtotal = $subtotal - $discounted;
									$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','Yes')";
									$food = $food."(20%)";
								}
								else{
									$discounted_subtotal = 0;
									$cartQty = (int)$cartItems - (int)$ctr;
									$subtotal = (float)$food_price * (float)$cartQty;
									$discounted_subtotal += $subtotal;
									$sqli = "Insert into mushroom_queue_orders values('$code','$food','$cartQty','$food_price','$subtotal','Yes','No')";
									$exists3 = $db->checkExist($sqli);

									$subtotal = (float)$food_price * (float)$ctr;
									$subtotal =  floatval(str_replace(",","",$subtotal));
									$discounted = $subtotal * 0.20;
									$subtotal = $subtotal - $discounted;
									$discounted_subtotal += $subtotal;
									$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$ctr','$food_price','$subtotal','Yes','Yes')";
									$food = $food."(20% - ".$ctr."x)";
									$ctr = 0;
									$subtotal = $discounted_subtotal;
								}
							}
							else{
								$subtotal = (float)$food_price * (float)$cartItems;
								$food = $row2['orders_foods'];	

								$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','No')";
							}					
						}
						else{
							$subtotal = $row2['orders_subtotal'];
							$food = $row2['orders_foods'];
							$subtotal = (float)$food_price * (float)$cartItems;
							// $food = $row2['food_name'];
							$sql3 = "Insert into mushroom_queue_orders values('$code','$food','$cartItems','$food_price','$subtotal','Yes','No')";
						}
						
						$exist3 = $db->checkExist($sql3);
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->text("$cartItems   $food @$food_price\n");
						$printer->text("        *$subtotal\n");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal;

					}
				}

			$total_price = number_format($total_price,"2");
			$payment = number_format($payment,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item Sold: $total_items\n");
			$printer->text("Total: $total_price\n");
			$printer->text("Payment: $payment\n");
			$payment = floatval(str_replace(",","",$payment));
			$total_price = floatval(str_replace(",","",$total_price));
			$change = ((double)$payment - (double)$total_price);
			$change = number_format($change,"2");
			$printer->text("Change Due: $change\n\n");

			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->setEmphasis(true);
			$printer->text("-------------CLOSED-------------\n\n");
			$printer->setTextSize(1,1);
			$printer->setEmphasis(false);
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("Thank You\n");
			$printer->text("Please Come Again\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();

			$datePaid = date('F d, Y');
			$time = date('h:i A');
			$dateSales = date('ymd');
			$secs = time();

			$sql4 = "Update mushroom_queue set queue_paid ='Yes' where queue_code ='$code'";
			$exist4 = $db->checkExist($sql4) or die(mysql_error());
			

			//$sql3 = "Update mushroom_tables set table_status ='vacant' where table_number ='$table'";
			//$exist3 = $db->checkExist($sql3);
			//$sql4 = "Insert into mushroom_delivery values('$code','Dine-in','$table','$customer','$username','$contact','$datePaid','$dateSales','$time','$secs','$address','Completed','No','$admin','No')";
			//$exist4 = $db->checkExist($sql4);
			$sql5 = "Select * from mushroom_queue_orders where queue_code = '$code'";
			$exist5 = $db->checkExist($sql5);
				while($row2 = $db->fetch_array($exist5)){
						$food_price = $row2['orders_price'];
						$subtotal = $row2['orders_subtotal'];
						$foodName = $row2['orders_foods'];
						$cartItems = $row2['orders_quantity'];
						//$sql6 = "Insert into mushroom_orders values('$code','$foodName','$cartItems','$food_price','$subtotal')";
						//$exist6 = $db->checkExist($sql6);
					}
			$sql6 = "Delete from mushroom_queue_orders where queue_code = '$code' AND queue_paid = 'No'";
			$exist6 = $db->checkExist($sql6);					
			/* $sql7 = "Delete from mushroom_queue where queue_code = '$code' ";
			$exist7 = $db->checkExist($sql7); */

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function finishOrder($db){
		$code = $_GET['code'];
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		date_default_timezone_set('Asia/Manila');
		$datePaid = date('F d, Y');
		$time = date('h:i A');
		$dateSales = date('ymd');
		$secs = time();
		$cartItemsSummarry = "";
		$sql1 = "Select * from mushroom_queue where queue_code = '$code'";
		$exist1 = $db->checkExist($sql1) or die(mysql_error());
			if($exist1){
				$row1 = $db->fetch_array($exist1);
				$table = $row1['queue_table'];
				$type = $row1['queue_type'];
				$customer = $row1['queue_customer'];
				$username = $row1['queue_username'];
				$contact = $row1['queue_contact'];
				$address = $row1['queue_address'];
			}

			$sql3 = "Update mushroom_tables set table_status ='vacant' where table_number ='$table'";
			$exist3 = $db->checkExist($sql3) or die(mysql_error());
			$sql4 = "Insert into mushroom_delivery values('$code','Dine-in','$table','$customer','$username','$contact','$datePaid','$dateSales','$time','$secs','$address','Completed','No','$admin','No')";
			$exist4 = $db->checkExist($sql4) or die(mysql_error());
			$sql5 = "Select * from mushroom_queue_orders where queue_code = '$code'";
			$exist5 = $db->checkExist($sql5) or die(mysql_error());

				while($row2 = $db->fetch_array($exist5)){

						$food_price = $row2['orders_price'];
						$subtotal = $row2['orders_subtotal'];
						$foodName = $row2['orders_foods'];
						$cartItems = $row2['orders_quantity'];
						$cartItemsSummarry = $cartItems;
						$discountedOrder = $row2['queue_discount'];
						$sql8 = "Select * from mushroom_orders where delivery_code = '$code' and order_foods ='$foodName'";
						$exist8 = $db->checkExist($sql8)or die(mysql_error());
						$num2 = $db->get_rows($exist8);

						if($num2>=1){
							$rows2 = $db->fetch_array($exist8);

							$qty = $rows2['order_quantity'];
							//echo $qty." ";
							$qty = floatval(str_replace(",","",$qty));
							$totals =$rows2['order_subtotal'];
							/* echo $totals." ";
							echo $cartItems." ";
							echo $subtotal." "; */
							$totals = floatval(str_replace(",","",$totals));
							$cartItems += $qty;
							$subtotal += $totals;
							//echo $cartItems." ";echo $subtotal." ";
							$sql9 = "Update mushroom_orders set order_quantity ='$cartItems',order_subtotal='$subtotal' where delivery_code ='$code' and order_foods ='$foodName'";
							$exist9 = $db->checkExist($sql9) or die(mysql_error());
						}
						else{
							echo $discountedOrder;
							if($discountedOrder=="Yes"){
								/* $subtotal =  floatval(str_replace(",","",$subtotal));
								echo $subtotal."?";
								$discounted = $subtotal * 0.20;
								echo $discounted." ";
								//$subtotal = $subtotal - $discounted;
								//echo $subtotal; */
								$foodName.="(20%)";
								$sql6 = "Insert into mushroom_orders values('$code','$foodName','$cartItems','$food_price','$subtotal')";
								$exist6 = $db->checkExist($sql6) or die(mysql_error());
								//$sql3 = "Insert into mushroom_orders values('$code','$food','$cartItems','$food_price','$subtotal')";
							}
							else{
								$sql6 = "Insert into mushroom_orders values('$code','$foodName','$cartItems','$food_price','$subtotal')";
								$exist6 = $db->checkExist($sql6) or die(mysql_error());
								//$subtotal = $row2['orders_subtotal'];
								//$sql3 = "Insert into mushroom_orders values('$code','$food','$cartItems','$food_price','$subtotal')";
							}
							/* if(isset($_SESSION['Discount'])){
									$discountedOrder = $_SESSION['Discount'];

									if($food==$discountedOrder){

										$subtotal =  floatval(str_replace(",","",$subtotal));
										$discounted = $subtotal * 0.20;
										$subtotal = $subtotal - $discounted;
										$food.="(20%)";
										$sql3 = "Insert into mushroom_orders values('$code','$food','$cartItems','$food_price','$subtotal')";
									}
									else{
										//$subtotal = $row2['orders_subtotal'];

										$sql3 = "Insert into mushroom_orders values('$code','$food','$cartItems','$food_price','$subtotal')";
									}
								}
								else{
									//$subtotal = $row2['orders_subtotal'];
									$food = $row2['food_name'];
									$sql3 = "Insert into mushroom_orders values('$code','$food','$cartItems','$food_price','$subtotal')";
								} */

							//echo "a".$code." ".$foodName." ".$cartItems." ".$food_price." ".$subtotal;
						}

						$foods = explode("(20%)",$foodName);
						$foodName = $foods[0];
						$sql10= "Select * from mushroom_summary where summary_date = '$dateSales' and summary_foods='$foodName'";
						$exist10 = $db->checkExist($sql10) or die(mysql_error());
						$get_rows10 = $db->get_rows($exist10);
							if($get_rows10>=1){
								$rows = $db->fetch_array($exist10);
								$quantitySummary = intval($rows['summary_quantity']);
								$quantitySummary += $cartItemsSummarry;
								$sql11 = "Update mushroom_summary set summary_quantity ='$quantitySummary' where summary_date = '$dateSales' and summary_foods='$foodName'";
								$exist11 = $db->checkExist($sql11) or die(mysql_error());
							}
							else{
								$sql11 = "Insert into mushroom_summary values('$foodName','$cartItems','$dateSales','$secs')";
								$exist11 = $db->checkExist($sql11) or die(mysql_error());
							}
						//echo "A";
					}

			$sql7 = "Delete from mushroom_queue where queue_code = '$code' ";
			$exist7 = $db->checkExist($sql7);
			$sql12 = "Delete from mushroom_queue_orders where queue_code = '$code' ";
			$exist12 = $db->checkExist($sql12);

			$activity = "Finished order($code)";
			$db->activity_log($activity);


	}

	function printOutReceipt($db){
		$code = $_GET["code"];
		$payment = $_GET["payment"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$cashier = "";
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$sql1 = "Select * from mushroom_queue where queue_code = '$code'";
			$exist1 = $db->checkExist($sql1) or die(mysql_error());
				if($exist1){
					$row1 = $db->fetch_array($exist1);
					$table = $row1['queue_table'];
					$type = $row1['queue_type'];
					$customer = $row1['queue_customer'];
					$username = $row1['queue_username'];
					$contact = $row1['queue_contact'];
					$address = $row1['queue_address'];
				}

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setTextSize(1,1);
			$printer->text("Order ID. $code\n");
			$printer->text("Order Type: $type\n");
			$printer->text("Cashier: $cashier\n");
			$printer->text("$date             $time\n");
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();

			$sql2 = "Select * from mushroom_queue_orders where queue_code = '$code'";
			$exist2 = $db->checkExist($sql2);
				if($exist2){
					while($row2 = $db->fetch_array($exist2)){
						$food_price = $row2['orders_price'];
						$subtotal = $row2['orders_subtotal'];
						$foodName = $row2['orders_foods'];
						$cartItems = $row2['orders_quantity'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal;

					}
				}

			$total_price = number_format($total_price,"2");
			$payment = number_format($payment,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item Sold: $total_items\n");
			$printer->text("Total: $total_price\n");
			$printer->text("Payment: $payment\n");
			$payment = floatval(str_replace(",","",$payment));
			$total_price = floatval(str_replace(",","",$total_price));
			$change = ((double)$payment - (double)$total_price);
			$change = number_format($change,"2");
			$printer->text("Change Due: $change\n\n");

			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->setEmphasis(true);
			$printer->text("-------------CLOSED-------------\n\n");
			$printer->setTextSize(1,1);
			$printer->setEmphasis(false);
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("Thank You\n");
			$printer->text("Please Come Again\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();

			$datePaid = date('F d, Y');
			$time = date('h:i A');
			$dateSales = date('ymd');
			$secs = time();

			$sql3 = "Update mushroom_tables set table_status ='vacant' where table_number ='$table'";
			$exist3 = $db->checkExist($sql3);
			$sql4 = "Insert into mushroom_delivery values('$code','Take-out','$table','$customer','$username','$contact','$datePaid','$dateSales','$time','$secs','$address','Completed','No','$admin','No')";
			$exist4 = $db->checkExist($sql4);
			$sql5 = "Select * from mushroom_queue_orders where queue_code = '$code'";
			$exist5 = $db->checkExist($sql5);
				while($row2 = $db->fetch_array($exist5)){
						$food_price = $row2['orders_price'];
						$subtotal = $row2['orders_subtotal'];
						$foodName = $row2['orders_foods'];
						$cartItems = $row2['orders_quantity'];
						$sql6 = "Insert into mushroom_orders values('$code','$foodName','$cartItems','$food_price','$subtotal')";
						$exist6 = $db->checkExist($sql6);
					}
			$sql7 = "Delete from mushroom_queue where queue_code = '$code' ";
			$exist7 = $db->checkExist($sql7);

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function printOrdersDine($db,$table,$type){

		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$cashier = "";
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer->setTextSize(2,3);
			$printer->text("Table No.\n");
			$printer->setTextSize(3,2);
			$printer->text("$table\n");
			$printer->feed();
			$printer->setTextSize(1,2);
			$printer->text("Order Type: $type\n\n");
			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->text("$date              $time\n");
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();
			if(isset($_SESSION['POSCart'])){
				foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$foodName = $row['food_name'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->setTextSize(1,3);
						$printer->text("{$cartItems}x   $foodName \n");
					}
				}
			}


			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->setEmphasis(true);
			$printer->text("\n");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item(s): $total_items\n");

			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();


		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function printOrdersTakeout($db,$type){

		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$cashier = "";
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();


			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer->feed();
			$printer->setTextSize(1,2);
			$printer->text("Order Type: $type\n\n");
			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->text("$date              $time\n");
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();
			if(isset($_SESSION['POSCart'])){
				foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$foodName = $row['food_name'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->setTextSize(1,3);
						$printer->text("{$cartItems}x   $foodName \n");
					}
				}
			}


			$printer -> setJustification();
			$printer->setTextSize(1,1);
			$printer->setEmphasis(true);
			$printer->text("\n");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item(s): $total_items\n");

			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function printBillDine($db){
		$table = $_GET["table"];
		$type = $_GET["type"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$cashier = "";
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setTextSize(2,2);
			$printer->text("Table No. $table\n");
			$printer->setTextSize(1,1);
			$printer->text("Order Type: $type\n");
			$printer->text("Cashier: $cashier\n");
			$printer->text("$date             $time\n");
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();
			if(isset($_SESSION['POSCart'])){
				foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$foodName = $row['food_name'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
								//$db->set_foodCode($cart);
								//$db->set_foodImage($row['food_image']);
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal;
					}
				}
			}
			$total_price = number_format($total_price,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item(s): $total_items\n");
			$printer->text("To be paid: $total_price\n");

			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->setEmphasis(true);
			$printer->text("\n");
			$printer->text("--------------------------------\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();
			//unset($_SESSION['POSCart']);

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function printBillOut($db){
		$type = $_GET["type"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$cashier = "";
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setTextSize(1,1);
			$printer->text("Order Type: $type\n");
			$printer->text("Cashier: $cashier\n");
			$printer->text("$date             $time\n");
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();
			if(isset($_SESSION['POSCart'])){
				foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
					$sql = "Select * from mushroom_foods where food_code = '$cart'";
					$exist = $db->checkExist($sql) or die(mysql_error());

					if($exist){

						$row = $db->fetch_array($exist);
						$food_price = $row['food_price'];
						$subtotal = (float)$food_price * (float)$cartItems;
						$foodName = $row['food_name'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
								//$db->set_foodCode($cart);
								//$db->set_foodImage($row['food_image']);
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal;
					}
				}
			}
			$total_price = number_format($total_price,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item(s): $total_items\n");
			$printer->text("To be paid: $total_price\n");

			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->setEmphasis(true);
			$printer->text("\n");
			$printer->text("--------------------------------\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();
			//unset($_SESSION['POSCart']);

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function printDine($db){
		$code = $_GET["code"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$cashier = "";
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$sql1 = "Select * from mushroom_queue where queue_code = '$code'";
			$exist1 = $db->checkExist($sql1) or die(mysql_error());
				if($exist1){
					$row1 = $db->fetch_array($exist1);
					$table = $row1['queue_table'];
					$type = $row1['queue_type'];
				}

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setTextSize(2,2);
			$printer->text("Table No. $table\n");
			$printer->setTextSize(1,1);
			$printer->text("Order No. $code\n");
			$printer->text("Order Type: $type\n");
			$printer->text("Cashier: $cashier\n");
			$printer->text("$date             $time\n");
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();

			$sql2 = "Select * from mushroom_queue_orders where queue_code = '$code'";
			$exist2 = $db->checkExist($sql2);
				if($exist2){
					while($row2 = $db->fetch_array($exist2)){
						$food_price = $row2['orders_price'];
						$subtotal = $row2['orders_subtotal'];
						$foodName = $row2['orders_foods'];
						$cartItems = $row2['orders_quantity'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal;
					}
				}
			$total_price = number_format($total_price,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item(s): $total_items\n");
			$printer->text("To be paid: $total_price\n");

			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->setEmphasis(true);
			$printer->text("\n");
			$printer->text("--------------------------------\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function printDelivery($db){
		$code = $_GET["code"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$cashier = "";
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$sql1 = "Select * from mushroom_queue where queue_code = '$code'";
			$exist1 = $db->checkExist($sql1) or die(mysql_error());
				if($exist1){
					$row1 = $db->fetch_array($exist1);
					$table = $row1['queue_table'];
					$type = $row1['queue_type'];
					$customer = $row1['queue_customer'];
					$username = $row1['queue_username'];
					$contact = $row1['queue_contact'];
					$address = $row1['queue_address'];
				}

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setTextSize(1,1);
			$printer->text("Order No. $code\n");
			$printer->text("Order Type: $type\n");
			$printer->text("Cashier: $cashier\n");
			$printer->text("$date             $time\n");
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();

			$sql2 = "Select * from mushroom_queue_orders where queue_code = '$code'";
			$exist2 = $db->checkExist($sql2);
				if($exist2){
					while($row2 = $db->fetch_array($exist2)){
						$food_price = $row2['orders_price'];
						$subtotal = $row2['orders_subtotal'];
						$foodName = $row2['orders_foods'];
						$cartItems = $row2['orders_quantity'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal;
					}
				}
			$total_price = number_format($total_price,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item(s): $total_items\n");
			$printer->text("To be paid: $total_price\n");

			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->setEmphasis(true);
			$printer->text("\n\n\n");
			$printer->setTextSize(1,1);
			$printer->text("Cust Name: ");
			$printer->setEmphasis(false);
			$printer->text("$customer\n");
			$printer->setEmphasis(true);
			$printer->text("Address: ");
			$printer->setEmphasis(false);
			$printer->text("$address\n");
			$printer->text("\n");
			$printer->setEmphasis(true);
			$printer->text("--------------------------------\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();
			$secs = time();
			$datePaid = date('F d, Y');
			$time = date('h:i A');
			$dateSales = date('ymd');

			$sql4 = "Insert into mushroom_delivery values('$code','$type','','$customer','$username','$contact','$datePaid','$dateSales','$time','$secs','$address','Completed','No','$admin','No')";
			$exist4 = $db->checkExist($sql4);
			$sql5 = "Select * from mushroom_queue_orders where queue_code = '$code'";
			$exist5 = $db->checkExist($sql5);
				while($row2 = $db->fetch_array($exist5)){
						$food_price = $row2['orders_price'];
						$subtotal = $row2['orders_subtotal'];
						$foodName = $row2['orders_foods'];
						$cartItems = $row2['orders_quantity'];
						$sql6 = "Insert into mushroom_orders values('$code','$foodName','$cartItems','$food_price','$subtotal')";
						$exist6 = $db->checkExist($sql6);
					}
			$sql7 = "Delete from mushroom_queue where queue_code = '$code' ";
			$exist7 = $db->checkExist($sql7);

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}

	function printTakeout($db){
		$code = $_GET["code"];
		ob_start();
		$total_items = 0;
		date_default_timezone_set('Asia/Manila');
		$date = date("m/d/Y");
		$time = date("h:i A");
		$cashier = "";
		if(isset($_SESSION['Admin'])){
			$admin = $_SESSION['Admin'];
			$sql = "Select * from mushroom_admin where admin_username ='$admin'";
			$exist = $db->checkExist($sql);
			if($exist){
				$num = $db->get_rows($exist);
					if($num>=1){
						$row = $db->fetch_array($exist);
						$cashier = $row['admin_firstname'];
					}

			}
		}
		try {

			$connector = new WindowsPrintConnector("printer");
			$printer = new Printer($connector);

			$printer->initialize();

			$img = EscposImage::load("../images/logo-mushroom.png");
			$printer -> setJustification(Printer::JUSTIFY_CENTER);
			$printer -> bitImage($img);

			$sql1 = "Select * from mushroom_queue where queue_code = '$code'";
			$exist1 = $db->checkExist($sql1) or die(mysql_error());
				if($exist1){
					$row1 = $db->fetch_array($exist1);
					$table = $row1['queue_table'];
					$type = $row1['queue_type'];
				}

			$printer->text("\n\n");
			$printer->text("Mushroom Sisig Haus\nCapitol Exit, Malolos, Bulacan\n0922 849 0700\n");
			$printer->feed();
			$printer->setEmphasis(true);
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setTextSize(2,2);
			$printer->setTextSize(1,1);
			$printer->text("Order No. $code\n");
			$printer->text("Order Type: $type\n");
			$printer->text("Cashier: $cashier\n");
			$printer->text("$date             $time\n");
			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->text("-------------------------------\n");
			$printer->setEmphasis(false);
			$printer->setTextSize(1,1);
			$printer -> setJustification();
			$printer->feed();

			$sql2 = "Select * from mushroom_queue_orders where queue_code = '$code'";
			$exist2 = $db->checkExist($sql2);
				if($exist2){
					while($row2 = $db->fetch_array($exist2)){
						$food_price = $row2['orders_price'];
						$subtotal = $row2['orders_subtotal'];
						$foodName = $row2['orders_foods'];
						$cartItems = $row2['orders_quantity'];
						$food_price = number_format($food_price,"2");
						$subtotal = number_format($subtotal,"2");
						$total_items += $cartItems;
						$printer->text("$cartItems   $foodName @$food_price\n");
						$printer->text("        *$subtotal\n");
						$subtotal = floatval(str_replace(",","",$subtotal));
						$total_price += $subtotal;
					}
				}
			$total_price = number_format($total_price,"2");
			$printer->text("\n\n");
			$printer -> setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Total Item(s): $total_items\n");
			$printer->text("To be paid: $total_price\n");

			$printer -> setJustification();
			$printer->setTextSize(1,2);
			$printer->setEmphasis(true);
			$printer->text("\n");
			$printer->text("--------------------------------\n\n");
			$printer->text("\n\n\n");

			$printer->feed();
			$printer->cut();
			$printer->close();

		} catch (Exception $e) {
			ob_end_clean();
			echo "error";
		}
	}


?>
