window.onload = viewProducts('allday');
var val = "allday";


function viewProducts(category){
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
		obj.onreadystatechange = showProduct;
		obj.open("GET","php/show-foods.php?category="+category, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
	

}

function showProduct(){
	if(obj.readyState==4 && obj.status==200){
		document.getElementById("table-data").innerHTML = obj.responseText;
		

	}
	else{
		
		msgs = "Error "+ obj.status;
	}
	
	
}

function viewFoods(code){
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
		obj.onreadystatechange = editFood;
		obj.open("GET","php/edit-foods.php?code="+code, true);
		obj.send(null);
	}
	else{
		alert("Error");
	}
}

function editFood(){
	if(obj.readyState==4 && obj.status==200){
		//alert(obj.responseText);
		document.getElementById("form-data2").style.display = "block";
		document.getElementById("form-data").innerHTML = obj.responseText;
		

	}
	else{
		
		msgs = "Error "+ obj.status;
	}
	
	
}

function changePic(event){
	
	/* var formData = new FormData();  // using XMLHttpRequest2
    var fileInput = document.getElementById('foodPic');
    var file = fileInput.files;
    formData.append("uploadfile", file);
	request.send(formData);
	alert(formData);
	
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
		obj.onreadystatechange = changeImg;
		obj.open("POST","php/get-image.php", true);
		obj.send(formData);
	}
	else{
		alert("Error");
	} */
	
/* 	var file_data = $('#sortpicture').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    alert(form_data);    */ 
	
	 selectedFile = event.target.files[0];
	 //alert(a);
	 var reader = new FileReader();
	 var imgtag = document.getElementById("foodPic");
	 imgtag.title = selectedFile.name;
	 alert(imgtag.title);
	 reader.onload = function(event) {
		imgtag.src = event.target.result;
	  };
	 //alert(imgtag.title);
	// document.getElementById("foodPic").src = 'foods/'+imgtag.title;
	 reader.readAsDataURL(selectedFile);
	 //imgtag.src = event.target.result;
	  
	 //reader.readAsDataURL(selectedFile);
	//alert(val);
	//pic = val.split("/");
	//alert(pic);
	//document.getElementById("foodPic").src = val;
	
}

function changeImg(){
	if(obj.readyState==4 && obj.status==200){
		alert(obj.responseText);
		//document.getElementById("form-data2").style.display = "block";
		//document.getElementById("form-data").innerHTML = obj.responseText;
		

	}
	else{
		
		msgs = "Error "+ obj.status;
	}
}