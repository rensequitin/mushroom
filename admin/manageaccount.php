<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width = device-width, initial-scale = 1">
<title>Mushroom Sisig</title>

<link href='fonts/fonts.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" rev="stylesheet" type="text/css" href="manageaccount-css.css">
<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"> </script>
<script src="js/main-script.js"> </script>
<script src="js/manageaccount-script.js"> </script>
<script src="js/index-ajax.js"> </script>
 
<style>

</style>
</head>
<body>

<?php
	require_once('php/class.database.php');
	$db = MushroomDB::getInstance();
?>

<div id="carousel-id" class="carousel-inner"> 

	<div class="header navbar-fixed-top" style="z-index:2;">	
	
		<div class="container navbar-fixed-top" style="height:110px;">
			<img src="images/header_banner.png" id="banner" width="200" class="visible-lg visible-md visible-sm img-responsive pull-left">						
			<div class="container navbar-fixed-top" id="login_register">
				<div class="horizontal">
					<div class="form-group" id="form-group">
						<div class="col-md-2 col-lg-2 col-s-2 col-xs-2">										
						<input type="text" id="username" autocomplete="off"  placeholder="username"  onkeypress="handleKeyPress(event);" onfocus="this.placeholder = ''" onblur="this.placeholder = 'username'" class="form-control" /><br>
						<input type="password" id="password" autocomplete="off" placeholder="password" onkeypress="handleKeyPress(event);" onfocus="this.placeholder = ''" onblur="this.placeholder = 'password'" class="form-control" />	
						</div>
						<div class="form-group"> 
						<div class="col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1">
							<button type="submit" id="btn_login">LOGIN</button>
						</div>
						</div>
					</div>
				</div>
			</div> 	
<?php
	
	if (isset($_SESSION['User'])){
		$user = $_SESSION['User'];
		$sql = "Select * from mushroom_users where user_username = '$user'";
		$exist = $db->checkExist($sql) or die(mysql_error());
		$check = $db->get_rows($exist);
			if($check){
				$row = $db->fetch_array($exist);
				$pic = $row['user_picture'];
			}
	}
	else{
		$pic = "profile/user.png";
	}

?>
			<div class="container navbar-fixed-top" id="account">								
					<img id="user_photo" style = "height:80px; border-radius:40px; width: 80px;" src = "<?php echo $pic;?>"/>
					<a id="manage_account" style = "left: 30px;" href = "#">View Profile</a>
					<a id="logout_account" style = "position:relative; left: -30px;top: 50px;" href = "php/logout.php">Logout</a>
				</div> 	

			<div id="banner-clickdiv2" class="container navbar-fixed-top" style="position:relative; display:none; margin:0;left:5px; width:220px; top:0px; height:40px;" >					
				<img src="images/manage_account_banner.png" id="banner-click2" width="168" class="visible-lg visible-md visible-sm img-responsive pull-left" style="position:relative; top:-200px; left:10px;" >	
			</div>
			<div id="banner-clickdiv" class="container navbar-fixed-top" style="position:relative; display:none; margin:0;left:20px; width:220px; top:0px; height:40px;" >					
				<img src="images/signinnow.png" id="banner-click" width="120" class="visible-lg visible-md visible-sm img-responsive pull-left" style="position:relative; top:-200px; left:18px;">	
			</div>	
			<img src="images/header_order.png" class="visible-lg visible-md visible-sm img-responsive pull-right" style="border:0; cursor:pointer; margin:-185px 58px 0 0;" width="165">
			 			 
			 
			<img src="images/header_mushroom.png" class="img-responsive pull-left" style="border:none; position:relative; top:-176px; box-shadow: 0px 14px 45px 13px rgba(251,251,249,1); background-color: #FBFBF9;">
		</div>		
	</div>
		<div class="container navbar-fixed-top" style="z-index:2; width:590px; height:50px;" >					
			<img src="images/header_text.png" class="visible-lg visible-md visible-sm img-responsive pull-right" style="position:relative; top: 20px; right: 20px;">
		</div>	
		
		<div class="container navbar-fixed-top" style="height:110px; width: 100%; border-shadow:20px 20px; background-image: url('images/background.png'); z-index:1;">		
			<div class="button visible-xs">
				<a class="home2" href="index.php" style="visibility:hidden; display: block;"></a>
		    </div>	
		</div> 	
</div>

