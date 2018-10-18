/*JQuery 限制文本框只能输入数字*/
        $("#phone").keyup(function () {
            $(this).val($(this).val().replace(/\D|^0/g, ''));
        }).bind("paste", function () {  //CTR+V事件处理   
            $(this).val($(this).val().replace(/\D|^0/g, ''));
        }).css("ime-mode", "disabled"); //CSS设置输入法不可用   
        /*JQuery 限制文本框只能输入数字和小数点*/
        $("#phone").keyup(function () {
            $(this).val($(this).val().replace(/[^0-9.]/g, ''));
        }).bind("paste", function () {  //CTR+V事件处理   
            $(this).val($(this).val().replace(/[^0-9.]/g, ''));
        }).css("ime-mode", "disabled"); //CSS设置输入法不可用       

   	$("#busi-submit-btn").click(function()
   	{
      if ($("#sq-people").val() == "") {
                $("#sq-people").focus();
                $("#sq-people").nextAll("b").show();
                return false;
            }
      else{
      	 $("#sq-people").nextAll("b").hide();
           }

       if ($("#aq-area").val() == "") {
                $("#aq-area").focus();
                $("#aq-area").nextAll("b").show();
                return false;
            }
        else{
      	 $("#aq-area").nextAll("b").hide();
           }
 	    checkphone();
         if ($("#s_province").val() == "选择省份") {
                $("#s_province").focus();
                $("#s_province").nextAll("b").show();
                return false;
            }
         else{
      	 $("#s_province").nextAll("b").hide();
           }
         if ($("#s_city").val() == "选择城市") {
                $("#s_city").focus();
                $("#s_city").nextAll("b").show();
                return false;
            }
         else{
      	 $("#s_county").nextAll("b").hide();
           }
         if ($("#s_county").val() == "选择区/县") {
                $("#s_county").focus();
                $("#s_county").nextAll("b").show();
                return false;
            }
         else{
      	 $("#s_county").nextAll("b").hide();
           }
			if ($("#address").val() == "") {
                $("#address").focus();
                 $("#address").nextAll("b").show();
                return false;
            }
			 else{
      	   $("#address").nextAll("b").hide();
           }
			if ($("#reason").val() == "") {
                $("#reason").focus();
                $("#reason").nextAll("b").show();
                return false;
            }
			 else{
      	   $("#reason").nextAll("b").hide();
          }
var formParam = $("#form1").serialize();
		jQuery.ajax({
		url:'/Web/about/join_us',
		data:formParam,
		type:"POST",
		success:function(e)
		{
			if(e==1)
		{
		    //清空resText里面的所有内容
		   $("#business-box").append(tishihtml);
		   setTimeout(function () {
            $(".busi-tihis").remove();
            $("#form1")[0].reset();
          }, 2000);
		  }
		else{
			alert("提交出错")
		}
		}
		});
		return false;
		});

 
   $(".checkwp").blur(function(){
   	if($(this).val() == ""||$(this).val()=="选择省份"||$(this).val()=="选择城市"||$(this).val()=="选择区/县")
   	{
            $(this).nextAll("b").show();
            return false;
      	}
      	else{
      		$(this).nextAll("b").hide();
      	}
   })
   $("#phone").blur(function(){
   	checkphone();
   })
   function checkphone(){
    var phone = $("#phone").val();
   	var telReg = !!phone.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/);
	if(phone==''){
	$("#phone").nextAll("b").show();
	$("#phone").nextAll("b").html("请填写手机号码！");
	return false;
	}else if(telReg==false){
	$("#phone").nextAll("b").show();
	$("#phone").nextAll("b").html("请输入正确的手机号！");
	return false;
	}
	else{
	$("#phone").nextAll("b").hide();	
	}
	}
   var tishihtml='<div class="busi-tihis bdrd5 tc">您的资料已提交成功!</div>'
   function tjsuccess(){	
// 	$("#business-box").append(tishihtml)
// 	setTimeout($("#form1").submit(),5000)
    
   }
