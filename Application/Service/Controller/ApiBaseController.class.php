<?php
namespace Service\Controller;
use Think\Controller;
class ApiBaseController extends Controller {
	const APP_KEY='ZwT_10010';	
	
	private $statusCode=array(	//状态码定义
		'000'=>'成功',
		'999'=>'没有访问权限',
		'901'=>'缺少必要参数',
		
		//用户相关报错
		'201'=>'用户不存在',
		'202'=>'密码错误',
		'203'=>'用户已被禁用',
		'204'=>'userid有误',
		'205'=>'原密码错误',
		'206'=>'密码修改失败',
		'207'=>'userid或busid有误',
		
		//反馈相关报错
		'301'=>'反馈数据写入失败',
		
		//服务相关报错
		'401'=>'申请数据写入失败',	//售后服务申请
		'402'=>'没有相关的数据',
		
		//签到相关报错
		'501'=>'签到失败',
		'502'=>'无签到记录',
		'503'=>'重复签到',
	
		//商家相关报错
		'601'=>'商家添加失败',
		'602'=>'商家修改失败',
		'603'=>'商家不存在',
	
	);
	
	public function _initialize(){
		$safe=I('safe');//接收加密参数
		$today=date('Ynj',time());
		$isafe=md5(self::APP_KEY.$today.ACTION_NAME);
		if($safe!=$isafe){
			$this->jsonRes('999',array('post'=>$_POST,'isafe'=>$isafe));
		}
	}
	
	/*public function _initialize(){
		$safe=I('safe');//接收加密参数
		$today=date('Ynj',time());
		$isafe=md5(self::APP_KEY.$today.ACTION_NAME);
		if($safe!=$isafe){
			$this->jsonRes('999');
		}
	}*/
	
	protected function jsonRes($code='',$data=array()){
		$res=array();
		if(empty($code)){
			$res['code']='000';
			$res['msg']=$this->statusCode['000'];
		}else{
			$res['code']=$code;
			$res['msg']=$this->statusCode[$code];
		}
		
		if(!empty($data))
			$res['data']=$data;
		
		header('Content-Type:application/json; charset=utf-8');
		exit(json_encode($res));
	}
	
	
}