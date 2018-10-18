<?php
namespace Wxchat\Controller;
use Wxchat\Controller;
class ProductController extends CommonController {
	
	public function index(){

	}
	
/**
* $data 传入的参数数组
* @作用：生成供URL传递的参数
*/
    public function get_param(){
		$data = array(
			'id'=>'208',
			'mch_billno'=>'20170810164220',//订单号
			'total_amount'=>'1.01',//红包金额
			'total_num'=>'1',//红包数量
			
		);
		$data['sign']   = $this->getSign($data);//签名
		$result = $this->url_parameter($data);
		echo  $result;
	}

	public function url_parameter($data){
		$arr = urlencode(json_encode($data));
		return $arr;
	}
	
	public function getSign($data)
	{
		foreach ($data as $k => $v)
		{
			$Parameters[$k] = $v;
		}
		//签名步骤一：按字典序排序参数
		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		//echo '【string1】'.$String.'</br>';
		//签名步骤二：在string后加入KEY
		$String = $String."&key=trans5@w0rld";//key值建议从配置文件读取，方便更换
		//echo "【string2】".$String."</br>";
		//签名步骤三：MD5加密
		$String = md5($String);
		//echo "【string3】 ".$String."</br>";
		//签名步骤四：所有字符转为大写
		$result_ = strtoupper($String);
		//echo "【result】 ".$result_."</br>";
		return $result_;
	}
	
	function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v)
		{
		    if($urlencode)
		    {
			   $v = urlencode($v);
			}
			//$buff .= strtolower($k) . "=" . $v . "&";
			$buff .= $k . "=" . $v . "&";
		}
		$reqPar;
		if (strlen($buff) > 0) 
		{
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}

	public function Qrcode(){
		header("Content-type:text/html;charset=utf-8");
		$myqcode = I('get.myqcode');//接收二维码参数
		$e_code  = I('get.e_code');
		$e_token = I('get.e_token');
		
		//1.验证二维码的正确性，是否是属于官方定义的二维码，然后查询该二维码是否已被扫描，如果没有扫描则进行下一步
		//2.验证通过之后查询相关的规则表进行规则匹配。
		//3.匹配成功之后进行数据的写入，然后跳转至扫码成功页面
		//4.任何人进行扫码动作都可以进行抽奖匹配，包括商家。
		//5.登录时要判断用户是属于商家还是消费者，如果是商家则拥有两个选项，如果是消费者则只显示一个选项（可以在common里面进行判断）
		
		$redirect_uri = C('SCAN_CODE_URL').$myqcode.'/e_code/'.$e_code.'/e_token/'.$e_token;
		
		$openid = $this->JsApi_pub($redirect_uri,1);		//调用微信网页授权方法
		//$openid = 'o0XhFtxJ7BcLLJZdeUM-gcTESQmU';		//调用微信网页授权方法
		
		$userid = session('userid');
		
		$where['user_id'] = $userid;
		$where['openid'] = $openid;
		
		$userInfo = M('custom')->where($where)->find(); //获取用户个人信息

		if( $userInfo['status'] == 0 ){
			
			//账户被禁用
 			echo "<h2 style='background:#eee;color:orange;font-size:3em;text-align:center;'>您的账户涉嫌违规已被禁用,请联系客服!</h2>";
			echo "<h2 style='background:#eee;color:orange;font-size:3em;text-align:center;'>客服电话0731-99558742</h2>";
			exit;
		}
		
		$res = $this->verify_code($myqcode,$e_code,$e_token);
		
		$msg = '';
		
		if( $res == 901){
			$msg = '二维码不正确';
		}else{
			
			if( $res['RuleStatus'] == 0 ){
				$msg = '该码段已经被停用！';//
				
			}else{
				
				if( $res['Type_astrict']== 1 ){
					$Rel = M('code_record')->field('id')->where( array('user_id'=>$userid,'code_en'=>$e_code ) )->find();
				
					if( $Rel != null ) $msg = '该二维码已被扫描！仅首次扫描可获取奖品。';
				
				}elseif( $res['Type_astrict']== 2 ){
					$Rel = M('code_record')->field('id')->where( array('code_en'=>$e_code ) )->find();
					if( $Rel != null ) $msg = '该二维码已被扫描！仅首次扫描可获取奖品。';
					
				}
				
			}

			if($Rel['id'] != null){
				//进行中奖匹配
				$get_prize = $this->good_luck($myqcode,$e_code);//获取中奖ID,返回一个数组
				//1.获取中奖ID之后，遍历中奖ID

				if( count($get_prize) > 0 ){
					$store_prize = $this->store_prize($get_prize,$e_code);
				}else{
					$store_prize = '999';
				}
			}
dump($store_prize);
			$store_prize = urlencode(json_encode($store_prize));
			
			//header('Location:/Wxchat/Product/scan_result/data/'.$store_prize);
			
		}

		
	}
	
