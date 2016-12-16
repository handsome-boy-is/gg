<?

/**
 * 控制器文件，就只负责去哪里，做什么事情
 */

//如果没有登录进不来
//权限管理
class resumeController extends BaseController{

	public function index()
	{
		
		$pdo_model=new BaseModel();
		
		if ($_REQUEST['sort']=='time') {
			$order=' add_time asc';
		}elseif ($_REQUEST['sort']=='Monthly_salary') {
			$order=' money desc ';
		}

		$where_ar=array('id'=>$_SESSION['uid']);//enterprise_id

		if ($_REQUEST['keywords']) {//如果有搜索，就再添加一个条件
			$where_ar['keywords']=$_REQUEST['keywords'];
			$where_ar['keywords_col']='resume_name';
		}

		$resume_list=$pdo_model->lists("myresume",'',$where_ar,$order);
 		
 
	 	$this->assigin("resume_list",$resume_list);

	 	$this->assigin("title","简历管理列表");

	 	

		$this->display("index");
		
		
		
		
		/*$mysql=$this->mysql_init();
		
		$resume_list=$mysql->lists("myresume",$_SESSION['uid']);//chuang biao
	
		if ($_REQUEST['sort']=='desc') {
			// 翻转
			$resume_list=array_reverse($resume_list);
		}
	
	 
	
			// 分页
			// 一页只显示4条
			// 有2页
			$page_num=4;
			$total_page=count($resume_list)/$page_num;
		
			// array_chunk 分割一个数组
			list($page_one_data,$page_two_data)=array_chunk($resume_list, $page_num);
			//////////////////////////////////////////////////////////////////////////////////////////////////
			if ($_REQUEST['p']==1) {
				$resume_list=$page_one_data;
			}elseif ($_REQUEST['p']==2) {
				$resume_list=$page_two_data;
			}
		
			
			if (!empty($_REQUEST['keywords'])) {
				 
				 foreach ($resume_list as $key => $value) {
					 $user_sech_a[$key]=$value['resume_name'];
				 }
				 
				 $ser_arr=array_search($_REQUEST['keywords'], $user_sech_a);//在一个数组中搜索指定的值，只支持一维数组
				 foreach ($resume_list as $key => $value) {
					 if ($key!=$ser_arr) {
						unset($resume_list[$key]);
					 }
				 }
			}
		
		 
			
			include_once ROOT_PATH."/template/resume/index.html";*/
		}

	//添加
	public function add(){	
		$this->assigin("title","添加简历");

		$this->display("add");
		/*include_once ROOT_PATH."/template/resume/add.html";*/
	
	}
	
	//保存
	public function save(){
		//保存添加时候提交过来的信息
	// 添加sql语句
		$add_array["resume_name"]=$_POST['resume_name'];//简历名称
		$add_array["Monthly_salary"]=$_POST['Monthly_salary'];//当时月薪
		$add_array["Description"]=$_POST['Description'];//工作描述
		$add_array["add_time"]=time();//1481178395
		$add_array["id"]=$_SESSION['uid'];//所有者
		

		$pdo_model=new BaseModel();

		 $pdo_model->add("myresume",$add_array);
		
		jump_do("添加成功！","/resume");
		/*$mysql=$this->mysql_init();
	
		// 添加sql语句
		$add_array["resume_name"]=$_POST['resume_name'];//简历名称
		$add_array["Monthly_salary"]=$_POST['Monthly_salary'];//当时月薪
		$add_array["Description"]=$_POST['Description'];//工作描述
		$add_array["add_time"]=time();//1481178395
		$add_array["id"]=$_SESSION['uid'];//所有者
	
		$mysql->add("myresume",$add_array);
	
		//$tip_what="添加成功！";
		//$go_where=URL_PATH."/index.php?co=resume";
		//include_once ROOT_PATH."/template/success.html";
		jump_do("添加成功！","/index.php?co=resume");*/
	}
	
	//删除
	public function delete(){
		$pdo_model=new BaseModel();

		$id=intval($_REQUEST['id']);
		if ($id>0) {
			$pdo_model->delete('myresume',$id);
			jump_do("删除成功！","/index.php?co=resume");
		}else{
			jump_do("操作有误！","/index.php?co=resume");
		}
		/*$mysql=$this->mysql_init();
		
		$resume_id=intval($_REQUEST['resume_id']);
		if($resume_id>0){
				$mysql ->delete('myresume',$resume_id);
				jump_do("删除成功","/index.php?co=resume");
			}
		else{
				jump_do("操作有误！","/index.php?co=resume");
			}*/	
		
		
	}
	
	//编辑
	public function edit(){
		
		$pdo_model=new BaseModel();

		$id=intval($_REQUEST['id']);

		$info_arr=$pdo_model->get_info('myresume',array('id'=>$id));

	 	$this->assigin("title","修改职位信息");

		$this->assigin("info_arr",$info_arr);
		$this->assigin("id",$id);
		$this->display("edit"); 
		/*$mysql=$this->mysql_init();
		
		$resume_id=intval($_REQUEST['id']);
		
		$info_arr=$mysql->get_info('myresume',array('resume_id' => $resume_id));
		include_once ROOT_PATH."/template/resume/edit.html";*/
		
		}
		
		
	//修改	
	public function update(){
		$pdo_model=new BaseModel();

		$id=intval($_REQUEST['id']);
		
		$pdo_model->update('myresume',$_POST,array('id'=>$id));

		jump_do("修改成功！","/index.php?co=resume");
		/*$mysql=$this->mysql_init();
		
		$resume_id=intval($_REQUEST['resume_id']);
		
		$mysql ->update('myresume',$_POST,array('resume_id'=>$resume_id));
		
		jump_do("修改成功！","/index.php?co=resume");*/
		}	

}
?>