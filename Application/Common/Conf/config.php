<?php
return array(
	//'配置项'=>'配置值'
	'URL_MODEL'=>2, //设置URL访问模式
	'URL_CASE_INSENSITIVE'=> true,
	'DEFAULT_MODULE'      => 'web',  // 默认模块
	'MODULE_ALLOW_LIST'   => array('web','Home','Wxchat','Service'),//允许访问的模块
	
	//数据库配置信息
	// 'DB_HOST'   => '193.112.18.247', // 服务器地址
	// 'DB_PWD'    => '!%hnsxjw123', // 密码
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_PWD'    => 'root', // 密码
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_NAME'   => 'zwt', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PORT'   => '3306', // 端口
	'DB_PREFIX' => 'cs_', // 数据库表前缀
	'DB_CHARSET'=> 'utf8',      // 数据库编码默认采用utf8
	
	//加密token
	'TOKEN'		=>  'hncpzw_2017_pingtaixinxishiyebu',
	//第一个身高id
	'ONE_HEIGHT_ID'    =>  '132',
	//第二个体重id
	'TWO_WEIGHT_ID'    =>  '133',
	//appId
    "APPID"=>'wx69c8b53849d51df2',
    "appId"=>'wx69c8b53849d51df2',
    "appSecret"=>"3e4ff6dc2fc2bc6d5dbaee1cd68534cb",


	
);