window.onload = start;

function start(){
	view_alert();
}

$(document).ready(function(){
	$("#file-attach").click(function(){
		$("#upload-file").click();
	});
	$('#upload-file').change(function(e) {
		if ($(this).val() == '') {
			$('#upload-file').val(""); 
			
		}
		else{
			var fileName = e.target.files[0].name;			
			$("#add-button").click();
			//uploadDatabase('form-data');
			//$('#file-label').val(fileName);
		}        
	});	

});

function uploadDatabase(data){
	//alert(data);
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
	var formData = new FormData(document.getElementById(data));
	if(obj){
		obj.onreadystatechange = function(){ 	//showImage;
			if(this.readyState == 4 && this.status == 200) {		
					
					if(this.responseText=="success"){
						/* iziToast.success({
							title: 'Success',
							message: 'Successful',
							timeout: 2000,
						}); */
					/* 	$('#file-label').val("");
						$('#upload-file').val(""); */
						/* setTimeout(function(){
							location.href = window.location.href;
						},500);		 */			
						$('#upload-file').val("");
						location.href = window.location.href;
					}
					else{
						iziToast.warning({
							title: 'Warning',
							message: this.responseText,
							backgroundColor: '#E16045',
							timeout: 3000,
						});	
					}
			}
		};
		obj.open("POST","php/admin-php.php?action="+'uploadDatabase', true);
		obj.send(formData);
	}
	else{
		alert("Error");
	}
	

}

function uploadToFolderRestore(data){
		
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
				//alert(this.responseText);
				msg = this.responseText;
				restoreDatabase(msg);
			}
		};
		obj.open("GET","php/admin-php.php?action="+'uploadToFolderRestore'+"&data="+data, true);
		obj.send();
	}
	else{
		alert("Error");
	}
}

function restoreDatabase(name){
	//var formData = new FormData(document.getElementById(data));
	
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
				//alert(this.responseText);
				location.href = window.location.href;
			}
		};
		obj.open("GET","php/admin-php.php?action="+'restoreDatabase'+"&name="+name, true);
		obj.send();
		//obj.send(formData);
	}
	else{
		alert("Error");
	}
}

function uploadToFolderCloud(data){
		
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
				//alert(this.responseText);
				msg = this.responseText;
				sendToCloud(msg);
			}
		};
		obj.open("GET","php/admin-php.php?action="+'uploadToFolderCloud'+"&data="+data, true);
		obj.send();
	}
	else{
		alert("Error");
	}
}

function sendToCloud(name){
	//var formData = new FormData(document.getElementById(data));
		
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
				alert(this.responseText);
			}
		};
		obj.open("GET","php/admin-php.php?action="+'sendToCloud'+"&name="+name, true);
		obj.send();
		//obj.send(formData);
	}
	else{
		alert("Error");
	}
}

function deleteFile(data){
	$("#delModal").modal("show");
	$("#confirmDel").attr("name",data);
}

function confirmDeleteFile(data){
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
				location.href = window.location.href;
			}
		};
		obj.open("GET","php/admin-php.php?action="+'deleteFile'+"&data="+data, true);
		obj.send();
	}
	else{
		alert("Error");
	}
}

function view_alert(){
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
				
				if(this.responseText=="save"){
					iziToast.success({
						title: 'Backup completed successfully',
						//message: 'Now printing...',				
						timeout: 3000,
					});	
				}
				else if(this.responseText=="del"){
					iziToast.success({
						title: 'Successful',
						//message: 'Now printing...',				
						timeout: 3000,
					});	
				}
				else if(this.responseText=="add"){
					iziToast.success({
						title: 'Successful',
						//message: 'Now printing...',				
						timeout: 3000,
					});	
				}
				else if(this.responseText=="import"){
					iziToast.success({
						title: 'Database restored successfully',			
						timeout: 3000,
					});	
				}
				else if(this.responseText=="send"){
					iziToast.success({
						title: 'Backup sent successfully',			
						timeout: 3000,
					});	
				}
				
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewAlert', true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}
