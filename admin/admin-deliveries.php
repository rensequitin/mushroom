<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width = device-width, initial-scale = 1">
<title>Admin</title>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" rev="stylesheet" type="text/css" href="fonts/fonts.css">
<link rel="stylesheet" href="font-picker/css/font-awesome.min.css">
<link rel="stylesheet" rev="stylesheet" type="text/css" href="admin-css.css">
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"> </script>-->
<script src="js/jquery.js"> </script>
<script src="js/jquery.timers.js"> </script>
<script src="js/admin-script.js"> </script>
<script src="js/admin-ajax.js"> </script>

<style>

</style>

</head>
<?php
	require_once("php/class.database.php");

	$db = MushroomDB::getInstance();
	$db->checkOnline();
	
?>
<div class="container-fluid">
	<div class="row">
	  	<div class="header"> 
			<nav class="navbar" style="background-color:<?php echo $_SESSION['Color'];?>;">
				<ul class="nav navbar-nav navbar-right">
					<li><a id="icon-message"  href="#">
						<img style="width: 30px; padding: 5px;" src="images/icon-cart.png"></a>
						<div id="msg"><span><small><span id="label-message" class="label label-success">0</span></small></span></div>
					</li>
					
				<li class="dropdown messages-menu">
					<ul class="dropdown-menu" id="message-id" style='right:34px;'>
						<li class="header" id="header"></li>
							<li>
						<!-- inner menu: contains the actual data -->
								<ul class="menu" id="menu">																		
								</ul>
							</li>
						<li class="footer"><a href="#">See All Messages</a></li>
					</ul>
				</li>
				
				<li class="dropdown user user-menu">
							<a href="#" id="user-menu" class="dropdown-toggle" data-toggle="dropdown">
							  <img src="img/avatar5.png" class="user-image" alt="User Image">
							  <span class="hidden-xs">Lorenzo Sequitin</span>
							</a>
							<ul class="dropdown-menu">
							  <!-- User image -->
							  <li class="user-header" style='background-color:<?php echo $_SESSION['Color'];?>'>
								<img src="img/avatar5.png" class="img-circle" alt="User Image">

								<p>
								  Lorenzo Sequitin - Administrator
								  <small>@admin</small>
								</p>
							  </li>
				
							  <!-- Menu Footer-->
							  <li class="user-footer">
								<div class="pull-left">
								  <a href="#" class="btn btn-default btn-flat">Profile</a>
								</div>
								<div class="pull-right">
								  <a href="#" onclick='signout(); signout(); return false;' class="btn btn-default btn-flat">Sign out</a>
								</div>
							  </li>
							</ul>
						  </li>				
					
					
				<!--	<li>
					<div class="popover__wrapper2">	
						<img width=30 style="border-radius: 20px;" src="images/once-su.png">
						<span class="text-center"><small>Lorenzo Sequitin</small></span>	
						<div class="push popover__content2">
						<div class="container">
							<div class="row">
								<div class="col-sm-12">
									<img class="img-responsove thumbnail" src="img/avatar5.png">
									<span><small>Lorenzo Sequitin</small></span>									 
									<div class="getpic"><label>upload photo<input type="file" name="myImage" accept="image/x-png,image/gif,image/jpeg" /></label></div>
									<button class="btn"><small>Sign out</small></button>									 
								</div>	
							</div>	
						</div>	
						</div>
					</div>
					</li>	-->
					<li>
						<div class="popover__wrapper">	
							<span><img width=28 src="images/pantone.png"/></span> 						
						<div class="push popover__content">
							<div class="container">
								<div class="row">
									<div class="col-sm-4" id="color1"></div><div class="col-sm-4" id="color2"></div><div class="col-sm-4" id="color3"></div>
								</div>
								<div class="row">
									<div class="col-sm-4" id="color4"></div><div class="col-sm-4" id="color5"></div><div class="col-sm-4" id="color6"></div>
								</div>	
								<div class="row">
									<div class="col-sm-4" id="color7"></div><div class="col-sm-4" id="color8"></div><div class="col-sm-4" id="color9"></div>
								</div>	
							</div>	
						</div>
						</div>
					</li>				
				</ul>
			</nav>		
		</div>
	</div>
</div>

