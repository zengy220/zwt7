<?php
namespace Home\Controller;
use Think\Controller;
class QuestionsearchController extends CommonController {
	
   	public function questionnaire(){
   		$Model=M('questionnaire');
		$collist =$Model->order('sort asc,create_time desc')->select();
		$www =$_SERVER['HTTP_HOST'];
		$this->assign('collist',$collist);
		$this->assign('www',$www);
		$this->display();
	}

	  function BMI($height,$weight)
    {
    	//公式是体质指数（BMI）=体重（kg）÷身高（m）2
    	$height=$height/100;
    	$BMI = round($weight/($height*$height),1);
    	if($BMI<'18.5'){
    		$res = "过轻";
    	}elseif('18.5'<=$BMI&&$BMI<='23.9'){
    		$res = "正常";
    	}elseif('24'<=$BMI&&$BMI<='27.9'){
    		$res = "过重";
    	}elseif('28'<=$BMI&&$BMI<='32'){
    		$res = "肥胖";
    	}else{
    		$res ="非常肥胖";
    	}
    	return $res.$BMI;
    }


  	//添加或删除问卷调查a
	public function questionnaire_add_index(){
		$Model=M('questionnaire');
		if(I('o') =='edit'){
			//修改的信息查询
			$where['id']=I('u');
			$col_data =$Model->where($where)->find();
			//查询属性
			$where_property['questionnaire_id']=I('u');
			$property =M('property')->where($where_property)->select();
			// var_dump($property);
			$this->assign('col_data', $col_data);
			$this->assign('property', $property);
			$this->assign('col', "edit");
			$this->assign('u', I('u'));
			$this->assign('o', 'edit');
			$this->assign('col_from_url', "/".MODULE_NAME."/Questionsearch/post_questionnaire_edit/");//
			$this->display("questionnaire_add_index");	
		}elseif(I('o')=='del'){
			//判断问题下面是否有选项，如果有选项则不能删除
			$where_question1['questionnaire_id']=I('u');
			$is_question = M('question')->where($where_question1)->select();

			if(!empty($is_question)){
				$this->error('此问卷还有题目，请先删除题目');exit;
			}
			$where['id']=I('u');
			$res = $Model->where($where)->delete();
			if($res){
					$this->success('删除成功！','/'.MODULE_NAME.'/Questionsearch/questionnaire/');exit;
			}else{
					$this->error('哎呀，出错了！');exit;
			}

			}else{
				$this->assign(' col_title','新增栏目');
				$this->assign('col', "add");
				$this->assign('col_from_url', "/".MODULE_NAME."/Questionsearch/post_questionnaire_add/");//from表单提交地址
				$this->display("questionnaire_add_index");
		}

	}


	//修改除问卷调查a
	public function questionnaire_edit_index(){
		$Model=M('questionnaire');
		if( IS_GET ){ //访问页
			//修改的信息查询
			$where['id']=I('u');
			$col_data =$Model->where($where)->find();
			//查询属性
			$where_property['questionnaire_id']=I('u');
			$property =M('property')->where($where_property)->select();
			$this->assign('col_data', $col_data);
			$this->assign('property', $property);
			$this->assign('col', "edit");
			$this->assign('u', I('u'));
			$this->assign('o', 'edit');
			$this->assign('col_from_url', "/".MODULE_NAME."/Questionsearch/questionnaire_edit_index/");//
			$this->display("questionnaire_edit_index");	
		}else{
			$data['name']   = I('name');
			$data['status'] = I('status');
			$data['create_time']  = time();
			$data['sort']  =  I('sort');

			//更新
			$where['id']=I('u');
			$res_a =$Model->where($where)->save($data);
			
				//属性的修改
				$datas =I();
				$questionnaire_id=I('u');
				//将数据整理好，修改数据功能
				unset($datas['name'],$datas['sort'],$datas['status'],$datas['u'],$datas['o']);
				//获取键值
				$id=array_keys($datas);
				//插入数据库
				foreach ($id as $k => $v) {
					$where_edit['id']=$v;
					$da['questions']=$datas[$v];
					$res =M('property')->where($where_edit)->save($da);
				}
				
				$this->success('修改成功！','/'.MODULE_NAME.'/Questionsearch/questionnaire/');
				
			

			
		}
	}

		

