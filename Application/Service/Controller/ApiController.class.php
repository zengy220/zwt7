<?php
namespace Service\Controller;
class ApiController extends ApiBaseController {
	/**
	* 登录接口
	* @param string $username
	* @param string $password
	* @return json
	*/
	public function login(){
		$username = I('username');
		$password = I('password');
		
		if(!empty($username) && !empty($password)){
			$model=D('user');
			$res=$model->login($username,$password);
			if(is_array($res)){
				$this->jsonRes('000',$res);
			}else{
				$resCode='';
				switch ($res){
					case -1:
						$resCode='201';		
						break;
					case -2:
						$resCode='202';
						break;
					case -3:
						$resCode='203';
						break;
				}
				$this->jsonRes($resCode);
			}
		}else{
			$this->jsonRes('901');
		}
	}
	
	/**
	* 修改密码
	* @param int $userid
	* @param string $username
	* @param string $oldpwd
	* @param string $newpwd
	* @return json
	*/
	public function changePwd(){
		$userid = I('post.userid');
		$oldpwd = I('post.oldpwd');
		$newpwd = I('post.newpwd');
		
		if(!empty($userid) && !empty($oldpwd) && !empty($newpwd)){
			$model=D('user');
			$res=$model->changePwd($userid,$oldpwd,$newpwd);
			if($res>0){
				$this->jsonRes();
			}else{
				$resCode='';
				switch ($res){
					case -1:
						$resCode='204';
						break;
					case -2:
						$resCode='205';
						break;
					case -3:
						$resCode='206';
						break;
				}
				$this->jsonRes($resCode);
			}
		}else{
			$this->jsonRes('901');
		}
	}
	
	/**
	* 意见反馈
	* @param int $userid
	* @param string $username
	* @param string $content
	* @return json
	*/
	public function feedback(){
		$userid=I('post.userid');
		$content=I('post.content');
		
		if(!empty($userid) && !empty($content)){
			$model=D('feedback');
			$res=$model->feedback($userid,$content);
			if($res>0){
				$this->jsonRes();
			}else{
				$resCode='';
				switch ($res){
					case -1:
						$resCode='204';
						break;
					case -2:
						$resCode='301';
						break;
				}
				$this->jsonRes($resCode);
			}
		}else{
			$this->jsonRes('901');
		}
	}
	
	
	/**
	* 商家列表
	* @param int $userid
	* @param string $list_type
	* @param string $busi_type
	* @param string $busi_name
	* @param string $lon
	* @param string $lat
	* @param string $current_page
	* @return json
	*/	
	public function businessList(){
		$saleman_id= I('userid');		//业务员id
		$list_type = I('list_type');	//维护类型
		$busi_type = I('post.busi_type');	//商家类型
		$busi_name = I('post.busi_name');	//商家名称
			  $lon = I('post.lon');			//经度
		 	  $lat = I('post.lat');			//纬度

		$where=array();
		$where['saleman_id']= $saleman_id;//关联业务员的ID
		$where['status']    = 1;		  //必须审核通过
		
		if($list_type != ''){
			$where['list_type']= $list_type;
		}
		if($busi_type != ''){
			$where['busi_type']= $busi_type;
		}
		if($busi_name != ''){
			$where['busi_name']= $busi_name;
		}
		
		$model=D('business');
		$res  = $model->getBusiList($where);
		if(is_array($res)){

			$this->jsonRes('000',$res);//成功，发送数据
			
		}else{
			$resCode='';
			switch ($res){
				case -1:
					$resCode='204';
					break;
			}
			$this->jsonRes($resCode);
		}
	}

	

	/**
	* 商品列表
	* @return json
	*/	
	public function getGoods(){
		$model=M('pro');
		//$where = array('sort2'=>array('in','1,2'));
		$res=$model->field('id,names,thumb,jifen')->where($where)->select();
		$this->jsonRes('000',$res);
	}
	
	
	
