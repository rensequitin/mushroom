window.onload = changeDelivValue('all');
var val = "all";
var $ajaxJQ = jQuery.noConflict();
$ajaxJQ(document).ready(function(){
	$ajaxJQ('.tbody:first').css('display','table-header-group');
	
	
});
/* function changeValue(val){
	
	var val = document.getElementById("foodcategory").value;
	var tbody = document.getElementsByClassName('tbody');
	var len = tbody.length;
	
		for(var i=0; i<len;i++){
			var attrib = tbody[i].getAttribute('id');
			if(attrib != val){
				tbody[i].style.display = 'none';
				
			}
			else{					
				tbody[i].style.display = "table-header-group";
			}
		}
	 

	

} */



function view_orders(val){
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
				msg = this.responseText.split("*");
				document.getElementById('orderdetails').style.display='block';
				document.getElementById("table-data-order").innerHTML = msg[0];
				document.getElementById("buttons").innerHTML = msg[1];
				var classActive = document.getElementsByClassName('active')[0].getAttribute('seen');
				changeDelivValueActive(classActive);
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewTableOrders'+"&val="+val, true); //get-orders
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function deliverOrder(code){
	//alert(code);
	//alert(val);
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
		obj.onreadystatechange = function(){ //setOrder
			if(this.readyState == 4 && this.status == 200) {
				alert(this.responseText);
				document.getElementById('orderdetails').style.display='none';
				var classActive = document.getElementsByClassName('active')[0].getAttribute('seen');
				changeDelivValueActive(classActive);
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'deliverOrder'+"&val="+val+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function changeDelivValue(code){
	val = code;
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
		obj.onreadystatechange = function(){ //getDelivery
			if(this.readyState == 4 && this.status == 200) {
				document.getElementById("table-data").innerHTML = "";
				document.getElementById("spinner").style.display = "block";
				var msg = this.responseText.split("*");
				
				document.getElementById("next-table").innerHTML = msg[1];
				
				setTimeout(function(){
					document.getElementById("spinner").style.display = "none";
					document.getElementById("table-data").innerHTML = msg[0];
					alert(document.getElementById("table-data").getElementsByTagName("tr").length);
				}, 700);
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewDeliveryTable'+"&val="+val, true);
		obj.send(null);
	}
		/* obj.open("GET","php/get-delivery.php?val="+val, true);
		obj.send(null);
	} */
	else{
		alert("Error");
	}
	
}

function changeDelivValueCode(code){
	val = code;
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
		obj.onreadystatechange = function(){ //getDelivery
			if(this.readyState == 4 && this.status == 200) {
				document.getElementById("table-data").innerHTML = "";
				document.getElementById("spinner").style.display = "block";
				var msg = this.responseText.split("*");
				document.getElementById("next-table").innerHTML = msg[1];
				document.getElementById("table-data").innerHTML = msg[0];
				var tableData = document.getElementById("table-data").firstChild.innerHTML;
				
				if(tableData=="NO RECORD FOUND"){
					document.getElementById("table-data").innerHTML="";
					setTimeout(function(){
						document.getElementById("spinner").style.display = "none";
						document.getElementById("table-data").innerHTML = msg[0];
					}, 200);
				}
				else{
					document.getElementById("spinner").style.display = "none";
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewDeliveryTableByCode'+"&val="+val, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	
}

function changeDelivValueActive(active){
	
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
				document.getElementById("table-data").innerHTML = obj.responseText; //getDeliveryActive
			}
		};
		obj.open("GET","php/get-deliveryActive.php?val="+val+"&active="+active, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	

}



/* function getOrders(){
	if(obj.readyState==4 && obj.status==200){
		document.getElementById('orderdetails').style.display='block';
		msg = obj.responseText;
		values = msg.split("*");
		document.getElementById("table-data-order").innerHTML = values[0];
		document.getElementById("buttons").innerHTML = values[1];
		//alert(obj.responseText);
		//$ajaxJQ('#order-id').show(300);
		//$ajaxJQ('#table-data-order').show(200);
		//alert(val);
		var classActive = document.getElementsByClassName('active')[0].getAttribute('seen');
		changeDelivValueActive(val,classActive);
	}
	else{
		
		msgs = "Error "+ obj.status;
	}
	
} */



//var myVar;
/* function getDelivery(){
	if(obj.readyState==4 && obj.status==200){
		document.getElementById("table-data").innerHTML = "";
		document.getElementById("spinner").style.display = "block";
		var msg = obj.responseText;
		var value = msg.split("*");
		document.getElementById("next-table").innerHTML = value[1];
	
		myVar = setTimeout(function(){
		document.getElementById("spinner").style.display = "none";
		document.getElementById("table-data").innerHTML = value[0];
		
		}, 700);
		

	}
	else{
		
		msgs = "Error "+ obj.status;
	}
	
	
} */

/* function setOrder(){
	if(obj.readyState==4 && obj.status==200){
		//document.getElementById("table-data").innerHTML = obj.responseText;
		alert(obj.responseText);
		document.getElementById('orderdetails').style.display='none';
		var classActive = document.getElementsByClassName('active')[0].getAttribute('seen');
		changeDelivValueActive(classActive);
		
		//$ajaxJQ('#order-id').hide();
		//$ajaxJQ('#table-data-order').hide();
		//showTable();
	}
	else{
		
		msgs = "Error "+ obj.status;
	}
	
}  */




/* function getDeliveryActive(){
	if(obj.readyState==4 && obj.status==200){
		//alert(obj.responseText);
		document.getElementById("table-data").innerHTML = obj.responseText;
		

	}
	else{
		
		msgs = "Error "+ obj.status;
	}
	
	
} */