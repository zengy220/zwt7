<?php
namespace Service\Model;
use Think\Model;
class BusinessModel extends Model{
	//商家列表实例
	public function getBusiList($where){

		if($where['saleman_id']>0){
			
			$where=$this->buildBLWhere($where);//筛选条件

			$list = $this->field("busi_id,name,businame,business_id,phone,addtime,address,busi_level,busi_type,longitude,latitude,remark,sign_last_time")->where($where)->order('addtime desc')->select();

			$second = 86400;//1天的秒数
			//size_status  签到状态
			//today_status 今日待维护状态
			$time = strtotime(date('Y-m-d'));//当天的整点时间戳
			
			if($where['list_type']==2){ //今日待维护商家,应该是全部未签到

				foreach($list as $key=>$val){
					
					$last = M('sign_log')->field('intime')->where('is_today=1 and bus_id='.$val['busi_id'])->order('intime desc')->find();
					
					$lastSignTime = strtotime(date('Y-m-d',$last['intime']));
					
					$signTime = strtotime(date('Y-m-d',$val['sign_last_time']));//最后一次签到时间
					
					if($signTime == $time){//最后的签到时间==当前时间则为已签到

						$list[$key]['size_status'] = true;
					
					}else{
					
						$list[$key]['size_status'] = false;

					}
					
					if( strtolower($val['busi_level']) == 'a' ){//每天都需要维护
						$list[$key]['today_status'] = true;
						
					
					}elseif( strtolower($val['busi_level']) == 'b' ){
						
						$date2 = $lastSignTime + $second*2;//第二天的整点时间戳
						
						
						if($lastSignTime == $time){
							
							$list[$key]['today_status'] = true;
						}elseif($date2 > $time){
							
							unset($list[$key]);//去除掉不需要的商家
						}else{
							
							$list[$key]['today_status'] = true;
						}

					}elseif( strtolower($val['busi_level']) == 'c' ){
						
						$date3 = $lastSignTime + $second*3;//第三天的整点时间戳

						if($lastSignTime == $time){
							
							$list[$key]['today_status'] = true;
						}elseif($date3 > $time){
							
							unset($list[$key]);//去除掉不需要的商家
						}else{
							
							$list[$key]['today_status'] = true;
						}
						
					}
					
				}
				
			}else{
				
				foreach($list as $key=>$val){
					
					$last = M('sign_log')->field('intime')->where('is_today=1 and bus_id='.$val['busi_id'])->order('intime desc')->find();
					
					$lastSignTime = strtotime(date('Y-m-d',$last['intime']));

					$signTime = strtotime(date('Y-m-d',$val['sign_last_time']));
					
					if($signTime == $time){//最后的签到时间==当前时间则为已签到

						$list[$key]['size_status'] = true;
					}else{
					
						$list[$key]['size_status'] = false;
					}

					if( strtolower($val['busi_level']) == 'a' ){
						
						$list[$key]['today_status'] = true;

					}elseif( strtolower($val['busi_level']) == 'b' ){
						
						$date2 = $lastSignTime + $second*2;//最后签到时间（is_today为1的）+ 一天后的时间

						if($lastSignTime == $time){
							
							$list[$key]['today_status'] = true;
						}elseif($date2 > $time){
							
							$list[$key]['today_status'] = false;
						}else{
							
							$list[$key]['today_status'] = true;
						}
						
						
					}elseif( strtolower($val['busi_level']) == 'c' ){
						
						$date3 = $lastSignTime + $second*3;//如果当天的时间戳大于等于最后一次签到时间戳+两天
						
						if($lastSignTime == $time){
							
							$list[$key]['today_status'] = true;
						}elseif($date3 > $time){
							
							$list[$key]['today_status'] = false;
						}else{
							
							$list[$key]['today_status'] = true;
						}
						
					}
				
				}
			}

			return $list;
			
		}else{
			return -1;	//缺少参数
		}
	}
	
	private function buildBLWhere($where){
		if(!empty($where['busi_type'])){
			switch($where['busi_type']){
				case 1:
					$where['busi_level']='A';
					break;
				case 2:
					$where['busi_level']='B';
					break;
				case 3:
					$where['busi_level']='C';
					break;
			}
		}
		
		if(!empty($where['busi_name'])){
			$where['name']=array('like','%'.$where['busi_name'].'%');
		}

		//unset($where['list_type'],$where['busi_type'],$where['busi_name']);
		unset($where['busi_type'],$where['busi_name']);
		return $where;
	}
}