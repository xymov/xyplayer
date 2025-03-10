<?php

//定义网站根目录
!defined('APP_PATH') AND define('APP_PATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')), '/') . '/');

//加载核心类
require_once APP_PATH . "include/class.main.php";
require_once APP_PATH . 'include/HttpMulti.php';  //加载多线程类

//加载云配置文件
require_once APP_PATH . 'save/config.php';
require_once APP_PATH . 'save/yun.config.php';
require_once APP_PATH . 'save/yun.match.php';
require_once APP_PATH . 'save/yun.data.php';

//定义常量

define('PARSE_VOD', 0);

define('PARSE_URL', 1);

define('PARSE_NAME',2);

define('PARSE_SEARCH_ID',3);

define('PARSE_SEARCH_NAME',4);




  //搜索ID
$res= ResParse::parse(['flag'=>2,'id'=>222821,'part'=>1],PARSE_SEARCH_ID); 


//var_dump($res);

/*
 * 资源解析类
 * 
 * Description of ResParse
 *
 * @author nohacks.cn
 */
class ResParse {
    

    public static function parse($val, $type = PARSE_URL) {
        global $YUN_MATCH;

        switch ($type) {
            
            case 0 :   //使用本地库
                
                //return self::getvod($val, filter_var($val, FILTER_VALIDATE_URL)===false);

            case 1 : //地址播放视频				 		    
                //$val = str_replace($YUN_MATCH["url_replace"], "", urldecode($val)); //url地址过滤		
               // return self::getvideo($val);
            case 2: //标题播放视频		 
               // return self::getvideo($val, true);
            case 3 : //	搜索资源 使用ID   		
                return self::getvideobyid($val["flag"], $val["id"], $val["part"]??'1');

            case 4 :   //搜索资源 使用标题

                //return self::getnames(rawurldecode($val));

            default:
                return array('success' => 0, 'code' => 0, 'm' => 'input error!');
        }
    }
    
   
  //使用本地库
     public static function getvideobylocal($id) {
         
        global  $CONFIG;
           $videoinfo = ['success'=>0];
       
            $vid = $CONFIG['vod'][$id];
            if ($vid['data'] !== "") {
                $video = explode("#", $vid['data']);
                $videoinfo['type'] = 'video';
            } else {
                $video = explode("#", $vid['url']);
                $videoinfo['type'] = 'jx';
            }

            $info[] = array('flag' => 'vod', 'flag_name' => $vid['name'], 'site' => 0, 'part' => sizeof($video), 'video' => $video,);
            $url = explode("$", $video[0])[1];
            //输出数据			 
            $videoinfo['success'] = 1;
            $videoinfo['code'] = 200;
            $videoinfo['title'] = $vid['name'];
            $videoinfo['part'] = 1;
            $videoinfo['url'] = $url;
            $videoinfo['info'] = $info;
            return $videoinfo;
     
     }
  
     /*  修复影片数据   */
    private static function fixVideo($dd,$flagName) {
                    $video = explode("#", trim((string)$dd));
                    $vlist = explode("$", $video[0]);
                    if (sizeof($vlist) < 3) {
                        foreach ($video as &$mov) {
                            if (sizeof($vlist) == 1) {
                                $mov = "正片$" . $mov . "$" . $flagName;
                            } else{
                                $mov = $mov . "$" . $flagName;
                            }
                        }
                    }
                    
            return $video;       
                    /* 自动修复影片数据    代码结束    */
     }

     //xml转换为数组，并处理空数组
    private static  function xmlToArray($xml) {
    $array = json_decode(json_encode((array)$xml), true);
    
    // 递归处理子元素
    foreach ($array as $key => $value) {
        if (is_array($value) && empty($value)) {
           $array[$key] = '';
        } elseif (is_array($value)) {
            $array[$key] = self::xmlToArray($value);
        }
    }
    return $array;
}


     
     
    
//根据资源站序号及视频ID取视频信息
    public static function getvideobyid($flag, $id) {
        
         global $YUN_MACTH, $YUN_CONFIG, $CONFIG;
         
           $videoinfo = ['success'=>0];
           
           //处理本地库  
           if ($flag == '888') {return self::getvideobylocal($id);}
         
          $api = $CONFIG["resource"][$flag]['url'];
          $api_name = $CONFIG["resource"][$flag]['name'];
          $url = "$api?ac=videolist&ids=$id";
          
         try{
    
               $html= HttpMulti::run($url);
     
            //xml
          if(substr($html, 0,1)==='<'){
              
         // 加载XML并处理CDATA
         $xml = simplexml_load_string($html, 'SimpleXMLElement',LIBXML_NOCDATA);
         //$video=self::xmlToArray($xml);
         
         foreach($xml->children() as $child)
{
    echo $child->getName() . ": " . $child . "<br>";
}
         
         
         
         //var_dump($xml);   
        
         
         
         exit;
         
             foreach ($xml->list->video->dl->dd as $dd) {
                 
                   var_dump((array)$xml->list->video);
                 
                 
                    $flag=(string)$dd['flag'];
                    $flag_name = sizeof($xml->list) == 1 ? $api_name : $flag;
                   
                    $vod=self::fixVideo($dd,$flag_name);
                    
                      if ($YUN_CONFIG["flag_filter"] == "" || preg_match('/' . $YUN_CONFIG["flag_filter"] . "/i", $flag)) {
                        $info[] = array('flag' => $flag, 'flag_name' => $flag_name, 'part' => sizeof($vod), 'video' => $vod);
                    }
            
             }  
              
             var_dump($info);
              
              
          }
               
               
               
               
               
               
               //$v= self::parseHtml($html);
               
               
               
               
               
               
               
               //var_dump($v);
               
                 
                //$img = $v['list'][]
                //$name = (string) $xml->list->video->name ?? '';
               
               
               
               
               
          }catch(Exception $e){
                error_log($e->getMessage());
               
          }
                 
         
               return $html;
               
          
 
                 
                 
                 
          
              
          
          
         
    }
    
    
    
    //put your code here
}
