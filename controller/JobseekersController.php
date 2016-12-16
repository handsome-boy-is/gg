<?

/**
 * 控制器文件，就只负责去哪里，做什么事情
 */

//如果没有登录进不来
//权限管理
class jobseekersController extends BaseController{

	public function index()
	{
		$pdo_model=new BaseModel();


		if ($_REQUEST['sort']=='time') {
			$order=' add_time asc';
		}

		$seeker_list=$pdo_model->lists("jobseekers",'',array('id'=>$_SESSION['uid']),$order);
		// echo $pdo_model->get_last_sql();
	 

		$this->assigin("title",'个人信息管理列表');
		$this->assigin("seeker_list",$seeker_list);
		$this->display("index"); 
		 
		 //$mysql=$this->mysql_init();
	/*	 
		 
		$seeker_list=$mysql->lists("jobseekers",'','',$_SESSION['uid']);//chuang biao
	
		if ($_REQUEST['sort']=='desc') {
			// 翻转
			$seeker_list=array_reverse($seeker_list);
		}
	
	 
	
			// 分页
			// 一页只显示4条
			// 有2页
			$page_num=4;
			$total_page=count($seeker_list)/$page_num;
		
			// array_chunk 分割一个数组
			list($page_one_data,$page_two_data)=array_chunk($seeker_list, $page_num);
			//////////////////////////////////////////////////////////////////////////////////////////////////
			if ($_REQUEST['p']==1) {
				$seeker_list=$page_one_data;
			}elseif ($_REQUEST['p']==2) {
				$seeker_list=$page_two_data;
			}
		
			//关键词筛选
			if (!empty($_REQUEST['keywords'])) {
				 
				 foreach ($seeker_list as $key => $value) {
					 $user_sech_a[$key]=$value['UserName'];
				 }
				 
				 $ser_arr=array_search($_REQUEST['keywords'], $user_sech_a);//在一个数组中搜索指定的值，只支持一维数组
				 foreach ($seeker_list as $key => $value) {
					 if ($key!=$ser_arr) {
						unset($seeker_list[$key]);
					 }
				 }
			}
		
		 
			
			include_once ROOT_PATH."/template/jobseekers/index.html";*/
		}



	public function add(){	
		//include_once ROOT_PATH."/template/jobseekers/add.html";
	$this->display("add"); 
	}
	
	
	
	
	public function save(){
		//保存添加时候提交过来的信息
 		$pdo_model=new BaseModel();
		 //$mysql=$this->mysql_init();
		list($name,$file_type)=explode('/', $_FILES['Photo']['type']);
		
		$photo_path='/uploads/'.time().".".$file_type;

		move_uploaded_file($_FILES['Photo']['tmp_name'], ROOT_PATH.$photo_path);
		
		$add_array['UserName']=$_POST['UserName'];
		$add_array['Phone']=$_POST['Phone'];
		$add_array['address']=$_POST['address'];
		$add_array['add_time']=time();
		$add_array['Photo']=$photo_path;

		//$mysql->add("jobseekers",$add_array);

		$pdo_model->add("jobseekers",$add_array);
		jump_do("添加成功！","/index.php?co=jobseekers");
	}



	public function saveimg(){
		$avatar_src=$_POST['avatar_src'];
		$avatar_data=$_POST['avatar_data'];
		
		list($name,$file_type)=explode('/', $_FILES['avatar_file']['type']);		
		$photo_path='/uploads/'.time().".".$file_type;
	//	$im=imagecreate($w,$h);
		
		//move_uploaded_file($_FILES['avatar_file']['tmp_name'], ROOT_PATH.$photo_path);
		
		//print_r( $_FILES['avatar_file']['tmp_name']);
		//print_r($avatar_data);
		//print_r($_REQUEST);
		echo json_encode($avatar_data,true);	
		}
		
	
		
		
		
	public function edit(){
		$pdo_model=new BaseModel();
		//$mysql=$this->mysql_init();
		$id=intval($_REQUEST['id']);
		$info_arr=$pdo_model->get_info('jobseekers',array('id'=>$id));
		//$info_arr=$mysql->get_info('jobseekers',array('id' => $id));
		//include_once ROOT_PATH."/template/jobseekers/edit.html";
		
		$this->assigin("info_arr",$info_arr);
		$this->display("edit"); 
		}
		
		
		
	public function update(){
		$pdo_model=new BaseModel();
		 //$mysql=$this->mysql_init();
		
		$id=intval($_REQUEST['id']);
		
		$_POST['id']=$_SESSION['uid'];//enterprise_id
		$pdo_model->update('jobseekers',$_POST,array('id'=>$id));

		jump_do("修改成功！","/jobseekers");
		
		
		
		/*if(!empty($_FILES['Photo']['type'])){
			list($name,$file_type)=explode('/', $_FILES['Photo']['type']);		
			$photo_path='/uploads/'.time().".".$file_type;
			move_uploaded_file($_FILES['Photo']['tmp_name'], ROOT_PATH.$photo_path);
			
		
			
			
			
			$_POST['Photo']=$photo_path;
			
			}
		else{
			echo "n";
			}
		

		$mysql ->update('jobseekers',$_POST,array('id'=>$id));
		
		jump_do("修改成功！","/index.php?co=jobseekers");*/	
		}	
		
		
	public function delete()
	{
		$pdo_model=new BaseModel();
		// $mysql=$this->mysql_init();

		$id=intval($_REQUEST['id']);
		if ($id>0) {
			$mysql->delete('jobseekers',$id);
			jump_do("删除成功！","/index.php?co=jobseekers");
		}else{
			jump_do("操作有误！","/index.php?co=jobseekers");
		}
	}	

}
?>