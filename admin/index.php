<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" type="text/css" href="iziToast-master/dist/css/iziToast.css"> 
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminCSS.css">
   
  <!-- Skins-->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!--animate-->
  <link rel="stylesheet" href="css/normalize.min.css">
  <link rel="stylesheet" href="css/animate.min.css">
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!--Sweet alert -->
  <script src="dist/sweetalert2.all.min.js"></script>
  <!--iziToast-->
  <script src="iziToast-master/dist/js/iziToast.js"> </script>
  <!--ajax-->
  <script src="js/jquery.js"> </script>
  <script src="js/jquery.timers.js"> </script>
  <script src="js/admin-pos-ajax.js"> </script>
  <script src="js/admin-settings.js"> </script>
  <link rel="stylesheet" href="dist/css/admin-index.css"> 
  <style><!-- /* flipInX bounceInDown jackInTheBox*/-->

.bounceInDown { 
    -webkit-animation-name: bounceInDown;
    animation-name: bounceInDown;
    -webkit-animation-duration: .5s;
    animation-duration: .5s;
}
.flipInX { 
    -webkit-animation-name: flipInX;
    animation-name: flipInX;
    -webkit-animation-duration: .7s;
    animation-duration: .7s;
}
.zoomIn { 
    -webkit-animation-name: zoomIn;
    animation-name: zoomIn;
    -webkit-animation-duration: .4s;
    animation-duration: .4s;
}
.modal-open {
    overflow-y: scroll;
}
.disabledbutton {
    pointer-events: none;
    opacity: 0.5;	
}
#btn-close-modal {
	width:100%;
    text-align: center;
    cursor:pointer;
    color:#fff;
}

#modal-review,#payment-review,#takeout-review,#modal-review-takeout,#modal-delivery{
	display:none;
}

#id-available{
	display:none;
}
#table-add{
	display:none;
}
#queue-tab{
	display:none;	
}

#cancelChk,#delChk{
	display:none;
}

.containerclass{
	position:absolute;
	top:83.50px;
	left:145px;
	transform:translate(-50%,-50%);
}

.toggle-btn{
	width:32px;
	height:17px;
	background-color:gray;
	border-radius:30px;
	transition: all 250ms ease-in-out;
	cursor:pointer;
}
.toggle-btn.active{
	background-color:#00a65a;
}
.toggle-btn > .inner-circle{
	border:solid 1pt gray;
	width:17.5px;
	height:17px;
	background:#fff;
	border-radius:100%;
	transition: all 250ms ease-in-out;
}

.toggle-btn.active > .inner-circle{
	transition: all 250ms ease-in-out;
	margin-left:15px;
}
  </style>
</head>
<body class="hold-transition skin-blue layout-top-nav fixed"> <!-- 1<body class=".sw-active hold-transition skin-blue sidebar-mini sidebar-collapse fixed ">-->
<?php
	require_once("php/class.database.php");

	$db = MushroomDB::getInstance();
	$db->checkOnline();
	$name = "";
	$admin = $_SESSION['Admin'];
	$sql = "Select * from mushroom_admin where admin_username ='$admin'";
		$exist = $db->checkExist($sql);
		if($exist){
			$num = $db->get_rows($exist);
				if($num>=1){
					$row = $db->fetch_array($exist);
					$name = $row['admin_firstname'];
					$LName = $row['admin_lastname'];
					$user = $row['admin_username'];
					$pic = $row['admin_picture'];
				}	
		}


?>
<div class="wrapper">

  <header class="main-header">

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
		<div class="navbar-header">
         <a class="navbar-brand"><span class="logo-lg"><i class="fa fa-desktop"></i> <b>Point of Sale</b></span></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

		<!-- Collect the nav links, forms, and other content for toggling -->
       <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <!--<li><a href="#">Link</a></li>-->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-dashboard"></i>  Dashboard <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">       
                <li><a style="color:#000;" href="admin-orders.php"><i class="fa fa-inbox"></i> Orders</a></li>
                <li class="divider"></li>
                <li><a style="color:#000;" href="admin-products.php"><i class="fa fa-cutlery"></i> Products</a></li>
				<li class="divider"></li>
                <li><a style="color:#000;" href="admin-employees.php"><i class="fa fa-users"></i> Employees</a></li>
				<li class="divider"></li>
                <li><a style="color:#000;" href="admin-users.php"><i class="fa fa-user-plus"></i> Users</a></li>
				<li class="divider"></li>
                <li><a style="color:#000;" href="admin-reports.php"><i class="fa fa-bar-chart"></i> Reports/Sales</a></li>
              </ul>
            </li>
          </ul>
         <!-- <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
            </div>
          </form>-->
        </div>
		  
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!--<li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-shopping-cart"></i>
              <span class="label label-danger" id="label-message">0</span>
            </a>
           <ul class="dropdown-menu">
              <li class="header" id="header"></li>
              <li>
                <ul class="menu" id="menu">
                                    
                </ul>
              </li>
              <li class="footer"><a href="#" onclick='location.href="admin-pending-orders.php"; return false;'>See All Messages</a></li>
            </ul>
          </li>-->
       
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo "../".$pic; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $name ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo "../".$pic; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $name." ".$LName?> - Administrator
                  <small>@<?php echo $admin?></small>
                </p>
              </li>
       
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="admin-profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a onclick="signout();" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->	
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">	 
		<li style="display:none;"><a id="print_review" href="#modal-review">Review</a></li>
		<li style="display:none;"><a id="takeout_review" href="#modal-review-takeout">Review</a></li>
		<li style="display:none;"><a id="delivery_review" href="#modal-delivery">Review</a></li>
		<li style="display:none;"><a id="payment_review" href="#payment-review">Review</a></li>		
		<li style="display:none;"><a id="takeout_payment" href="#takeout-review">Review</a></li>			
		
		<div id="queue-tab" class="col-lg-4 col-sm-7 col-xs-12 col-lg-offset-8 col-sm-offset-5">
		<div class="small-box bg-white" style="margin-bottom:0px; border-radius:0%;padding:0; background-color: #FDFDFD; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px; height:48px;">          			
			<div style="padding-left:3px;display:block; padding-right:0px;" class="box-tools col-xs-12">
				<div>
					<div style="padding-left:0px; padding-right:0px;" class="box-tools col-xs-12">
						<div class="has-feedback ">
							<input onkeyup="searchQueue(this.value)" id="search-queue" type="text" class="form-control input-lg" placeholder="Search by order no.">
							<span class="glyphicon glyphicon-search form-control-feedback"></span>
						</div>
					</div>
				
				</div>
				<!--<button id="close-queue" style="margin:1px;" type="button" class="btn btn-lg btn-danger pull-right">
					<i  class="fa fa-times-circle" style="margin-right:5px;"></i>Close
				</button>-->
				<div>
		
			
				
				</div>
			</div>
		</div>
		
         
		  
		  <div class="small-box bg-white mousescroll2" style="margin-bottom:10px; border-radius:0%;padding:0; background-color: #FDFDFD; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px; height:305px;">          
           
			<div class="table-responsive" style="overflow:hidden;">          
			  <table class=" table-striped">
				
				<tbody id="table-queue">				
				  <!--<tr>
					<td class='col-xs-1'><label style='position:relative; top:10px;'>Take-out</label><h3 style='position:relative; left:35px; font-size:45pt;'><i  class='fa fa-shopping-basket fa-1x'></h3></td>
					<td class='col-xs-1'><strong>ORD12345678</strong><br/><label style='font-weight:normal;'>Tuesday </label><br/><label style='font-weight:normal;'>Dec. 05, 2017, 09:30 PM</label></td>
					<td class='col-xs-1'><i  class='fa fa-cutlery fa-5x'></i></td>
				  </tr>
				 <!--<div class="col-lg-12 col-sm-6 col-xs-12">
				  <div class="small-box bg-aqua">
					<div class="inner">
					  <h3 id='orders-label'>0</h3>

					  <p>Today's Total Orders</p>
					</div>
					
					<a href="admin-orders.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div>-->				 
				</tbody>
			  </table>
			  </div>
			
			
			
          </div>

		  
		  
        </div>
        <div class="col-lg-4 col-sm-5 col-xs-12" style="padding-right:0px;">
          <!-- small box -->
          <div id="typeButton" class="small-box bg-aqua" data-toggle="modal"  data-target="#typeModal" style="border-radius:0%; cursor:pointer; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
            <div style="padding:12px;" class="small-box-footer"><i class="fa fa-plus-circle"></i> New Order</div>
          </div>

		       
		<!--<div class="small-box" style="padding-left:4px; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);">          
            <div style="padding:12px; border-radius:.3em;" class="small-box-footer col-lg-6"><i class="fa fa-book"></i> New Order</div>
        </div>   -->
		
		<div class="box-header with-border" style="margin-top:0px; padding-right:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">
			<div>				
				
				<div class="box-tools col-lg-6" style="display:none;">
					<div class="has-feedback ">
					
						<select onchange="viewProducts()" class="form-control input-lg" style="font-size:.82em;" name="foodcategory" id="foodcategory">								
<?php
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
	$items = 0;
	$sql1 = "Select * from mushroom_queue";
	$exist1 = $db->checkExist($sql1) or die(mysql_error());
	$numrows = $db->get_rows($exist1);
	$items = $numrows;
	/* if(isset($_SESSION['POSCart'])){
		$items = 0;
		foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
			$items += $cartItems;
		}	
	}
	else{
		$items = 0;
	} */

	
