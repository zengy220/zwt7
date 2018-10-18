<?php
namespace Web\Controller;
use Think\Controller;

class IndexController extends CommonController
{
   
    public function index()
    {
    	//数组全部查出来
    	//统计问题个数
    	$where1['questionnaire_id']=I('questionnaire_id');
    	// 不需要状态，只需要传过来的问卷id就行
    	$question_middle_id=M('question as t1')->join('cs_questionnaire as t2 on t1.questionnaire_id =t2.id')->where($where1)->order('t1.sort asc')->field('t1.id,t2.id as questionnaire_id')->select();
    	foreach ($question_middle_id as $k2 => $v2) {
    		
	    	$where_middle['question_id']=$v2['id'];
	    	//是否是选择如果question_type为1是选择，question_type为3是文字
	    	$where_id['id']=$v2['id'];
	    	$question_type=M('question')->where($where_id)->find();

	    	if($question_type['question_type']==1){

		    	$option_middle[$k2] =M('option as t1')->join('cs_question as t2 on t2.id=t1.question_id')->where($where_middle)->field('t2.name as question_name,t1.*,t2.sort as question_sort,t2.question_type,t2.create_time as question_time')->order('t1.question_id asc,t1.sort asc')->select();
	    	}
	    	if($question_type['question_type']==3){
	    		$option_middle[$k2]=M('question')->where($where_id)->field('name as question_name,id as question_id,question_type,sort as question_sort,questionnaire_id,create_time,sort')->select();
	    	}
    	}
    	//序号显示
    	foreach ($option_middle as $k_op => $v_op) {
    		$i = 1;
    		$option_middle[$k_op]['number']=$k_op+1;
    	}

		$this->assign('option_middle',$option_middle);
		$this->display();

    }

    public function start(){
    	
    		$questionnaire_id=I('questionnaire_id');
    		$this->assign('questionnaire_id',$questionnaire_id);
    		$this->display();
    	
    }

    public function add(){

    	if(!empty($_POST)){
    		$data = $_POST;
    		// var_dump($data);exit;

    		//统计答题问题个数
    		$count = count($data);
    		//取键名和键值
    		$option_key = array_keys($data);
    		$option_values = array_values($data);

    		$question_id=array_splice($option_key,0,$count-3);
    		$question_values=array_splice($option_values,0,$count-3);
    		//取键值
    		$content = array_splice($data,0,$count-3);
    		//如果成功则插入到用户信息白哦中
				$user_data['user_name'] = $data['user_name'];
				$user_data['age'] = $data['age'];
				$user_data['phone'] = $data['phone'];
				$user_data['create_time'] = time();
				$user_info = M('que_user')->add($user_data);
				$user_id =$user_info;

				if($user_info){
					//开始组装插入数据库
		    		foreach ($content as $key => $value) {
		    			$info['question_id']=$question_id[$key];
		    			$info['content']=$value;
		    			$info['user_id']=$user_id;
		    			$infos[]=$info;
		    		}
					$info = M('user_answer')->addall($infos);
					if($info){
		    			// 根据插入数据库的id查询user_id的信息
		    		$where_user_id['id']=$info;
		    		$user_id_q = M('user_answer')->where($where_user_id)->field('user_id')->find();
		    		$id_q = $user_id_q['user_id'];
						$this->success('提交成功','/web/index/question_score/user_id/'.$id_q);exit;
					}else{
						$this->error('哎呀，出错了！');exit;
					}
				}else{
					$this->error('哎呀，出错了！');exit;
				}

    		
    		
    		
    	}
    	
    }


    //通用版的显示不包含（气虚+血虚）、（寒+阳虚）、（气滞+血瘀）的统计
    // public function question_score(){
    // 	// var_dump(I());exit;
    // 	$this->display();
    // }


