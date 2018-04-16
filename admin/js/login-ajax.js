$loginJQ = jQuery.noConflict();


function handleKeyPress(e){
 var key=e.keyCode || e.which;
 
  if (key==13){
     signIn();
  }
  
}

function resetPass(){
	$('#alertModal').modal('hide');
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
					message: 'Username and Password have been reset successfully',						
					timeout: 2500,
				});
			};
		}
		obj.open("GET","php/admin-php.php?action="+'resetPass', true);
		obj.send(null);	
	}
	else{
		alert("Error");
	}
		
}

function checkLen(id){
	
	var inputVal = document.getElementById(id).value;
	var inputValLen = inputVal.length;
	
	var warning = "";
	
	if(id=="username"){
		warning = "#warning-user";
	}
	else{
		warning = "#warning-pass";
	}
	if(inputValLen>0){
		$loginJQ(warning).css({'visibility' : 'hidden'});
		document.getElementById(id).style.borderColor = "#ccc";
	}
	else{
		$loginJQ(warning).css({'visibility' : 'visible'});
		document.getElementById(id).style.borderColor = "red";
	}

}
function checkEnable(){
	user = document.getElementById('username').value;
	userLen = user.length;
	pass = document.getElementById('password').value;
	passLen = pass.length;

	if(userLen > 0 && passLen > 0){
		document.getElementById('btn-login').removeAttribute('disabled');
	}
	else{
		document.getElementById('btn-login').setAttribute('disabled','disabled');
	}

}

function signIn(){
	
	user = document.getElementById('username').value;
	pass = document.getElementById('password').value;
	
	userLen = user.length;
	passLen = pass.length;

	if(userLen<=0){
		$loginJQ('#warning-user').css({'visibility' : 'visible'});
		document.getElementById('username').style.borderColor = "red";
	}
	else{
		$loginJQ('#warning-user').css({'visibility' : 'hidden'});
		document.getElementById('username').style.borderColor = "#ccc";
	}
	if(passLen<=0){
		$loginJQ('#warning-pass').css({'visibility' : 'visible'});
		document.getElementById('password').style.borderColor = "red";
	}
	else{
		$loginJQ('#warning-pass').css({'visibility' : 'hidden'});
		document.getElementById('password').style.borderColor = "#ccc";
	}

	
	if(userLen > 0 && passLen > 0){
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
			obj.onreadystatechange = function(){ 	//obj.onreadystatechange = showContents;
				if(this.readyState == 4 && this.status == 200) {
					msg = this.responseText;
					if(msg=='user'){
						location.href = "index.php";
					}
					else{
						iziToast.warning({
						//title: 'Error',
						message: 'Invalid username or password!',
						backgroundColor: '#E16045',
						timeout: 2000,
					});	
					}
				}
			};
			obj.open("GET","php/admin-php.php?action="+'login'+"&username="+user+"&password="+pass, true); //obj.open("GET","php/index-php.php?username="+user+"&password="+pass, true);
			obj.send(null);
		}
		else{
			alert("Error");
		}
	}
	else{
		document.getElementById('btn-login').setAttribute('disabled','disabled');
	}
	

}