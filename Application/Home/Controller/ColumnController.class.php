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
class ColumnController extends CommonController
{
	
//默认页展示
    public function index()
    {
		//菜单列表
		$colModel = M('content_category');
		$where_1['pid'] = 0;
		$list_1 = $colModel->where($where_1)->order('sort asc')->select();
		foreach($list_1 as &$val){
			//拼接显示字段
			$val['status'] = $val['status'] == 1 ? "<font color='#75B731'>启用</font>" : "<font color='#F83D35'>禁用</font>";

			$collist[] =$val;//组装新数组
			$where_2['pid'] = $val['id'];
			$list2 = $colModel->where($where_2)->order("sort asc")->select();
			if (!empty($list2)) {
				foreach ($list2 as &$vf) {
					$vf['name'] = "  &nbsp;&nbsp;--  " . $vf['name'];
					$vf['status'] = $vf['status'] == 1 ? "<font color='#75B731'>启用</font>" : "<font color='#F83D35'>禁用</font>";
					$collist[] = $vf;
				}
			}
		}

    	$this->assign('collist',$collist);
		$this->display();
       
    }

	//添加栏目
	public function add_index(){
		$columnlist = M('content_category')->field('id,name')->where("pid=0")->select();
		$this->assign('columnlist',$columnlist);//栏目菜单下拉列表
		$this->assign(' col_title','新增栏目');
		$this->assign('col', "add");
		$this->assign('col_from_url', "/".MODULE_NAME."/Column/post_column_add/");//from表单提交地址
		$this->display();
	}


	//栏目下拉列表
	public function col_menu($type=0){
		$colModel = M('content_category');
		if($type==1)
			$where_1['status'] = 1;
		$where_1['pid'] = 0;
		$col_menu = array();
		$list_1 = $colModel->where($where_1)->field('id,pid,name,status')->order('sort asc')->select();
		foreach($list_1 as &$key){
			//拼接显示字段
			$key['status'] = $key['status'] == 0 ? $key['name']." <font color='#F83D35'>(已隐藏)</font>" : $key['name'];

			$col_menu[] = $key;//组装新数组
			$where_2['pid'] = $key['id'];
			$list2 = $colModel->where($where_2)->field('id,pid,name,status')->order("sort asc")->select();
			if (!empty($list2)) {
				foreach ($list2 as &$vf) {
					$vf['name'] = "  &nbsp;&nbsp;&nbsp;&nbsp;--  " . $vf['name'];
					$col_menu[] = $vf;
				}
			}
		}
		return $col_menu;

	}


	//修改栏目
	public function edit_index(){
		$Model = M('content_category');
		$columnlist = M('content_category')->field('id,name')->where("pid=0")->select();
		$u = I('u');
		$col_data = $Model->where("`id`='".$u."'")->find();
		$this->assign('columnlist',$columnlist);//栏目菜单下拉列表
		$this->assign('col_data',$col_data);
		$this->assign('col_title','修改栏目');
		$this->assign('col', "edit");
		$this->assign('u', "$u");
		$this->assign('col_from_url', "/".MODULE_NAME."/Column/post_column_edit/");//from表单提交地址
		$this->display("add_index");
	}

	//添加栏目
	public function post_column_add(){

		if(IS_POST || $_FILES){
			$o = I('o');
			if(I('name') == ''){
				$this->error('栏目名称必须填写！');
			}
			if($o == 'add'){
				$data['name']   = I('name');
				$data['sort'] = I('sort');
				$data['col_url'] = I('col_url');
				$ac = I('tpcode');

				//栏目名称唯一性
				$count2 = M('content_category')->where("tpcode='$ac'")->count(); // $count 用户名在数据库出现的次数  
				if (intval($count2)>0) {  

			    $this->error('已存在同名的栏目编码'. $data['tpcode'] .'，请重新输入！');exit;
				} 

				if(I('pid')!='')
				$data['pid'] = I('pid',0);
				if($_FILES){
					list($n,$suffix)= explode('.',$_FILES['thumb']['name']);
					$img_name='/upfile/coloum/'.'column'.time().'.'.$suffix;
					move_uploaded_file($_FILES['thumb']['tmp_name'],'.'.$img_name);
					$data['thumb'] = $img_name;
				}
				$data['tpcode'] = I('tpcode');
				$data['status'] = I('status');
				$data['tpl'] = I('tpl');
				$data['create_time']  = time();

				//更新排序
				$add = M('content_category')->add($data);
				$tid = M('content_category')->getLastInsID();
				$tsort = I('sort');

				$smap['pid'] = I('pid',0);
				$sortarr = M('content_category')->field('sort,id')->order('sort asc')->where($smap)->select();
				$update = self::sort_to_sort($sortarr,$tid,$tsort);
				foreach($update as $k=>$v){
					M('content_category')->where("id=".$v['id'])->save(array('sort'=>$v['sort']));
				}

				if($add){
					$this->success('操作成功！','/'.MODULE_NAME.'/Column/index/');exit;
				}else{
					$this->error('哎呀，出错了！');exit;
				}
			}
		}
	}

