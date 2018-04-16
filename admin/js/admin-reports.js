window.onload = start;

function start(){
	//view_table();
}

function changeSales(){
	//alert(value);
	value = $("#reservation").val();
	category = $("#reports_category option:selected").val();
	//alert(category);
	val = value.split("-");
	//alert(val[0]);
	valStart = val[0].split("/");
	yr1 = valStart[2].substring(2,4);
	salesStart = yr1+valStart[0]+valStart[1];
	
	valEnd = val[1].split("/");
	yr2 = valEnd[2].substring(2,4);
	valEnd[0] = valEnd[0].substring(1,3);
	salesEnd = yr2+valEnd[0]+valEnd[1];
	
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
				document.getElementById("sales-table").innerHTML = msg[0];			
				document.getElementById("sales-total").innerHTML = msg[1];
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewSalesReport'+"&salesStart="+salesStart+"&salesEnd="+salesEnd+"&category="+category, true);//viewCompletedOrders
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
				document.getElementById("orders-table").innerHTML = this.responseText;			
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewCompletedOrders', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}
