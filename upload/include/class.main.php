<?php
/*##################################################
# xypaly 智能视频解析 X   by nohacks.cn
# 官方网站: http://nohacks.cn
# 源码获取：http://nohacks.taobao.com 
# 模块功能：公用文件
###################################################*/

// 0: 线上模式; 1: 调试模式; 
defined('DEBUG') or define('DEBUG', 0);
!defined('APP_PATH') AND define('APP_PATH', dirname(__FILE__).'/../'); // __DIR__
!defined('ADMIN_PATH') AND define('ADMIN_PATH', APP_PATH.'admin/');
//error_reporting(DEBUG ? E_ALL : E_ALL & ~E_NOTICE);
error_reporting(DEBUG ? E_ALL : 0);
  // 检测PHP环境
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
	die('PHP版本过低，最少需要PHP5.4，请升级PHP版本！');
}

//自定义异常和错误处理
  set_error_handler('_error_handler', E_ALL);  // 注册错误处理方法来处理所有错误 E_STRICT 8.4 后 已弃用
  set_exception_handler('_exception_handler');          // 注册异常处理方法来捕获异常

  
  //异常处理方法
     function _exception_handler(Throwable $e)
     {
         $err=array(
            'type'=>$e->getCode(),
            'msg'=>$e->getMessage(),
            'file'=>$e->getFile(),
            'line'=>$e->getLine()
          );
         ShowError($err,$e instanceof Error ? "Error":"Exception");

         }
    //错误处理方法
    function _error_handler($errno, $errmsg ,$errfile, $errline)
      {
      $err=array(
            'type'=>$errno,
            'msg'=>$errmsg,
            'file'=>$errfile,
            'line'=> $errline
          );
        ShowError($err,-1);
    }
    
     
   //echo $foo['bar'];  // 由于数组未定义，会产生一个notice级别的错误
    //foobar(3, 5);   //调用未定义的方法将会产生一个Error级别的错误
  //trigger_error('自定义错误', E_ERROR); //人为触发错误
    //throw new Exception('Uncaught Exception occurred');  //触发Exception异常  
    

class GlobalBase
{
    /**
     * [curl 网页数据获取]
     * @param  [type] $url    [访问 URL 地址]
     * @param  string $method [访问方式] 。 
     * @param  string $fields [要提交的数据]
     * @param  string $ckname [cookie 文件名]
     * @return [type]         [返回访问结果字符串数据]
     */
    public static function curl($url, $params = array(), &$Headers = null)
    {

        $ip = empty($params["ip"]) ? self::rand_ip() : $params["ip"];
        $header = array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip);
        if (isset($params["httpheader"])) {
            $header = array_merge($header, $params["httpheader"]);
        }
        $referer = empty($params["ref"]) ? parse_url($url)['host'] : $params["ref"];
        
        
        
        $user_agent = empty($params["ua"]) ? $_SERVER['HTTP_USER_AGENT'] : $params["ua"];