	/**
	* 提货申请
	* @param int $userid
	* @param string $reason
	* @param string $busi_type
	* @param string $goods_ext
	* @return json
	* 2017-6-8修改最终版-朱达
	*/	
	public function pickUpGoods(){
		$userid =I('post.userid');//用户ID
		$reason =I('post.remark');//备注
		$goods_ext=$_POST['goods_ext'];
		
		if(!empty($userid)){
			$goods_ext=json_decode($goods_ext,true); 
	
			foreach($goods_ext['ext'] as $k=>$v){//如果传上来控制就去除掉
				if($v['num'] == 0){
					unset($goods_ext['ext'][$k]);
				}
			}

			$item = array_values($goods_ext['ext']);//重新排序

			$addArr=array(
				'saleman_id' => $userid,
				'serv_type'  => 4,
				'reason'	 => $reason,
				'add_time'   => time(),
			
			);

			$model=M('customer_service');
			
			$model->startTrans();//开启事务
			
			$customer_id=$model->add($addArr);
			
			$sql = "INSERT INTO `cs_customer_pro` (customer_id,pro_id,predict_num,practical_num) VALUES ";
			
			foreach($item as $k => $v ){
				$sql .= "(".$customer_id.",".$v['id'].",".$v['num'].",".$v['num']."),";
			}
		
			$sql = rtrim($sql,',');

			if($customer_id>0){
				
				M()->execute($sql);
				$model->commit();//执行事务
				$this->jsonRes();
				
			}else{
				
				$model->rollback();//回滚事务
				$this->jsonRes('401');
				
			}
			
			
			
			
		}else{
			$this->jsonRes('901');
		}
		
	}
	

	
	/**
	* 补货申请
	* @param int $userid
	* @param string $reason
	* @param string $busid
	* @param string $goods_ext
	* @return json
	*/	
	public function replenishment(){
		//header("Content-type:text/html;charset=utf-8");	
		$userid = I('post.userid');		//用户ID
		$busid	= I('post.busid');		//商家ID
		$reason = I('post.reason'); 		//备注
		$goods_ext = $_POST['goods_ext'];

		if(!empty($userid) && !empty($busid)){        
			$business = M('business as a')->field(	'a.busi_id,a.name,a.businame,a.phone,a.addtime,a.business_id,a.busi_level')->where('a.busi_id='.$busid)->find();//查询出商家信息

			$where['supply_status'] = 0;
			
			$where['business_id'] = $business['business_id'];
			
			$goods_ext = json_decode($goods_ext,true);
			
			$recordModel = M("gift_exchange_record");
			
			foreach($goods_ext['ext'] as $k=>$v){
				
				if($v['num'] == 0){
					
					unset($goods_ext['ext'][$k]);
					
				}else{
					
					$where['pro_id'] = $v['id'];
					$rel = $recordModel->field('id,pro_id,num')->where($where)->limit($v['num'])->order('id asc')->select();//查询出来的条数总不会大于上传的num数量

					$count = count($rel);//统计当前商品需要兑换的数量
					if($count>=1){
						
						$str = $this->arrAsstr($rel,'id',$count);//需要兑换的ID
						$whereRecord['id'] = array('in',$str);
						$data['supply_status'] = 1;
						$data['supply_time'] = time();
						$change = $recordModel->where($whereRecord)->save($data);//返回受影响的条数(兑换数)
						$practical = $v['num'] - $change;//实际补货数
						$goods_ext['ext'][$k]['exchange_num'] = $change;
						$goods_ext['ext'][$k]['practical_num'] = $practical;
						
					}else{
						$goods_ext['ext'][$k]['exchange_num'] = 0;
						$goods_ext['ext'][$k]['practical_num'] = $v['num'];
					}
					
				}
				
			}

			$item = array_values($goods_ext['ext']);//重新排序

			$addArr=array(
				'saleman_id' => $userid,
				'busi_id'	 => $busid,
				'serv_type'  => 1,
				'reason'	 => $reason,
				'add_time'   => time(),
			);
			$customer_service_model = M('customer_service');
			
			$customer_service_model->startTrans();//开启事务
			
			$customer_id = $customer_service_model->add($addArr);
			
			//$customer_id = 191;
			
			$sql = "INSERT INTO `cs_customer_pro` (customer_id,pro_id,predict_num,convert_num,practical_num) VALUES ";
			
			foreach($item as $k => $v ){
				$sql .= "(".$customer_id.",".$v['id'].",".$v['num'].",".$v['exchange_num'].",".$v['practical_num']."),";
			}
		
			$sql = rtrim($sql,',');

			if($customer_id>0){
				
				M()->execute($sql);//
				
				$customer_service_model->commit();
				
				$this->jsonRes('000',$goods_ext);
				
			}else{
				
				$customer_service_model->rollback();
				
				$this->jsonRes('401');
				
			}
	
		}else{
			
			$this->jsonRes('901');
			
		}
		
		
	}
	

