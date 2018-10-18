<?php
//微信模块公共控制器
namespace Wxchat\Controller;
use Think\Controller;
use Vendor\WxPayPubHelper;

class CommonController extends Controller {
    
    public $baseUser=array(); 

	public function _initialize(){
	
		//把当前网址存起来
		$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		session('returnurl',$url);
		
		//$url = "http://iu16692198.iok.la/Wxchat/Product/Qrcode/myqcode/EEC15721525489103CAC73FB93246850";
		//$this->JsApi_pub($url);		//调用微信网页授权方法
    
	}

	//授权登录
	public function JsApi_pub($redirect_uri,$type){

		import("Org.WxPayPubHelper.WxPayPubHelper");
		
		$jsApi = new \JsApi_pub();

		if (!isset($_GET['code']))
		{
		
			$url = $jsApi->createOauthUrlForCode($redirect_uri);
			Header("Location: $url"); 
		}else
		{
			$code = $_GET['code'];
			$jsApi->setCode($code);
			$data = $jsApi->getOpenId();
			$user_info=$jsApi->get_user_info($data['access_token'],$data['openid']);
			$wx_result = json_decode($user_info,true);//获取微信返回用户信息的结果集
			
			if($wx_result['openid'] != ''){
				session('openId',$wx_result['openid']);
			}
			$openid = session('openId');
			$result = M('custom')->where("openid='".$openid."'")->find();//根据openid查询这个用户是否存在

			if($result){
				session('new_user',1001);
				session('userid',$result['user_id']);
				session('nickname',$result['nickname']);
				session('headimgurl',$result['headimgurl']);
				return $openid;
			}else{
				$custom=M('custom');
				$data = array(
					'nickname'  => $wx_result['nickname'],
					'openid'    => $wx_result['openid'],
					'realname'  => $wx_result['realname'],
					'sex'	    => $wx_result['sex'],
					'addtime'	=> time(),
					'status'	=> 1,
					'city'	    => $wx_result['city'],
					'province'  => $wx_result['province'],
					'country'   => $wx_result['country'],
					'headimgurl'=> $wx_result['headimgurl'],
					'regcome'	=> $type
					);
				
				$rs = $custom->add($data);
				session('new_user',1000);//新用户标示
				session('userid',$rs);//用户ID
				session('nickname',$wx_result['nickname']);
				session('headimgurl',$wx_result['headimgurl']);
				return $openid;
			}
			
		}
		
		
	}
 
	
}