        $ch = curl_init();                                                      //初始化 curl
        curl_setopt($ch, CURLOPT_URL, $url);                                    //要访问网页 URL 地址
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                          //伪装来源 IP 地址
        curl_setopt($ch, CURLOPT_REFERER, $referer);                            //伪装网页来源 URL
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);                        //模拟用户浏览器信息
        curl_setopt($ch, CURLOPT_NOBODY, false);                                //设定是否输出页面内容
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                         //返回字符串，而非直接输出到屏幕上
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);                        //连接超时时间，设置为 0，则无限等待
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);                                //数据传输的最大允许时间超时,设为一小时
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);                       //HTTP验证方法
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                        //不检查 SSL 证书来源
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);                        //不检查 证书中 SSL 加密算法是否存在
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);                         //跟踪爬取重定向页面
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);                            //当Location:重定向时，自动设置header中的Referer:信息
        curl_setopt($ch, CURLOPT_ENCODING, '');                                 //解决网页乱码问题
        curl_setopt($ch, CURLOPT_HEADER, empty($params["header"]) ? false : true);  //是否输出 header 部分
        if (!empty($params["fields"])) {
            curl_setopt($ch, CURLOPT_POST, true);                                  //设置为 POST 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params["fields"]);                //提交数据
        }
        if (!empty($params["cookie"])) {
            curl_setopt($ch, CURLOPT_COOKIE, $params["cookie"]);                  //从字符串传参来提交cookies
        }
        if (!empty($params["proxy"])) {
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);                  //代理认证模式
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);                  //使用http代理模式
            curl_setopt($ch, CURLOPT_PROXY, $params["proxy"]);                    //代理服务器地址 host:post的格式
            if (!empty($params["proxy_userpwd"])) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $params["proxy_userpwd"]); //http代理认证帐号，username:password的格式
            }
        }
        //运行 curl，请求网页并返回结果
        $data = curl_exec($ch);
        //$Headers = curl_getinfo($ch);
        curl_close($ch);                                                        //关闭 curl
        return $data ;
    }

  
    /**
     * [rand_ip 生成随机 IP 地址]
     * @return [type] [返回 IPv4地址 字符串]
     */
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

    /**
     * [is_https 是否是安全连接访问]
     * @return boolean [description]
     */
    public static function is_https()
    {
        if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return "https://";
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return "https://";
        } elseif (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return "https://";
        } elseif (isset($_SERVER["REQUEST_SCHEME"]) && $_SERVER["REQUEST_SCHEME"] === 'https') {
            return "https://";
        }
        return "http://";
    }
    public static function is_dir()
    {
        $root = str_replace("\\", "/", filter_input(INPUT_SERVER, 'DOCUMENT_ROOT'));
        if ($root == "") {
            return "/";
        }
        $dir = str_replace("\\", "/", str_replace("include", "", dirname(__FILE__)));
        if ($dir == "") {
            return "/";
        }
        $out = str_replace($root, "", $dir);
        //前后加"/"
        if (substr($out, 0, 1) !== "/") {
            $out = "/" . $out;
        }
        if (substr($out, -1, 1) !== "/") {
            $out .= "/";
        }
        return $out;
    }
    public static function is_root()
    {
        return self::is_https() . filter_input(INPUT_SERVER, 'HTTP_HOST') . self::is_dir();
    }

    public static function is_time($time)
    {
        if (preg_match("/^(\d+)(.*?)$/i", $time, $key)) {

            if (sizeof($key) < 2) {
                return 0;
            }

            switch ($key[2]) {
                case "d":
                    return $key[1] * 24 * 60 * 60 * 1000;
                case "h":
                    return $key[1] * 60 * 60 * 1000;
                case "m":
                    return $key[1] * 60 * 1000;
                case "s":
                    return $key[1] * 1000;
                case "ms":
                    return $key[1];
                default:
                    return $key[1];
            }
        } else {
            return 0;
        }
    }


    /**
     * [getdirs 取指定目录下的子目录数组]
     * @return array [dir]
     */
    public static function getdirs($dir)
    {

        if (is_dir($dir) && is_readable($dir)) {
            $handle = opendir($dir);
            $f_dir = array();
            while (($f_name = readdir($handle)) != false) {
                if (is_dir($dir . '/' . $f_name) && $f_name != "." && $f_name != "..") {
                    $f_dir[] = $f_name;
                }
            }
            closedir($handle);
            return $f_dir;
        } else {
            return false;
        }
    }
}

/* 生成加密串  */
class Crumb {                                                                                                     
    CONST SALT = "www.xymov.net";                                                            
    static  $ttl = 7200;  
    //内用
    static public function challenge($data) {   
        return hash_hmac('md5', $data, self::SALT);   
    }                                                                                                                
   //生成随机字符串
    static public function issueCrumb($uid,$ttl=7200,$action = -1) {   
       // if(intval($ttl)>7200){self::$ttl=$ttl;}
        $i = ceil(time() / $ttl);
        return substr(self::challenge($i . $action . $uid), -12, 10);   
    }                                                                                                                
   //验证
    static public function verifyCrumb($uid, $crumb,$ttl=7200,$action = -1) {   
        $i = ceil(time() / $ttl);   
        return (substr(self::challenge($i . $action . $uid), -12, 10) == $crumb || substr(self::challenge(($i - 1) . $action . $uid), -12, 10) == $crumb); 
    }                                                                                                                
} 


