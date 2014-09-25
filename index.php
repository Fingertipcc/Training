<?php 
date_default_timezone_set("Asia/Shanghai");
require_once 'config.php';
require_once 'MySqlHelper.php';
$he=new MySqlHelper();
echo date(' Y-m-d H:i:s')."<br>".($he->connect($config));
?>

