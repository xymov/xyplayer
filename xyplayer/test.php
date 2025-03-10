<?php

// 创建URL列表
$urls = array(
    'https://api.apibdzy.com/api.php/provide/vod/?wd=猎冰',
 
);
$res=HttpMulti::multiRun($urls);

var_dump($res);

class HttpMulti {
     //curl选项
       
         
       private  static $options = array(
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36',
        CURLOPT_NOBODY=>false ,     //设定是否输出页面内容
        CURLOPT_RETURNTRANSFER=>true,  //返回字符串，而非直接输出到屏幕上
        CURLOPT_SSL_VERIFYPEER => 0,   //不开启HTTPS请求
        CURLOPT_RETURNTRANSFER => 1,   //请求信息以文件流方式返回
        CURLOPT_CONNECTTIMEOUT => 10,  //连接超时时间 默认为10s
        CURLOPT_AUTOREFERER=>true,    //当Location:重定向时，自动设置header中的Referer:信息
        CURLOPT_TIMEOUT =>10,   //设置curl执行最大时间
        CURLOPT_ENCODING => "", //HTTP请求头中"Accept-Encoding"的值，为空发送所有支持的编码类型,解决网页乱码问题
        CURLOPT_HEADER => 0, //设置为true,请求返回的文件流中就会包含response header
    	CURLOPT_POST => FALSE,   //默认选择GET的方式发送
	
        );
       //添加请求头
public static  function FormatHeader($url) {
	// 解析url
	$temp = parse_url($url);
	$query = isset($temp['query']) ? $temp['query'] : '';
	$path = isset($temp['path']) ? $temp['path'] : '/';
        $ip =self::rand_ip();
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
		 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36',
                 'X-FORWARDED-FOR:' . $ip,
                  'CLIENT-IP:' . $ip
		 );
	return $header;
}    
      public static function rand_ip()
    {
        $ip_long = array(
            array('607649792', '608174079'), //36.56.0.0-36.63.255.255
            array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
            array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
            array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
            array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
            array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
            array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
            array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
            array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
            array('-569376768', '-564133889') //222.16.0.0-222.95.255.255
        );
        $rand_key = mt_rand(0, 9);
        $ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
        return $ip;
    }
      
           
      public static function multiRun($urls=array()){
      
         if(empty($urls)) {return false;}
           
// 初始化会话
$mh = curl_multi_init();


// 创建cURL句柄并添加到会话
$handles = array();
$response=array();
 
foreach ($urls as $url) {
    $header = self::FormatHeader($url);
    $ch = curl_init($url);
    curl_setopt_array($ch, self::$options);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);      //伪装来源 IP地址 
    curl_multi_add_handle($mh, $ch);
    $handles[] = $ch;
}
  
  // 执行会话中的cURL句柄
   $active = null;
do {
    $result = curl_multi_exec($mh, $active);
} while ($result == CURLM_CALL_MULTI_PERFORM || $active);

// 处理结果
foreach ($handles as $handle) {
   
    // 处理响应数据
    $response[] = curl_multi_getcontent($handle);
    
    // 移除句柄和关闭cURL
    curl_multi_remove_handle($mh, $handle);
    curl_close($handle);
}
  
// 关闭会话
curl_multi_close($mh);

//返回结果
return $response;

 }      
           
                 
   }
   
   
  