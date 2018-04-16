window.onload = start;

function start(){
	viewUsers();
	/* viewCategory(); */
	
}

function disableScrolling(){
	var x=window.scrollX;
	var y=window.scrollY;
	window.onscroll=function(){window.scrollTo(x, y);};
}

function closeChange(){
	enableScrolling();
	$("#newPassword").val("");
	$("#confirmPassword").val("");
}

function askChange(username){
	//alert(username);
	disableScrolling();
	$("#changePass").modal("show");
	document.getElementById("button-update").setAttribute("name",username);
}


function enableScrolling(){
	window.onscroll=function(){};
}

function updatePassword(){
	var passw = document.getElementById('newPassword');
	var conpassw = document.getElementById('confirmPassword');
	var username = document.getElementById("button-update").getAttribute("name");
	
	if(passw.value.length!=0 && conpassw.value.length!=0){
	
		var pass = passw.nextElementSibling.nextElementSibling.innerHTML;
		
		if(pass=='OK!'){
			var conpass = conpassw.nextElementSibling.nextElementSibling.innerHTML;
			
			passw.parentElement.classList.remove("has-error");			
			if(conpass=='OK!'){
				var newpass = passw.value;
				conpassw.parentElement.classList.remove("has-error");
				if(window.XMLHttpRequest){
					obj = new XMLHttpRequest();
				}
				else{
					if(window.ActiveXObject){
						try{
							obj = new ActiveXObject("Microsoft.XMLHTTP");
						}
						catch(e){
								
						}
					}
				}
					
				if(obj){
					obj.onreadystatechange = function(){
						if(this.readyState==4 && this.status==200){			
							iziToast.success({
								title: 'Success',
								message: this.responseText,
								timeout: 2000,
							});	
							$("#closeChange").click();
						};
					}
					obj.open("GET","php/admin-php.php?action="+'editUsersPass'+"&username="+username+"&newpass="+newpass, true);
					obj.send(null);	
				}
				else{
					alert("Error");
				}
			}
			else{
				conpassw.parentElement.classList.add("has-error");
				iziToast.warning({
					title: conpass,
					backgroundColor: '#E16045',
					timeout: 3000,
				});
			}
			
		}
		else{
			passw.parentElement.classList.add("has-error");
			iziToast.warning({
				title: pass,
				//message: this.responseText,
				backgroundColor: '#E16045',
				timeout: 3000,
			});
		}
	}
	else{
		iziToast.warning({
			title: 'Please fill up the form',
			//message: this.responseText,
			backgroundColor: '#E16045',
			timeout: 3000,
		});
	}
	
	
}

