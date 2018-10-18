<?php 
namespace Home\Controller;
use Think\Controller;
class QuestionController extends CommonController {
	
	
	

	/* 问题添加 */
	/* 问题添加 */
	public function add()
	{

        if( IS_GET ){ //访问页面  
        	/* 填充好当前默认排序 */
        	$question['sort'] = M('Question')->where( I('get.') )->count('id') + 1;
        	//将问卷的属性查出来
        	$questionnaire_id_add = I('questionnaire_id');
        	$where_property['questionnaire_id']=$questionnaire_id_add;
        	$property=M('property')->where($where_property)->field('questions')->select();
        	// var_dump($property);
        	// 对数组遍历
        	foreach ($property as $k_p => $v_p) {
        		$property_name .=$v_p['questions'].'/';
        	}
        	//去掉最后字符'/'
        	$property_name=substr($property_name, 0, -1);
        	$this->assign('property_name', $property_name);
        	$this->assign('question', $question);
			$this->display();
        }else{ //表单提交  
	        $question = D('Question');
    		$data=I();
    		$data['questionnaire_id']=$_GET['questionnaire_id'];
        	$data['options'] = I('post.options', '', ''); //临时关闭I函数的过滤器，因为选项中包含特殊字符
        	// 如果{}长度是2，如果只含有{}那么是文字题，则question_type=3 否则是选择题为1
			$length = strlen($data['options']);
			if($length ==2){
				$data['question_type']=3;
				unset($data['options']);
			}else{
				$data['question_type']=1;
			}
        	$data['create_time']=time();
        	$state = $question->add($data);
	        
	        if( $state===false ){
        		$this->error('问题添加失败，错误信息：');
	        }else{
	        	//将后台的options的json数据插入到表option当中
	        	// var_dump($state);exit;
	        	$option['question_id']=$state;
	        	$option['create_time']=time();
	        	
	        	//查询option是否存在选项，如果存在选项则先删除，然后再添加。
	        	$where_option['question_id']=$state;
	        	$option_all =M("option")->where($where_option)->select();
	        	if(!empty($option_all)){
	        		$where_del['question_id']=$state;
	        		$del = M('option')->where($where_del)->delete();
	        	}else{
	        		//经行添加操作，查询表question 获取问题name,选项name,选项排序，分值
	        		$where_question['id']=$state;
	        		$question_info=M('question')->where($where_question)->find();
	        		$option_json = json_decode($question_info['options'],true);
	        		foreach ($option_json as $k => $v) {
	        			//对option进行分割为选项和分值
	        			$text = explode('*',$option_json[$k]['text']);
	        			$option['name']=$text[0];
	        			$option['questions']=$text[1];
	        			$option['sort']=$k+1;
	        			$option_add =M('option')->add($option);
	        		}
	        	}

	        	$this->success('问题添加成功', '', 0);
	        }	        	
	       
        }
	}




	/* 问题编辑 */
	public function edit()
	{
        
        if( IS_GET ){ //访问页面
        	$question = D('Question');
        	$id =I('id');
        	$questionnaire_id =I('questionnaire_id');
        	$where_question_edit['id']=$id;
        	$question = $question->where($where_question_edit)->find();
        	
			$this->assign('question', $question);
			$this->assign('id', $id);
			$this->assign('questionnaire_id', $questionnaire_id);
			$this->assign('optionsList', json_decode($question['options'], true)); //选项列表
			$isText = ( $question['options'] == '{"0":{"type":"text","text":""}}' ) ? true:false; //判断该题是否是文本输入型问题
			$this->assign('standardList', $this->getStandardList($question['standard'], $isText)); //标准答案列表
			$this->display();
       }else{ //表单提交  

            $question = D('Question');
    		$data=I();
        	$data['options'] = I('post.options', '', ''); //临时关闭I函数的过滤器，因为选项中包含特殊字符
        	$data['create_time']=time();
        	$questionnaire_id=$_GET['questionnaire_id'];
        	$data['questionnaire_id']=$questionnaire_id;
        	$where_edit_submit['id']=I('id');
        	$state = $question->where($where_edit_submit)->save($data);
	        
	        if( $state===false ){
        		$this->error('问题添加失败，错误信息：');
	        }else{
	        		        	//将后台的options的json数据插入到表option当中
	        	// var_dump($state);exit;
	        	$state=I('id');
	        	$option['question_id']=$state;
	        	$option['create_time']=time();
	        	
	        	//查询option是否存在选项，如果存在选项则先删除，然后再添加。
	        	$where_option['question_id']=$state;
	 
	        	$option_all =M("option")->where($where_option)->select();
	        	// var_dump($option_all);exit;
	        	if(!empty($option_all)){
	        		$where_del['question_id']=$state;
	        		$del = M('option')->where($where_del)->delete();
	        	}
        		//经行添加操作，查询表question 获取问题name,选项name,选项排序，分值
        		$where_question['id']=$state;
        		$question_info=M('question')->where($where_question)->find();
        		$option_json = json_decode($question_info['options'],true);
        		foreach ($option_json as $k => $v) {
        			//对option进行分割为选项和分值
        			$text = explode('*',$option_json[$k]['text']);
        			$option['name']=$text[0];
        			$option['questions']=$text[1];
        			$option['sort']=$k+1;

        			$option_add =M('option')->add($option);
        		}
	        	
	        	$this->success('问题修改成功', '/home/Questionsearch/question/questionnaire_id/'.$questionnaire_id, 0);
	        }	        	
       
        
        }
	}


		/* 问题删除 */
	public function delete()
	{
       $id=$_GET['id'];
       // var_dump($id);exit;

        $question = M('Question');
        $state = $question->delete($id);

        if( $state===false ){
	        $this->error('问卷删除失败');
        }else{
	        $this->success('问题删除成功', '', 0);
        }
	}





	public function getStandardList($standard, $isText)
	{
		if( $isText ){ //当前问题是一个文本输入型的问题
			return $standard;
		}else{
			$list = explode(',', $standard);

			foreach ($list as $value) {
				$sep = explode(':', $value);
				$key = $sep[0];
				$value = isset($sep[1]) ? $sep[1] : '';

				$standardList[$key] = $value;
			}

			return $standardList;
		}
	}

	

}
?>