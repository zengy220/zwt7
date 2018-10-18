<?php
namespace Home\Controller;
use Think\Controller;
class AdvertiseController extends CommonController {
	
    public function ad_list(){
		$ad_list=M("ad_list as t1")->join("(select count(id) as sum_1,ad_list_id from cs_ad_content GROUP BY ad_list_id) t2 on t2.ad_list_id =t1.id ","left")->field("t2.sum_1,t1.id,t1.name,t1.simple_code,t1.illustration")->select();
		
		$this->assign("ad_list",$ad_list);
		$this->display();
	}
	
	public function ad_list_add(){
		if($_POST){
			$_POST['addtime']=time();
			//广告设置添加简码唯一性
			//查找简码相同的数量
			$ak = $_POST['simple_code'];
			$aid = $_POST['id'];

			$count1 = M("ad_list")->where("simple_code='$ak' and id !='$aid'")->count();
			//如果简码数量>0则弹出“已存在相同简码，请重新输入”
			if (intval($count1)>0) {  

  					  $this->error('已存在同名的简码'. $ak .'，请重新输入！');exit;
			} 


			$res=M("ad_list")->add($_POST);

			if($res){
				$this->success("新增广告位列表成功","/".MODULE_NAME."/Advertise/ad_list");
				
			}else{
				$this->error("新增广告位列表失败","/".MODULE_NAME."/Advertise/ad_list");
				
			}
			
			
			
		}else{
			
			$this->display();
			
		}
		
		
		
	}
	
	public function ad_list_edit(){
		if($_POST){
			// $name = $_POST['name'];
			if($_POST['name'] == ''){
				$this->error('名称必须填写！');
		    }
		    if($_POST['simple_code'] == ''){
				$this->error('简码必须填写！');
		    }
		    if($_POST['illustration'] == ''){
				$this->error('说明必须填写！');
		    }

			//广告设置添加简码唯一性
			//查找简码相同的数量
			$ak = $_POST['simple_code'];
			$aid = $_POST['id'];

			$count1 = M("ad_list")->where("simple_code='$ak' and id !='$aid'")->count();
			//如果简码数量>0则弹出“已存在相同简码，请重新输入”
			if (intval($count1)>0) {  

  					  $this->error('已存在同名的简码'. $ak .'，请重新输入！');exit;
			} 
			
			$res=M("ad_list")->save($_POST);
			if($res){
				$this->success("修改广告位列表成功","/".MODULE_NAME."/Advertise/ad_list");
				
			}else{
				$this->error("修改广告位列表失败","/".MODULE_NAME."/Advertise/ad_list");
				
			}
				
			
		}else{
			$ad_list_id=I("ad_list_id");
			$data=M("ad_list")->where("id='$ad_list_id'")->find();
			$this->assign("data",$data);
			$this->assign("ad_list_id",$ad_list_id);
			$this->display();
		}
		
		
	}
	
	public function ad_list_del(){
		$ad_list_id=I("ad_list_id");
		$data=M("ad_content")->where("ad_list_id='$ad_list_id'")->select();
		if(!empty($data)){
			$this->error("该广告位下有内容不能删除");
			exit;
		}
		
		$res=M("ad_list")->where("id='$ad_list_id'")->delete();
		if($res){
			$this->success("删除广告位列表成功","/".MODULE_NAME."/Advertise/ad_list");
		}else{
			$this->error("删除广告位列表失败","/".MODULE_NAME."/Advertise/ad_list");
		}
				
		
	}
	
	
	//广告内容
	public function ad_content_list(){
		$condition="1=1";
		$ad_list_id=I("ad_list_id");
		session('ad_list_id',I("ad_list_id"));
		if($ad_list_id!=''){
			$condition.=" and ad_list_id='$ad_list_id'";
			
		}
		
		$ad_content_list=M("ad_content")->where("$condition")->order('sort asc')->select();
		//广告位列表
		$ad_list=M("ad_list")->select();
		$this->assign("ad_list_id",$ad_list_id);
		$this->assign("ad_list",$ad_list);
		$this->assign("ad_content_list",$ad_content_list);
		$this->display();
		
	}
	
