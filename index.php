<?
	 include("init.php"); 
	$application=new BaseController();

	$application->run(); 
	
	include_once("libraries/Smarty/Smarty.class.php"); //包含smarty类文件 

$smarty = new Smarty(); //建立smarty实例对象$smarty 
$smarty->templates("./template"); //设置模板目录 
$smarty->templates_c("./template_c"); //设置编译目录 
$smarty->cache("./cache"); //缓存目录 
$smarty->cache_lifetime = 0; //缓存时间 
$smarty->caching = true; //缓存方式 

$smarty->left_delimiter = "{#"; 
$smarty->right_delimiter = "#}"; 
$smarty->assign("name", "zaocha"); //进行模板变量替换 
$smarty->display("test.htm");
	
	
	
	/*
	$control=$_REQUEST['co'];//控制器
	 if (empty($control)) {
	 	$control=$config_arr['default_co'];
	 }

	 $action=$_REQUEST['ao'];//做什么事情？
	  if (empty($action)) {
	 	$action=$config_arr['default_ao'];
	 }
  

	 //权限管理
	 // 这个数组里面的控制器需要登录
	 $access_arr=array('resume','message','info');

	//怎么判断一个字符串是否在数组里面	 
	 if (in_array($control, $access_arr)) {
	 	 //判断到底有没有登录
	 		if (empty($_SESSION['uid'])) {
	 			header("location:index.php");
	 		}
	 }elseif ($control=='login' && $action=='index' && $_SESSION['uid']) {
	 	 header("location:index.php?co=jobseekers");
	 }
	$control_name=$control."Controller";
	 //include_once ROOT_PATH."/controller/".$control.".php";//执行和引入文件
	 include_once ROOT_PATH."/controller/".$control_name.".php";
	$job_class=new $control_name();
	 // //对象的调用
	 $job_class->$action();
	 // 单一入口
	 // 为什么？
	 // 程序：安全*/
?>