class AntiTX {
/*
反腾讯网址安全检测系统
Description:屏蔽腾讯电脑管家网址安全检测
Version:2.8
call: AntiTX::on()
*/
//IP屏蔽

public static function on(){

$iptables='977012992~977013247|977084416~977084927|1743654912~1743655935|1949957632~1949958143|2006126336~2006127359|2111446272~2111446527|3418570752~3418578943|3419242496~3419250687|3419250688~3419275263|3682941952~3682942207|3682942464~3682942719|3682986660~3682986663|1707474944~1707606015|1709318400~1709318655|1884967642|1884967620|1893733510|1709332858|1709325774|1709342057|1709341968|1709330358|1709335492|1709327575|1709327041|1709327557|1709327573|1975065457|1902908741|1902908705|3029946827';
$remoteiplong=bindec(decbin(ip2long(self::real_ip())));
foreach(explode('|',$iptables) as $iprows){
	if($remoteiplong==$iprows)exit('404 not found！');
	$ipbanrange=explode('~',$iprows);
	if($remoteiplong>=$ipbanrange[0] && $remoteiplong<=$ipbanrange[1])
		exit('404 not');
}
//HEADER特征屏蔽
if(preg_match("/manager/", strtolower($_SERVER['HTTP_USER_AGENT'])) || strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla')===false && strpos($_SERVER['HTTP_USER_AGENT'], 'ozilla')!==false || isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'urls.tr.com')!==false || isset($_COOKIE['ASPSESSIONIDQASBQDRC']) || empty($_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_USER_AGENT'], 'HUAWEI G700-U00')!==false && !isset($_SERVER['HTTP_ACCEPT']) || preg_match("/Alibaba.Security.Heimdall/", $_SERVER['HTTP_USER_AGENT'])) {
	exit('404 not found！');
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS 9_3_4')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS 8_4')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'Android 6.0.1')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'MQQBrowser/6.8')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'en')!==false && strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'zh')===false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'en-')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'zh')===false) {
	exit('404 not found。');
}
if(preg_match("/Windows NT 6.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*'|| preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*' || preg_match("/vnd.wap.wml/", $_SERVER['HTTP_ACCEPT']) && preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT'])){
	exit('404 not found。');
}
}

public static function real_ip(){
	
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

}


/** 
 * js escape php 实现 
 * @param $string           the sting want to be escaped 
 * @param $in_encoding       
 * @param $out_encoding      
 */
function escape($string, $in_encoding = 'UTF-8', $out_encoding = 'UCS-2')
{
    $return = '';
    if (function_exists('mb_get_info')) {
        for ($x = 0; $x < mb_strlen($string, $in_encoding); $x++) {
            $str = mb_substr($string, $x, 1, $in_encoding);
            if (strlen($str) > 1) { // 多字节字符 
                $return .= '%u' . strtoupper(bin2hex(mb_convert_encoding($str, $out_encoding, $in_encoding)));
            } else {
                $return .= '%' . strtoupper(bin2hex($str));
            }
        }
    }
    return $return;
}

//文本加密函数
function strencode($string, $key = 'xyplay')
{
    $string = base64_encode($string);
    $len = strlen($key);
    $code = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $k = $i % $len;
        $code .= $string[$i] ^ $key[$k];
    }
    return base64_encode($code);
}

function lsUserAgen($key)
{
    return preg_match('/' . $key . "/i", @$_SERVER['HTTP_USER_AGENT']);
}

function lsReferer($key)
{
    return preg_match('/' . $key . "/i", parse_url(@$_SERVER['HTTP_REFERER'], PHP_URL_HOST));
}

//广告过滤类

class AdBlack
{
    static $path = "";