	public function ad_content_add(){
		if($_POST){
			list($n,$suffix)= explode('.',$_FILES['img']['name']);
			$tmp_name=$_FILES['img']['tmp_name'];
			$img_name='ad'.time().'.'.$suffix;
			move_uploaded_file($tmp_name,"./upfile/$img_name");
			$_POST['img']=$img_name;
			
			$_POST['addtime']=time();

			if($url = $_POST['url']){
				$preg='|^http://|';  //正则，匹配以http://开头的字符串
				if(!preg_match($preg,$url)) {  //如果不能匹配
					$url='http://'.$url;
				}
				$_POST['url'] = $url;
			}
			$res=M("ad_content")->add($_POST);

			//更新排序

			$tid = M('ad_content')->getLastInsID();
			$tsort = I('sort');
			$smap['ad_list_id']=I('ad_list_id');
			$sortarr = M('ad_content')->field('id,sort')->order('sort asc')->where($smap)->select();
			$update = ColumnController::sort_to_sort($sortarr,$tid,$tsort);
			foreach($update as $k=>$v){
				$r  = M('ad_content')->where("id=".$v['id'])->save(array('sort'=>$v['sort']));
			}
			if($res){
				$this->success("新增广告内容成功",U("/".MODULE_NAME."/Advertise/ad_content_list",array('ad_list_id'=>$_POST['ad_list_id'])));
			}else{
				$this->error("新增广告内容失败","/".MODULE_NAME."/Advertise/ad_content_list");
				
			}
			
			
			
		}else{
			$ad_list=M("ad_list")->field("id,name")->select();
			$this->assign("ad_list",$ad_list);
			$this->display();
		}
		
		
		
	}
	
	public function ad_content_edit(){
		if($_POST||$_FILES){
			if($url = $_POST['url']){
				$preg='|^http://|';  //正则，匹配以http://开头的字符串
				if(!preg_match($preg,$url)) {  //如果不能匹配
					$url='http://'.$url;
				}
				$_POST['url'] = $url;
			}
			if($_FILES['img']['error']!=0||!isset($_FILES['img']['error'])){
				
				$res=M("ad_content")->save($_POST);
				
			}else{
				
				//删除原来的图片
				$ad_content_id=I("id");
				$img_url=M("ad_content")->where("id='$ad_content_id'")->getField("img");
				unlink("./upfile/$img_url");
				list($n,$suffix)= explode('.',$_FILES['img']['name']);
				$tmp_name=$_FILES['img']['tmp_name'];
				$img_name='ad'.time().'.'.$suffix;
				move_uploaded_file($tmp_name,"./upfile/$img_name");
				$_POST['img']=$img_name;
				$res=M("ad_content")->save($_POST);

			}
			// 排序
			$tsort = I('sort');
			$tid = I('id');
			$smap['ad_list_id']=I('ad_list_id');
			$sortarr = M('ad_content')->field('id,sort')->order('sort asc')->where($smap)->select();
			$update = ColumnController::sort_to_sort($sortarr,$tid,$tsort);
			foreach($update as $k=>$v){
				$r  = M('ad_content')->where("id=".$v['id'])->save(array('sort'=>$v['sort']));
			}


			if($res || $r){
				$this->success("修改广告内容成功",U("/".MODULE_NAME."/Advertise/ad_content_list",array('ad_list_id'=>session('ad_list_id'))));
				
			}else{
				$this->error("修改广告内容失败","/".MODULE_NAME."/Advertise/ad_content_list");
				
			}
			
			
		}else{
			
			$ad_content_id=I("ad_content_id");
			$data=M("ad_content")->where("id='$ad_content_id'")->find();
			$ad_list=M("ad_list")->field("id,name")->select();
			$this->assign("data",$data);
			$this->assign("ad_list",$ad_list);
			$this->assign("ad_content_id",$ad_content_id);
			$this->display();
		}
		
		
	}
	
	
	public function ad_content_del(){
		
		$ad_content_id=I("ad_content_id");
		$res=M("ad_content")->where("id='$ad_content_id'")->delete();
		if($res){
			$this->success("删除广告内容成功",U("/".MODULE_NAME."/Advertise/ad_content_list",array('ad_list_id'=>session('ad_list_id'))));
		}else{
			$this->error("删除广告内容失败","/".MODULE_NAME."/Advertise/ad_content_list");
		}
				
		
	}


}