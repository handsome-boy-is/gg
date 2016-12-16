<? 
	header("Content-:text/html ; charset=utf-8");

			session_start();
	//public function into(){
	// 第一步连接mysql
	//@mysqli_connect('127.0.0.1','root','','yuanku_job');
 
	// 定义
	define("ROOT_PATH",str_replace("\\","/",dirname(__FILE__)) );
	//视图目录常量
	//为什么定义？
	define("TEMPLATE_PATH",str_replace("\\","/",dirname(__FILE__)).'/template/' );
	//有多种模版、中英文的网站。中文是不是要在一个模版文件夹里、英文的视图又在另外一个文件夹
	define("URL_PATH",'http://'.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'],'/', dirname($_SERVER['SCRIPT_FILENAME'])) );

	include_once(ROOT_PATH."/model/mysql.php");    
	include_once(ROOT_PATH."/code/BaseModel.php");               
	include_once(ROOT_PATH."/config.php");       
	include_once(ROOT_PATH."/libraries/smarty/Smarty.class.php");           
	include_once(ROOT_PATH."/libraries/function.php"); 
	include_once(ROOT_PATH."/code/BaseController.php"); 
	 

	 // 安全过滤
	 foreach ($_POST as $key => $value) {
	 	   $_POST[$key]=addslashes($value);
	 }

	 foreach ($_GET as $key => $value) {
	 	   $_GET[$key]=addslashes($value);
	 }

?>