    public static function parse($list, $path)
    {

        $url = filter_input(INPUT_GET, $list["name"]);
        if (empty($url)) {
            return "";
        }
        $key =array();
        $path = preg_match("#^((http://|https://).*?)/#i", $url, $key) ? $key[1] : $url;
        self::$path = $path;


        $match = $list["match"];
        if (!sizeof($match) > 0) {
            return self::curl($url);
        }

        //规则按优先级降序排列  
        foreach ($match as $key => $row) {
            $num[$key] = $row['num'];
        }
        array_multisort($num, SORT_DESC, $match);


        foreach ($match as $m) {
            if ($m["off"] == "1" && preg_match("{" . Base64_decode($m["target"]) . "}", $url)) {

                $word = self::curl($url, $url);                                //原始内容
                $word = self::black_replace($word, $m["val"]);                //主体替换
                $word = self::frame_replace($word, $list["name"]);           //框架替换
                break;
            }
        }

        //file_put_contents("noad.html",$word);

        return  $word;
    }

    public static function black_replace($word, $match)
    {
        //规则替换
        foreach ($match as $key => $val) {
            $word = preg_replace("{" . $key . "}i", $val, $word);
        }

        //智能转换POST资源路径
        $word = preg_replace_callback(
            '{(\$\.post\()"(.*?)"}i',
            function ($matches) {
                return $matches[1] . '"'.self::put_url($matches[2]) . '"';
            },
            $word
        );

        //智能转换HTML资源路径
        $type = array("action", "src", "href");
        foreach ($type as $val) {
            $word = preg_replace_callback(
                "{($val)=" . '"(.*?)"}i',
                function ($matches) {
                    return $matches[1] . '="' . self::put_url($matches[2]) . '"';
                },
                $word
            );
        }


        //file_put_contents("noad.htm",$word);

        return $word;
    }

    public static function frame_replace($word, $jx)
    {
        if (preg_match_all('{<iframe.*?src="(.*?)".*?</iframe>}i', $word, $matchs)) {
            foreach ($matchs[1] as $val) {
                $word = preg_replace('{' . $val . '}', '/?jx=' . self::put_url($val), $word);
            }
        }
        return $word;
    }



    public static  function put_url($url, $path = "")
    {
        if (empty($path)) {
            $path = self::$path;
        }
        if (substr($url, 0, 4) == "http" || substr($url, 0, 2) == "//") {
            return $url;
        } else if (substr($url, 0, 1) == "/") {
            return $path . $url;
        } else {
            return $path . "/" . $url;
        }
    }

    public static function curl($url, $ref = '')
    {
        $params["ua"] = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36";
        $params['ref'] = $ref;
        return GlobalBase::curl($url, $params);
    }
}

