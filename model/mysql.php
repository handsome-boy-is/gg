<?

/**
 * mysql被弃用版
 * 数据库操作类 
 * 模型的父类
 * 添加、删除
 */
class Mysql 
{
	
	function __construct()
	{
	//	# code...
	}

	public function init()
	{
			// 第一步连接mysql
			$link=@mysql_connect("127.0.0.1","root","");
		 
			// 把当前的目录，放在一个常量中
			// 怎么定义常量
			// 预定义变量
			// __FILE__ 返回当前文件的目录，包含当前文件
			if (!$link) {
				die('Could not connect: ' . mysql_error());
			}
			// C:\wamp\www\20160926\1208\enterprise   / /
			// echo str_replace("\\","/",dirname(__FILE__));//返回当前文件的目录，不包含当前文件
			
			// 定义
			define("ROOT_PATH",str_replace("\\","/",dirname(__FILE__)) );
			 

			// 第二步使用数据库
			 mysql_select_db("yuanku_job");

			mysql_query("set names utf8");
	}

	/**
	 * 添加数据
	 * @param [string] $table        [表名]
	 * @param [array] $column_array [列值]
	 */
	public function add($table,$column_array)
	{

		$column_str=implode(",",  array_keys($column_array));

		//转换值
		$val_a=array_values($column_array);

		foreach ($val_a as $key => $value) {
			$new_val_a[]="'".$value."'";
		}
		$column_val= implode(",", $new_val_a);

		 $insert_sql="insert into $table ($column_str) values ($column_val)";
		
		 mysql_query($insert_sql);


	}

	/**
	 * 显示列表信息
	 * @param  string $table 表名
	 * @return array        所有列表信息
	 */
	public function lists($table,$limit='',$where_array='')//,$where=null
	{
		//通过求职者用户控制器传过来的当前登录id作为判断依据，使个人页面只显示个人信息，而不是所有注册者的个人；
		$limit_sql='';

		/*if($where){
			$select_sql="select * from $table where id=$where";
		}
		else{*/
			///////////////////////////////////////////////////////////////////////////////////////!!!!!!!!!!!!!!!!!!!!!!!!!!!!/////////////////////////////////////////////////!
			if ($limit) {
				$limit_sql= ' limit '.$limit;
			}
	
			$where_sql='';
			if ($where_array) {
				$where_sql=' where ';
				$where_sql.=do_sql_string($where_array,"and");
			}
			$select_sql="select * from $table $where_sql  order by id desc ".$limit_sql;
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//}
		$result=mysql_query($select_sql);
		
		$return_a;
		while ($row=mysql_fetch_assoc($result)) {
			$return_a[]=$row;
			
		}
			
		return $return_a;
	}
	/**
	 * 获取一条信息，通过任意条件
	 * @param  string $table       表名
	 * @param  array $where_array 条件数组
	 * @return array              返回一条记录
	 */

	public function get_info($table,$where_array)
	{
		// user_name='admin' and user_pwd='123456'
		
		 $where_sql=do_sql_string($where_array,"and");
		 $sel_sql="select * from $table where ".$where_sql ;
		 $res_query=mysql_query($sel_sql);

		 return  mysql_fetch_assoc($res_query);
		 
	}
	/**
	 * 删除一条信息通过主键ID
	 * @param  string $table 表名
	 * @param  int $id    主键ID
	 * @return null        如果id没有值就返回空
	 */
	public function delete($table,$id)
	{

		// delete from 表名   //不加条件删除整个表的信息
		// delete from 表名 where 列名=值名   //删除指定条件的信息
		if ($id<=0) {
			return;
		}else{
			$dele_sql="delete from $table where id=$id";
			mysql_query($dele_sql);
		}
	}
	/**
	 * 修改一条信息
	 * @param  string $table       表名
	 * @param  array $set_array   需要修改
	 * @param  arrray $where_array 修改的条件
	 */
	public function update($table,$set_array,$where_array)
	{
		// mysql 的修改update 语法
		//  update 表名 set 列名1=列值1,列名2=列值2            修改整个表的对应列的信息
		//  update 表名 set 列名1=列值1,列名2=列值2,...  where 条件1=条件值1 and 条件2=条件值2
	 
		//job_name='HTML5',money='234234'
		
		$set_str=do_sql_string($set_array,",");
		$where_str=do_sql_string($where_array,"and");

		 $upd_sql="update $table set $set_str  where $where_str ";
 //echo $upd_sql;
		mysql_query($upd_sql);

	}



}









?>