    public function question_score(){
    	$user_id=I('user_id');

    	if(!empty($user_id)){
    		$where_res['t4.question_type']="1";
    		$res = M('user_answer as t1')->field('t2.user_name,t1.user_id,t1.content,t1.question_id,t3.question_id as option_question_id,t3.questions,t4.question_type,t4.questionnaire_id,t5.name as questionnaire_name,t5.id as questionnaire_id,t6.phone,t6.age')->join('left join cs_que_user as t2 on t1.user_id=t2.id')->join('left join cs_option as t3 on t1.content =t3.id')->join('left join cs_question as t4 on t1.question_id=t4.id')->join('left join cs_questionnaire as t5 on t4.questionnaire_id=t5.id')->join('left join cs_que_user as t6 on t6.id=t1.user_id')->where($where_res)->select();

		$good=$this->group_same_key($res,user_name);

		foreach ($good as $k => $v) {

			foreach ($v as $kk => $vv) {
					if($vv['questions']==null){
						$vv['questions']='0/0/0/0/0/0';
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

			foreach ($new_arr_all as $k_q => $v_q) {
				if($v_q['user_id']==$user_id){
					$question_score =$new_arr_all[$k_q];
				}
			}
    	}


    	$property=explode('/',$question_score['property']);
    	$score = explode('/',$question_score['count']);
    	foreach ($property as $k_a => $v_a) {
    		$arr_all[$k_a]['property']=$v_a;
    		$arr_all[$k_a]['count']=$score[$k_a];
    	}
    	//将数据插入表score中
    	if($arr_all){
    		$score_data['user_name'] = $question_score['user_name'];
    		$score_data['age'] = $question_score['age'];
    		$score_data['phone'] = $question_score['phone'];
    		$score_data['user_id'] = $question_score['user_id'];
    		$score_data['questionnaire_name'] = $question_score['questionnaire_name'];
    		$score_data['questionnaire_id'] = $question_score['questionnaire_id'];
    		$score_data['all_score'] = $question_score['count'];
    		$score_data['all_property'] = $question_score['property'];
    		$score_data['create_time'] = time();
    		$score_data['count_property']="(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)";
    		$han_yang=$arr_all[0]['count']+$arr_all[1]['count'];
    		$qi_xue_yu=$arr_all[2]['count']+$arr_all[3]['count'];
    		$qi_xue=$arr_all[4]['count']+$arr_all[5]['count'];
    		$score_data['count_score']=$han_yang."/".$qi_xue_yu."/".$qi_xue;

    		// 查询数据库，如果$score_data一模一样就不插入数据库了
    		$where_my['user_id']=$user_id;
    		$my_score_data=M('score')->where($where_my)->find();

    		//统计体质指数（BMI）
    		//获取体重
    		$map_h['user_id']=$user_id;
	    	$map_h['question_id']=C('ONE_HEIGHT_ID');
	    	$bmi['height'] = M('user_answer')->field('id,content')->where($map_h)->find();
	    	$where_w['user_id']=$user_id;
	    	$where_w['question_id']=C('TWO_WEIGHT_ID');
	    	$bmi['weight'] = M('user_answer')->field('id,content')->where($where_w)->find();

	    	$score_data['bmi']=$this->BMI($bmi['height']['content'],$bmi['weight']['content']);


    		$question_score['bmi']=$score_data['bmi'];

    		if(!empty($score_data['age'])&&$my_score_data['all_score']!=$score_data['all_score']&&$my_score_data['phone']!=$score_data['phone']){
    			
	    		$score_res = M('score')->add($score_data);
    		}

    	}


    	$this->assign('arr_all',$arr_all);
    	$this->assign('question_score',$question_score);
		$this->display();

    }

    //统计体质指数（BMI）
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
    	return $BMI."(".$res.")";
    }



    function group_same_key($arr,$key){
	        $new_arr = array();
	        foreach($arr as $k=>$v ){
	            $new_arr[$v[$key]][] = $v;
	        }
	        return $new_arr;
	    }





	

}