	//添加问卷调查
	public function post_questionnaire_add(){
		$Model=M('questionnaire');
		if(IS_POST || $_FILES){
			$o = I('o');
			if(I('name') == ''){
				$this->error('问卷调查名称必须填写！');
			}
			if($o == 'add'){
				$data['name']   = I('name');
				$data['status'] = I('status');
				$data['sort'] = I('sort');
				$data['create_time']  = time();

				//更新排序
				$add = $Model->add($data);
				//插入到属性表中
				if($add){
					// var_dump($add);exit;
					foreach (I('questions') as $key => $value) {
						$data_questions['questions']=$value;
						$data_questions['questionnaire_id']=$add;
						$data_all[]=$data_questions;

					}
					//批量插入数据库
					$res =M('property')->addall($data_all);
					if($res){

						$this->success('操作成功！','/'.MODULE_NAME.'/Questionsearch/questionnaire/');exit;
					}
				}
				
			}
		}
	}

	//修改问卷调查
	public function post_questionnaire_edit(){
		$Model=M('questionnaire');
		if(IS_POST || $_FILES){
			$o = I('o');
			if(I('name') == ''){
				$this->error('修改出错了哟');
			}
			if($o == 'edit'){
				$data['name']   = I('name');
				$data['status'] = I('status');
				$data['create_time']  = time();

				//更新
				$where['id']=I('u');
				$res =$Model->where($where)->save($data);

				if($res){
		
						$this->success('修改成功！','/'.MODULE_NAME.'/Questionsearch/questionnaire/');exit;
					}else{

						$this->error('哎呀，出错了！');exit;
					}

				}
			}
			
		
	}


	//问题模块
	public function question(){
		$where_questionnaire['questionnaire_id']=I('questionnaire_id');
		$collist = M("question")->where($where_questionnaire)->order("sort asc,create_time desc")->select();

		$this->assign('collist',$collist);
		$this->assign('questionnaire_id',I('questionnaire_id'));
		$this->display();
	}

  	//添加或修改或删除问题
	public function question_add_index(){
		$Model=M('question');
		if(I('o') =='edit'){
			//修改的信息查询
			$where['t1.id']=I('u');
			$col_data =$Model->alias('t1')->join('cs_questionnaire as t2 on t1.questionnaire_id=t2.id')->field('t1.*,t2.name as questionnaire_name')->where($where)->find();

			//将所属问卷查出来
			$questionnaire_id = M('questionnaire')->order('sort desc')->select();

			$this->assign('col_data', $col_data);
			$this->assign('col', "edit");
			$this->assign('u', I('u'));
			$this->assign('questionnaire_id', $questionnaire_id);
			$this->assign('col_from_url', "/".MODULE_NAME."/Questionsearch/post_question_edit/");//
			$this->display("question_add_index");	
		}elseif(I('o')=='del'){
			//判断问题下面是否有选项，如果有选项则不能删除
			$where_option['question_id']=I('u');
			$is_option = M('option')->where($where_option)->select();
			if(!empty($is_option)){
				$this->error('此题目还有选项，请先删除选项');exit;
			}
			//否则正常删除
			$where['id']=I('u');
			$res = $Model->where($where)->delete();
			if($res){
					$this->success('删除成功！','/'.MODULE_NAME.'/Questionsearch/question/');exit;
			}else{
					$this->error('哎呀，出错了！');exit;
			}

			}else{
				//将所属问卷查出来
				$questionnaire_id = M('questionnaire')->order('sort desc')->select();
				$this->assign(' col_title','新增问题');
				$this->assign('col', "add");
				$this->assign('questionnaire_id', $questionnaire_id);
				$this->assign('col_from_url', "/".MODULE_NAME."/Questionsearch/post_question_add/");//from表单提交地址
				$this->display("question_add_index");
		}

	}


	//添加问卷
	public function post_question_add(){
		$Model=M('question');
		if(IS_POST || $_FILES){
			$o = I('o');
			if(I('name') == ''){
				$this->error('问卷名称必须填写！');
			}
			if($o == 'add'){
				$data['name']   = I('name');
				$data['sort'] = I('sort');
				$data['questionnaire_id'] = I('questionnaire_id');
				$data['question_type'] = I('question_type');
				$data['create_time']  = time();
				//更新排序
				$add = $Model->add($data);
				if($add){
					$this->success('操作成功！','/'.MODULE_NAME.'/Questionsearch/question/');exit;
				}else{
					$this->error('哎呀，出错了！');exit;
				}
			}
		}
	}


