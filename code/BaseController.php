<?
class BaseController{
		protected $control;
		private $var=array();
	
		public function __construct(){
			$this->control=get_class($this);
			// JobController
			$this->control=strtolower(str_replace('Controller', '', $this->control));
	
		}
		
		public function run()
		{
			// 怎么调用全局的变量
			global $config_arr;
	
			$this->control=$_REQUEST['co'];//控制器
	
			if (empty($this->control)) {
				$this->control=$config_arr['default_co'];
			}
	
			$action=$_REQUEST['ao'];//做什么事情？
		   if (empty($action)) {
				$action=$config_arr['default_ao'];
			}
		  
	
			 //权限管理
			 // 这个数组里面的控制器需要登录
			 $access_arr=array('resume','message','info');
	
			//怎么判断一个字符串是否在数组里面	 
			 if (in_array($this->control, $access_arr)) {
				 //判断到底有没有登录
					if (empty($_SESSION['uid'])) {
						header("location:index.php");
					}
			 }elseif ($this->control=='login' && $action=='index' && $_SESSION['uid']) {
				 header("location:index.php?co=jobseekers");
			 } 
	
			 
	
	
			 $control_name=$this->control."Controller";
	
	
			 // 任务：怎么判断该类到底存不存在？
			 $contorl_path=ROOT_PATH."/controller/".$control_name.".php";
			 if (!file_exists($contorl_path)) {
				echo 'access run!';exit();
			 }
	
			 include_once $contorl_path;//执行和引入文件
	
	
			 $job_class=new $control_name();
			 // //对象的调用
			 $job_class->$action();
	
		}
		/**
		 * 加载模型
		 * @param  string $modelName 模型名称
		 * @return class            模型对象
		 */
		public function loadModel($modelName)
		{
			$mysql=new $modelName();
			$mysql->init();
			return $mysql;
		}
	
		/**
		 * 模版（视图）变量赋值
		 * @param  [string] $tempate_key  [模版变量的键]
		 * @param  [string] $template_val [模版变量的值]
		 * @return [type]               [description]
		 */
		public function assigin($tempate_key,$template_val)
		{
			$this->var[$tempate_key]=$template_val;
		}
	
		/**
		 * 视图
		 * @param  string $view_name 视图名称
		 */
		public function display($view_name)
		{
			foreach ($this->var as $key => $value) {
				$$key=$value;
			}
	
			
			include_once ROOT_PATH."/template/".$this->control."/".$view_name.".html";
		}
	
	public function mysql_init(	){
		
		$mysql=new Mysql();
		$mysql->init();
		
		return $mysql;
		
		}
	

	
	
	}


?>