//防火墙类
class Blacklist
{
    public static function parse($list)
    {
       
        
        if ($list['off'] == 1) {
            
           
            self::black($list);
            
        }
    }
     public static function start($match, $list, $type = '')
    {
             
        switch ($type) {
                //来源域名
            case '0':
                //取出来源域名  

                $val = filter_input(INPUT_SERVER, "HTTP_REFERER");
                if ($val) {
                    $val = parse_url($val, PHP_URL_HOST);
                }
                //取出解析域名
                $host = filter_input(INPUT_SERVER, "SERVER_NAME");

                //替换变量
                $match['val']=str_replace('$host',$host,$match['val']);

               
                
               //排除解析域名
                if ($host !== $val) {
                 
                    if (in_array($val, $match['val']) == $match['match']) {
                        
                        //self::start($match, $list);
                        return true;
                        
                    }
                }
                
                return false;
                break;
                //目标域名
            case '1':
               $val =filter_input(INPUT_SERVER, "QUERY_STRING"); if(!$val){$val='';}       //取出目标域名	
                if (preg_match('{' . implode("|", $match['val']) . "}i", $val) == $match['match']) {
                    return true;
                    //self::start($match, $list);
                }
                 return false;
                break;
                //浏览器标识
            case '2':
                $val =filter_input(INPUT_SERVER, "HTTP_USER_AGENT"); if(!$val){$val='';}       //取出浏览器标识			
                if (preg_match('{' . implode("|", $match['val']) . "}i", $val) == $match['match']) {
                    return true;
                    //self::start($match, $list);
                }
                 return false;
                break;
                //客户IP
            case '3':
                
                $val =self::get_real_ip(); if(!$val){$val='';}   //取出IP
                if ($val!="127.0.0.1"&&preg_match('{' . implode("|", $match['val']) . "}i", $val) == $match['match']) {
                   return true;
                  //  self::start($match, $list);
                }
                return false;
                break;
                 //来源参数
            case '4':   
                $ref=!$match['match'];
                foreach ($match['val']as $val) {
                   $arr= explode(":", $val);
                   if(sizeof($arr)>=2){
                      //取出来源对应值
                     $v =filter_input(INPUT_GET,$arr[0])?:filter_input(INPUT_POST,$arr[0]); 
                     if($v){
                         $ref=(trim($v)==trim($arr[1]))==$match['match'];
                      }
                   }
                }
              
                 return $ref;
                  //self::start($match, $list);
    
                break;
  
            default:
                
                
                
                //取出脚本
                $js = base64_decode($list['black'][$match['black']]['info']);
                
                //取出脚本类型
                $type = $list['black'][$match['black']]['type'];
                //取出脚本动作
                $action = $list['black'][$match['black']]['action'];
                if ($type == '0') {
                    if ($action =='0') {
                        session_start();
                        $_SESSION['FOOTER_CODE'] = $js;
                    } else {
                        exit($js);
                    }
                } else {
                     $dir=APP_PATH."/cache/";if(!is_dir($dir)){$dir=APP_PATH."/../cache/"; }
                     file_put_contents($dir."cache_php.html","<?php header('Content-Type:text/html;charset=utf-8');".$js);
                     include_once $dir."cache_php.html";
                    if ($action == '1') {
                          exit;
                    }
                }
                break;
        }
    }

    
    public static function get_real_ip()
{
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
    
    
    public static function black($list)
    {
        $match = $list['match'];

        //规则按优先级升序排列     
        foreach ($match as $key => $row) {$num[$key] = $row['num'];}
        array_multisort($num, SORT_ASC, $match);

        foreach ($match as $key=>$val) {
            if ($val['off'] == 1 && preg_match("{" . $val['for'] . "}i", $_SERVER['PHP_SELF'])) {
               //检测到被拦截
                $ret=self::start($val, $list, $val['type']);
      
                if($ret){$k=$key;}else{return;}
            }
        }
        if($ret??false){self::start($match[$k], $list);}
    }
}


//检测字符串组的字符在字符串中是否存在,对大小写不敏感
function findstrs($str, $find, $strcmp = false, $separator = "|")
{
    $ymarr = explode($separator, $find);
    foreach ($ymarr as  $find) {

        if ($strcmp) {
            if (strcasecmp($str, $find) == 0) {
                return true;
            }
        } else {
            if (stripos($str, $find) !== false) {
                return true;
            }
        }
    }
    return false;
}



//获取远程内容
function geturl($url, $timeout = 10)
{
    $user_agent = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36";
    $curl = curl_init();                                        //初始化 curl
    curl_setopt($curl, CURLOPT_URL, $url);                      //要访问网页 URL 地址
    curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);           //模拟用户浏览器信息 
    curl_setopt($curl, CURLOPT_REFERER, $url);               //伪装网页来源 URL
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);                //当Location:重定向时，自动设置header中的Referer:信息                   
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);             //数据传输的最大允许时间 
    curl_setopt($curl, CURLOPT_HEADER, 0);                     //不返回 header 部分
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);            //返回字符串，而非直接输出到屏幕上
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);             //跟踪爬取重定向页面
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '0');        //不检查 SSL 证书来源
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, '0');        //不检查 证书中 SSL 加密算法是否存在
    curl_setopt($curl, CURLOPT_ENCODING, '');              //解决网页乱码问题
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
function lsMobile()
{
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    return false;
}