	//修改问题
	public function post_question_edit(){
		if(IS_POST || $_FILES){
			$o = I('o');
			if(I('name') == ''){
				$this->error('修改出错了哟');
			}
			if($o == 'edit'){
				$data['name']   = I('name');
				$data['sort'] = I('sort');
				$data['question_type'] = I('question_type');
				$data['create_time']  = time();

				//更新
				$where['id']=I('u');
				$res = M('question')->where($where)->save($data);
				if($res){
					$this->success('修改成功！','/'.MODULE_NAME.'/Questionsearch/question/');exit;
				}else{
					$this->error('哎呀，出错了！');exit;
				}
			}
			
		}
	}


	//选项模块
	public function option(){
		$count = M('option')->where($where_option_page)->count();//统计所有的条数。
		$page = new \Org\Util\Page($count,20);//实例化分页模型
		$collist = M('option as t1')->join('cs_question as t2 on t2.id = t1.question_id')->join('left join cs_questionnaire as t3 on t3.id=t2.questionnaire_id')->field('t1.name,t1.question_id,t1.sort,t1.create_time,t1.id,t2.name as question_name,t3.name as questionnaire_name')->order('t1.question_id desc,t1.sort desc')->limit($page->limit[0],$page->limit[1])->select();
		$show = $page->show();//分页
		$this->assign('dataPage',$show);
		$this->assign('collist',$collist);
		$this->display();
	}

  	//添加或修改或删除问题
	public function option_add_index(){
		if(I('o') =='edit'){
			//修改的信息查询
			$where['id']=I('u');
			$col_data =M('option')->where($where)->find();
			$this->assign('col_data', $col_data);
			$this->assign('col', "edit");
			$this->assign('u', I('u'));
			$this->assign('col_from_url', "/".MODULE_NAME."/Questionsearch/post_option_edit/");//
			$this->display("option_add_index");	
		}elseif(I('o')=='del'){
			$where['id']=I('u');
			$res = M('option')->where($where)->delete();
			if($res){
					$this->success('删除成功！','/'.MODULE_NAME.'/Questionsearch/option/');exit;
			}else{
					$this->error('哎呀，出错了！');exit;
			}

			}else{

				$where_question['id']=I('u');
				$questionnaire_id=M('question')->where($where_question)->find();
				$where_questions['questionnaire_id']=$questionnaire_id['questionnaire_id'];
				$questions=M('property')->where($where_questions)->select();
				$this->assign('u', I('u'));
				$this->assign('type', I('type'));
				$this->assign('col_title','新增问题');
				$this->assign('questions',$questions);
				$this->assign('col', "add");
				$this->assign('col_from_url', "/".MODULE_NAME."/Questionsearch/post_option_add/");//from表单提交地址
				$this->display("option_add_index");
		}

	}


	//添加问卷
	public function post_option_add(){
		if(IS_POST || $_FILES){
			$o = I('o');
			$u = I('u');
			if(I('name') == ''){
				$this->error('问卷名称必须填写！');
			}
			if($o == 'add'){
				$data['name']   = I('name');
				$data['sort'] = I('sort');
				$data['create_time']  = time();
				$data['question_id']  = I('u');
				$data['questions']  = I('questions');
				//更新排序
				$add = M('option')->add($data);
				if($add){
					$this->success('操作成功！','/'.MODULE_NAME.'/Questionsearch/question/');exit;
				}else{
					$this->error('哎呀，出错了！');exit;
				}
			}
		}
	}


	//修改问题
	public function post_option_edit(){
		if(IS_POST || $_FILES){
			$o = I('o');
			if(I('name') == ''){
				$this->error('修改出错了哟');
			}
			if($o == 'edit'){
				$data['name']   = I('name');
				$data['sort'] = I('sort');
				$data['questions'] = I('questions');
				$data['create_time']  = time();

				//更新
				$where['id']=I('u');
				$res = M('option')->where($where)->save($data);
				if($res){
					$this->success('修改成功！','/'.MODULE_NAME.'/Questionsearch/option/');exit;
				}else{
					$this->error('哎呀，出错了！');exit;
				}
			}
			
		}
	}