	/**
	* 将二位数组的某个字段拼接成字符串
	* @param int $count 需要转换字段的数量
	* @param string $arr 二维数组
	* @param string $join 需要转换的字段
	* @return json
	*/	
	private function arrAsstr($arr,$join,$count){
		if( is_array($arr) ){
			$str='';
			foreach($arr as $k=>$v){
				
				if( is_array($v) ){
					$str .= $v[$join].",";
				}else{
					return $arr;
				}
				$k++;
				if( isset($count) && $k >= $count ){
					break;
				}
			}
			$str = rtrim($str, ",");
			return $str;
		}else{
			return $arr;
		}
	}
	
	//退货申请(2017-6-1已修改，朱达)
	public function returnGoods(){
		$this->iWantService(2);
	}
	
	//换货申请(2017-6-1已修改，朱达)
	public function ExchangeGoods(){
		$this->iWantService(3);
	}
	
	/**
	* 退换货公共方法
	* @author 朱达
	* @param string $userid 用户ID
	* @param string $busid 商家ID
	* @param string $reason 备注
	* @param string $type 退换货类型
	* @return json
	*/	
	private function iWantService($type){
		$userid =I('post.userid');
		$busid	=I('post.busid');
		$reason =I('post.reason');
		$goods_ext=$_POST['goods_ext'];
		
		if(!empty($userid) && !empty($busid)){
			$goods_ext=json_decode($goods_ext,true);
	
			foreach($goods_ext['ext'] as $k=>$v){
				if($v['num'] == 0){
					unset($goods_ext['ext'][$k]);
				}
			}
			
			$item = array_values($goods_ext['ext']);//重新排序
			
			$addArr=array(
				'saleman_id' => $userid,
				'busi_id'	 => $busid,
				'serv_type'  => $type,
				'reason'	 => $reason,
				'add_time'   => time(),

			);
			
			$model=M('customer_service');
			
			$model->startTrans();//开启事务
			
			$customer_id=$model->add($addArr);
			//$customer_id=194;

			$sql = "INSERT INTO `cs_customer_pro` (customer_id,pro_id,predict_num,practical_num) VALUES ";
			
			foreach($item as $k => $v ){
				$sql .= "(".$customer_id.",".$v['id'].",".$v['num'].",".$v['num']."),";
			}
			
			$sql = rtrim($sql,',');

			if( $customer_id>0 ){
				
				M()->execute($sql);
				$model->commit();//执行事务
				$this->jsonRes();
				
			}else{
				
				$model->rollback();//回滚事务
				$this->jsonRes('401');
				
			}
			
			
			
		}else{
			$this->jsonRes('901');
		} 
	}
	

	/**
	* 签到方法 2017-6-9最终修改版
	* @author 朱达
	* @param string $userid 用户ID
	* @param string $busid 商家ID
	* @param string $lon 经度
	* @param string $lat 纬度
	* @return json
	*/	
	public function sign(){
		$userid = I('userid');//用户userID 
		$busid  = I('busid'); //商家ID
		$lon    = I('lon');   //经度
		$lat    = I('lat');   //维度
	
		if(!empty($userid) && !empty($busid) && !empty($lon) && !empty($lat)){
			$nowTime = time();
			if($userid>0 && $busid>0){
				$model = M('sign_log');
				$model -> startTrans();
				$addArr = array(
					'saleman_id'=>$userid,
					'bus_id'	=>$busid,
					'intime'	=>$nowTime,
					'longitude' =>$lon,
					'latitude'	=>$lat
				);
				
				$busi = M('business')->field("busi_level,sign_last_time,sign_count")->where("busi_id=".$busid)->find();//查询当前商家的信息

				$last = M('sign_log')->where('is_today = 1 and bus_id='.$busid)->order('intime desc')->limit(1)->getField('intime');//查询最后一次签到记录

				$nowDate  = strtotime(date('Y-m-d',$nowTime));//当前时间戳

				$lastDate = strtotime(date('Y-m-d',$last));//最后一次插入时间戳

				if($lastDate >= $nowDate ){
					$this->jsonRes('503');exit;
				}else{

					if($busi['busi_level'] == 'B'){//最后签到时间+ A(3天)=下次签到的时间，如果当前签到时间小于上述时间，则为计划外签到

					
						if($nowDate-$lastDate<86400*2){
							$addArr['is_today']=0;//计划外
						}else{
							$addArr['is_today']=1;//计划内
						}

					}elseif($busi['busi_level']=='C'){

						if($nowDate-$lastDate<86400*3){
							$addArr['is_today']=0;
						}else{
							$addArr['is_today']=1;
						}
						
					}else{
						$addArr['is_today']=1;
					}
					
					$res=$model->add($addArr);
					
					$updateData['sign_last_time'] = $nowTime;
					$updateData['sign_count']     = $busi['sign_count'] + '1';
					
					$upBusiness = M('business')->where("busi_id=".$busid)->save($updateData);
					if($res>0 && $upBusiness>0){
						$model->commit();
						$this->jsonRes('000');
					}else{
						$model->rollback();
						$this->jsonRes('501');						
					}

				}
				
			}else{
				$this->jsonRes('207');
			}
		}else{
			$this->jsonRes('901');
		}
	}
	

