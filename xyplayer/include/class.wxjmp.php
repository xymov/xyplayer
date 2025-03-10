<?php
error_reporting(0);
header('Content-Type: text/html; charset=UTF-8');
header("Cache-Control: no-store, no-cache");

function lswap() {
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$ualist = array('android', 'midp', 'nokia', 'mobile', 'iphone', 'ipod', 'blackberry', 'windows phone');
	foreach($ualist as $v) {
		if(strpos($useragent, $v) !== false) {
			return true;
		}
	}
	if(strpos($_SERVER['HTTP_ACCEPT'], "VND.WAP") !== false || strpos($_SERVER['HTTP_VIA'],"wap") !== false){
		return true;
	}
	return false;
}


/*
反腾讯网址安全检测系统
Description:屏蔽腾讯电脑管家网址安全检测
Version:2.6
Author:消失的彩虹海
*/
//IP屏蔽
$iptables='977012992~977013247|977084416~977084927|1743654912~1743655935|1949957632~1949958143|2006126336~2006127359|2111446272~2111446527|3418570752~3418578943|3419242496~3419250687|3419250688~3419275263|3682941952~3682942207|3682942464~3682942719|3682986660~3682986663|1707474944~1707606015|1709318400~1709318655|1884967642|1884967620|1893733510|1709332858|1709325774|1709342057|1709341968|1709330358|1709335492|1709327575|1709327041|1709327557|1709327573|1975065457|1902908741|1902908705|3029946827';
$remoteiplong=bindec(decbin(ip2long(real_ip())));
foreach(explode('|',$iptables) as $iprows){
	if($remoteiplong==$iprows)exit('我是阔爱的小承诺。！');
	$ipbanrange=explode('~',$iprows);
	if($remoteiplong>=$ipbanrange[0] && $remoteiplong<=$ipbanrange[1])
		exit('我是阔爱的小承诺。！');
}
//HEADER特征屏蔽
if(preg_match("/manager/", strtolower($_SERVER['HTTP_USER_AGENT'])) || strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla')===false && strpos($_SERVER['HTTP_USER_AGENT'], 'ozilla')!==false || isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'urls.tr.com')!==false || isset($_COOKIE['ASPSESSIONIDQASBQDRC']) || empty($_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_USER_AGENT'], 'HUAWEI G700-U00')!==false && !isset($_SERVER['HTTP_ACCEPT']) || preg_match("/Alibaba.Security.Heimdall/", $_SERVER['HTTP_USER_AGENT'])) {
	exit('我是阔爱的小承诺。！');
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS 9_3_4')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS 8_4')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'Android 6.0.1')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'MQQBrowser/6.8')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'en')!==false && strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'zh')===false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'en-')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'zh')===false) {
	exit('我是阔爱的小承诺。');
}
if(preg_match("/Windows NT 6.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*'|| preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*' || preg_match("/vnd.wap.wml/", $_SERVER['HTTP_ACCEPT']) && preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT'])){
	exit('我是阔爱的小承诺。');
}
function real_ip(){
$ip = $_SERVER['REMOTE_ADDR'];
if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
	foreach ($matches[0] AS $xip) {
		if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
			$ip = $xip;
			break;
		}
	}
} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
	$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
} elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
	$ip = $_SERVER['HTTP_X_REAL_IP'];
}
return $ip;
}

//检测手机QQ，微信客户端

