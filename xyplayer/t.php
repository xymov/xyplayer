<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
echo curl_get("https://api.apibdzy.com/api.php/provide/vod/?wd=猎冰",true,true);
/**
 * get请求
 * @param $url
 */
function curl_get($url,$gzip=false,$firefox=false) {
	if($firefox) {
		//火狐浏览器
		$useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:99.0) Gecko/20100101 Firefox/99.0';
	} else {
		//谷歌浏览器
		$useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36';
	}
	$header = FormatHeader($url,$useragent);
	$timeout= 120;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	//设置请求头信息
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	//不取得返回头信息	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	if($gzip) {
		//解释gzip加密压缩
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
	}
	// 关闭https验证
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt($ch, CURLOPT_ENCODING, "" );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_AUTOREFERER, true );
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout );
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout );
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	$content = curl_exec($ch);
	curl_close($ch);
	return $content;
}
//添加请求头
function FormatHeader($url,$useragent) {
	// 解析url
	$temp = parse_url($url);
	$query = isset($temp['query']) ? $temp['query'] : '';
	$path = isset($temp['path']) ? $temp['path'] : '/';
	$header = array (
		 "POST {$path}?{$query} HTTP/1.1",
		 "Host: {$temp['host']}",
		 "Referer: http://{$temp['host']}/",
		 "Content-Type: text/xml; charset=utf-8",
		 'Accept: application/json, text/javascript, */*; q=0.01',
		 'Accept-Encoding:gzip, deflate, br',
		 'Accept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
		 'Connection:keep-alive',
		 'X-Requested-With: XMLHttpRequest',
		 'User-Agent: '.$useragent,
		 );
	return $header;
}