//跳转至个人中心页面
	private function data_skip($store_prize,$msg,$userInfo){
		
	}
	
	
	//进行抽奖匹配之后，将该数组各值写入数据库
	private function store_prize($arr,$e_code){
		//1.如果抽到积分，需更新用户积分，存储积分获取记录。
		//2.如果抽取到现金则需要调动现金接口
		//3.需要往扫码记录表里面写一条记录
		
		$str = implode(',',$arr);
		
		$code_classify = M('code_classify as a')->field('a.Classify_Id,a.Prize_id,a.Rule_Id,a.Classify_resource,Prize_type')->join('LEFT JOIN `cs_code_prize` as b ON a.Prize_id=b.Prize_id')->where(array('Classify_Id'=>array('in',$str)))->select();
		$sum_integral = '';//获取的总积分数
		$sum_money = '';//获取的总现金数
		$nowId = session('userid');
		$time  = time();
		$Model = M('custom');
		$userPoints = $Model->field('points')->where('user_id='.$nowId)->find();//查询用户的信息

 		$Model->startTrans();//开启事务
		
		$recordSql_1 .= "INSERT INTO `cs_code_record` (user_id,time,point,rule_id,Prize_id,type,code_en) value ";
		$recordSql_2 .= "INSERT INTO `cs_code_record` (user_id,time,point,rule_id,Prize_id,type,code_en) value ";
		foreach($code_classify as $key=>$val){
			
			//抽取到积分需要插入三个数据表 1.更新积分，2.写入日志记录，3.写入扫码记录
			if( $val['Prize_type'] == 1 ){
				//1.写入扫码记录
				$recordSql_1 .= "('".$nowId."','".$time."','".$val['Classify_resource']."','".$val['Rule_Id']."','".$val['Prize_id']."',". 1 .",'".$e_code."'),";//插入扫码记录sql
				
				$sum_integral += $val['Classify_resource'];//获得的总积分
				
			}elseif( $val['Prize_type'] == 2 ){
				//1.写入扫码记录
				$recordSql_2 .= "('".$nowId."','".$time."','".$val['Classify_resource']."','".$val['Rule_Id']."','".$val['Prize_id']."',". 2 .",'".$e_code."'),";//插入扫码记录sql
				
				$sum_money += $val['Classify_resource'];//获得的总现金
				
			}

		}
		
		$change_point = $userPoints['points'] + $sum_integral;//变更后的积分
		$recordSql_1 = rtrim($recordSql_1, ",");//插入扫码记录sql
		$recordSql_2 = rtrim($recordSql_2, ",");//插入扫码记录sql
		

		if( $nowId!=null && $e_code!=null && $sum_integral>0 && $change_point>0 ){
			$integSql = "INSERT INTO `cs_integ_log` (user_id,code_en,point,change_point,type,change_type,time)value($nowId,'$e_code',$sum_integral,'$change_point',1,4,$time)";//插入积分日志表sql
			
			$integ_res = M()->query($integSql);//插入积分日志表
			
		}

		if($sum_integral > 0){//如果抽取的积分大于0;
			$cus_res = $Model->where('user_id='.$nowId)->setInc('points',$sum_integral); // 更新用户表的积分数
			$res_1 = M()->query($recordSql_1);//插入积分记录
			
		}

		if($sum_money > 0){//如果抽取的总现金大于0;
			$res_2 = M()->query($recordSql_2);//插入现金记录
			
		}
		
		$data['point'] = !empty($sum_integral) ? $sum_integral : NULL;
		$data['money'] = !empty($sum_money) ? $sum_money : NULL;
		

		if( ($sum_integral>0 && $res_1>0 && $cus_res>0 ) || ( $sum_money>0 && $res_2>0 ) ){

			$Model->commit();
			if( $sum_money>0 && $res_2>0 ){
				//1.需要在此处调用发送红包的接口
				//$this->sendRedpack();
			}
			return $data;
		}else{

			$Model->rollback();
			return false;
		}
		
		
	}
	
