/* $(document).ready(function(){
 
  $( '#bio > div' ).hide();  
  
  //$('#bio > div:first').show();
  
  $('#bio h3').click(function() {
    $(this).next().animate( 
	    {'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
    );
  });
}); */

/* $(document).ready(function(){ //admin-users.php
 
  //$( '#animateDiv' ).hide();  
  
  //$('#bio > div:first').show();
  
  $('#bio > h3').click(function() {
	  //alert();
    $("#animateDiv").animate( 
	    {'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
    );
  });
}); */

$(document).ready(function(){ 
  
  $('#add-product').click(function() {	 
	$("#editProductAnimate").css({"display":"none"});
	$("#addProductAnimate").css({"display":"none"});
    $("#addProductAnimate").animate( 
	    {'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
    );
	$("#food-category-input").val("");
	$("#food-name-input").val("");
	$("#food-price-input").val("");
  });
  
  $('#cancel-product').click(function() {	
	$("#editProductAnimate").css({"display":"none"});
    $("#addProductAnimate").animate( 
	    {'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
    );
	$("#food-category-input").val("");
	$("#food-name-input").val("");
	$("#food-price-input").val("");
  });
  
   $('#add-food').click(function() {	 
	$("#editProductAnimate").css({"display":"none"});
	$("#addProductAnimate").css({"display":"none"});
    $("#addProductAnimate").animate( 
	    {'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
    );
	$("#food-code-input").val("");
	$("#food-name-input").val("");
	$("#food-price-input").val("");
  });
  
  $('#cancel-food').click(function() {	
	$("#editProductAnimate").css({"display":"none"});
    $("#addProductAnimate").animate( 
	    {'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
    );
	$("#food-code-input").val("");
	$("#food-name-input").val("");
	$("#food-price-input").val("");
  });
  
  
  $('#cancel-edit').click(function() {	 
	$("#addProductAnimate").css({"display":"none"});
    $("#editProductAnimate").animate( 
	    {'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
    );
  });
 /*  $('#close-queue').click(function() {	 
	$(this).hide();
    $("#queue-tab").animate( 
	    {'height':'toggle','width':'toggle'}, 'slow', 'easeOutSine'
    );
  }); */
});



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