	/**
	* 提货记录 2017-6-2
	* @author 朱达
	* @param string $userid 用户ID
	* @param string $date 日期
	* @return json
	*/	
	public function s2ServiceList(){
		$saleman_id = I('userid');	//用户ID
		$date 		= I('date');	//日期
		$startTime = !empty($date)?strtotime($date.' 0:0:0'):strtotime(date('y-m-d 0:0:0'));
		$endTime   = !empty($date)?strtotime($date.' 23:59:59'):strtotime(date('y-m-d 23:59:59'));
		
		if( !empty($saleman_id) ){

			$where=array(
				'saleman_id'=>$saleman_id,
				'add_time'=>array(
					'between',array($startTime,$endTime),
				), 
				'serv_type'=>4
				
			);

			$res=M('customer_service')->where($where)->select();

			$temp=array();
			$i = 0;
			foreach($res as $val){
				$pickgood=json_decode($val['goods_ext'],true);

				foreach($pickgood['ext'] as $k1=>$v1){
					$temp[$i]['id'] = isset($v1['id'])?$v1['id']:'';
					$temp[$i]['names'] = $v1['names'];
					$temp[$i]['num']  = $v1['num'];
					$i++;
				}
				
			}

			$item=array();
			$i=0;
			foreach($temp as $k=>$v){
				if(!isset($item[$v['id']])){
					$item[$v['id']]=$v;
				}else{
					$item[$v['id']]['num']+=$v['num'];
				}
				$i+=$v['num'];
			}
			$item = array_values($item);//重新排序
			$this->jsonRes('000',array('list'=>$item,'remark'=>$res[0]['remark'],'count'=>$i));
			
		}else{
			$this->jsonRes('901');
		}

	}
	

