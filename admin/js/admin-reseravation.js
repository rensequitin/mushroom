window.onload = start;

function start(){
	view_table();
}

function searchProducts(code){
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

function view_orders(code){
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
			
			if(obj){
				obj.onreadystatechange = function(){
					if(this.readyState==4 && this.status==200){					
						msg = this.responseText.split("*");			
						
						if(msg[0]=="Delivery"){
							document.getElementById("review-table").innerHTML = msg[1];
							document.getElementById("review-orderno").innerHTML = msg[2];
							//document.getElementById("accept-delivery").setAttribute("name",msg[2]);
							document.getElementById("review-date").innerHTML = msg[3];
							document.getElementById("review-total").innerHTML = msg[4];					
							document.getElementById("review-name").innerHTML = msg[5];
							document.getElementById("review-address").innerHTML = msg[6];
							document.getElementById("review-contact").innerHTML = msg[7];
							document.getElementById("review-type").innerHTML = msg[0];
							$('#modal-orders').css({"display":"block"});
							$("#show_orders").click();
						}
						else{
							document.getElementById("dinein-table").innerHTML = msg[1];
							document.getElementById("dinein-orderno").innerHTML = msg[2];
							document.getElementById("dinein-date").innerHTML = msg[3];
							document.getElementById("dinein-total").innerHTML = msg[4];		
							//document.getElementById("accept-dinein").setAttribute("name",msg[2]);
							document.getElementById("dinein-type").innerHTML = msg[0];
							$('#modal-dinein').css({"display":"block"});
							$("#show_dinein").click();
						}
						
						/* document.getElementById("accept-print").setAttribute("name",msg[1]);
						document.getElementById("accept-print").setAttribute("value",msg[4]); */
					
						//printReceipt($code);
					}
				};
				obj.open("GET","php/admin-php.php?action="+'reviewPendingOrders'+"&code="+code, true);
				obj.send(null);
			}
			else{
				alert("Error");
			}
			
	
}

function disableScrolling(){
	var x=window.scrollX;
	var y=window.scrollY;
	window.onscroll=function(){window.scrollTo(x, y);};
}

function enableScrolling(){
	window.onscroll=function(){};
}

function ask(code){
	code = code;	
	document.getElementById("archive-button").setAttribute("name",code);
	disableScrolling();
	$('#alertModal').modal('show');
	$("#alertModalAnimate").animateCss('zoomIn');	
}

function closeAlert(){
	enableScrolling();
	$('#alertModal').modal('hide');
	$("#alertModalAnimate").animateCss('zoomOut');
}

function archiveOrder(code){
	
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
					title: 'Successful',			
					timeout: 3000,
				});				
				view_table();
				closeAlert();
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'archiveOrder'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function view_table(){
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
				//document.getElementById("orders-table").innerHTML = this.responseText;	
				document.getElementById("orders-table").innerHTML = "";
				document.getElementById("spinner").style.display = "block";
				//var msg = this.responseText.split("*");
				
				//document.getElementById("next-table").innerHTML = msg[1];
				var msg = this.responseText;
				setTimeout(function(){
					document.getElementById("spinner").style.display = "none";
					document.getElementById("orders-table").innerHTML = msg;
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
					//alert(document.getElementById("table-data").getElementsByTagName("tr").length);
				}, 400);				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewReservation', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}
