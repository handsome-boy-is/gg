<?
/**
 * 投递控制器
 */
class SendController extends BaseController{

	public function index()
	{
		$this->display("index");
	}


	public function show_list_ajax()
	{
		//第一步：职位列表查出来
		
		$mysql=$this->loadModel('mysql');
		$limit_start=0;
		$page_num=4;

		$scroll_count=$_POST['scroll_count'];
		if ($scroll_count>0) {
			$limit_start=$scroll_count*$page_num;//1
			
		}

		$resume_list=$mysql->lists("myresume",$limit_start.','.$page_num);


		//第二步：输出json格式
		 
		echo json_encode($resume_list);

	}

	public function show_resume()
	{
		$mysql=$this->loadModel('mysql');

		$info=$mysql->get_info('myresume',array('id'=>$_GET['id']));
		

		$jobseekers_info=$mysql->get_info('jobseekers',array('id'=>$info['id']));/////////enterprise_id

		$this->assigin('info',$info);
		$this->assigin('jobseekers_info',$jobseekers_info);
		$this->display("show_resume");
	}

}


?>