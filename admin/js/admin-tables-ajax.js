window.onload = start;

function start(){
	show();
	
}

function disableScrolling(){
	var x=window.scrollX;
	var y=window.scrollY;
	window.onscroll=function(){window.scrollTo(x, y);};
}

function enableScrolling(){
	window.onscroll=function(){};
}

function show(){
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
				document.getElementById("products-table-value").innerHTML = "";
				document.getElementById("spinner").style.display = "block";

				var msg = this.responseText;
				setTimeout(function(){
					document.getElementById("spinner").style.display = "none";
					document.getElementById("products-table-value").innerHTML = msg;	
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
							
								
			};
		}
		obj.open("GET","php/admin-php.php?action="+'showTables', true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}	
}

function setTableActive(category){
	var category = category;
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
				show();
			};
		}
		obj.open("GET","php/admin-php.php?action="+'setTableStatus'+"&category="+category+"&status="+'vacant', true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}	
}

function setTableInactive(category){
	var category = category;
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
				show();
			};
		}
		obj.open("GET","php/admin-php.php?action="+'setTableStatus'+"&category="+category+"&status="+'occupied', true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}	
}
function ask(category){
	disableScrolling();
	alert(category);
	$('#alertModal').modal('show');
	$('.del-product').attr('id',category);
	$("#alertModalAnimate").animateCss('zoomIn');	
}

function deleteProduct(category){
	var category = category;
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
				
				show();
				enableScrolling();
				closeAlert();
				
			};
		}
		obj.open("GET","php/admin-php.php?action="+'deleteProduct'+"&category="+category, true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}	
}

function closeAlert(){
	enableScrolling();
	$('#alertModal').modal('hide');
	$("#alertModalAnimate").animateCss('zoomOut');	
}

function edit_product(category){
	$("#editProductAnimate").css({"display":"none"});
	$("#addProductAnimate").css({"display":"none"});
	$("#editProductAnimate").animate( 
		{'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
	);	
	//document.getElementById("product-category").innerHTML = category;
	document.getElementById("update-product").value = category;
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
				document.getElementById("food-name-value").value = category;
				//document.getElementById("food-price-value").value = msg[1];			
			};
		}
		obj.open("GET","php/admin-php.php?action="+'showEditForm'+"&category="+category, true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}
	
}

function updateProduct(value){
	var name = document.getElementById("food-name-value").value;
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
					message: 'Successfully updated table.',
					timeout: 2000,
				});
				document.getElementById("editProductAnimate").style.display="none";
				show();
			};
		}
		obj.open("GET","php/admin-php.php?action="+'editTable'+"&category="+value+"&name="+name, true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}
}

function saveTable(){
	//var category = $("#food-category-input").val();
	var tableNo = $("#table-number-input").val();
	
	if(tableNo.length != 0){
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
							message: 'Cannot add new table with same table number!',
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
						show();
					}
				}
			};
			obj.open("GET","php/admin-php.php?action="+'saveTable'+"&tableNo="+tableNo, true);
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