	//答题列表
   	public function answer(){
		$count = M('user_answer')->where($where_answer_page)->count();//统计所有的条数。
		$page = new \Org\Util\Page($count,22);//实例化分页模型  
		//下拉框查询
		$questionnaire_name = M('questionnaire')->order('sort asc,create_time desc')->select();
		$this->assign('questionnaire_name',$questionnaire_name);
		$ad_list_id=I("ad_list_id");
		if($ad_list_id!=''){
			$condition.=" t5.id='$ad_list_id'";
		}
		session('ad_list_id',I("ad_list_id"));
		$this->assign("ad_list_id",$ad_list_id);


	   	$collist=M('user_answer as t1')->join('left join cs_question as t2 on t2.id=t1.question_id')->field('t1.*,t2.name as question_name,t2.question_type,t2.questionnaire_id,t3.user_name,t4.name as option_name,t5.name as questionnaire_name,t5.id')->join('left join cs_que_user as t3 on t1.user_id=t3.id')->join('left join cs_option as t4 on t1.content=t4.id')->join('left join cs_questionnaire as t5 on t2.questionnaire_id=t5.id')->where("$condition")->limit($page->limit[0],$page->limit[1])->select();
		$show = $page->show();//分页
		$this->assign('dataPage',$show);
		$this->assign('collist',$collist);
		$this->display();
	}

	public function score(){

		//页面的下拉选择框查询问卷
		$questionnaire_name = M('questionnaire')->order('sort asc,create_time desc')->select();
		$this->assign('questionnaire_name',$questionnaire_name);
		//模糊搜索问卷名
		
		$ad_list_id=I("ad_list_id");
		if($ad_list_id!=''){
			$condition.=" questionnaire_id='$ad_list_id'";
		}else{
			$condition="1=1";
		}
		
		session('ad_list_id',I("ad_list_id"));
		$this->assign("ad_list_id",$ad_list_id);

		$count = M('score')->where("$condition")->count();//统计所有的条数。
		$page = new \Org\Util\Page($count,22);//实例化分页模型  
		$new_arr_all =M('score')->where("$condition")->limit($page->limit[0],$page->limit[1])->select();

		// var_dump($new_arr_all);
		// echo "<br>000";
		// foreach ($new_arr_all as $ka => $va) {
		// 	# code...
		// 	explode($new_arr_all[$ka]['all_property'],'/');
		// }
		$show = $page->show();//分页
		//评分表导出功能
		if(I('print')=='1'){
			$filename = '评分记录'.date('YmdHis');
			$header = array('所属用户','年龄(岁)','联系电话','所属问卷','所有属性','所有评分','多项属性','多项评分');
			$index = array('user_name','age','phone','questionnaire_name','property','count');
			$this->createtable($new_arr_all,$filename,$header,$index);
		}
		$this->assign('dataPage',$show);
		$this->assign('new_arr_all',$new_arr_all);
		$this->display();

	}

