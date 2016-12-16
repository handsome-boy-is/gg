<?
/**
 * 数据库PDO操作类
 * 重构mysql.php
 */
class BaseModel {

	private static $DBName;//数据库名字
	private static $DBUser;//数据库用户名
	private static $DBPwd;//数据库密码
	private static $HOST;//数据库地址
	private static $db_driver;//数据库地址
	private static $pdo_db;//当前pdo对象
	private static $query_sql;//执行的sql语句

	//构造函数
	public function __construct(){
		global $config_arr;

		self::$DBName=$config_arr['db_name'];
		self::$DBUser=$config_arr['db_user'];
		self::$DBPwd=$config_arr['db_pwd'];
		self::$HOST=$config_arr['db_host'];
		self::$db_driver=$config_arr['db_driver'];

		try {
			self::$pdo_db=new PDO(self::$db_driver.":host=".self::$HOST.";dbname=yuanku_job",self::$DBUser,self::$DBPwd);//
			self::$pdo_db->exec("set names utf8");
		} catch (Exception $e) {
			echo $e;
		}

	}

	/**
	 * 添加一条记录
	 * @param [type] $table        [description]
	 * @param [type] $column_array [description]
	 *
	 * exec 和 之前的query方法是一样的功能
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
		return self::$pdo_db->exec($insert_sql);

	}

	/**
	 * 显示所有信息列表
	 * @param  string $table 表名
	 * @return array        所有列表信息
	 * pdo 和之前的mysql_函数是不可以混合使用的
	 */
	public function lists($table,$limit='',$where_array='',$order_column='')
	{
		$limit_sql='';
		if ($limit) {
			$limit_sql= ' limit '.$limit;
		}

		$where_sql='';
		if ($where_array) {
			$where_sql=' where ';
			$where_sql.=do_sql_string($where_array,"and");
		}

	
		if (empty($order_column)) {
			$order_column=" id desc";
		}

		//sql语句   order by 列名 desc/asc 
		//desc 降序  从大到小
		//asc 升序  从小到大
		self::$query_sql="select * from $table $where_sql  order by $order_column  ".$limit_sql;
		$pre_stat=self::$pdo_db->prepare(self::$query_sql);// prepare 是什么？
		
		$result=$pre_stat->execute(); // execute 预处理sql语句

		$return_a;
		if ($result) {
			$return_a=$pre_stat->fetchAll(PDO::FETCH_ASSOC);
		}else{
		  self::show_error_info();
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

		self::$query_sql="select * from $table where ".$where_sql ;
		$pre_stat=self::$pdo_db->prepare(self::$query_sql);// prepare 是什么？
		
		$result=$pre_stat->execute(); // execute 预处理sql语句

		return  $pre_stat->fetch(PDO::FETCH_ASSOC);
		 
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
			self::$pdo_db->exec($dele_sql);
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

		self::$pdo_db->exec($upd_sql);

	}
	/**
	 * 错误信息显示
	 * @return string  [description]
	 */
	public static function show_error_info()
	{
		global $config_arr;

		if ($config_arr['debug']) {
		 	echo '错误代号：'.self::$pdo_db->errorinfo()[0].'，错误sql:'.self::$query_sql;
		}
	}
	/**
	 * 获取最后执行的sql语句
	 */
	public function get_last_sql()
	{
		return self::$query_sql;
	}

}

?>