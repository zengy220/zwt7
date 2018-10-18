<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    //自动加载类
	public function _initialize(){
		  $userId = session('userId');
		$userName = session('userName');
		if(empty($userId) || empty($userName)){
			header("location:/Home/Index");
			exit;
		}
		$this->test_jurisdiction($userId);//调用
		$now_url = strtolower("/Home"."/".CONTROLLER_NAME."/".ACTION_NAME);
		$meuns_list = menu_list();
		$this->assign('now_url',$now_url);
		$memory['a'] = substr(G('begin','end','m'),2,4);
		$memory['b'] = 4000;
		$memory['c'] = round( $memory['a']/$memory['b'] * 100 , 2) . "%";
		$this->assign('memory',$memory);
		$this->assign('meuns_list',$meuns_list);
	}
	
	//检测权限类
	
	private function test_jurisdiction($userId){
		$userId = $userId;
		
		if(!session('jurisdiction')){
			
			$Model = M('userrole as a');
			//查询当前用户可拥有的菜单列表
			$menuSql = "SELECT menu_Id,menu_name,menu_url,relation_Id FROM `cs_menu` where menu_Id IN (SELECT distinct menu_Id FROM `cs_rolemenu` as a LEFT JOIN `cs_role` as b ON a.role_Id=b.role_Id where a.role_Id IN (SELECT role_Id FROM `cs_userrole` where (`user_Id` = '".$userId."' and b.`role_status` = 1 and `menu_status` = 1 ) )) ";
		
			//结果集
			$newData= $Model->query($menuSql);
			$data =array();
			foreach($newData as $key=>$val){
				if($val['menu_url'] != ''){
					$data[] = strtolower($val['menu_url']);
				}
			}
			session('jurisdiction',$data);
			
		}
		$super_admin = session('roleName');
		if($super_admin != '302ff00ddb9cb45c970a316e5212bb34'){
			$url = "/Home/".CONTROLLER_NAME."/".ACTION_NAME;
			$url_list = session('jurisdiction');
			$result = array_search(strtolower($url),$url_list);
				if($result === false){
					$this->error('对不起，您没有权限！');
				}
		}

	}
	//根据组织获取业务员列表
	public function get_salesman(){
		$role_identity = session('role_identity');
		$roleModel = M('userrole as a');
		if($role_identity == 0){//总部角色
			
			$res = $roleModel->field('c.user_Id,c.username,c.real_name,c.company_id')->join('LEFT JOIN `cs_role` as b ON a.role_Id=b.role_Id')->join('LEFT JOIN `cs_user` as c ON a.user_Id=c.user_Id')->where('b.role_position=3 and c.is_use=1')->select();
			
		}elseif($role_identity == 1){
			$company = session('company');
			$res = $roleModel->field('c.user_Id,c.username,c.real_name,c.company_id')->join('LEFT JOIN `cs_role` as b ON a.role_Id=b.role_Id')->join('LEFT JOIN `cs_user` as c ON a.user_Id=c.user_Id')->where('b.role_position=3 and c.is_use=1 and c.company_id='.$company)->select();
		}
		return $res;
	}
	
	//根据组织获取客服列表
	public function support_staff(){
		$role_identity = session('role_identity');
		$roleModel = M('userrole as a');
		if($role_identity == 0){//总部角色
			
			$res = $roleModel->field('c.user_Id,c.username,c.real_name,c.company_id')->join('LEFT JOIN `cs_role` as b ON a.role_Id=b.role_Id')->join('LEFT JOIN `cs_user` as c ON a.user_Id=c.user_Id')->where('b.role_position=2 and c.is_use=1')->select();
			
		}elseif($role_identity == 1){
			$company = session('company');
			$res = $roleModel->field('c.user_Id,c.username,c.real_name,c.company_id')->join('LEFT JOIN `cs_role` as b ON a.role_Id=b.role_Id')->join('LEFT JOIN `cs_user` as c ON a.user_Id=c.user_Id')->where('b.role_position=2 and c.is_use=1 and c.company_id='.$company)->select();
		}
		return $res;
	}

	/**
    * 导出数据为excel表格
    *@param $data    一个二维数组,结构如同从数据库查出来的数组
    *@param $title   excel的第一行标题,一个数组,如果为空则没有标题
    *@param $filename 下载的文件名
    *@examlpe 
	*访问方法 parent::exportexcel($rel,$title,$name);
    $stu = M ('User');
    $arr = $stu -> select();
    exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
	*/
	protected function exportexcel($data=array(),$title=array(),$filename='report'){
		header("Content-type:application/octet-stream");
		header("Accept-Ranges:bytes");
		header("Content-type:application/vnd.ms-excel");  
		header("Content-Disposition:attachment;filename=".$filename.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		//导出xls 开始
		if (!empty($title)){
			foreach ($title as $k => $v) {
				$title[$k]=iconv("UTF-8", "GB2312",$v);
			}
			$title= implode("\t", $title);
			echo "$title\n";
		}
		if (!empty($data)){
			foreach($data as $key=>$val){
				foreach ($val as $ck => $cv) {
					$data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
				}
				$data[$key]=implode("\t", $data[$key]);
				
			}
			echo implode("\n",$data);
		}
	}
	
//生成excel表格顶部标题
	protected function bubbling_sort($arr,$title,$title_1){//冒泡排序
		
		$i = 0;
		$j = '';
		foreach($arr as $key=>$val){
			$count = count($val);
			if( $count > $i ){
				$i = $count;
				$j = $key;
			}
			
		}

		$str = '';
		$n = 0;
		foreach($arr[$j] as $k => $v){
			if( 'pro_name_'.$n == $k ){
				//$str .= ',产品名称['.$n.'],补货数量,兑换数量,实际送货量';
				
				$arr =   array_merge( array('产品名称['.$n.']'),$title_1 );
				
				$title = array_merge($title,$arr);
				
				$n++;
			}
		} 
		return $title;
		
	}


	// 公共方法返回错误或者成功
	public function reply($page_index,$res){
		if($res){
					$this->success('删除成功！','/'.MODULE_NAME.'$page_index');exit;
			}else{
					$this->error('哎呀，出错了！');exit;
			}
	}



	
}