<?php
/** 
*PHP文件 
* 
*系统菜单权限角色集中控制器
* @author      zhuda<675671998@qq.com> 
* @version     $Id$ 
* @since        1.0 
*/ 
namespace Home\Controller;
use Home\Controller;
class UserController extends CommonController
{
	
//默认页展示
    public function index()
    {	

		$path=$_SERVER['HTTP_HOST'];
    	$this->assign('path',$path);
		$this->display();
       
    }

//菜单列表
    //菜单列表
    public function menu_list()
    {
        //菜单列表
		$menuModel = M('menu');

		$where_1['relation_Id'] = 0;
		$list_1 = $menuModel->where($where_1)->order('menu_sort asc')->select();
		foreach($list_1 as $val=>$key){
			//拼接显示字段
			$list_1[$val]['menu_class_titile'] = "一级目录";
            $list_1[$val]['menu_class_up'] = "无";
            $list_1[$val]['menu_status'] = $key['menu_status'] == 1 ? "<font color='#75B731'>启用</font>" : "<font color='#F83D35'>禁用</font>";
            $list_1[$val]['menu_show'] = $key['menu_show'] == 1 ? "<font color='#75B731'>展示</font>" : "<font color='#0044CC'>隐藏</font>";
            $list_mul[] = $list_1[$val];//组装新数组
			
			$where_2['relation_Id'] = $key['menu_Id'];
			$list2 = $menuModel->where($where_2)->order("menu_sort asc")->select();
			
			if (!empty($list2)) {
                foreach ($list2 as $va => $vf) {
                    $list2[$va]['menu_name'] = "  &nbsp;&nbsp;--  " . $vf['menu_name'];
                    $list2[$va]['menu_class_titile'] = "二级目录";
                    $list2[$va]['menu_class_up'] = $key["menu_name"];
                    $list2[$va]['menu_status'] = $vf['menu_status'] == 1 ? "<font color='#75B731'>启用</font>" : "<font color='#F83D35'>禁用</font>";
                    $list2[$va]['menu_show'] = $vf['menu_show'] == 1 ? "<font color='#75B731'>展示</font>" : "<font color='#0044CC'>隐藏</font>";
                    $list_mul[] = $list2[$va];
					
					/*$where_3['menu_status'] = 1;
					$where_3['relation_Id'] = $vf['menu_Id'];
                    $list3 = $menuModel->where($where_3)->select();
                    if (!empty($list3)) {
                        foreach ($list3 as $vd => $vg) {
                            $list3[$vd]['menu_name'] = " -- " . $vg['menu_name'];
                            $list3[$vd]['menu_class_titile'] = "三级目录";
                            $list3[$vd]['menu_class_up'] = $vf["menu_name"];
                            $list3[$vd]['menu_status'] = $vg['menu_status'] == 1 ? "启用" : "禁用";
                            $list3[$vd]['menu_show'] = $vg['menu_show'] == 1 ? "展示" : "隐藏";
                            $list_mul[] = $list3[$vd];
                        }

                    }*/
                }

            }
			
			
		}
        $this->assign('menu_list', $list_mul);
        $this->assign('menu', "list");
        $this->assign('title', "菜单列表");
        $this->display("menu");
    }

//菜单添加
	public function menu_add()
	{
		$list = M('menu')->where("relation_Id=0")->select();
		$this->assign('menu_title','添加菜单');
		$this->assign('list', $list);//菜单下拉列表
		$this->assign('menu', "add");
		$this->assign('menu_from_url', "/Home/User/menu_set/");//from表单提交地址
		$this->display("menu");
	}
	
//菜单编辑
    public function menu_set()
    {
		$menuModel = M('menu');
		if(IS_POST){
			$o = I('o');

				if(I('menu_name') == ''){
					$this->error('菜单名必须填写！');
				}else{
					$verify = I('verify');
					$check_verify = check_verify($verify);
					if(!$check_verify){
						$this->error('验证码错误！');
					}
				}
				
				$data['menu_name']   = I('menu_name');
				$data['relation_Id'] = I('relation_Id');
				$data['menu_url']    = I('menu_url');
				$data['menu_status'] = I('menu_status');
				$data['menu_show'] = I('menu_show');
				$data['menu_sort'] = I('menu_sort');
				$data['add_time']  = time();
				$where['menu_Id'] = I('u');
				
				if($o == 'edit'){
					$rel = $menuModel->where($where)->save($data);
				}elseif($o == 'add'){
					$rel = $menuModel->add($data);
				}

				if($rel){
					$this->success('操作成功！','/Home/User/menu_list');exit;
				}else{
					$this->error('哎呀，出错了！');
				}

		}
		$where_1['menu_Id'] = I('u');
		$rel = $menuModel->where($where_1)->find();
		//
        $list = $menuModel->where("relation_Id=0")->select();
        $this->assign('menu', "edit");
        $this->assign('menu_Id', $where_1['menu_Id']);
        $this->assign('menu_from_url', "/Home/User/menu_set/");//from表单提交地址
        $this->assign('menu_data', $rel);//菜单数据
        $this->assign('list', $list);//菜单下拉列表
        $this->assign('menu_title','编辑菜单');
        $this->display("menu");
    }
	
//删除菜单功能
	public function menu_del()
	{	
		$where['menu_Id'] = I('u');
		$rel = M('menu')->where($where)->delete();
		if($rel){
			$this->success('操作成功！','/Home/User/menu_list');exit;
		}else{
			$this->error('哎呀，出错了！');
		}
	}
	

//验证码方法
	public function verify(){
		$Verify = new \Think\Verify();
		$Verify->fontSize = 15;
		$Verify->length   = 4;
		$Verify->useNoise   = false;
		ob_clean();
		$Verify->entry();
	}

//菜单功能列表
	public function menu_capacity(){
		$u = I('u');
		$rel = M('menu')->where("`relation_Id`='".$u."'")->select();
		$param['before_menu'] = "菜单列表";
		$param['current_menu']= "菜单功能";
		$param['before_url']  = "/Home/User/menu_list";
		$param['menu'] 		  = "menu_list";//定义显示页面
		$param['u'] 		  = $u;
		$this->assign('menu_list',$rel);
		$this->assign('param',$param);
		$this->display();
		
	}
	
//菜单功能添加
	public function menu_capacity_edit(){
		$u = I('u');
		$menu_Id = I('menu_Id');
		if(IS_POST){
			$o = I('o');
			if(I('menu_name') == ''){
				$this->error('功能名称必须填写！');
			}elseif(I('menu_url') == ''){
				$this->error('功能地址必须填写！');
			}
			if($o == 'add'){
				$data['menu_name']   = I('menu_name');
				$data['menu_url']    = I('menu_url');
				$data['menu_sort']   = 0;
				$data['menu_status'] = I('menu_status');
				$data['menu_show']   = I('menu_show');
				$data['relation_Id'] = $u;
				$data['add_time'] 	 = time();
				$add = M('menu')->add($data);
				if($add){
					$this->success('操作成功！','/Home/User/menu_capacity/u/'.$u);exit;
				}else{
					$this->error('哎呀，出错了！');exit;
				}
				
			}
		}
		
		$param['before_menu'] = "菜单列表";
		$param['current_menu']= "新增功能";
		$param['before_url']  = "/Home/User/menu_list";
		$param['title'] 	  = "添加";
		$param['menu_from_url'] 	  = "/Home/User/menu_capacity_edit";
		//$param['menu_Id']	  = $menu_Id;
		$param['u']	  		  = $u;
		$param['o']	  		  = "add";
		$this->assign('param',$param);
		$this->display('menu_capacity');
	}

//菜单功能编辑
	public function menu_capacity_redact(){
		$u = I('u');
		$Model = M('menu');
		$rel = $Model->where("`menu_Id`='".$u."'")->find();
		if(IS_POST){
			if(I('menu_name') == ''){
				$this->error('功能名称必须填写！');
			}elseif(I('menu_url') == ''){
				$this->error('功能地址必须填写！');
			}
			$o = I('o');
			if($o == 'edit'){
				$data['menu_name']   = I('menu_name');
				$data['menu_url']    = I('menu_url');
				$data['menu_status'] = I('menu_status');
				$data['menu_show']   = I('menu_show');
				$upd = $Model->where("`menu_Id`='".$u."'")->save($data);
				
				if($upd){
					$this->success('操作成功！','/Home/User/menu_capacity/u/'.$rel['relation_Id']);exit;
				}else{
					$this->error('哎呀，出错了！');exit;
				}
			}
		}
		
		$param['before_menu'] = "菜单列表";
		$param['current_menu']= "修改功能";
		$param['before_url']  = "/User/menu_list";
		$param['title'] 	  = "修改";
		$param['menu_from_url'] 	  = "/Home/User/menu_capacity_redact";
		//$param['menu_Id']	  = $menu_Id;
		$param['o']	  		  = "edit";
		$param['u']	  		  = $u;
		
		$this->assign('param',$param);
		$this->assign('menu_data',$rel);
		$this->display('menu_capacity');
		
	}
	
//功能菜单删除
	public function menu_capacity_del(){
		$u = I('u');
		$del = M('menu')->where("`menu_Id`='".$u."'")->delete();
		if($del){
			$this->success('操作成功!');exit;
		}else{
			$this->error('哎呀，出错了!');exit;
		}
		
	}
	

//角色列表
	public function roleList()
	{
		$roleModel = M('role');
		$rel = $roleModel->order('role_Id asc')->select();
		$this->assign('roleList', $rel);
		$this->assign('menu', "list");
		$this->display('public');
	}

	
//角色添加
	public function roleAdd()
	{
		$columnlist = M('role')->field('role_Id,role_name')->select();
		$this->assign('columnlist',$columnlist);//栏目菜单下拉列表
		$roleModel = M('role');
		$where['role_Id']= I('editId');
		$rel_1['menu_titles_button'] = '确定';
		$rel_1['type'] = 'add';
		$menu_all = menu_all();

		$this->assign('menu_from_url','/Home/User/roleEdit');//发送数据提交菜单
		$this->assign('role',$rel_1);						 //角色信息查询
		$this->assign('menu_all',$menu_all);				 //菜单列表
		$this->display('public');
	}

//角色编辑
	public function roleEdit()
	{	
		$roleModel = M('role');
		if(IS_POST){
			
			$type = I('type');			//接收类型参数
			$role_name    = I('role_name');//接收角色名
			
			if($role_name == ''){		
				$this->error('角色名不能为空！');
			}
			
			if($role_num_test != NULL){
				$this->error('角色编号已存在！');exit;
			}

			$role_status = I('role_status');//接收角色状态
			$role_identity = I('role_identity');//接收角色身份

			//组装需要写入的数据
			$data['role_name'] 	 = $role_name;
			$data['role_identity'] 	 = $role_identity;
			$data['role_status'] = $role_status;
			$data['add_time'] 	 = time();

			$rolemenu = M('rolemenu');
			
			$menu_list = $_POST;//接收post参数
			
			//过滤需要加入角色——用户表的其他数据
			foreach($menu_list as $k => $v){
				if($k == 'role_name'){
					unset($menu_list[$k]);
				}elseif($k == 'role_status'){
					unset($menu_list[$k]);
				}elseif($k == 'roleId'){
					unset($menu_list[$k]);
				}elseif($k == 'role_identity'){
					unset($menu_list[$k]);
				}elseif($k == 'type'){
					unset($menu_list[$k]);
				}elseif($k == 'role_num'){
					unset($menu_list[$k]);
				}else{
					if( !is_numeric($v) ){
						$menu_list[$k] = (int)$v;
					}
				}
			}

			$roleModel->startTrans();	//开启事务验证
			if($type == 'add')
			{
				$role_test = $roleModel->where("role_name='".$data['role_name']."'")->find();
				if(!empty($role_test)){
					$this->error('角色名已存在！');exit;
				}
				
				$role_num  = I('role_num');//接收角色状态

				if($role_num == '' || $role_num < 10 || $role_num > 99){
				
					$this->error('角色编号不合法！');
				
				}
			
				$role_num_test = $roleModel->where("role_num='".$role_num."'")->find();
			
				$data['role_num'] = $role_num;
				
				$rel =$roleModel->data($data)->add();
				if($rel){
					$roleId = $rel;
				}
			}
			elseif($type == 'edit')
			{
				$roleId = I('roleId');
				//查询这个角色是否存在
				$select = $roleModel->where("`role_Id`='".$roleId."'")->find();
				if(!$select){
					$this->error('哎呀，出错了！');exit;
				}
				//进行修改操作
				$result = $roleModel->where("`role_Id`='".$roleId."'")->save($data);//修改角色
				//删除之前这个角色所拥有的所有权限，为更新权限做准备
				$del = $rolemenu->where("`role_Id`='".$roleId."'")->delete();
			}
			
			//插入角色目录表（赋权限）
			foreach($menu_list as $key => $val){
				$data_1['role_Id'] = $roleId;
				$data_1['menu_Id'] = $menu_list[$key];
				$data_1['addtime'] = time();
				$rel = M('rolemenu')->data($data_1)->add();
				if(!$rel){
					$roleModel->rollback();
					$this->error('哎呀，出错了！');exit;
				}
			}
			$roleModel->commit();
			$this->success('操作成功！','/Home/User/roleList');exit;
			
		}
		
		$where['role_Id']= I('editId');
		$rel_1 = $roleModel->where($where)->find();
		$rel_1['menu_titles_button'] = '确定';
		$rel_1['type'] 				 = 'edit';
		$rel_1['role_Id'] 			 = $where['role_Id'];
		$menu_all = menu_all();
		$this->assign('menu_from_url','/Home/User/roleEdit');//发送数据提交菜单
		$roleNum = M('system_variables')->where("variable_type=2")->select();
		$this->assign('roleNum',$roleNum);
		$this->assign('role',$rel_1);						//角色信息查询
		$this->assign('menu_all',$menu_all);			//菜单列表
		$this->display('public');
	}
	

//角色删除 
	public function roleDel(){
		//实例化
		$roleModel = M('role');
		//接收参数
		$roleId = I('delId');
		
		//条件 
		$where['role_Id'] = $roleId;
		//开启事务
		$roleModel->startTrans();
		$rel = $roleModel->where($where)->find();
		
		if(!$rel){
			$this->error("哎呀，出错了！");exit;
		}
		
		$del_1 = $roleModel->where($where)->delete();
		$del_2 = M('rolemenu')->where($where)->delete();

		if($del_1 || $del_2){
			$roleModel->commit();
			$this->success("删除成功！");exit;
		}else{
			$roleModel->rollback();
			$this->error("哎呀，出错了！");exit;
		}
		
	}
	
	
	
/*用户管理*/	
	//用户列表
	public function user_list(){
		$userModel=M("user as a");
		if( session('role_identity') == 1){
			$where['a.company_id'] = session('company');
		}
			
		$count = $userModel->where($where)->count();//统计所有的条数。
		$page = new \Org\Util\Page($count,20);//实例化分页模型
		$dataInfo = $userModel->field("a.*,b.company_name")->join("LEFT JOIN `cs_company` as b ON a.company_id = b.company_id")->where($where)->order('addtime desc')->limit($page->limit[0],$page->limit[1])->select();//查询所有数据
			
		foreach($dataInfo as $k=>$v ){
				$dataInfo[$k]['role'] = get_role($v['user_Id']);//查询用户所属角色
				
				if( $v['ser_uid'] > 0 ){
					$dataInfo[$k]['service'] = get_server($v['ser_uid']);
				}
				if( $v['manager_uid'] >0 ){
					$dataInfo[$k]['manager'] = get_manager($v['manager_uid']);
				}
				
		}
		$show = $page->show();//分页
		$this->assign('dataPage',$show);
		$this->assign("user_list",$dataInfo);
		$this->display();
	}	
	
