<?php
include('libraries/smarty/Smarty.class.php'); //包含smarty类文件
define('_SITE_ROOT','D:/PHP/wamp/www/php2');
 
$smarty = new Smarty(); 

//$smarty->assign("newsArray", $array); 

//编译并显示位于./templates下的index.tpl模板 

$smarty->display("template/test.html"); 
$smarty->display("template/resume/index.html"); 



/*		$tpl = new Smarty(); //建立smarty实例对象$smarty 
		$tpl->template_dir=_SITE_ROOT."/template/"; //设置模板目录 
		$tpl->compile_dir=_SITE_ROOT."/template_c"; //设置编译目录 
		$tpl->config_dir=_SITE_ROOT."/config";
	//	$tpl->cache_lifetime = 3600; //缓存时间 
		$tpl->caching = flase; //缓存方式 ,是否要进行缓存以及缓存的方式。它可以取3个值，0：Smarty默认值，表示不对模板进行缓存；1：表示Smarty将使用当前定义的cache_lifetime来决定是否结束cache；2：表示

//Smarty将使用在cache被建立时使用cache_lifetime这个值。习惯上使用true与false来表示是否进行缓存。
		$tpl->cache_dir=_SITE_ROOT."/cache"; //缓存目录 

		$tpl->left_delimiter = "{"; 
		$tpl->right_delimiter = "}"; 
	//$tpl->assign("name", "zaocha"); //进行模板变量替换 
		//$tpl->display("index_js.html"); //编译并显示位于./templates下的index.htm模板 
*/
?>