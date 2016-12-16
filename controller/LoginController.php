<?

//数据名：yuanku_job  && 用到的数据表：jobseekers  &&  种类型：UserName（用户）、PassWrod（密码）、Phone（注册电话）
	header("Content-type: text/html; charset=utf-8");  
	
	
	//验证码
	class loginController  extends BaseController{	
	
		public function index() {
			
			include_once ROOT_PATH.'/template/login.html';
		}
	
		public function indexs() {
			
			include_once ROOT_PATH.'/template/resume/index.html';
		}
	
		public function do_login() {	
				
				$Verification=$_POST['Verification'];
				$code=$_SESSION['code'];
				$salt='YUANKU_MM';
				//$admin=$_POST['admin'];
				$pwds=md5($salt.md5($_POST['pwd']).$salt);
				
				$pdo_model=new BaseModel();
				$checkbox=$_POST['checkbox'];
				//$js_sql="select * from jobseekers where  UserName='$admin' and PassWord='$pwds'";
				
				//$login_init=mysqli_connect('127.0.0.1','root','','yuanku_job');	
				//mysqli_query($con,$sql) 函数执行某个针对数据库的查询
				//$hs_res_query=mysqli_query($login_init,$js_sql);
				//传出相应用于核对的用户数据 
				//$infos=mysqli_fetch_assoc($hs_res_query);  
				$infos= $pdo_model->get_info('jobseekers',array('UserName'=>$_POST['admin'],'PassWord'=>$pwds));//?!
				
				//mysqli_query($login_init,"set names utf8");
				
				
				
				if($Verification == $code){
					
						if($infos )
						{
							$_SESSION['uid']=$infos['id'];
							$arr=array('status' =>1 ,'msg' =>'s','ck' =>$checkbox,'code'=>'');
							setcookie("username_login_status",1, time()+3600*24);
							//登录模块选中了“记住我”才保存一星期
							if($checkbox){
								setcookie("username_login",1, time()+3600*24*7);
								}		
							$tip_what="用户名或密码正确";
							$go_where="index.php";
							
						}
						else  {
							$arr = array('status'=>0,'msg' => '帐号或密码错误了','code'=>'');
							setcookie("username_login_status",0);
							 $tip_what="用户名或密码不正确！";
							$go_where="index.php";
							
							}
					
					}
						
				else {
					$arr = array('status'=>0,'msg' => '','code'=>'验证码错误');
					setcookie("username_login_status",0);
					
					}	
				$go_where="index.php";
				echo json_encode($arr);
				
		}
		
		// 退出登录
		public function logout() {
			 //
			setcookie('username_login_status');
			session_destroy();
	
			$tip_what="退出成功！";
			$go_where="index.php";
			include_once ROOT_PATH."/template/success.html";
			jump_do("退出成功！","/template/success.html");
		}
		
		
		// 注册页面
		public function register()
		{
			include_once ROOT_PATH.'/template/register.html';
		}
		public function do_register()
		{
			
			 
			// 添加数据的语法
			// insert into 表名 (列名1,列名2) values (列名1的值，列名2的值);
			
			// 怎么防止用户名重复?
			// 如果有记录则不能注册
			
			 $mysql=new Mysql();
			 $mysql->init();
			 
			 
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
			//	$login_init=mysqli_connect('127.0.0.1','root','','yuanku_job');
			//	$select_sql="select * from jobseekers where UserName='$user_name'";
				//$query_s= mysqli_query($login_init,$select_sql);
				
				 // 结果集转换数组
				//$info= mysqli_fetch_row($query_s);
				
				 $pdo_model=new BaseModel();
				 $info= $pdo_model->get_info('jobseekers',array('UserName'=>$user_name)); 
				
			 
			//注册检验帐号是否存在
			if (!empty($info)) {
				$arr=array( 'info' => '该用户已经存在！');
				}
			else{
				$arr=array( 'info'=> '可用');
			
			
				//验证码是否正确
				if($Verification == $code){
					
				$arr=array('info'=> '可用','code' =>'ok');
					
						if($tip){
							//$insert_sql="insert into jobseekers (UserName,PassWord,Phone)  values('$user_name','$user_pwd','$phone')";
							//数据库插入新数据
							// mysqli_query($login_init,$insert_sql);
									$add_array["UserName"]=$user_name;
									$add_array["PassWord"]=$user_pwd;
									$add_array["Phone"]=$phone;
									$add_array["reg_time"]=time();
				
	
							$pdo_model->add("enterprise_user",$add_array); 
	
							$arr=array('info'=> '','code' =>'ok','msg' =>'注册成功！');
							jump_do("注册成功！","/jobseekers");
							
							}
						else{
							$arr=array('info'=> '','code' =>'验证码不正确了','msg' =>'注册bu成功！');
							}	
		
			}
			else{
				$arr=array('info'=> '可用','code' =>'验证码不正确了','msg' =>'');
				}
				
			
			
			}
		
	
				echo json_encode($arr);	
				}
	
	}

?>