	/**
	* 补货记录 2017-6-2
	* @author 朱达
	* @param string $userid 用户ID
	* @param string $type 商家类型(1,2,3)
	* @return json
	*/	
	public function s3ServiceList(){
		$saleman_id = I('userid');	//用户ID
		$type = I('post.type');		//商家类型
		$date = I('post.date');		//日期Y-M-d
		$startTime = !empty($date)?strtotime($date.' 0:0:1'):strtotime(date('Y-m-d 0:0:1'));
		$endTime = !empty($date)?strtotime($date.' 23:59:59'):strtotime(date('Y-m-d 23:59:59'));
		
		
		if( !empty($saleman_id) ){
			$Model = M("customer_service as a");
			$where=array(
				'a.saleman_id'=>$saleman_id,
				'add_time'=>array(
					'between',array($startTime,$endTime),
				), 
				'serv_type'=>1
				
			);

			switch ($type)
			{
			case 1:
			  $where['b.busi_level'] = 'A';
			  break;
			case 2:
			  $where['b.busi_level'] = 'B';
			  break;
			case 3:
			  $where['b.busi_level'] = 'C';
			  break;
			}
			
			$res=$Model->field("a.id,a.saleman_id,a.busi_id,a.serv_type,a.goods_ext,a.reason as remark,b.name,b.businame,b.phone,b.busi_level,b.busi_type,b.address")->join('left join `cs_business` b on a.busi_id=b.busi_id')->where($where)->select();//查询当日各商品退换的总数

			$countList = $this->jsonChangeArray($res,true);
			$list = $this->jsonChangeArray($res,false);
			
			$this->jsonRes('000',array('count'=>$countList,'list'=>$list,'remark'=>$res[0]['reason']));
			
		}else{
			$this->jsonRes('901');
		}
		
	}

	
	/**
	* 签到历史 2017-6-2
	* @author 朱达
	* @param string $userid 用户ID
	* @param string $date 时间(Y-m-d)
	* @return json
	*/
	public function signList(){
		$saleman_id= I('post.userid');//业务员ID
		$date	   = I('post.date');//接收的时间
		$uDate	   = strtotime($date);//转化成时间戳
		
		if(!empty($saleman_id)){
			$startTime=!empty($date)?strtotime($date.' 0:0:1'):strtotime(date('y-m-d 0:0:0'));
			$endTime=!empty($date)?strtotime($date.' 23:59:59'):strtotime(date('y-m-d 23:59:59'));
			
			$signModel=M('sign_log');
			$busModel =M('business');
			$arr=array(
				'a.intime'=>array('between',array($startTime,$endTime)),
				'a.saleman_id'=>$saleman_id,
				'b.status'=>1
			);

			
			//已签到商家
			$res  = $signModel->alias('a')->field('a.bus_id,a.intime,a.is_today,b.busi_id,b.name,b.busi_img,b.businame,b.phone,b.address,b.busi_level,b.busi_type,b.sign_last_time')->join('LEFT JOIN `cs_business` b ON a.bus_id=b.busi_id')->where($arr)->select();
			
			$total = count($res);	//已签到商家总数
			
			$signId = $this->arrAsstr($res,'busi_id');//获取出已经签到的商家的ID

			$f = 0;
			$j = 0;
			$temporary = array(
				'0'=>array('busi_level'=>'A','total' => 0),
				'1'=>array('busi_level'=>'B','total' => 0),
				'2'=>array('busi_level'=>'C','total' => 0)
			);
			
			foreach($res as $ko=>$vo){//计划外签到数据
				$res[$ko]['intime'] = date('H:i:s',$vo['intime']);
				$lastTime = strtotime(date('Y-m-d',$vo['sign_last_time']));
				switch($vo['busi_level']){
					case 'B':
						if($vo['is_today'] == 0){
							$f++;
						}
						$temporary[1]['total'] = $f;
						
					break;
					case 'C':
						if($vo['is_today'] == 0){
							$j++;
						}
						$temporary[2]['total'] = $j;
						
					break;
				}
			}

			if($signId != NULL){
				$noInSql = 'select busi_level,count(*) as total from `cs_business` where busi_id not in ('.$signId.') and saleman_id='.$saleman_id.' and status=1 group by busi_level';
			}else{
				$noInSql = 'select busi_level,count(*) as total from `cs_business` where saleman_id='.$saleman_id.' and status=1 group by busi_level';
			}

			$noIn=M()->query( $noInSql );	//未签到 
			
			$temp = array(
			'0'=>array('busi_level'=>'A','total' => 0),
			'1'=>array('busi_level'=>'B','total' => 0),
			'2'=>array('busi_level'=>'C','total' => 0)
			);

			foreach($noIn as $key=>$val){

				switch($val['busi_level']){
					case 'A':
						$temp[0]['total'] = $val['total'];
						
					break;
					case 'B':
						$temp[1]['total'] = $val['total'];
						
					break;
					case 'C':
						$temp[2]['total'] = $val['total'];
						
					break;
				}
				
			}
			
			$resArr=array(
				'list' => $res,
				'total'=> $total,
				'noIn' => $temp,			 //未签到
				'besides'=>$temporary        //计划外签到
			);

			$this->jsonRes('000',$resArr);
		}else{
			$this->jsonRes('901');
		}
		
		
	}

	

	/**
	* 商家信息维护 2017-5-27
	* @author 朱达
	* @param string $userid 用户ID
	* @param string $status 类型(1,2,3)
	* @return json
	*/
	public function myBusi(){
		$saleman_id=I('post.userid');
		$status=I('post.status');
		$model=M('business');
		$where=array();
		if(!empty($saleman_id) && !empty($status) ){
			
			$where['saleman_id']=$saleman_id;
			
			if($status=='1'){	//全部已审核的
				$where['status']=1;
			}elseif($status=='2'){	//待审核的
				$where['status']=2;
			}elseif($status=='3'){  //已拒绝的
				$where['status']=3;
			}

			$res=$model->field("busi_id,name,busi_img,businame,phone,address,busi_level,busi_type,longitude,latitude,status")->where($where)->order('addtime desc')->select();
			$this->jsonRes('000',$res);
		}else{
			$this->jsonRes('901');
		}
		
	}
	

