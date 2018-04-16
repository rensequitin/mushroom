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
    <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!--Sweet alert -->
  <script src="dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="css/admin-profile-css.css">
  <!--iziToast-->
  <script src="iziToast-master/dist/js/iziToast.js"> </script>
  <!--ajax-->
  <script src="js/jquery.js"> </script> 
  <script src="js/jquery.timers.js"> </script>
  <script src="js/admin-script.js"> </script>  
  <script src="js/admin-profile-ajax.js"> </script>
  <!-- <script src="js/admin-script.js"> </script> -->
  
 
  <style>

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
					$email = $row['admin_email'];
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
              <img src="<?php echo "../".$pic; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $name;?></span>
            </a>
            <ul class="dropdown-menu">

              <li class="user-header">
                <img src="<?php echo "../".$pic; ?>" class="img-circle" alt="User Image">

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
          <img src="<?php echo "../".$pic; ?>" class="img-circle" alt="User Image">
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
			<li><a href="admin-pending-orders.php"><i class="fa fa-circle-o"></i> Pending Deliveries</a></li>            
			<li><a href="admin-reservation.php"><i class="fa fa-circle-o"></i> Reservations</a></li>
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
		<li style="display:none;"><a id="show_orders" href="#modal-orders">Review</a></li>
		<li style="display:none;"><a id="show_dinein" href="#modal-dinein">Review</a></li>		
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
        <div class="col-md-12">
        <div class="col-md-4">
          <div class="box box-default">
            <div class="box-header with-border">           
				<h3 class="text-center"><i class="fa fa-user-circle-o">&emsp;Profile Picture</i></h3>
				<hr>
				<img src="<?php echo "../".$pic; ?>" style="height:208px; width:200px;" class="dp img-thumbnail center-block">
				<button onclick="changePic();" class="btn btn-primary center-block">Change picture</button>
            </div>             
          </div>  
        </div>        
		<div class="col-md-8">
          <div class="box box-default">
            <div class="box-header with-border"> 
			<button class="btn btn-secondary pull-right" id="changepw" data-toggle="modal" data-target="#changePW">change password</button>
			<h3 class="text-center">My Account</i></h3>
             <hr>     
			<p><strong>Personal Information</strong></p>			
 			<div class="col-md-12"> 
				<input type="text" class="form-control input-md" id="FirstName" onclick='this.select();' value='<?php echo $name; ?>' placeholder="First name" onfocus="this.placeholder=''" onblur="this.placeholder ='First name'"> 
			</div> 	
			<div class="col-md-12"> 
				<input type="text" class="form-control input-md" id="LastName" onclick='this.select();' value='<?php echo $LName; ?>' placeholder="Last name" onfocus="this.placeholder=''" onblur="this.placeholder ='Last name'"> 
			</div>		
			<div class="col-md-12"> 
				<input type="email" class="form-control input-md" id="EmailAddress" onclick='this.select();' value='<?php echo $email; ?>' placeholder="Email" onfocus="this.placeholder=''" onblur="this.placeholder ='Email'"> 
			</div>			
			<div class="col-md-12"> 
				<input type="text" class="form-control input-md" id="Username" onclick='this.select();' value='<?php echo $user; ?>' placeholder="Username" onfocus="this.placeholder=''" onblur="this.placeholder ='Username'"> 
			</div>
			<button class="btn btn-success pull-right" onclick="updateProfile();"><i class="fa fa-save"></i> Update</button>
            </div> 
          </div>  
        </div>
        </div>
      </div>
    </section>
	<!-- Modal for change password-->
	<div id="changePW" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title pull-left">Change password</h4>
		  </div>
		  <div class="modal-body">
		 	<div class="col-md-12"> 
				<input type="password" class="form-control input-md" id="currentpass" placeholder="Current password" onfocus="this.placeholder=''" onblur="this.placeholder ='Current password'"> 
			</div>		
			<div class="col-md-12"> 
				<input type="password" class="form-control input-md" id="newpass" placeholder="New password" onfocus="this.placeholder=''" onblur="this.placeholder ='New password'"> 
			</div>		
			<div class="col-md-12" style="margin-bottom: 2%;"> 
				<input type="password" class="form-control input-md" id="conpass" placeholder="Confirm new password" onfocus="this.placeholder=''" onblur="this.placeholder ='Confirm new password'"> 
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" onclick="savePass();" class="btn btn-success btn-block">Save</button>
		  </div>
		</div>
	  </div>
	</div>
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
  
  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="editphoto" role="dialog">				
		<div class="modal-dialog modal-sm">		
			<div class="modal-content" id="editphotoanimate" style="border-radius:3pt;">
				<div class="modal-header" align="center">
					<button type="button" class="close" onclick='closeEditPhoto();'>&times;</button>
					
				</div>
				<div class="modal-body" style="text-align:center;">
					Once you update your photo,
					your current photo will be replaced.
					<div class="imageInput">
						<form id="form-data" enctype='multipart/form-data'>
							<input style="display:none;" id="upload-file" name='myfile' type="file" />
							<div class="col-xs-12">
								<input type="text" class="form-control input-md" id='file-label' readonly placeholder="NO FILES">
							</div>
							<img id="file-delete" src="images/icon-delete.png" width="30" height="28">
							<img id="file-attach" src="images/icon-attach.png" width="30" height="28">													
							<!--<input type="file" name="pic" id="imageUpload" style="display: none;">-->
							<label>File type: jpg, png</label>
						</form>
					</div>
				</div>
				<div class="modal-footer" style=" text-align:center;">	
					<button id="edit-button-value" onclick="uploadPic('form-data');" class="btn btn-success"><i style="padding-right:3px;" class="fa fa-floppy-o"></i>UPDATE</button>
				</div>
			</div>
		</div>
	</div>
	
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
		<button onclick="archiveOrder(this.name);" name="" id='archive-button' type="button" class="btn btn-danger">
			<i class="fa fa-trash-o fa-lg"></i> Delete
		</button>
				
        </div>
      </div>
    </div>
  </div>
	
  

	<div id="modal-orders">   
            
            <div class="modal-content" style="background-color:pink; margin-top:15px;">
                
				 
					<div class="col-xs-8 col-xs-offset-2" style="position:relative; height:65px; background-color:#34454f; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px 3px 0px 3px;">						
						<h3 id='orders-label' style="color:#fff;">Order Details
						<button type="button" style="position:relative; top:-4px; border-radius:12pt; background-color:#f97a78; border-color:#f97a78; " class="close-modal-orders btn btn-danger btn-number pull-right">
							CLOSE
						</button>
						</h3>
					</div>
					<div class="col-xs-8 col-xs-offset-2" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="col-xs-4">
						<strong>Order No</strong>. <span id="review-orderno"></span>
						</div>
						<div class="col-xs-3 col-xs-offset-1">
							<i class="fa fa-calendar  fa-lg"> </i><span id="review-date">11/25/2017</span>
						</div>
						<div class="col-xs-3 col-xs-offset-1">
						<strong>Order Type</strong>: <span id="review-type"></span>
						</div>
						<div style='padding-top:15px;' class="col-xs-4">
						<strong>Name</strong>. <span id="review-name"></span>
						</div>
						<div style='padding-top:15px;' class="col-xs-4">
						<strong>Address</strong>. <span id="review-address"></span>
						</div>
						<div style='padding-top:15px;' class="col-xs-4">
						<strong>Contact No</strong>. <span id="review-contact"></span>
						</div>
					
						
						<div class="col-xs-12" style="padding-top:65px;">
						  <div class="table-responsive">
							<table class="table table-bordered">
							  <!--<caption class="text-right">
									<a class="btn btn-default" id="buttonAdd">
										<i style="color:#ccc;" class="fa fa-chevron-left fa-1x"></i> 
									</a>
								<span>
								
								</span>
								<a class="btn btn-default" id="buttonAdd">
									<i style="color:#ccc;" class="fa fa-chevron-right fa-1x"></i> 
								</a>
							  </caption>-->
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
								  <td id="review-total"> 0.00</td>
								</tr>
								<!--<tr>
								  <td colspan="2"></td>
								  <td><strong>Payment</strong>: </td>
								  <td id="review-payment"> 500.00</td>
								</tr>
								<tr>
								  <td colspan="2"></td>
								  <td><strong>Change Due</strong>: </td>
								  <td id="review-change"> 0.00</td>
								</tr>-->
							  </tfoot>
							</table>
						  </div>
						</div>
						
					
					</div>
				
            </div>
        </div>
		
		<div id="modal-dinein">   
            
            <div class="modal-content" style="background-color:pink; margin-top:15px;">
                
				 
					<div class="col-xs-8 col-xs-offset-2" style="position:relative; height:65px; background-color:#34454f; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 3px 3px 0px 3px;">						
						<h3 id='orders-label' style="color:#fff;">Order Details
						<button type="button" style="position:relative; top:-4px; border-radius:12pt; background-color:#f97a78; border-color:#f97a78; " class="close-modal-dinein btn btn-danger btn-number pull-right">
							CLOSE
						</button>
						</h3>
					</div>
					<div class="col-xs-8 col-xs-offset-2" style="padding-top:10px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="col-xs-4">
						<strong>Order No</strong>. <span id="dinein-orderno"></span>
						</div>
						<div class="col-xs-3 col-xs-offset-1">
							<i class="fa fa-calendar  fa-lg"> </i><span id="dinein-date">11/25/2017</span>
						</div>
						<div class="col-xs-3 col-xs-offset-1">
						<strong>Order Type</strong>: <span id="dinein-type"></span>
						</div>
						
						
						<div class="col-xs-12" style="padding-top:65px;">
						  <div class="table-responsive">
							<table class="table table-bordered">
		
							  <thead>
								<tr>
								  <th>Food Name</th>
								  <th>Quantity</th>
								  <th>Price</th>
								  <th>Total</th>
								</tr>
							  </thead>
							  <tbody id="dinein-table">																
								
							  </tbody>
							  <tfoot>
								<tr>
								  <td colspan="2"></td>
								  <td><strong>Total</strong>: </td>
								  <td id="dinein-total"> 0.00</td>
								</tr>						
							  </tfoot>
							</table>
						  </div>
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

<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>


<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!--iziToast-->
<script src="js/animatedModal.js"></script>
<script>
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
$("#show_orders").animatedModal({
	modalTarget:'modal-orders',
    animatedIn:'slideInUp',
    animatedOut:'slideOutDown',
    color:'#e9f0f5',              
});
$("#show_dinein").animatedModal({
	modalTarget:'modal-dinein',
    animatedIn:'slideInUp',
    animatedOut:'slideOutDown',
    color:'#e9f0f5',              
});

$(function () {
    //Initialize Select2 Elements
    //$('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

       
  })


 /* $(document).ready(function(){
	$('#date-range').on('DOMSubtreeModified',function(){
	  alert($(this).html());
	}) 
 }); */
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

</body>
</html>
