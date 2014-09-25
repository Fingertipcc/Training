<?php
class MySqlHelper { // mysql helper
	/**
	 * 报错处理
	 *
	 * @param string $error        	
	 */
	function err($error) {
		die ( "操作有误，错误原因：" . $error );
	}
	/**
	 * 链接数据库
	 *
	 * @param string $config
	 *        	链接字符串 配置数组array($dbhost,$dbuser,$dbpsw,$dbname,$dbcharst)
	 *        	[主机地址，用户名，密码，数据库名，字符集【也就是编码格式】]
	 *        	
	 */
	function connect($config) {
		extract ( $config ); // 将数组还原成变量【变量名=变量值】
		if (! ($con = mysql_connect ( $dbhost, $dbuser, $dbpsw ))) { // 链接数据 []
			
			$this->err ( mysql_error () );
		}
		if (! mysql_select_db ( $dbname, $con )) { // 选择数据库
			$this->err ( mysql_error () );
		}
		mysql_query ( "set names " . $dbcharst ); // 设定字符编码 建议使用 utf8
		return true;
	}
	/**
	 * 执行查询
	 *
	 * @param string $sql
	 *        	查询语句
	 * @return resource
	 */
	function query($sql) {
		if (! ($query = mysql_query ( $sql ))) { // 执行查询
			$this->err ( $sql . "<br/>" . mysql_error () );
		} else {
			return $query;
		}
	}
	/**
	 * 返回所有
	 *
	 * @param string $sql
	 *        	sql 语句
	 * @return Ambigous <string, multitype:> 返回数组列表
	 */
	function findAll($sql) {
		$query = $this->query ( $sql );
		while ( ($rs = mysql_fetch_array ( $query, MYSQL_ASSOC )) ) { // 把资源转换成数组 一行一行的转
			$list [] = $rs;
		}
		return isset ( $list ) ? $list : ""; // 返回 先要判断是否存在
	}
	/**
	 * 返回一条
	 *
	 * @param string $sql        	
	 *
	 * @return array : 返回单条数据 数组
	 */
	function findOne($sql) {
		$query = $this->query ( $sql );
		$rs = mysql_fetch_array ( $query, MYSQL_ASSOC );
		return $rs;
	}
	/**
	 * 返回指定行 指定列的结果 【默认第一行 第一列】
	 *
	 * @param string $sql
	 *        	sql 语句
	 * @param int $row
	 *        	指定行
	 * @param int $field
	 *        	指定的列
	 * @return string
	 */
	function findResult($sql, $row = 0, $field = 0) {
		$query = $this->query ( $sql );
		$rs = mysql_result ( $query, $row, $field );
		return $rs;
	}
	/**
	 * 插入
	 *
	 * @param string $tableN
	 *        	表名
	 * @param array $arr
	 *        	字段和值对应的数组【如：array('a'=>1,'b'=>2)】
	 * @return number 返回主键
	 *        
	 */
	function insert($tableN, $arr) {
		foreach ( $arr as $key => $value ) {
			$value = mysql_real_escape_string ( $value ); // 转义 防止 sql注入
			$keyArr [] = "`" . $key . "`";
			$valueArr [] = "'" . $value . "'";
		}
		$keys = implode ( ",", $keyArr );
		$values = implode ( ",", $valueArr );
		$sql = "insert into `" . $tableN . "`(" . $keys . ") values(" . $values . ")"; // 拼接sql语句
		$this->query ( $sql );
		return mysql_insert_id ();
	}
	/**
	 * 更新
	 *
	 * @param stringing $tableN
	 *        	表名
	 * @param array $arr
	 *        	字段和值对应的数组【如：array('a'=>1,'b'=>2)】
	 * @param string $where
	 *        	where 语句
	 */
	function update($tableN, $arr, $where) {
		foreach ( $arr as $key => $value ) {
			$value = mysql_real_escape_string ( $value ); // 转义 防止 sql注入
			$keyAnadValArr [] = "`" . $key . "`='" . $value . "'";
		}
		$setStr = implode ( ",", $keyAnadValArr );
		$sql = "update `" . $tableN ."` set " . $setStr . " where " . $where;
		$this->query ( $sql );
	}
	/**
	 * 删除
	 *
	 * @param string $tableN
	 *        	表名
	 * @param string $where
	 *        	where 语句
	 */
	function delete($tableN, $where) {
		$sql = "delete from " . $tableN . " where " . $where;
		$this->query ( $sql );
	}
}








