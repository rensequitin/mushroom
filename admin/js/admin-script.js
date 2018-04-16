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
				msg = this.responseText.split("*");
				document.getElementById('hour-label').innerHTML = msg[0];
				document.getElementById('date-label').innerHTML = msg[1];
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewDate', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
		
},0);

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
				document.getElementById('sales-label').innerHTML = this.responseText;
				var len = document.getElementById('sales-label').innerHTML.length;
			/* 	if(len>=5 && len < 7){
					document.getElementById('sales-label').style.fontSize = '3.0em';
				}
				if(len==7){						
					document.getElementById('sales-label').style.fontSize = '2.5em';
				}
				if(len>=8 && len < 10){						
					document.getElementById('sales-label').style.fontSize = '2em';
				} */
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewSales', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
		
},0);	

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
				document.getElementById('orders-label').innerHTML = this.responseText;
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewOrders', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
		
},0);
	
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
				document.getElementById('users-label').innerHTML = this.responseText;
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewUsers', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
		
},0);
	
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
		
},0);
	//Menu-icon > Close-icon
/* function myFunction(className) {    
	//className.classList.toggle("change");
}

var $adminJQ = jQuery.noConflict();
	//Change theme color
$adminJQ(document).ready(function(){
	
	$adminJQ("#color1").on("click", function(){$adminJQ(".navbar").css("background", "#F1C40F");$adminJQ('thead').css("background", '#F1C40F');$adminJQ('.user-header').css("background", '#F1C40F'); changeColor('F1C40F');})
	$adminJQ("#color2").on("click", function(){$adminJQ(".navbar").css("background", "#E74C3C");$adminJQ('thead').css("background", '#E74C3C');$adminJQ('.user-header').css("background", '#E74C3C'); changeColor('E74C3C');})
	$adminJQ("#color3").on("click", function(){$adminJQ(".navbar").css("background", "#9B59B6");$adminJQ('thead').css("background", '#9B59B6');$adminJQ('.user-header').css("background", '#9B59B6'); changeColor('9B59B6');})
	$adminJQ("#color4").on("click", function(){$adminJQ(".navbar").css("background", "#3498DB");$adminJQ('thead').css("background", '#3498DB');$adminJQ('.user-header').css("background", '#3498DB'); changeColor('3498DB');})
	$adminJQ("#color5").on("click", function(){$adminJQ(".navbar").css("background", "#FF5733");$adminJQ('thead').css("background", '#FF5733');$adminJQ('.user-header').css("background", '#FF5733'); changeColor('FF5733');})
	$adminJQ("#color6").on("click", function(){$adminJQ(".navbar").css("background", "#FFA07A");$adminJQ('thead').css("background", '#FFA07A');$adminJQ('.user-header').css("background", '#FFA07A'); changeColor('FFA07A');})
	$adminJQ("#color7").on("click", function(){$adminJQ(".navbar").css("background", "#2E7D32");$adminJQ('thead').css("background", '#2E7D32');$adminJQ('.user-header').css("background", '#2E7D32'); changeColor('2E7D32');})
	$adminJQ("#color8").on("click", function(){$adminJQ(".navbar").css("background", "#AFB42B");$adminJQ('thead').css("background", '#AFB42B');$adminJQ('.user-header').css("background", '#AFB42B'); changeColor('AFB42B');})
	$adminJQ("#color9").on("click", function(){$adminJQ(".navbar").css("background", "#607D8B");$adminJQ('thead').css("background", '#607D8B');$adminJQ('.user-header').css("background", '#607D8B'); changeColor('607D8B');})
	
	
	function changeColor(color){
		
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
				}
			};
			obj.open("GET","php/admin-php.php?action="+'changeColor'+"&newColor="+color, true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
	}
})


	//Animation for admin profile
$adminJQ(document).ready(function(){
	TriggerClick = 0;
	$adminJQ("#menu-toggle").click(function(){
		if(TriggerClick==0){
			 TriggerClick=1;
			 $adminJQ("#idimg").animate({width:'43px',left: '153px'}, 200);
 
		}else{
			 TriggerClick=0;
			 $adminJQ("#idimg").animate({width:'35%',left: '0px'}, 400);
 
			};
		});
	});

	// SIDEBAR
$adminJQ(document).ready(function(){
    $adminJQ("#menu-toggle").click(function(e) {
        e.preventDefault();
        $adminJQ("#wrapper").toggleClass("toggled");
    });
	
	//MESSAGE
	
	$adminJQ('#icon-message').click(function(){
		var stat = $adminJQ('.messages-menu .dropdown-menu').css("display");
		if(stat!="block"){
			$adminJQ('.dropdown-menu').css({'display': 'none'});
			$adminJQ('.messages-menu .dropdown-menu').css({'display': 'block'});
		}
		else{
			$adminJQ('.messages-menu .dropdown-menu').css({'display': 'none'});
		}
		return false;	
		
	});
	$adminJQ('#user-menu').click(function(){
		var stat = $adminJQ('.user-menu .dropdown-menu').css("display");
		if(stat!="block"){
			$adminJQ('.dropdown-menu').css({'display': 'none'});
			$adminJQ('.user-menu .dropdown-menu').css({'display': 'block'});
		}
		else{
			$adminJQ('.user-menu .dropdown-menu').css({'display': 'none'});
		}
		return false;	
		
	});
	$adminJQ('body').click(function(evt){    

          
       //For descendants of menu_content being clicked, remove this check if you do not want to put constraint on descendants.
		if(!$adminJQ(evt.target).closest('.messages-menu').length){
			$adminJQ('.messages-menu .dropdown-menu').css({'display': 'none'});
		}
		if(!$adminJQ(evt.target).closest('.user-menu').length){
			$adminJQ('.user-menu .dropdown-menu').css({'display': 'none'});
		}
	   
                  

      //Do processing of click event here for every element except with id menu_content

	});
	
	//NEXT TABLE
	$adminJQ('.next').on('click',function(){
		var currentTd = $adminJQ('td.active');
		
		var activeTable = currentTd.attr('seen');
		var currentLabel = $adminJQ('label.active');
		var next = parseInt(activeTable);
		next++;
		
		var nextTable = $adminJQ('td[seen='+next+']');
		
		if(nextTable.length){
			currentTd.removeClass('active').css('display, none');
			nextTable.addClass('active').css('display, block');
			
			currentLabel.removeClass('active');
			$adminJQ('label[val='+next+']').addClass('active');
			
			$adminJQ('label').removeAttr('id');
			$adminJQ('label[val='+next+']').attr('id','active');
			var prevLabel = $adminJQ('label[val='+next+']').prev();
			var nextLabel = $adminJQ('label[val='+next+']').next();
			if(prevLabel.length){
				prevLabel.attr('id','active');
			}
			if(nextLabel.length){
				nextLabel.attr('id','active');
			}
		}
		
	});
	
	$adminJQ('.prev').on('click',function(){
		var currentTd = $adminJQ('td.active');
		var activeTable = currentTd.attr('seen');
		var currentLabel = $adminJQ('label.active');
		var next = parseInt(activeTable);
		next--;
	
		var nextTable = $adminJQ('td[seen='+next+']');
		
		if(nextTable.length){
			currentTd.removeClass('active').css('display, none');
			nextTable.addClass('active').css('display, block')
			
			currentLabel.removeClass('active');
			$adminJQ('label[val='+next+']').addClass('active');
			
			$adminJQ('label').removeAttr('id');
			$adminJQ('label[val='+next+']').attr('id','active');
			var prevLabel = $adminJQ('label[val='+next+']').prev();
			var nextLabel = $adminJQ('label[val='+next+']').next();
			if(prevLabel.length){
				prevLabel.attr('id','active');
			}
			if(nextLabel.length){
				nextLabel.attr('id','active');
			}
		}
	});
	
	$adminJQ('#next-table').on('click','label',function(){
		var val = $adminJQ(this).attr('val');
		var currentTd = $adminJQ('td.active');
		var activeTable = currentTd.attr('seen');
		var currentLabel = $adminJQ('label.active');
		
		var nextTable = $adminJQ('td[seen='+val+']');
		
		if(nextTable.length){
			currentTd.removeClass('active').css('display, none');
			nextTable.addClass('active').css('display, block')
			
			currentLabel.removeClass('active');
			$adminJQ('label[val='+val+']').addClass('active')
			
			$adminJQ('label').removeAttr('id');
			$adminJQ('label[val='+val+']').attr('id','active');
			var prevLabel = $adminJQ('label[val='+val+']').prev();
			var nextLabel = $adminJQ('label[val='+val+']').next();
			if(prevLabel.length){
				prevLabel.attr('id','active');
			}
			if(nextLabel.length){
				nextLabel.attr('id','active');
			}
			
			
		}
		
	});

	
});


$adminJQ(document).ready(function(){
	$adminJQ(document).everyTime("1s", function() {	
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
			obj.onreadystatechange = checkNotify;
			obj.open("GET","php/check-delivery.php", true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
		
	},0);
	
	$adminJQ(document).everyTime("1s", function() {	
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
					document.getElementById('hour-label').innerHTML = msg[0];
					document.getElementById('date-label').innerHTML = msg[1];
				}
			};
			obj.open("GET","php/admin-php.php?action="+'viewDate', true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
		
	},0);
	
	$adminJQ(document).everyTime("1s", function() {	
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
					document.getElementById('sales-label').innerHTML = this.responseText;
					var len = document.getElementById('sales-label').innerHTML.length;
					if(len>=5 && len < 7){
						document.getElementById('sales-label').style.fontSize = '3.0em';
					}
					if(len==7){						
						document.getElementById('sales-label').style.fontSize = '2.5em';
					}
					if(len>=8 && len < 10){						
						document.getElementById('sales-label').style.fontSize = '2em';
					}
				}
			};
			obj.open("GET","php/admin-php.php?action="+'viewSales', true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
		
	},0);
	
	$adminJQ(document).everyTime("1s", function() {	
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
					document.getElementById('orders-label').innerHTML = this.responseText;
				}
			};
			obj.open("GET","php/admin-php.php?action="+'viewOrders', true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
		
	},0);
	
	$adminJQ(document).everyTime("1s", function() {	
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
					document.getElementById('users-label').innerHTML = this.responseText;
				}
			};
			obj.open("GET","php/admin-php.php?action="+'viewUsers', true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
		
	},0);
	
	$adminJQ(document).everyTime("1s", function() {	
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
		
	},0);
	
	function checkNotify(){
		if(obj.readyState==4 && obj.status==200){
			msg = obj.responseText;
			var audio = document.getElementById("myAudio"); 
			if(msg!=0){
				
				//audio.play();
				 setTimeout(function(){
					
				}, 2500);
				//alert(msg);
			}
			
		}
		else{
			
			msgs = "Error "+ obj.status;
		}	
	}
	
	
}); */

function signout(){
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
					location.href = window.location.href;
				}
			};
			obj.open("GET","php/admin-php.php?action="+'logout', true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
}

