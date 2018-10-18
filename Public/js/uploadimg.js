function checkfile(size,imgid){

	var maxsize = size*1024*1024;//最大
	var errMsg = "上传的附件文件不能超过"+size+"M！！！";
	var tipMsg = "您的浏览器暂不支持计算上传文件的大小，确保上传文件不要超过"+size+"M，建议使用IE、FireFox、Chrome浏览器。";
	var  browserCfg = {};
	var ua = window.navigator.userAgent;
	if (ua.indexOf("MSIE")>=1){
		browserCfg.ie = true;
	}else if(ua.indexOf("Firefox")>=1){
		browserCfg.firefox = true;
	}else if(ua.indexOf("Chrome")>=1){
		browserCfg.chrome = true;
	}

	try{
		var obj_file = document.getElementById(imgid);
		var fileTArr= document.getElementById(imgid).value.toLowerCase().split(".");
		var filetype=fileTArr[fileTArr.length-1];

		if(obj_file.value==""){
			//alert("请先选择上传文件");
			return true;
		}
		if(!/(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(filetype))
		{
			alert("文件类型必须是.gif,jpeg,jpg,png中的一种");
			return false;
		}
		var filesize = 0;
		if(browserCfg.firefox || browserCfg.chrome ){
			filesize = obj_file.files[0].size;  //如果用jquery是obj_file[0]
		}else if(browserCfg.ie){
			var obj_img = document.getElementById(imgid);
			obj_img.dynsrc=obj_file.value;
			filesize = obj_img.fileSize;
		}else{
			alert(tipMsg);
			return;
		}
		if(filesize==-1){
			alert(tipMsg);
			return;
		}else if(filesize>maxsize){
			alert(errMsg);
			return;
		}else{
			//alert("文件大小符合要求");
			return true;
		}
	}catch(e){
		alert(e);
	}
}

