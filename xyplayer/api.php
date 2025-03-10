<?php

/* ########################################################
  # xypaly 智能视频解析整合接口 X by nohacks.cn
  # 官方网站: http://nohacks.cn
  # 源码获取：http://www.xymov.net
  # 模块功能：程序核心，jsonp服务端
  # 更新时间：2021.06.03
  ######################################################### */
//不显示读取错误
//ini_set("error_reporting", "E_ALL & ~E_NOTICE");
//
//运行目录
!defined('APP_PATH') AND define('APP_PATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/')), '/') . '/');

//加载核心类
 require  APP_PATH.'/include/class.main.php';
 
//加载配置文件
require_once APP_PATH . '/save/config.php';


define("ROOT_PATH", $CONFIG["ROOT_PATH"]? $CONFIG["ROOT_PATH"] : GlobalBase::is_root());

define("VIDEO_M3U8", ROOT_PATH."video/m3u8.php?url=");



/*
//输出json格式文件
header('content-type:application/json;charset=utf8'); //header("Content-Disposition:attachment;filename='json.js'");

$filters = array(
     "cb" => FILTER_SANITIZE_STRING,
     "tp" => FILTER_SANITIZE_STRING,
     "url" => FILTER_SANITIZE_URL,
     "wd"=>FILTER_SANITIZE_STRING,
     "line"=>FILTER_SANITIZE_NUMBER_INT,
     "id"=>FILTER_SANITIZE_NUMBER_INT,
     "flag" => FILTER_SANITIZE_NUMBER_INT,	
     "app" => FILTER_UNSAFE_RAW,
     "dd"=>FILTER_SANITIZE_NUMBER_INT,
     'loadjs'=>FILTER_SANITIZE_NUMBER_INT,
     'out' => FILTER_SANITIZE_STRING,
);
//过滤输入参数并赋值,支持POST和GET
 $GET=filter_input_array(INPUT_GET, $filters); foreach ($GET as $key=>$val){if(trim($val)!="")$$key=trim($val);}
 $POST=filter_input_array(INPUT_POST, $filters); foreach ($POST as $key=>$val){if(trim($val)!="");$$key=trim($val);}
*/

/**/

//循环取传入参数，支持POST和GET
foreach ($_REQUEST as $k => $v) { $$k = trim($v);}



//参数初始化
$cb = isset($cb) && $cb ? $cb : '';
$tp = isset($tp) && $tp ? $tp : '';
$url = isset($url) && $url ? $url : '';
$wd = isset($wd) && $wd ? $wd: '';
$part = isset($part) &&$part ? $part: '';
$line = isset($line) && $line ? $line : '0';
$id = isset($id) ? $id : '';
$flag = isset($flag) ? $flag : '';
//$part= isset($part) ? $part : 0;
$app = isset($app) ? $app : 'xysoft';
$dd = isset($dd) && $dd ? $dd : 0;
$loadjs = isset($loadjs) ? $loadjs : 0;
$out = isset($out) ? $out : 'json';




 //全局变量,读写缓存
 $cache = new Cache(array("type" => $CONFIG["cache"]["type"],"prefix"=>$CONFIG["cache"]["prefix"], "cacheDir" => APP_PATH ."/cache","ip" => $CONFIG["cache"]["ip"], "prot" => $CONFIG["cache"]["prot"],"pass" => $CONFIG["cache"]["pass"], 'cacheTime' => $CONFIG["cache"]["time"]));
    

//加载搜索数据
if($wd!=""){
   //检测非法关键字
   if($CONFIG["socode"]["not_off"]){
      $str=base64_decode($CONFIG["socode"]["not_val"]);
     if($str!='' && preg_match("/$str/i",$wd) ){exit(json_encode(array('success' => 0,'m'=>'input error2!')));}
   }
   require_once APP_PATH ."/save/top.inc.php"; 
   require_once APP_PATH .'/include/class.db.php';
}
    
//全局变量,输出信息
$info = array('success' => 0, 'code' => 0);