//编码转换，转换为utf-8编码
function utf8($title)
{
    $encode = mb_detect_encoding($title, array('GB2312', 'GBK', 'UTF-8', 'CP936')); //得到字符串编码
    if ($encode != 'CP936' && $encode != 'UTF-8') {
        $title = iconv($encode, 'UTF-8', $title);
    }
    return $title;
}


//缓存操作类 	
class Cache
{
    private $type = 1;             //默认缓存类型,1为文件，2为Redis服务
    private $prot = 6379;          //缓存服务端口，默认为Redis服务端口
    private $ip = "127.0.0.1";     //缓存服务器ip,默认为127.0.0.1
    private $pass = "";            //缓存服务器密码,默认为空
    private $cacheTime = 3600;        //默认缓存时间,可用单位 d|h|m|s，默认单位：秒(s)
    private $cacheDir = './cache';    //缓存绝对路径   
    private $md5 = true;              //是否对键和内容进行加密   
    private $suffix = "";         //设置文件后缀    
    private $prefix = "";           //设置缓存前缀
 
    private $cache;
    public function __construct($config)
    {

        if ($this->type == 0) {
            return;
        }

        if (is_array($config)) {
            foreach ($config as $key => $val) {
                $this->$key = $val;
            }
        }

        if ($this->type == 2) {
           if (class_exists('Redis')){
            $this->cache = new Redis();
            $this->cache->connect($this->ip , $this->prot);
            if($this->pass!=""){$this->cache->auth($this->pass);} //设置密码
            }else{
                $this->type = 1;
            }
        }
        //时间转换
         $this->cacheTime=$this->_time($this->cacheTime);
         
         //清理过期缓存
        $this->clear();
  
    }
    //设置缓存   
    public function set($key, $val, $leftTime = NULL)
    {
        $key=$this->prefix.$key;
        if ($this->type == 0) {

            return  false;
        } else if ($this->type == 1) {
            $key = $this->md5 ? md5($key) : $key;
            $val = $this->md5 ? base64_encode($val) : $val;
            if (function_exists("gzcompress")) {
                $val = @gzcompress($val);
            }
           
            !file_exists($this->cacheDir) && mkdir($this->cacheDir, 0777);
            $file = $this->cacheDir . '/' . $key . $this->suffix;
            $leftTime = empty($leftTime) ? $this->cacheTime : $leftTime;
            if ($leftTime != 0) {
            $ret = file_put_contents($file, $val) or $this->error(__line__, "文件写入失败");
            $ret = touch($file, time() + $leftTime) or $this->error(__line__, "更改文件时间失败");
             }
        } else if ($this->type == 2) {
            $key_md5 = $this->md5 ? md5($key) : $key;
            $val_base64 = $this->md5 ? base64_encode($val) : $val;
            $val_base64 = @gzcompress($val_base64);
            $ret = $this->cache->set($key_md5, $val_base64);
            if ($leftTime != 0) {
                $this->cache->EXPIRE($key_md5, $leftTime);
            }
            // $this->cache->del($val_base64); 
        }
        return   $ret;
    }

    //得到缓存   
    public function get($key)
    {
        $key=$this->prefix.$key;
        if ($this->type == 0) {
            return;
        } else if ($this->type == 1) {
            
            //$this->clear();   
            if ($this->_isset($key)) {

                $key_md5 = $this->md5 ? md5($key) : $key;
                
                 // echo $key_md5;
                
                $file = $this->cacheDir . '/' . $key_md5 . $this->suffix;
                $val = file_get_contents($file);
                  if (function_exists("gzuncompress") && $val) {
                    $val = @gzuncompress($val);
                  }
                $val = $this->md5 ? base64_decode($val) : $val;
                return $val;
            }
            return null;
        }
        if ($this->type == 2) {
            $key_md5 = $this->md5 ? md5($key) : $key;
            $val = $this->cache->get($key_md5);
            if (function_exists("gzuncompress") && $val) {
                $val = @gzuncompress($val);
            }
            $val_base64 = $this->md5 ? base64_decode($val) : $val;
            return $val_base64;
        }
    }

