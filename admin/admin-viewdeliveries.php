<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width = device-width, initial-scale = 1">
<title>Admin</title>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" rev="stylesheet" type="text/css" href="admin-css.css">
<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="font-picker/css/font-awesome.min.css">
<script src="js/jquery.js"> </script>
<script src="js/jquery.timers.js"> </script>
<script src="js/admin-script.js"> </script>
<script src="js/admin-delivajax.js"> </script>

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
								  <a href="#" onclick='signout(); return false;' class="btn btn-default btn-flat">Sign out</a>
								</div>
							  </li>
							</ul>
						  </li>			
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
				<img class="rounded float-left" id="idimg" src="images/once-su.png">
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
						<li><a href="#"><span>Contacts</span><img id="idimg6" width=23 src="images/contacts.png"/></a></li>
							<div class="push popover__content-sub-contents">
								<li><a href="#"><span>Add contacts</span><img width=30 src="images/eye.png"/></a></li>	
								<li><a href="#"><span>View contacts</span><img width=30 src="images/eye.png"/></a></li>	
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
                <div class="row">
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
				<div class="col-md-6 col-md-offset-6">				
					<div id="custom-search-input">
						<div class="input-group">
							<input type="text" class="  search-query form-control" onkeyup="changeDelivHistory(this.value);" placeholder="Search" />
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
						<div style='height:225px; background-color:#f5f5f5;'> 
								<table class="table responsive table-bordered">
									<thead style='background-color:<?php echo $_SESSION['Color'];?>'>
										<tr>
											<th class="col-sm-2">Delivery Code</th>
											<th class="col-sm-3">Date</th>
											<th class="col-sm-2">Time</th>
											<th class="col-sm-2">Served by</th>
											<th class="col-sm-2"></th>
										</tr>
									</thead>
									<tbody id="table-data">	
											
										
									</tbody>
									
									
								</table>
								<div id="spinner">
								  <div class="bounce1"></div>
								  <div class="bounce2"></div>
								  <div class="bounce3"></div>
								</div>
							</div>
					
				</div>
		
				<div id="orderdetails" class="modal">	
					<button onclick="document.getElementById('orderdetails').style.display='none'" class="close">&times;</button>		
					<div class="modal-content">
						<button class="btn btn-block">YADUP</button>
					</div>
				</div> 
			</div> 
			<img style="cursor:pointer; position:absolute; top:480px; left:450px;" src="images/icon-prev.png" class="prev" alt="Prev" width="35" height="23" />
				<div class="next-table" id="next-table" style="text-align:center; position:absolute; left:475px; height:20px;top:480px; width:120px; margin:auto;">
				</div>
			<img style="cursor:pointer; position:absolute; top:480px; left:587px;" src="images/icon-next.png" class="next" alt="Next" width="35" height="23"/>
		</div>	
		</div>
		<footer class="main-footer hidden-xs" align="center">
			<strong>Copyright &copy; 2017 <a href="../index.php">Mushroom Sisig Haus Atbp</a>.</strong> All rights reserved.
		</footer>
					
</body>
</html>