//公用函数,API接口  
if ($tp == 'getnum') {
    echo sizeof($CONFIG["jx_url"]);
    exit;
}
if ($tp == 'set') {
    setcookie("url_num", $line, time() + 3600 * timecookie);
    exit;
}
if ($tp == 'getset') {
    exit(isset($_COOKIE["url_num"]) ? $_COOKIE["url_num"] : '0');
}

if($tp=="json"){
    if ($wd !== '') {
            //取缓存数据 	
            $word = $cache->get('json' . $wd);
            if ($word != "") {
                $info = json_decode($word);
            } else {
                include_once APP_PATH . "/video/class.yun.php";

                $info = YUN::parse(urlencode($wd), 4);

                if ($info['success']) {
                    $cache->set('json' . $wd, json_encode($info));
                } else {
                    $info['m'] = "404";
                }
            }
        } else {

            $info['m'] = " wd input error";
        }
        exit(json_encode($info));
        
}


if ($tp == $CONFIG["plus"]['app']['token'] && $CONFIG["plus"]['app']['off']==='1') {
   
    $app=$CONFIG["plus"]['app'];
    if(trim($app['update']['url'])==''){
        $app['update']['url']=GlobalBase::is_root()."plus/app/app.apk";
   
    }
      
    exit( json_encode($app));
}

  
//exit( APP_PATH."/cache");
//加载防火墙规则
Blacklist::parse($CONFIG["BLACKLIST"]);


switch ($tp) {

    //取配置参数及线路列表 
    case 'getparm' :
        require_once APP_PATH . '/save/yun.data.php';
        $info['success'] = 1;
        $info['type'] = 'getparm';
        $info['app'] = server::lsUserAgen($CONFIG["play"]['all']['AppName']);
        $CONFIG["play"]['define']['jx_link'] = $CONFIG["jx_link"];
        $CONFIG["play"]['define']['jx_url'] = $CONFIG["jx_url"];
       //$CONFIG["play"]['define']['live_url'] = $CONFIG["live_url"];
        $CONFIG["play"]['define']['parse'] = $CONFIG["parse"];
        $CONFIG["play"]['define']['live'] = $CONFIG["live"];
        
        $CONFIG["play"]['define']['jx_link'] = $CONFIG["jx_link"];
        $CONFIG["play"]['define']['url_jmp'] = $YUN_DATA["url_jmp"];
        $CONFIG["play"]['define']['timeout'] = $CONFIG["timeout"];
		$CONFIG["play"]['define']['timecookie'] = $CONFIG["timecookie"];
        $CONFIG["play"]['define']['host'] =  ROOT_PATH;
       
        
        $info['val'] = strencode(json_encode($CONFIG["play"]));
        break;

    //检测线路
    case 'lsurl' :
        if ($url !== '') {
            $info['val'] = $url;
            $code = server::lsurl($url);
            $info['code'] = $code;
            if ($code == 200 || $code == 302 || $code == 301) {
                $info['success'] = 1;
                $info['info'] = true;
            } else {
                $info['success'] = 0;
                $info['info'] = false;
            }
        } else {
            $info['m'] = "input error";
        }

        break;

    case 'local':
        
        
          if ($url !== '') {
            //取缓存数据 	
            $word = $cache->get('local' . $url);
            if ($word != "") {
                $info = json_decode($word);
            } else {
                
               //加载云库
               include_once APP_PATH . "/video/class.yun.php";
               $info=YUN::parse($url,0);
                               
                if ($info['url']) {
                    $info['success'] = 1;
                    $cache->set('local' . $url, json_encode($info));
                } else {
                    $info['m'] = "404";
                }
            }
        } else {

            $info['m'] = " url input error";
        }

    
       break; 

    case 'checkPlay':
 
           server::checkPlay();
    
      break;     
       
   
    //一次解析对接
     
    case 'link':
        if ($url !== '') {
               server::GetLinkVideo($url, $info);
        } else {

            $info['m'] = " url input error";
        }
        break;


    //云解析		
    default:

           include APP_PATH  . "/video/class.yun.php";
      
        
           server::parse(); 
    
        break;
}

server::out($cb, $info);

class server {

