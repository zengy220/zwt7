<?php
namespace Service\Model;
use Think\Model;
class UserModel extends Model{
	/**
	 * 登录接口
	 * @param string $username 用户名
	 * @param string $password 密码
	 * @return mixed
	 */
	public function login($username,$password){
		$where=array(
			'username'=>$username,
			//'tel'=>$username,
			//'_logic'=>'or'
		);
		$res=$this->field("user_Id,company_id,head_img,password,username,real_name,tel,is_use")->where($where)->find();
		$userRole = M('userrole as a')->field('role_position')->join('LEFT JOIN `cs_role` as b ON a.role_Id=b.role_Id')->where('a.user_Id='.$res['user_Id'])->find();
		if($res && $userRole['role_position'] == 3){
			if($res['password']==md5($password.'cs')){
				if($res['is_use']==1){
					unset($res['password']);
					unset($res['addtime']);
					unset($res['is_use']);
					return $res;
				}else{
					return -3;	//用户已被禁用
				}
			}else{
				return -2;	//密码错误
			}
		}else{
			return -1;	//用户不存在
		}
	}
	
	/**
	 * 修改密码
	 * @param int $userid
	 * @param string $oldpwd
	 * @param string $newpwd
	 * @return int
	 */
	public function changePwd($userid,$oldpwd,$newpwd){
		if($userid>0){
			$oldpwd=md5($oldpwd.'cs');
			$dbUser=$this->where('user_id='.$userid)->find();
			if($oldpwd==$dbUser['password']){
				$res=$this->where('user_id='.$userid)->setField('password',md5($newpwd.'cs'));
				if(false!==$res){
					return 1;
				}else{
					return -3;	//密码修改失败
				}
			}else{
				return -2;	//原密码错误
			}
		}else{
			return -1;	//userid错误
		}
	}


}