	/**
	* 拒绝商家申请 2017-6-2
	* @author 朱达
	* @param string $userid 用户ID
	* @param string $busid  商家ID
	* @return json
	*/
	public function busiProcess(){
		$saleman_id=I('post.userid');
		$busi_id=I('post.busid');
		if(!empty($saleman_id) && !empty($busi_id)){
			
			$business = M('business')->field('name,addtime,status,manager_status,service_status,reason')->where("busi_id=".$busi_id)->find();//查询此商户的信息
			
			$where['a.busi_id'] = $busi_id;

			$where['a.check_time'] = array('EGT',$business['addtime']);
			
			$res = M('busi_check as a')->field('a.*,b.real_name')->join("LEFT JOIN `cs_user` as b ON a.user_id=b.user_Id")->where($where)->select();
			
			$this->jsonRes('000',array('reason'=>$business['reason'],'list'=>$res));
		}else{
			$this->jsonRes('901');
		}
		
	}
	

	/**
	* 添加商家展示页面
	* @author 朱达
	* @return json
	*/
	public function addBusiShow(){
		$model=M('pro');
		//$where = array('sort2'=>array('in','1,2'));
		$res=$model->field('id,names')->where($where)->select();
		$this->jsonRes('000',array('on_credit'=>$res,'free'=>$res,'cash'=>$res));
	}
	
	//添加商家动作
	public function addBusi(){
		//header("Content-type:text/html;charset=utf-8");
		$goods_ext  = $_POST['goods_ext'];//接收商品集合参数

		$temp_array = json_decode($goods_ext,true);

		$new_temp = array();
		
		foreach($temp_array['ext'] as $key=>$val){
			
			foreach($val as $k=>$v){
				
				if($v['num'] == 0){
					unset($val[$k]);
				}
				
			}
			$new_temp[$key] = $val;
			
		}

		$check=array(
			'name'		=> I('post.name'),		//商店名
			'businame'	=> I('post.businame'),	//老板名
			'phone' 	=> I('post.phone'),		//电话
			'busi_level'=> I('post.busi_level'),//商家等级
			'busi_type' => I('post.busi_type'),	//商家类型
			'saleman_id'=> I('post.userid'),	//业务员ID
			'company_id'=> I('post.company_id'),//业务员ID
			'longitude' => I('post.lon'),		//经度
			'latitude' 	=> I('post.lat'),		//维度
			'address' 	=> I('post.address'),	//定位地址
			'wx_number' => I('post.wx_number'),	//微信号
		);
		
		foreach( $check as $k => $v ){
			if(empty($v)){
				$this->jsonRes('901');
				return;
			}
		}
		
		$check['addtime']= time();				  //申请时间
		$check['status'] = 2;					  //待审核状态
		$check['remark'] = I('post.other');		  //备注
		$check['boxnum'] = I('post.boxnum');      //盒子
		$check['reason'] = '新增的商家!';
		
		$model = M('business');
		
		$model->startTrans();//开启事务
		
		$business_id = $model->add($check);//添加商家数据

		$sql = "INSERT INTO `cs_business_pro` (type,business_id,pro_num,pro_id) VALUES ";
		
		foreach($new_temp as $k => $v ){
			switch($k){
				case 'cash':$type = 1;break;
				case 'free':$type = 2;break;
				case 'on_credit':$type = 3;break;
			}
			
			foreach($v as $key=>$val){
				$sql .= "(".$type.",".$business_id.",".$val['num'].",".$val['id']."),";
			}
			
		}
		
		$sql = rtrim($sql,',');

		if( $business_id > 0 ){
			M()->execute($sql);
			$model->commit();//提交事务
			$this->jsonRes();
			
		}else{
			
			$model->rollback();//回滚事务
			$this->jsonRes('601');
			
		}
		
	}
	
