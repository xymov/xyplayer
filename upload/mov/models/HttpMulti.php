<?php

/**
 * Description of HttpMulti
 *
 * @author nohacks
 */

/*
 ########多线程取网页简化版########  
 * 
 $response = HttpMulti::Run(['http://www.baidu.com','http://www.baidu.com']);

 $response = HttpMulti::request('http://www.baidu.com');
 */ 
 
 // var_dump( HttpMulti::run(['http://www.youku.com','http://www.baidu.com']));


class HttpMulti{
    //获取多个url，返回数组
     public static function run($urls){
        
           $response = new MultiHttpRequest();
        
           return($response->setRequests($urls)->request());
    }
    
     public static function request($url){
     //获取单个url，返回文本   
           $response = new MultiHttpRequest();
        
           return($response->setRequests(array($url))->request()[0]);
    }
    
    
}
/* 
 ########多线程取网页源码########  
 $response = new MultiHttpRequest();
  $url=[
        ['url' => 'http://www.baidu.com',
        'postData'=>['wd'=>'电影'],
	'header' => ["Content-Type: application/Json","X-Requested-With: XMLhttpRequest"],
	'proxy'=>'127.0.0.1:8080'],
        ['url' => 'http://www.baidu.com']
       ];
  $url=['http://www.baidu.com','http://www.baidu.com']; // 简化版
  $json=$response->setRequests($url)->request();
*/
class MultiHttpRequest{
    public $requests = [];
    public $poolSize;

    public $useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36';
	
   
    /**
     * 设置请求url
     *
     * @param $requests
     * @return $this
     */
    public function setRequests($requests,$poolSize=50) {
        $this->requests = $requests;
        $this->poolSize = $poolSize;
        return $this;
    }

    
    //添加请求头
   public  function FormatHeader($url) {
	
	// 解析url
	$temp = parse_url($url);
	$query = isset($temp['query']) ? $temp['query'] : '';
	$path = isset($temp['path']) ? $temp['path'] : '/';
        $ip=$this->rand_ip();

	$header = array (
		 "GET {$path}?{$query} HTTP/1.1",
		 "Host: {$temp['host']}",
		 "Referer: http://{$temp['host']}/",
                 "Connection: keep-alive",
                 "Pragma: no-cache",
                 "X-Content-Type-Options: nosniff",
		 "Content-Type: application/json; charset=utf-8",
		 'Accept: application/json,application/xml,text/xml,text/javascript,*/*;q=0.01',
		 'Accept-Encoding: gzip, deflate, br',
		 'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',	
		 'X-Requested-With: XMLHttpRequest',
		 'User-Agent: '.$this->useragent,
                 'CLIENT-IP: '.$ip,'X-FORWARDED-FOR: '.$ip,
		 );
      
	return $header;
}
       /**
     * 随机IP
     *
     * @return str
     */
      public function rand_ip()
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
    
    
    /**
     * 发送请求
     *
     * @return array|false
     */
    public function request()
    {
        if(!is_array($this->requests) or count($this->requests) == 0){
            return false;
        }

        $curl   = $response = [];
        $handle = curl_multi_init();
        foreach($this->requests as $k => $v){
          if(is_array($v)){
            $url      = isset($v['url']) ? $v['url'] : '';
            $postData = isset($v['postData']) ? $v['postData'] : [];
            $header   = isset($v['header']) ? $v['header'] : $this->FormatHeader($url);
            $timeOut  = isset($v['timeOut']) ? $v['timeOut'] : 10;
            $proxy    = isset($v['proxy']) ? $v['proxy'] : '';
            $curl[$k] = $this->buildCurlObject($url, $postData, $header, $timeOut, $proxy);
          }else{
            $curl[$k] = $this->buildCurlObject($v, null, $this->FormatHeader($v), 10,null);
            }
            
            curl_multi_add_handle($handle, $curl[$k]);
        }

        $this->execHandle($handle);
        
        //获取内容
     
        foreach ($this->requests as $key => $val){
            
            $response[$key] =  curl_multi_getcontent($curl[$key]);

            curl_multi_remove_handle($handle, $curl[$key]);
            curl_close($curl[$key]);
        }

        curl_multi_close($handle);

        return $response;
    }

    /**
     * 构造请求
     *
     * @param $url
     * @param $postData
     * @param $header
     * @param $timeOut
     * @param $proxy
     * @return false|resource
     */
    private function buildCurlObject($url, $postData, $header, $timeOut, $proxy) {

        $curl = curl_init($url);
        $options = array(  
        CURLOPT_NOBODY=>false ,     //设定是否输出页面内容
        CURLOPT_RETURNTRANSFER=>true,  //返回字符串，而非直接输出到屏幕上
        CURLOPT_RETURNTRANSFER => TRUE,   //请求信息以文件流方式返回
        CURLOPT_AUTOREFERER=>true,    //当Location:重定向时，自动设置header中的Referer:信息
        CURLOPT_ENCODING => "", //HTTP请求头中"Accept-Encoding"的值，为空发送所有支持的编码类型,解决网页乱码问题
        CURLOPT_HEADER => FALSE, //设置为true,请求返回的文件流中就会包含response header
    	CURLOPT_POST => FALSE,   //默认选择GET的方式发送
        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,          //设置ip地址模式
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,   //设置http版本 HTTP1.1是主流的http版本
        CURLOPT_FOLLOWLOCATION => true,                //跟踪重定向页面   
        CURLOPT_MAXREDIRS => 5  ,                      //最大重定向跟踪次数
        CURLOPT_TIMEOUT =>(int)$timeOut,   //设置curl执行最大时间
        CURLOPT_USERAGENT => $this->useragent,  //伪装浏览器
        CURLOPT_CONNECTTIMEOUT => (int)$timeOut,  //连接超时时间 默认为10s
        CURLOPT_HTTPHEADER=> $header
	
        );
        
        curl_setopt_array($curl, $options);
         

        // 配置代理
        if (!empty($proxy))
            curl_setopt($curl, CURLOPT_PROXY, $proxy);

        // 合并请求头部信息
        if(!empty($header))
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        // 是否是post请求
        if(!empty($postData) && is_array($postData)){
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS,  http_build_query($postData));
        }

        // 是否是https
        if(stripos($url,'https') === 0){
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   //不开启HTTPS请求
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);    //检查证书
        }
        return $curl;
    }

    /**
     * 执行批处理句柄
     *
     * @param $mh
     * @return void
     */

     private function execHandle($mh){
 
        if(empty($mh)) {return false;}
        $active=null;
        do {
         $status=curl_multi_exec($mh, $active);
       if ($active) {
         // Wait a short time for more activity
          curl_multi_select($mh);
       }
     } while ($active && $status == CURLM_OK);
        
    
    }
    
}