?>														 
						</select>
					</div>
				</div>
			</div>		
			<div>
				<div class="box-tools col-lg-12">
					<div class="has-feedback ">
						<input onkeyup="searchProducts(this.value)" id="search-product" type="text" class="form-control input-lg" placeholder="Search">
						<span class="glyphicon glyphicon-search form-control-feedback"></span>
					</div>
				</div>
				
			</div>
			<div>
				<div class="btn-group col-xs-12" style="padding-top:5px;">
				  <a style='background-color:#0080a5; border-color:#0080a5; font-size:16pt; text-align:left; text-indent:5px;' class="btn btn-primary col-xs-12 input-lg" data-toggle="dropdown" href="#"><i class="fa fa-user fa-bookmark"></i> <span id="products-info" value=''></span><span class="pull-right fa fa-caret-down" title="Toggle dropdown menu"></span></a>
				  <!--<a class="btn btn-primary dropdown-toggle input-lg" data-toggle="dropdown" href="#">
					<span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
				  </a>-->
				  <ul class="dropdown-menu" id="dropdown-choice" style="font-size:18pt; right:5px; max-height:290px; overflow-y:scroll;">
						<!--
						<li><a href="#"><i class="fa fa-bookmark"></i> Student Meals</a></li>
						<li class="divider"></li>
						<li><a href="#"><i class="fa fa-bookmark"></i> Make admin</a></li>
						-->
				  </ul>
				</div>
			</div>
			
			
        </div>			
          

          <!-- small box -->
          <div class="small-box bg-white mousescroll" id="items-table" style="border-radius:0%;padding:0; background-color: #FDFDFD; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px; height:424px;">          
            <!--<a href="admin-view-deliveries.php"style="padding:12px;" class="small-box-footer"><i class="fa fa-plus"></i> Walk in</a>-->
			<div class="table-responsive">          
			  <table class="table-hover">
				
				<tbody id="table-data">					
				  <!--<tr style="border-bottom:solid 1px #ccc;">
					<td class='col-xs-3'><img src="foods/allday_cornedbeef.png" width="60" height="60" class="img-rounded"/></td>
					<td class='col-xs-7'><strong id="prod-name">Sizzling Pink Salmon Head w/ mushroom atsara</strong><br/><small>&#8369; 120.00</small></td>
					<td style="line-height:5;" class='col-xs-1'><i class="fa fa-plus fa-2x"></i> </td>					
				  </tr>	-->		  
				</tbody>
			  </table>
				<div id="spinner">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
			  </div>
			
			
          </div>
      
        </div>	
	
		<div id="order-tab" class="col-lg-8 col-sm-7 col-xs-12">
		<div class="small-box bg-white" style="margin-bottom:0px; border-radius:0%;padding:0; background-color: #FDFDFD; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px; height:48px;">          
			
			<div style="padding-right:0px;" class="box-tools col-xs-12">
				<button onclick='viewQueue();' style="margin:1px; background-color:#0080a5; color:white;" type="button" class="quantity-minus btn btn-lg pull-right">
					<i  class="fa fa-database" style="margin-right:5px;"></i>Queue
				</button>
				<div id="id-available" >
					<label>Table No.</label>
					<div class="btn-group" style="padding-top:1.2px;">
					  <a style='font-size:16pt; text-align:left; text-indent:5px;' class="btn btn-default col-xs-12 input-lg" data-toggle="dropdown" href="#"><span id="table-info" value=''></span><span style="position:relative; top:5px;" class="pull-right fa fa-caret-down" title="Toggle dropdown menu"></span></a>			
					  <ul class="dropdown-menu" id="dropdown-choice-available" style="font-size:18pt; left:-90px; max-height:290px; overflow-y:scroll;">			
											
					  </ul>
					</div>
					
				</div>
				<div id="table-add">
				<h3 style="font-weight:normal;">Table No# <b><span id="table-no-add">0</span></b></h3>
				</div>
				<div id="table-name">
				<h3 style="font-weight:normal;" > <span id="customer-name"></span><i onclick="inputName();" id="inputCustomer" style="display:none; cursor:pointer; font-size:25px; margin-left:5px; color:#ccc;" class="fa fa-plus-circle"></i></h3>
				</div>
				<!--<div id="id-notavailable" >
					<label>Table No.</label>
					<div class="btn-group" style="padding-top:1.2px;">
					  <a style='font-size:16pt; text-align:left; text-indent:5px;' class="btn btn-default col-xs-12 input-lg" data-toggle="dropdown" href="#"><span id="table-info-add" value=''></span><span style="position:relative; top:5px;" class="pull-right fa fa-caret-down" title="Toggle dropdown menu"></span></a>			
					  <ul class="dropdown-menu" id="dropdown-choice-add" style="font-size:18pt; left:-80px; max-height:290px; overflow-y:scroll;">			
											
					  </ul>
					</div>
					
				</div>-->
			</div>
		</div>
		<small id="cartAnimate" style="background-color:#3399FF; position:relative; top:17px; z-index:5; right:2px;" class="label pull-right"><span id="cartQuantity"><?php echo $items; ?></span></small>
          <!-- small box -->
          <div class="small-box bg-white" style="margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">
            <div class="inner">
              <h3 id='orders-label'>Administrator</h3>

              <p id="date-label"><?php date_default_timezone_set('Asia/Manila'); echo date("l, d M Y, h:i A");?></p>
			  <p style="color:#00add7; height:2px;">Order Type: <span id="type-label"></span></p>
            </div>
            <div class="icon">
              <i style="color:#f39c12;" class="fa fa-cart-arrow-down"></i>
            </div>
            
          </div>
		 
		  <div class="small-box bg-white mousescroll" style="margin-bottom:0px; border-radius:0%;padding:0; background-color: #FDFDFD; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px; height:335px;">          
            <!--<a href="admin-view-deliveries.php"style="padding:12px;" class="small-box-footer"><i class="fa fa-plus"></i> Walk in</a>-->
			<div class="table-responsive">   
			 <form id='form-data' method='POST'>
			  <table class=" table-striped">
				
				<tbody id="table-foods">
				<!--<div class="right-arrow col-xs-1" id="preview" style="padding:0px;">
					<div class="input-group">
					  <input style="width:65px;" id="change-qty" type="text" class="form-control input-lg">
					  <span class="input-group-btn">
						<button class="btn btn-lg btn-primary" type="button">OK</button>
					  </span>
					</div>
					<!--<input onkeyup="searchQueue(this.value)" id="search-queue" type="text" class="form-control input-lg" placeholder="Search by order no.">
				</div>-->
				
				<!--<tbody>
				 <tr style="border-bottom:solid 1px #ccc;">
					<td class='col-xs-3'><img src="foods/allday_cornedbeef.png" width="120" height="60" class="img-rounded"/></td>
					<td class='col-xs-6'><strong>Sizzling Pink Salmon Head w/ mushroom atsara</strong><br/><small>&#8369; 120.00</small></td>
					<td style="line-height:5;" class='col-xs-1'></td>
					<td style="line-height:5;" class='col-xs-2'><small>120.00</small> <strong> </strong> </td>
					<td style="line-height:5;" class='col-xs-1'><strong>1</strong> </td>
					<td style="line-height:3;" class="col-xs-2"><i style="color:#94a573;" class="fa fa-chevron-up fa-lg"></i><i style="color:#7e6369;" class="fa fa-chevron-down fa-lg"></i> </td>
				  </tr>-->
				
				  
				</tbody>
			  </table>
			  </div>
			
			
			
          </div>
			<div class="small-box bg-white" style="background-color:#fff; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.30); border-radius:0px;">          
				<div class="box-header with-border">
					<a id="cancelChk" style="margin-right:3px" onclick="changeCartValues(); return false;" class="btn btn-default pull-left" href="#">
						<i class="fa fa-trash-o fa-lg"></i> Cancel
					</a>
					<a id="delChk" style="margin-bottom:0px" onclick="deleteChkbox('form-data'); return false;" class="btn btn-danger pull-left" href="#">
						<i class="fa fa-trash-o fa-lg"></i> Delete
					</a>
				    <h3 class="box-title pull-right" style="font-size:17.3pt;">Total Amount: &#8369; <span id="topay">0.00</span></h3>

				  
				  <!-- /.box-tools -->
				</div>
			</div>
			</form>
			<div class="small-box bg-white" style="padding-top:-10px; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
				<div id="resetDiv" class="box-header with-border  col-xs-4 col-md-4 hidden" style="padding-top:0px; padding-right:0px; padding-left:0px;">				  
						<div class="small-box bg-red" align="right" style="background-color:#54bd9f; border-radius:0%; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
							<div onclick="ask();" style="padding:8px; font-weight:bold; font-size:14pt; cursor:pointer;" class="small-box-footer"><i class="fa fa-ban"></i> RESET</div>
						</div>			
				</div>
				<div id="divReset" class="box-header with-border  col-xs-6 hidden" style="padding-top:0px; padding-right:0px; padding-left:0px;">				  
						<div class="small-box bg-red" align="right" style="border-radius:0%; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
							<div onclick="ask();" style="padding:8px; font-weight:bold;  font-size:14pt; cursor:pointer;" class="small-box-footer"><i class="fa fa-ban"></i> RESET</div><!--background-color:#54bd9f;-->
						</div>			
				</div>
				<div id="queueDiv" class="box-header with-border col-xs-4 col-md-4 hidden" style="padding-top:0px; padding-right:0px; padding-left:0px;">				  
						<div id="checkout" class="small-box" type="button" style="background-color:#66CCFF; border-radius:0%; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
							<div onclick="checkType();" style="padding:8.5px; cursor:pointer; font-weight:bold; font-size:14pt;" id="payButton" class="small-box-footer disabledbutton"><i class="fa fa-check"></i> QUEUE</div> <!--onclick="printReceipt();"-->
						</div>			
				</div>
				<div id="paymentDiv" class="box-header with-border col-xs-4 col-md-4 hidden" style="padding-top:0px; padding-right:0px; padding-left:0px;">				  
						<div id="print-check" class="small-box" type="button" style="background-color:#54bd9f; border-radius:0%; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
						<!--printBill(this.value);--><div onclick="checkPaymentType();"  value="" style="padding:8.5px; cursor:pointer; font-weight:bold; font-size:14pt;" id="print-button" class="small-box-footer disabledbutton"><i class="fa fa-money"></i> PAYMENT</div>
						</div>			
				</div>
				<div id="payment-takeout-div" class="box-header with-border col-xs-6 col-md-6 hidden" style="padding-top:0px; padding-right:0px; padding-left:0px;">				  
						<div id="print-check-takeout" class="small-box" type="button" style="background-color:#54bd9f; border-radius:0%; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
						<!--printBill(this.value);--><div onclick="checkPaymentType();"  value="" style="padding:8.5px; cursor:pointer; font-weight:bold; font-size:14pt;" id="print-button-takeout" class="small-box-footer disabledbutton"><i class="fa fa-money"></i> PAYMENT</div>
						</div>			
				</div>
				<div id="reserveDiv" class="box-header with-border col-xs-6 col-md-6 hidden" style="padding-top:0px; padding-right:0px; padding-left:0px;">				  
						<div id="print-reserve" class="small-box" type="button" style="background-color:#54bd9f; border-radius:0%; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
							<div onclick="checkType();"  value="" style="padding:8.5px; cursor:pointer; font-weight:bold; font-size:14pt;" id="reserve-button" class="small-box-footer disabledbutton"><i class="fa fa-book"></i> RESERVE</div>
						</div>			
				</div>
				<div id="addDiv" class="box-header with-border col-xs-6 col-md-6 hidden" style="padding-top:0px; padding-right:0px; padding-left:0px;">				  
						<div id="add-check" class="small-box" type="button" style="background-color:#66CCFF; border-radius:0%; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;"><!--66CCFF-->
						<div onclick="checkType();"  value="" style="padding:8.5px; cursor:pointer; font-weight:bold; font-size:14pt;" id="print-button-add" class="small-box-footer"><i class="fa fa-plus-circle"></i> ADD</div>
						</div>			
				</div>
			</div>
		  
		  
        </div> 
		
		 
		
      </div>
  
	
	
    </section>
    <!-- /.content -->
  </div>
  
  <!-- /.content-wrapper -->
  <footer class="main-footer">
   
    <strong>Copyright &copy; 2017 <a>Mushroom Sisig Haus atbp</a>.</strong> All rights
    reserved.<!--target="_new" href="../index.php"-->
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <div class="tab-content">
		<div class="tab-pane" id="control-sidebar-home-tab">        
		</div>
	</div>
  </aside>
	<!-- Modal -->
  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="payModal" role="dialog">
  <form id="reg-form" class='reg-form'>
    <div class="modal-dialog modal-sm">
      <div class="modal-content" id="payModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">
          <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h3 id='orders-label'class="modal-title"><i class="fa fa-money"></i> Make payment</h3>
        </div>
		
        <div class="modal-body">
			<div class="has-feedback ">
			  <input type="text" id="txtNumber" onkeypress="return isNumber(event)" class="input-lg form-control" id="inputSuccess" placeholder="0">
			</div>
        </div>
        <div class="modal-footer">		
			<a onclick="resetValue();" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<a onclick="checkPayment();" class="btn btn-success">
				<i class="fa fa-check-circle fa-lg"></i> Proceed
			</a>			
        </div>
      </div>
    </div>
	</form>
  </div>
  
  <div class="modal" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="qtyModal" role="dialog">
  <form id="reg-form" class='reg-form'>
    <div id="qtyModalBody" class="modal-dialog modal-sm">
      <div class="modal-content" id="qtyModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">
          <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h3 id='orders-label'class="modal-title"><i class="fa fa-sort-numeric-asc"></i> Quantity</h3>
        </div>
		
        <div class="modal-body">
			<div class="has-feedback ">
				 <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtQty" onkeypress="handleKeyPress(event); return isNumbers(event); " class="input-lg form-control">
			</div>
			<!--<div class="has-feedback ">
			  <input type="text" onkeypress="return isNumbers(event)" class="input-lg form-control" id="txtQty" placeholder="0">
			</div>-->
        </div>
        <div class="modal-footer">		
			<a data-dismiss="modal" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<button type="button" onclick="cartUpdate(this.name);" name="" id="confirmUpdate" data-dismiss="modal" class="btn btn-success" >
				<i class="fa fa-check-circle fa-lg"></i> Confirm
			</button>		
        </div>
      </div>
    </div>
	</form>
  </div>
  
  <div class="modal" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="nameModal" role="dialog">
  <form id="reg-form" class='reg-form'>
    <div id="nameModalBody" class="modal-dialog modal-sm">
      <div class="modal-content" id="nameModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">
          <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h3 id='orders-label'class="modal-title"><i class="fa fa-user"></i> Customer Name</h3>
        </div>
		
        <div class="modal-body">
			<div class="has-feedback ">
				 <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtCustomer" onkeypress="handleKeyPressCustomer(event); return isLetters(event); " class="input-lg form-control">
			</div>
			<!--<div class="has-feedback ">
			  <input type="text" onkeypress="return isNumbers(event)" class="input-lg form-control" id="txtQty" placeholder="0">
			</div>-->
        </div>
        <div class="modal-footer">		
			<a data-dismiss="modal" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<button type="button" onclick="nameUpdate();" name="" class="btn btn-success" >
				<i class="fa fa-check-circle fa-lg"></i> Confirm
			</button>		
        </div>
      </div>
    </div>
	</form>
  </div>
  
  <div class="modal" data-backdrop="static" data-keyboard="false" style="padding-top:100px; z-index:99999;" id="scModal" role="dialog">
  <form id="reg-form" class='reg-form'>
    <div id="scModalBody" class="modal-dialog modal-sm">
      <div class="modal-content" id="scModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">
     
          <h3 id='orders-label'class="modal-title"><i class="fa fa-id-card"></i>SC ID No.</h3>
        </div>
		
        <div class="modal-body">
			<div class="has-feedback ">
				 <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtSC" onkeypress="handleKeyPressCustomerSC(event); return isNumbers(event); " class="input-lg form-control">
			</div>
	
        </div>
        <div class="modal-footer">		
			<a data-dismiss="modal" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<button data-dismiss="modal" type="button" onclick="discountPaymentScID();" name="" class="btn btn-success" >
				<i class="fa fa-check-circle fa-lg"></i> Confirm
			</button>		
        </div>
      </div>
    </div>
	</form>
  </div>

  <div class="modal" data-backdrop="static" data-keyboard="false" style="padding-top:100px; z-index:99999;" id="scTkModal" role="dialog">
  <form id="reg-form" class='reg-form'>
    <div id="scTkModalBody" class="modal-dialog modal-sm">
      <div class="modal-content" id="scTkModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">
     
          <h3 id='orders-label'class="modal-title"><i class="fa fa-id-card"></i>SC ID No.</h3>
        </div>
		
        <div class="modal-body">
			<div class="has-feedback ">
				 <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtTkSC" onkeypress="handleKeyPressCustomerTkSC(event); return isNumbers(event); " class="input-lg form-control">
			</div>
	
        </div>
        <div class="modal-footer">		
			<a data-dismiss="modal" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<button data-dismiss="modal" type="button" onclick="discountPaymentTkScID();" name="" class="btn btn-success" >
				<i class="fa fa-check-circle fa-lg"></i> Confirm
			</button>		
        </div>
      </div>
    </div>
	</form>
  </div>

  <div class="modal" data-backdrop="static" data-keyboard="false" style="padding-top:100px; z-index:99999;" id="scReviewModal" role="dialog">
  <form id="reg-form" class='reg-form'>
    <div id="scReviewModalBody" class="modal-dialog modal-sm">
      <div class="modal-content" id="scReviewModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">
     
          <h3 id='orders-label'class="modal-title"><i class="fa fa-id-card"></i>SC ID No.</h3>
        </div>
		
        <div class="modal-body">
			<div class="has-feedback ">
				 <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtReviewSC" onkeypress="handleKeyPressCustomerReviewSC(event); return isNumbers(event); " class="input-lg form-control">
			</div>
	
        </div>
        <div class="modal-footer">		
			<a data-dismiss="modal" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<button data-dismiss="modal" type="button" onclick="discountPaymentReviewScID();" name="" class="btn btn-success" >
				<i class="fa fa-check-circle fa-lg"></i> Confirm
			</button>		
        </div>
      </div>
    </div>
	</form>
  </div>
  
  <div class="modal" data-backdrop="static" data-keyboard="false" style="padding-top:100px; z-index:99999;" id="pwdModal" role="dialog">
  <form id="reg-form" class='reg-form'>
    <div id="pwdModalBody" class="modal-dialog modal-sm">
      <div class="modal-content" id="pwdModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">

          <h3 id='orders-label'class="modal-title"><i class="fa fa-id-card"></i>PWD ID No.</h3>
        </div>
		
        <div class="modal-body">
			<div class="has-feedback ">
				 <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtPWD" onkeypress="handleKeyPressCustomerPWD(event); return isNumbers(event); " class="input-lg form-control">
			</div>
		
        </div>
        <div class="modal-footer">		
			<a data-dismiss="modal" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<button data-dismiss="modal" type="button" onclick="discountPaymentPwdID();" name="" class="btn btn-success" >
				<i class="fa fa-check-circle fa-lg"></i> Confirm
			</button>		
        </div>
      </div>
    </div>
	</form>
  </div>

  <div class="modal" data-backdrop="static" data-keyboard="false" style="padding-top:100px; z-index:99999;" id="pwdTkModal" role="dialog">
  <form id="reg-form" class='reg-form'>
    <div id="pwdTkModalBody" class="modal-dialog modal-sm">
      <div class="modal-content" id="pwdTkModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">

          <h3 id='orders-label'class="modal-title"><i class="fa fa-id-card"></i>PWD ID No.</h3>
        </div>
		
        <div class="modal-body">
			<div class="has-feedback ">
				 <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtTkPWD" onkeypress="handleKeyPressCustomerTkPWD(event); return isNumbers(event); " class="input-lg form-control">
			</div>
		
        </div>
        <div class="modal-footer">		
			<a data-dismiss="modal" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<button data-dismiss="modal" type="button" onclick="discountPaymentTkPwdID();" name="" class="btn btn-success" >
				<i class="fa fa-check-circle fa-lg"></i> Confirm
			</button>		
        </div>
      </div>
    </div>
	</form>
  </div>
  
  <div class="modal" data-backdrop="static" data-keyboard="false" style="padding-top:100px; z-index:99999;" id="pwdReviewModal" role="dialog">
  <form id="reg-form" class='reg-form'>
    <div id="pwdReviewModalBody" class="modal-dialog modal-sm">
      <div class="modal-content" id="pwdReviewModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">

          <h3 id='orders-label'class="modal-title"><i class="fa fa-id-card"></i>PWD ID No.</h3>
        </div>
		
        <div class="modal-body">
			<div class="has-feedback ">
				 <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtReviewPWD" onkeypress="handleKeyPressCustomerReviewPWD(event); return isNumbers(event); " class="input-lg form-control">
			</div>
		
        </div>
        <div class="modal-footer">		
			<a data-dismiss="modal" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<button data-dismiss="modal" type="button" onclick="discountPaymentReviewPwdID();" name="" class="btn btn-success" >
				<i class="fa fa-check-circle fa-lg"></i> Confirm
			</button>		
        </div>
      </div>
    </div>
	</form>
  </div>
  <!--<div class="modal" data-backdrop="static" data-keyboard="false" style="padding-top:100px; z-index:99999;"id="pwdModal" role="dialog">
  <form id="reg-form" class='reg-form'>
    <div id="qtyModalBody" class="modal-dialog modal-sm">
      <div class="modal-content" id="pwdModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">
         
          <h3 id='orders-label'class="modal-title"><i class="fa fa-sort-numeric-asc"></i> Quantity</h3>
        </div>
		
        <div class="modal-body">
			<div class="has-feedback ">
				 <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtQty" onkeypress="handleKeyPress(event); return isNumbers(event); " class="input-lg form-control">
			</div>
	
        </div>
        <div class="modal-footer">		
			<a data-dismiss="modal" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<button type="button" onclick="cartUpdate(this.name);" name="" id="confirmUpdate" data-dismiss="modal" class="btn btn-success" >
				<i class="fa fa-check-circle fa-lg"></i> Confirm
			</button>		
        </div>
      </div>
    </div>
	</form>
  </div>-->
  
  
  <!--<div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="infoModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" id="payModalAnimate" style="border-radius:3pt;">
        <div class="modal-header" style="background-color:#5cbce6;color:#fff;" align="center">
         
		  <i class="fa fa-warning fa-2x"></i>
          <h3 id='orders-label'  class="modal-title"> Info Alert</h3>
        </div>
		
        <div class="modal-body" style="text-align:center;">
			Insufficient funds!
        </div>
        <div class="modal-footer" style=" text-align:center;">		
			<a onclick="closeModal();" class="btn btn-info">
				<i class="fa fa-check fa-lg"></i> OK
			</a>
        </div>
      </div>
    </div>
  </div>-->

  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="alertModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" id="alertModalAnimate" style="border-radius:3pt;">
        <div class="modal-header" style="background-color:#e66454;color:#fff;" align="center">
          <button type="button" class="close" onclick='closeAlert();'>&times;</button><!--data-dismiss="modal"-->
		  <i class="fa fa-warning fa-2x"></i>
          <h3 id='orders-label'  class="modal-title"> Alert</h3>
        </div>
		
        <div class="modal-body" style="text-align:center;">
			This action requires your confirmation. Please choose an option:
        </div>
        <div class="modal-footer" style=" text-align:center;">		
			<a onclick="cartMinus('0');" class="btn btn-danger" href="#">
				<i class="fa fa-trash-o fa-lg"></i> Delete
			</a>			
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="typeModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content" id="typeModalAnimate" style="border-radius:3pt;">
        <div class="modal-header" style="background-color:#00add7;color:#fff;" align="center">
         <!-- <button type="button" class="close" onclick='closeOrderType();'>&times;</button> data-dismiss="modal"-->		 
          <h3 id='orders-label'  class="modal-title"> Select Order Type</h3>
        </div>
		
        <div class="modal-body" style="text-align:center; padding:0px;">
			<div class="small-box bg-white" style="background-color:#fff; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.30); border-radius:0px;">          				
				<div onclick="newOrder('DineIn'); hideNewModal();" style="cursor:pointer; padding:25px; background-image:url('images/icon-dine-in.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Dine In</span></p>
				</div>
				<div onclick="newOrder('DineIn'); hideNewModal();" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Dine In</span></p>
				</div>
				<div onclick="newOrder('TakeOut'); hideNewModal();" style="cursor:pointer; padding:25px; background-image:url('images/icon-take-out.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Take Out</span></p>
				</div>	
				<div onclick="newOrder('TakeOut'); hideNewModal();" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Take Out</span></p>
				</div>		
				<div onclick="newOrder('Reserve'); hideNewModal();" style="cursor:pointer; padding:25px; background-image:url('images/icon-reserve.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				   <p class="box-title" style="text-align:center; font-size:17.3pt; padding-left:40px;">Reservation</span></p>
				</div>	
				<div onclick="newOrder('Reserve'); hideNewModal();" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				   <p class="box-title" style="text-align:center; font-size:17.3pt;">Reservation</span></p>
				</div>		
				<!--<div onclick="newOrder('AddOrd'); hideNewModal();" style="cursor:pointer; padding:25px; background-image:url('images/icon-add-order.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				   <p class="box-title" style="text-align:center; font-size:17.3pt; padding-left:40px;">Add Order(s)</span></p>
				</div>	
				<div onclick="newOrder('AddOrd'); hideNewModal();" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				   <p class="box-title" style="text-align:center; font-size:17.3pt;">Add Order(s)</span></p>
				</div>-->
			</div>
        </div>
        <div class="modal-footer" style=" text-align:center;">		
			<a onclick="closeOrderType();" style='background-color:#737373; border-color:#737373;' class="btn btn-danger">
				<i class="fa fa-ban fa-lg"></i> Cancel
			</a>			
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px; z-index:99999;" id="discountModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content" id="discountModalAnimate" style="border-radius:3pt;">
        <div class="modal-header" style="background-color:#00add7;color:#fff;" align="center">
         <!-- <button type="button" class="close" onclick='closeOrderType();'>&times;</button> data-dismiss="modal"-->		 
          <h3 id='orders-label'  class="modal-title"> Select Discount Type</h3>
        </div>
		
        <div class="modal-body" style="text-align:center; padding:0px;">
			<div class="small-box bg-white" style="background-color:#fff; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.30); border-radius:0px;">          				
				<div onclick="showSC();" data-dismiss="modal" style="cursor:pointer; padding:25px; background-image:url('images/icon-sc.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				  <p class="box-title" style="text-align:right; text-indent:80px; font-size:17.3pt;">Senior Citizen</p>
				</div>
				<div onclick="showSC();" data-dismiss="modal" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Senior Citizen</p>
				</div>
				<div onclick="showPWD();" data-dismiss="modal" style="cursor:pointer; padding:25px; background-image:url('images/icon-pwd.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">PWD</p>
				</div>	
				<div onclick="showPWD();" data-dismiss="modal" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">PWD</p>
				</div>		
					
				<!--<div onclick="newOrder('AddOrd'); hideNewModal();" style="cursor:pointer; padding:25px; background-image:url('images/icon-add-order.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				   <p class="box-title" style="text-align:center; font-size:17.3pt; padding-left:40px;">Add Order(s)</span></p>
				</div>	
				<div onclick="newOrder('AddOrd'); hideNewModal();" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				   <p class="box-title" style="text-align:center; font-size:17.3pt;">Add Order(s)</span></p>
				</div>-->
			</div>
        </div>
        <div class="modal-footer" style=" text-align:center;">		
			<a data-dismiss="modal" style='background-color:#737373; border-color:#737373;' class="btn btn-danger"><!--onclick="closeOrderType();"-->
				<i class="fa fa-ban fa-lg"></i> Cancel
			</a>			
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px; z-index:99999;" id="discountModalTK" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content" id="discountModalTKAnimate" style="border-radius:3pt;">
        <div class="modal-header" style="background-color:#00add7;color:#fff;" align="center">
          <h3 class="modal-title"> Select Discount Type</h3>
        </div>
		
        <div class="modal-body" style="text-align:center; padding:0px;">
			<div class="small-box bg-white" style="background-color:#fff; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.30); border-radius:0px;">          				
				<div onclick="showTkSC();" data-dismiss="modal" style="cursor:pointer; padding:25px; background-image:url('images/icon-sc.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				  <p class="box-title" style="text-align:right; text-indent:80px; font-size:17.3pt;">Senior Citizen</p>
				</div>
				<div onclick="showTkSC();" data-dismiss="modal" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Senior Citizen</p>
				</div>
				<div onclick="showTkPWD();" data-dismiss="modal" style="cursor:pointer; padding:25px; background-image:url('images/icon-pwd.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">PWD</p>
				</div>	
				<div onclick="showTkPWD();" data-dismiss="modal" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">PWD</p>
				</div>		
			</div>
        </div>
        <div class="modal-footer" style=" text-align:center;">		
			<a data-dismiss="modal" style='background-color:#737373; border-color:#737373;' class="btn btn-danger">
				<i class="fa fa-ban fa-lg"></i> Cancel
			</a>			
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px; z-index:99999;" id="discountModalReview" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content" id="discountModalReviewAnimate" style="border-radius:3pt;">
        <div class="modal-header" style="background-color:#00add7;color:#fff;" align="center">
          <h3 class="modal-title"> Select Discount Type</h3>
        </div>
		
        <div class="modal-body" style="text-align:center; padding:0px;">
			<div class="small-box bg-white" style="background-color:#fff; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.30); border-radius:0px;">          				
				<div onclick="showModalSC();" data-dismiss="modal" style="cursor:pointer; padding:25px; background-image:url('images/icon-sc.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				  <p class="box-title" style="text-align:right; text-indent:80px; font-size:17.3pt;">Senior Citizen</p>
				</div>
				<div onclick="showModalSC();" data-dismiss="modal" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Senior Citizen</p>
				</div>
				<div onclick="showModalPWD();" data-dismiss="modal" style="cursor:pointer; padding:25px; background-image:url('images/icon-pwd.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">PWD</p>
				</div>	
				<div onclick="showModalPWD();" data-dismiss="modal" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">PWD</p>
				</div>		
			</div>
        </div>
        <div class="modal-footer" style=" text-align:center;">		
			<a data-dismiss="modal" style='background-color:#737373; border-color:#737373;' class="btn btn-danger">
				<i class="fa fa-ban fa-lg"></i> Cancel
			</a>			
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="clearModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" id="clearModalAnimate" style="border-radius:3pt;">
        <div class="modal-header" style="background-color:#e66454;color:#fff;" align="center">
          <button type="button" class="close" onclick='closeClearAlert();'>&times;</button>
		  <i class="fa fa-warning fa-2x"></i>
          <h3 id='orders-label'  class="modal-title"> Alert</h3>
        </div>
		
        <div class="modal-body" style="text-align:center;">
			This action requires your confirmation. Please choose an option:
        </div>
        <div class="modal-footer" style=" text-align:center;">		

			<a onclick="clearCart();" data-dismiss="modal" class="btn btn-danger" >
				<i class="fa fa-refresh fa-lg"></i> RESET
			</a>			
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="delModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" id="delModalAnimate" style="border-radius:3pt;">
        <div class="modal-header" style="background-color:#e66454;color:#fff;" align="center">
          <button type="button" class="close" onclick='closeDelAlert();'>&times;</button>
		  <i class="fa fa-warning fa-2x"></i>
          <h3 id='orders-label'  class="modal-title"> Alert</h3>
        </div>
		
        <div class="modal-body" style="text-align:center;">
			This action requires your confirmation. Please choose an option:
        </div>
        <div class="modal-footer" style=" text-align:center;">		

			<a onclick="delOrder();" id="delOrder" data-dismiss="modal" class="btn btn-danger" >
				<i class="fa fa-trash-o fa-lg"></i> Delete
			</a>			
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="cancelModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" id="cancelModalAnimate" style="border-radius:3pt;">
        <div class="modal-header" style="background-color:#e66454;color:#fff;" align="center">
          <button type="button" class="close" onclick='closeCancelModal();'>&times;</button>
		  <i class="fa fa-warning fa-2x"></i>
          <h3 id='orders-label'  class="modal-title"> Alert</h3>
        </div>
		
        <div class="modal-body" style="text-align:center;">
			This action requires your confirmation. Please choose an option:
        </div>
        <div class="modal-footer" style=" text-align:center;">		
			<button type="button" onclick="confirmCancelOrder(this.name);" name="" id="confirmCancel" data-dismiss="modal" class="btn btn-danger" onclick='closeCancelModal();'>
				<i class="fa fa-trash-o fa-lg"></i> Delete
			</button>
			
        </div>
      </div>
    </div>
  </div>
  
  <!--<div class="modal fade" data-backdrop="static" data-keyboard="true" style="padding-top:100px;"id="addModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" id="addModalAnimate" style="border-radius:3pt;">
        <div class="modal-header">
          <!--<button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 id='orders-label'class="modal-title"><i class="fa fa-cutlery"></i> Add product</h3>
        </div>
		
        <div class="modal-body">
			<center><img id="product-pic" src='' width="220" height="120"/></center>
			<h5><center><strong id="product-label"></strong></center></h5>
			<div class="input-group">
				<span class="input-group-btn">
					<button type="button" class="quantity-minus btn btn-primary btn-number">
						<i  class="fa fa-minus"></i>
					</button>
				</span>
				<input type="text" style="text-align:center;" id="quantity" class="form-control input-md" readonly value="1" min="1" max="10">
				<span class="input-group-btn">
					<button type="button" class="quantity-plus btn btn-danger btn-number">
						<i  class="fa fa-plus"></i>
					</button>
				</span>
			</div>
        </div>
		
        <div class="modal-footer">		
			<a onclick="resetValue();" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-ban fa-1x"></i> Cancel
			</a>
			<a class="btn btn-success" id="buttonAdd" name="" onclick="addQuantity(this.name);">
				<i class="fa fa-plus-circle fa-lg"></i> Add 
			</a>			
        </div>
      </div>
    </div>
  </div>-->
  
	<div id="payment-review">
            
            <div class="modal-content" style="margin:15px 15px 0px 15px;">
				 
					<div class="col-xs-12 " style="position:relative; height:65px; background-color:#34454f; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px 3px 0px 3px;">						
						<h3 id='orders-label' style="color:#fff;">Order Details
						<button type="button" style="position:relative; top:-4px; border-radius:12pt; background-color:#f97a78; border-color:#f97a78; " class="close-payment-review btn btn-danger btn-number pull-right">
							CLOSE
						</button>
						<!--<button onclick="cancelOrder(this.name);" name="" id="cancel-dine-in" type="button" style="position:relative; top:-4px; margin-right:15px; border-radius:12pt; " class="btn btn-default btn-number pull-right">
							<i  class="fa fa-ban" style="padding-right:1px;"></i> CANCEL ORDER
						</button>-->
						</h3>
					</div>
					<div class="col-sm-8" style="padding-top:10px; position:relative; height:605px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="row">	 						
					        <div class="col-lg-4 col-sm-4 col-xs-12">
					          <div class="small-box bg-green">
					            <div class="inner">
					              <h4 id="sales-label"><span style="font-size:18px; font-weight: bold;" id="payment-table-no"></span><sup style="font-size: 20px"></sup></h4>

					              <p>Table Number</p>
					            </div>
					            <div class="icon">
					              <i class="ion ion-ios-location"></i>
					            </div>
					            <a class="small-box-footer"> <i style="visibility:hidden;" class="fa fa-arrow-circle-right"></i></a>
					          </div>
					        </div>
					        <div class="col-lg-4 col-sm-4 col-xs-12">

					          <div class="small-box bg-yellow">
					            <div class="inner">
					              <h4><span style="font-size:18px; font-weight: bold;">Dine-in</span></h4>

					              <p>Order Type</p>
					            </div>
					            <div class="icon">
					              <i class="ion ion-ios-pricetags"></i>
					            </div>
					            <a class="small-box-footer"> <i style="visibility:hidden;" class="fa fa-arrow-circle-right"></i></a>
					          </div>
					        </div>

					        <div class="col-lg-4 col-sm-4 col-xs-12">

					          <div class="small-box bg-red">
					            <div class="inner">
					              <h4 style="font-size:18px; font-weight: bold;" id='payment-time'><?php date_default_timezone_set('Asia/Manila'); echo date("h:iA");?></h4>
					              <p id='payment-date'><?php echo date("D, m/d/Y"); ?></p>
					            </div>
					            <div class="icon">
					              <i class="ion ion-ios-calendar"></i>
					            </div>
					            <a class="small-box-footer"> <i style="visibility:hidden;" class="fa fa-arrow-circle-right"></i></a>
					          </div>
					        </div>
							
					      </div>

						<!-- <div class="col-xs-4">
						<strong>Order Type</strong>: <span>Dine-in</span>
						</div>
						<div class="col-xs-2 col-xs-offset-1">
						<strong>Table No</strong>. <span id="payment-table-no"></span>
						</div>
						<div class="col-xs-3 col-xs-offset-2">
						<i class="fa fa-clock-o  fa-lg" style="padding-right:2px;"> </i><span id="payment-time"></span>
						</div>
						<div class="col-xs-4">
						<strong>Total Amount</strong>: <span id="payment-total-top">143.00</span>
						</div>
						<div class="col-xs-2 col-xs-offset-1">
						<i class="fa fa-calendar  fa-lg" style="padding-right:2px;"> </i><span id="payment-date">11/25/2017</span>
						</div>
						<div class="col-xs-3 col-xs-offset-2">
						</div> -->
						
						<div class="col-xs-12" style="padding-top:25px;">
						  <div class="box box-primary table-responsive mousescroll" style="max-height: 393px;">
							<table class="table table-bordered">
						
							  <thead>
								<tr>
								  <th>Food Name</th>
								  <th>Quantity</th>
								  <th>Price</th>
								  <th>Total</th>
								</tr>
							  </thead>
							  <tbody id="payment-table">																
								
							  </tbody>
							  
							</table>
						  </div>
						</div>
						<div style="position: absolute; bottom:5px; right:35px; font-size:18px;">
						<strong>Total Amount</strong>: <span id="payment-total-top"></span>
						</div>
						
					</div>
					<div class="col-sm-4" style="padding-top:10px; position:relative; height:605px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="has-feedback ">
						  <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="paymentText" onkeyup="changePaymentTotal(this.value);" onkeypress="return isNumber(event)" class="input-lg form-control" id="inputSuccess" placeholder="0">
						</div>
						<div class="col-xs-12" style="padding-top:15px;">
							<div class="table-responsive">
								<table class="table table-bordered">
								<tfoot>
									<tr style="font-size:15pt; font-weight:bold;">									  
									  <td><strong>Payment</strong>: </td>
									  <td style="text-align:right;" id="payment-total-input"> 0.00</td>
									</tr>
									<tr style="font-size:15pt; font-weight:bold;">									  
									  <td><strong>Discount</strong>: <div class='containerclass' style="height:29.2px; color:white; background-color: #5bba59; border:solid 2px #5ea660; width:70px; border-radius: 100px;"><div class='inner-circle'><i style="cursor:pointer; font-size: 26.2px; margin:0 3.5px 0 1.5px;" onclick="showDiscount();" class="fa fa-plus-circle"> </i><span style="font-size: 15px; font-weight: normal; position: absolute; top:2.9px;">Add</span></i></div></div></td><!--<div class='containerclass'><div onclick="this.classList.toggle('active'); discountPayment();" id='toggle-id-payment' class='toggle-btn'><div class='inner-circle'></div> </div></div>-->
									  <!-- <td><strong>Discount</strong>: <div class='containerclass' style="height:29.2px; color:white; background-color: #5bba59; border:solid 2px #5ea660; width:70px; border-radius: 100px;"><div class='inner-circle'><i style="cursor:pointer; font-size: 26.2px; margin:0 3.5px 0 1.5px;" onclick="showDiscount();" class="fa fa-plus-circle"> </i><span style="font-size: 15px; font-weight: normal; position: absolute; top:2.9px;">Add</span></i></div></div></td> -->
									  <td style="text-align:right;" id="review-discount-payment"> 0.00</td>
									</tr>
									<tr style="font-size:15pt; font-weight:bold;">
									  
									  <td><strong>Total</strong>: </td>
									  <td style="text-align:right;" id="payment-total-price"> 0.00</td>
									</tr>									
									
									<tr style="font-size:15pt; font-weight:bold;">
									  
									  <td><strong>Change Due</strong>: </td>
									  <td style="text-align:right;" id="payment-change"> 0.00</td>
									</tr>
									
								
								  </tfoot>
								</table>
							</div>
						</div>
						<div id="printPayment-button" class="col-xs-12" style="position:absolute; bottom:80px; text-align:center; padding-top:25px;">
						
								<!--<button onclick="printDinein(this.name);" id="print-dine-receipt" name="" type="button" class="quantity-plus btn-lg btn-default btn-number">
									<i  class="fa fa-print"></i><span>  Print Receipt</span>
								</button>-->
										
								<button type="button" value="" name="" onclick="printPaymentDineReceipt(this.value);" id="payment-print" class="quantity-plus btn-lg btn-danger btn-number">
									<i  class="fa fa-upload"></i><span>  Pay & Queue</span>
								</button>
						
						</div>
					</div>
				
            </div>
        </div>
  
	<div id="takeout-review">
            
            <div class="modal-content" style="margin:15px 15px 0px 15px;">
				 
					<div class="col-xs-12 " style="position:relative; height:65px; background-color:#34454f; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px 3px 0px 3px;">						
						<h3 id='orders-label' style="color:#fff;">Order Details
						<button type="button" style="position:relative; top:-4px; border-radius:12pt; background-color:#f97a78; border-color:#f97a78; " class="close-takeout-review btn btn-danger btn-number pull-right">
							CLOSE
						</button>
						<!--<button onclick="cancelOrder(this.name);" name="" id="cancel-dine-in" type="button" style="position:relative; top:-4px; margin-right:15px; border-radius:12pt; " class="btn btn-default btn-number pull-right">
							<i  class="fa fa-ban" style="padding-right:1px;"></i> CANCEL ORDER
						</button>-->
						</h3>
					</div>
					
					<div class="col-sm-8" style="padding-top:10px; position:relative; height:595px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	

						<div class="row">	 							   
					        <div class="col-lg-6 col-sm-6 col-xs-12">
					          <div class="small-box bg-yellow">
					            <div class="inner">
					              <h4 id="users-label"><span style="font-size:18px; font-weight: bold;">Take-out</span></h4>

					              <p>Order Type</p>
					            </div>
					            <div class="icon">
					              <i class="ion ion-ios-pricetags"></i>
					            </div>
					            <a class="small-box-footer"> <i style="visibility:hidden;" class="fa fa-arrow-circle-right"></i></a>
					          </div>
					        </div>

					        <div class="col-lg-6 col-sm-6 col-xs-12">

					          <div class="small-box bg-red">
					            <div class="inner">
					              <h4 style="font-size:18px; font-weight: bold;" id='takeout-time'><?php date_default_timezone_set('Asia/Manila'); echo date("h:iA");?></h4>
					              <p id='takeout-date'><?php echo date("D, m/d/Y"); ?></p>
					            </div>
					            <div class="icon">
					              <i class="ion ion-ios-calendar"></i>
					            </div>
					            <a class="small-box-footer"> <i style="visibility:hidden;" class="fa fa-arrow-circle-right"></i></a>
					          </div>
					        </div>		
						</div>

						<!-- <div class="col-xs-4">
						<i class="fa fa-calendar  fa-lg" style="padding-right:2px;"> </i><span id="takeout-date">11/25/2017</span>
						</div>
						<div class="col-xs-2 col-xs-offset-1">
						<i class="fa fa-clock-o  fa-lg" style="padding-right:2px;"> </i><span id="takeout-time"></span>
						</div>
						<div class="col-xs-3 col-xs-offset-2">
						<strong>Total Amount</strong>: <span id="takeout-total-top">143.00</span>
						</div>
						<div class="col-xs-4">
						<strong>Order Type</strong>: <span>Take-out</span>
						</div>
						
						<div class="col-xs-3 col-xs-offset-2">
						</div> -->
						
						<div class="col-xs-12" style="padding-top:25px;">
						  <div class="box box-primary table-responsive mousescroll" style="max-height: 373px;">
							<table class="table table-bordered">
						
							  <thead>
								<tr>
								  <th>Food Name</th>
								  <th>Quantity</th>
								  <th>Price</th>
								  <th>Total</th>
								</tr>
							  </thead>
							  <tbody id="takeout-table">																
								
							  </tbody>
							  
							</table>
						  </div>
						</div>
						<div style="position: absolute; bottom:5px; right:35px; font-size:18px;">
							<strong>Total Amount</strong>: <span id="takeout-total-top"></span>
						</div>
						
					</div>
					<div class="col-sm-4" style="padding-top:10px; position:relative; height:595px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="has-feedback ">
						  <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="paymentTakeout" onkeyup="changePaymentTakeoutTotal(this.value);" onkeypress="return isNumber(event)" class="input-lg form-control" id="inputSuccess" placeholder="0">
						</div>
						<div class="col-xs-12" style="padding-top:15px;">
							<div class="table-responsive">
								<table class="table table-bordered">
								<tfoot>
									<tr style="font-size:15pt; font-weight:bold;">									  
									  <td><strong>Payment</strong>: </td>
									  <td style="text-align:right;" id="takeout-total-input"> 0.00</td>
									</tr>
									<tr style="font-size:15pt; font-weight:bold;">									  
									  <td><strong>Discount</strong>: <div class='containerclass'><div class='inner-circle'><i style="cursor:pointer;" onclick="showDiscountTakeout();" class="fa fa-plus-circle"> </i></i></div></div></td>
									  <td style="text-align:right;" id="review-discount-takeout"> 0.00</td>
									</tr>
									<!-- <tr style="font-size:15pt; font-weight:bold;">									  
									  <td><strong>Discount</strong>: <div class='containerclass'><div onclick="this.classList.toggle('active'); discountTakeout();" id='toggle-id-takeout' class='toggle-btn'><div class='inner-circle'></div> </div></div></td>
									  <td style="text-align:right;" id="review-discount-takeout"> 0.00</td>
									</tr> -->
									<tr style="font-size:15pt; font-weight:bold;">
									  
									  <td><strong>Total</strong>: </td>
									  <td style="text-align:right;" id="takeout-total-price"> 0.00</td>
									</tr>									
									<tr style="font-size:15pt; font-weight:bold;">
									  
									  <td><strong>Change Due</strong>: </td>
									  <td style="text-align:right;" id="takeout-change"> 0.00</td>
									</tr>
								<!--	<tr style="font-size:15pt; font-weight:bold;">
									  
									  <td><strong>Change Due</strong>: </td>
									  <td style="text-align:right;" id="payment-change"> 0.00</td>
									</tr>
									<tr style="font-size:15pt; font-weight:bold;">
									  
									  <td><strong>Total</strong>: </td>
									  <td style="text-align:right;" id="takeout-total-price"> 0.00</td>
									</tr>
									<tr style="font-size:15pt; font-weight:bold;">
									  
									  <td><strong>Payment</strong>: </td>
									  <td style="text-align:right;" id="takeout-total-input"> 0.00</td>
									</tr>
									<tr style="font-size:15pt; font-weight:bold;">
									  
									  <td><strong>Change Due</strong>: </td>
									  <td style="text-align:right;" id="takeout-change"> 0.00</td>
									</tr>-->
								  </tfoot>
								</table>
							</div>
						</div>
						<div id="printTakeout-button" class="col-xs-12" style="position:absolute; bottom:80px; text-align:center; padding-top:25px;">
					
								<button type="button" value="" name="" onclick="printPaymentTakeoutReceipt(this.value);" id="takeout-print" class="quantity-plus btn-lg btn-danger btn-number">
									<i  class="fa fa-upload"></i><span>  Pay & Queue</span>
								</button>
						
						</div>
					</div>
				
            </div>
        </div>
		
	<div id="modal-review">
            
            <div class="modal-content" style="margin:15px 15px 0px 15px;">
				 
					<div class="col-xs-12 " style="position:relative; height:65px; background-color:#34454f; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px 3px 0px 3px;">						
						<h3 id='orders-label' style="color:#fff;">Order Details
						<button type="button" style="position:relative; top:-4px; border-radius:12pt; background-color:#f97a78; border-color:#f97a78; " class="close-modal-review btn btn-danger btn-number pull-right">
							CLOSE
						</button>
						<button onclick="cancelOrder(this.name);" name="" id="cancel-dine-in" type="button" style="position:relative; top:-4px; margin-right:15px; border-radius:12pt; " class="btn btn-default btn-number pull-right">
							<i  class="fa fa-ban" style="padding-right:1px;"></i> CANCEL ORDER
						</button>
				
						</h3>
					</div>

					<div class="col-sm-8" style="padding-top:10px; position:relative; height:565px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="row">	 
							<div class="col-lg-3 col-sm-6 col-xs-12">
					          <div class="small-box bg-aqua">
					            <div class="inner">
					              <h4 id='orders-label'><span style="font-size:18px; font-weight: bold;" id="review-orderno"></span></h4>

					              <p>Order Number</p>
					            </div>
					            <div class="icon">
					              <i class="ion ion-compose"></i>
					            </div>
					            <a class="small-box-footer"> <i style="visibility:hidden;" class="fa fa-arrow-circle-right"></i></a>
					          </div>
					        </div>
					        <div class="col-lg-3 col-sm-6 col-xs-12">
					          <div class="small-box bg-green">
					            <div class="inner">
					              <h4 id="sales-label"><span style="font-size:18px; font-weight: bold;" id="review-table-no"></span><sup style="font-size: 20px"></sup></h4>

					              <p>Table Number</p>
					            </div>
					            <div class="icon">
					              <i class="ion ion-ios-location"></i>
					            </div>
					            <a class="small-box-footer"> <i style="visibility:hidden;" class="fa fa-arrow-circle-right"></i></a>
					          </div>
					        </div>
					        <div class="col-lg-3 col-sm-6 col-xs-12">

					          <div class="small-box bg-yellow">
					            <div class="inner">
					              <h4 id="users-label"><span style="font-size:18px; font-weight: bold;" id="review-type"></span></h4>

					              <p>Order Type</p>
					            </div>
					            <div class="icon">
					              <i class="ion ion-ios-pricetags"></i>
					            </div>
					            <a class="small-box-footer"> <i style="visibility:hidden;" class="fa fa-arrow-circle-right"></i></a>
					          </div>
					        </div>

					        <div class="col-lg-3 col-sm-6 col-xs-12">

					          <div class="small-box bg-red">
					            <div class="inner">
					              <h4 style="font-size:18px; font-weight: bold;" id='review-hour'><?php date_default_timezone_set('Asia/Manila'); echo date("h:iA");?></h4>
					              <p id='review-date'><?php echo date("D, m/d/Y"); ?></p>
					            </div>
					            <div class="icon">
					              <i class="ion ion-ios-calendar"></i>
					            </div>
					            <a class="small-box-footer"> <i style="visibility:hidden;" class="fa fa-arrow-circle-right"></i></a>
					          </div>
					        </div>
							
					      </div>
						<!-- <div class="col-xs-4">
						<strong>Order No</strong>. <span id="review-orderno"></span>
						</div>
						<div class="col-xs-2 col-xs-offset-1">
							<i class="fa fa-calendar  fa-lg"> </i><span id="review-date">11/25/2017</span>
						</div>						
						<div class="col-xs-4">
						<strong>Order Type</strong>: <span id="review-type"></span>
						</div>
						<div class="col-xs-2 col-xs-offset-1">
						<strong>Table No</strong>. <span id="review-table-no"></span>
						</div>
						<div class="col-xs-3 col-xs-offset-2">
						</div> -->						
						<div class="col-xs-12" style="padding-top:25px;">
						  <div class="box box-primary table-responsive mousescroll" style="max-height: 363px;">				
								<table class="table table-bordered">
							
								  <thead>
									<tr>
									  <th>Food Name</th>
									  <th>Quantity</th>
									  <th>Price</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody id="review-table">																
									
								  </tbody>
								  
								</table>
						  </div>
						</div>						
						<div style="position: absolute; bottom:5px; right:35px; font-size:18px;">
							<strong>Total Amount</strong>: <span id="review-total-top"></span>
						</div>
						
					</div>
					<div class="col-sm-4" style="padding-top:10px; position:relative; height:565px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="has-feedback ">
						  <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtPayment" onkeyup="changeDineTotal(this.value);" onkeypress="return isNumber(event)" class="input-lg form-control" id="inputSuccess" placeholder="0">
						</div>
						<div class="col-xs-12" style="padding-top:15px;">
							<div class="table-responsive">
								<table class="table table-bordered">
								<tfoot>
									<tr style="font-size:15pt; font-weight:bold;">									  
									  <td><strong>Payment</strong>: </td>
									  <td style="text-align:right;" id="review-payment"> 0.00</td>
									</tr>
									<tr style="font-size:15pt; font-weight:bold;">									  
									  <td><strong>Discount</strong>: <div class='containerclass discount-button'><div class='inner-circle'><i style="cursor:pointer;" onclick="showDiscountModal();" class="fa fa-plus-circle"> </i></i></div></div></td>
									  <td style="text-align:right;" id="review-discount"> 0.00</td>
									</tr>
									<!-- <tr style="font-size:15pt; font-weight:bold;">									  
									  <td><strong>Discount</strong>: <div class='containerclass'><div onclick="this.classList.toggle('active'); discountOrder();" data-id="" id='toggle-id' class='toggle-btn'><div class='inner-circle'></div> </div></div></td>
									  <td style="text-align:right;" id="review-discount"> 0.00</td>
									</tr> -->
									<tr style="font-size:15pt; font-weight:bold;">
									  
									  <td><strong>Total</strong>: </td>
									  <td style="text-align:right;" id="review-total"> 0.00</td>
									</tr>									
									
									<tr style="font-size:15pt; font-weight:bold;">
									  
									  <td><strong>Change Due</strong>: </td>
									  <td style="text-align:right;" id="review-change"> 0.00</td>
									</tr>
								  </tfoot>
								</table>
							</div>
						</div>
						<div class="col-xs-12" id="pay-print-button" style="position:absolute; bottom:80px; text-align:center; padding-top:25px;">
						
								<!--<button onclick="printDinein(this.name);" id="print-dine-receipt" name="" type="button" class="quantity-plus btn-lg btn-default btn-number">
									<i  class="fa fa-print"></i><span>  Print Receipt</span>
								</button>-->
										
								<button type="button" value="" name="" onclick="printDineReceipt(this.name,this.value);" id="pay-print" class="quantity-plus btn-lg btn-danger btn-number">
									<i  class="fa fa-upload"></i><span>  Payment</span>
								</button>
						
						</div>
					</div>
					<div class="col-xs-6 text-right" style="padding-right:3px; padding-top:10px; position:relative; height:48px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<!--printDineReceipt(this.name,this.value);--><button type="button" value="" name="" onclick="addOrder(this.name);" id="addOrder" class="quantity-plus btn btn-md btn-default btn-number">
							<i  class="fa fa-plus"></i><span>  Add order(s)</span>
						</button>
					</div>
					<div id="finish-order-button" class="col-xs-6 text-left" style="padding-left:2px; padding-top:10px; position:relative; height:48px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<button type="button" value="" name="" onclick="finishOrder(this.name);" id="finish-order" class="quantity-plus btn btn-md btn-success btn-number">
							<i  class="fa fa-check"></i><span>  Finish order</span>
						</button>
					</div>
				
					</div>
				
            </div>
        </div>
		
		<div id="modal-review-takeout">
            <!--"THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID-->
            
            
            <div class="modal-content" style="margin:15px 15px 0px 15px;">
                <!--Your modal content goes here e9f0f5 width:90%; height:60px; -->
				 
					<div class="col-xs-12 " style="position:relative; height:65px; background-color:#34454f; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px 3px 0px 3px;">						
						<h3 id='orders-label' style="color:#fff;">Order Details
						
						<button type="button" style="position:relative; top:-4px; border-radius:12pt; background-color:#f97a78; border-color:#f97a78; " class="close-modal-review-takeout btn btn-danger btn-number pull-right">
							CLOSE
						</button>
						<button onclick="cancelOrder(this.name);" name="" id="cancel-queue-out" type="button" style="position:relative; top:-4px; margin-right:15px; border-radius:12pt; " class="btn btn-default btn-number pull-right">
							<i  class="fa fa-ban" style="padding-right:1px;"></i> CANCEL ORDER
						</button>
						</h3>
					</div>
					<div class="col-sm-8" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="col-xs-4">
						<strong>Order No</strong>. <span id="take-out-orderno"></span>
						</div>
						<div class="col-xs-2 col-xs-offset-1">
							<i class="fa fa-calendar  fa-lg"> </i><span id="take-out-date">11/25/2017</span>
						</div>
						<div class="col-xs-3 col-xs-offset-2">
						<strong>Total Amount</strong>: <span id="take-out-total-top">143.00</span>
						</div>
						<div class="col-xs-12" align="center" style="padding-top:15px;">
						<strong>Order Type</strong>: <span id="take-out-type"></span>
						</div>
						
						<div class="col-xs-12" style="padding-top:55px;">
						  <div class="table-responsive">
							<table class="table table-bordered">
							 <!-- <caption class="text-right">
									<a class="btn btn-default" id="buttonAdd">
										<i style="color:#ccc;" class="fa fa-chevron-left fa-1x"></i> 
									</a>
								<span>
								
								</span>
								<a class="btn btn-default" id="buttonAdd">
									<i style="color:#ccc;" class="fa fa-chevron-right fa-1x"></i> 
								</a>
							  </caption>--><!--<label style="position:relative; top:3px; font-size:16pt; padding:60px 4px 0px 4px;">1</label><label style="position:relative; top:3px; font-size:16pt; padding:60px 4px 0px 4px;">1</label>-->
							  <thead>
								<tr>
								  <th>Food Name</th>
								  <th>Quantity</th>
								  <th>Price</th>
								  <th>Total</th>
								</tr>
							  </thead>
							  <tbody id="take-out-table">																
								
							  </tbody>
							  
							</table>
						  </div>
						</div>
						
						
					</div>
					<div class="col-sm-4" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="has-feedback ">
						  <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="take-outPayment" onkeyup="changeTakeoutTotal(this.value);" onkeypress="return isNumber(event)" class="input-lg form-control" id="inputSuccess" placeholder="0">
						</div>
						<div class="col-xs-12" style="padding-top:15px;">
							<div class="table-responsive">
								<table class="table table-bordered">
								<tfoot>
									<tr style="font-size:15pt; font-weight:bold;">
									  <td><strong>Total</strong>: </td>
									  <td style="text-align:right;" id="take-out-total"> 0.00</td>
									</tr>
									<tr style="font-size:15pt; font-weight:bold;">
									  <td><strong>Payment</strong>: </td>
									  <td id="take-out-payment"> 0.00</td>
									</tr>
									<tr style="font-size:15pt; font-weight:bold;">
									  <td><strong>Change Due</strong>: </td>
									  <td id="take-out-change"> 0.00</td>
									</tr>
								  </tfoot>
								</table>
							</div>
						</div>
						<div class="col-xs-12" style="position:absolute; bottom:80px; text-align:center; padding-top:25px;">
						
								<button onclick="printTakeout(this.name);" id="print-out-receipt" name="" type="button" class="quantity-plus btn-lg btn-default btn-number">
									<i  class="fa fa-print"></i><span>  Print</span>
								</button>
						
					
								<button type="button" value="" name="" onclick="printOutReceipt(this.name,this.value);" id="pay-takeReceipt" class="quantity-plus btn-lg btn-danger btn-number">
									<i  class="fa fa-upload"></i><span>  Pay & Print</span>
								</button>
						
						</div>
					</div>
				
            </div>
        </div>
		
		<div id="modal-delivery">   
            
            <div class="modal-content" style="margin:15px 15px 0px 15px;">
                				 
					<div class="col-xs-8 col-xs-offset-2 " style="position:relative; height:65px; background-color:#34454f; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px 3px 0px 3px;">						
						<h3 id='orders-label' style="color:#fff;">Order Details
						<button type="button" style="position:relative; top:-4px; border-radius:12pt; background-color:#f97a78; border-color:#f97a78; " class="close-modal-delivery btn btn-danger btn-number pull-right">
							CLOSE
						</button>
						<button onclick="cancelOrder(this.name);" name="" id="cancel-queue-delivery" type="button" style="position:relative; top:-4px; margin-right:15px; border-radius:12pt; " class="btn btn-default btn-number pull-right">
							<i  class="fa fa-ban" style="padding-right:1px;"></i> CANCEL ORDER
						</button>
						</h3>
					</div>
					<div class="col-sm-8 col-xs-offset-2" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="col-xs-4">
						<strong>Order No</strong>. <span id="delivery-orderno"></span>
						</div>
						<div class="col-xs-3 col-xs-offset-1">
							<i class="fa fa-calendar  fa-lg"> </i><span id="delivery-date">11/25/2017</span>
						</div>
						<div class="col-xs-3 col-xs-offset-1">
						<strong>Order Type</strong>: <span id="delivery-type"></span>
						</div>
						<div style='padding-top:15px;' class="col-xs-4">
						<strong>Name</strong>. <span id="delivery-name"></span>
						</div>
						<div style='padding-top:15px;' class="col-xs-4">
						<strong>Address</strong>. <span id="delivery-address"></span>
						</div>
						<div style='padding-top:15px;' class="col-xs-4">
						<strong>Contact No</strong>. <span id="delivery-contact"></span>
						</div>
					
						
						<div class="col-xs-12" style="padding-top:25px;">
						  <div class="table-responsive">
							<table class="table table-bordered">
							  <caption class="text-right">
									<a class="btn btn-default" id="buttonAdd">
										<i style="color:#ccc;" class="fa fa-chevron-left fa-1x"></i> 
									</a>
								<span>
								
								</span>
								<a class="btn btn-default" id="buttonAdd">
									<i style="color:#ccc;" class="fa fa-chevron-right fa-1x"></i> 
								</a>
							  </caption>
							  <thead>
								<tr>
								  <th>Food Name</th>
								  <th>Quantity</th>
								  <th>Price</th>
								  <th>Total</th>
								</tr>
							  </thead>
							  <tbody id="delivery-table">																
								
							  </tbody>
							  <tfoot>
								<tr style="font-size:15pt; font-weight:bold;">
								  <td colspan="2"></td>
								  <td><strong>Total</strong>: </td>
								  <td id="delivery-total"> 0.00</td>
								</tr>								
								
							  </tfoot>
							</table>
						  </div>
						</div>
						
						<div class="col-xs-12" style="position:absolute; bottom:40px; text-align:center; padding-top:25px;">
						
								<!--<button type="button" class="quantity-plus btn btn-default btn-number">
									<i  class="fa fa-ban"></i><span>  Cancel Order</span>
								</button>-->
						
					
								<button onclick="printDelivery(this.name);" id="delivery-receipt" name="" type="button" class="quantity-plus btn-lg btn-danger btn-number"><!--onclick="printReceipt(this.name,this.value);"-->
									<i  class="fa fa-upload"></i><span>  Confirm</span>
								</button>
						
						</div>
					</div>
					
				
            </div>
        </div>
		
  <div class="control-sidebar-bg"></div>
  
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!--iziToast-->
<script src="js/jquery.hotkeys.js"></script>
<script src="js/animatedModal.js"></script>
<script>
function domo(){
jQuery('#platform-details').html('<code>' + navigator.userAgent + '</code>');
                
	var elements = [
		"Shift+D","Ctrl+D"
	];

	$.each(elements, function(i, e) {
		var newElement = ( /[\+]+/.test(elements[i]) ) ? elements[i].replace("+","_") : elements[i];                   
		$(document).bind('keydown', elements[i], function assets() {    
				
				changeCartValuesDel();
				
				
				return false;
			});
	});   
}
            
