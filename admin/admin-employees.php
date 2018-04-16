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
  <!--<script src="js/admin-users-ajax.js"> </script>  -->
  <script src="js/add-employee.js"> </script>  
	 
  
  
  <!--<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
  <script src="js/jquery.validate-2.min.js"> </script>
  
  <script src="js/admin-employees-script.js" type="text/javascript"></script>-->
  <style>
  #addProductAnimate{
	  display:none;
  }
  #editProductAnimate{
	  display:none;
  }
  #modal-employee{
	  display:none;
  }
  label.error {
  padding-left: 0px;
  padding-top: 5px;
  width:24px;
  background: url(images/icon-warning.png) left center no-repeat;
  background-size:24px 24px;
  background-position:0 12;
/*   display: none !important; */
  display: inline-block;
  text-indent: -99999px;
  position:absolute;
}

label.valid {
  padding-left: 0px;
  padding-top: 10px;
  width:24px;
  background: url(images/valid.png) left center no-repeat;
  background-size:24px 24px;
  background-position:0 12;
  display: inline-block;
  text-indent: -99999px;
  position:absolute;
}

label.error,label.valid {
	visibility:hidden;
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
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo "../".$pic; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $name; ?></span>
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
		        
        <li class="active">
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
		
       <div class="col-xs-12">
          <div class="box">
            <div class="box-header" >
			
				<div class="col-xs-4">
					<select onchange="viewUsers()" class="form-control input-lg" style="box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); margin:10px 0 0 0px;" name="user_category" id="user_category">								
						<option value='All'>All</option>
						<option value='Active'>Active</option>
						<option value='Inactive'>Inactive</option>
					</select>						
				</div> 
				<a id="add-employee" style="border-radius: 2em;" type="button" class="btn btn-info btn-number pull-right active" href="#modal-employee"><i class="fa fa-plus-circle fa-lg" style="padding-right:5px;"></i>Add New Employee</a>
				
            </div>
            <div class="box-body">
			<div class="table-responsive">
              <table id="data-table" class="table table-hover">
                <thead style="background-color:#e9f0f5;">
                <tr>   
				  <th style="text-align:center;">Username</th>
                  <th style="text-align:center;">Full Name</th>
                  <th style="text-align:center;">Email</th>
				  <th style="text-align:center;">Contact No.</th>
				  <th style="text-align:center;">Status</th>
                  <th style="text-align:center;">Action</th>
                </tr>
                </thead>
                <tbody align="center" id="users-table">
            
                </tbody>
              </table>
			  <div id="spinner" style="position:relative; top:-150px;">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			  </div>
			  </div>
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

	<div data-backdrop="static" data-keyboard="false" id="changePass" class="modal fade" role="dialog">
	  <div class="login-box modal-dialog modal-sm">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" id="closeChange" class="close" onclick="closeChange();" data-dismiss="modal">&times;</button>
			<h4 class="modal-title pull-left">Change password</h4>
		  </div>
		  <div class="modal-body register-box-body">
		 	<form id="password-form">
			<div class="col-md-12"> 
				<!--<input type="password" class="form-control input-md" id="newpass" placeholder="New password" onfocus="this.placeholder=''" onblur="this.placeholder ='New password'"> -->
				<div class="form-group has-feedback" style="display:block;">
					<input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="New password">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
			</div>		
			<div class="col-md-12" style="margin-bottom: 2%;"> 
				<!--<input type="password" class="form-control input-md" id="conpass" placeholder="Confirm new password" onfocus="this.placeholder=''" onblur="this.placeholder ='Confirm new password'"> -->
				<div class="form-group has-feedback" style="display:block;">
					<input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm new password">
					<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
				</div>
			</div>
			</form>
		  </div>
		  <div class="modal-footer" style="text-align:center;">
			<button onclick="updatePassword();" name="" id="button-update" type="button" class="quantity-plus btn btn-primary btn-number">
				<i class="fa fa-save"></i><span> Update</span>
			</button>
			<!--  <button type="button" class="btn btn-primary btn-block">Update</button>-->
			
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
			<a id="" onclick="deleteFood(this.id);" class="del-product btn btn-danger active" href="#">
				<i class="fa fa-trash-o fa-lg"></i> Delete
			</a>			
        </div>
      </div>
    </div>
  </div>  
  

	<div id="modal-employee" style="padding:0px 45px 0px 45px;">   
            
            <div class="modal-content" style="margin-top:15px; background-color:pink; ">
                
				
			<div class="regForm-personal">	 
					<div class="col-xs-12 " style="position:relative; height:65px; background-color:#ececea; overflow:hidden;">						
						<h3 id='orders-label' style="color:#474747;">Add Employee
						<button type="button" style="position:relative; top:-4px; border-radius:4pt; color:#fff; background-color:#f97a78; border-color:#f97a78; " class="close-modal-employee btn btn-danger btn-number pull-right">
							Cancel
						</button>
						</h3>
					</div>
					
				<form id="reg-form" class='reg-form'>
					<div>		
					<div class="col-xs-12 " style="padding-top:10px; padding-left:0px; position:relative; height:535px; background-color:#fefefe; overflow:hidden; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26); border-radius: 0px 3px 3px 3px;">	
						<div class="col-xs-6">
						<strong>First Name</strong>*
						</div>
						<div class="col-xs-6">
						<strong>Last Name</strong>*
						</div>
						
						<div class="form-group col-xs-6" style="display:block;"> 
							<input id="firstname-input" autocomplete="off" name="inputFirstName" class="form-control input-lg" style="box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16); margin:5px 0 10px 0;" type="text"> 
						</div>
						<div class="form-group col-xs-6" style="display:block;"> 
							<input id="lastname-input" autocomplete="off" name="inputLastName" class="form-control input-lg" style="box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16); margin:5px 0 10px 0;" type="text"> 
						</div>
						
						<div class="col-xs-6">
						<strong>Email Address</strong>*
						</div>
						<div class="col-xs-6">
						<strong>Contact Number</strong>*
						</div>					
						
						<div class="form-group col-xs-6" style="display:block;"> 
							<input id="emailadd-input" autocomplete="off" class="form-control input-lg" style="box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16); margin:5px 0 20px 0;" type="text"> 
						</div>
						<div class="form-group col-xs-6" style="display:block;"> 
							<input id="contactno-input" autocomplete="off" class="form-control input-lg" style="box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16); margin:5px 0 20px 0;" type="text"> 
						</div>
						
						<div class="col-xs-12" align="center">
						<strong>Gender</strong>*
						</div>
						
						<div class="col-xs-6" align="right">
							<div class="radio">
							  <label><input id="radio" checked type="radio" name="rbtnGender">Male</label>
							</div>
						</div>
						<div class="col-xs-6" align="left">
							<div class="radio">
							  <label><input id="radio2" type="radio" name="rbtnGender">Female</label>
							</div>
						</div>
					
						<div class="col-xs-6">
						<strong>Username</strong>*
						</div>
						<div class="col-xs-6">
						<strong>Password</strong>*
						</div>					
						
						<div class="form-group col-xs-6" style="display:block;"> 
							<input id="username-input" onchange='generateUsername();' onfocus='generateUsername();' onkeyup='generateUsername();' autocomplete="off" class="form-control input-lg" style="box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16); margin:5px 0 20px 0;" type="text"> 
						</div>
						<div class="form-group col-xs-6" style="display:block;"> 
							<input type="text" value="123456" readonly autocomplete="off" id="password-input" class="form-control input-lg" style="box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16); margin:5px 0 20px 0;" type="text"> 
						</div>
						
						
						<div class="col-xs-12" style="position:absolute; bottom:120px; text-align:center; padding-top:25px;">
						
								<button onclick="saveEmployee();" type="button" class="quantity-plus btn btn-primary btn-number">
									<i class="fa fa-save"></i><span> Save</span>
								</button>									
						
						</div>
					</div>
					</div>
				</form>
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
<script src="js/animate-extend.js"></script>
<script>

$("#add-employee").animatedModal({
	modalTarget:'modal-employee',
    animatedIn:'slideInUp',
    animatedOut:'slideOutDown',
    color:'#ececea',              
});
$("#add-employee").click(function(){$("#modal-employee").css({"display":"block"})});

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

<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="js/jquery.validate-2.min.js"> </script>
<script src="js/admin-employees-script.js" type="text/javascript"></script>
<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="js/jquery.validate.min.js"> </script>
<script src="js/admin-employees-script2.js" type="text/javascript"></script>
<!--sweet alert-->

</body>
</html>