	//新增用户
	
	public function user_add(){
		if($_POST){
			$data['username']=I("post.username");
			$data['password']=md5(I("post.password").'cs');
			$data['real_name']=I("post.real_name");
			$id = I('u');
			//zy已写死判断新增的是否是业务员，是业务员就有值，不是业务员就没有值null
			$role_id = I("post.role_id");
			if($role_id == 0 || $role_id == null)
			{
				$this->error('请选择所属角色');exit;
			}
			$arr =M('role')->field('role_position')->where("role_Id=$role_id")->find();
			// 把数组role_position值取出来
			$arr_role_position = $arr['role_position'];			
			if($arr_role_position=='3'){
				$data["ser_uid"]=I("post.real_name_to");
				$data["manager_uid"]=I("post.real_name_to2");

			}else{
				$data["ser_uid"]="";
				$data["manager_uid"]="";
			}
			
			$data['is_use']=I("post.is_use");
			$data['tel']=I("post.tel");
			$data['number']=I("post.number");
			$data['addtime']=time();
			$data['company_id'] = I("post.user_company");


			//获取role表中的role_id
			// $role_id=implode('',I("post.role_id"));
			// $data['user_Id'] = $role_id;
			//根据role_id在userrole表中查询

			//数组转化字符串
			$role_num= M('role')->field('role_num')->where("role_Id='$role_id'")->find();
			$rnum = $role_num['role_num'];

			// 获取组织ID字段并查num
			$company_id = I("post.user_company");
			// var_dump($company_id);exit;
			$company_num = M('company')->where("company_id='$company_id'")->find();
			$cnum = $company_num['company_num'];
			// 拼起来 组织+角色+4位随机
			
			$username = $cnum.$rnum.rand(1000,9999);
			
			$count1 = M('user')->where("username='$username'")->count();	
			while (intval($count1)>0) {  
					$username = $role_id.$company_id.rand(1000,9999);
			} 
			
			$data['username'] = $username;


			//zy自己编写end
			$insert_id=M("user")->add($data);
			//zy把信息添加user表后，查询user表中的此时的user_Id，然后将此时的user_Id和role_id插入到userrole表中
			//zy通过username唯一性查到相应的user_Id
			$username1 = $data['username'];
			$u = M("user")->where("username='$username1'")->find();
			$u_i = $u['user_Id'];
			//将获取到的user_Id和role_id插入表userrole中，
			$userrole1['user_Id']=$u_i;
			$userrole1['role_Id']=$role_id;
			// $userrole2 = M('userrole')->add($userrole1);
			
			$check_name=M("user")->where("username=".I("post.username"))->find();
			// if(!empty($check_name)){
			// 	$this->error("用户名已经存在",'/Home/User/user_add');
			// }			
			if($insert_id){
				
				$role_id=I("post.role_id");
				$length=count($role_id);
				
				for($i=0;$i<$length;$i++){
					$time_=time();
					M("userrole")->add(array('role_Id'=>$role_id,'user_Id'=>$insert_id,'time'=>$time_));
					
				}
				$this->success("添加成功",'/Home/User/user_list');
			}else{
				$this->error("添加失败",'/Home/User/user_list');
				
			}
			
		}else{
			$role_identity = session('role_identity');//角色类型
			$company12 = session('company');//组织ID
		
			//zy编写
			
			if($role_identity === '0'){
				$role=M("role")->where("role_status=1")->select();
				$company = M('company')->field("company_id,company_name")->where("company_status=1")->select();				
			}else{
				$role=M("role")->where("role_status=1 and role_identity=1")->select();
				// $company = M('company')->field("company_id,company_name")->where("company_status=1")->select();		
				$company = M('company')->field("company_id,company_name")->where("company_status=1 and company_id='$company12'")->select();		
						
			}
			$this->assign('mark',$role_identity);
			$this->assign('company',$company);
			$this->assign("role",$role);
			// $this->assign("real_name_to",$real_name_to);
			$this->display();
			
		}
		
	
	}
	//客服
	public function ajax_kefu(){
	//zy编写ajax
		$c_id = $_POST['name'];
		// var_dump($c_id);exit;
		$c = M('user')->where("company_id='$c_id'")->select();
			 $where_role['a.role_position'] = 2;
			$sql = "SELECT c.user_Id FROM `cs_user` as c where c.user_Id in ( SELECT b.user_Id FROM `cs_role` as a LEFT JOIN `cs_userrole` as b ON a.role_Id=b.role_Id WHERE ( a.role_position = 2 ) and c.company_id = '$c_id' )";
			$sql2 = "SELECT c.user_Id FROM `cs_user` as c where c.user_Id in ( SELECT b.user_Id FROM `cs_role` as a LEFT JOIN `cs_userrole` as b ON a.role_Id=b.role_Id WHERE ( a.role_position = 1 ) and c.company_id = '$c_id' )";
			$Model = M();
			$result1 = $Model->query($sql);
			$result2 = $Model->query($sql2);
			// 二维数组变一维数组
			$result = array_reduce($result1, function ($result, $value) {
			    return array_merge($result, array_values($value));
			}, array());
			$result3 = array_reduce($result2, function ($result, $value) {
			    return array_merge($result, array_values($value));
			}, array());
			// zy将遍历出来长沙的客服存入数组当中了
			foreach ($result as $key => $value) {
				$rn = M("user")->field("real_name,user_Id")->where("user_Id='$value'")->find();
				
				$tp['real_name'] = $rn['real_name'];
				$tp['user_Id'] = $rn['user_Id'];
				$real_name_to[]  = $tp;
			}
			echo json_encode($real_name_to);
			//zy编写
	}
	

