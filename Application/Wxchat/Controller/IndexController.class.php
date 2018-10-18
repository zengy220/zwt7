<?php
//微信首页控制器 
namespace Wxchat\Controller;
use Wxchat\Controller;
class IndexController extends CommonController{
    public function index(){
		
		$redirect_uri = C('ORDER_URL');			//商家绑定地址
		
		$openid = $this->JsApi_pub($redirect_uri);		//调用微信网页授权方法,获取用户openid
		
		$nowId = session('userid');
	   
		$returnurl=session("returnurl");
		//获取完用户信息 跳回之前的页面
		if(isset($returnurl)&&!empty($returnurl))
		{ 
			session("returnurl",null);
			header("Refresh:3;url=".$returnurl);
			exit;
		}
	   
		$result1 = M('custom')->where('user_id='.$nowId)->find();
		$result2 = M('business')->where('user_id='.$nowId)->find();	
		//如果是用户，跳转到个人中心
		if($result1 && empty($result2)){
			Header('Location:/Wxchat/Product/member_center'); 
			exit;
		}
		//如果查询到时商户，跳转到扫码页面
		if($result2){
			Header('Location:/Wxchat/Business/exchange_goods'); 
			exit;
		}
	
	
    }
   


}

	
	
	
	
	
	
	
	
	
	
	
	
?>	