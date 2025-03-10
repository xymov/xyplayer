<?php 
/*##################################################
# xypaly 智能视频解析 X3  by nohacks.cn
# 官方网站: http://nohacks.cn
# 源码获取：http://www.xymov.net 
# 模块功能：m3u8本地化
###################################################*/
error_reporting(0);
require_once(dirname(__FILE__).'/'."../include/class.main.php");
require_once(dirname(__FILE__).'/'."../save/config.php");
$url=filter_input(INPUT_GET, "url");
$ts=filter_input(INPUT_GET, "ts");
if(!$url&&!$ts){exit("input error！");}
define("ROOT_PATH", $ROOT_PATH ? $ROOT_PATH:GlobalBase::is_root());
define("M3U8", ROOT_PATH."video/m3u8.php?url=");
define("TS", ROOT_PATH."video/m3u8.php?ts=");
if($ts){
    ts(urldecode($ts));
}else{
    parse(urldecode($url)); 
}
function ts($url){
   header('Access-Control-Allow-Origin:*');
   header("Content-Type: video/mp2t") ;
  $data = file_download($url);
  if($data===false){exit(trim(file_get_contents($url)));}
}

function parse($url)
{	
  $base=array();
  $name=preg_match("#/([\w]+\.m3u8)#",$url,$base)?$base[1]:"video.m3u8";
  $key=array();
  $path=preg_match("#^((http://|https://).*)/#i",$url,$key)?$key[1]:"";
  header('Access-Control-Allow-Origin:*');
  header('Content-type: application/vnd.apple.mpegurl;');
  header('Content-Disposition: attachment; filename='.$name);	
  //获取m3u8文件数据  
  $data = curl($url)?:file_get_contents($url);if($data===false){return false;}
  $lines = preg_split('/[\r\n]+/s', $data); $m3u8=""; 

  foreach ($lines as  $key =>  $value) 
  {			 
       //判断是文件信息
	 if($value&&substr($value,0,1)!="#")
         {	

// 路径转换
             $purl=put_url($path,$value); 	                                           	 
	     $m3u8.=put_file($lines,$key).urlencode($purl)."\n";                           
	  //其他信息直接返回原信息
	  }else{
	     $m3u8.=$value."\n";			
         }    
    }
       exit(trim($m3u8));	
}
function put_file($lines,$key){  
     //取文件类型
     $i=$key; do {$i--;$front=$lines[$i];}while($front === ""&&!$i<0);   
    //路径转换
     if(strstr($front,"#EXT-X-STREAM-INF:")){ return M3U8;}else if(strstr($front,"#EXTINF:")){ return TS; }
    }

function put_url($path,$url){
	
  if(substr($url,0,4)=="http"){
	  return $url;			
   }else if(substr($url,0,1)=="/"){
	  return $path.$url;
   }else{
	 return $path."/".$url;
   }		
}

//分段下载文件
function file_download($url){   
    $user_agent = "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)";       
    $ch = curl_init();    
    curl_getinfo($ch);
    curl_setopt ($ch, CURLOPT_URL, $url);//设置要访问的地址     
    curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);//模拟用户使用的浏览器    
    curl_setopt($ch, CURLOPT_REFERER,parse_url($url)['host']); //伪装来源 URL 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1 );   // 使用自动跳转  
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);   //忽略HTTPS证书 
    curl_setopt ($ch, CURLOPT_TIMEOUT, 30);         //设置超时时间      
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUTT, 10); //连接超时时间 默认为10s 
    curl_setopt ($ch, CURLOPT_AUTOREFERER, 1 );     //自动设置Referer             
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);      
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
     //包含文件头
    curl_setopt($ch, CURLOPT_HEADER, 1); 
    //设置下载回调函数
     curl_setopt($ch, CURLOPT_WRITEFUNCTION, 'download');
  
    $result = curl_exec($ch);      
    curl_close($ch);     
    return $result;      
}

 //下载回调函数
function  download($ch, $str) {static $s = '@'; if($s){$s = trim($str); if($s) header($s);}else {echo$str;} return strlen($str);}   

function curl($url,$cookie="")
{
	$params["ua"] = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36";
	$params["cookie"] = $cookie;
  	return GlobalBase::curl($url,$params);
}