	//绑定业务员区域经理
		public function ajax_kefu2(){
	//zy编写ajax
		$c_id = $_POST['name'];

		// echo $c_id;
		$c = M('user')->where("company_id='$c_id'")->select();
			$sql = "SELECT c.user_Id FROM `cs_user` as c where c.user_Id in ( SELECT b.user_Id FROM `cs_role` as a LEFT JOIN `cs_userrole` as b ON a.role_Id=b.role_Id WHERE ( a.role_position = 1 ) and c.company_id = '$c_id' )";
			$Model = M();
			$result1 = $Model->query($sql);
			// 二维数组变一维数组
			$result = array_reduce($result1, function ($result, $value) {
			    return array_merge($result, array_values($value));
			}, array());
					// zy将遍历出来长沙的区域经理存入数组当中了
			foreach ($result as $key => $value) {
				$rn = M("user")->field("real_name,user_Id")->where("user_Id='$value'")->find();
				
				$tp['real_name'] = $rn['real_name'];
				$tp['user_Id'] = $rn['user_Id'];
				$real_name_to[]  = $tp;
			}

			echo json_encode($real_name_to);
			//zy编写
	}
	//绑定业务员区域经理end
	
	//修改用户
	
	public function user_edit(){
		if($_POST){
			$save['user_Id']  = I("post.user_Id");
			$save['username'] = I("post.username");
			$save['real_name']= I("post.real_name");
			$save['tel']      = I("post.tel");
			$save['is_use']   = I("post.is_use");	
			// $role_id = I("post.role_id");		
			// $save['password']   = I("post.password");	
			//edit中需要
			//zy已写死判断新增的是否是业务员，是业务员就有值，不是业务员就没有值null
			$role_id = I("post.role_id");
			$arr =M('role')->field('role_position')->where("role_Id=$role_id")->find();
			// 把数组role_position值取出来
			$arr_role_position = $arr['role_position'];	
			if($arr_role_position=='3'){
				$save["ser_uid"]=I("post.real_name_to");
				$save["manager_uid"]=I("post.real_name_to2");

			}else{
				$save["ser_uid"]="";
				$save["manager_uid"]="";
			}
			
			//传给ajax
			$ser_uidi = $save["ser_uid"];
			$manager_uidi = $save["manager_uid"];
			$save['company_id'] = I("post.user_company");
			//edit中需要end		
			$res=M("user")->save($save);
			$userid  = I("post.user_Id");
			
			
			// var_dump($userid);exit;
			//zy查询该用户已有的角色，如果已经修改，则删除当前角色，添加全部选择的角色
			//zy通过手段查询得到$role_id(是一个数组形式)而不是post传
			//zy通过userid查询userrole表得到
			$role_id = M("userrole")->field('role_Id')->where("user_Id='$userid'")->find();
			$current_role=M("userrole")->where("user_Id=".$userid)->field("role_Id")->select();
			
			if(count($current_role)!=count($role_id)){
				
				M("userrole")->where("user_Id=".$userid)->delete();
					
				foreach($role_id as $k=>$v){
					$time_=time();
					M("userrole")->add(array('role_Id'=>$v['role_Id'],'user_Id'=>$userid,'time'=>$time_));
				
				}
					
				$this->success("修改成功",'/Home/User/user_list');
				exit;
				
			}else{

				$mark=0;
				foreach($role_id as $k=>$v){

					foreach($current_role as $k1=>$v1){

						if($v==$v1['role_Id']){
							$mark++;
						}
						
					}
					
				}
				
				if($mark!=count($current_role)){
					
					M("userrole")->where("user_Id=".$userid)->delete();
					
					foreach($role_id as $k=>$v){
						$time_=time();
						M("userrole")->add(array('role_Id'=>$v,'user_Id'=>$userid,'time'=>$time_));
					
					}
					
					$this->success("修改成功",'/Home/User/user_list');
					exit;
				}
				
			
			}
			if($res){
				
				$this->success("修改成功",'/Home/User/user_list');
				exit;
				
			}else{
				
				$this->error("修改失败",'/Home/User/user_list');
				exit;
				
			}
		
		}else{
			
			$user_Id=I("get.u");
			//根据所属的组织遍历出所有属下的区域经理
			$au = M("user")->field("company_id")->where("user_Id='$user_Id'")->find();
			$c_id = $au['company_id'];
			// var_dump($c_id);exit;

			//遍历所属区域经理
			$c = M('user')->where("company_id='$c_id'")->select();
			$sql = "SELECT c.user_Id FROM `cs_user` as c where c.user_Id in ( SELECT b.user_Id FROM `cs_role` as a LEFT JOIN `cs_userrole` as b ON a.role_Id=b.role_Id WHERE ( a.role_position = 1 ) and c.company_id = '$c_id' )";
			$Model = M();
			$result1 = $Model->query($sql);
			// 二维数组变一维数组
			$result = array_reduce($result1, function ($result, $value) {
			    return array_merge($result, array_values($value));
			}, array());
					// zy将遍历出来长沙的区域经理存入数组当中了
			foreach ($result as $key => $value) {
				$rn = M("user")->field("real_name,user_Id")->where("user_Id='$value'")->find();
				
				$tp['real_name'] = $rn['real_name'];
				$tp['user_Id'] = $rn['user_Id'];
				$real_name_to[]  = $tp;
			}
			// var_dump($real_name_to);exit;
			//根据所属的组织遍历出所有属下的客服
			$where_role['a.role_position'] = 2;
			$sql4 = "SELECT c.user_Id FROM `cs_user` as c where c.user_Id in ( SELECT b.user_Id FROM `cs_role` as a LEFT JOIN `cs_userrole` as b ON a.role_Id=b.role_Id WHERE ( a.role_position = 2 ) and c.company_id = '$c_id' )";
			$Model = M();
			$result4 = $Model->query($sql4);
			$result5 = array_reduce($result4, function ($result, $value) {
			    return array_merge($result, array_values($value));
			}, array());
			foreach ($result5 as $key5 => $value5) {
				$rn5 = M("user")->field("real_name,user_Id")->where("user_Id='$value5'")->find();
				
				$tp5['real_name'] = $rn5['real_name'];
				$tp5['user_Id'] = $rn5['user_Id'];
				$real_name_to5[]  = $tp5;
			}
			// var_dump($real_name_to5);exit;
						
			
			// 绑定组织公司
			$conpany_id_to = M("user")->field('company_id')->where("user_Id='$user_Id'")->find();
			$c_i_t = $conpany_id_to['company_id'];
			//绑定角色
			$role_to = M("userrole")->field("role_Id")->where("user_Id='$user_Id'")->find();
			$role_toto=$role_to['role_Id'];
			// var_dump($role_to);exit;
			//绑定组织
			// $company1['cid'] = $c_i_t;
			// var_dump($company);exit;
			// var_dump($company['cid']);exit;
			$data=M("user")->where("user_Id='$user_Id'")->find();
			$role=M("role")->where("role_status=1")->select();
			$datay_ser_uid = $data['ser_uid'];
			$manager_uid = $data['manager_uid'];
			$role_identity = session('role_identity');//角色类型
			if($role_identity === '0'){
				$role=M("role")->where("role_status=1")->select();
				$company = M('company')->field("company_id,company_name")->where("company_status=1")->select();				
			}else{
				$role=M("role")->where("role_status=1 and role_identity=1")->select();
			}
			$this->assign("role",$role);
			$this->assign("company",$company);
			$this->assign("data",$data);
			//绑定组织
			$this->assign("c_i_t",$c_i_t);
			//绑定角色
			$this->assign("role_toto",$role_toto);
			//给绑定客服
			$this->assign("real_name_to",$real_name_to5);
			//给绑定区域经理
			$this->assign("real_name_to2",$real_name_to);
			//user_Id传送
			$this->assign("datay_ser_uid",$datay_ser_uid);
			$this->assign("manager_uid",$manager_uid);		
			$this->display();
		}
		
		
		
	}
// 修改ajax2017年6月7日20:46:43
	public function ajax_kefu_1(){
	//zy编写ajax
		$c_id = $_POST['name'];
		// var_dump($c_id);exit;
		$c = M('user')->where("company_id='$c_id'")->select();
			 $where_role['a.role_position'] = 2;
			$sql = "SELECT c.user_Id FROM `cs_user` as c where c.user_Id in ( SELECT b.user_Id FROM `cs_role` as a LEFT JOIN `cs_userrole` as b ON a.role_Id=b.role_Id WHERE ( a.role_position = 2 ) and c.company_id = '$c_id' )";
			$sql2 = "SELECT c.user_Id FROM `cs_user` as c where c.user_Id in ( SELECT b.user_Id FROM `cs_role` as a LEFT JOIN `cs_userrole` as b ON a.role_Id=b.role_Id WHERE ( a.role_position = 1 ) and c.company_id = '$c_id' )";
			$Model = M();
			$result1 = $Model->query($sql);
			$result2 = $Model->query($sql2);
			// 二维数组变一维数组
			$result = array_reduce($result1, function ($result, $value) {
			    return array_merge($result, array_values($value));
			}, array());
			$result3 = array_reduce($result2, function ($result, $value) {
			    return array_merge($result, array_values($value));
			}, array());
			// zy将遍历出来长沙的客服存入数组当中了
			foreach ($result as $key => $value) {
				$rn = M("user")->field("real_name,user_Id")->where("user_Id='$value'")->find();
				
				$tp['real_name'] = $rn['real_name'];
				$tp['user_Id'] = $rn['user_Id'];
				$real_name_to[]  = $tp;
			}
			echo json_encode($real_name_to);
			//zy编写
	}
	

