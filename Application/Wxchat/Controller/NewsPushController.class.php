<?php
//微信模块公共控制器
namespace Wxchat\Controller;
use Think\Controller;
use Vendor\WxPayPubHelper;

class NewsPushController extends Controller {
    
	public function index(){
		//获得参数 signature nonce token timestamp echostr
		$nonce     = $_GET['nonce'];
		$token     = 'zhiweitang';
		$timestamp = $_GET['timestamp'];
		$echostr   = $_GET['echostr'];
		$signature = $_GET['signature'];
		//形成数组，然后按字典序排序
		$array = array();
		$array = array($nonce, $timestamp, $token);
		sort($array);
		//拼接成字符串,sha1加密 ，然后与signature进行校验
		$str = sha1( implode( $array ) );
		if( $str  == $signature && $echostr ){
			//第一次接入weixin api接口的时候
			echo  $echostr;
			exit;
		}else{
			$this->reponseMsg();
		}
	}
	
	
	
	// 接收事件推送并回复
	public function reponseMsg(){
		//1.获取到微信推送过来post数据（xml格式）
		$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
		//2.处理消息类型，并设置回复类型和内容
		/*<xml>
		<ToUserName><![CDATA[toUser]]></ToUserName>
		<FromUserName><![CDATA[FromUser]]></FromUserName>
		<CreateTime>123456789</CreateTime>
		<MsgType><![CDATA[event]]></MsgType>
		<Event><![CDATA[subscribe]]></Event>
		</xml>*/
		$postObj = simplexml_load_string( $postArr );
		//$postObj->ToUserName = '';
		//$postObj->FromUserName = '';
		//$postObj->CreateTime = '';
		//$postObj->MsgType = '';
		//$postObj->Event = '';
		// gh_e79a177814ed
		//判断该数据包是否是订阅的事件推送
		if( strtolower( $postObj->MsgType) == 'event'){
			//如果是关注 subscribe 事件
			if( strtolower($postObj->Event == 'subscribe') ){
				//回复用户消息(纯文本格式)	
				$toUser   = $postObj->FromUserName;
				$fromUser = $postObj->ToUserName;
				$time     = time();
				$msgType  =  'text';
				
				$content  = '欢迎关注湖南介贷网！'."\n\n".'扫描介贷网槟榔产品内包装袋二维码获得积分，“累积分，得礼品”活动火热进行中！'."\n\n".'请随时关注醇品滋味公司投放的小礼品，可以扫码累积分哦！';
				$template = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>";
				$info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
				echo $info;
/*<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[你好]]></Content>
</xml>*/
			

			}
		}

		//当微信用户发送imooc，公众账号回复‘imooc is very good'
		/*<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[你好]]></Content>
</xml>*/
		/*if(strtolower($postObj->MsgType) == 'text'){
			switch( trim($postObj->Content) ){
				case 1:
					$content = '您输入的数字是1';
				break;
				case 2:
					$content = '您输入的数字是2';
				break;
				case 3:
					$content = '您输入的数字是3';
				break;
				case 4:
					$content = "<a href='http://www.imooc.com'>慕课</a>";
				break;
				case '英文':
					$content = 'imooc is ok';
				break;

			}	
				$template = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
//注意模板中的中括号 不能少 也不能多
				$fromUser = $postObj->ToUserName;
				$toUser   = $postObj->FromUserName; 
				$time     = time();
				// $content  = '18723180099';
				$msgType  = 'text';
				echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
			
		}
	}
*/
		//用户发送tuwen1关键字的时候，回复一个单图文
		if( strtolower($postObj->MsgType) == 'text' && trim($postObj->Content)=='tuwen' ){
			/* $toUser = $postObj->FromUserName;
			$fromUser = $postObj->ToUserName;
			$arr = array(
				array(
					'title'=>'imooc',
					'description'=>"imooc is very cool",
					'picUrl'=>'http://www.imooc.com/static/img/common/logo.png',
					'url'=>'http://www.imooc.com',
				),
				array(
					'title'=>'hao123',
					'description'=>"hao123 is very cool",
					'picUrl'=>'https://www.baidu.com/img/bdlogo.png',
					'url'=>'http://www.hao123.com',
				),
				array(
					'title'=>'qq',
					'description'=>"qq is very cool",
					'picUrl'=>'http://www.imooc.com/static/img/common/logo.png',
					'url'=>'http://www.qq.com',
				),
			);
			$template = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<ArticleCount>".count($arr)."</ArticleCount>
						<Articles>";
			foreach($arr as $k=>$v){
				$template .="<item>
							<Title><![CDATA[".$v['title']."]]></Title> 
							<Description><![CDATA[".$v['description']."]]></Description>
							<PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
							<Url><![CDATA[".$v['url']."]]></Url>
							</item>";
			}
			
			$template .="</Articles>
						</xml> ";
			echo sprintf($template, $toUser, $fromUser, time(), 'news'); */

			//注意：进行多图文发送时，子图文个数不能超过10个
		}else{
			switch( trim($postObj->Content) ){
				case "绑定商家号":
					$content = "您已经是知友会会员，若绑定商家号，您依然是知友会会员，但是将不能在“个人中心”查看积分和使用积分，只能查看商家兑换记录。\n若您解绑商家号后，您的积分依旧保留。\n您也可以选择使用其他微信号进行绑定。继续绑定，请回复“绑定”";
				break;
				case "绑定":
					$UserName   = $postObj->FromUserName;
					$redirect_uri = C('MERCHANT_BIND_URL')."/uname/".$UserName;
					$content = "您好，绑定商家号需先授权登录，点击这里<a href='".$redirect_uri."'>授权登录,绑定商家号</a>";
				break;
				
				case "解除绑定":
					$toUser   = $postObj->FromUserName;
					$result = M('business')->field('is_bind')->where("openid='".$toUser."'")->find();
					if($result['is_bind']>0){
						$redirect_uri = C('MERCHANT_UNBIND_URL');
						$content = "您好，解除绑定商家号，点击这里<a href='".$redirect_uri."'>解除绑定商家号</a>";
					}else{
						$content = $toUser;
					}
					
				break;
				default : exit; 
				
			}	
				$template = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				</xml>";
//注意模板中的中括号 不能少 也不能多
				$fromUser = $postObj->ToUserName;
				$toUser   = $postObj->FromUserName; 
				$time     = time();
				$msgType  = 'text';
				echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
			
		}//if end
	}//reponseMsg end

