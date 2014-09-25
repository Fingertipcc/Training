<?php 
date_default_timezone_set("Asia/Shanghai");
echo  date(' Y-m-d H:i:s');
require_once 'config.php';
require_once 'MySqlHelper.php';
$he=new MySqlHelper();
$sre=$he->connect($config);
echo 'dsada'.$sre;
?>