	//修改商家信息
	public function changeBusi(){
		$saleman_id = I('post.userid');		//业务员ID
		$busi_id    = I('post.busid'); 		//商家ID
		$reapply    = I('post.reapply');	    //再次申请标示
		$business = M('business');	    //实例化商家模型
		
		$bus = $business->field('name,businame,wx_number,phone,busi_type,busi_level,longitude,latitude,address,saleman_id')->where(array('busi_id'=>$busi_id))->find();

		if(empty($bus)){
			$this->jsonRes('603');
		}

		$check=array(
			'name' 		 => I('post.name'),			//商店名字
			'businame' 	 => I('post.businame'),		//老板名字
			'phone' 	 => I('post.phone'),			//电话
			'busi_type'  => I('post.busi_type'),		//商家类型
			'busi_level' => I('post.busi_level'),	//商家等级
			'longitude'  => I('post.lon'),			//经度
			'latitude' 	 => I('post.lat'),			//纬度
			'address' 	 => I('post.address'),		//地址
			'wx_number'  => I('post.wx_number'),	//微信号
		);

		foreach($check as $k=>$v){
			if( $v == '' ){
				$this->jsonRes('901');
				return;
			}
		}
		
		$check['addtime'] = time();
		$check['status'] = 2;
		$check['manager_status'] = 0;
		$check['service_status'] = 0;
		
		foreach($bus as $k=>$v){
			
				switch($k){
					case 'name':
						if( $v != $check['name'] ){
							$check['reason'] .= '修改店名`';
						}
					break;
					case 'businame':
						if( $v != $check['businame'] ){
							$check['reason'] .= '修改联系人`';
						}
					break;
					case 'wx_number':
						if( $v != $check['wx_number'] ){
							$check['reason'] .= '修改微信号`';
						}
					break;
					case 'phone':
						if( $v != $check['phone'] ){
							$check['reason'] .= '修改电话`';
						}
					break;
					case 'busi_type':
						if( $v != $check['busi_type'] ){
							$check['reason'] .= '修改类型`';
						}
					break;
					case 'busi_level':
						if( $v != $check['busi_level'] ){
							$check['reason'] .= '修改等级`';
						}
					break;
					case 'longitude':

						if( $v != $check['longitude'] ){
							$check['reason'] .= '修改商家经度`';
						}
					break;
					case 'latitude':
						if( $v != $check['latitude'] ){
							$check['reason'] .= '修改商家纬度`';
						}
					break;
					case 'address':
						if( $v != $check['address'] ){
							$check['reason'] .= '修改地址`';
						}
					break;

				}
		}

		$res = $business->where(array('busi_id'=>$busi_id))->save($check);
		
		if(false!==$res){
			$this->jsonRes();
		}else{
			$this->jsonRes('602');
		}
	}
	
	//退换货记录
	public function serviceLog(){
		$saleman_id=I('post.userid');		//业务员ID
		$status = intval(I('post.status'));	//审核状态,0审核中,1通过,2拒绝
		$date=I('post.date');				//时间
		$type=I('post.type');				//2退货3换货

		if( empty($saleman_id) || empty($type)){
			$this->jsonRes('901');exit;
		}
		
		if( $status < 0 || $status > 3 ){
			$status = 0;
		}
	
		if(!empty($date)){
			$startTime=strtotime($date.' 0:0:1');
			$endTime=strtotime($date.' 23:59:59');
		}else{
			$startTime=strtotime(date('Y-m-d').'0:0:1');
			$endTime=time();
		}
		
		$where['a.add_time']=array('between',array($startTime,$endTime));
		$where['a.saleman_id']=$saleman_id;
		$where['a.serv_type']=$type;
		$where['a.status']=$status;

		$model=M('customer_service');//实例化售后服务模型
		
		$rel=$model->alias('a')->field("a.id,a.saleman_id,a.busi_id,a.serv_type,a.goods_ext,a.remark,b.name,b.businame,b.phone,b.busi_level,b.busi_type,b.address")->join('left join `cs_business` b on a.busi_id=b.busi_id')->where($where)->select();//查询当日各商品退换的总数

		$count_1 = $this->jsonChangeArray($rel,true);
		$count_1 = empty($count_1) ? null : $count_1;
		$count_2 = $this->jsonChangeArray($rel,false);
		$count_2 = empty($count_2) ? null : $count_2;
		$this->jsonRes('000',array('count'=>$count_1,'list'=>$count_2));
	}
	
		

