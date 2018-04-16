<?php

	require_once("connect.php");
	session_start();
	class MushroomDB{
	
		private $connection;
		private static $instance;
		private $user;
		private $userPic;
		private $userAddress;
		private $orderTime;
		private $pass;
		private $conpass;
		private $sales_subtotal;
		private $sales_total = 0;
		private $subtotal;
		private $total = 0;
		private $divCount = 0;
		private $className;
		private $foodName;
		private $foodCode;
		private $foodQuantity;
		private $foodPrice;
		private $foodSubtotal;
		private $foodImage;
		private $productImage;
		private $productCode;
		private $productName;
		private $productPrice;
		private $productStatus;
		private $productFoodCategory;
		private $userCode;
		private $userName;
		private $userStatus;
		private $userEmail;
		private $userContact;
		private $userCompleteAddress;
		private $productNameVal;
		private $productPriceVal;
		private $productAddedDate;
		private $productDate;
		private $productStatusVal;
		private $deliveryCode;
		private $deliveryCustomer;
		private $deliveryUsername;
		private $deliveryType;
		private $deliveryServe;
		private $deliveryContact;
		private $deliveryDate;
		private $deliveryTime;
		private $deliveryAddress;
		private $deliveryRead;
		
		
			public static function getInstance(){
				if(!self::$instance){
					self::$instance = new self;
				}
				return self::$instance;
			}
			
			private function __construct(){
				$this->connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
					if($this->connection){
						$db = mysql_select_db(DB_NAME,$this->connection);
							if($db){
								
							}
					}
			}
			
			function set_user($userN){
				$this->user = $userN;
			}		
			function set_user_image($pic){
				$this->userPic = $pic;
			}
			function set_user_address($address){
				$len = strlen($address);
				if($len>15){
					$address = substr($address,0,15)."....";
				}
				$this->userAddress = $address;
			}
			function set_pass($passW){
				$this->pass = $passW;
			}
			function set_conpass($conP){
				$this->conpass = $conP;
			}
			function set_divCount($count){
				$this->divCount = $count;
			}
			function set_className($name){
				$this->className = $name;
			}
			function set_userCode($code){
				$this->userCode = $code;
			}			
			function set_userStatus($stat){
				$this->userStatus = $stat;
			}
			function set_userName($name){
				$this->userName = $name;
			}
			function set_userEmail($email){
				$this->userEmail = $email;
			}
			function set_userContact($contact){
				$this->userContact = $contact;
			}
			function set_userCompleteAddress($address){
				$this->userCompleteAddress = $address;
			}
			function set_productPic($pic){
				$this->productImage = $pic;
			}			
			function set_productCode($code){
				$this->productCode = $code;
			}
			function set_productName($name){
				$this->productName = $name;
			}
			function set_productPrice($price){
				$this->productPrice = $price;
			}
			function set_productStatus($status){
				$this->productStatus = $status;
			}
			function set_productFoodCategory($category){
				$this->productFoodCategory = $category;
			}
			function set_productNameVal($name){
				$this->productNameVal = $name;
			}
			function set_productPriceVal($price){
				$this->productPriceVal = $price;
			}
			function set_productAddedDate($date){
				$this->productAddedDate = $date;
			}
			function set_productDate($date){
				$this->productDate = $date;
			}
			function set_productStatusVal($status){
				$this->productStatusVal = $status;
			}
			function set_foodName($food){
				$this->foodName = $food;
			}
			function set_foodQuantity($qty){
				$this->foodQuantity = $qty;
			}
			function set_foodPrice($price){
				$this->foodPrice = $price;
			}
			function set_foodImage($pic){
				$this->foodImage = $pic;
			}
			function set_foodSubtotal($subtotal){
				$this->foodSubtotal = $subtotal;
			}
			function set_foodCode($code){
				$this->foodCode = $code;
			}
			function set_deliveryCode($code){
				$this->deliveryCode = $code;
			}
			function set_deliveryType($type){
				$this->deliveryType = $type;
			}
			function set_deliveryCustomer($customer){
				$this->deliveryCustomer = $customer;
			}
			function set_deliveryUsername($username){
				$this->deliveryUsername = $username;
			}
			function set_deliveryServed($serveby){
				$this->deliveryServe = $serveby;
			}
			function set_deliveryContact($contact){
				$this->deliveryContact = $contact;
			}
			function set_deliveryDate($date){
				$this->deliveryDate = $date;
			}
			function set_deliveryTime($time){
				$this->deliveryTime = $time;
			}
			function set_deliveryAddress($address){
				$this->deliveryAddress = $address;
			}
			function set_deliveryRead($read){
				$this->deliveryRead = $read;
			}
			
			function checkExist($sql){
				$db = mysql_query($sql,$this->connection);
					if($db){
						return $db;
					}
			}
			
			function get_rows($result){
				return mysql_num_rows($result);
			}
			
			function fetch_array($exist){
				return mysql_fetch_array($exist);
			}
			
			function registerUser($sql){
				$db2 = mysql_query($sql,$this->connection);
					if($db2){
						echo "Successful";
					}
			}				
			
			function loginUser(){
				
				if (!isset($_SESSION['User'])){
					echo '<script type="text/javascript"> 
							logoutUser();
						  </script>';
				}
				else{
					echo '<script type="text/javascript"> 
							loginUser();
						  </script>';
				}
			}
			
			function generateCode(){
				if(isset($_SESSION['OrderType'])){
					$order = $_SESSION['OrderType'];
					if($order=="DineIn"){
						$type = "ORD";
					}
					else if($order=="Reserve"){
						$type = "ORD";
					}
					else{
						$type = "TKT";
					}
				}
				else{
					$type = "ORD";
				}
				$nums = mt_rand(1,999999999);
				$code = $type.$nums;
				return $code;
			}
			
			function generateProduct(){
			
				$nums = mt_rand(1,999999999);
				$code = "PRD-".$nums;
				return $code;
			}
			
			function generateFood(){
			
				$nums = mt_rand(1,999999999);
				$code = "FDS-".$nums;
				return $code;
			}
			
			function set_sales_subtotal($num){
				$this->sales_subtotal = $num;
				$this->sales_subtotal = floatval(str_replace(",","",$this->sales_subtotal));
			}
			
			function compute_sales(){
				$this->sales_total = floatval(str_replace(",","",$this->sales_total));
				$this->sales_total += $this->sales_subtotal;
				return number_format($this->sales_total,"2");
			}
			function compute_bill(){
				return $this->total += $this->foodSubtotal;
			}
			/* function compute_bill(){
				$this->total += $this->foodSubtotal;
			} */
				
				
			function view_orders(){
				$this->foodPrice = number_format($this->foodPrice,"2");
				$this->foodSubtotal = number_format($this->foodSubtotal,"2");
				echo "<tr><td seen='$this->divCount' class='$this->className'>{$this->foodName}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->foodQuantity}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->foodPrice}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->foodSubtotal}</td></tr>";
			}
			
			function view_orders_amount(){
				$this->total = number_format($this->total,"2");
				echo "<tr><td class='active' colspan='2'></td>
					<td class='active'>Total: </td>
					<td class='active'>&#x20B1;{$this->total}</td></tr>";
			}
			
			function view_orders_button($code){
				echo "*<button style='width:204px;' class='btn btn-warning'>DELETE</button>
					<button onclick='deliverOrder($code);' style='width:204px;' class='btn btn2 btn-success'>DELIVER</button>";
			}
				
			function view_delivery_table(){
				echo "<tr id='{$this->deliveryRead}'><td seen='$this->divCount' class='$this->className'>{$this->deliveryCode}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->deliveryCustomer}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->deliveryContact}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->deliveryDate}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->deliveryTime}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->deliveryAddress}</td>
					<td seen='$this->divCount' class='$this->className'	 align='center'><button onclick='view_orders({$this->deliveryCode});' class='btn btn-success'>Order Details</button></td></tr>";
			}
			
			function view_delivered_table(){
				echo "<tr><td seen='$this->divCount' class='$this->className'>{$this->deliveryCode}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->deliveryDate}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->deliveryTime}</td>
					<td seen='$this->divCount' class='$this->className'>{$this->deliveryServe}</td>							
					<td seen='$this->divCount' class='$this->className' align='center'><button onclick='view_orders({$this->deliveryCode})'; class='btn btn-success'>Order Details</button></td></tr>";
			}
			
			function view_button_numbers(){
				$len = $this->divCount;
				$activelabel = "active";
				$id= '';		
				echo "*";
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
			
			function set_orderTime($secs){
				$time=time();
				
					$diff = $time - $secs;
					

				switch(1){
					
					case($diff<60):{
						$count = $diff;
						if($count==1){
							$suffix = "sec";
						}
						else{
							$suffix ="secs";
						}
					break;
					}
					case($diff>=60 && $diff<3600):{
						$count= floor($diff/60);
						if($count==1){
							$suffix= "min";
						}
						else{
							$suffix= "mins";
						}
	
					break;
					}
					case($diff>=3600 && $diff<86400):{
						$count = floor($diff/3600);
						if($count==1){
							$suffix ="hour";
						}
						else{
							$suffix ="hours";
						}
					break;
					}
					
					case($diff>86400):{
						$count=floor($diff/86400);
						if($count==1){
							$suffix = "day";
							
						}
						else{
							$suffix = "days";
						}
					}
					
				}

				$this->orderTime = "$count $suffix";
			}
			
			function view_message($total){
				$location ='"admin-pending-orders.php"';
				if($total>1){
					$total = "$total pending orders";
				}
				else{
					$total = "$total pending order";					
				}
				echo "<li>
						<a href='#' onclick='location.href=$location;return false;'>
						<div class='pull-left'>
							<img src='../$this->userPic' class='img-circle' alt='User Image'>
						</div>
							<h4>
								$this->userAddress
								<small><i class='fa fa-clock-o'></i> $this->orderTime</small>
							</h4>
							<p>$total</p>
						</a>
					</li>";
			}
			
			function checkOnline(){
				if (!isset($_SESSION['Admin'])){
					header("Location:admin-login.php");
				}
			}
			
			function view_products_table(){
				echo "<tr><td seen='$this->divCount' class='$this->className' align='center'><img src='../$this->productImage' width='72' height='35'/></td>
					<td seen='$this->divCount' class='$this->className'>$this->productName</td>
					<td seen='$this->divCount' class='$this->className'>$this->productPrice</td>
					<td seen='$this->divCount' class='$this->className'>$this->productStatus</td>
					<td seen='$this->divCount' class='$this->className' align='center'>
						<button class='btn btn-primary'><span class='glyphicon glyphicon-pencil'></span></button>
						<button class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span></button>	
					</td></tr>";
			}
			
			function view_pos_products_table(){		
				$this->productPrice	= number_format($this->productPrice,"2");// data-toggle='modal' data-target='#addModal' onclick='showQuantity(this.id);'
				echo "<tr id='$this->productCode' onclick='addQuantity(this.id);' style='cursor:pointer; border-bottom:solid 1px #ccc;'>
					<td class='col-xs-3'><img src='../$this->productImage' width='60' height='60'/></td>
					<td class='col-xs-10'><strong id='prod-name'>$this->productName</strong><br/><small>&#8369; $this->productPrice</small></td>
					<td style='line-height:5;' class='col-xs-1'><i class='fa fa-angle-double-right fa-2x'></i> </td>					
				  </tr>";
			}
			
			function view_cart(){
				$this->foodPrice = number_format($this->foodPrice,"2");
				$this->foodSubtotal = number_format($this->foodSubtotal,"2");
				$id = $this->foodQuantity." ".$this->foodCode;
				echo "<tr style='border-bottom:solid 1px #ccc;'>
					<td class='col-xs-1'><img src='../$this->foodImage' style='width:120px; height:90px;'class='img-rounded'/></td>
					<td class='col-xs-4' style='padding-right:0px;' ><strong style='font-size:15pt; letter-spacing:2px; '>$this->foodName</strong><br/><small>&#8369; $this->foodPrice</small></td>					
					<td style='line-height:5; font-size:1.25em; font-weight:bold;' class='col-xs-2'><small>&#8369; $this->foodSubtotal</small> <strong> </strong> </td>
					<td style='line-height:5; font-size:1.3em;' class='col-xs-1'><strong id='$id' onclick='load(this.id,event);' style='cursor:pointer; border:solid 1.5pt #ccc; width:10px height:10px; border-radius:2em; padding:0px 7px 0px 7px;'>$this->foodQuantity</strong> </td>
					<td style='line-height:3; padding-left:40px;'><i style='color:#009551; cursor:pointer;' id='$id' onclick='cartIncrease(this.id);' class='fa fa-chevron-up fa-2x'></i><br/><i style='color:#7e6369; cursor:pointer;' id='$id' onclick='cartDecrease(this.id)'; class='fa fa-chevron-down fa-2x'></i> </td>
					<td ><i style='color:#be3000; padding-left:10px; cursor:pointer;' id='$this->foodCode' onclick='removeOrder(this.id);' class='fa fa-trash fa-2x'></i></td>
				</tr>";
			}		
			
			function view_cart_del(){
				$this->foodPrice = number_format($this->foodPrice,"2");
				$this->foodSubtotal = number_format($this->foodSubtotal,"2");
				$id = $this->foodQuantity." ".$this->foodCode;
				echo "<tr style='border-bottom:solid 1px #ccc;'>
					<td style='text-align:right;'><input type='checkbox' name='chk[]' value='$this->foodCode'/></td>
					<td class='col-xs-1'><img src='$this->foodImage' style='width:120px; height:20%;'class='img-rounded'/></td>
					<td class='col-xs-4' style='padding-right:0px;' ><strong style='font-size:15pt; letter-spacing:2px;'>$this->foodName</strong><br/><small>&#8369; $this->foodPrice</small></td>					
					<td style='line-height:5; font-size:1.25em; font-weight:bold;' class='col-xs-2'><small>&#8369; $this->foodSubtotal</small> <strong> </strong> </td>
					<td style='line-height:5; font-size:1.2em;' class='col-xs-1'><strong id='$id' onclick='load(this.id,event);' style='cursor:pointer; border:solid 1.5pt #ccc; width:10px height:10px; border-radius:2em; padding:0px 7px 0px 7px;'>$this->foodQuantity</strong> </td>
					<td style='line-height:3;'><i style='color:#009551; cursor:pointer;' id='$id' onclick='cartIncrease(this.id);' class='fa fa-chevron-up fa-2x'></i><br/><i style='color:#7e6369; cursor:pointer;' id='$id' onclick='cartDecrease(this.id)'; class='fa fa-chevron-down fa-2x'></i> </td>
					<td ><i style='color:#be3000; padding-left:10px; cursor:pointer;' id='$this->foodCode' onclick='removeOrder(this.id);' class='fa fa-trash fa-2x'></i></td>
				</tr>";
			}	

			function show_reviewTable(){
				echo "<tr background-color:><td>$this->foodName</td>
					<td>$this->foodQuantity</td>
					<td>$this->foodPrice</td>
					<td>$this->foodSubtotal</td></tr>";
			}
			
			function show_reviewTableColor($color){
				echo "<tr style='background-color:$color;'><td>$this->foodName</td>
					<td>$this->foodQuantity</td>
					<td>$this->foodPrice</td>
					<td>$this->foodSubtotal</td></tr>";
			}
			
			function show_products(){
				if($this->productStatusVal=="Active"){
					$classButton1 = "btn btn-info btn-number active";
					$classButton2 = "btn btn-danger btn-number";
					$button1 = "<button id='$this->productFoodCategory' style='cursor:no-drop; border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;' type='button' class='$classButton1'>
						Active
					</button>";
					$button2 = "<button id='$this->productFoodCategory' onclick='setProductInactive(this.id);' style='border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;' type='button' class='$classButton2'>
						Inactive
					</button>";
				}
				else{
					$classButton1 = "btn btn-info btn-number";
					$classButton2 = "btn btn-danger btn-number active";
					$button1 = "<button id='$this->productFoodCategory' onclick='setProductActive(this.id);' style='border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;' type='button' class='$classButton1'>
						Active
					</button>";
					$button2 = "<button id='$this->productFoodCategory' style='cursor:no-drop; border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;' type='button' class='$classButton2'>
						Inactive
					</button>";
				}
				echo "<tr>
                  <td>$this->productNameVal</td>
                  <td>$this->productPriceVal</td>
                  <td>$this->productAddedDate</td>
                  <td><span class='input-group-btn'>
					$button1
					$button2
				</span></td>
                  <td><span class='input-group-btn'>
					<button id='$this->productFoodCategory' onclick='edit_product(this.id);' style='border-radius: 2em;' type='button' class='btn btn-info btn-number'>
						<i class='fa fa-edit'></i>Edit
					</button>					
					<button id='$this->productFoodCategory' onclick='ask(this.id);' style='border-radius: 2em; margin-left:5px;' type='button' class='btn btn-danger btn-number'>
						<i class='fa fa-trash-o'> </i>Delete
					</button>
				</span></td>
                </tr>";
			}
			
			function show_tables(){
				if($this->productStatusVal=="vacant"){
					$classButton1 = "btn btn-info btn-number active";
					$classButton2 = "btn btn-danger btn-number";
					$button1 = "<button id='$this->productNameVal' style='cursor:no-drop; border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;' type='button' class='$classButton1'>
						Vacant
					</button>";
					$button2 = "<button id='$this->productNameVal' onclick='setTableInactive(this.id);' style='border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;' type='button' class='$classButton2'>
						Occupied
					</button>";
				}
				else{
					$classButton1 = "btn btn-info btn-number";
					$classButton2 = "btn btn-danger btn-number active";
					$button1 = "<button id='$this->productNameVal' onclick='setTableActive(this.id);' style='border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;' type='button' class='$classButton1'>
						Vacant
					</button>";
					$button2 = "<button id='$this->productNameVal' style='cursor:no-drop; border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;' type='button' class='$classButton2'>
						Occupied
					</button>";
				}
				echo "<tr>
                  <td>$this->productNameVal</td>
               
                  <td><span class='input-group-btn'>
					$button1
					$button2
				</span></td>
                  <td><span class='input-group-btn'>
					<button id='$this->productNameVal' onclick='edit_product(this.id);' style='border-radius: 2em;' type='button' class='btn btn-info btn-number'>
						<i class='fa fa-edit'></i>Edit
					</button>					
					<button id='$this->productNameVal' onclick='ask(this.id);' style='border-radius: 2em; margin-left:5px;' type='button' class='btn btn-danger btn-number'>
						<i class='fa fa-trash-o'> </i>Delete
					</button>
				</span></td>
                </tr>";
			}
			
			function show_foods(){
				if($this->productStatus=="Active"){
					$classButton1 = "btn btn-info btn-number active";
					$classButton2 = "btn btn-danger btn-number";
					$button1 = "<button id='$this->productCode' style='cursor:no-drop; border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;' type='button' class='$classButton1'>
						Active
					</button>";
					$button2 = "<button id='$this->productCode' onclick='setProductInactive(this.id);' style='border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;' type='button' class='$classButton2'>
						Inactive
					</button>";
				}
				else{
					$classButton1 = "btn btn-info btn-number";
					$classButton2 = "btn btn-danger btn-number active";
					$button1 = "<button id='$this->productCode' onclick='setProductActive(this.id);' style='border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;' type='button' class='$classButton1'>
						Active
					</button>";
					$button2 = "<button id='$this->productCode' style='cursor:no-drop; border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;' type='button' class='$classButton2'>
						Inactive
					</button>";
				} //<img src='../$this->productImage' width='120' height='80'/>
				echo "<tr>
				  <td class='containerpic'>
					  <img src='../$this->productImage' alt='IMG' class='image' style='width:120px; height:80px;'>
					  <div class='middle'>
						<div onclick='changePic(this.id);' id='$this->productCode' class='text'>Change Image</div>
					  </div></td>
                  <td>$this->productName</td>
                  <td>$this->productPrice</td>
                  <td>$this->productDate</td>
                  <td><span class='input-group-btn'>
					$button1
					$button2
				</span></td>
                  <td><span class='input-group-btn'>
					<button id='$this->productCode' onclick='edit_food(this.id);' style='border-radius: 2em;' type='button' class='btn btn-info btn-number'>
						<i class='fa fa-edit'></i>Edit
					</button>					
					<button id='$this->productCode' onclick='ask(this.id);' style='border-radius: 2em; margin-left:5px;' type='button' class='btn btn-danger btn-number'>
						<i class='fa fa-trash-o'> </i>Delete
					</button>
				</span></td>
                </tr>";
			}
			
			function show_users(){
				if($this->userStatus=="Active"){
					$classButton1 = "btn btn-info btn-number active";
					$classButton2 = "btn btn-danger btn-number";
					$button1 = "<button id='$this->userCode' style='cursor:no-drop; border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;' type='button' class='$classButton1'>
						Active
					</button>";
					$button2 = "<button id='$this->userCode' onclick='setUserInactive(this.id);' style='border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;' type='button' class='$classButton2'>
						Inactive
					</button>";
				}
				else{
					$classButton1 = "btn btn-info btn-number";
					$classButton2 = "btn btn-danger btn-number active";
					$button1 = "<button id='$this->userCode' onclick='setUserActive(this.id);' style=' border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;' type='button' class='$classButton1'>
						Active
					</button>";
					$button2 = "<button id='$this->userCode' style='cursor:no-drop; border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;' type='button' class='$classButton2'>
						Inactive
					</button>";
				} //<img src='../$this->productImage' width='120' height='80'/>
				echo "<tr>
				  <td>$this->userCode</td>
                  <td>$this->userName</td>
                  <td>$this->userEmail</td>
                  <td>$this->userContact</td>
				  <td>$this->userCompleteAddress</td>
                  <td><span class='input-group-btn'>
					$button1
					$button2
				</span></td>
				<td><button id='$this->userCode' onclick='askChange(this.id);' style='border-radius: 2em;' type='button' class='btn btn-default'>
						<i class='fa fa-edit' style='padding-right:1.5px;'></i>Edit Password
					</button></td>				                			
                </tr>";
			}
			
			function show_staff(){
				if($this->userStatus=="Active"){
					$classButton1 = "btn btn-info btn-number active";
					$classButton2 = "btn btn-danger btn-number";
					$button1 = "<button id='$this->userCode' style='cursor:no-drop; border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;' type='button' class='$classButton1'>
						Active
					</button>";
					$button2 = "<button id='$this->userCode' onclick='setStaffInactive(this.id);' style='border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;' type='button' class='$classButton2'>
						Inactive
					</button>";
				}
				else{
					$classButton1 = "btn btn-info btn-number";
					$classButton2 = "btn btn-danger btn-number active";
					$button1 = "<button id='$this->userCode' onclick='setStaffActive(this.id);' style='border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;' type='button' class='$classButton1'>
						Active
					</button>";
					$button2 = "<button id='$this->userCode' style='cursor:no-drop; border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;' type='button' class='$classButton2'>
						Inactive
					</button>";
				} //<img src='../$this->productImage' width='120' height='80'/>
				echo "<tr>
				  <td>$this->userCode</td>
                  <td>$this->userName</td>
                  <td>$this->userEmail</td>
                  <td>$this->userContact</td>
			
                  <td><span class='input-group-btn'>
					$button1
					$button2
				</span></td>    
				<td><button id='$this->userCode' onclick='askChange(this.id);' style='border-radius: 2em;' type='button' class='btn btn-default'>
						<i class='fa fa-edit' style='padding-right:1.5px;'></i>Edit Password
					</button></td>				
                </tr>";
			}
			
			function view_pending_orders($text){
				echo "<tr>
						<td></td>
						<td><a style='cursor:default;' onclick='return false;' href='#'>$this->deliveryCode</a></td>
						<td><b>$this->deliveryCustomer</b> 
						<td><b>$this->deliveryType</b> - $text</td>
						<td>$this->deliveryTime</td>
						<td>$this->orderTime ago</td>
						<td><button id='$this->deliveryCode' onclick='view_orders(this.id);' type='button' style='border-radius:2em;' class='btn btn-default btn-sm'><i class='fa fa-search'></i> View</button></td>
					  </tr>";
			}
			
			function view_reserve_orders($text){
				echo "<tr>
						<td></td>						
						<td><b>$this->deliveryCustomer</b> 
						<td><b>$this->deliveryType</b> - $text</td>
						<td>$this->deliveryTime</td>
						<td>$this->orderTime ago</td>
						<td><button id='$this->deliveryCode' onclick='view_orders(this.id);' type='button' style='border-radius:2em;' class='btn btn-default btn-sm'><i class='fa fa-search'></i> View</button></td>
					  </tr>";
			}
			
			function view_completed_orders($text){
				echo "<tr>
						<td></td>
						<td><a style='cursor:default;' onclick='return false;' href='#'>$this->deliveryCode</a></td>
						<td><b>$this->deliveryServe</b> 
						<td><b>$this->deliveryType</b></td>
						<td>$this->deliveryTime</td>
						<td>$this->orderTime ago</td>
						<td><button id='$this->deliveryCode' onclick='view_orders(this.id);' type='button' style='border-radius:2em;' class='btn btn-default btn-sm'><i class='fa fa-search'></i> View</button>
						<button id='$this->deliveryCode' onclick='ask(this.id);' type='button' style='border-radius:2em; background-color:white; border-color:#f55f5c; color:#f55f5c;' class='btn btn-danger btn-sm'><i class='fa fa-trash-o'></i> Delete</button></td>
					  </tr>";
			}
			/* function view_reserve_orders($text){
				echo "<tr>
						<td></td>
						<td><a style='cursor:default;' onclick='return false;' href='#'>$this->deliveryCode</a></td>
						<td>$this->deliveryCustomer</td>
						<td>$this->deliveryTime</td>
						<td>$this->orderTime ago</td>
						<td><button id='$this->deliveryCode' onclick='view_orders(this.id);' type='button' style='border-radius:2em;' class='btn btn-default btn-sm'><i class='fa fa-search'></i> View</button>
						<button id='$this->deliveryCode' onclick='ask(this.id);' type='button' style='border-radius:2em; background-color:white; border-color:#f55f5c; color:#f55f5c;' class='btn btn-danger btn-sm'><i class='fa fa-trash-o'></i> Delete</button></td>
					  </tr>";
			} */
			function view_completed_archive($text){
				//<button id='$this->deliveryCode' onclick='ask(this.id);' type='button' style='border-radius:2em; background-color:white; border-color:#f55f5c; color:#f55f5c;' class='btn btn-danger btn-sm'><i class='fa fa-trash-o'></i> Delete</button>
				echo "<tr>
						<td></td>
						<td><a style='cursor:default;' onclick='return false;' href='#'>$this->deliveryCode</a></td>
						<td><b>$this->deliveryServe</b> 
						<td><b>$this->deliveryType</b></td>
						<td>$this->deliveryTime</td>
						<td>$this->orderTime ago</td>
						<td><button id='$this->deliveryCode' onclick='restoreArchive(this.id);' type='button' style='border-radius:2em; background-color:white; border-color:#28b9d2; color:#28b9d2;' class='btn btn-info btn-sm'><i class='fa fa-undo'></i> Restore</button></td>
					  </tr>";
			}
			
			function activity_log($activity){
				if (isset($_SESSION['Admin'])){
					$admin = $_SESSION['Admin'];
					$sql = "Select * from mushroom_admin where admin_username = '$admin'";
					$exist = $this->checkExist($sql);
					$row = $this->fetch_array($exist);
					$user = $row['admin_firstname']." ".$row['admin_lastname'];
				}
				
				date_default_timezone_set('Asia/Manila'); 
				$time = date("h:iA");
				$date = date("m/d/Y, l");
				//$ip = $this->getIP();
				/* $file = "../records/records.txt";
				if(file_exists($file)){
					$oldfile = file_get_contents($file);
					$myfile = fopen("../../records/records.txt", "w") or die("Unable to open file!");
					$txt = "$date, $time, $user(admin) : $activity". PHP_EOL ;
					fwrite($myfile, $txt);
					fclose($myfile);
					
					$newfile = fopen("../../records/records.txt", "a") or die("Unable to open file!");
					fwrite($newfile, $oldfile);
					fclose($newfile);
				}	
				else{
					$myfile = fopen("../../records/records.txt", "w") or die("Unable to open file!");
					$txt = "$date, $time, $user(admin) : $activity". PHP_EOL ;
					fwrite($myfile, $txt);
					fclose($myfile);
				} */
				
				/* $myfile = fopen("../../records/records.txt", "a") or die("Unable to open file!");
				//$txt = "$date, $time, $user(admin) : $activity | ";
				$txt = "$date, $time, $user(admin) : $activity". PHP_EOL ;
				fwrite($myfile, $txt);				
				fclose($myfile); */
			}
			
			function getIP() {
				$ip = $_SERVER['SERVER_ADDR'];

				if (PHP_OS == 'WINNT'){
					$ip = getHostByName(getHostName());
				}

				if (PHP_OS == 'Linux'){
					$command="/sbin/ifconfig";
					exec($command, $output);

					$pattern = '/inet addr:?([^ ]+)/';

					$ip = array();
					foreach ($output as $key => $subject) {
						$result = preg_match_all($pattern, $subject, $subpattern);
						if ($result == 1) {
							if ($subpattern[1][0] != "127.0.0.1")
							$ip = $subpattern[1][0];
						}

					}
				}

				return $ip;
			}


			
	}

?>