    //判断文件是否有效   
    public function _isset($key)
    {
        $key = $this->md5 ? md5($key) : $key;
        $file = $this->cacheDir . '/' . $key . $this->suffix;
        if (file_exists($file)) {
            if ($this->cacheTime == 0 || filemtime($file) >= time()) {
                return true;
            } else {
                @unlink($file);
                return false;
            }
        }
        return false;
    }

    //删除指定缓存  
    public function _unset($key)
    {
        $key=$this->prefix.$key;
        if ($this->type == 0) {
            return;
        } elseif ($this->type == 1) {
            if ($this->_isset($key)) {
                $key_md5 = $this->md5 ? md5($key) : $key;
                $file = $this->cacheDir . '/' . $key_md5 . $this->suffix;
                return @unlink($file);
            }
        } elseif ($this->type == 2) {
            $key_md5 = $this->md5 ? md5($key) : $key;
            return $this->cache->del($key_md5);
        }
    }
    //清除过期缓存文件   
    public function clear()
    {
        $ret=false;
        $cacheTime = $this->cacheTime;
        if($cacheTime == 0){return false;}
        $files = scandir($this->cacheDir);
        foreach ($files as $val) {
            if ($val!=".." && $val!="." &&filemtime($this->cacheDir . "/" . $val)  < time()) {
                $ret = @unlink($this->cacheDir . "/" . $val);
            }
        }
        return $ret;
    }

    //清除所有缓存文件   
    public function clear_all()
    {
        $ret = true;
        if ($this->type == 0) {
            return $ret;
        } elseif ($this->type == 1) {
            if (!is_writable($this->cacheDir)) {
                return false;
            }
            $files = scandir($this->cacheDir);
            foreach ($files as $val) {
                if($val!=='.'&&$val!=='..'){@unlink($this->cacheDir . "/" . $val);}
            }
        } elseif ($this->type == 2) {
            $ret = $this->cache->flushAll();
        }
        return $ret;
    }
    
    public static function _time($time)
    {
        if (preg_match("/^(\d+)(.*?)$/i", $time, $key)) {

            if (sizeof($key) < 2) {
                return 0;
            }

            switch ($key[2]) {
                case "d":
                    return $key[1] * 24 * 60 * 60 ;
                case "h":
                    return $key[1] * 60 * 60 ;
                case "m":
                    return $key[1] * 60 ;
                case "s":
                    return $key[1] ;
                default:
                    return $key[1];
            }
        } else {
            return 0;
        }
    }

    private function error($line, $msg)
    {

        die("出错文件：" . __file__ . "/n出错行：$line/n错误信息：$msg");
    }
}