if(lswap() && (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/')!==false) ){	
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" style="font-size: 100px;">
<head id="Head1"><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>站点提示</title>
    <!--禁止全屏缩放-->
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <!--不显示成手机号-->
    <meta name="format-detection" content="telephone=no" />
    <!--删除默认的苹果工具栏和菜单栏-->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!--解决UC手机字体变大的问题-->
    <meta name="wap-font-scale" content="no" />
    <!--控制状态栏显示样式-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <style>
body, div, form, input, li, ol, p, textarea, ul
{
    margin: 0;
    padding: 0;
}

body
{
    background: #ffffff;
    color: #3f3f3f;
    font-family: Apple LiGothic Medium,SimHei,Geneva,Arial,Helvetica,sans-serif;
    -webkit-tap-highlight-color: transparent;
    -webkit-tap-highlight-color: transparent;
    -webkit-touch-callout: none;
    -webkit-appearance: none;
    width: 100%;
    font-size: 16px;
}

a, button, input
{
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    -webkit-tap-highlight-color: transparent;
    -webkit-user-modify: read-write-plaintext-only;
    -webkit-touch-callout: none;
    -webkit-appearance: none;
    outline: none;
}
a:focus, input:focus
{
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    -webkit-tap-highlight-color: transparent;
    -webkit-user-modify: read-write-plaintext-only;
    -webkit-touch-callout: none;
    -webkit-appearance: none;
    border: 1px solid #FFFFFF;
    outline: none;
}


ul li
{
    padding: 0px;
    margin: 0px;
}

li
{
    list-style: none;
}

img
{
    border: 0 none;
}
span
{
    padding: 0px;
    margin: 0px;
}




.tx_top
{
    height: 2.8rem;
    margin: 0 auto;
    position: relative;
    background: url(../img/tx_bg.png) no-repeat;
    background-size: 15rem auto;
    overflow: hidden;
}
.top_bg
{
    width: 15rem;
    height: 5.8rem;
    margin: 0 auto;
    position: relative;
    background: url(../img/top_bg.png) no-repeat;
    background-size: 15rem auto;
    overflow: hidden;
}

.srk_bg
{
    width: 15rem;
    height: 7.4rem;
    margin: 0 auto;
    position: relative;
    background: url(../img/srk_bg.png) no-repeat;
    background-size: 15rem auto;
    overflow: hidden;
}
.hdgz_bg
{
    width: 15rem;
    height: 8.28rem;
    margin: 0 auto;
    position: relative;
    background: url(../img/hdgz_bg.png) no-repeat;
    background-size: 15rem auto;
    overflow: hidden;
}

.tx_con
{
    padding-left: 0.8rem;
    padding-top: 0.9rem;
}
.tx_top_tx
{
    width: 1.7rem;
    height: 1.7rem;
    border-radius: 1.6rem;
    border: 0.12rem solid #f6dbdd;
    float: left;
}
.tx_top_tx img
{
    width: 1.7rem;
    height: 1.7rem;
    border-radius: 1.6rem;
}
.tx_top_wz
{
    font-size: 0.52rem;
    color: #FFF;
    line-height: 0.6rem;
    padding-left: 2.8rem;
    padding-right: 0.9rem;
    padding-top: 0.5rem;
}





.wxhd_con_srk
{
    width: 12.4rem;
    margin: 0 auto;
    padding-top: 0.8rem;
}
.wxhd_con_srk_l
{
    background-color: #ffffff;
    border-radius: 0.1rem; height: 1.38rem;
    width: 12.4rem;
}

.wxhd_con_srk_l ul li.srk_nr
{
    float: left;
    width: 12rem;
    padding-left: 0.4rem;
}
.wxhd_con_srk_l ul li.srk_nr input
{ height: 1.38rem;
    width: 12rem;
    border: 0px;
    font-size: 0.6rem;
    text-align: center;
}

.wxhd_con_srk_l ul li.srk_nr2
{
    float: left;
    width: 7rem;
    padding-left: 0.4rem;
}
.wxhd_con_srk_l ul li.srk_nr2 input
{ height: 1.38rem;
    width: 7rem;
    border: 0px;
    font-size: 0.6rem;
}
.wxhd_con_srk_l ul li.srk_nr3
{
    float: right;
    width: 5rem;
    text-align: center;
    line-height: 1.38rem;
    font-size: 0.6rem;
    color: #FFF;
    background-color: #e74129;
    cursor: pointer;
    border-radius: 0rem 0.1rem 0.1rem 0rem;
}
.wxhd_wc
{
    width: 100%;
    padding-top: 1.4rem;
}
.wxhd_wc_an
{
    width: 12.4rem;
    margin: 0 auto;
    text-align: center; height: 1.38rem;
    line-height: 1.38rem;
    font-size: 0.7rem;
    color: #b71f2d;
    border-radius: 0.1rem;
    background-color: #fcc602;
}
.cwts
{
    height: 0.6rem;
    color: #F00;
    font-size: 0.6rem;
    padding-top: 0.4rem;
    text-align: center;
}
.xxtjh
{
    padding-top: 1.5rem;
    text-align: center;
    font-size: 0.6rem;
    padding-bottom: 0.15rem;
    line-height: 1.0rem;
    color: #b91422;
}
.xxtjh span
{
    color: #ff0003;
    font-size: 0.7rem;
}
.wxhd_wc_an2
{
    width:12.4rem;
    margin: 0 auto;
    text-align:center; height: 1.38rem;
    line-height: 1.38rem;
    font-size: 0.7rem;
    color: #fdcb5e;
    border-radius: 0.1rem;
    background-color: #e74129;
}
.fc_jt
{
    width: 15rem;
    height: 4.28rem;
}
.fc_jt img
{
    width: 15rem;
    height: 4.28rem;
}

.fc_wz
{
    height: 6.9rem;
    line-height: 1.0rem;
    font-size: 0.7rem;
    text-align: center;
    color: #333333;
}
.fc_tp
{
    width: 12.44rem;
    height: 10.0rem;
    margin: 0 auto;
}
.fc_tp img
{
    width: 12.44rem;
    height:10.0rem;
    text-align: center;
}
.wxhd_wc2
{
    width: 100%;
    padding-top: 0.3rem;
}



.all_main
{
    text-align: center;
    padding-top: 130px;
}
.all_main01
{
    text-align: center;
    padding-top: 30px;
    font-size: 28px;
    color: #999595;
    margin-bottom: 20px;
}
.all_main01 span
{
    color: #9dbad0;
}
.all_main01 a
{
    text-decoration: none;
}

.all_main02
{
    border-radius: 40px;
    -moz-border-radius: 40px; /* Firefox */
    -webkit-border-radius: 40px; /* Safari �� Chrome */
    background-color: #9dbad0;
    width: 400px;
    height: 60px;
    line-height: 60px;
    margin: 0 auto;
    color: #FFF;
    font-size: 24px;
    cursor: pointer;
    text-align: center;
}

.zxyq
{
   
    width: 15rem;
    background-color: #dd3149;
}
.zxyq_title
{
    height: 2.06rem;
    width: 15rem;
    text-align: center;
    background: url(../img/zxyq_title.jpg) center center no-repeat;
    background-size: 5.3rem auto;
}
.zxyq_main
{
    margin: 0 auto;
    width: 12.82rem;
    background-color: #e1485e;
    padding-left: 0.8rem;
    padding-right: 0.8rem;
    padding-top: 0.8rem;
	padding-bottom: 0.8rem;
}

.zxyq_main ul li
{
    clear: both;
    color: #ffffff;
    font-size: 0.56rem;
    line-height: 1.45rem;
	overflow:hidden;
}
.imgtx
{
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    overflow: hidden;
    border: #FFF 0.04rem solid;
    float: left;
    margin-top: 0.2rem;
}
.imgtx img
{
    width: 1rem;
    height: 1rem;
}
.nicheng
{
    width: 2.4rem;
    height: 1rem;
    margin-left: 0.4rem;
    float: left;
}
.mes
{
    width: 5.3rem;
    float: left;
}
.time
{
    width:3rem;
    height: 1rem;
    margin-left: 0.4rem;
    color: #f5adb7;
    float: right;
    text-align: right;
}

</style>
<script type="text/javascript">
window.onload=function(){
   setRootFontSize();
}

window.onresize = function () {
    setRootFontSize();
}
function setRootFontSize() { 
  document.querySelector("html").style.cssText ='font-size:'+ document.body.clientWidth / 15+'px;';
}
    </script>
	
</head>
<body style="background-color: #f5f5f5;">
    <div id="Pan_WX">
        <!--微信访问-->
        <div class="fc_jt">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAu4AAADWCAIAAAAByZB0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpERkU0RkUzN0NCNjExMUU2ODRFODhCMTdCODhGNjFBNSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpERkU0RkUzOENCNjExMUU2ODRFODhCMTdCODhGNjFBNSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkRGRTRGRTM1Q0I2MTExRTY4NEU4OEIxN0I4OEY2MUE1IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkRGRTRGRTM2Q0I2MTExRTY4NEU4OEIxN0I4OEY2MUE1Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+jYEgaQAAD85JREFUeNrs3Xt014P/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"></div>
               <div class="fc_wz">
                点击屏幕右上角[...]<br />
                用 浏览器 打开(不要使用QQ和搜狗浏览器)
            </div>  
          <div class="fc_tp">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAm4AAAIICAIAAABYZ/UDAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpBODA2OTE0NUNEQUIxMUU2ODc0RkM0MTkyNUFBN0U5QiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpBODA2OTE0NkNEQUIxMUU2ODc0RkM0MTkyNUFBN0U5QiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkE4MDY5MTQzQ0RBQjExRTY4NzRGQzQxOTI1QUE3RTlCIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkE4MDY5MTQ0Q0RBQjExRTY4NzRGQzQxOTI1QUE3RTlCIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+5JcgSAAAsi5JREFUeNrsvVd0G1mW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"></div>
		</div>
</body>
</html>

<?php
exit();
}
?>

