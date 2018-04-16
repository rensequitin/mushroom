<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin</title>
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
  <link rel="stylesheet" href="css/admin-products-css.css">
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!--Sweet alert -->
  <script src="dist/sweetalert2.all.min.js"></script>
  <!--iziToast-->
  <script src="iziToast-master/dist/js/iziToast.js"> </script>
  <!--ajax-->
  <script src="js/jquery.js"> </script> 
  <script src="js/jquery.timers.js"> </script>
  <script src="js/admin-script.js"> </script>    
  <script src="js/admin-tables-ajax.js"> </script>      

 
  <style>
  #addProductAnimate{
	  display:none;
  }
  #editProductAnimate{
	  display:none;
  }
  #modal-review{
	  display:none;
  }
  #data-table_wrapper > .row{
		margin:0px;	
	}
  
  </style>
</head>
<body class=".sw-active hold-transition skin-blue sidebar-mini fixed">
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

    <a href="index.php" class="logo">

      <span class="logo-mini"><i class="fa fa-laptop"></i></span>

      <span class="logo-lg"><i class="fa fa-laptop"></i> <b>Admin </b>Panel</span>
    </a>

    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown messages-menu">
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
          </li>
       
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $pic; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs">Lorenzo</span>
            </a>
            <ul class="dropdown-menu">

              <li class="user-header">
                <img src="<?php echo $pic; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $name." ".$LName;?> - Administrator
                  <small>@<?php echo $user;?></small>
                </p>
              </li>
       
 
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

          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <aside class="main-sidebar">

    <section class="sidebar">

      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $pic; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $name." ".$LName;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
		<li>
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
      
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-cutlery"></i> <span>Product</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li class="active"><a href="admin-products.php"><i class="fa fa-circle-o"></i> Products</a></li>
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
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bar-chart"></i> <span>Reports</span> 
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li><a href="admin-reports.php"><i class="fa fa-circle-o"></i> Sales </a></li>
			<li><a href="admin-summary.php"><i class="fa fa-circle-o"></i> Summary </a></li>
          </ul>
        </li>  
      </ul>
    </section>

  </aside>
  <aside>
  </aside>

  <div class="content-wrapper">

	<section class="content">
	<div class="row">	 
		<li style="display:none;"><a id="print_review" href="#modal-review">Review</a></li>	  
		<div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 id='orders-label'>0</h3>

              <p>Today's Total Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cart"></i>
            </div>
            <a href="admin-orders.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="sales-label">0<sup style="font-size: 20px"></sup></h3>

              <p>Today's Sales</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="admin-reports.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">

          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="users-label">0</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="admin-users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">

          <div class="small-box bg-red">
            <div class="inner">
              <h3 id='hour-label'><?php date_default_timezone_set('Asia/Manila'); echo date("h:iA");?></h3>
              <p id='date-label'><?php echo date("D, m/d/Y"); ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-calendar"></i>
            </div>
            <a class="small-box-footer"> <i style="visibility:hidden;" class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
		
      </div>
      <div class="row">
	  <div id="addProductAnimate" class="col-md-12">
          <div class="box box-primary" style="border-top-color:#fff; height:90px;">		
			<!--<div class="col-xs-5"> 
				<input id="food-category-input" class="form-control input-lg" style="box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); margin:10px 0 0 15px;" type="text" placeholder="Food Category"> 
			</div>
			<div class="col-xs-12">
				<label style="padding-left:25px; color:red; font-weight:normal;">This is important! </label><label style="font-weight:normal; padding-left:2px;"> e.g."allday", "sizzlingfor3", "student"</label>
			</div>-->
			<div class="col-xs-5"> 
				<input id="table-number-input" class="form-control input-lg" style="box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); margin:10px 0 0 15px;" type="text" placeholder="Table No.">
			</div>
			<div class="col-xs-5" style="margin-top:15px; padding-right:0px;"> 
				<button onclick="saveTable()" type="button" class="btn btn-info btn-number active">
					Save
				</button>		
				<button id="cancel-product"  type="button" class="btn btn-danger btn-number active">
					Cancel
				</button>
			</div>
			
		  </div>		
		</div>
		 <div id="editProductAnimate" class="col-md-12">		 
          <div class="box box-primary" style="border-top-color:#fff; height:80px;">		
		
			<div class="col-xs-5"> 
				<input id="food-name-value" class="form-control input-lg" style="box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); margin:10px 0 0 15px;" type="text" placeholder="Table Number">
			</div>
			<div class="col-xs-5" style="margin-top:15px; padding-right:0px;"> 
				<button id="update-product" value="" onclick="updateProduct(this.value);" type="button" class="btn btn-info btn-number active">
					Update
				</button>		
				<button id="cancel-edit" type="button" class="btn btn-danger btn-number active">
					Cancel
				</button>
			</div>
			
		  </div>		
		</div>
       <div class="col-xs-12">
          <div class="box">
            <div class="box-header" >
				<h3 class="box-title">Tables</h3>
				<button id="add-product" style="border-radius: 2em;" type="button" class="btn btn-info btn-number pull-right active">
					<i class="fa fa-plus-circle fa-lg" style="padding-right:5px;"></i>Add New Tables
				</button>
            </div>
            <!-- /.box-header -->
			 <div class="box-body">
			 <div class="table-responsive">
              <table id="data-table" class="table table-hover">
                <thead style="background-color:#e9f0f5;">
                <tr>                  
                  <th style="text-align:center;">Table Number</th>                  
                  <th style="text-align:center;">Status</th>
                  <th style="text-align:center;">Action</th>
                </tr>
                </thead>
                <tbody align="center" id="products-table-value">
                
                
                </tbody>
               
              </table>
			  <div id="spinner" style="position:relative; top:-150px;">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			  </div>
			  </div>
            </div>
            <!--<div class="box-body">
              <table id="data-table" class="table table-hover">
                <thead style="background-color:#e9f0f5;">
                <tr>                  
                  <th style="text-align:center;">Product Name</th>
                  <th style="text-align:center;">Product Estimated Price</th>
				  <th style="text-align:center;">Added Date</th>
                  <th style="text-align:center;">Status</th>
                  <th style="text-align:center;">Action</th>
                </tr>
                </thead>
                <tbody align="center" id="products-table-value">
            
                </tbody>
              </table>
            </div>-->
          </div>
		      <!--<tr>
                  <td>All Day Meals</td>
                  <td>120</td>
                  <td>November 20, 2017</td>
                  <td><span class="input-group-btn">
					<button style="border-top-left-radius: 2em; border-right:none; border-bottom-left-radius: 2em;" type="button" class="btn btn-info btn-number active">
						Active
					</button>
					<button style="border-top-right-radius: 2em; border-left:none; border-bottom-right-radius: 2em;" type="button" class="btn btn-danger btn-number">
						Inactive
					</button>
				</span></td>
                  <td><span class="input-group-btn">
					<button style="border-radius: 2em;" type="button" class="btn btn-info btn-number">
						<i class="fa fa-edit"></i>Edit
					</button>					
					<button style="border-radius: 2em; margin-left:5px;" type="button" class="btn btn-danger btn-number">
						<i class="fa fa-trash-o"> </i>Delete
					</button>
				</span></td>
                </tr>-->
        </div>
        </div>
      
    </section>
  </div>
  
  <footer class="main-footer">
   
    <strong>Copyright &copy; 2017 <a target="_new" href="../index.php">Mushroom Sisig Haus atbp</a>.</strong> All rights
    reserved.
  </footer>

  <aside class="control-sidebar control-sidebar-dark">
    <div class="tab-content">
		<div class="tab-pane" id="control-sidebar-home-tab">        
		</div>
	</div>
  </aside>

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
			<a id="" onclick="deleteProduct(this.id); return false;" class="del-product btn btn-danger active" href="#">
				<i class="fa fa-trash-o fa-lg"></i> Delete
			</a>			
        </div>
      </div>
    </div>
  </div>  
  

	<div id="modal-review">
   
            
            
            <div class="modal-content" style="background-color:pink; margin-top:15px;">
                
				 
					<div class="col-xs-8 col-xs-offset-2" style="position:relative; height:65px; background-color:#34454f; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px 3px 0px 3px;">						
						<h3 id='orders-label' style="color:#fff;">Order Details
						<button type="button" style="position:relative; top:-4px; border-radius:12pt; background-color:#f97a78; border-color:#f97a78; " class="close-modal-review btn btn-danger btn-number pull-right">
							CLOSE
						</button>
						</h3>
					</div>
					<div class="col-xs-8 col-xs-offset-2" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="col-xs-4">
						<strong>Order No</strong>. <span id="review-orderno"></span>
						</div>
						<div class="col-xs-2 col-xs-offset-1">
							<i class="fa fa-calendar  fa-lg"> </i><span id="review-date">11/25/2017</span>
						</div>
						<div class="col-xs-3 col-xs-offset-2">
						<strong>Total Amount</strong>: <span id="review-total-top">143.00</span>
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
							  <tbody id="review-table">																
								
							  </tbody>
							  <tfoot>
								<tr>
								  <td colspan="2"></td>
								  <td><strong>Total</strong>: </td>
								  <td id="review-total"> 400.00</td>
								</tr>
								<tr>
								  <td colspan="2"></td>
								  <td><strong>Payment</strong>: </td>
								  <td id="review-payment"> 500.00</td>
								</tr>
								<tr>
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
									<i  class="fa fa-upload"></i><span>  Accept</span>
								</button>
						
					
								<button type="button" value="1" name="" onclick="printReceipt(this.name,this.value);" id="accept-print" class="quantity-plus btn btn-danger btn-number">
									<i  class="fa fa-print"></i><span>  Accept & Print</span>
								</button>
						
						</div>
					</div>
				
            </div>
        </div>
		
  <div class="control-sidebar-bg"></div>
  
</div>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.js"></script>
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


</script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminJS.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
<script src="dist/js/demo.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>
<script src="js/script.js"> </script>
<!--sweet alert-->

</body>
</html>
