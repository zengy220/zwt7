<?php
namespace Web\Controller;
use Think\Controller;

class CommonController extends Controller
{
    //自动加载类
    public function _initialize(){
        $map['pid'] = 0;
        $map['status'] = 1;
        $topCol =  M('content_category')->where($map)->order('sort asc')->select();//项部栏目

        foreach($topCol as &$v){
            $vmap['pid']=$v['id'];
            $v['col_url'] = M('content_category')->where($vmap)->order('sort asc')->getField('col_url');
        }

        $ptpcode = I('ptpcode');
        $id = I('id');

        $pars['tpcode'] = $ptpcode;
        $pcolInfo =  M('content_category')->where($pars)->find();

        $sunCol = $this->getSunCol($ptpcode);
        if($id == ''){
            $map1['pid'] = $this->getIdByTpcode($ptpcode);
            $map1['status'] = 1;
            $res = M('content_category')->where($map1)->order('sort asc')->find();
            $id = $res['id'];
            $isShowTop = true;
            $this->assign('isShowTop',$isShowTop);
        }

        $colInfo=M("content_category")->where("tpcode='$ptpcode' and pid=0")->find();
		$bread_list=M("content_category")->where("id='$id'")->find();
		$this->assign('colInfo',$colInfo);
		$this->assign('bread_list',$bread_list);
        $this->assign('pcolInfo',$pcolInfo);

        $scolmap['id']= $id;
        $scolInfo =  $res = M('content_category')->where($scolmap)->find();
        $this->assign('pcolInfo',$pcolInfo);//当前顶级栏目信息
        $this->assign('scolInfo',$scolInfo);//当前子栏目信息

        //顶部广告
        $adtopimg = M('ad_list t1')->join("cs_ad_content t2 on t1.id = t2.ad_list_id",'left')->field("t2.img,t1.id,t2.title,t2.url")
            ->where('t1.simple_code='."'".$ptpcode."'")->order("sort asc")->find();
        if($adtopimg){
            $adtopimg['img'] = "http://".$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']."/upfile/".$adtopimg['img'];
            $this->assign('adimg',$adtopimg);
        }

        $this->assign('topCol',$topCol);
        $this->assign('id',$id);
        $this->assign('ptpcode',$ptpcode);
        $this->assign('sunCol',$sunCol);
    }

    //获取子栏目列表
    public function getSunCol($ptpcode)
    {
        $map1['status'] = 1;
        $map1['pid'] = $this->getIdByTpcode($ptpcode);
        return M('content_category')->where($map1)->order('sort asc')->select();
    }

    //根据简码获取ID
    public function getIdByTpcode($tpcode)
    {
        $map['tpcode'] = $tpcode;
        $pCol = M('content_category')->where($map)->find();//父栏目信息
        return $pCol['id'];
    }

    //根据id获取模版
    public function getTplById($id)
    {
        $map['id'] = $id;
        $pCol = M('content_category')->where($map)->find();//父栏目信息
        return $pCol['tpl'];
    }

}