function changePic(code){
	document.getElementById("edit-button-value").setAttribute('value',code);
	if(window.XMLHttpRequest){
		obj = new XMLHttpRequest();
	}
	else{
		if(window.ActiveXObject){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				
			}
		}
	}
	
	if(obj){
		obj.onreadystatechange = function(){
			if(this.readyState==4 && this.status==200){									
				document.getElementById("food-picture").setAttribute('src',this.responseText);				
				$('#editphoto').modal('show');	
				$('#editphotoanimate').animateCss('zoomIn');
				disableScrolling();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewFoodImage'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function closeEditPhoto(){
	enableScrolling();
	$('#editphotoanimate').animateCss('zoomOut');
	$('#editphoto').modal('hide');
}

function ask(category){
	disableScrolling();
	$('#alertModal').modal('show');
	$('.del-product').attr('id',category);
	$("#alertModalAnimate").animateCss('zoomIn');	
}

function closeAlert(){
	enableScrolling();
	$('#alertModal').modal('hide');
	$("#alertModalAnimate").animateCss('zoomOut');
}

function edit_food(code){
	$("#editProductAnimate").css({"display":"none"});
	$("#addProductAnimate").css({"display":"none"});
	$("#editProductAnimate").animate( 
		{'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
	);	
	document.getElementById("food-code").innerHTML = code;
	document.getElementById("update-product").value = code;
	if(window.XMLHttpRequest){
		obj = new XMLHttpRequest();
	}
	else{
		if(window.ActiveXObject){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
					
			}
		}
	}
		
	if(obj){
		obj.onreadystatechange = function(){
			if(this.readyState==4 && this.status==200){			
				msg = this.responseText.split("*");
				document.getElementById("food-name-value").value = msg[0];
				document.getElementById("food-price-value").value = msg[1];			
			};
		}
		obj.open("GET","php/admin-php.php?action="+'showEditFoods'+"&code="+code, true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}
	
}


function updateProduct(value){
	var name = document.getElementById("food-name-value").value;
	var price = document.getElementById("food-price-value").value
	if(window.XMLHttpRequest){
		obj = new XMLHttpRequest();
	}
	else{
		if(window.ActiveXObject){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
					
			}
		}
	}
		
	if(obj){
		obj.onreadystatechange = function(){
			if(this.readyState==4 && this.status==200){						
				iziToast.success({
					title: 'Success',
					message: 'Successfully updated product.',
					timeout: 2000,
				});
				document.getElementById("editProductAnimate").style.display="none";
				viewProducts();
			};
		}
		obj.open("GET","php/admin-php.php?action="+'editFood'+"&code="+value+"&name="+name+"&price="+price, true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}
}

function deleteFood(code){
	var code = code;
	if(window.XMLHttpRequest){
		obj = new XMLHttpRequest();
	}
	else{
		if(window.ActiveXObject){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
					
			}
		}
	}
		
	if(obj){
		obj.onreadystatechange = function(){
			
			if(this.readyState==4 && this.status==200){								
				iziToast.success({
					title: 'Success',
					message: 'You have successfully deleted a product',
					timeout: 2000,
				});
				enableScrolling();
				closeAlert();
				viewProducts();
			};
		}
		obj.open("GET","php/admin-php.php?action="+'deleteFood'+"&code="+code, true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}	
}

$(document).ready(function(){
	$("#file-attach").click(function(){
		$("#upload-file").click();
	});
	$('#upload-file').change(function(e) {
		if ($(this).val() == '') {
			$('#file-label').val("")   
		}
		else{
			var fileName = e.target.files[0].name;
			$('#file-label').val(fileName);
		}        
	});	
	$("#file-delete").click(function(){
		$('#file-label').val("")   
		$('#upload-file').val("")   
	});
	
	$("#editphoto-close").click(function(){
		$('#file-label').val("");
		$('#upload-file').val("");
		$("#editphoto").css({'display':'none'});
	});
	$("#editphoto-close2").click(function(){
		$('#file-label').val("");
		$('#upload-file').val(""); 
		$("#editphoto").css({'display':'none'});
	});	
});

function uploadPic(data,code){
	//alert(code);
	if(window.XMLHttpRequest){
		obj = new XMLHttpRequest();
	}
	else{
		if(window.ActiveXObject){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				
			}
		}
	}
	var formData = new FormData(document.getElementById(data));
	if(obj){
		obj.onreadystatechange = function(){ 	//showImage;
			if(this.readyState == 4 && this.status == 200) {		
					
					if(this.responseText=="success"){
						iziToast.success({
							title: 'Success',
							message: 'Successfully updated product.',
							timeout: 2000,
						});
						$('#file-label').val("");
						$('#upload-file').val("");
						closeEditPhoto();
						viewProducts();						
					}
					else{
						iziToast.warning({
							title: 'Warning',
							message: this.responseText,
							backgroundColor: '#E16045',
							timeout: 3000,
						});	
					}
			}
		};
		obj.open("POST","php/admin-php.php?action="+'saveFoodImage'+"&code="+code, true);
		obj.send(formData);
	}
	else{
		alert("Error");
	}
	

}

function viewUsers(){
	category = $("#user_category option:selected").val();	
	//stat = $("#foodstatus option:selected").val();
	//val = category;
	if(window.XMLHttpRequest){
		obj = new XMLHttpRequest();
	}
	else{
		if(window.ActiveXObject){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				
			}
		}
	}
	
	if(obj){
		obj.onreadystatechange = function(){
			if(this.readyState==4 && this.status==200){	
				$("#data-table").dataTable().fnDestroy();	
					document.getElementById("users-table").innerHTML = "";
					document.getElementById("spinner").style.display = "block";

					var msg = this.responseText;
					setTimeout(function(){
						document.getElementById("spinner").style.display = "none";
						document.getElementById("users-table").innerHTML = msg;	
						$(function () {
							$('#data-table').DataTable({
							  'retrieve'	: true,					  
							  'paging'  	: true,					  
							  'lengthChange': false,
							  'searching'   : false,
							  'ordering'    : false,
							  'info'        : false,
							  'autoWidth'   : true,
							  "pageLength"	: 10,
							  
							  "sDom": "<'row'<'col-xs-5 col-sm-6'l><'col-xs-7 col-sm-6 text-right'f>r>t<'row'<'col-xs-3 col-sm-4 col-md-5'i><'col-xs-9 col-sm-8 col-md-7 text-right'p>>",
							})
						  })
					}, 400);
				//document.getElementById("users-table").innerHTML = this.responseText;
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewUsersInfo'+"&category="+category, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}	

}

function setUserActive(code){
	
	var code = code;
	if(window.XMLHttpRequest){
		obj = new XMLHttpRequest();
	}
	else{
		if(window.ActiveXObject){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
					
			}
		}
	}
		
	if(obj){
		obj.onreadystatechange = function(){
			if(this.readyState==4 && this.status==200){				
				iziToast.success({
					title: 'Success',
					message: 'Successfully updated user.',
					timeout: 2000,
				});
				viewUsers();
			};
		}
		obj.open("GET","php/admin-php.php?action="+'setUserStatus'+"&code="+code+"&status="+'Active', true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}	
}

function setUserInactive(code){
	var code = code;
	if(window.XMLHttpRequest){
		obj = new XMLHttpRequest();
	}
	else{
		if(window.ActiveXObject){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
					
			}
		}
	}
		
	if(obj){
		obj.onreadystatechange = function(){
			if(this.readyState==4 && this.status==200){							
				iziToast.success({
					title: 'Success',
					message: 'Successfully updated user.',
					timeout: 2000,
				});
				viewUsers();
			};
		}
		obj.open("GET","php/admin-php.php?action="+'setUserStatus'+"&code="+code+"&status="+'Inactive', true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}	
}

function saveFood(){
	category = $("#product_category option:selected").val();
	//alert(product_category);
	var foodCode = $("#food-code-input").val();
	var foodName = $("#food-name-input").val();
	var foodPrice = $("#food-price-input").val();	
	
	if(category.length != 0 && foodName.length != 0 && foodPrice.length != 0){
		if(window.XMLHttpRequest){
			obj = new XMLHttpRequest();
		}
		else{
			if(window.ActiveXObject){
				try{
					obj = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(e){
					
				}
			}
		}
		
		if(obj){
			obj.onreadystatechange = function(){
				if(this.readyState==4 && this.status==200){		
		
					if(this.responseText=="same"){
						iziToast.warning({
							title: 'Warning',
							message: 'Cannot add new product with same food code or food name!',
							backgroundColor: '#E16045',
							timeout: 3000,
						});	
					}
					else{						
						iziToast.success({
							title: 'Success',
							message: 'Successfully Added!',
							timeout: 3000,
						});
						document.getElementById("addProductAnimate").style.display="none";
						viewProducts();
					}
				}
			};
			obj.open("GET","php/admin-php.php?action="+'saveFood'+"&foodCode="+foodCode+"&foodName="+foodName+"&foodPrice="+foodPrice+"&category="+category, true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
	}
	else{
		iziToast.warning({
			title: 'Warning',
			message: 'Please fill up the form!',
			backgroundColor: '#E16045',
			timeout: 3000,
		});	
	}
	
}
/* function viewCategory(){
	if(window.XMLHttpRequest){
		obj = new XMLHttpRequest();
	}
	else{
		if(window.ActiveXObject){
			try{
				obj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				
			}
		}
	}
	
	if(obj){
		obj.onreadystatechange = function(){
			if(this.readyState==4 && this.status==200){	
				document.getElementById("product-category").innerHTML = this.responseText;
				alert();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewCategory', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
} */