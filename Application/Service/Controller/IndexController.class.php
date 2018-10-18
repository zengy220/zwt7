<?php
namespace Service\Controller;
class IndexController{
	public function Index(){
		header("Content-type:text/html;charset=utf-8");
		echo '没有访问权限...';
	}

}