	public function whole_score(){
		//寒+阳虚列表
		//寒+阳虚的分值
		// $han_yang[0]['score'] ="<70";
		//获取分值，字符串大散
		$all_list=M('score')->select();
		$all_numbers=M('score')->count();
		$a=0;
		$b=0;
		$c=0;
		$d=0;

		$a2=0;
		$b2=0;
		$c2=0;
		$d2=0;

		$a3=0;
		$b3=0;
		$c3=0;
		$d3=0;
		foreach ($all_list as $k => $v) {
			$score = explode("/",$all_list[$k]['count_score']);
			
			if($score[0]<70){
				$han_yang['no_level']=++$a;
			}elseif(70<=$score[0]&&$score[0]<=100){
				$han_yang['one_level']=++$b;
			}elseif(101<=$score[0]&&$score[0]<=150){
				$han_yang['two_level']=++$c;
			}else{
				$han_yang['three_level']=++$d;
			}


			if($score[1]<70){
				$qi_xue['no_level']=++$a2;
			}elseif(70<=$score[1]&&$score[1]<=100){
				$qi_xue['one_level']=++$b2;
			}elseif(101<=$score[1]&&$score[1]<=150){
				$qi_xue['two_level']=++$c2;
			}else{
				$qi_xue['three_level']=++$d2;
			}

			if($score[2]<70){
				$qi_xue_xu['no_level']=++$a3;
			}elseif(70<=$score[2]&&$score[2]<=100){
				$qi_xue_xu['one_level']=++$b3;
			}elseif(101<=$score[2]&&$score[2]<=150){
				$qi_xue_xu['two_level']=++$c3;
			}else{
				$qi_xue_xu['three_level']=++$d3;
			}
			
		}



		$qi_xue_xu_proportion['no_level']=round($qi_xue_xu['no_level']/$all_numbers*100)."%";
		$qi_xue_xu_proportion['one_level']=round($qi_xue_xu['one_level']/$all_numbers*100)."%";
		$qi_xue_xu_proportion['two_level']=round($qi_xue_xu['two_level']/$all_numbers*100)."%";
		$qi_xue_xu_proportion['three_level']=round($qi_xue_xu['three_level']/$all_numbers*100)."%";
		$qi_xue_proportion['no_level']=round($qi_xue['no_level']/$all_numbers*100)."%";
		$qi_xue_proportion['one_level']=round($qi_xue['one_level']/$all_numbers*100)."%";
		$qi_xue_proportion['two_level']=round($qi_xue['two_level']/$all_numbers*100)."%";
		$qi_xue_proportion['three_level']=round($qi_xue['three_level']/$all_numbers*100)."%";
		$han_yang_proportion['no_level']=round($han_yang['no_level']/$all_numbers*100)."%";
		$han_yang_proportion['one_level']=round($han_yang['one_level']/$all_numbers*100)."%";
		$han_yang_proportion['two_level']=round($han_yang['two_level']/$all_numbers*100)."%";
		$han_yang_proportion['three_level']=round($han_yang['three_level']/$all_numbers*100)."%";

		//查询"生育后痛经情况的变化" question_id为115  A.未生育id为163  B.生育后痛经加重id164 C.生育后痛经无变化id165  D.生育后痛经缓减id166
		//对于A所选的人数
		$where['question_id']=115;
		$content = M('user_answer')->where($where)->select();
		$e = 0;
		$f=0;
		$g=0;
		$h=0;
		foreach ($content as $k_content => $v_content) {
			//针对A选项人数
			if($content[$k_content]['content']==163){
				$bear[a]=++$e;
			}elseif($content[$k_content]['content']==164){
				$bear[b]=++$f;
			}elseif($content[$k_content]['content']==165){
				$bear[c]=++$g;
			}elseif($content[$k_content]['content']==166){
				$bear[d]=++$h;
			}
		}
		//所占比例
		$bear_proportion[a]=round($bear[a]/$all_numbers*100)."%";
		$bear_proportion[b]=round($bear[b]/$all_numbers*100)."%";
		$bear_proportion[c]=round($bear[c]/$all_numbers*100)."%";
		$bear_proportion[d]=round($bear[d]/$all_numbers*100)."%";


		$this->assign('bear',$bear);
		$this->assign('bear_proportion',$bear_proportion);


		$this->assign('han_yang',$han_yang);
		$this->assign('all_numbers',$all_numbers);
		$this->assign('han_yang_proportion',$han_yang_proportion);
		$this->assign('qi_xue',$qi_xue);
		$this->assign('qi_xue_proportion',$qi_xue_proportion);
		$this->assign('qi_xue_xu',$qi_xue_xu);
		$this->assign('qi_xue_xu_proportion',$qi_xue_xu_proportion);


		//生产前后对比

		// var_dump($han_yang);
		// echo "<br>2222";
		// var_dump($qi_xue);
		// echo "<br>333";
		// var_dump($qi_xue_xu);
		// echo "<br>666";
		// var_dump($qi_xue_xu_proportion);
		$this->display();
	}

