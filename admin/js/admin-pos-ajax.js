window.onload = start;


$adminJQ = jQuery.noConflict();
function start(){
	changeChoices();	
	changeCartValues();
	
}

function changeChoices(){
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
				document.getElementById("products-info").innerHTML = msg[1];
				document.getElementById("products-info").value = msg[0];
				document.getElementById("dropdown-choice").innerHTML = msg[2];
				viewProducts();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'changeChoices', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function changeTableDineIn(){
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
				document.getElementById("table-info").innerHTML = msg[1];
				document.getElementById("table-info").value = msg[0];
				document.getElementById("dropdown-choice-available").innerHTML = msg[2];
				//viewProducts();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'changeDinein', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function changeTableAdd(){
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
				
				document.getElementById("table-no-add").innerHTML = this.responseText;
				//msg = this.responseText.split("*");
				//document.getElementById("table-info-add").innerHTML = msg[1];
				//document.getElementById("table-info-add").value = msg[0];
				//document.getElementById("dropdown-choice-add").innerHTML = msg[2];
				//viewProducts();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'changeAdd', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function changeDinein(val){
	
	document.getElementById("table-info").value = val;
	document.getElementById("table-info").innerHTML = val;	

}

function changeAdd(val){
	
	document.getElementById("table-info-add").value = val;
	document.getElementById("table-info-add").innerHTML = val;	

}

function changeValue(val,name){
	
	document.getElementById("products-info").value = val;
	document.getElementById("products-info").innerHTML = name;
	viewProducts();
}

function newOrder(orderType){
	document.getElementById("inputCustomer").style.display = "none";
	checkName();
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
				document.getElementById("type-label").innerHTML = this.responseText;
				
				if(this.responseText=="Dine in"){
					document.getElementById("print-button").value= "Dine-in";
					document.getElementById("id-available").style.display ="block";
					document.getElementById("table-add").style.display ="none";
					document.getElementById("print-button").setAttribute("name","Dine-in");
					document.getElementById("queueDiv").classList.remove("hidden");
					document.getElementById("resetDiv").classList.remove("hidden");
					document.getElementById("divReset").classList.add("hidden");
					document.getElementById("payment-takeout-div").classList.add("hidden");
					document.getElementById("paymentDiv").classList.remove("hidden");
					document.getElementById("reserveDiv").classList.add("hidden");
					document.getElementById("addDiv").classList.add("hidden");
					document.getElementById("customer-name").innerHTML = "";
					changeTableDineIn();
					
				}
				else if(this.responseText=="Take out"){
					document.getElementById("print-button-takeout").value= "Take-out";
					document.getElementById("table-add").style.display ="none";
					document.getElementById("id-available").style.display ="none";	
					document.getElementById("queueDiv").classList.add("hidden");
					document.getElementById("resetDiv").classList.add("hidden");
					document.getElementById("divReset").classList.remove("hidden");					
					document.getElementById("payment-takeout-div").classList.remove("hidden");
					document.getElementById("paymentDiv").classList.add("hidden");
					document.getElementById("reserveDiv").classList.add("hidden");
					document.getElementById("addDiv").classList.add("hidden");
					document.getElementById("customer-name").innerHTML = "";
				}
				else if(this.responseText=="Reservation"){
					document.getElementById("reserve-button").value= "Reserve";
					document.getElementById("table-add").style.display ="none";
					document.getElementById("id-available").style.display ="none";	
					document.getElementById("queueDiv").classList.add("hidden");
					document.getElementById("resetDiv").classList.add("hidden");
					document.getElementById("divReset").classList.remove("hidden");
					document.getElementById("payment-takeout-div").classList.add("hidden");
					document.getElementById("paymentDiv").classList.add("hidden");
					document.getElementById("reserveDiv").classList.remove("hidden");
					document.getElementById("addDiv").classList.add("hidden");
					document.getElementById("inputCustomer").style.display = "inline-block";
					askName();
				}
				else{
					document.getElementById("print-button-add").value= "Add-order(s)";
					document.getElementById("table-add").style.display ="block";
					document.getElementById("id-available").style.display ="none";
					document.getElementById("queueDiv").classList.add("hidden");
					document.getElementById("resetDiv").classList.add("hidden");
					document.getElementById("divReset").classList.remove("hidden");
					document.getElementById("reserveDiv").classList.add("hidden");
					document.getElementById("payment-takeout-div").classList.add("hidden");
					document.getElementById("paymentDiv").classList.add("hidden");
					document.getElementById("addDiv").classList.remove("hidden");
					document.getElementById("customer-name").innerHTML = "";
					changeTableAdd();
				}	
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'newOrder'+"&orderType="+orderType, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function askName(){
	var customer = document.getElementById("customer-name").innerHTML;
	
	if(customer==""){
		$('#txtCustomer').val("");
		$('#nameModal').modal('show');
		$('#txtCustomer').select();
		
	}
}

function inputName(){
	var customer = document.getElementById("customer-name").innerHTML;
	
	if(customer==""){
		$('#txtCustomer').val("");
		$('#nameModal').modal('show');
		$('#txtCustomer').select();
		
	}
	else{
		$('#txtCustomer').val(customer);
		$('#nameModal').modal('show');
		$('#txtCustomer').select();
	}
}

function hideNewModal(){
	enableScrolling();
	$('#typeModal').modal('hide');
	$("#typeModalAnimate").animateCss('zoomOut');
}
function hideTable(){	
	document.getElementById("table-add").style.display ="none";
	document.getElementById("id-available").style.display ="none";
	
}
function disableScrolling(){
	var x=window.scrollX;
	var y=window.scrollY;
	window.onscroll=function(){window.scrollTo(x, y);};
}

function enableScrolling(){
	window.onscroll=function(){};
}

function resetValue(){
	document.getElementById('quantity').value = "1";
	document.getElementById('txtNumber').value = "";
	enableScrolling();
}

function checkCart(){
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
				
				if(this.responseText=="set"){
					document.getElementById("payButton").classList.remove("disabledbutton");
					document.getElementById("checkout").style.cursor = "pointer";	
					document.getElementById("print-button").classList.remove("disabledbutton");
					document.getElementById("print-button-takeout").classList.remove("disabledbutton");
					document.getElementById("print-check").style.cursor = "pointer";
					document.getElementById("print-check-takeout").style.cursor = "pointer";
					document.getElementById("reserve-button").classList.remove("disabledbutton");
					document.getElementById("print-reserve").style.cursor = "pointer";
					document.getElementById("print-button-add").classList.remove("disabledbutton");
					document.getElementById("add-check").style.cursor = "pointer";					
				}
				else{				
					document.getElementById("payButton").classList.add("disabledbutton");
					document.getElementById("checkout").style.cursor = "no-drop";	
					document.getElementById("print-button").classList.add("disabledbutton");
					document.getElementById("print-button-takeout").classList.add("disabledbutton");
					document.getElementById("print-check").style.cursor = "no-drop";
					document.getElementById("print-check-takeout").style.cursor = "no-drop";
					document.getElementById("reserve-button").classList.add("disabledbutton");
					document.getElementById("print-reserve").style.cursor = "no-drop";
					document.getElementById("print-button-add").classList.add("disabledbutton");	
					document.getElementById("add-check").style.cursor = "no-drop";					
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'checkCart', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function checkPayment(){
	var payment = parseFloat(document.getElementById('txtNumber').value).toFixed(2);
	//alert(payment);
	var topay = document.getElementById('topay').innerHTML;
	//alert(topay);
	topay = parseFloat(topay.replace(',','').replace('.','.'));
	//var topay = parseFloat('' + (topay * 100)) / 100;
	if(!payment){
		//$('#infoModal').modal('show');
		//$('#infoModal > div').animateCss('bounceInDown')
		iziToast.warning({
			title: 'Error',
			message: 'Insufficient funds!',
			backgroundColor: '#E16045',
			timeout: 2000,
		});	
	}
	else{
		if(payment>=topay){
			//alert(topay+"<"+payment);	
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
						document.getElementById("review-table").innerHTML = msg[0];
						document.getElementById("review-orderno").innerHTML = msg[1];
						document.getElementById("review-date").innerHTML = msg[2];
						document.getElementById("review-total").innerHTML = msg[3];
						document.getElementById("review-total-top").innerHTML = msg[3];
						document.getElementById("review-payment").innerHTML = msg[4];
						document.getElementById("review-change").innerHTML = msg[5];
						document.getElementById("accept-print").setAttribute("name",msg[1])
						document.getElementById("accept-print").setAttribute("value",msg[4])
						
						//printReceipt($code);
					}
				};
				obj.open("GET","php/admin-php.php?action="+'reviewOrder'+"&payment="+payment, true);
				obj.send(null);
			}
			else{
				alert("Error");
			}
			$("#print_review").click();			
		}
		else{
			iziToast.warning({
				title: 'Error',
				message: 'Insufficient funds!',
				backgroundColor: '#E16045',
				timeout: 2000,
			});	
		}
	}
	
}

/* function showQuantity(code){
	disableScrolling();
	document.getElementById('buttonAdd').setAttribute("name",code);
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
				document.getElementById("product-pic").innerHTML = "";
				document.getElementById("product-label").innerHTML = "";
				var msg = this.responseText.split("*");
				document.getElementById("product-pic").src = msg[0];	
				
				document.getElementById("product-label").innerHTML = msg[1];					
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewPosFood'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
	//$("#addModalAnimate").animateCss('flipInX');
	
	//alert(code);
} */

function viewProducts(){
	category = $("#products-info").val();	
	document.getElementById('search-product').value = "";
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
				
				document.getElementById("table-data").innerHTML = "";
				document.getElementById("spinner").style.display = "block";
				var msg = this.responseText.split("*");
				
						
				setTimeout(function(){
					document.getElementById("spinner").style.display = "none";
					document.getElementById("table-data").innerHTML = msg[0];
				}, 400);
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewPosProducts'+"&category="+category, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	

}




function searchProducts(code){
	category = $("#products-info").val();
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
				document.getElementById("table-data").innerHTML = "";
				var msg = this.responseText.split("*");
				document.getElementById("table-data").innerHTML = msg[0];			
			}
		};
		obj.open("GET","php/admin-php.php?action="+'searchPosProducts'+"&category="+category+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	

}