//发送红包接口
	private function sendRedpack($order_number)
    {
        //调用请求接口基类
        $Redpack = new \Redpack_pub();
        
        //$openid = session('openId');
        //商户订单号
        $Redpack->setParameter('mch_billno', $order_number);
        //提供方名称
        $Redpack->setParameter('nick_name', "gaoyl101");
        //商户名称
        $Redpack->setParameter('send_name', "介贷网");
        //用户openid
		//$Redpack->setParameter('re_openid', "o0XhFtxJ7BcLLJZdeUM-gcTESQmU");
        //付款金额
        $Redpack->setParameter('total_amount', 100);//需要传入
        //最小红包金额
        $Redpack->setParameter('min_value', 100);
        //最大红包金额
        $Redpack->setParameter('max_value', 100);
        //红包发放总人数
        $Redpack->setParameter('total_num', 1);
        //红包祝福语
        $Redpack->setParameter('wishing', "现金红包教程祝大家写代码快乐");
        //活动名称
        $Redpack->setParameter('act_name', "现金红包教程");
        //备注
        $Redpack->setParameter('remark', "现金红包教程祝大家写代码快乐");
        //以下是非必填项目
        //子商户号  
//         $Redpack->setParameter('sub_mch_id', $parameterValue);
//        //商户logo的url
//         $Redpack->setParameter('logo_imgurl', $parameterValue);
//         //分享文案
//         $Redpack->setParameter('share_content', $parameterValue);
//         //分享链接
//         $Redpack->setParameter('share_url', $parameterValue);
//         //分享的图片
//         $Redpack->setParameter('share_imgurl', $parameterValue);
        

        
        $result = $Redpack->sendRedpack();
        
        return $result;
    }
	
//生成订单号方法
	private function produce_order_number(){
		$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
		$orderSn = $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
		echo $orderSn;
	}

	//中奖方法
	private function good_luck($myqcode,$e_code){
		
		$code_prize = M('code_prize')->where(array('Rule_Id'=>$myqcode))->select();//查询扫码即中的奖项
		//dump($code_prize);
		
		$arr = array();
		
		foreach($code_prize as $key=>$val){
			
			if( $val['Prize_condition']==1 ){
				$temp = array();//声明一个空数组
				
				$code_classify = M('code_classify')->where(array('Prize_id'=>$val['Prize_id']))->select();

				foreach( $code_classify as $k=>$v ){
					$temp[ $v['Classify_Id'] ] = $v['Classify_probability'];//将中奖几率存到之前声明的数组当中
					
				}
				$classify_id = $this->random($temp);
				if( $classify_id > 0 ){
					//说明抽中奖了
					$arr[] = $classify_id;
					
				}

				unset($code_prize[$key]);
				break;
				
			}


		}
		
		//打乱接下来数组的顺序
		shuffle($code_prize);
		
		foreach( $code_prize as $ko=>$vo ){
			$temp = array();//声明一个空数组
		
			$code_classify = M('code_classify')->where(array('Prize_id'=>$vo['Prize_id']))->select();

			foreach( $code_classify as $k=>$v ){
				$temp[ $v['Classify_Id'] ] = $v['Classify_probability'];//将中奖几率存到之前声明的数组当中
				
			}
			
			$classify_id = $this->random($temp);

			if( $classify_id > 0 ){
				//说明抽中奖了
				$arr[] = $classify_id;

			} 
			
		}
		
		return $arr;
		
	}
	
	
	
	
/**
 * 全概率计算
 *
 * @param array $p array('a'=>0.5,'b'=>0.2,'c'=>0.4)
 * @return string 返回上面数组的key
 */
	private function random($ps){
		
		static $arr = array();
	
		$key = md5(serialize($ps));
	
		if (!isset($arr[$key])) {
			$max = array_sum($ps);
			
			 if( $max !== 100 ){
				$remainder = 100 - $max;
				$ps[0] = strval($remainder);

			}
			
			foreach ($ps as $k=>$v) {
				for ($i=0; $i<$v; $i++) $arr[$key][] = $k;
			}
		}
		
		return $arr[$key][mt_rand(0,count($arr[$key])-1)];
	}


	
//验证二维码正确性,验证二维码是否重复扫描
	private function verify_code($myqcode,$e_code,$e_token){
		
		//验证二维码正确性,不正确901
		$test_code = $this->create_secret_key($myqcode,$e_code);
		if( $test_code !== $e_token ){
			return 901;exit;//加密码段不正确返回901
		}
		
		$test_code_repetition = $this->verify_code_repetition($myqcode,$e_code);
		
		return $test_code_repetition;
		
	}

//生成秘钥
	private function create_secret_key($myqcode,$e_code){
		$secretToken = md5($myqcode.C('TOKEN').$e_code);
		return $secretToken;//返回加密字符串
	}

	