	//评分算法
	public function score_1(){
		//根据用户user_id来查询选项，根据选项questions拆分数据，依次相加，得出不同属性分数
		//页面的下拉选择框查询问卷
		$questionnaire_name = M('questionnaire')->order('sort asc,create_time desc')->select();
		$this->assign('questionnaire_name',$questionnaire_name);
		//模糊搜索问卷名
		$condition="1=1";
		$ad_list_id=I("ad_list_id");
		if($ad_list_id!=''){
			$condition.=" and t5.id='$ad_list_id'";
		}
		
		session('ad_list_id',I("ad_list_id"));
		$this->assign("ad_list_id",$ad_list_id);
		
		$res = M('user_answer as t1')->field('t2.user_name,t1.user_id,t1.content,t1.question_id,t3.question_id as option_question_id,t3.questions,t4.questionnaire_id,t5.name as questionnaire_name,t5.id as questionnaire_id,t6.phone,t6.age')->join('left join cs_que_user as t2 on t1.user_id=t2.id')->join('left join cs_option as t3 on t1.content =t3.id')->join('left join cs_question as t4 on t1.question_id=t4.id')->join('left join cs_questionnaire as t5 on t4.questionnaire_id=t5.id')->join('left join cs_que_user as t6 on t6.id=t1.user_id')->where("$condition")->select();


		$good=$this->group_same_key($res,user_name);
		foreach ($good as $k => $v) {

				foreach ($v as $kk => $vv) {
					if($vv['questions']==null){
						//查询问卷id
						$where_property['questionnaire_id']=$vv['questionnaire_id'];
						//查询属性个数有多少个
						$property_count = M('property')->where($where_property)->select();
						// 将个数形式规定
						foreach ($property_count as $k_p => $v_p) {
							$vv['questions'].='0/';
						}
						//去掉最后一个字符串
						if(!empty($property_count)){
							$vv['questions']=substr($vv['questions'], 0, -1);
						}else{
							$vv['questions']=null;
						}
					}
					$quess = explode("/",$vv['questions']);
					foreach ($quess as $kkk => $vvv) {
						$goods[$kkk][]=$vvv;
					}
				}
				//元素相加
				foreach ($goods as $goods_k=> $goods_v) {

					$count_array=array_sum($goods_v);
					$count[]=$count_array;
				}
				$new_arr['user_name']=$vv['user_name'];
				$new_arr['user_id']=$vv['user_id'];
				$new_arr['questionnaire_name']=$vv['questionnaire_name'];
				$new_arr['questionnaire_id']=$vv['questionnaire_id'];
				$new_arr['phone']=$vv['phone'];
				$new_arr['age']=$vv['age'];
				$count=implode('/',$count);
				$new_arr['count']=$count;
				unset($count);
				unset($goods);
				unset($count_array);
				$new_arr_all[$k]=$new_arr;

			}
		

		// 属性查询
		foreach ($new_arr_all as $new_arr_all_k => $new_arr_all_v) {
			$where7['questionnaire_id']=$new_arr_all_v['questionnaire_id'];
			$property = M('property')->field('questions')->where($where7)->select();
			foreach ($property as $key4 => $value4) {
				$property2[]=$value4['questions'];
			}
			$property3=implode('/',$property2);
			$new_arr_all[$new_arr_all_k]['property']=$property3;
			unset($property2);
		}

		if(I('print')=='1'){
			$filename = '评分记录'.date('YmdHis');
			$header = array('所属用户','年龄(岁)','联系电话','所属问卷','所属属性','评分');
			$index = array('user_name','age','phone','questionnaire_name','property','count');
			$this->createtable($new_arr_all,$filename,$header,$index);
		}
		$this->assign('new_arr_all',$new_arr_all);
		$this->display();

	}

	//新增问题和选项和选项赋值
	public function question_option(){
		 if(!empty($_POST)){
			var_dump($_POST);exit;
		 }
		$this->display();
	}

	public function all_question_option(){

		if(I('o')=='add'){
	        if( IS_GET ){ //访问页面  
	        	/* 填充好当前默认排序 */
	        	$question['sort'] = M('Question')->where( I('get.') )->count('id') + 1;
	        	$this->assign('question', $question);
				$this->display();
	        }else{ //表单提交  
		        $questions = D('Question');
	        	
	        	if( $data = $questions->create() ){
		        	$data['options'] = I('post.options', '', ''); //临时关闭I函数的过滤器，因为选项中包含特殊字符

		        	$state = $questions->add($data);
			        
			        if( $state===false ){
		        		$this->error('问题添加失败，错误信息：'.$questions->getDbError());
			        }else{
			        	$this->success('问题添加成功', '', 0);
			        }	        	
		        }else{ //表单提交不完整  
		        	$this->_formBack(); //把不完整的表单数据反馈回去

		            $this->assign('errorNote', $questions->getError());

					$this->display();
		        }
	        }
		}


		$this->display();
	}

	//公共方法
	
	function createtable($list,$filename,$header=array(),$index = array()){  
			header("Content-type:application/vnd.ms-excel");  
			header("Content-Disposition:filename=".$filename.".xls");  
			$teble_header = implode("\t",$header);
			$strexport = $teble_header."\r";
			foreach ($list as $row){  
				foreach($index as $val){
					$strexport.=$row[$val]."\t";   
				}
				$strexport.="\r"; 
		 
			}  
			$strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);  
			exit($strexport);     
	} 

	function group_same_key($arr,$key){
	        $new_arr = array();
	        foreach($arr as $k=>$v ){
	            $new_arr[$v[$key]][] = $v;
	        }
	        return $new_arr;
	}





}
?>