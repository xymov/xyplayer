<?php 
!defined('APP_PATH') AND define('APP_PATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')), '/') . '/');
if(!file_exists(APP_PATH.'save/config.php')){ exit("input error!");}
include APP_PATH.'include/class.main.php';include APP_PATH.'save/config.php';
if(function_exists("opcache_reset")){opcache_reset();} //清除PHP脚本缓存
session_start(); $webapi="http://xymov.nohacks.cn";$website="http://nohacks.cn";
if(empty($_SESSION['hashstr']) || filter_input(INPUT_COOKIE, 'login_token')!=='1' || $_SESSION['hashstr']!==md5((isset($CONFIG["user"])?$CONFIG["user"]:"admin").(isset($CONFIG["pass"])?$CONFIG["pass"]:MD5("admin888")))){echo "<script>location.href='load.php?url=login.htm'</script>";exit();}
$username=$_SESSION['username'];