//获取二维码信息
	private function verify_code_repetition($myqcode,$e_code){
		
		$where['a.Rule_Id'] = $myqcode;
		$where['CodeStart'] = array('elt',$e_code);
		$where['CodeEnd'] = array('egt',$e_code);
		
		$rel =  M('code_rule as a')->field('a.Rule_Id,a.Type_id,a.StartTime,a.EndTime,a.CodeStart,a.CodeEnd,a.RuleStatus,c.Type_num,c.Type_explain,c.Type_astrict')->join('LEFT JOIN `cs_code_type` as c ON a.Type_id = c.Id')->where($where)->find();
		
		return $rel;
		
	}
	

	
	
	//扫码成功页面 ->个人中心
	public function scan_result(){
		$nowPoints = isset($_GET['points'])?$_GET['points']:'0';
		$nowId = session('userid');
		$userInfo = M('custom')->where('user_id='.$nowId)->find();
		$this->assign('addtime',$userInfo['addtime']);//用户注册时间
		
		$msg="该码已被扫描，仅首次扫码可得积分"; //消息提示

		//做活动的商品的信息
		$activeInfo = M('active_gift')->field('id,type_id,name,points,imagePath')->where('is_active=1')->select();

		$this->assign('nowPoints',$nowPoints);//当前扫描获得积分
		$this->assign('msg',$msg);//传递扫码结果信息
		$this->assign('activeInfo',$activeInfo);//参与活动的商品的信息
		$this->assign('userPoints',$userInfo['points']);//消费的积分
		$this->assign('nickname',$userInfo['nickname']);//消费者的微信昵称
		$this->assign('headimgurl',$userInfo['headimgurl']);//消费者的微信头像地址
		$this->display();
	}

	//扫码成功页面 ->会员中心
	public function member_center(){
		
		$redirect_uri = C('MERCHANT_PERSONAL_CENTER');			//商家绑定地址
		$openid = $this->JsApi_pub($redirect_uri);	
		
		
		//echo '会员中心';
		$nowId = session('userid');
		$where = array(
				'openid' => $this->userInfo['openid'],
				'regcome' => 0
				);
		$res = M('custom')->where($where)->count();
		if (!$res) {
			$data = array(
				'user_id' => $nowId,
				'regcome' => 2
			);
			M('custom')->save($data);
		}
		$userInfo = M('custom')->where('user_id='.$nowId)->find();
		$activeInfo = M('active_gift')->field('id,type_id,name,points,imagePath')->where('is_active=1')->select();

		$this->assign('activeInfo',$activeInfo);
		$this->assign('points',$userInfo['points']);
		$this->assign('nickname',$userInfo['nickname']);
		$this->assign('headimgurl',$userInfo['headimgurl']);
		$this->display();
	}

	
	//查看消费者自己的积分明细
	public function Integral_record(){
		$nowId = session('userid');
		
		$recordInfo = M('code_record')->field('gift_id,user_id,time,point')->where('user_id='.$nowId)->select();//查询扫码记录
		
		$exchangeInfo = M('gift_exchange_record')->field('gettime,points,name,business_id,busi_id')->where('user_id='.$nowId.' && status=2')->select();//查询兑换记录
		
		$i = 0;
		$newArr = array();
		$k = 0;
		while (true) {
			if ($recordInfo[$i] == NULL && $exchangeInfo[$i] == NULL) {
				break;
			} else {
				if ($recordInfo[$i] != NULL) {
					$t = date('Y年m月',$recordInfo[$i]['time']);
					$newArr[$t][$k]['type'] = '扫码获得';
					$newArr[$t][$k]['jifen'] = +$recordInfo[$i]['point'];
					$newArr[$t][$k]['time'] = date('Y-m-d H:i:s',$recordInfo[$i]['time']);
					$k++;
				}
				if($exchangeInfo[$i] != NULL) {
					$t = date('Y年m月',$exchangeInfo[$i]['gettime']);
					$newArr[$t][$k]['type'] = '兑换' . $exchangeInfo[$i]['name'];
					$newArr[$t][$k]['jifen'] = -$exchangeInfo[$i]['points'];
					$newArr[$t][$k]['time'] = date('Y-m-d H:i:s',$exchangeInfo[$i]['gettime']);
					$k++;
				}
			}
			$i++;
		}
		
		$arr = array();
		$info = array();
		foreach ($newArr as $key => $value) {
			usort($value,function ($a,$b) {
			$aa = strtotime($a['time']);
			$bb = strtotime($b['time']);
			if ($aa == $bb) return 0;
			return $aa>$bb?-1:1;
		});
			$arr[$key] = $value;
			foreach ($value as $v) {
				if($v['jifen'] > 0) {
					$info[$key]['increase'] += $v['jifen'];
				}else {
					$info[$key]['reduce'] += abs($v['jifen']);
				}
			}
		}
		
		$this->assign('arr',$arr);
		$this->assign('info',$info);
		$this->display();
	}
	


	/*
	制作二维码备注的方法 不要删除！

	public function zhizuoerweima(){
		  $url = "http://www.baidu.com";
		  Vendor('phpqrcode.phpqrcode');
		  $errorCorrectionLevel =intval($level) ;//容错级别 
		  $matrixPointSize = intval($size);//生成图片大小 
		//生成二维码图片 
		  //echo $_SERVER['REQUEST_URI'];
		  $object = new \QRcode();
		  $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
	}
	*/
}

	
	
	
	
	
	
	
	
	
	
	
	
?>	