	function http_curl(){
		//1.初始化curl
		$ch = curl_init();
		$url = 'http://www.baidu.com';
		//2.设置curl的参数
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//3.采集
		$output = curl_exec($ch);
		//4.关闭
		curl_close($ch);

	}

	function getWxAccessToken(){
		//1.请求url地址
		$appid = 'wx08d5c2cb632bb5e4';
		$appsecret =  '06d3444fb9abd8d00314eb4a38ad61a8';
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
		//2初始化
		$ch = curl_init();
		//3.设置参数
		curl_setopt($ch , CURLOPT_URL, $url);
		curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
		//4.调用接口 
		$res = curl_exec($ch);
		//5.关闭curl
		curl_close( $ch );
		if( curl_errno($ch) ){
			var_dump( curl_error($ch) );
		}
		$arr = json_decode($res, true);
		var_dump( $arr );
	}

	function getWxServerIp(){
		$accessToken = "6vOlKOh7r5uWk_ZPCl3DS36NEK93VIH9Q9tacreuxJ5WzcVc235w_9zONy75NoO11gC9P0o4FBVxwvDiEtsdX6ZRFR0Lfs_ymkb8Bf6kRfo";
		$url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$accessToken;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$res = curl_exec($ch);
		curl_close($ch);
		if(curl_errno($ch)){
			var_dump(curl_error($ch));
		}
		$arr = json_decode($res,true);
		echo "<pre>";
		var_dump( $arr );
		echo "</pre>";


	}
 
	
}
