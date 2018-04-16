//window.onload = start;

// function start(){
	// viewProducts();
	// /* viewCategory(); */
	
// }

function disableScrolling(){
	var x=window.scrollX;
	var y=window.scrollY;
	window.onscroll=function(){window.scrollTo(x, y);};
}

function enableScrolling(){
	window.onscroll=function(){};
}

function changePic(){
	
	//document.getElementById("edit-button-value").setAttribute('value',code);
	/* if(window.XMLHttpRequest){
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
				document.getElementById("food-picture").setAttribute('src',this.responseText);	 */			
				$('#editphoto').modal('show');	
				$('#editphotoanimate').animateCss('zoomIn');
				disableScrolling();
		/* 	}
		};
		obj.open("GET","php/admin-php.php?action="+'viewFoodImage'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	} */
	
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

function uploadPic(data){
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
						setTimeout(function(){
							location.href = window.location.href;
						},500);					
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
		obj.open("POST","php/admin-php.php?action="+'saveProfileImage', true);
		obj.send(formData);
	}
	else{
		alert("Error");
	}
	

}

function  savePass(){
	var currentPass = $("#currentpass").val();
	var newPass = $("#newpass").val();
	var conPass = $("#conpass").val();
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
				if(this.responseText=="invalid"){
					iziToast.warning({
						title: 'Warning',
						message: 'Please retype your current password',
						backgroundColor: '#E16045',
						timeout: 3000,
					});	
				}
				else if(this.responseText=="same"){
					iziToast.warning({
						title: 'Warning',
						message: 'Password does not match the confirm password',
						backgroundColor: '#E16045',
						timeout: 3000,
					});	
				}
				else{
					iziToast.success({
						title: 'Updated successfully',
						//message: 'Successfully Added!',
						timeout: 3000,
					});
					setTimeout(function(){
						location.href = window.location.href;
					},500);
				}
				//document.getElementById("foods-table-value").innerHTML = this.responseText;
			}
		};
		obj.open("GET","php/admin-php.php?action="+'changePassword'+"&currentPass="+currentPass+"&newPass="+newPass+"&conPass="+conPass, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function viewProducts(){
	category = $("#foodcategory option:selected").val();
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
				document.getElementById("foods-table-value").innerHTML = this.responseText;
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewProducts'+"&category="+category, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	

}

function updateProfile(){
	category = $("#product_category option:selected").val();
	//alert(product_category);
	//var foodCode = $("#food-code-input").val();
	var firstname = $("#FirstName").val();
	var lastname = $("#LastName").val();
	var email = $("#EmailAddress").val();
	var username = $("#Username").val();	
	
	if(firstname.length != 0 && lastname.length != 0 && email.length != 0 && username.length != 0){
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
						title: 'Updated successfully',
						//message: 'Successfully Added!',
						timeout: 3000,
					});
					setTimeout(function(){
						location.href = window.location.href;
					},500);
					/* if(this.responseText=="same"){
						iziToast.warning({
							title: 'Warning',
							message: 'Cannot add new food with same food name!',
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
						viewProducts(); */
					}
				};
				obj.open("GET","php/admin-php.php?action="+'updateProfile'+"&firstname="+firstname+"&lastname="+lastname+"&email="+email+"&username="+username, true);
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
