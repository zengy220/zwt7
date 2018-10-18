<?php
	//商家控制器
	namespace Wxchat\Controller;
	use Wxchat\Controller;
	class BusinessController extends CommonController 
	{
		//绑定商家默认页面
		public function index(){
			$this->display();
		}

		//绑定商家提交页面
		public function bind_business(){
			header("Content-type:text/html;charset=utf-8");
			$UserName = I('uname');
			$redirect_uri = C('MERCHANT_BIND_URL')."/uname/".$UserName;			//商家绑定地址
			$openid = $this->JsApi_pub($redirect_uri);		//调用微信网页授权方法,获取用户openid

			$data = array(
				'openid' => $openid
			);
			//$UserName = I('uname');
			//var_dump($UserName);exit;
			
			$result = M('business')->where($data)->find();

			if($result && $result['is_bind'] > 0){
				
				echo '<script>alert("您好，您已经绑定商家号，无需再绑定!");</script>';exit;
				
			}else{
				$this->assign('openid',$data['openid']);
				$this->display();
			}
			
		}
		//绑定商家提交结果
		public function bind_business_result()
		{
			header("Content-type:text/html;charset=utf-8");
			$business_id = I('business_id'); 
			$openid = I('openid');
			$result = M('business')->where("business_id='".$business_id."'")->find();
			
			if($result['is_bind'] == 0){
				$where = array(
					'openid' =>$openid,
					'is_bind'=>1,
				);

				$res =  M('business')->where("business_id='$business_id'")->save($where);

				if($res){
					echo '<script>alert("绑定成功!");history.go(-1)</script>';exit;
				}else{
					echo '<script>alert("绑定失败!");history.go(-1)</script>';exit;
				}
	
			}
			else
			{
				echo '<script>alert("该商家号已经被绑定!");</script>';exit;
			}
			
		}
		
		//ajax查询商家号是否存在
		public function ajax_business_check(){
			$inputv = I('inputv');
			$result_set = M('business')->where("business_id='".$inputv."'")->find();
			
			if(empty($result_set)){
				echo 3;//查不到
			}else if($result_set['is_bind'] == 0){
				echo 1;//未绑定
			}else{
				echo 2;//已绑定
			}
			
			
		}
		
		//解除绑定商家页面
		public function unbind_business(){
			header("Content-type:text/html;charset=utf-8");
			$redirect_uri = C('MERCHANT_UNBIND_URL');			//商家绑定地址
			$openid = $this->JsApi_pub($redirect_uri);		//调用微信网页授权方法,获取用户openid
			
			$data = array(
				'openid' => $openid
			);
			
			$result = M('business')->where($data)->find();

			if($result['is_bind']==1){
				
				$this->assign('openid',$data['openid']);
				$this->display();
				
			}else{
				echo '<script>alert("该微信号没有绑定成为商家!");</script>';exit;
			}
		}
		
		//解除绑定商家提交结果
		public function unbind_business_result(){
			header("Content-type:text/html;charset=utf-8");
			$business_id = I('business_id'); 
			$openid = I('openid');
			$result = M('business')->where("business_id='".$business_id."' and openid='".$openid."'")->find();
			
			if($result['is_bind'] > 0){
				$where = array(
					'openid' =>'',
					'is_bind'=>0,
				);

				$res =  M('business')->where("business_id='".$business_id."'")->save($where);

				echo '<script>alert("解绑成功!");history.go(-1)</script>';exit;
			}
			// else
			// {
				// echo '<script>alert("该商家号已经被绑定!");</script>';exit;
			// }
		}
		
		
		
		//商户扫描订单二维码  输入商家号的兑换行为
		public function busiScan2(){
			$cstatus = I('cstatus');
			$time= time(); 			
			$cname = I('cname'); 	
			$corderno = I('corderno');	
			$userid = I('userid');	
			$cpoints = I('cpoints'); 
			$business_id =I('business_id');
			
			//订单的状态如果不为1 说明被兑换了
			if($cstatus !=1){
				echo "<h2 style='background:#eee;color:orange;font-size:3em;text-align:center;'>此订单已失效</h2>";
			}else{
				//查询商户是否存在
				$busiInfo = M('business')->where("business_id='$business_id'")->find();
				//echo M()->getLastsql();exit;
				$rs = M('gift_exchange_record')->where("orderno='$corderno'")->find();
				if($rs['status']==2){
					echo "<h2 style='background:#eee;color:orange;font-size:3em;text-align:center;'>订单已经被扫描过</h2>";
					//echo '订单已经被扫描过';
					exit;
				}
				if($busiInfo){
					if($busiInfo['status']!=1){
						echo "<h2 style='background:#eee;color:orange;font-size:3em;text-align:center;'>该商家被禁用！</h2>";
					}else{
						$M = M('custom');//消费者表
						$M->startTrans();
						$G = M('gift_exchange_record');//商品兑换记录表
						$I = M('integ_log');//积分日志表
						$userInfo = $M->where("user_id=$userid")->find();//查询消费者的信息，主要是要积分信息
						$nowPoints = $userInfo['points'];//消费者现有积分
						$change_point = $nowPoints-$cpoints ;//变更后的消费者的积分 此数据主要是给日志表做记录用
						if($nowPoints < $cpoints){
							echo "<h2 style='background:#eee;color:orange;font-size:3em;text-align:center;'>您的积分已经不足以兑换该商品</h2>";
							exit;
						}
						$sql1 = "update cs_custom set points=$nowPoints-$cpoints where user_id=$userid";
						$rs1 = $M->execute($sql1);
						
						
						$sql2 = "update cs_gift_exchange_record set status=2,gettime=$time,business_id='$business_id' where orderno='$corderno'";
						$rs2 = $G->execute($sql2);
						//echo M()->getLastsql();exit;
						/*
						产生兑换日志
						user_id = $user_id 					用户id
						change_point = $change_point        变更后的用户积分
						type = 2 							扣减积分 2是扣减1是增加
						change_type = 2 					变更类型2 2是兑换商品
						business_id='$business_id'			商家号
						point = $cpoints					该商品的积分
						*/
						$sql3 = "insert into cs_integ_log (user_id,business_id,point,change_point,type,change_type,time)value
									($userid,'$business_id',$cpoints,$change_point,2,2,$time)";
						
						$rs3 = $I->execute($sql3);
						
						if($rs1 && $rs2 && $rs3){
							$M->commit();
							$this->assign('time',$time);
							$this->assign('corderno',$corderno);
							$this->assign('cname',$cname);
							$this->assign('cpoints',$cpoints);
							$this->display('Business/exchange_succeed');
						}else{
							$M->rollback();
							echo '兑换单失败!';
						}
					}
				
				}
			}
			
		}
		
		//商户扫描订单二维码 商家已经绑定过，不输入订单号的兑换行为
		public function busiScan(){
			header("Content-type:text/html;charset=utf-8");

			//$busiInfo = M('business')->where("openid='$openid'")->find();

			$corderno = I('corderno');//接收订单编号
			$userid   = I('userid');//接收消费者(用户)id
			$cstatus  = I('cstatus');//接收订单状态
			$cname 	  = I('cname');//接收订单名字
			$cpoints  = I('cpoints');//接收订单积分
			$time = time();
			
			if($busiInfo){
				//如果通过微信公众号绑定了商家，可以直接完成订单二维码的兑换
				/*$M = M('custom');//消费者表
				$M->startTrans();
				$G = M('gift_exchange_record');//积分兑换记录表
				$I = M('integ_log');//积分日志表
				
				$userInfo = $M->where("user_id='".$userid."'")->find();//查询消费者的信息，主要是要积分信息
				
				$nowPoints = $userInfo['points'];//消费者现有积分
				$change_point = $nowPoints-$cpoints ;//变更后的消费者的积分 此数据主要是给日志表做记录用
				
				$userInfo = $M->where('user_id='.$userid)->find();
				
 				$sql1 = "update cs_custom set points='".$change_point."' where user_id='".$userid."'";
 				$rs1 = $M->query($sql1);

 				$sql2 = "update cs_gift_exchange_record set status=2,gettime=$time where orderno='$corderno'";
 				$rs2 = $G->query($sql2);
				
				$sql3 = "insert into cs_integ_log (user_id,business_id,point,change_point,type,change_type,time)value($userid,'$business_id',$cpoints,$change_point,2,2,$time)";
			
				$rs3 = $I->query($sql3);
				
 				if($rs1 && $rs2 && $rs3){
 					$M->commit();
 				}else{
 					$M->rollback();
					echo '商家扫码失败了!';
 				}*/

			}else{
				//否则，可以通过输入商家号进行兑换
				$this->assign('corderno',$corderno);
				$this->assign('userid',$userid);
				$this->assign('cstatus',$cstatus);
				$this->assign('cname',$cname);
				$this->assign('cpoints',$cpoints);
				//跳转到输入商家号兑换积分页面
				$this->display('Business/exchange_goods');
			}

		}
		
	
		

	}
	
	
	
	
	
	