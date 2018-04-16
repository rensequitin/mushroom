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
  <link rel="stylesheet" href="dist/css/admin-index.css">  
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
  <script src="js/admin-pos-ajax.js"> </script>
  
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

#modal-review,#modal-review-takeout,#modal-delivery{
	display:none;
}

#id-available{
	display:none;
}
#id-notavailable{
	display:none;
}
#queue-tab{
	display:none;	
}

  </style>
</head>
<body class=".sw-active hold-transition skin-blue sidebar-mini sidebar-collapse fixed ">
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
				}	
		}


?>
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><i class="fa fa-laptop"></i></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><i class="fa fa-laptop"></i> <b>Admin </b>Panel</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-shopping-cart"></i>
              <span class="label label-success" id="label-message">0</span>
            </a>
           <ul class="dropdown-menu">
              <li class="header" id="header"></li>
              <li>
                <ul class="menu" id="menu">
                                    
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
       
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/avatar04.png" class="user-image" alt="User Image">
              <span class="hidden-xs">Lorenzo</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/avatar04.png" class="img-circle" alt="User Image">

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
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <section class="sidebar">

      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/avatar04.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $name." ".$LName;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
		<li class="active">
          <a href="index.php">
            <i class="fa fa-desktop"></i> <span>Point Of Sale</span>           
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-inbox"></i> <span>Orders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li><a href="admin-orders.php"><i class="fa fa-circle-o"></i> View Orders</a></li>
			<li><a href="admin-pending-orders.php"><i class="fa fa-circle-o"></i> Pending Orders</a></li>            
          </ul>
        </li>
      
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cutlery"></i> <span>Product</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li><a href="admin-products.php"><i class="fa fa-circle-o"></i> Products</a></li>
			<li><a href="admin-foods.php"><i class="fa fa-circle-o"></i> Foods</a></li>           
          </ul>
        </li>
		        
        <li>
          <a href="admin-employees.php">
            <i class="fa fa-users"></i>
            <span>Employees</span>            
          </a>
        </li>
        <li>
          <a href="admin-users.php">
            <i class="fa fa-user-plus"></i> <span>Users</span>           
          </a>
        </li>
        <li>
          <a href="admin-reports.php">
            <i class="fa fa-bar-chart"></i> <span>Reports/Sales</span>           
          </a>
        </li>      
      </ul>
    </section>

  </aside>
  <aside>
  </aside>

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
		
		<div id="queue-tab" class="col-lg-4 col-sm-7 col-xs-12 col-lg-offset-8 col-sm-offset-5">
		<div class="small-box bg-white" style="margin-bottom:0px; border-radius:0%;padding:0; background-color: #FDFDFD; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px; height:48px;">          			
			<div style="padding-left:3px;display:block; padding-right:0px;" class="box-tools col-xs-12">
				<div>
					<div style="padding-left:0px;" class="box-tools col-xs-8">
						<div class="has-feedback ">
							<input onkeyup="searchQueue(this.value)" id="search-queue" type="text" class="form-control input-lg" placeholder="Search by order no.">
							<span class="glyphicon glyphicon-search form-control-feedback"></span>
						</div>
					</div>
				
				</div>
				<button id="close-queue" style="margin:1px;" type="button" class="btn btn-lg btn-danger pull-right">
					<i  class="fa fa-times-circle" style="margin-right:5px;"></i>Close
				</button>
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
	if(isset($_SESSION['POSCart'])){
		$items = 0;
		foreach ($_SESSION['POSCart'] as $cart => $cartItems) {
			$items += $cartItems;
		}	
	}
	else{
		$items = 0;
	}

	if(isset($_SESSION['OrderType'])){
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
	else{
		$type = "Undefined";		
	}
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
				  <a style='font-size:16pt; text-align:left; text-indent:5px;' class="btn btn-primary col-xs-12 input-lg" data-toggle="dropdown" href="#"><i class="fa fa-user fa-bookmark"></i> <span id="products-info" value=''></span><span class="pull-right fa fa-caret-down" title="Toggle dropdown menu"></span></a>
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
				<button onclick='viewQueue();' style="margin:1px;" type="button" class="quantity-minus btn btn-lg btn-primary pull-right">
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
				<div id="id-notavailable" >
					<label>Table No.</label>
					<div class="btn-group" style="padding-top:1.2px;">
					  <a style='font-size:16pt; text-align:left; text-indent:5px;' class="btn btn-default col-xs-12 input-lg" data-toggle="dropdown" href="#"><span id="table-info-add" value=''></span><span style="position:relative; top:5px;" class="pull-right fa fa-caret-down" title="Toggle dropdown menu"></span></a>			
					  <ul class="dropdown-menu" id="dropdown-choice-add" style="font-size:18pt; left:-80px; max-height:290px; overflow-y:scroll;">			
											
					  </ul>
					</div>
					
				</div>
			</div>
		</div>
		<small id="cartAnimate" style="position:relative; top:17px; z-index:5; right:2px;" class="label pull-right bg-yellow"><span id="cartQuantity"><?php echo $items; ?></span></small>
          <!-- small box -->
          <div class="small-box bg-white" style="margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">
            <div class="inner">
              <h3 id='orders-label'>Cashier</h3>

              <p><?php date_default_timezone_set('Asia/Manila'); echo date("l, d M Y, h:i A");?></p>
			  <p style="color:#00add7; height:2px;">Order Type: <span id="type-label"><?php echo $type;?></span></p>
            </div>
            <div class="icon">
              <i class="fa fa-cart-arrow-down"></i>
            </div>
            
          </div>
		  
		  <div class="small-box bg-white mousescroll" style="margin-bottom:0px; border-radius:0%;padding:0; background-color: #FDFDFD; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px; height:335px;">          
            <!--<a href="admin-view-deliveries.php"style="padding:12px;" class="small-box-footer"><i class="fa fa-plus"></i> Walk in</a>-->
			<div class="table-responsive" style="overflow:hidden;">          
			  <table class=" table-striped">
				
				<tbody id="table-foods">				
				  <!--<tr style="border-bottom:solid 1px #ccc;">
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
				  <h3 class="box-title pull-right" style="font-size:17.3pt;">Total Amount: &#8369; <span id="topay">0.00</span></h3>

				  
				  <!-- /.box-tools -->
				</div>
			</div>
			<div class="small-box bg-white" style="padding-top:-10px; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
				<div class="box-header with-border  col-xs-4 col-md-4" style="padding-top:0px; padding-right:0px; padding-left:0px;">				  
						<div class="small-box bg-white" align="right" style="border-radius:0%; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
							<div onclick="ask();" style="padding:8px; font-weight:bold; background-color:#c9ccd1; font-size:14pt; cursor:pointer;" class="small-box-footer"><i class="fa fa-ban"></i> CLEAR</div>
						</div>			
				</div>
				<div class="box-header with-border col-xs-4 col-md-4" style="padding-top:0px; padding-right:0px; padding-left:0px;">				  
						<div id="print-check" class="small-box bg-red" type="button" style="border-radius:0%; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
							<div onclick="print-checkReceipt();" style="padding:8.5px; cursor:pointer; font-weight:bold; font-size:14pt;" id="print-button" class="small-box-footer disabledbutton"><i class="fa fa-print"></i> PRINT</div>
						</div>			
				</div>
				<div class="box-header with-border col-xs-4 col-md-4" style="padding-top:0px; padding-right:0px; padding-left:0px;">				  
						<div id="checkout" class="small-box bg-aqua" type="button" style="border-radius:0%; margin-bottom:0px; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px;">          
							<div onclick="checkType();" style="padding:8.5px; cursor:pointer; font-weight:bold; font-size:14pt;" id="payButton" class="small-box-footer disabledbutton"><i class="fa fa-check"></i> CONFIRM</div> <!--onclick="printReceipt();"-->
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
   
    <strong>Copyright &copy; 2017 <a target="_new" href="../index.php">Mushroom Sisig Haus atbp</a>.</strong> All rights
    reserved.
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
			This action requires your confirmation. Please choose and option:
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
				<div onclick="newOrder('DineIn');" style="cursor:pointer; padding:25px; background-image:url('images/icon-dine-in.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Dine In</span></p>
				</div>
				<div onclick="newOrder('DineIn');" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Dine In</span></p>
				</div>
				<div onclick="newOrder('TakeOut');" style="cursor:pointer; padding:25px; background-image:url('images/icon-take-out.png'); background-repeat:no-repeat; background-size:120px 60px; background-position:130px center;" class="hidden-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Take Out</span></p>
				</div>	
				<div onclick="newOrder('TakeOut');" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				  <p class="box-title" style="text-align:center; font-size:17.3pt;">Take Out</span></p>
				</div>				
				<div onclick="newOrder('AddOrd');" style="cursor:pointer; padding:25px; background-image:url('images/icon-add-order.png'); background-repeat:no-repeat; background-size:130px 60px; background-position:120px center;" class="hidden-xs box-header with-border">
				   <p class="box-title" style="text-align:center; font-size:17.3pt;">Add Order(s)</span></p>
				</div>	
				<div onclick="newOrder('AddOrd');" style="cursor:pointer; padding:25px;" class="visible-xs box-header with-border">
				   <p class="box-title" style="text-align:center; font-size:17.3pt;">Add Order(s)</span></p>
				</div>
			</div>
        </div>
        <div class="modal-footer" style=" text-align:center;">		
			<a onclick="closeOrderType();" style='background-color:#737373; border-color:#737373;' class="btn btn-danger" href="#">
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
			This action requires your confirmation. Please choose and option:
        </div>
        <div class="modal-footer" style=" text-align:center;">		

			<a onclick="clearCart();" data-dismiss="modal" class="btn btn-danger" >
				<i class="fa fa-trash-o fa-lg"></i> Delete
			</a>			
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
  

	<div id="modal-review">
            <!--"THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID-->
            
            
            <div class="modal-content" style="margin:15px 15px 0px 15px;">
                <!--Your modal content goes here e9f0f5 width:90%; height:60px; -->
				 
					<div class="col-xs-12 " style="position:relative; height:65px; background-color:#34454f; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px 3px 0px 3px;">						
						<h3 id='orders-label' style="color:#fff;">Order Details
						<button type="button" style="position:relative; top:-4px; border-radius:12pt; background-color:#f97a78; border-color:#f97a78; " class="close-modal-review btn btn-danger btn-number pull-right">
							CLOSE
						</button>
						</h3>
					</div>
					<div class="col-sm-8" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="col-xs-4">
						<strong>Order No</strong>. <span id="review-orderno"></span>
						</div>
						<div class="col-xs-2 col-xs-offset-1">
							<i class="fa fa-calendar  fa-lg"> </i><span id="review-date">11/25/2017</span>
						</div>
						<div class="col-xs-3 col-xs-offset-2">
						<strong>Total Amount</strong>: <span id="review-total-top">143.00</span>
						</div>
						<div class="col-xs-4">
						<strong>Order Type</strong>: <span id="review-type"></span>
						</div>
						<div class="col-xs-2 col-xs-offset-1">
						<strong>Table No</strong>. <span id="review-table-no"></span>
						</div>
						<div class="col-xs-3 col-xs-offset-2">
						</div>
						
						<div class="col-xs-12" style="padding-top:15px;">
						  <div class="table-responsive">
							<table class="table table-bordered">
							  <caption class="text-right">
									<a class="btn btn-default" id="buttonAdd">
										<i style="color:#ccc;" class="fa fa-chevron-left fa-1x"></i> 
									</a>
								<span>
								<!--<label style="position:relative; top:3px; font-size:16pt; padding:60px 4px 0px 4px;">1</label><label style="position:relative; top:3px; font-size:16pt; padding:60px 4px 0px 4px;">1</label>-->
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
							  <tbody id="review-table">																
								
							  </tbody>
							  <tfoot>
								<tr style="font-size:15pt; font-weight:bold;">
								  <td colspan="2"></td>
								  <td><strong>Total</strong>: </td>
								  <td id="review-total"> 0.00</td>
								</tr>
								<tr style="font-size:15pt; font-weight:bold;">
								  <td colspan="2"></td>
								  <td><strong>Payment</strong>: </td>
								  <td id="review-payment"> 0.00</td>
								</tr>
								<tr style="font-size:15pt; font-weight:bold;">
								  <td colspan="2"></td>
								  <td><strong>Change Due</strong>: </td>
								  <td id="review-change"> 0.00</td>
								</tr>
							  </tfoot>
							</table>
						  </div>
						</div>
						
						<div class="col-xs-12" style="position:absolute; bottom:40px; text-align:center; padding-top:25px;">
						
								<button type="button" class="quantity-plus btn btn-default btn-number">
									<i  class="fa fa-print"></i><span>  Print</span>
								</button>
						
					
								<button type="button" value="1" name="" onclick="printReceipt(this.name,this.value);" id="accept-print" class="quantity-plus btn btn-danger btn-number">
									<i  class="fa fa-upload"></i><span>  Pay & Print</span>
								</button>
						
						</div>
					</div>
					<div class="col-sm-4" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="has-feedback ">
						  <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtPayment" onkeypress="return isNumber(event)" class="input-lg form-control" id="inputSuccess" placeholder="0">
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
						
						<div class="col-xs-12" style="padding-top:15px;">
						  <div class="table-responsive">
							<table class="table table-bordered">
							  <caption class="text-right">
									<a class="btn btn-default" id="buttonAdd">
										<i style="color:#ccc;" class="fa fa-chevron-left fa-1x"></i> 
									</a>
								<span>
								<!--<label style="position:relative; top:3px; font-size:16pt; padding:60px 4px 0px 4px;">1</label><label style="position:relative; top:3px; font-size:16pt; padding:60px 4px 0px 4px;">1</label>-->
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
							  <tbody id="take-out-table">																
								
							  </tbody>
							  <tfoot>
								<tr style="font-size:15pt; font-weight:bold;">
								  <td colspan="2"></td>
								  <td><strong>Total</strong>: </td>
								  <td id="take-out-total"> 0.00</td>
								</tr>
								<tr style="font-size:15pt; font-weight:bold;">
								  <td colspan="2"></td>
								  <td><strong>Payment</strong>: </td>
								  <td id="take-out-payment"> 0.00</td>
								</tr>
								<tr style="font-size:15pt; font-weight:bold;">
								  <td colspan="2"></td>
								  <td><strong>Change Due</strong>: </td>
								  <td id="take-out-change"> 0.00</td>
								</tr>
							  </tfoot>
							</table>
						  </div>
						</div>
						
						<div class="col-xs-12" style="position:absolute; bottom:40px; text-align:center; padding-top:25px;">
						
								<button type="button" class="quantity-plus btn btn-default btn-number">
									<i  class="fa fa-print"></i><span>  Print</span>
								</button>
						
					
								<button type="button" value="1" name="" onclick="printReceipt(this.name,this.value);" id="accept-print" class="quantity-plus btn btn-danger btn-number">
									<i  class="fa fa-upload"></i><span>  Pay & Print</span>
								</button>
						
						</div>
					</div>
					<div class="col-sm-4" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="has-feedback ">
						  <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="take-outPayment" onkeypress="return isNumber(event)" class="input-lg form-control" id="inputSuccess" placeholder="0">
						</div>
					</div>
				
            </div>
        </div>
		
		<div id="modal-delivery">   
            
            <div class="modal-content" style="margin:15px 15px 0px 15px;">
                				 
					<div class="col-xs-12 " style="position:relative; height:65px; background-color:#34454f; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px 3px 0px 3px;">						
						<h3 id='orders-label' style="color:#fff;">Order Details
						<button type="button" style="position:relative; top:-4px; border-radius:12pt; background-color:#f97a78; border-color:#f97a78; " class="close-modal-delivery btn btn-danger btn-number pull-right">
							CLOSE
						</button>
						</h3>
					</div>
					<div class="col-sm-8" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
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
								<tr>
								  <td colspan="2"></td>
								  <td><strong>Total</strong>: </td>
								  <td id="delivery-total"> 0.00</td>
								</tr>								
								  <td colspan="2"></td>
								  <td><strong>Payment</strong>: </td>
								  <td id="delivery-payment"> 0.00</td>
								</tr>
								<tr>
								  <td colspan="2"></td>
								  <td><strong>Change Due</strong>: </td>
								  <td id="delivery-change"> 0.00</td>
								</tr>
							  </tfoot>
							</table>
						  </div>
						</div>
						
						<div class="col-xs-12" style="position:absolute; bottom:40px; text-align:center; padding-top:25px;">
						
								<button type="button" class="quantity-plus btn btn-default btn-number">
									<i  class="fa fa-ban"></i><span>  Cancel Order</span>
								</button>
						
					
								<button type="button" value="1" name="" id="accept-print" class="quantity-plus btn btn-danger btn-number"><!--onclick="printReceipt(this.name,this.value);"-->
									<i  class="fa fa-upload"></i><span>  Accept & Queue</span>
								</button>
						
						</div>
					</div>
					<div class="col-sm-4" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="has-feedback ">
						  <input type="text" style="text-align:right; padding:40px; font-size:25pt;" id="txtPayment" onkeypress="return isNumber(event)" class="input-lg form-control" id="inputSuccess" placeholder="0">
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
<script src="js/animatedModal.js"></script>
<script>
$("#print_review").animatedModal({
	modalTarget:'modal-review',
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
		 '</script>';
}
?>
</body>
</html>
