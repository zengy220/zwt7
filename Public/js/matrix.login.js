function check(){
	var un = $("#username").val(),
		pw = $("#password").val();
	
	if(un == ''){
		$(".error-login span").html("请输入账号");
		$(".error-login").css("display","block");
		return false;
	}else if(pw == ''){
		$(".error-login span").html("请输入密码");
		$(".error-login").css("display","block");
		return false;
	}else{
		$(".error-login span").css("display","none");
		return true;
	}
	
}