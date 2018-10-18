$(document).ready(function(){
	
	//添加菜单处选择一级目录时的JS
	$("#relation_Id").change(function(){
		var v = $("#relation_Id").val();
		var m = $("#menu_url");
		if(v == 0){
			m.val('');
			$(".control-single").hide();
		}else{
			$(".control-single").show();
		}
	});
	
	
	
});