    //调用解析
    public static function parse() {
        global $cache, $tp, $url, $wd,$part, $id, $flag, $info,$CONFIG;

     
        //标题播放视频	
        if ($tp == 'wd'){
            
            if ($wd !== '') {
                $word = $cache->get('wd.wd' . $wd);
            
                if ($word != "") {
                    $info = json_decode($word,true);
                    $info['part']=$part;
            try {
                     $video=$info['info'][0]['video'][$part-1];
                     $info['url']= explode("$", $video)[1];
         
                } catch(Error $e){
                    /*  */  
                   $val=["name"=>$wd,"part"=>$part];
                    $info = YUN::parse($val, 2);
                   if ($info['success']) {
                        $cache->set('wd.wd' . $wd, json_encode($info));
                    } else {
                        $info['m'] = "404";
                    }
                   
                }
     
                    
                } else {
                    
               
                    
                    /*  */
                    
                    $val=["name"=>$wd,"part"=>$part];
                    
                    $info = YUN::parse($val, 2);
     
                    if ($info['success']) {
                        $cache->set('wd.wd' . $wd, json_encode($info));
                    } else {
                        $info['m'] = "404";
                    }
                    
                    
                }
            } else {

                $info['m'] = "wd input error";
            }
            return;
        }else if($tp=="link"){
              server::GetLinkVideo($url, $info);
               if( $info['success'] ==1)
                {
                     $info["type"]=self::checkType($info["url"]);
  
                  }else{
                      $info = self::yun($url);
                  }
        }

        //id搜索视频			
        if ($id != '' && $flag != '') {
            $word = $cache->get('id'.$id.'-'.$flag);
            if ($word != "") {
                $info = json_decode($word);
            } else {
                $info = YUN::parse(array('id' => $id, 'flag' => $flag), 3);
             
                if ($info['success']===true) {
                    $cache->set('id'.$id.'-'.$flag,json_encode($info));
                } 
            }
            return;

            //标题搜索视频
        } else if ($wd != '') {
        
           
 
            $word = $cache->get('wd' . $wd);
            
          
            if ($word != "") {
                $info = json_decode($word,true);
          
             if($tp==""){ self::uptop($wd);}
            
      
            } else {
 
                $info = YUN::parse(urldecode($wd), 4);
         
                 }
              
                 
                if ($info['success']) {
                    $cache->set('wd' . $wd, json_encode($info));
                    if($tp==""){ self::uptop($wd);}
                } else {
                    $info['m'] = "404";
                }
                
            
            
            

            //URL播放视频	
        } else if ($url != '') {

           $word = $cache->get('url' . $url);
     
            if (!filter_input(INPUT_GET, 'dd')&& $word != ""  ) {
                $info = json_decode($word);
        
            } else {
                   //对接设置
                   if($CONFIG['play']['off']['link']=='1'){
                       
                        server::GetLinkVideo($url, $info);
                         if(!$info['success']){
                        
                         $info = self::yun($url);
                
                     }
                  //本地数据   
                  }else if($CONFIG['play']['off']['jmp']=='1'){
                    
                     $info = YUN::getvod($url);
                     if(!$info['success']){
                        
                         $info = self::yun($url);
                
                     }
                     
              //云播
                }else{ 
                    $info = self::yun($url);
                    
      
                }
 
                if ($info['success']) {
                    $cache->set('url' . $url, json_encode($info));
                } else {
                    $info['m'] = "404";
                }
            }
        } else {
            $info['m'] = "input error";
        }
    }


    
   // 检测播放, 参数：类型 
   /* urljmp,检测url指定线路
    * flagjmp,检测来源指定线路
    * urlurl, 检测url直链打开
    * urlflag,检测来源直链打开
    * playflag，检测来源云播打开
    */
     public static function checkPlay($type=null)
     {
        global $CONFIG,$info,$flag,$url;
        $type and  $key=$CONFIG['play']['match'][$type];
        switch ($type) 
        { 
            //检测url指定线路
            case 'urljmp':  
                
            //检测来源指定线路  
            case 'flagjmp':
                $arr=explode(",",$key);
                $test='urljmp'?$url:$flag;
                foreach ($arr as  $val)
                {
                   $jmp=explode("->",$val);
                   if(stristr($url,$jmp[0])!==false)
                   {
                    $info['success'] =1;
                    $info['type']="link";
                    $info['url'] =$jmp[1].$url;
                    return true;
                    }
                }
                break;

             //检测url直链打开
            case 'urlurl':  
                
            //检测来源直链打开  
            case 'urlflag':   
               $test='urlurl'?$url:$flag;  
               if (preg_match("#$key#i",$test))
               {
                   $info['success'] =1;
                   $info['type']="link";
                   $info['url'] =$url;
                    return true;
               } 
             break;   
                

           //检测来源云播打开 
            case 'playflag':  
            
               if (preg_match("#$key#i",$flag))
               { 
                   $info['success'] =1;
                   $info['type']="video";
                   $info['url'] =$url;
                   return true;
               } 
               break;

             case 'all':   
                default:
                    
                    //规则查询
                      if(self::checkPlay("urljmp") || self::checkPlay("flagjmp") || self::checkPlay("urlurl") || self::checkPlay("urlflag") || self::checkPlay("playflag"))
                   {  
                      return ;  
                    }
                    //对接查询
                   if($CONFIG['play']['off']['link']==='1')
                   {
                      server::GetLinkVideo($url, $info);
                      if( $info['success'] ==1)
                         {
                         $info["type"]=self::checkType($info["url"]);
                         return ;  
                         }
                    }
                 //乐多查询
                 if(preg_match("#^XM#i",$url)){      
                         
                          require_once APP_PATH.'/video/class.leduo.php';
                          $info=LEDUO::parse($url); 
                          return ;
                 }
                    
                //文件类型查询    
                 $info['type']=self::checkType($url);
                 $info['success'] =1;
                 $info['url'] =$url;
                
        }
         
        
     }
     
