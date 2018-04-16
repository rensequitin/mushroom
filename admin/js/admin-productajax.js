window.onload = start;
var val = "sizzling";

$adminJQ = jQuery.noConflict();
function start(){
	viewProducts();
}
$adminJQ(document).ready(function(){
	$adminJQ("#file-attach").click(function(){
		$adminJQ("#upload-file").click();
	});
	$adminJQ('#upload-file').change(function(e) {
		if ($adminJQ(this).val() == '') {
			$adminJQ('#file-label').val("")   
		}
		else{
			var fileName = e.target.files[0].name;
			$adminJQ('#file-label').val(fileName);
		}        
	});	
	$adminJQ("#file-delete").click(function(){
		$adminJQ('#file-label').val("")   
		$adminJQ('#upload-file').val("")   
	});
	
	$adminJQ("#editphoto-close").click(function(){
		$adminJQ('#file-label').val("");
		$adminJQ('#upload-file').val("");
		$adminJQ("#editphoto").css({'display':'none'});
	});
	$adminJQ("#editphoto-close2").click(function(){
		$adminJQ('#file-label').val("");
		$adminJQ('#upload-file').val(""); 
		$adminJQ("#editphoto").css({'display':'none'});
	});	
});

function uploadPic(data){
	
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
				msg = this.responseText.split("*");
					//alert(msg[0]);
					
					if(msg[0]=="success"){
						document.getElementById("my-image").src = msg[1];
						document.getElementById("user_photo").src = msg[1];
						document.getElementById("file-label").value = "";
						document.getElementById("upload-file").value = "";
						document.getElementById('editphoto').style.display = "none";
						document.getElementById('success').style.display = "block";
						showAlert('.modal-content-alert');
						//window.location.reload();
					}
					else{
						document.getElementById('editphoto').style.display = "none";
						document.getElementById('invalid').style.display = "block";
						showAlert('.modal-content-alert');
					}
			}
		};
		obj.open("POST","php/user-php.php?action="+'saveImage', true);
		obj.send(formData);
	}
	else{
		alert("Error");
	}
	

}

function viewProducts(){
	category = $adminJQ("#foodcategory option:selected").val();
	stat = $adminJQ("#foodstatus option:selected").val();
	val = category;
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
				
				document.getElementById("next-table").innerHTML = msg[1];
				
				setTimeout(function(){
					document.getElementById("spinner").style.display = "none";
					document.getElementById("table-data").innerHTML = msg[0];
				}, 400);
			}
		};
		obj.open("GET","php/admin-php.php?action="+'viewProducts'+"&category="+category+"&status="+stat, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	

}