<div id="wrapper">
    <!-- Sidebar -->
		<div id="sidebar-wrapper">
            <ul class="sidebar-nav" style="margin-left:0;">
				<img class="rounded float-left" id="idimg" src="img/avatar5.png">
					<span class="text-center" id="adminname"><small>Lorenzo Sequitin</small></span>
						<div class="popover__wrapper-sub-contents">	
						<li><a href="admin-deliveries.php"><span>Deliveries</span><img id="idimg1" width=30 src="images/deliveries.png"/></a></li>	
							<div class="push popover__content-sub-contents">							 
								<li><a href="#"><span>Pending deliveries</span><img width=30 src="images/eye.png"/></a></li>	
								<li><a href="admin-viewdeliveries.php"><span>View deliveries</span><img width=30 src="images/eye.png"/></a></li>									 
							</div>
						</div>
						<div class="popover__wrapper-sub-contents">	
						<li><a href="#"><span>Order</span><img id="idimg2" width=28 src="images/order.png"/></a></li>
							<div class="push popover__content-sub-contents">
								<li><a href="#"><span>Add order</span><img width=30 src="images/eye.png"/></a></li>	
								<li><a href="admin-vieworder.php"><span>View order</span><img width=30 src="images/eye.png"/></a></li>	
							</div>
						</div>
						<div class="popover__wrapper-sub-contents">	
						<li><a href="admin-product.php"><span>Products</span><img id="idimg3" width=28 src="images/products.png"/></a></li>
							<div class="push popover__content-sub-contents">
								<li><a href="#"><span>Add products </span><img width=30 src="images/eye.png"/></a></li>	
								<li><a href="#"><span>View products</span><img width=30 src="images/eye.png"/></a></li>	
							</div>
						</div>
						<div class="popover__wrapper-sub-contents">	
						<li><a href="admin-employees.php"><span>Employees</span><img id="idimg5" width=24 src="images/promos.png"/></a></li>
							<div class="push popover__content-sub-contents">
								<li><a href="#"><span>Add employee</span><img width=30 src="images/eye.png"/></a></li>	
								<li><a href="#"><span>Manage employee</span><img width=30 src="images/eye.png"/></a></li>	
							</div>
						</div>
						<div class="popover__wrapper-sub-contents">	
						<li><a href="admin-promos.php"><span>Promos</span><img id="idimg2" width=28 src="images/order.png"/></a></li>
							<div class="push popover__content-sub-contents">
								<li><a href="#"><span>Add promo</span><img width=30 src="images/eye.png"/></a></li>	
								<li><a href="#"><span>View promo</span><img width=30 src="images/eye.png"/></a></li>	
							</div>
						</div>
						<div class="popover__wrapper-sub-contents">	
						<li><a href="#"><span>Users</span><img id="idimg6" width=23 src="images/contacts.png"/></a></li>
							<div class="push popover__content-sub-contents">
								<li><a href="#"><span>Add user</span><img width=30 src="images/eye.png"/></a></li>	
								<li><a href="#"><span>View users</span><img width=30 src="images/eye.png"/></a></li>	
							</div>
						</div>						
            </ul>			 
		</div>	
	
		<div id="page-content-wrapper">
			<!-- Header -->				 

			<a href="#menu-toggle" data-toggle="collapse" id="menu-toggle" style="margin-top:10px;float:left;" onclick="myFunction(this)">
				<div class="bar1"></div><div class="bar2"></div><div class="bar3"></div>
			</a> 
			
			
							
			<!-- Page content -->

            <div class="container-fluid">
                <div class="row" id='top-buttons'>
                    <div class="col-lg-3 col-xs-6">
						<div id="cart">
						<img class="img-responsive center-block" src="images/cartorder.png"/>
						<p style='position:relative; top:-105px;'class="text-center">TODAY'S </BR> TOTAL ORDERS<BR><small id='orders-label'>0</small></p>
						</div>
                    </div>
					<div class="col-lg-3 col-xs-6">
						<div id="sales">
						<img class="img-responsive center-block" src="images/sales.png"/>
						<p class="text-center">TODAY'S SALES<BR><small id="sales-label">0</small></p>
						</div>
                    </div>
					<div class="col-lg-3 col-xs-6">
						<div id="reg_users">
						<img class="img-responsive center-block" src="images/users.png"/>
						<p class="text-center">REGISTERED USERS<BR><small id="users-label">0</small></p>
						</div>						
                    </div>
					<div class="col-lg-3 col-xs-6">
						<div id="date">
						<p class="text-center"><span id='hour-label'><?php date_default_timezone_set('Asia/Manila'); echo date("h:iA") . "<br>";?></span><small><span id='date-label'><?php echo date("l, M d, Y"); ?></span></small></p>
						<img class="img-responsive center-block" src="images/calendar.png"/>  
						</div>						
					</div>
                </div>	
		 </div>	      
		 
		<div class="container-fluid">
            <div class="row">
                <div class="col-xs-3">
					<div class="input-group">
						<div class="selectContainer">						
							<select class="form-control" onchange="changeDelivValue(this.value)" name="food category" id="foodcategory">								
								<option value="all">All</option>
								<option value="Seen">Read</option>
								<option value="Unseen">Unread</option>													 
							</select>
							
						</div>	
							<span style='visibility:hidden;'class="input-group-btn">
								<button class="btn" type="button">
									<span class=" glyphicon glyphicon-search"></span>
								</button>
                            </span>						
					</div>
                </div>
	 
				<div class="col-xs-3 col-xs-offset-6">				
					<div id="custom-search-input">
						<div class="input-group">
							<input onkeyup="changeDelivValueCode(this.value);" type="text" class="  search-query form-control" placeholder="Search by code" />
								<span class="input-group-btn">
								<button class="btn" type="button">
									<span class=" glyphicon glyphicon-search"></span>
								</button>
                            </span>
                        </div>
					</div>							
				</div>
            </div>	
		</div>	
		
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div id="scroll" class="scroll" style='background-color:#f5f5f5;'> 
							<table class="table responsive table-bordered">
								<thead style='background-color:<?php echo $_SESSION['Color'];?>'>
									<tr>
										<th class='col-sm-2'>Delivery Code</th>
										<th class='col-sm-2'>Customer's Name</th>
										<th class='col-sm-2'>Contact Number</th>
										<th class='col-sm-2'>Date</th>
										<th class='col-sm-2'>Time</th>
										<th class='col-sm-2'>Address</th>
										<th></th>
									</tr>
								</thead>
								<tbody id="table-data">	
										
									
								</tbody>
								
								<!--<tbody>
									<tr>
									<td>Shaman</td>
									<td>0975 761 7256</td>
									<td>10/22/17</td>
									<td>8:55pm</td>
									<td>Siquijor, Yumadup</td>
									<td align="center"><button onclick="document.getElementById('orderdetails').style.display='block'" class="btn btn-success">Order Details</button></td>
									</tr>						 				
								</tbody>								
								<tbody>
									<tr>
									<td>Shaman</td>
									<td>0975 761 7256</td>
									<td>10/22/17</td>
									<td>8:55pm</td>
									<td>Siquijor, Yumadup</td>
									<td align="center"><button onclick="document.getElementById('orderdetails').style.display='block'" class="btn btn-success">Order Details</button></td>
									</tr>						 				
								</tbody>-->
							</table>
							<div id="spinner">
							  <div class="bounce1"></div>
							  <div class="bounce2"></div>
							  <div class="bounce3"></div>
							</div>
						</div>
					</div>
				</div>
				<img style="cursor:pointer; position:absolute; top:480px; left:450px;" src="images/icon-prev.png" class="prev" alt="Prev" width="35" height="23" />
						<div class="next-table" id="next-table" style="text-align:center; position:absolute; left:475px; height:20px;top:480px; width:120px; margin:auto;">
						</div>
				<img style="cursor:pointer; position:absolute; top:480px; left:587px;" src="images/icon-next.png" class="next" alt="Next" width="35" height="23"/>
				<div id="orderdetails" style="display:none;"class="modal">	
							
					<div class="modal-content">
						<table id="table-orders" class = "table">
							<thead id="order-id" style="">
								<tr>	
									<th style="width:140px;">Name</th>
									<th style="width:70px;">Quantity</th>
									<th style="width:70px;">Price</th>
									<th style="width:100px;">Subtotal <button onclick="document.getElementById('orderdetails').style.display='none'" class="close">&times;</button></th>
								</tr>
							</thead>
							
							<tbody id="table-data-order">		
															
							</tbody>
						</table>
						
						<h1 id="buttons">
							
						</h1>
					</div>
				</div> 
				<div class="box-header with-border">
						<span style="position:relative; top:-10px;">Showing 1 to 10 of 57 entries</span>
					  <div class="box-tools pull-right">
						<div class="pull-left" style="line-height:2.5">1-50/200</div>
						<div class="btn-group">
							
							<button type="button" class="btn btn-default btn-sm prev"><i class="fa fa-chevron-left"></i></button>
							<button type="button" class="btn btn-default btn-sm next"><i class="fa fa-chevron-right"></i></button>
						  </div>
					  </div>
					  <!-- /.box-tools -->
				</div>
			
				
				
			</div> 
			
			</div>
			 
			<footer class="main-footer hidden-xs" align="center">
				<strong>Copyright &copy; 2017 <a href="../index.php">Mushroom Sisig Haus Atbp</a>.</strong> All rights reserved.
			</footer>	
			
</body>
</html>