	//修改栏目
	public function post_column_edit(){
		if(IS_POST || $_FILES){
			$o = I('o');
			if(I('name') == ''){
				$this->error('栏目名称必须填写！');
			}
			$u = I('u');

			if(I('pid')!=''){
				$paramc['id'] = $u;
				$col =  M('content_category')->where($paramc)->find();
				if($col['pid'] != I('pid')){
					if($col['pid'] ==0 ){
						$this->error('此栏目为顶级栏目，不可以更改父栏目！');exit;
					}
					$paramp['id'] = I('pid');
					$re =  M('content_category')->where($paramc)->find();
					if($re['pid']!=0){
						$this->error('不可以更改子栏目到非顶级栏目下');exit;
					}
				}

			}
			if($o == 'edit'){
				$data['name']   = I('name');
				$data['sort'] = I('sort');
				$data['pid']   = I('pid');
				$data['col_url'] = I('col_url');
				$data['tpcode']   = I('tpcode');
				$data['status']   = I('status');
				$data['tpl']   = I('tpl');
				$data['create_time'] 	 = time();
				$where['id'] = $u;
				$data['name']   = I('name');
				$acx= I('tpcode');
				//修改排序
				$id=I('u');
				$tosort =I('sort');

				//获取排序结果集
				$smap['pid'] = I('pid');
				$sortarr = M('content_category')->field('sort,id')->order('sort asc')->where($smap)->select();
				$update = self::sort_to_sort($sortarr,$id,$tosort);
				foreach($update as $k=>$v){
					M('content_category')->where("id=".$v['id'])->save(array('sort'=>$v['sort']));
				}

				//栏目名称唯一性
				$count1 = M('content_category')->where("tpcode='$acx' and id != $u")->count(); // $count 用户名在数据库出现的次数
				if (intval($count1)>0) {  

			    $this->error('已存在同名的栏目编码'. $data['tpcode'] .'，请重新输入！');exit;
				} 

				if($_FILES['thumb']['error']==0){
					list($n,$suffix)= explode('.',$_FILES['thumb']['name']);
					$img_name='/upfile/coloum/'.'column'.time().'.'.$suffix;
					$info =  M('content_category')->where($where)->find();
					if($info['thumb']){
						$img_name = $info['thumb'];
					}
					move_uploaded_file($_FILES['thumb']['tmp_name'],'.'.$img_name);
					$data['thumb'] = $img_name;
				}
				$rel =  M('content_category')->where($where)->save($data);
				if($rel){

					$this->success('操作成功！','/'.MODULE_NAME.'/Column/index/');exit;
				}else{
					$this->error('哎呀，出错了！');exit;
				}

			}
		}
	}

	//删除栏目
	public function col_del()
	{
		$u = I('u');
		$Model   = M('content_category');
		$premise = $Model->where("`pid`='".$u."'")->find();
		if($premise){
			$this->error('该目录下存在子目录,不可删除!');
		}
		$cocont =  M('content_content')->where("`col_id`=$u")->find();
		if($cocont){
			$this->error('该目录下存在栏目内容,不可删除!');
		}
		$rel = $Model->where("`id`='".$u."'")->delete();
		if($rel){
			$this->success('操作成功！','/'.MODULE_NAME.'/Column/index');exit;
		}else{
			$this->error('哎呀，出错了！');
		}
	}


	//栏目内容
	public function content_list()
	{
		//菜单列表
		if(empty($_POST)){
			$status = 1;
		}else{
			$status = I('status');
		}

		session('col_id',I('col_id'));
		session('c_status',I('c_status',0));
		session('status',$status);

		$colModel = M('content_content');
		$col_id = I('col_id');
		$type = 1;
		if(I('c_status') != 1){
			$type=0;
		}
		$where = "1=1";
		$col_menu =$this->col_menu($type);
		if($status!=1 ){
			$where =" status=1 ";
		}
		if($col_id){
			if($where)
				$sql = "select * from cs_content_content where col_id in (select id from cs_content_category where pid=$col_id or id=$col_id) and $where order by istop desc,create_time desc,update_time desc";
			else
				$sql = "select * from cs_content_content where col_id in (select id from cs_content_category where pid=$col_id or id=$col_id)  order by istop desc,create_time desc,update_time desc";

		}else{
			if($where)
				$sql = "select * from cs_content_content where " .$where."  order by istop desc,create_time desc,update_time desc";
			else
				$sql = "select * from cs_content_content  order by istop desc,create_time desc,update_time desc";
		}
		$content_list = $colModel->query($sql);
		$this->assign('c_status',I('c_status'));
		$this->assign('col_id',I('col_id'));
		$this->assign('status',$status);
		$this->assign('col_menu',$col_menu);
		$this->assign('content_list',$content_list);
		$this->display();

	}

	//添加栏目内容
	public function add_content(){
		$Model = M('content_content');
		$columnlist =$this->col_menu();
		$time = date("Y-m-d");
		$this->assign('columnlist',$columnlist);//栏目菜单下拉列表
		$this->assign('col_title','新增栏目内容');
		$this->assign('time', $time);
		$this->assign('col', "add");
		$this->assign('col_from_url', "/".MODULE_NAME."/Column/post_content_add/");//from表单提交地址
		$this->display();
	}

