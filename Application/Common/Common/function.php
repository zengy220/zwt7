<?php
	//δ֪����,��ɾ
	function json_public($role_Id,$menu_Id)
	{	
	
	}
	//  �������򷽷�
	function arr_sort($array,$key,$order="asc")
	{//asc������ desc�ǽ���
			$arr_nums=$arr=array();
			foreach($array as $k=>$v){
				$arr_nums[$k]=$v[$key];
			}
			if($order=='asc'){
				asort($arr_nums);
			}else{
				arsort($arr_nums);
			}
			foreach($arr_nums as $k=>$v){
				$arr[$k]=$array[$k];
			}
			return $arr;
	}

	//��������̼Һ�
	function getRandBusinessId(){
		$str = 'cp';
		$num = '0123456789';
		for($i=0;$i<6;$i++){
			$str .= substr($num,rand(0,strlen($num)-1),1);
		}
		$rs = M('business')->field('business_id')->where("business_id='$str'")->find();
		if($rs){
			$str = getRandBusinessId();
		}
		return $str;
	}
	
	//�������ID
	function getRandomString($len, $chars=null)
	{
		if (is_null($chars)){
			//$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$chars = "abcdefghijkmnpqrstuvwxyz123456789";
		}  
		mt_srand(10000000*(double)microtime());
		for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
			$str .= $chars[mt_rand(0, $lc)];  
		}
		return $str;
	}
	
	//����9λ���������
	function getRandomStr9($num='9'){
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$str = '';
		for($i=0;$i<$num;$i++){
			$str .= substr($chars,rand(0,strlen($chars)-1),1);
		}
		return $str;
	}

//	��ǰ�û����õĲ˵���
	function menu_list(){
		//�ж��Ƿ�Ϊ��¼״̬
		  $userId = session('userId');
		$userName = session('userName');
		if(empty($userId) || empty($userName)){
			header('Location: /Index/index');
			exit;
		}
		$Model = M('userrole as a');

		
		//��ѯ��ǰ�û���ӵ�еĲ˵��б�
		$menu_sql = "SELECT menu_Id,menu_name,menu_url,relation_Id FROM `cs_menu` where menu_Id IN (SELECT distinct menu_Id FROM `cs_rolemenu` as a LEFT JOIN `cs_role` as b ON a.role_Id=b.role_Id where a.role_Id IN (SELECT role_Id FROM `cs_userrole` where (`user_Id` = '".$userId."' and b.`role_status` = 1 and `menu_status` = 1 and `relation_Id` = 0 and `menu_show` = 1) )) order by menu_sort asc";
		
		//�����
		$menuResult= $Model->query($menu_sql);
		$current_url = strtolower("/Home"."/".CONTROLLER_NAME."/".ACTION_NAME);
		foreach($menuResult as $key=>$val){
			
			$sql = "SELECT menu_Id,menu_name,menu_url,relation_Id FROM `cs_menu` where menu_Id IN (SELECT distinct menu_Id FROM `cs_rolemenu` as a LEFT JOIN `cs_role` as b ON a.role_Id=b.role_Id where a.role_Id IN (SELECT role_Id FROM `cs_userrole` where (`user_Id` = '".$userId."' and b.`role_status` = 1 and `menu_status` = 1 and `relation_Id` = '".$val['menu_Id']."' and `menu_show` = 1) )) order by menu_sort asc";
			
			$result = M()->query($sql);
			$menuResult[$key]['son'] = $result;

			foreach($result as $k=>$v){
				if(strtolower($v['menu_url']) == $current_url){
					$menuResult[$key]['key'] = $current_url;
				}
			}
			// if(in_array($current_url,$val)){
				// $menuResult[$key]['key'] = $current_url;
			// }
			
		}
		return $menuResult;

	}


//	���еĲ˵���
	function menu_all(){
		//��ѯ��ǰ�û���ӵ�еĲ˵��б�
		$menuModel = M('menu');
		$where['relation_Id'] = 0;
		$list1 = $menuModel->field('menu_Id,menu_name')->where($where)->select();//��ѯ��һ��˵�

        foreach ($list1 as $vs => $vl) {
			//��ѯ�ڶ���˵�
            $list2 = $menuModel->field('menu_Id,menu_name,relation_Id')->where("`relation_Id`='" . $vl['menu_Id']."'")->order('menu_sort asc')->select();
			foreach($list2 as $vd =>$vf){
				
				$where['relation_Id'] = $vf['menu_Id'];
				$list3 = $menuModel->where($where)->select();
				if(!empty($list3)){
					$list2[$vd]['grandson'] = $list3;
				}
				
			}
			$list1[$vs]['son'] = $list2;
		
        }
		
		return $list1;
		
	}
	
	
//�������ֶһ���¼��16λ�����id
	function getRandNum16(){
		$str = "0123456789";
		$rs = "";
		for($i=0;$i<16;$i++){
			$rs .= substr($str,rand(0,strlen($str)-1),1);
		}
		$rs = M('gift_exchange_record')->where('id='.$id)->find();
		if($rs){
			$rs = getRandNum16;
		}
		return $rs;
	}

//�������ֶһ���¼��12λ�����id	
	function getRandNum12(){
		$a = mt_rand(10000000,99999999);
		$b = mt_rand(10000000,99999999);
		return $a.$b;
	}
//��֤��֤��
	function check_verify($code, $id = '')
	{
		$verify = new \Think\Verify();
		return $verify->check($code, $id);
	}

	
	function text_role($role,$menu_Id)
	{	
		$menu = $menu_Id;
		$role = $role;
		$rel_1 = M('rolemenu')->field('menu_Id')->where("`role_Id`='".$role."'")->select();
		
		if($rel_1){
			foreach($rel_1 as $key => $val){
				if($val['menu_Id'] == $menu){
					return true;
					exit;
				}
			}
		}else{
			return false;
		}

	}

//��ȡ�û���ɫ
	function get_role($user_id){

		if( isset($user_id) ){
			$rel = M('userrole as a')->field('role_name')->join("LEFT JOIN `cs_role` as b ON a.role_Id=b.role_Id")->where("a.user_Id=".$user_id)->find();
			
			return $rel['role_name'];
		}else{
			return false;
		}
		
	}
	
//��ȡҵ��Ա�Ŀͷ�
	function get_server($user_id){
		
		if( isset($user_id) ){
			$rel = M('user')->field('real_name')->where("user_Id=".$user_id)->find();
			
			return $rel['real_name'];
		}else{
			return false;
		}
		
	}
	
//��ȡҵ��Ա��������
	function get_manager($user_id){
		
		if( isset($user_id) ){
			$rel = M('user')->field('real_name')->where("user_Id=".$user_id)->find();

			return $rel['real_name'];
		}else{
			return false;
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>