	//退换货记录详情
	public function serviceDetail(){
		$servid=I('post.servid');
		//$status = intval(I('status'));
		if($servid>0){
			$model=M('customer_service');
		
			$where['a.id'] = $servid;
			//$where['a.status'] = $status;
			
			$res=$model->alias('a')->field('a.saleman_id,a.busi_id,a.serv_type,a.goods_ext,a.reason,b.name,b.businame,b.phone,b.busi_level,b.busi_type,b.address')->join('LEFT JOIN `cs_business` b ON a.busi_id=b.busi_id')->where($where)->select();
			
			$audit = M("serv_check as a")->field("real_name,is_pass,message")->join("LEFT JOIN `cs_user` as b ON a.user_id=b.user_Id ")->where('ser_id='.$servid)->select();
			
			$rel = $this->jsonChangeArray($res,true);
			$count = empty($rel) ? null : $rel;
			$reason= empty($res[0]['reason']) ? null : $res[0]['reason'];
			$audit = empty($audit) ? null : $audit;
			$this->jsonRes('000',array('count'=>$count,'remark'=>$reason,'list'=>$audit));

		}else{
			$this->jsonRes('901');
		}
	}
	
	
	
	//转化售后商品数据的格式,将数组里面的json转化成为数组
	private function jsonChangeArray($rel,$type){
		if(!is_array($rel)){
			return null;
		}
		$temp=array();
		$i = 0;
		foreach($rel as $key=>$val){
			$pickgood=json_decode($val['goods_ext'],true);
		
			foreach($pickgood['ext'] as $k1=>$v1){
				$temp[$i]['id'] = isset($v1['id'])?$v1['id']:'';
				$temp[$i]['names'] = $v1['names'];
				$temp[$i]['num']  = $v1['num'];
				$i++;
				
				$rel[$key]['num'] += $v1['num'];

			}
			$rel[$key]['goods_ext'] = $pickgood['ext'];
			
		}

		if($type == true){
			
			$item=array();
			foreach($temp as $k=>$v){
				if(!isset($item[$v['id']])){
					$item[$v['id']]=$v;
				}else{
					$item[$v['id']]['num']+=$v['num'];
				}
			}
			$result = !empty($item)?array_values($item):null;//重新排序,查询当日各商品退换的总数
			return $result;
			
		}else{
			return array_values($rel);
		}
		
	}
	
	//app版本控制
	public function versionControl(){
		$version=I('version');//版本号
		
		if(!empty($version)){
			
			$res = M('app_versions')->field('hasNew,version,url,releasenote,forceupdate')->order('addtime desc')->find();
			
			if($res['forceupdate'] == 1){
				$res['forceupdate'] = true;
			}else{
				$res['forceupdate'] = false;
			}
			
			if( $res['version'] >= $version ){
				$res['hasNew'] = true;
			}else{
				$res['hasNew'] = false;
			}
			
			$this->jsonRes('000',$res);

		}else{
			$this->jsonRes('901');
		}
		
	}
	
	/**
	* 商家库存信息维护功能接口
	* @param string 
	* @param string 
	* @return json
	*/
	public function inventoryService(){
		//header("Content-type:text/html;charset=utf-8");
		$userid = I('post.userid');//业务员ID
		$busid	= I('post.busid'); //商家ID
		$remark	= I('post.remark'); //备注
		$goods_ext  = $_POST['goods_ext'];//接收商品集合参数
		//$goods_ext = '{"ext":{"store":[{"id":"131446","names":"知音系列","num":0},{"id":"131441","names":"乡愁系列","num":2},{"id":"131443","names":"旅行系列","num":3}],"line":[{"id":"131446","names":"知音系列","num":1},{"id":"131441","names":"乡愁系列","num":2},{"id":"131443","names":"旅行系列","num":3}]}}';
		
		$temp_array = json_decode($goods_ext,true);
		
		$new_temp = array();
		
		foreach($temp_array['ext'] as $key=>$val){
			
			foreach($val as $k=>$v){
				
				if($v['num'] == 0){
					unset($val[$k]);
				}
				
			}
			$new_temp[$key] = $val;
			
		}
		
		if( $userid>0 && $busid>0 && $new_temp != null ){

			$sql = "INSERT INTO `cs_business_inventory` (business_id,pro_id,pro_num,inventory_type,addtime,remark) VALUES ";
			$time = time();//导入时间
			foreach( $new_temp as $k => $v ){
				$type = ($k == 'store') ? 1 : 2 ;
				
				foreach( $v as $key => $val ){
		
					$sql .= "(".$busid.",".$val['id'].",".$val['num'].",".$type.",".$time.",'".$remark."'),";
					
				}

			}
		
			$sql = rtrim($sql,',');
			
			$insert_rel = M()->execute($sql);

			if( $insert_rel > 0){
				
				$this->jsonRes('000',$insert_rel);
				
			}else{
				
				$this->jsonRes('401');
				
			}
			
		}else{
			$this->jsonRes('901');
		}
		
	}
	

	

}