<?php 
/*
'软件名称：xypaly 智能视频解析  X4
'开发作者：nohacks  QQ：23453161  官方网站：http://www.xymov.net/
'--------------------------------------------------------
'适用本程序需遵循 商业软件 许可协议
'这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
'不允许对程序代码以任何形式任何目的的再发布。
'--------------------------------------------------------
*/

//运行目录
define("FCPATH", str_replace("\\", "/",dirname(__FILE__)));

//加载核心类
 require_once FCPATH.'/include/class.main.php';

 if( file_exists(FCPATH.'/save/config.php')){
     
//加载配置文件
 require_once FCPATH.'/save/config.php';   
     
 }else{
  header("Refresh:3;url=./admin"); 
  die('<font color="red">未检测到配置文件<br>即将跳转到后台初始化<br>默认账号：admin,密码：admin888<br>登录后台后请点击确认恢复配置或点击右上角重置按钮。</font>');
 }

  if( !file_exists(FCPATH.'/'.$CONFIG["API_PATH"])){
    die('<font color="red">核心文件('.$CONFIG["API_PATH"].')未找到，请检查是否被误杀！</font>');   
 }
 
define("ROOT_PATH", $CONFIG["ROOT_PATH"] ? $CONFIG["ROOT_PATH"] : GlobalBase::is_root());

//反腾讯安全检查
//require_once FCPATH.'/include/class.fackqq.php';

//微信QQ防红
if($CONFIG['plus']['weixin']['jmp_off']==1){
	require_once FCPATH.'/include/class.jmpqq.php';
}



//加载防火墙规则
Blacklist::parse($CONFIG["BLACKLIST"]);

//广告过滤
if(filter_input(INPUT_GET, $CONFIG["BLACKLIST"]["adblack"]["name"])){exit(AdBlack::parse($CONFIG["BLACKLIST"]["adblack"],ROOT_PATH));}


///空参数处理
if($CONFIG["NULL_URL"]['type']>0 && !filter_input(INPUT_GET, "url")&& !filter_input(INPUT_GET, "v")&&!filter_input(INPUT_GET, "wd")&&!preg_match("/^index(\d+)-(\d+)(?:-|)(?:(\d+|)).*?$/i",$_SERVER["QUERY_STRING"])){
		    if($CONFIG["NULL_URL"]['type']==1){
			  exit(base64_decode($CONFIG["NULL_URL"]['info']));
		  }else if($CONFIG["NULL_URL"]['type']==2 || $CONFIG["NULL_URL"]['type']==3 ){
   if($CONFIG["NULL_URL"]['type']==2){
                      
                      $NULL_JMP=$CONFIG["NULL_URL"]['url']; 
   }else{
        $NULL_JMP="mov";
   }
                      
$code=base64_decode($CONFIG["FOOTER_CODE"]);
$TITLE=$CONFIG["TITLE"];
$keywords=$CONFIG["keywords"];
$description=$CONFIG["description"];
exit(<<<code
<!DOCTYPE html>
 <!--[if lt IE 7 ]><html class=ie6><![endif]--> <!--[if IE 7 ]><html class=ie7><![endif]--> <!--[if IE 8 ]><html class=ie8><![endif]--> <!--[if IE 9 ]><html class=ie9><![endif]--> <!--[if (gt IE 9)|!(IE)]><!--><html class=w3c><!--<![endif]-->       
<head>     
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> <meta name="renderer" content="webkit" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv="pragma" content="no-cache" /><meta http-equiv="expires" content="0" />
<meta name="keywords" content="$keywords" />
<meta name="description" content="$description" />   
<title>$TITLE</title> 
<style>
html,body{overflow:hidden;  
width:100%;
height: 100%; 
margin: 0;
padding: 0;
}
</style>
</head>
<body>
<iframe width="100%" height="100%" src="$NULL_JMP" frameborder="0" border="0" marginwidth="0" marginheight="0" allowfullscreen="allowfullscreen"  mozallowfullscreen="mozallowfullscreen"  msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" ></iframe>
 $code       
</body>
</html>  	 
code
); 



	  }
}

//定义模板目录

define('TEMPLETS_NAME',(lsMobile()? $CONFIG["templets"]['wap']:$CONFIG["templets"]['pc']));

define('TEMPLETS_PATH', 'templets/'.TEMPLETS_NAME.'/');

//加载模版

include_once  TEMPLETS_PATH.$CONFIG["templets"]['html'].'/index.htm';
