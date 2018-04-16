window.onload = changeDelivHistory('');
var val;
var $adminJQ = jQuery.noConflict();
$adminJQ(document).ready(function(){
	$adminJQ('.tbody:first').css('display','table-header-group');
	
	
});

function changeDelivHistory(code){
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
				document.getElementById("table-data").innerHTML = "";
				document.getElementById("spinner").style.display = "block";
				var msg = this.responseText.split("*");
				
				document.getElementById("next-table").innerHTML = msg[1];
				
				setTimeout(function(){
					document.getElementById("spinner").style.display = "none";
					document.getElementById("table-data").innerHTML = msg[0];
				}, 400);
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewDeliveredOrder'+"&code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	


}
