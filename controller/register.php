<?
//数据名：yuanku_job  && 用到的数据表：jobseekers  &&  种类型：UserName（用户）、PassWrod（密码）、Phone（注册电话）	
//【注册检验帐号是否存在】
header("Content-type: text/html; charset=utf-8");  
	include_once ('../init.php');
	session_start();
	
	$salt='YUANKU_MM';
	$code=$_SESSION['code'];
	$user_name=$_POST['new_admin'];
	//$user_pwd=$_POST['new_pwd'];
	$user_pwd=md5($salt.md5($_POST['new_pwd']).$salt);
	$phone=$_POST['phone'];
	$tip=$_POST['tip'];
	$Verification=$_POST['Verification'];
	 
	// 添加数据的语法
	$login_init=mysqli_connect('127.0.0.1','root','','yuanku_job');
	$select_sql="select * from jobseekers where UserName='$user_name'";
	$query_s= mysqli_query($login_init,$select_sql);
	
	 // 结果集转换数组
	$info= mysqli_fetch_row($query_s);
	//mysql_query("set names utf8");
	
	
	//注册检验帐号是否存在
	if (!empty($info)) {
		$arr=array( 'info' => '该用户已经存在！');
			}
	else{
		if($user_name == ""){
				$arr=array( 'info'=> '帐号不能为空');
				
				}
		else{
			$arr=array( 'info'=> '可用');
			
			
			//验证码是否正确
			if($Verification == $code){
					
				$arr=array('info'=> '可用','code' =>'ok');
					
						if($tip){
							$insert_sql="insert into jobseekers (UserName,PassWord,Phone)  values('$user_name','$user_pwd','$phone')";
							//数据库插入新数据
							 mysqli_query($login_init,$insert_sql);
							$arr=array('info'=> '','code' =>'ok','msg' =>'注册成功！');
							
							}
						else{
							$arr=array('info'=> '','code' =>'验证码不正确了','msg' =>'注册bu成功！');
							}	
						
					
			}
			else{
				
				$arr=array('info'=> '可用','code' =>'验证码不正确了','msg' =>'');
				}
				
		}
		
	}
	
	
	
		
	echo json_encode($arr);	
	
?>