function searchQueue(code){
	//category = $("#products-info").val();
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
				document.getElementById("table-queue").innerHTML = this.responseText;
					
			}
		};
		obj.open("GET","php/admin-php.php?action="+'searchQueue'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	

}

function printReceipt(code,payment){
	//alert(code+" "+payment);	
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
				//alert("Success");
				if(this.responseText!="error"){
					iziToast.success({
						title: 'Successful',
						message: 'Now printing...',				
						timeout: 3000,
					});	
					changeCartValues();
					$(".close-modal-review").click();
					$("#payModal").modal("hide");
					resetValue();
				}
				else{
					iziToast.warning({
						title: 'Error',
						message: 'Please set up your printer!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'printReceipt'+"&code="+code+"&payment="+payment, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function printBill(type){
	var action = "";
	var table = "";
	if(type=="Take-out"){
		action = "printBillOut";
		
	}
	else{
		action = "printBillDine";
		if(type=="Dine-in"){
			table = document.getElementById("table-info").value;
		}
		else{
			table = document.getElementById("table-info-add").value;
		}
		
	}
	
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
				//alert("Success");
				if(this.responseText!="error"){
					iziToast.success({
						title: 'Successful',
						message: 'Now printing...',				
						timeout: 3000,
					});	
					//changeCartValues();
					//$(".close-modal-review").click();
					//$("#payModal").modal("hide");
					//resetValue();
				}
				else{
					iziToast.warning({
						title: 'Error',
						message: 'Please set up your printer!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+action+"&type="+type+"&table="+table, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function isNumber(evt) {
 /*    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true; */
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]|\./;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

function isNumbers(evt) {

	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]/;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

function isNumbersAndLetters(evt) {

	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9a-z A-Z]/;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

function isLetters(evt) {

	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[a-z A-Z]/;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

function addQuantity(food_code){

  //var quantity = document.getElementById('quantity').value;
  var quantity = 1;
  //var cartQuantity = document.getElementById('cartQuantity').firstChild.data;
   
  //var total = parseInt(cartQuantity) + parseInt(quantity);
  
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
			if(this.readyState == 4 && this.status == 200) {	
				//document.getElementById('quantity').value = 1;	
				if(this.responseText=="success"){
					//document.getElementById('cartQuantity').firstChild.data = "+"+total;
					/* $("#cartAnimate").animateCss('bounce');
					setTimeout(function(){
						document.getElementById('cartQuantity').firstChild.data = total;
					},1000);	 */				
					$("#queue-tab").css({"display":"none"});
					changeCartValues();	
				}
				else{
					iziToast.info({
						message: 'Tap the new order button to start a new order.',						
						timeout: 2500,
					});	
				}
						
			}
		};
		obj.open("GET","php/admin-php.php?action="+'addToCart'+"&food_code="+food_code+"&quantity="+quantity, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
  
}

function closeModal(){
	$('#infoModal').modal('hide');
}

function cartIncrease(id){
	var msg = id.split(" ");
	quantity = msg[0];
	code = msg[1];
	quantity = parseInt(quantity) + 1;
	
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {		
				//document.getElementById('quantity').value = 1;	
				//document.getElementById('cartQuantity').firstChild.data = obj.responseText;
				changeCartValues();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'updateProduct'+"&food_code="+code+"&quantity="+quantity, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
  
}

function cartDecrease(id){
	disableScrolling();
	var msg = id.split(" ");
	quantity = msg[0];
	code = msg[1];
	quantity = parseInt(quantity) - 1;
	if(quantity > 0){		
		cartMinus(quantity);
	}
	else{
		$('#alertModal').modal('show');
		$("#alertModalAnimate").animateCss('zoomIn');
	}
	
}
function closeOrderType(){
	enableScrolling();
	$('#typeModal').modal('hide');
	$("#typeModalAnimate").animateCss('zoomOut');
}

function closeAlert(){
	enableScrolling();
	$('#alertModal').modal('hide');
	$("#alertModalAnimate").animateCss('zoomOut');
}

function closeClearAlert(){
	enableScrolling();
	$('#clearModal').modal('hide');
	$("#clearModalAnimate").animateCss('zoomOut');
	hideTable();
}

function closeDelAlert(){
	enableScrolling();
	$('#delModal').modal('hide');
	$("#delModalAnimate").animateCss('zoomOut');
	
}

function closeCancelModal(){
	enableScrolling();
	$('#cancelModal').modal('hide');
	$("#cancelModalAnimate").animateCss('zoomOut');
	
}

function cartMinus(quantity){
	$('#alertModal').modal('hide');
	$("#alertModalAnimate").animateCss('zoomOut');
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {						
				//document.getElementById('cartQuantity').firstChild.data = obj.responseText;
				changeCartValues();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'updateProduct'+"&food_code="+code+"&quantity="+quantity, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function checkType(){
  //var quantity = document.getElementById('quantity').value;
  //var quantity = 1;
  var cartQuantity = document.getElementById('cartQuantity').firstChild.data;
   
  var total = parseInt(cartQuantity) + 1;
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {		
				/* document.getElementById("type-label").innerHTML = "Undefined";
				//document.getElementById('cartQuantity').firstChild.data = 0;
				//changeCartValues();
				clearCart(); */				
						
				if(this.responseText=="Dine"){	
					document.getElementById('cartQuantity').firstChild.data = "+"+1;
					$("#cartAnimate").animateCss('bounce');
						setTimeout(function(){
						document.getElementById('cartQuantity').firstChild.data = total;
					},1000);
					queueDine();
				}
				else if(this.responseText=="Take"){
					document.getElementById('cartQuantity').firstChild.data = "+"+1;
					$("#cartAnimate").animateCss('bounce');
						setTimeout(function(){
						document.getElementById('cartQuantity').firstChild.data = total;
					},1000);
					queueTakeout();
				}
				else if(this.responseText=="Reserve"){
					var customer = document.getElementById("customer-name").innerHTML;
					if(customer==""){
						iziToast.warning({
							title: 'No customer found',							
							backgroundColor: '#E16045',
							timeout: 2000,
						});	
					}
					else{
						reserveOrder();
						clearCart();
						//queueReserve();
					}
					/* document.getElementById('cartQuantity').firstChild.data = "+"+1;
					$("#cartAnimate").animateCss('bounce');
						setTimeout(function(){
						document.getElementById('cartQuantity').firstChild.data = total;
					},1000);
					queueTakeout(); */
				}
				else{
					queueAdd();
				}
			}
		};
		obj.open("GET","php/admin-php.php?action="+'checkType', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function nameUpdate(){

	var name = document.getElementById("txtCustomer").value;	
	
	if(name==""){
		iziToast.warning({
			message: 'Invalid name',
			backgroundColor: '#E16045',
			timeout: 2000,
		});
	}
	else{
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
			obj.onreadystatechange = function(){ 	//updateProduct;
				if(this.readyState == 4 && this.status == 200) {		
					document.getElementById("customer-name").innerHTML = this.responseText;
					$("#nameModal").modal("hide");
				}
			};
			obj.open("GET","php/admin-php.php?action="+'updateName'+"&name="+name, true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
	}
	
}

function checkName(){
	var name = document.getElementById("txtCustomer").value;	
	
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {		
				document.getElementById("customer-name").innerHTML = this.responseText;
			}
		};
		obj.open("GET","php/admin-php.php?action="+'checkName', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function checkPaymentType(){
  //var quantity = document.getElementById('quantity').value;
  //var quantity = 1;
  //var cartQuantity = document.getElementById('cartQuantity').firstChild.data;
   
  //var total = parseInt(cartQuantity) + 1;
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {		
				/* document.getElementById("type-label").innerHTML = "Undefined";
				//document.getElementById('cartQuantity').firstChild.data = 0;
				//changeCartValues();
				clearCart(); */				
				/* document.getElementById('cartQuantity').firstChild.data = "+"+1;
				$("#cartAnimate").animateCss('bounce');
					setTimeout(function(){
						document.getElementById('cartQuantity').firstChild.data = total;
				},1000); */	
			
				if(this.responseText=="Dine"){					
					queuePaymentDine();
				}
				else if(this.responseText=="Take"){
					queuePaymentTakeout();
				}
				else{
					queuePaymentAdd();
				}
			}
		};
		obj.open("GET","php/admin-php.php?action="+'checkType', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function queueDine(){
	var table = document.getElementById("table-info").value;
	
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {	
				if(this.responseText!="error"){																	
					iziToast.success({
						message: 'Moved to queue',						
						timeout: 2500,
					});				
					clearCart();
					hideTable();	
				}
				else{
					iziToast.warning({
						title: 'Error',
						message: 'Please set up your printer!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'queueDine'+"&table="+table, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function reserveOrder(){
	var table = document.getElementById("table-info").value;
	var name = document.getElementById("customer-name").innerHTML;
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {					
				iziToast.success({
					message: 'Moved to Orders->Reservations',						
					timeout: 2500,
				});	
				/* if(this.responseText!="error"){																	
					iziToast.success({
						message: 'Moved to queue',						
						timeout: 2500,
					});				
					clearCart();
					hideTable();	
				}
				else{
					iziToast.warning({
						title: 'Error',
						message: 'Please set up your printer!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				} */
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'reserveOrder'+"&name="+name, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function showDiscount(){
	$('#discountModal').modal('show');
}
function showDiscountTakeout(){
	$('#discountModalTK').modal('show');
}
function showDiscountModal(){
	$('#discountModalReview').modal('show');
}
function showSC(){
	$("#txtSC").val("");
	$("#scModal").modal("show");
	$("#txtSC").select();
	
}
function showPWD(){
	$("#txtPWD").val("");
	$("#pwdModal").modal("show");
	$("#txtPWD").select();
}
function showTkSC(){
	$("#txtTkSC").val("");
	$("#scTkModal").modal("show");
	$("#txtTkSC").select();
	
}
function showTkPWD(){
	$("#txtTkPWD").val("");
	$("#pwdTkModal").modal("show");
	$("#txtTkPWD").select();
}
function showModalSC(){
	$("#txtReviewSC").val("");
	$("#scReviewModal").modal("show");
	$("#txtReviewSC").select();
	
}
function showModalPWD(){
	$("#txtReviewPWD").val("");
	$("#pwdReviewModal").modal("show");
	$("#txtReviewPWD").select();
}

function queuePaymentDine(){
	document.getElementById("payment-print").classList.add("disabledbutton");
	document.getElementById("printPayment-button").style.cursor = "no-drop";
	val = parseFloat("0").toFixed(2);
	document.getElementById("review-discount-payment").innerHTML = val;	
	//document.getElementById('toggle-id-payment').classList.remove("active");
	
	var table = document.getElementById("table-info").value;

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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {
				msg = this.responseText.split("*");
				if(msg[0]!="error"){
					iziToast.success({
						message: 'Printing orders',						
						timeout: 2500,
					});		
					document.getElementById("payment-time").innerHTML = msg[2];
					document.getElementById("payment-date").innerHTML = msg[1];				
					document.getElementById("payment-table").innerHTML = msg[3];
					document.getElementById("payment-total-price").innerHTML = msg[4];
					document.getElementById("payment-total-top").innerHTML = msg[4];
					document.getElementById("payment-table-no").innerHTML = table;
					
					$("#payment-review").css({"display":"block"});
					$("#payment_review").click();
					$("#paymentText").val("");
					$("#payment-total-input").html("0.00");
					$("#payment-change").html("0.00");
					$("#paymentText").focus();
					$("#paymentText").select();	
				}
				else{
					iziToast.warning({
						title: 'Error',
						message: 'Please set up your printer!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
							
					
				//clearCart();
				//hideTable();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'queuePaymentDine'+"&table="+table, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function queuePaymentTakeout(){
	document.getElementById("takeout-print").classList.add("disabledbutton");
	document.getElementById("printTakeout-button").style.cursor = "no-drop";
	val = parseFloat("0").toFixed(2);
	document.getElementById("review-discount-takeout").innerHTML = val;	
	//document.getElementById('toggle-id-takeout').classList.remove("active");
	
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {
				msg = this.responseText.split("*");
				if(msg[0]!="error"){
					iziToast.success({
						message: 'Printing orders',						
						timeout: 2500,
					});		
					document.getElementById("takeout-time").innerHTML = msg[2];
					document.getElementById("takeout-date").innerHTML = msg[1];				
					document.getElementById("takeout-table").innerHTML = msg[3];
					document.getElementById("takeout-total-price").innerHTML = msg[4];
					document.getElementById("takeout-total-top").innerHTML = msg[4];

					$("#takeout-review").css({"display":"block"});
					$("#takeout_payment").click();
					$("#paymentTakeout").val("");
					$("#takeout-total-input").html("0.00");
					$("#takeout-change").html("0.00");
					$("#paymentTakeout").focus();
					$("#paymentText").select();	
				}
				else{
					iziToast.warning({
						title: 'Error',
						message: 'Please set up your printer!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
							
					
				//clearCart();
				//hideTable();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'queuePaymentTakeout', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function queueAdd(){
	//var table = document.getElementById("table-info-add").value;
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {	
							
				iziToast.success({
					message: 'Succesfully updated',						
					timeout: 2500,
				});	
				clearCart();
				hideTable();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'queueAdd', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function viewQueue(){
	
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {	
				document.getElementById("table-queue").innerHTML = this.responseText;
				/* $("#queue-tab").css({"display":"none"});
				$("#close-queue").hide(); */
				$("#queue-tab").animate( 
					{'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
				);	
				//$("#close-queue").fadeIn(1500);
				/* iziToast.success({
					message: 'Moved to queue',						
					timeout: 2500,
				});				
				clearCart();
				hideTable(); */
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewQueue', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function discountOrder(){
	code = document.getElementById('toggle-id').getAttribute('data-id');
	

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
			if(this.readyState == 4 && this.status == 200) {
				var value = document.getElementById('txtPayment').value;
				if(value==""){
					value = 0;
				}	
				value = parseFloat(value);				
				var msg = this.responseText.split("*");
				if(msg[0]=="discounted"){						
					document.getElementById("review-discount").innerHTML = msg[1];//parseFloat(msg[1]).toFixed(2);
					var discount = document.getElementById("review-discount").innerHTML;
					discount = parseFloat(discount.replace(',','').replace('.','.'));
					
					
					var total = document.getElementById("review-total").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var newTotal = (total - discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');//numberformat
					total = document.getElementById("review-total").innerHTML =  newTotal;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var value = parseFloat(value);
					//document.getElementById("pay-print").value = value;	
					if(value>0){
						//value = value.toFixed(2)
						//document.getElementById("review-payment").innerHTML = value;
						//total = document.getElementById("review-total").innerHTML;
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("review-change").innerHTML = change;								
					}
					/* else{
						value = parseFloat("0").toFixed(2);
						document.getElementById("review-payment").innerHTML = value;
						document.getElementById("review-change").innerHTML = value;
					} */
				}
				else{
					
					var newTotal = msg[1];
					total = document.getElementById("review-total").innerHTML =  newTotal;					
					var total = document.getElementById("review-total").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
						
					val = parseFloat("0").toFixed(2);
					document.getElementById("review-discount").innerHTML = val;	

					if(value>0){
						//alert();
						value = value.toFixed(2)
						document.getElementById("review-payment").innerHTML = value;
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("review-change").innerHTML = change;								
					}
					/* else{
						value = parseFloat("0").toFixed(2);
						document.getElementById("review-payment").innerHTML = value;
						document.getElementById("review-change").innerHTML = value;
					} */
														
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'discountOrder'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function discountPayment(){
	//code = document.getElementById('toggle-id').getAttribute('data-id');
	
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
			if(this.readyState == 4 && this.status == 200) {
				
				var value = document.getElementById('paymentText').value;
				if(value==""){
					value = 0;
				}	
				value = parseFloat(value);				
				var msg = this.responseText.split("*");				
				if(msg[0]=="discounted"){	
					//alert(msg[1]);
					document.getElementById("review-discount-payment").innerHTML = msg[1];//parseFloat(msg[1]).toFixed(2);
					var discount = document.getElementById("review-discount-payment").innerHTML;
					discount = parseFloat(discount.replace(',','').replace('.','.'));
					
					
					var total = document.getElementById("payment-total-price").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var newTotal = (total - discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					total = document.getElementById("payment-total-price").innerHTML =  newTotal;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var value = parseFloat(value);
					
					if(value>0){						
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("payment-change").innerHTML = change;								
					}
	
				}
				else{
					
					var newTotal = msg[1];
					
					total = document.getElementById("payment-total-price").innerHTML =  newTotal;					
					var total = document.getElementById("payment-total-price").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
						
					val = parseFloat("0").toFixed(2);
					document.getElementById("review-discount-payment").innerHTML = val;	

					if(value>0){					
						value = value.toFixed(2)
						document.getElementById("payment-total-input").innerHTML = value;
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("payment-change").innerHTML = change;								
					}
										
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'discountPayment', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function discountPaymentScID(){
	//code = document.getElementById('toggle-id').getAttribute('data-id');
	
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
			if(this.readyState == 4 && this.status == 200) {
				//alert(this.responseText);
				var msg = this.responseText.split("*");
				//alert(msg[0]);
				if(msg[0]=="0"){
					iziToast.warning({
						title: 'Error',
						message: 'Add more orders',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				else{
					var value = document.getElementById('paymentText').value;
					value = parseFloat(value);				
				//var msg = this.responseText.split("*");	
					document.getElementById("review-discount-payment").innerHTML = msg[1];//parseFloat(msg[1]).toFixed(2);
					var discount = document.getElementById("review-discount-payment").innerHTML;
					discount = parseFloat(discount.replace(',','').replace('.','.'));
					
					document.getElementById("payment-total-price").innerHTML =  msg[2];
					
					var total = document.getElementById("payment-total-price").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var newTotal = (total - discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					total = document.getElementById("payment-total-price").innerHTML =  newTotal;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var value = parseFloat(value);
					
					if(value>0){						
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("payment-change").innerHTML = change;								
					}
				}
				
				
	
				/* var value = document.getElementById('paymentText').value;
				if(value==""){
					value = 0;
				}	
				value = parseFloat(value);				
				var msg = this.responseText.split("*");				
				if(msg[0]=="discounted"){	
					//alert(msg[1]);
					document.getElementById("review-discount-payment").innerHTML = msg[1];//parseFloat(msg[1]).toFixed(2);
					var discount = document.getElementById("review-discount-payment").innerHTML;
					discount = parseFloat(discount.replace(',','').replace('.','.'));
					
					
					var total = document.getElementById("payment-total-price").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var newTotal = (total - discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					total = document.getElementById("payment-total-price").innerHTML =  newTotal;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var value = parseFloat(value);
					
					if(value>0){						
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("payment-change").innerHTML = change;								
					}
	
				}
				else{
					
					var newTotal = msg[1];
					
					total = document.getElementById("payment-total-price").innerHTML =  newTotal;					
					var total = document.getElementById("payment-total-price").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
						
					val = parseFloat("0").toFixed(2);
					document.getElementById("review-discount-payment").innerHTML = val;	

					if(value>0){					
						value = value.toFixed(2)
						document.getElementById("payment-total-input").innerHTML = value;
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("payment-change").innerHTML = change;								
					}
										
				} */
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'discountPaymentScID', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function discountPaymentTkScID(){
	
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
			if(this.readyState == 4 && this.status == 200) {
				var msg = this.responseText.split("*");
				if(msg[0]=="0"){
					iziToast.warning({
						title: 'Error',
						message: 'Add more orders',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				else{
					var value = document.getElementById('paymentTakeout').value;
					value = parseFloat(value);				
					document.getElementById("review-discount-takeout").innerHTML = msg[1];
					var discount = document.getElementById("review-discount-takeout").innerHTML;
					discount = parseFloat(discount.replace(',','').replace('.','.'));
					
					document.getElementById("takeout-total-price").innerHTML =  msg[2];
					
					var total = document.getElementById("takeout-total-price").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var newTotal = (total - discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					total = document.getElementById("takeout-total-price").innerHTML =  newTotal;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var value = parseFloat(value);
					
					if(value>0){						
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("takeout-change").innerHTML = change;								
					}
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'discountPaymentScID', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function discountPaymentReviewScID(){
	
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
			if(this.readyState == 4 && this.status == 200) {
				var msg = this.responseText.split("*");
				if(msg[0]=="0"){
					iziToast.warning({
						title: 'Error',
						message: 'Add more orders',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				else{
					var value = document.getElementById('txtPayment').value;
					value = parseFloat(value);				
					document.getElementById("review-discount").innerHTML = msg[1];
					var discount = document.getElementById("review-discount").innerHTML;
					discount = parseFloat(discount.replace(',','').replace('.','.'));
					
					document.getElementById("review-total").innerHTML =  msg[2];
					var total = document.getElementById("review-total").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var newTotal = (total - discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					total = document.getElementById("review-total").innerHTML =  newTotal;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var value = parseFloat(value);
					
					if(value>0){						
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("review-change").innerHTML = change;								
					}
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'discountPaymentReviewScID', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function discountPaymentPwdID(){
	
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
			if(this.readyState == 4 && this.status == 200) {
				var msg = this.responseText.split("*");
				if(msg[0]=="0"){
					iziToast.warning({
						title: 'Error',
						message: 'Add more orders',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				else{
					var value = document.getElementById('paymentText').value;
					value = parseFloat(value);				
					document.getElementById("review-discount-payment").innerHTML = msg[1];
					var discount = document.getElementById("review-discount-payment").innerHTML;
					discount = parseFloat(discount.replace(',','').replace('.','.'));
					
					document.getElementById("payment-total-price").innerHTML =  msg[2];
					
					var total = document.getElementById("payment-total-price").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var newTotal = (total - discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					total = document.getElementById("payment-total-price").innerHTML =  newTotal;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var value = parseFloat(value);
					
					if(value>0){						
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("payment-change").innerHTML = change;								
					}
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'discountPaymentPwdID', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function discountPaymentTkPwdID(){
	
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
			if(this.readyState == 4 && this.status == 200) {
				var msg = this.responseText.split("*");
				if(msg[0]=="0"){
					iziToast.warning({
						title: 'Error',
						message: 'Add more orders',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				else{
					var value = document.getElementById('paymentTakeout').value;
					value = parseFloat(value);				
					document.getElementById("review-discount-takeout").innerHTML = msg[1];
					var discount = document.getElementById("review-discount-takeout").innerHTML;
					discount = parseFloat(discount.replace(',','').replace('.','.'));
					
					document.getElementById("takeout-total-price").innerHTML =  msg[2];
					
					var total = document.getElementById("takeout-total-price").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var newTotal = (total - discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					total = document.getElementById("takeout-total-price").innerHTML =  newTotal;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var value = parseFloat(value);
					
					if(value>0){						
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("takeout-change").innerHTML = change;								
					}
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'discountPaymentPwdID', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function discountPaymentReviewPwdID(){
	
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
			if(this.readyState == 4 && this.status == 200) {
				var msg = this.responseText.split("*");
				if(msg[0]=="0"){
					iziToast.warning({
						title: 'Error',
						message: 'Add more orders',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				else{
					var value = document.getElementById('txtPayment').value;
					value = parseFloat(value);				
					document.getElementById("review-discount").innerHTML = msg[1];
					var discount = document.getElementById("review-discount").innerHTML;
					discount = parseFloat(discount.replace(',','').replace('.','.'));
					
					document.getElementById("review-total").innerHTML =  msg[2];
					var total = document.getElementById("review-total").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var newTotal = (total - discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					total = document.getElementById("review-total").innerHTML =  newTotal;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var value = parseFloat(value);
					
					if(value>0){						
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("review-change").innerHTML = change;								
					}
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'discountPaymentReviewPwdID', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function discountTakeout(){
	//code = document.getElementById('toggle-id').getAttribute('data-id');
	
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
			if(this.readyState == 4 && this.status == 200) {
				
				var value = document.getElementById('paymentTakeout').value;
				if(value==""){
					value = 0;
				}	
				value = parseFloat(value);				
				var msg = this.responseText.split("*");				
				if(msg[0]=="discounted"){						
					document.getElementById("review-discount-takeout").innerHTML = msg[1];//parseFloat(msg[1]).toFixed(2);
					var discount = document.getElementById("review-discount-takeout").innerHTML;
					discount = parseFloat(discount.replace(',','').replace('.','.'));
					
					
					var total = document.getElementById("takeout-total-price").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var newTotal = (total - discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					total = document.getElementById("takeout-total-price").innerHTML =  newTotal;
					total = parseFloat(total.replace(',','').replace('.','.'));
					var value = parseFloat(value);
						
					if(value>0){	
						//alert(value);
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("takeout-change").innerHTML = change;								
					}
	
				}
				else{
					
					var newTotal = msg[1];
					total = document.getElementById("takeout-total-price").innerHTML =  newTotal;					
					var total = document.getElementById("takeout-total-price").innerHTML;
					total = parseFloat(total.replace(',','').replace('.','.'));
						
					val = parseFloat("0").toFixed(2);
					document.getElementById("review-discount-takeout").innerHTML = val;	

					if(value>0){					
						value = value.toFixed(2)
						document.getElementById("takeout-total-input").innerHTML = value;
						var change = value - total;
						change = change.toFixed(2);
						document.getElementById("takeout-change").innerHTML = change;								
					}
										
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'discountTakeout', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function showQueue(code){
	//alert(code);
	val = parseFloat("0").toFixed(2);
	//document.getElementById("review-discount").innerHTML = val;	
	//document.getElementById('toggle-id').classList.remove("active");
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
				if(msg[0]=="Dine-in"){
					if(msg[9]>=1){
						document.getElementById("finish-order").classList.add("disabledbutton");
						document.getElementById("finish-order-button").style.cursor = "no-drop"
						$(".discount-button").css({"display":"block"});
					}
					else{
						document.getElementById("finish-order").classList.remove("disabledbutton");
						document.getElementById("finish-order-button").style.cursor = "default"
						$(".discount-button").css({"display":"none"});
						//document.getElementById("pay-print-button").style.cursor = "no-drop";
					}
					document.getElementById("pay-print").classList.add("disabledbutton");
					document.getElementById("pay-print-button").style.cursor = "no-drop";					
				
					document.getElementById("review-table-no").innerHTML = msg[1];
					document.getElementById("review-type").innerHTML = msg[0];				
					document.getElementById("review-table").innerHTML = msg[2];					
					document.getElementById("review-orderno").innerHTML = msg[3];
					document.getElementById("finish-order").setAttribute("name",msg[3]);
					document.getElementById("addOrder").setAttribute("name",msg[3]);
					document.getElementById("cancel-dine-in").setAttribute("name",msg[3]);
					//document.getElementById("print-dine-receipt").setAttribute("name",msg[3]);					
					document.getElementById("pay-print").setAttribute("name",msg[3]);
					//document.getElementById("toggle-id").setAttribute("data-id",msg[3]);
					// document.getElementById("review-date").innerHTML = msg[4];
					document.getElementById("review-date").innerHTML = msg[10];
					document.getElementById("review-hour").innerHTML = msg[11];
					document.getElementById("review-total").innerHTML = msg[5];
					document.getElementById("review-total-top").innerHTML = msg[5];					
					$("#modal-review").css({"display":"block"});
					$("#print_review").click();
					$("#txtPayment").val("");
					$("#review-payment").html("0.00");
					$("#review-discount").html("0.00");
					$("#review-change").html("0.00");
					$("#txtPayment").focus();
					$("#txtPayment").select();	
					if(parseInt(msg[9])>=1){
						/* document.getElementById("pay-print").classList.remove("disabledbutton");
						document.getElementById("pay-print-button").style.cursor = "pointer"; */
						document.getElementById("txtPayment").removeAttribute("readonly");
						
					}
					else{
						document.getElementById("pay-print").classList.add("disabledbutton");
						document.getElementById("txtPayment").setAttribute("readonly","true");
						document.getElementById("pay-print-button").style.cursor = "no-drop";
					}
				}
				else if(msg[0]=="Take-out"){					
					document.getElementById("take-out-type").innerHTML = msg[0];				
					document.getElementById("take-out-table").innerHTML = msg[1];
					document.getElementById("take-out-orderno").innerHTML = msg[2];
					document.getElementById("take-out-date").innerHTML = msg[3];
					document.getElementById("print-out-receipt").setAttribute("name",msg[2]);
					document.getElementById("pay-takeReceipt").setAttribute("name",msg[2]);
					document.getElementById("cancel-queue-out").setAttribute("name",msg[2]);
					document.getElementById("take-out-total").innerHTML = msg[4];
					document.getElementById("take-out-total-top").innerHTML = msg[4];					
					$("#modal-review-takeout").css({"display":"block"});					
					$("#takeout_review").click();
					$("#take-outPayment").val("");
					$("#take-out-payment").html("0.00");
					$("#take-out-change").html("0.00");
					$("#take-outPayment").focus();
					$("#take-outPayment").select();	
				}
				else{
					document.getElementById("delivery-type").innerHTML = msg[0];				
					document.getElementById("delivery-table").innerHTML = msg[1];
					document.getElementById("delivery-orderno").innerHTML = msg[2];
					document.getElementById("delivery-receipt").setAttribute("name",msg[2]);
					document.getElementById("cancel-queue-delivery").setAttribute("name",msg[2]);
					document.getElementById("delivery-date").innerHTML = msg[3];
					document.getElementById("delivery-total").innerHTML = msg[4];
					document.getElementById("delivery-name").innerHTML = msg[5];
					document.getElementById("delivery-address").innerHTML = msg[6];
					document.getElementById("delivery-contact").innerHTML = msg[7];
					/* document.getElementById("print-out-receipt").setAttribute("name",msg[2]);
					document.getElementById("pay-takeReceipt").setAttribute("name",msg[2]);
					document.getElementById("delivery-total").innerHTML = msg[4];
					document.getElementById("delivery-total-top").innerHTML = msg[4];		 */			
					$("#modal-delivery").css({"display":"block"});					
					$("#delivery_review").click();
					/* $("#txtDelivery").val("");
					$("#delivery-payment").html("0.00");
					$("#delivery-change").html("0.00");
					$("#txtDelivery").focus();
					$("#txtDelivery").select();	 */
				}
					
						//printReceipt($code);
			}
		};
		obj.open("GET","php/admin-php.php?action="+'showQueue'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function finishOrder(code){
	var cartQuantity = document.getElementById('cartQuantity').firstChild.data;
   
    var total = parseInt(cartQuantity) - 1;
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
			if(this.readyState == 4 && this.status == 200) {
				
				$("#queue-tab").animate( 
					{'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
				);	
				$(".close-modal-review").click();
				document.getElementById('cartQuantity').firstChild.data = "-"+1;
				$("#cartAnimate").animateCss('bounce');
					setTimeout(function(){
						document.getElementById('cartQuantity').firstChild.data = total;
				},1000);	
				iziToast.success({
					title: 'Successful',
					//message: 'Now printing...',				
					timeout: 3000,
				});	
				
	
			}
		};
		obj.open("GET","php/admin-php.php?action="+'finishOrder'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}	
}

function addOrder(code){
	document.getElementById("inputCustomer").style.display = "none";
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
			if(this.readyState == 4 && this.status == 200) {	
			/* 	iziToast.success({
					title: 'Successful',
					//message: 'Now printing...',				
					timeout: 3000,
				});	 */
				document.getElementById("table-no-add").innerHTML = this.responseText;
				document.getElementById("type-label").innerHTML = "Add order(s)";
				document.getElementById("table-add").style.display ="block";
				document.getElementById("id-available").style.display ="none";
				document.getElementById("queueDiv").classList.add("hidden");
				document.getElementById("resetDiv").classList.add("hidden");
				document.getElementById("divReset").classList.remove("hidden");
				document.getElementById("paymentDiv").classList.add("hidden");
				document.getElementById("payment-takeout-div").classList.add("hidden");
				document.getElementById("addDiv").classList.remove("hidden");
				document.getElementById("reserveDiv").classList.add("hidden");
				document.getElementById("customer-name").innerHTML = "";
				$("#queue-tab").animate( 
					{'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
				);	
				$(".close-modal-review").click();
			
			}
		};
		obj.open("GET","php/admin-php.php?action="+'addOrder'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}	
}

function cancelOrder(value){
	//alert(value);
	disableScrolling();	
	$('#cancelModal').modal('show');
	$("#cancelModalAnimate").animateCss('zoomIn');	

	var getType = value.substring(0, 3);	
	if(getType=="ORD"){
		$(".close-modal-review").click();
	}
	else if(getType=="DLV"){
		$(".close-modal-delivery").click();
	}
	else{
		$(".close-modal-review-takeout").click();
	}
	document.getElementById("confirmCancel").setAttribute("name",value);

	
}

function confirmCancelOrder(value){
	enableScrolling();
	$('#cancelModal').modal('hide');
	$("#cancelModalAnimate").animateCss('zoomOut');
	var cartQuantity = document.getElementById('cartQuantity').firstChild.data;
   
    var total = parseInt(cartQuantity) - 1;
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
			if(this.readyState == 4 && this.status == 200) {					
				
		/* 		if(this.responseText=="Dine-in"){
					$('#close-queue').click();
					$(".close-modal-review").click();
				}
				else if(this.responseText=="Take-out"){
					$('#close-queue').click();
					$(".close-modal-review-takeout").click();
				}
				else{
					$('#close-queue').click();
					$(".close-modal-delivery").click();
				} */
				$("#queue-tab").animate( 
					{'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
				);	
				document.getElementById('cartQuantity').firstChild.data = "-"+1;
				$("#cartAnimate").animateCss('bounce');
					setTimeout(function(){
						document.getElementById('cartQuantity').firstChild.data = total;
				},1000);	
				iziToast.success({
						title: 'Successful',
						//message: 'Now printing...',				
						timeout: 3000,
					});	
	
			}
		};
		obj.open("GET","php/admin-php.php?action="+'cancelOrder'+"&code="+value, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function printDinein(code){
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
			if(this.readyState == 4 && this.status == 200) {	
				iziToast.success({
						title: 'Successful',
						message: 'Now printing...',				
						timeout: 3000,
					});	
	
			}
		};
		obj.open("GET","php/admin-php.php?action="+'printDine'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function printDineReceipt(code,payment){
	//alert(code+" "+payment);	
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
				
				//alert("Success"); finish order
				if(this.responseText!="error"){
					iziToast.success({
						title: 'Successful',
						message: 'Now printing...',				
						timeout: 3000,
					});	
					//changeCartValues();
					$("#queue-tab").animate( 
						{'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
					);	
					$(".close-modal-review").click();
					//$("#payModal").modal("hide");
					//resetValue();
				}
				else{
					iziToast.warning({
						title: 'Error',
						message: 'Please set up your printer!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'printDineReceipt'+"&code="+code+"&payment="+payment, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function printPaymentDineReceipt(payment){
	var table = document.getElementById("table-info").value;
	var cartQuantity = document.getElementById('cartQuantity').firstChild.data;   
	var total = parseInt(cartQuantity) + 1;
	
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
				//alert("Success");
				// alert(this.responseText);
				if(this.responseText!="error"){												

					document.getElementById('cartQuantity').firstChild.data = "+"+1;
					$("#cartAnimate").animateCss('bounce');
						setTimeout(function(){
						document.getElementById('cartQuantity').firstChild.data = total;
					},1000);
					iziToast.success({
						title: 'Successful',
						message: 'Now printing...',				
						timeout: 3000,
					});	
					clearCart();
					$(".close-payment-review").click();
	
				}
				else{
					iziToast.warning({
						title: 'Error',
						message: 'Please set up your printer!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'printPaymentDineReceipt'+"&table="+table+"&payment="+payment, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function printPaymentTakeoutReceipt(payment){
	//var table = document.getElementById("table-info").value;
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
				//alert("Success");
				if(this.responseText!="error"){
					
					iziToast.success({
						title: 'Successful',
						message: 'Now printing...',				
						timeout: 3000,
					});	
					clearCart(); //insert sa summary
					$(".close-takeout-review").click();
	
				}
				else{
					iziToast.warning({
						title: 'Error',
						message: 'Please set up your printer!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'printPaymentTakeoutReceipt'+"&payment="+payment, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function printOutReceipt(code,payment){
	//alert(code+" "+payment);	
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
				//alert("Success");
				if(this.responseText!="error"){
					iziToast.success({
						title: 'Successful',
						message: 'Now printing...',				
						timeout: 3000,
					});	
					//changeCartValues();
					$("#queue-tab").animate( 
						{'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
					);
					$(".close-modal-review-takeout").click();
					//$("#payModal").modal("hide");
					//resetValue();
				}
				else{
					iziToast.warning({
						title: 'Error',
						message: 'Please set up your printer!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'printOutReceipt'+"&code="+code+"&payment="+payment, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}



function printTakeout(code){

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
			if(this.readyState == 4 && this.status == 200) {	
				iziToast.success({
						title: 'Successful',
						message: 'Now printing...',				
						timeout: 3000,
					});	
	
			}
		};
		obj.open("GET","php/admin-php.php?action="+'printTakeout'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function printDelivery(code){

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
			if(this.readyState == 4 && this.status == 200) {	
				iziToast.success({
						title: 'Successful',
						message: 'Now printing...',				
						timeout: 3000,
					});	
				$("#queue-tab").animate( 
						{'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
					);
				$(".close-modal-delivery").click();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'printDelivery'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function changeDineTotal(value){
	var total = document.getElementById("review-total").innerHTML;
	total = parseFloat(total.replace(',','').replace('.','.'));
	var value = parseFloat(value);
	document.getElementById("pay-print").value = value;	
	if(total<=value){
		document.getElementById("pay-print").classList.remove("disabledbutton");
		document.getElementById("pay-print-button").style.cursor = "default";
	}
	else{
		document.getElementById("pay-print").classList.add("disabledbutton");
		document.getElementById("pay-print-button").style.cursor = "no-drop";
	}
	if(value>0){		
		value = value.toFixed(2)
		document.getElementById("review-payment").innerHTML = value;
		var change = value - total;
		change = change.toFixed(2);
		document.getElementById("review-change").innerHTML = change;		
	}
	else{
		value = parseFloat("0").toFixed(2);
		document.getElementById("review-payment").innerHTML = value;
		document.getElementById("review-change").innerHTML = value;
	}
}

function changePaymentTotal(value){
	var total = document.getElementById("payment-total-price").innerHTML;
	total = parseFloat(total.replace(',','').replace('.','.'));
	var value = parseFloat(value);
	document.getElementById("payment-print").value = value;	
	//<!--button
	if(total<=value){
		document.getElementById("payment-print").classList.remove("disabledbutton");
		document.getElementById("printPayment-button").style.cursor = "cursor";
	}
	else{
		document.getElementById("payment-print").classList.add("disabledbutton");
		document.getElementById("printPayment-button").style.cursor = "no-drop";
	}
	//button-->
	if(value>0){		
		value = value.toFixed(2)
		document.getElementById("payment-total-input").innerHTML = value;
		var change = value - total;
		change = change.toFixed(2);
		document.getElementById("payment-change").innerHTML = change;		
	}
	else{		
		value = parseFloat("0").toFixed(2);
		document.getElementById("payment-total-input").innerHTML = value;
		document.getElementById("payment-change").innerHTML = value;
	}
	
	
}

function changePaymentTakeoutTotal(value){
	
	var total = document.getElementById("takeout-total-price").innerHTML;
	total = parseFloat(total.replace(',','').replace('.','.'));
	var value = parseFloat(value);
	//<!--button
	if(total<=value){
		document.getElementById("takeout-print").classList.remove("disabledbutton");
		document.getElementById("printTakeout-button").style.cursor = "cursor";
	}
	else{
		document.getElementById("takeout-print").classList.add("disabledbutton");
		document.getElementById("printTakeout-button").style.cursor = "no-drop";
	}
	document.getElementById("takeout-print").value = value;	
	if(value>0){
		value = value.toFixed(2)
		document.getElementById("takeout-total-input").innerHTML = value;
		var change = value - total;
		change = change.toFixed(2);
		document.getElementById("takeout-change").innerHTML = change;		
	}
	else{
		value = parseFloat("0").toFixed(2);
		document.getElementById("takeout-total-input").innerHTML = value;
		document.getElementById("takeout-change").innerHTML = value;
	}
}

function changeTakeoutTotal(value){
	var total = document.getElementById("take-out-total").innerHTML;
	total = parseFloat(total.replace(',','').replace('.','.'));
	var value = parseFloat(value);
	document.getElementById("pay-takeReceipt").value = value;
	if(value>0){
		value = value.toFixed(2)
		document.getElementById("take-out-payment").innerHTML = value;
		var change = value - total;
		change = change.toFixed(2);
		document.getElementById("take-out-change").innerHTML = change;
	}
	else{
		value = parseFloat("0").toFixed(2);
		document.getElementById("take-out-payment").innerHTML = value;
		document.getElementById("take-out-change").innerHTML = value;
	}
}

function queueTakeout(){	

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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {	
				iziToast.success({
					message: 'Moved to queue',						
					timeout: 2500,
				});				
				clearCart();
				hideTable();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'queueTakeout', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function ask(){
	disableScrolling();
	$('#clearModal').modal('show');
	$("#clearModalAnimate").animateCss('zoomIn');	
}

function delOrder(){
	$('#delModal').modal('hide');
	$("#delModalAnimate").animateCss('zoomOut');	
	cartMinus('0');
	
}
function removeOrder(value){
	disableScrolling();	
	$('#delModal').modal('show');
	$("#delModalAnimate").animateCss('zoomIn');		
	code = value;
		
}

function clearCart(){
	document.getElementById("inputCustomer").style.display = "none";
	document.getElementById("customer-name").innerHTML = "";
	enableScrolling();
	document.getElementById("queueDiv").classList.remove("hidden");
	document.getElementById("resetDiv").classList.remove("hidden");
	document.getElementById("divReset").classList.add("hidden");
	document.getElementById("paymentDiv").classList.remove("hidden");
	document.getElementById("payment-takeout-div").classList.add("hidden");
	document.getElementById("addDiv").classList.add("hidden");
	document.getElementById("reserveDiv").classList.add("hidden");
	$('#clearModal').modal('hide');
	$("#clearModalAnimate").animateCss('zoomOut');
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
		obj.onreadystatechange = function(){ 	//updateProduct;
			if(this.readyState == 4 && this.status == 200) {		
				document.getElementById("type-label").innerHTML = "Undefined";
				//document.getElementById('cartQuantity').firstChild.data = 0;
				hideTable();
				changeCartValues();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'clearCart', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function changeCartValues(){
	$('#cancelChk').css({"display":"none"});					 
	$('#delChk').css({"display":"none"});
	enableScrolling();
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
		obj.onreadystatechange = function(){ 	//changeCart;
			if(this.readyState == 4 && this.status == 200) {	
				msg = this.responseText.split("*");								
				document.getElementById("table-foods").innerHTML = 	msg[0];				
				document.getElementById("topay").innerHTML = 	msg[1];
				checkCart();
				//init();
			}
		};
		
		obj.open("GET","php/admin-php.php?action="+'viewCart', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function changeCartValuesDel(){
	if($("#cancelChk").css("display")=='none'){
		$('#cancelChk').css({"display":"block"});				
		$('#cancelChk').animateCss('flipInX');					 
		$('#delChk').css({"display":"block"});				
		$('#delChk').animateCss('flipInX');
		enableScrolling();
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
			obj.onreadystatechange = function(){ 	//changeCart;
				if(this.readyState == 4 && this.status == 200) {	
					msg = this.responseText.split("*");								
					document.getElementById("table-foods").innerHTML = 	msg[0];				
					document.getElementById("topay").innerHTML = 	msg[1];
					checkCart();
					//init();
				}
			};
			
			obj.open("GET","php/admin-php.php?action="+'viewCartDel', true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
	}
	else{
			
		changeCartValues();
		//$('#delChk').animateCss('flipInX');
	}
}

var xloc,yloc;
var url;
function init(){
	var tbody = document.getElementById("table-foods");
	var links = tbody.getElementsByTagName("td");
	for(x = 0 ; x < links.length ; x++){
		links[x].onclick = load;
	}
}

function load(qty,evt){
	
	var msg = qty.split(" ");
	quantity = msg[0];
	code = msg[1];
	disableScrolling();
	$("#qtyModal").modal("show");

	$("#txtQty").val(quantity);
	$("#txtQty").select();	
	document.getElementById("confirmUpdate").setAttribute("name",code);
}

function handleKeyPressCustomer(e){
 var key=e.keyCode || e.which;
 
  if (key==13){
	  var name = document.getElementById("txtCustomer").value;
	  if(name==""){
		iziToast.warning({
			message: 'Invalid name',
			backgroundColor: '#E16045',
			timeout: 2000,
		});
	  }
	  else{
		  $("#nameModal").modal("hide");
		  nameUpdate();
	  }
	 
  }
  
}

function handleKeyPressCustomerSC(e){
 var key=e.keyCode || e.which;
 
  if (key==13){
	  discountPaymentScID();
	  $("#scModal").modal("hide");
	  /*var name = document.getElementById("txtCustomer").value;
	  if(name==""){
		iziToast.warning({
			message: 'Invalid name',
			backgroundColor: '#E16045',
			timeout: 2000,
		});
	  }
	  else{
		  $("#nameModal").modal("hide");
		  nameUpdate();
	  }*/
	 
  }
  
}

function handleKeyPressCustomerPWD(e){
 var key=e.keyCode || e.which;
 
  if (key==13){
  	discountPaymentPwdID();
	$("#pwdModal").modal("hide");
  }
  
}

function handleKeyPressCustomerTkSC(e){
 var key=e.keyCode || e.which;
 
  if (key==13){
  	discountPaymentTkScID();
	$("#scTkModal").modal("hide");
  }
  
}

function handleKeyPressCustomerTkPWD(e){
 var key=e.keyCode || e.which;
 
  if (key==13){
  	discountPaymentTkPwdID();
	$("#pwdTkModal").modal("hide");
  }
  
}

function handleKeyPressCustomerReviewSC(e){
 var key=e.keyCode || e.which;
 
  if (key==13){
  	discountPaymentReviewScID();
	$("#scReviewModal").modal("hide");
  }
  
}

function handleKeyPressCustomerReviewPWD(e){
 var key=e.keyCode || e.which;
 
  if (key==13){
  	discountPaymentReviewPwdID();
	$("#pwdReviewModal").modal("hide");
  }
  
}

function handleKeyPress(e){
 var key=e.keyCode || e.which;
 var id = $("#confirmUpdate").attr("name");
  if (key==13){
	 $("#qtyModal").modal("hide");
     cartUpdate(id);
  }
  
}

function deleteChkbox(data){
	var formData = new FormData(document.getElementById(data));
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
			if(this.readyState == 4 && this.status == 200) {		
				//alert(this.responseText);
				changeCartValues();
			}
		};
		obj.open("POST","php/admin-php.php?action="+'deleteChkbox', true);
		obj.send(formData);
	}
	else{
		alert("Error");
	}
}

function cartUpdate(id){

	var code = id;
	var quantity = parseInt($("#txtQty").val());
	
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
			if(this.readyState == 4 && this.status == 200) {		
	
				changeCartValues();
			}
		};
		obj.open("GET","php/admin-php.php?action="+'updateProduct'+"&food_code="+code+"&quantity="+quantity, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
  
}
