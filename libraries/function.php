<?php

	/**
	 * 跳转页面
	 * @param  string $tip_val 提示信息
	 * @param  string $go_val  跳转的url
	 */
	function jump_do($tip_val,$go_val)
	{
		 
		$tip_what=$tip_val;
		$go_where=URL_PATH.$go_val;
		include_once ROOT_PATH."/template/success.html";
	}

	/**
	 * 处理mysql封装的语句
	 * @param  array $where_array    array('job_name'=>'HTML5','money'=>'2423423');
	 * @param  string $conn_char  连接符号 例如： , 或 and 等等
	 * @return string             job_name='HTML5',money='234234' 
	 */
	 function do_sql_string($where_array,$conn_char)
	{
		// $where_array=array('job_name'=>'HTML5','money'=>'2423423');

		$where_col=  array_keys($where_array);//array(0=>"job_name",1=>"money")
		
		$where_val=  array_values($where_array);//array(0=>"HTML5",1=>"2423423")
		  
		$where_sql;
		$and_tag=' ';
		foreach ($where_col as $k => $val) {

			 $where_sql.=$and_tag.$val."='".$where_val[$k]."'";
			 $and_tag=' '.$conn_char.' ';
		}
		// return job_name='HTML5',money='234234' 
		return $where_sql;
	}
?>