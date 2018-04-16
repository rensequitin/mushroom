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
  <!--iziToast-->
  <script src="iziToast-master/dist/js/iziToast.js"> </script>
  <!--ajax-->
  <script src="js/jquery.js"> </script> 
  <script src="js/jquery.timers.js"> </script>
  <script src="js/admin-backup-restore.js"> </script>
  <!--<script src="js/admin-script.js"> </script> -->
  <!--<script src="js/admin-reports.js"> </script>-->
  <!-- <script src="js/admin-script.js"> </script> -->
  
 
  <style>
	#modal-orders,#modal-dinein{
		display:none;
	}
	.zoomIn { 
		-webkit-animation-name: zoomIn;
		animation-name: zoomIn;
		-webkit-animation-duration: .5s;
		animation-duration: .5s;
	}
	.modal-open {
		overflow-y: scroll;
	}
	div.mousescroll { overflow-y: auto; }
	.mousescroll::-webkit-scrollbar { width: 4px; }
	.mousescroll::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
		border-radius: 10px;
	}
	.mousescroll::-webkit-scrollbar-thumb {
		border-radius: 10px;
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
	}
	#data-table_wrapper > .row{
		margin:0px;	
	}
	
  </style>
</head>
<body class=".sw-active hold-transition skin-blue sidebar-mini fixed">
<?php
//	require_once("php/class.database.php");

	//$db = MushroomDB::getInstance();
	//$db->checkOnline();
	//$name = "";
	/* $admin = $_SESSION['Admin'];
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
		} */

