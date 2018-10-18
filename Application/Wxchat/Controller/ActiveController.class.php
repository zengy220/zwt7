<?php
	//活动控制器
	namespace Wxchat\Controller;
	use Wxchat\Controller;
	class ActiveController extends CommonController 
	{
		public function index(){

		}

		//产生订单二维码
		public function change(){
			header("Content-type:text/html;charset=utf-8");
			$id = I('get.id');//接收商品的id
		
			$giftInfo = M('active_gift')->where("id=$id")->find();//该活动商品的所有信息
			
			$nowId = session('userid');
		
			$userInfo = M('custom')->where('user_id='.$nowId)->find();//获取session中的用户信息
			
			if($userInfo['status']!=1){
				echo "<h2 style='background:#eee;color:orange;font-size:3em;text-align:center;'>您的账户涉嫌违规已被禁用,请联系客服! 客服电话0731-99558742</h2>";
			}else{
			
				//积分足够兑换
				if($userInfo['points'] >= $giftInfo['points']){
					//随机数订单id
					//$orderno = getRandNum12();
					
					/*  生成订单号规则 yymmdd+user_id + 随机2位数 */
					$orderno ='';
					$timestr = date('ymd',time()); 
					$orderno .= $timestr;
					$randOrderNo = getRandomStr9(); //获取随机9位数
					
					$getRandTime = M('gift_exchange_record')->field('gettime')->where("orderno='$randOrderNo'")->find();     //查询该码的当天时间                                                                                                                                                                                  
					if(!isset($getRandTime)&& empty($getRandTime)){
						$orderno.=$randOrderNo;
						
						$data = array(
							'orderno'  => $orderno,
							'user_id'  => $nowId,
							'points'   => $giftInfo['points'],//该订单的积分
							'time'     => time(),
							'name'     => $giftInfo['name'],//商品名称
							'status'   => 1,//订单状态 1是申请兑换中 2 成功 3失败
							);
						
						//var_dump($data);exit;
						$rs = M('gift_exchange_record')->data($data)->add();
						
						$_SESSION['change']['points'] = $data['points'];//订单积分
						$_SESSION['change']['status'] = $data['status'];//订单状态
						$_SESSION['change']['name'] = $data['name'];//兑换商品名字
						$_SESSION['change']['orderno'] = $data['orderno'];//兑换单单号

						$this->assign('orderno',$data['orderno']);
						$this->assign('name',$giftInfo['name']);
						$this->assign('points',$data['points']);
						$this->display('Active/erweima');
						
					}
					
					
				}else{
					echo "<h2 style='background:#eee;color:orange;font-size:3em;text-align:center;'>积分不足兑换</h2>";
				}
			}
		}

		public function showErweima(){
			  $cpoints	= $_SESSION['change']['points'];
			  $cstatus = $_SESSION['change']['status'];
			  $cname = $_SESSION['change']['name'];
			  $corderno = $_SESSION['change']['orderno'];
			  $nowId = session('userid');

			  Vendor('phpqrcode.phpqrcode');
			  $url=C('ORDER_URL');
			  
			  $url=C('ORDER_URL')."/Wxchat/Business/busiScan/corderno/$corderno/userid/$nowId/cstatus/$cstatus/cname/$cname/cpoints/$cpoints";
			  $size =12;
			  $level =4;
			  $errorCorrectionLevel =intval($level) ;//容错级别 
			  $matrixPointSize = intval($size);//生成图片大小 
			  $object = new \QRcode();
			  ob_clean();
			  $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
		}
		
		//商户扫码结果页异步回调
		public function client_ajax(){
			$orderno = I('ID');
			//echo $orderno;exit;
			//接收客户端二维码展示页面异步传来的订单号查询状态
			$result = M('gift_exchange_record')->where("orderno='$orderno'")->find();
			
			if($result['status']!=2){
				echo '1'; //订单还没有被扫描,状态没有改变为2,返回1
			}else{
				echo '2'; //查到结果,返回2 该订单已经兑换成功了，客户扫码结果页返回成功提示
			}
		}
		
		//订单扫描成功后返回的页面(客户看到的成功提示页面)
		public function client_succeed(){
			$orderno=I("get.orderno");//获取传过来的兑换单编号
			//查询数据库 然后显示
			$orderInfo = M('gift_exchange_record')->field('orderno,name,points,gettime')->where("orderno='$orderno'")->find();
			$this->assign('corderno',$orderInfo['orderno']);
			$this->assign('cname',$orderInfo['name']);
			$this->assign('cpoints',$orderInfo['points']);
			$this->assign('gettime',$orderInfo['gettime']);
			$this->display();
		}
		
		//商家不存在异步回调信息
		public function business_ajax(){
			$SJ = I('SJ');//接收商家号
		
			if(empty($SJ)){
				//商家号为空
				echo 0;exit;
			}
			$result = M('business')->where("business_id='$SJ'")->find();
			if(!$result){
				echo 1; //商家不存在
			}
			else if($result['status']!=1){
				echo 2; //商家被禁用
			}else{
				echo 3; //正常的商家
			}
			
			
			
			
		}
		
	}









?>