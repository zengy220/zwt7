<?php
namespace Web\Controller;
use Think\Controller;

class TestController extends CommonController
{
   
    public function index()
    {	 
    	$post = '410000';
		$appkey = 'cb847624f9d3e5e5';//你的appkey
		$zipcode = $post; //邮编
		$url = "http://api.jisuapi.com/zipcode/query?appkey=$appkey&zipcode=$zipcode";//外部接口
		$result = file_get_contents($url);
		$jsonarr = json_decode($result, true);
		 
		if($jsonarr['status'] != 0)
		{
		    echo $jsonarr['msg'];
		    exit();
		}
		 
		$result = $jsonarr['result'];
		foreach($result as $val)
		{
		    echo $val['province'].' '.$val['city'].' '.$val['town'].' '.$val['address'].' '.$val['zipcode'].'<br>';
		}

		


    }

    public function add(){
    	var_dump($_POST);exit;
    	
    }






	

}