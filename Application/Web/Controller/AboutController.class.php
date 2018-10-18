<?php
namespace Web\Controller;
use Think\Controller;

class AboutController extends CommonController
{

	//不带分页内容获取控制器
    public function content()
    {

        $map['col_id'] = $this->id;
        $map['status'] = 1;
        $contents = M('content_content')->order('istop desc,create_time desc,update_time desc')->where($map)->select();
        $this->assign('contents',$contents);
        $this->display($this->getTplById($this->id));
    }

	//带分页内容获取控制器
    public function page_content()
    {

		$map['col_id'] = $this->id;
		$map['status'] = 1;
		$count=M("content_content")->where($map)->count();
		$p=new \Org\Util\Page($count,10,"/page_content/id/$this->id/ptpcode/$this->ptpcode");
		$show=$p->show();
		$news=M("content_content")->where($map)->order('istop desc,create_time desc,update_time desc')->limit($p->limit[0],$p->limit[1])->select();
        $this->assign('show',$show);
		$this->assign('news',$news);
        $this->display($this->getTplById($this->id));

    }

	//带上下篇内容控制器
	public function page_detail(){
		$news_id=I("news_id");
		$news_id_array=M("content_content")->where("col_id=$this->id")->field('title,id')->order('istop desc,create_time desc,update_time desc')->select();

		$preInfo = array();//上一篇
		$nextInfo = array();//下一篇
		foreach($news_id_array as $key=>$v){
			if($v['id'] == $news_id){
				echo $key;
				$pk = $key-1;
				$nk = $key+1;
				if($pk>=0){
					$preInfo['id'] = $news_id_array[$pk]['id'];
					$preInfo['title'] = $news_id_array[$pk]['title'];
				}
				if($nk < count($news_id_array)){
					$nextInfo['id'] = $news_id_array[$nk]['id'];
					$nextInfo['title'] = $news_id_array[$nk]['title'];
				}
				break;
			}
		}
		$now_info = M("content_content")->where("id=$news_id")->find();
		$this->assign("now_info",$now_info);
		$this->assign("preInfo",$preInfo);
		$this->assign("nextInfo",$nextInfo);
		$this->display('page_detail');
	}

	//招商版块
	public function join_us(){

		if(IS_POST){
			$_POST['region'] = $_POST['s_province'].$_POST['s_city'].$_POST['s_county'];
			$_POST['createtime'] = date("Y-m-d H:i:s");
			$res = M("attract_investment")->add($_POST);
			if($res){

				echo  1;exit;
			}else{
				echo  0;exit;
			}
		}
		$this->display();
	}

	//商品列表页
	public function products_list(){
		$sarr = array(0,2);
		$pmap['sort2'] = array('in',$sarr);
		$count=M("pro")->where($pmap)->count();
		$p=new \Org\Util\Page($count,9);
		$show=$p->show();
		$productList = M("pro")->where($pmap)->order('sort asc')->field('id,thumb,names')->limit($p->limit[0],$p->limit[1])->select();
		$this->assign("productList",$productList);
		$this->assign("show",$show);
		$this->display('products_list');
	}

	//商品详情页
	public function products_detail(){
		$pro_id = I('pro_id');
		$sarr = array(0,2);
		$map['sort2'] = array('in',$sarr);
		$pro_id_array=M("pro")->where($map)->field('names,id')->order('sort asc')->select();
		$preInfo = array();//上一篇
		$nextInfo = array();//下一篇
		foreach($pro_id_array as $key=>$v){
			if($v['id'] == $pro_id){
				$pk = $key-1;
				$nk = $key+1;
				if($pk>=0){
					$preInfo['id'] = $pro_id_array[$pk]['id'];
					$preInfo['title'] = $pro_id_array[$pk]['names'];
				}
				if($nk < count($pro_id_array)){
					$nextInfo['id'] = $pro_id_array[$nk]['id'];
					$nextInfo['title'] = $pro_id_array[$nk]['names'];
				}
				break;
			}
		}

		$now_info = M("pro")->where("id=$pro_id")->find();
		$this->assign("now_info",$now_info);
		$this->assign("preInfo",$preInfo);
		$this->assign("nextInfo",$nextInfo);
		$this->display('products_detail');
	}


}