jQuery(document).ready(domo);

$("#typeModal").click(function(){
	$("#queue-tab").css({"display":"none"});
});
$("#print_review").animatedModal({
	modalTarget:'modal-review',
    animatedIn:'slideInUp',
    animatedOut:'slideOutDown',
    color:'#e9f0f5',              
});
$("#payment_review").animatedModal({
	modalTarget:'payment-review',
    animatedIn:'slideInUp',
    animatedOut:'slideOutDown',
    color:'#e9f0f5',              
});
$("#takeout_payment").animatedModal({
	modalTarget:'takeout-review',
    animatedIn:'slideInUp',
    animatedOut:'slideOutDown',
    color:'#e9f0f5',              
});
$("#takeout_review").animatedModal({
	modalTarget:'modal-review-takeout',
    animatedIn:'slideInUp',
    animatedOut:'slideOutDown',
    color:'#e9f0f5',              
});
$("#delivery_review").animatedModal({
	modalTarget:'modal-delivery',
    animatedIn:'slideInUp',
    animatedOut:'slideOutDown',
    color:'#e9f0f5',              
});
$.fn.extend({
    animateCss: function (animationName, callback) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
            if (callback) {
              callback();
            }
        });
        return this;
    }
});
$("#payButton").click(function(){
	$("#payModalAnimate").animateCss('flipInX');
	disableScrolling();
});
$("#typeButton").click(function(){
	$("#typeModalAnimate").animateCss('zoomIn');
	disableScrolling();
});
$("#payModalClose").click(function(){
	enableScrolling();
	/* $("#payModalAnimate").animateCss('fadeOutDown');
	setTimeout(function(){
		$('#payModal').modal('hide');
	}, 250); */

});
	$(document).ready(function(){
		
		$("#search-product").click(function(){
			$(this).select();
		});
		$('.quantity-plus').click(function(e){      
			e.preventDefault();
			var quantity = parseInt($('#quantity').val()); 
				if(quantity<10){
					$('#quantity').val(quantity + 1);
				}
				
		});
		
		 $('.quantity-minus').click(function(e){
			e.preventDefault();
			var quantity = parseInt($('#quantity').val());
				if(quantity>1){
					$('#quantity').val(quantity - 1);
				}
		});
		if($("#prod-name").text().length > 20){
			var food_text = $("#prod-name").text().slice(0,20);
			//alert($("#prod-name").value = food_text +"...");
			document.getElementById("prod-name").innerHTML =  food_text +"...";
		}
		
	});
