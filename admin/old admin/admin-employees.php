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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"> </script>
<script src="js/admin-script.js"> </script>
<script src="js/jquery.js"> </script>

<style>
#addemployee > div > div > div > div{ position: relative; top: 20px;}
#addemployee > div > div > button{ position: relative; top: 20px;} 
#addemployee > div { height: 50%;} 
#addemployee h4  { position: relative; top: 10px;} 
#addemployee hr { position: relative; top: 5px;} 
</style>

</head>
<?php
	require_once("php/class.database.php");

	$db = MushroomDB::getInstance();
?>
<div class="container-fluid">
	<div class="row">
	  	<div class="header"> 
			<nav class="navbar" style="background-color: #222D32;">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">
						<img style="width: 30px; padding: 5px;" src="images/message.png"></a>
						<div id="msg"><span><small>4</small></span></div>
					</li>
					<li>
					<div class="popover__wrapper2">	
						<img width=30 style="border-radius: 20px;" src="images/once-su.png">
						<span class="text-center"><small>Lorenzo Sequitin</small></span>	
						<div class="push popover__content2">
						<div class="container">
							<div class="row">
								<div class="col-sm-12">
									<img class="img-responsove thumbnail" src="images/once-su.png">
									<span><small>Lorenzo Sequitin</small></span>									 
									<div class="getpic"><label>upload photo<input type="file" name="myImage" accept="image/x-png,image/gif,image/jpeg" /></label></div>
									<button class="btn"><small>Sign out</small></button>									 
								</div>	
							</div>	
						</div>	
						</div>
					</div>
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
                    <div class="col-lg-3">
						<div id="cart">
						<img class="img-responsive center-block" src="images/cartorder.png"/>
						<p class="text-center">TOTAL ORDERS<BR><small>666</small></p>		
						</div>
                    </div>
					<div class="col-lg-3">
						<div id="sales">
						<img class="img-responsive center-block" src="images/sales.png"/>
						<p class="text-center">SALES<BR><small>666</small></p>
						</div>
                    </div>
					<div class="col-lg-3">
						<div id="reg_users">
						<img class="img-responsive center-block" src="images/users.png"/>
						<p class="text-center">REGISTERED USERS<BR><small>666</small></p>
						</div>						
                    </div>
					<div class="col-lg-3">
						<div id="date">
						<p class="text-center"><?php date_default_timezone_set('Asia/Manila'); echo date("h:iA") . "<br>";?><small><?php echo date("l, M d, Y");?></small></p>
						<img class="img-responsive center-block" src="images/calendar.png"/>  
						</div>						
					</div>
                </div>	
		 </div>	      
		 
		<div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
					<div class="input-group">
						 <button onclick="document.getElementById('addemployee').style.display='block'" class="btn btn-default">Add new employee</button>		
					</div>
                </div>
	 
				<div class="col-md-6">				
					<div id="custom-search-input">
						<div class="input-group">
							<input type="text" class="  search-query form-control" placeholder="Search" />
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
						<table class="table responsive table-bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>Employee Name</th>
									<th>Address</th>
									<th>Contact Number</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>
								<td>001</td>
								<td>Hirai Momo</td>
								<td>Bahay nila Harold. <3</td>
								<td>09358900300</td>
								<td>Logged In</td>
								<td align="center">
								<button class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>
								<button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>		
								</td>
								</tr>						 				
							</tbody>																										
						</table>
					</div>
				</div>
			</div> 
			
			<div id="addemployee" class="modal">	
				<button onclick="document.getElementById('addemployee').style.display='none'" class="close">&times;</button>		
				<div class="modal-content">
				<h4 class="text-left">&nbsp;&nbsp;Registration for employee</h4>
				<hr>
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="First name">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Last name">
								</div>	
							</div>	
							<div class="col-lg-12">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Address">
								</div>	
							</div>
							<div class="col-lg-12">
								<div class="input-group">
									 <span class="input-group-addon" id="basic-addon1">+93</span>
									<input type="text" class="form-control" placeholder="Contact no.">
								</div>	
							</div>					 					 												 
						</div>
						<button class="btn btn-block"><span class="glyphicon glyphicon-plus"></span></button>
					</div>	
				</div>					
			</div> 
		</div> 
		
				
					
</body>
</html>