<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	
    public function index(){
		//登录页面
		  $userId = session('userId');
		$userName = session('userName');
		if(!empty($userId) && !empty($userName)){
			header("location:/Home/User/");
			exit;
		}
		
		$this->display('login');
    }
	
	//  登录
	public function login()
	{
		session(null);
		$name = I("name");
		$password = md5(I("password")."cs");
		
		if(!empty($name) && !empty($password))
		{
			$User = M('user as a');
			$where_1['username'] = $name;
			$where_1['password'] = $password;
			$list=$User->field('user_Id,a.company_id,username,real_name,is_use,b.company_name,company_type,b.company_num')->join('LEFT JOIN `cs_company` as b ON a.company_id=b.company_id')->where($where_1)->find();//查询用户记录
			
			if(!empty($list))
			{
				if($list['is_use'] == 1)
				{
					$rel = M('userrole as a')->field('role_name,role_type,role_identity,role_position,role_num')->join("LEFT JOIN `cs_role` as b ON a.role_Id = b.role_Id")->where("`user_Id`='".$list['user_Id']."'")->find();
					
					session(array('name'=>"session_id",'expire'=>3600));
					session('userId',		$list['user_Id']);		//用户ID
					session('userName',		$list['username']); 	//用户名，登录账号
					session('realName',		$list['real_name']);	//真实姓名
					session('company',		$list['company_id']);	//组织ID
					session('companyname',	$list['company_name']); //组织名称
					session('company_num',	$list['company_num']);  //组织编号
					session('company_type',	$list['company_type']); //组织类型
					session('roleName',		md5($rel['role_name']));
					session('role_identity',$rel['role_identity'] );//角色类型（总部、分部）
					session('role_position',$rel['role_position'] );//角色身份（业务员、客服、经理）
					session('role_num',		$rel['role_num'] );		//角色编码（角色编码）
					header("location:/Home/User");
					exit;
				}
				else
				{
					$this->error('您的账号不允许登录！');
				}
			}
			else
			{
				$this->error('用户名或密码错误');
			}
		}
		else
		{
			$this->error('用户名和密码不能为空');
		}
		
	}
	
	
	//  修改密码
	public function changepwd()
	{
		if($_POST){
			$old = I('old');
			$new1 = I('new1');
			$new2 = I('new2');
			if($old == ''){
				$this->error('原始密码必须填写');
			}elseif($new1 == ''){
				$this->error('新密码必须填写');
			}elseif($new1 != $new2){
				$this->error('两次密码输入不一致');
			}

			$old = md5($old."cs");
			$new1 = md5($new1."cs");
			   $user = M('user');
			  $userId = session('userId');
			$userName = session('userName');

			
			$where['userId'] = $userId;
			$where['password'] = $old;
			
			$check_query = mysql_query("select username from cs_user where user_Id='$userId' and password='$old' limit 1");  
			if($result = mysql_fetch_array($check_query)){ 
				$where_1['user_Id'] = $userId;
				$data['password']  = $new1;
				$res = $user->where($where_1)->save($data);
				if($res){
					$this->success('修改成功,请重新登录','/Home/index/logout');exit;
				}else{
					$this->error('哎呀，出错了！');
				}
				
				
			}else{
				$this->error('原始密码错误');

			} 
			
			// $old1 = $user->where("user_Id=$userId AND password=$old")->count();

			
			
		}
		$this->display();
	}
	
	
	//	退出
	public function logout()
	{
		session('[destroy]');
		$this->success('成功退出','/Home/Index');
	}
	
}