?>
<?php
 function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 1) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 1) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 1) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
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
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

 <aside class="main-sidebar">

    <section class="sidebar">

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
	<!--<div class="row">	 
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
		
      </div>-->
	  
	  <section class="content-header">
		  <h1 style="visibility:hidden;">
			Admin
			<small>Profile</small>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Backup & Restore</li>
		  </ol>
		</section>
		
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
             
			<h3 style="margin-top:0px;"align="center"><i class="fa fa-hdd-o"></i> Backup & Restore</h3>
              
            </div>            
            <div class="box-body" style="padding-top:-20px;">	
				<form id="form-data" enctype='multipart/form-data'>
					<a href="save.php" type="button" class="btn btn-sm btn-primary">
						<i class="fa fa-file-text-o fa-lg" style="padding-right:2px;"></i> Backup latest database
					</a>
					<input style="display:none;" id="upload-file" name='myfile' type="file" />
					<a id='file-attach' type="button" class="btn btn-sm btn-default">
						<i class="fa fa-plus-circle fa-lg" style="padding-right:2px;"></i> Add file
					</a>	
					
				</form>
				<button style="display:none;" id="add-button" onclick="uploadDatabase('form-data');">
			</div>			
									 
              <div class="table-responsive">
                <table id="data-table" class="table table-hover table-striped" >
				  <thead style="background-color:#e9f0f5;">
					<tr>
						<th class="col-xs-2" style="text-align:left;"><b>Date - (Last Modified)</b></th>
						<th class="col-xs-4" style="text-align:left;"><b>Time</b></th>
						<th style="text-align:right;"><b>File size</b></th>
						<th style="text-align:left;"><b>Action</b> </th>					
					 </tr>
				  </thead>
				  <tbody id="database-table" >
						<?php 
							$ctr = 1;
							$table = "table.$ctr";
							foreach ($files as $file) {
							$table = "table$ctr";
							$size = formatSizeUnits(filesize("files/$file"));											
						?>
							<tr>
							<td  style="text-align:left;"><?php date_default_timezone_set('Asia/Manila'); echo date ("F d Y", filemtime("files/$file")); ?></td>
							<td  style="text-align:left;"><?php date_default_timezone_set('Asia/Manila'); echo date ("h:i A", filemtime("files/$file")); ?></td>
							<td style="text-align:right;"><?php echo $size;?></td>
							<td style="text-align:left;">
								<form id="<?php echo $table; ?>"  class="pull-left" method="post"><!--action="<?php //echo $url; ?>"//-->															 
									<button onclick="uploadToFolderCloud('<?php echo $file; ?>');" value="Send to Google Drive" name="submit" class="btn btn-sm btn-info"> <!--type="submit"-->
										<i class="fa fa-send fa-lg" style="padding-right:2px;"></i> Send to Google Drive
									</button>											
								</form>
								<a onclick="uploadToFolderRestore('<?php echo $file; ?>');" type="button" style="margin-left:2px;" class="btn btn-sm btn-warning pull-left"> <!--href="import.php"-->
									<i class="fa fa-recycle fa-lg" style="padding-right:2px;"></i> Restore
								</a>
								<a download style="margin-left:2px;" href="<?php echo "files/$file";?>" type="button" class="btn btn-sm btn-success pull-left">
									<i class="fa fa-cloud-download fa-lg" style="padding-right:2px;"></i> Download
								</a>
								<a onclick="deleteFile('<?php echo $file; ?>');"  style="margin-left:2px;" type="button" class="btn btn-sm btn-danger pull-left">
									<i class="fa fa-trash-o fa-lg" style="padding-right:2px;"></i> Delete
								</a>
								
								
							</td>
							</tr>
						<?php $ctr++;} ?>
						
                  </tbody>
				  			
                </table>
				
              </div>   
				<table  class="table table-hover table-striped" >				 
                  </tbody>
				  	<!--<tfoot>
						
						<tr style="font-size:15pt;">														
							
							<td style="padding-right:45px;" class="col-xs-8" align="right">
							<a download="sales" href="admin-sales.php" type="button" class="btn btn-danger">
								<i class="fa fa-file-pdf-o fa-lg" style="padding-right:2px;"></i> Download pdf
							</a>
							<a target="_new" href="admin-sales.php" type="button" class="btn btn-default">
								<i class="fa fa-eye fa-lg" style="padding-right:2px;"></i> View in pdf
							</a></td>
							<td class="col-xs-3" align="right"><strong>Total</strong>: </td>
							<td id="sales-total"> 0.00</td>
						</tr>
					</tfoot>-->	
                </table>			  
            </div>
         
          </div>
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
		<button onclick="archiveOrder(this.name);" name="" id='archive-button' type="button" class="btn btn-danger">
			<i class="fa fa-trash-o fa-lg"></i> Delete
		</button>
				
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" data-backdrop="static" data-keyboard="false" style="padding-top:100px;"id="delModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" id="delModalAnimate" style="border-radius:3pt;">
        <div class="modal-header" style="background-color:#e66454;color:#fff;" align="center">
          <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
		  <i class="fa fa-warning fa-2x"></i>
          <h3 id='orders-label'  class="modal-title"> Alert</h3>
        </div>
		
        <div class="modal-body" style="text-align:center;">
			This action requires your confirmation. Please choose an option:
        </div>
        <div class="modal-footer" style=" text-align:center;">	
			<button type="button" data-dismiss="modal" class="btn btn-default">
				<i class="fa fa-ban fa-lg"></i> Cancel
			</button>		
			<button type="button" onclick="confirmDeleteFile(this.name);" name="" id="confirmDel" data-dismiss="modal" class="btn btn-danger">
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
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
 
					
					$(function () {
						$('#data-table').DataTable({
						  'retrieve'	: true,		//hello			  
						  'paging'  	: true,					  
						  'lengthChange': false,
						  'searching'   : true,
						  'ordering'    : true,
						  'info'        : true,
						  'autoWidth'   : true,
						  "pageLength"	: 5,
						  "columnDefs"	: [{ "targets": [1,2,3], "searchable": false }],
						  "order": [[ 0, "desc" ],[1,"desc"]], 						  
						  "sDom": "<'row'<'col-xs-5 col-sm-6'l><'col-xs-7 col-sm-6 text-right'f>r>t<'row'<'col-xs-3 col-sm-4 col-md-5'i><'col-xs-9 col-sm-8 col-md-7 text-right'p>>",
						})
					  })
</script>
<!-- Bootstrap 3.3.7 -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminJS.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
<script src="dist/js/demo.js"></script>

<!--sweet alert-->

</body>
</html>