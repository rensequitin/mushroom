/* $(document).everyTime("1s", function() {	
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
				msg =  this.responseText.split("*");
				document.getElementById('menu').innerHTML = msg[0];
				document.getElementById('label-message').innerHTML = msg[1];
				document.getElementById('header').innerHTML = msg[2];
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewMessage', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
		
},0); */


$(document).everyTime("1s", function() {	
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
				document.getElementById('date-label').innerHTML = this.responseText;
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewDateIndex', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
		
},0);