	//绑定业务员区域经理
		public function ajax_kefu2_1(){
	//zy编写ajax
		$c_id = $_POST['name'];

		// echo $c_id;
		$c = M('user')->where("company_id='$c_id'")->select();
			$sql = "SELECT c.user_Id FROM `cs_user` as c where c.user_Id in ( SELECT b.user_Id FROM `cs_role` as a LEFT JOIN `cs_userrole` as b ON a.role_Id=b.role_Id WHERE ( a.role_position = 1 ) and c.company_id = '$c_id' )";
			$Model = M();
			$result1 = $Model->query($sql);
			// 二维数组变一维数组
			$result = array_reduce($result1, function ($result, $value) {
			    return array_merge($result, array_values($value));
			}, array());
					// zy将遍历出来长沙的区域经理存入数组当中了
			foreach ($result as $key => $value) {
				$rn = M("user")->field("real_name,user_Id")->where("user_Id='$value'")->find();
				
				$tp['real_name'] = $rn['real_name'];
				$tp['user_Id'] = $rn['user_Id'];
				$real_name_to[]  = $tp;
			}

			echo json_encode($real_name_to);
			//zy编写
	}
	//绑定业务员区域经理end
// end修改ajax2017年6月7日20:46:43end





	
	//删除用户
	public function user_del(){
		$user_id=I("get.u");
		$res_ax=M('business')->field('saleman_id')->where("saleman_id=".$user_id)->find();
		if ($res_ax) {
			$this->success("删除失败，该业务员名下仍有关联商家，请先到商家管理模块更换业务员再进行删除操作。",'/Home/User/user_list');
		}else{
			M("user")->where("user_Id=$user_id")->delete();
			M("userrole")->where("user_Id=$user_id")->delete();
			$this->success("删除成功",'/Home/User/user_list');
		}

	}
	
	//修改用户密码
	public function edit_pwd(){
		
		if($_POST){
			$user_id=I("post.u");
			//$oldpwd=md5(I("post.oldpwd")."cs");
			$newpwd=md5(I("post.newpwd")."cs");
			$confirmpwd=md5(I("post.confirmpwd")."cs");
			if($newpwd!=$confirmpwd){
				$this->error("新密码与重复密码不一致");
			}
						
			$verify = I('verify');
			$check_verify = check_verify($verify);
			if(!$check_verify){
				$this->error('验证码错误！');
			}
			
			$change=M("user")->where("user_Id=$user_id")->save(array('password'=>$newpwd));
			if($change){
				
				$this->success("修改密码成功",'/Home/User/user_list');
			}else{
				$this->error("修改密码失败");
				
			}
			
			
		}else{
			$user_id=I("get.u");
			$this->assign("u",$user_id);
			$this->display();
		}
		
		
	}
	
	
   
   

	
	
	


}