	//修改栏目内容
	public function content_edit_index(){
		$Model = M('content_content');
		$columnlist = $this->col_menu();
		$u = I('u');
		$content_data = $Model->where("`id`='".$u."'")->find();
		$this->assign('columnlist',$columnlist);//栏目菜单下拉列表
		$this->assign('content_data',$content_data);
		$this->assign('col_title','修改栏目内容');
		$this->assign('col', "edit");
		$this->assign('u', "$u");
		$this->assign('col_from_url', "/".MODULE_NAME."/Column/post_content_edit/");//from表单提交地址
		$this->display("add_content");
	}
	//添加栏目内容
	public function post_content_add(){

		if(IS_POST || $_FILES){
			$o = I('o');
			if(I('title') == ''){
				$this->error('内容标题必须填写！');
			}
			if(!I('col_id')){
				$this->error('所属栏目必须填写！');
			}
			if($o == 'add'){
				$data['title']   = I('title');
				$data['col_id']    = I('col_id');

				if($_FILES['thumb']['error']==0) {
					list($n,$suffix)= explode('.',$_FILES['thumb']['name']);
					$img_name='/upfile/content/'.'content'.time().'.'.$suffix;
					move_uploaded_file($_FILES['thumb']['tmp_name'],'.'.$img_name);
					$data['thumb'] = $img_name;
				}

				if(I('istop') != '' ){
					$data['istop'] = I('istop');
				}
				
				$status=I('status');
				if(strcmp($status,'')==0){
					$data['status'] = 1;
					
				}else{
					$data['status']=0;
				}
				
				$data['subtitle'] = I('subtitle');
				$data['description'] = I('description');
				$data['contents'] = htmlspecialchars_decode(I('contents'));
				$data['create_time']  =I('create_time');
				$add = M('content_content')->add($data);
				if($add){
					$this->success('操作成功！',U('/'.MODULE_NAME.'/Column/content_list/',array('col_id'=>I('col_id'),'status'=>1)));exit;
				}else{
					$this->error('哎呀，出错了！');exit;
				}

			}
		}
	}

	//删除栏目内容
	public function content_del()
	{
		$u = I('u');
		$Model   = M('content_content');
		$rel = $Model->where("`id`='".$u."'")->delete();
		if($rel){
			$this->success('操作成功！',U('/'.MODULE_NAME.'/Column/content_list/',array('col_id'=>session('col_id'),'status'=>session('status'),'c_status'=>session('c_status'))));exit;
		}else{
			$this->error('哎呀，出错了！');
		}
	}


	//修改栏目内容
	public function post_content_edit(){

		if(IS_POST || $_FILES){
			$o = I('o');
			if(I('title') == ''){
				$this->error('内容标题必须填写！');
			}
			if($o == 'edit'){
				if(!I('col_id')){
					$this->error('所属栏目必须填写！');
				}
				$data['title']   = I('title');
				$data['col_id'] = I('col_id');
				$where['id'] = I('u');
				if($_FILES['thumb']['error']==0){
					list($n,$suffix)= explode('.',$_FILES['thumb']['name']);
					$img_name='/upfile/content/'.'content'.time().'.'.$suffix;
					$info =  M('content_content')->where($where)->find();
					if($info['thumb']){
						$img_name = $info['thumb'];
					}
					move_uploaded_file($_FILES['thumb']['tmp_name'],'.'.$img_name);
					$data['thumb'] = $img_name;
				}
				$data['subtitle'] = I('subtitle');
				$data['description'] = I('description');
				$data['contents'] = htmlspecialchars_decode(I('contents'));
				$data['create_time'] = I('create_time');
				$data['update_time'] = date("Y-m-d h:i:s");
				$data['istop'] = 0;
				if(I('istop') != '' ){
					$data['istop'] = I('istop');
				}
				
				$status=I('status');
				if(strcmp($status,'')==0){
					$data['status'] = 1;
					
				}else{
					$data['status']=0;
				}

				$rel =  M('content_content')->where($where)->save($data);

				if($rel){
					$this->success('操作成功！',U('/'.MODULE_NAME.'/Column/content_list/',array('col_id'=>session('col_id'),'status'=>session('status'),'c_status'=>session('c_status'))));exit;
				}else{
					$this->error('哎呀，出错了！');exit;
				}

			}
		}
	}

	//联动排序
	static public function sort_to_sort($sortarr,$tid,$tsort){
		$nsort = $tsort+1;
		$update = array();
		foreach($sortarr as $key=>$v){
			$tp=array();
			$s = $v['sort'];
			$k = $v['id'];

			if($s<$tsort)
				continue;
			if($k==$tid) {
				$tp['sort'] = $tsort;
				$tp['id'] = $k;
				$update[] = $tp;
				continue;
			}
			if($s<$nsort){
				$tp['sort'] = $nsort;
				$tp['id'] = $k;
				$nsort ++;
				$update[] = $tp;
				continue;
			}

		}
		return $update;
	}
}