</script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminJS.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
<script src="dist/js/demo.js"></script>
<!--sweet alert-->
<script>
  /* global $, swal, FileReader */

  $('.showcase.sweet button').on('click', () => {
    swal('Good job!', 'You clicked the button!', 'success')
  })

</script>
<script src="js/jquery.timers.js"> </script>
<script src="js/index-script.js"> </script>
<script src="js/script.js"> </script>
<script>

</script>
<?php
if(!isset($_SESSION['OrderType'])){
	echo '<script type="text/javascript">',
		    'hideTable();',


			'document.getElementById("queueDiv").classList.remove("hidden");',
			'document.getElementById("resetDiv").classList.remove("hidden");',
			'document.getElementById("divReset").classList.add("hidden");',
			'document.getElementById("paymentDiv").classList.remove("hidden");',
			'document.getElementById("reserveDiv").classList.add("hidden");',
			'document.getElementById("payment-takeout-div").classList.add("hidden");',
			'document.getElementById("addDiv").classList.add("hidden");',			
			'document.getElementById("type-label").innerHTML="Undefined";',
			'checkName();',
		 '</script>';

}
else{
		echo '<script type="text/javascript">',		  
			'checkName()',
		 '</script>';
		 
		if($_SESSION['OrderType']=="DineIn"){
			$type = "Dine in";
			echo '<script type="text/javascript">',
				 'newOrder("DineIn");',
				 '</script>';
		}
		else if($_SESSION['OrderType']=="TakeOut"){
			$type = "Take out";
			echo '<script type="text/javascript">',
				 'newOrder("TakeOut");',
				 '</script>';
			
		}
		else if($_SESSION['OrderType']=="Reserve"){
			$type = "Reservation";
			echo '<script type="text/javascript">',
				 'newOrder("Reserve");',
				 '</script>';
			
		}
		else if($_SESSION['OrderType']=="AddOrd"){
			$type = "Add order(s)";
			echo '<script type="text/javascript">',
				 'newOrder("AddOrd");',
				 '</script>';
		}
		else{
			$type = "Undefined";
			echo '<script type="text/javascript">',
				 'newOrder("");',
				 '</script>';
		}
		
}
	if(isset($_SESSION['OrderType'])){
		
	}
	else{
		$type = "Undefined";	
	}
?>
</body>
</html>