     //检测视频文件类型
     public static function checkType($url){
         
        if(!preg_match("#^(http|ftp)#i",$url)){return "jx";}
         
        if(preg_match("{\.(ogg|mp4|webm|m3u8|flv)(#|$)}i",$url)){
                   return "video";
        }else{
             $content_type=get_headers($url, 1)["Content-Type"];
              if($content_type==="application/vnd.apple.mpegurl"){
                    return "hls"; 
              }elseif($content_type==="video/mp4"){
                    return "mp4";  
              }else{
                    return "jx";  
              }
         }
         
         
         
     }

    public static function uptop($word){
        global  $TOPDATA;
		$wd=str_ireplace(array('<','>','|','*','"','\'',' '),'',strip_tags($word)); //过滤危险字符及html和php标签
        if(isset($TOPDATA["$word"])){$TOPDATA["$wd"]++;}else{$TOPDATA["$wd"]='1';}
         $dbPath= APP_PATH.'save/top.inc.php';      
        if(file_exists($dbPath)){return Main_db::save($dbPath);}
        return false;
    }


    //检测url
    public static function lsurl($url, $timeout = 10) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_REFERER, $url);             //伪装网页来源 URL
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); //超时时间
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  //启用301重定向跟踪
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   //不显示结果
        curl_setopt($ch, CURLOPT_HEADER, 0); //包含头信息
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '0'); // 强制访问https网站
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');
        curl_exec($ch);
        $curl_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $curl_code;
    }

    


    
    //一次解析对接
    public static function GetLinkVideo($url, &$DATA) {
        global $CONFIG,$cache;
        
        //取缓存数据
        $word = $cache->get('link' . $url);
         if ($word != "") {
    
             $DATA = json_decode($word);

        }else {
        
      
        foreach ($CONFIG["LINK_URL"] as $val) {
            if ($val['off'] == 0) {
                continue;
            }
            $data = trim(self::post($url, $val));

            if ($data == '') {
                continue;
            }

            $json = json_decode($data, true);
            if (!$json) {
                continue;
            }
            if ($val["val_off"] == 1) {
                foreach ($val['val'] as $j => $x) {
                    $DATA[$x] = $json[$j];
                }   //转换
                if (!empty($val['add'])) {
                    $DATA = array_merge($val['add'], $DATA);
                }    //附加
            } else {
                $DATA = $json;
            }
            if ($DATA['url']) {
                //$DATA['url'].="#.m3u8";
                break;
            }
        }
        
              if ($DATA['url']??'') {
                    $DATA['success'] = 1;
                    
                    //有视频文件后缀的可以缓存
                    if( preg_match("[^#]*?{\.(ogg|mp4|webm|m3u8|flv)(?:#|$)}i",$DATA['url'])){
                        $cache->set('link' . $url, json_encode($DATA));
                    }
                } else {
                    $DATA['m'] = "404";
                }
       }
        
    }

    //检测浏览器UA标识
    public static function lsUserAgen($key) {
        return preg_match('/' . $key . "/i", filter_input(INPUT_SERVER, 'HTTP_USER_AGENT'));
    }

    public static function yun($url) {
       require_once APP_PATH.'/video/class.init.php';
       return  INIT::parse($url);
    }

    public static function out($jsoncallback, &$data) {
        
        global $out;
        $json = json_encode($data);
        
        if($out=="jsonp"){
              exit($jsoncallback . '(' . $json . ');');
            
        } else {
             exit( $json);
        }
    
    }

    public static function curl($url, $referer = "") {
        $params["ua"] = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36";
        $params["referer"] = $referer;
        return GlobalBase::curl($url, $params);
    }

    public static function post($url, $data) {
        global $loadjs, $cb;
        $params["ua"] = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36";
        $fields = "";
        $purl = trim($data["path"]);
        if ($data['api'] == 0) {
            $purl = self::getsrc_match($purl.$url, $data, $fields);
        }
       
         //运行前置HTML脚本
        if (!empty($data["html"]) && !$loadjs) {
            header('content-type:text/html;charset=utf8');
            $html = base64_decode($data["html"]);
            if (!empty($fields)) {
                $html = str_ireplace('$fields', $fields, $html);
                file_put_contents("./cache/cache_link.html", $html);
                //self::curl(ROOT_PATH."run.htm?time=".time());
                $info["success"] = "1";
                $info["type"] = "js";
                $info["js"] = ROOT_PATH . "cache/cache_link.html?time=" . time();
                self::out($cb, $info);
            }
        }

        //运行前置PHP脚本
        if (!empty($data["shell"])) { 
              file_put_contents(APP_PATH."/cache/cache_php.html","<?php header('Content-Type:text/html;charset=utf-8');".base64_decode($data["shell"]));
              include_once APP_PATH."/cache/cache_php.html";
        }
        //变量处理
        $fields = base64_decode($data["fields"]);
        foreach (explode(",", base64_decode($data["strtr"])) as $val) { $k = str_replace("$", "", $val);$fields = trim(str_replace($val, $$k, $fields));}
        //提交参数处理
        if ($data["type"] == "0") { $params["fields"] = $fields;} else {$purl.= "?" . $fields; }
         //附加头处理
        if (!empty($data["header"])) { $params["httpheader"] = $data["header"]; }
         //附加cookie处理
        if (!empty($data["cookie"])) {$params["cookie"] = $data["cookie"];}
        //代理处理
        if (!empty($data["proxy"])) {$params["proxy"] = $data["proxy"]; }
 
        return GlobalBase::curl($purl, $params);
    }

    public static function getsrc_match($url, $data, &$fields) {
        $header = "";
        $key = "";
        $matchs = "";
        $info = GlobalBase::curl($url, NULL, $header);
        $path = preg_match("#^((http://|https://).*?)\?#", $header['url'], $key) ? $key[1] : "";
        //解析播放页

        if (preg_match(base64_decode($data['match']), $info, $key)) {
            $api = $key[1];
            $fields = $key[2];
            if (substr($api, 0, 4) == "http") {
                return $api;
            }

            return $path . $api;

            //框架   
        } else if (preg_match_all('{<iframe.*?src="(.*?)".*?</iframe>}', $info, $matchs)) {

            //框架循环
            foreach ($matchs[1] as $val) {
                if (substr($val, 0, 4) != "http") {
                    $val = $path . $val;
                }

                exit($val);
                return self::getsrc_match($val, $data,$fields);
            }
        } else {
            return false;
        }
    }

}