<div class="container">
<div class="row centered-form">
	<div class="col-lg-4">
		<div class="panel" style="background-color: #F0F0F0; position: relative; left: 30px;">
			<div class="panel-body">
				<a onclick="showChoosefile()"><span class="glyphicon glyphicon-pencil" style="position: absolute; top: 25px; right: 100px; cursor: pointer; font-size: 1.5em;"></span></a>
				<img class="img-responsive center-block " src="images/once-su.png" width=120 style="border-radius: 80px;"/>
				<input type="file" name="myImage" id="myImage" accept="image/*" style="margin: 20px 35px; display: none;"/>
				<p class="text-center"><small>Lorenzo<br>oncesu123.yahweh.com</small></p>
				<ul class="profile">
					<li id="personaldetails">
						<a href="#" onclick="showPanel1()"><img src="images/user.png"/>Personal Details</a>
					</li>
					<li id="receipt">
						<a href="#" onclick="showPanel2()"><img src="images/receipt.png"/>Receipts & Billing</a>
					</li>
				</ul>
				<p class="text-center" id="signout"><strong>Sign out</strong></p>
			</div>	
		</div>
	</div>	
    <div class="col-lg-8">
        <div class="panel" id="show1">
		<button class="btn btn-default" style="float: right; padding: 10px 30px 10px 30px;">Edit</button>
		<h2>Personal Details</h2>
			<div class="panel-body">
		    <div class="other">
			    <form role="form" data-toggle="validator" autocomplete="off">	
					<div class="row">
					<hr>	
					<h4>Name</h4>					
						<div class="col-lg-6">
							<div class="form-group">						
								<input type="text"  id="first_name" class="form-control input-sm" placeholder="First name" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" id="last_name" class="form-control input-sm" placeholder="Last name">						
							</div>						
						</div>							 				
					</div>
					<div class="row">
					<hr>			
					<h4>Email
						<div class="col-lg-12">
							<div class="form-group">
							<label style="font-variant: small-caps;"><small>new email address:</small></label>
								<input type="email" id="email" class="form-control input-sm" placeholder="Email">
							</div>	
						</div>	
					</div>
					<h4>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
							<label style="font-variant: small-caps;"><small>new password:</small></label>
								<input type="password" id="pwd" class="form-control input-sm" placeholder="Password">
							</div>
							<div class="form-group">
								<input type="password" id="pwd" class="form-control input-sm" placeholder="Confirm new password">
							</div>	
						</div>	
					</div>
					<div class="row">
					<hr>	
					<h4>Full Address</h4>					
						<div class="col-lg-12">
						<label style="font-variant: small-caps;"><small>new address:</small></label>
							<div class="form-group">
								<input type="text" id="address" class="form-control input-sm" placeholder="Address">
							</div>	
						</div>	
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" id="town" class="form-control input-sm" placeholder="Town/City">						
							</div>						
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" id="province" class="form-control input-sm" placeholder="Province">						
							</div>						
						</div>							 				
					</div>
					<div class="row">
					<hr>			
					<h4>Contact
						<div class="col-lg-12">
							<div class="form-group">
							<label style="font-variant: small-caps;"><small>new contact no:</small></label>
								<input type="tel" id="contactno" class="form-control input-sm" placeholder="Contact #">
							</div>	
						</div>	
					</div>
				<input type="submit" value="Save" class="btn btn-info btn-block">					
			    </form>
					</div>
			</div>
		</div>
	</div> 
	<div class="col-lg-8">
        <div class="panel" id="show2">
		<h2>Receipt and Billings</h2>
			<div class="panel-body">
				<div class="row">					
					<div class="col-lg-12">						 
						<table class="table responsive">
							<thead>
								<tr>
									<th></th>
									<th>Nuh</th>
									<th>gina</th>
									<th>gawa</th>
									<th>muh!</th>
								</tr>
							</thead>							
							<tbody>
					 			<tr>
								<td></td>
								<td></td>
								<td></td>
								</tr>												 							
							</tbody>  
						</table>
					</div>
				</div>				
			</div>
		</div>
		</div>
	</div>
</div>	
 
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div class="carousel-inner">
	<div id="footer" class="navbar-fixed-bottom img-responsive" style="height:160px;">
		<div id="group" class="row visible-lg visible-md visible-sm">
			<ul class="items">
				<li id="ft_nav_food" class="left">
				<a href="foods.php">FOODS</a>
				</li>
				<li id="ft_nav_mushroom" class="left">
					<img src="images/mushroom-icon.png" class="visible-lg visible-md visible-sm img-responsive">
				</li>
				<li id="ft_nav_locations" class="left">
				<a href="#">LOCATIONS</a>
				</li>
				<li id="ft_nav_about" class="right">
				<a href="#">ABOUT</a>
				</li>
				<li id="ft_nav_mushroom" class="right">
					<img src="images/mushroom-icon.png" class="visible-lg visible-md visible-sm img-responsive">
				</li>
				<li id="ft_nav_order" class="right">
				<a href="#">ORDER</a>
				</li>
			</ul>
		</div>
		
		<div class="row visible-lg visible-md visible-sm">
			<div class="col-sm-offset-3 col-md-offset-3 col-lg-1 col-lg-offset-4">
				<div class="button">
					<a class="home" href="index.php" style="display: block; left:0px;"></a>
				</div>
			</div>
		</div>
		
		<div class="row visible-lg visible-md visible-sm">
			<div class="button col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-lg-1">
				<a class="off" href="#" style="display: block;"></a>
				<a class="on" href="#" style="display: none;"></a>						
			</div>	
		</div>
		<div class="footer1 visible-lg">
		</div>
		<div class="footer2 visible-md">
		</div>
		<div class="footer3 visible-sm">
		</div>
	</div>
</div>
<?php
	$db -> loginUser();
?>
</body>
</html>