function ShowError($e,$type='')
{
    
     is_dir(APP_PATH."log/") || mkdir(APP_PATH."log/"); 
     error_log("异常发生！错误属于：" .$e["type"].','. $e["msg"] . "，所在文件 " . $e["file"] . "，位于行 " . $e["line"] . "\r\n",3,APP_PATH."log/".date('Y-m-d').".log");
    
      $etext=($type==-1)? "错误" : "{$type}异常";
    
  if(DEBUG){
         $code=getLine($e["file"],$e["line"]); 
         $msg="<!DOCTYPE html><html><meta http-equiv='Content-Type' content='text/html; charset=utf-8'><head><title>网站提示</title></head><body>";
         $msg.="<font style='color:red;'>警告:程序发生{$etext}！</font><br>";
         $msg.= "错误编号: ".$e["type"]."<br>";
         $msg.= "错误信息: ".$e["msg"]."<br>";
         $msg.= "出错文件: ".$e["file"]."<br>";
         $msg.= "出错行号: ".$e["line"]."<br>";
         $msg.= "出错代码: <font style='color:#0000FF;'>".$code."<br></font></body></html>";
         die($msg); 
         
     }elseif($type!==-1){

         
  $msg=<<<html
     <!DOCTYPE html><html><head><title>提示信息</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <base target='_self'/><style>body{background:#f9fafd;color:#818181}.msg_jump{width:90%;max-width:624px;min-height:60px;padding:20px 50px 50px;margin:5% auto 0;font-size:14px;line-height:24px;border:1px solid #cdd5e0;border-radius:10px;background:#fff;box-sizing:border-box;text-align:center}.msg_jump .title{margin-bottom:11px}.msg_jump .text{margin-bottom:11px}.msg_jump_tit{width:100%;height:35px;margin:25px 0 10px;text-align:center;font-size:25px;color:#0099CC;letter-spacing:5px}</style></head>
    <body leftmargin='0' topmargin='0'><center><script>setTimeout("location='javascript:history.go(-1)'",3000);</script>
    <br/><div class='msg_jump'><div class='msg_jump_tit'>系统提示</div><font style='color:red;'>抱歉，网站出了点问题，请稍后再试</font><br /><br /><a href='javascript:history.go(-1)'><font style='color:#777777;'>如果你的浏览器没反应，请点击这里...</font></a><br/></div></div><br/><br/></div></div></center></body></html>
   html;
   
   die($msg); 
 
    }
      
}

function ShowMsg($msg,$gourl,$onlymsg=0,$limittime=0,$extraJs='')
{
	$htmlhead  = "<html>\r\n<head>\r\n<title>提示信息</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><meta name=\"viewport\" content=\"width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no\">\r\n";
	$htmlhead .= "<base target='_self'/>\r\n<style>body{background:#f9fafd;color:#818181}.msg_jump{width:90%;max-width:624px;min-height:60px;padding:20px 50px 50px;margin:5% auto 0;font-size:14px;line-height:24px;border:1px solid #cdd5e0;border-radius:10px;background:#fff;box-sizing:border-box;text-align:center}.msg_jump .title{margin-bottom:11px}.msg_jump .text{margin-bottom:11px}.msg_jump_tit{width:100%;height:35px;margin:25px 0 10px;text-align:center;font-size:25px;color:#0099CC;letter-spacing:5px}</style></head>\r\n<body leftmargin='0' topmargin='0'>\r\n<center>\r\n<script>\r\n";
        $htmlfoot  = "</script>\r\n$extraJs</center>\r\n</body>\r\n</html>\r\n";
        $litime=($limittime==0)?($gourl=="-1"? 3000:1000) :$limittime;
        if($gourl=="-1"){$gourl = "javascript:history.go(-1);";$msg_color="F00";}else{$msg_color="0FF";}
	if($gourl==''||$onlymsg==1)
	{
		$msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
	}else{
		$func = " var pgo=0;function JumpUrl(){ if(pgo==0){ location='$gourl'; pgo=1; } }\r\n";
		$rmsg = $func;
		$rmsg .= "document.write(\"<br /><div class='msg_jump'><div class='msg_jump_tit'>系统提示</div>";
	        $rmsg .= "<div class='text'>\");\r\n";

		$rmsg .= "document.write(\"<font style='color:$msg_color;'>".str_replace("\"","“",$msg)."</font>\");\r\n";
		$rmsg .= "document.write(\"";
		if($onlymsg==0)
		{
                        if($gourl!="javascript:;" && $gourl!=""){$rmsg .= "<br /><br /><a href='{$gourl}'><font style='color:#777777;'>如果你的浏览器没反应，请点击这里...</font></a>";}
			$rmsg .= "<br/></div></div>\");\r\n";
			if($gourl!="javascript:;" && $gourl!=''){$rmsg .= "setTimeout('JumpUrl()',$litime);";}
                }else{
                    $rmsg .= "<br/><br/></div></div>\");\r\n";
                }
		$msg  = $htmlhead.$rmsg.$htmlfoot;
	}
	echo $msg;
}

function getLine($file, $line, $length = 4096)
{
    
    
    $returnTxt = null; // 初始化返回
    $i = 1; // 行数

    $handle = fopen($file, "r");
    
    
   
    if ($handle) {
         
        while (!feof($handle)) {
            
            
            $buffer = fgets($handle, $length);
            
            
            if ($line == $i) {$returnTxt = $buffer;break;}
        
            $i++;
        }
     
        
        fclose($handle);
        
         
    }
    
  
    return $returnTxt;
}




