<?php
namespace Service\Model;
use Think\Model;
class FeedbackModel extends Model{
	/**
	 * 反馈
	 * @param int $userid 用户id
	 * @param string $content 反馈内容
	 * @return number
	 */
	public function feedback($userid,$content){
		if($userid>0){
			$arr=array(
					'user_id'=>$userid,
					'message'=>$content,
					'add_time'=>time()
			);
			$res=$this->add();
			if(false!==$res){
				if($res>0){
					return 1;	//插入成功
				}
			}else{
				return -2;	//数据写入失败
			}
		}else{
			return -1;	//userid错误
		}
	}
}