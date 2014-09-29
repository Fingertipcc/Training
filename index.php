<?php
error_reporting ( E_ALL ^ E_NOTICE ); // 屏蔽notice 通知
header ( "Content-type: text/html; charset=utf-8" );
set_time_limit ( 0 );
date_default_timezone_set ( "Asia/Shanghai" );
require_once 'config.php';
require_once 'MySqlHelper.php';
$he = new MySqlHelper ();
$he->connect ( $config );
/* $he->delete("TestTB", "1"); */
echo date ( "H:i:s" ) . "<BR>";
$he->query ( BEGIN );
for($i = 0; i < 1000 * 100; $i ++) {
	$name = rands ( 10 );
	$age = mt_rand ( 7, 99 );
	$arr = array (
			'Name' => $name,
			'Age' => $age 
	);
	$he->insert ( "TestTB", $arr );
	if ($i % 10000 == 0) {
		$he->query ( COMMIT );
		echo "提交10
				000";
		$he->query ( BEGIN );
	}
}
$he->query ( COMMIT );
echo date ( "H:i:s" );
function rands($lenth) {
	$str = "0123456789QAZWSXEDCRFVTGBYHNUJMIKOLPqazwsxedcrfvtgbyhnujmikolp";
	$key = "";
	for($i = 0; $i < $lenth; $i ++) {
		$key = $key . $str [mt_rand ( 0, 62 )];
	}
	return $key;
}
?>

