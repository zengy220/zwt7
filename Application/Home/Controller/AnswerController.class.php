<?php 
namespace Home\Controller;
use Think\Controller;
class AnswerController extends CommonController {
	
	
	//答题列表
   	public function index(){
		$count = M('user_answer')->where($where_answer_page)->count();//统计所有的条数。
		$page = new \Org\Util\Page($count,22);//实例化分页模型  
		$questionnaire_id=I('questionnaire_id');
		$user_id=I('user_id');
		
		$condition="t5.id='$questionnaire_id' and t1.user_id='$user_id'";
		//分页
		$count = M('user_answer as t1')->join('left join cs_question as t2 on t2.id=t1.question_id')->field('t1.*,t2.name as question_name,t2.question_type,t2.questionnaire_id,t3.user_name,t4.name as option_name,t5.name as questionnaire_name,t5.id')->join('left join cs_que_user as t3 on t1.user_id=t3.id')->join('left join cs_option as t4 on t1.content=t4.id')->join('left join cs_questionnaire as t5 on t2.questionnaire_id=t5.id')->where("$condition")->count();//统计所有的条数。
		$page = new \Org\Util\Page($count,22);//实例化分页模型  

	   	$collist=M('user_answer as t1')->join('left join cs_question as t2 on t2.id=t1.question_id')->field('t1.*,t2.name as question_name,t2.question_type,t2.questionnaire_id,t3.user_name,t4.name as option_name,t5.name as questionnaire_name,t5.id')->join('left join cs_que_user as t3 on t1.user_id=t3.id')->join('left join cs_option as t4 on t1.content=t4.id')->join('left join cs_questionnaire as t5 on t2.questionnaire_id=t5.id')->where("$condition")->select();
		$show = $page->show();//分页
		$this->assign('dataPage',$show);
		$this->assign('collist',$collist);
		$this->display();
	}
	

}
?>