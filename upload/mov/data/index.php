<?php

/*****
 ** 360数据采集脚本 by nohacks from xyplayer.net
 *
*****/

 //定义根目录 
!defined('APP_PATH') AND define('APP_PATH', dirname(__FILE__).'/../'); // __DIR__

//数据分类
define('DATA_TYPE_BANNER','banner');define('DATA_TYPE_RANK','rank');define('DATA_TYPE_DETAIL', 'detail');define('DATA_TYPE_LIST','list');define('DATA_TYPE_SEARCH','search');
//排行分类
define('DATA_RANK_ALL',1);define('DATA_RANK_M', 2);define('DATA_RANK_TV',3);define('DATA_RANK_VA',4);define('DATA_RANK_CT',4);
//影视分类
define('DATA_CAT_M', 1);define('DATA_CAT_TV',2);define('DATA_CAT_VA',3);define('DATA_CAT_CT',4);


require_once APP_PATH.'config.php';    //加载配置文件

require_once APP_PATH.'models/Cache.php';  //加载缓存类


require_once APP_PATH.'models/Debug.php'; //加载调试类

require_once APP_PATH.'models/HttpMulti.php';  //加载多线程类



//缓存目录，这里设置为解析缓存目录

$cacheDir=dirname(__FILE__). '/../../cache';

 //全局变量,读写缓存
$cache = new Cache(array("type" => $CONFIG["cache"]["type"],"prefix"=>$CONFIG["cache"]["prefix"], "cacheDir" => $cacheDir,"ip" => $CONFIG["cache"]["ip"],"pass" => $CONFIG["cache"]["pass"], "prot" => $CONFIG["cache"]["prot"], 'cacheTime' => $CONFIG["cache"]["time"]));


// 数据源
$data_api = array(
    'banner'=>'https://api.web.360kan.com/v1/block?blockid=522', //幻灯片
    'rank'=>'https://api.web.360kan.com/v1/rank?cat=%cat&size=%size', //排行
    'detail'=>'https://api.web.360kan.com/v1/detail?cat=%cat&id=%id&start=%start&end=%end&site=%site',  //详情 site:qiyi
    'list'=>'https://api.web.360kan.com/v1/filter/list?catid=%catid&rank=%rank&cat=%cat&act=%act&area=%area&size=%size&pageno=%page', //列表  rank：ranklatest,rankhot
    'search'=>'https://api.so.360kan.com/index?force_v=1&kw=%kw&from=&pageno=%page&v_ap=1&tab=all'  //搜索
    );


//top分类,用于取首页top数据
$data_cat=array(
    '1'=>'top',  //混合
    '2'=>'m',    //电影
    '3'=>'tv',   //电视
    '4'=>'va',  //综艺
    '5'=>'ct',  //动漫
   
);
//来源分类，用于显示中文来源
$data_site=array('imgo'=>'芒果',"qiyi"=>'爱奇艺','qq'=>"腾讯",'youku'=>"优酷",'xigua'=>'西瓜','douyin'=>"抖音",'bilibili1'=>"哔哩哔哩",'leshi'=>"乐视",'sohu'=>"搜狐",'cntv'=>'央视TV','huashu'=>'华数');


//取视频列表json数据
if (!empty($_GET['random'])) {

    if (empty($_REQUEST["act"])) {
        die("参数错误");
    } else {
        
        
        
        //header('content-type:application/json;charset=utf8');
        
        $retCache= data(array("act" => $_REQUEST["act"],"id" => $_REQUEST["id"],'cat'=>$_REQUEST["cat"],'site'=>$_REQUEST["site"],'size'=>$_REQUEST["size"]??''));
        
        if($retCache===false){
               
                 echo json_encode(array('code'=>'1','msg'=>'资源获取失败，请稍后再试！'));exit; 
        }else{
                 echo json_encode($retCache);exit; 
        }
        
    }
}

 function data($data){
     global $data_cat,$data_site,$CONFIG;
     $act=$data['act']?? 'index';
     $retDate=array();
     
     
     
     //取回缓存
     if(!DEBUG){
       $retCache= setCache($data);
       if(is_array($retCache)){return $retCache;}
     }
     switch ($act) {
         //首页数据
         case 'index':
           
   
             
            
           //幻灯片数据
            $retArray=data_get_contents(DATA_TYPE_BANNER,$data); 
             
            
             
            foreach ($retArray['data']['lists'] as $list) {     
              $banner=array(
                  'title'=>$list['title'],
                  'upinfo'=>$list['upinfo'],
                  'cat'=>$list['cat'],
                  'id'=>$list['ent_id'],
                  'pic'=>$list['pic_lists'][0]['url'],
                  'keywords'=>$list['comment'],
              );
              $retDate['banner'][]=$banner;
            }
          
          
            
            
         //首页列表数据
            
            foreach ($data_cat as $key => $value) { 
                
                 $retDate[$value]=data_get_rank($key);
           
            }
        
            break;

           case 'list':   
      
                $retDate=array('list'=>array(),'filter'=>array(),'hasmore'=>0);
                $catid=$data['catid'];$cat=$data['filter']=='全部'?'':$data['filter'];
                $condition=data_get_condition($catid);
         
               //取列表数据
        
                 $parm=array('catid'=>$catid,'cat'=>$cat,'size'=>24,'rank'=>'','page'=>$data['page'],'area'=>'','act'=>'');
         
                 $retDate=data_get_list($parm);
          
                 $retDate['filter']=$condition;

                 break;
                 
         case 'search': 
             
               $parm=array('kw'=>$data['kw'],'page'=>$data['page'],'szie'=>24);
               $retDate=data_get_search($parm);
               break;
 
                 
        //播放页数据     
         case 'play':   
             
               $retDate=data_get_play($data);
             
         
               break;
        //播放列表数据   
         case 'more': 
             $retDate=data_get_playList($data);
             break;
       
         default:
             break;
     }
     
        //设置缓存
            setCache($data, $retDate);
            
                  return $retDate;
          
  
 }
 
 
 function data_get_playList($data){
     
        global $data_cat,$data_site,$data_api,$CONFIG;
          $urls=array();
          $retDate=array('code'=>'0');
          $site=$data['site']??'';
          $size=$data['size']??'';
         
          if(!$size>0){$start='';$end='';}
          
          //多线程分批取数据，360看看每次获取数量有限制，不能一次全部获取
          $to=100;
          for ($i = 0; $i<$size; $i+=$to) {
             if($i+$to>$size){ $to=$size-$i;}
             $parm=array('cat'=>$data['cat'],'id'=>$data['id'],'site'=>$data['site'],'start'=>$i+1,'end'=>$i+$to);
             $urls[] = _sprintf($data_api[DATA_TYPE_DETAIL], $parm);
          
        }
     
         $ret= HttpMulti::Run($urls);
          
  
         //数组合并
         $lists=array();
         foreach ($ret as $list) 
         {
           $retArray=json_decode($list,true);  
             
          //检查是否成功
           if(isset($retArray['msg']) && $retArray['msg']=='Success'){
              
             $d= $retArray['data'];
           
              $site=$data['site']??$d['playlink_sites'][0]; 
               
              $list=array();
             
               //单来源
                  if(isset($d['defaultepisode'])){ 
                       foreach ($d['defaultepisode'] as $value) {
                          $list[$value['period']]=$value['url'];
                       }
               //多来源
                  }elseif(isset($d['allepidetail']) && $site!='' ){
                      
                      foreach ($d['allepidetail'][$site] as $value) {
                        $list[$value['playlink_num']]=$value['url'];
                      }
                      
                  }
                  
    
                if(sizeof($list)){
                    
                       $lists+=$list;
           
                }
    
          }
 
         }

                   $retDate['code']=0;
                   $retDate['msg']='Success';
                   $retDate['site']=$site;
                   $retDate['size']= $size;
                   $retDate['data']=array('list'=>$lists);
                   
                   return $retDate;
     
 }
 
 
 
   /*
  取播放页数据
  @参数：类别
  *   */
 function data_get_play($data,$ismore=false)
{
          global $data_cat,$data_site,$CONFIG;
          $retDate=array('success'=>'0');
          $site= $ismore?$data['site']:'';
          $start=$ismore?$data['start']:'';
          $end=$ismore?$data['end']:'';
          if(!$end>0){$start='';$end='';}
          
          $parm=array('cat'=>$data['cat'],'id'=>$data['id'],'site'=>$site,'start'=>$start,'end'=>$end);
  
          $retArray=data_get_contents(DATA_TYPE_DETAIL,$parm); 
          
          //检查是否成功
          if(isset($retArray['msg']) && $retArray['msg']=='Success'){
              
           $d= $retArray['data'];
         
           //取播放列表
            if($ismore){
                    
            
              $site=$data['site']??$d['playlink_sites'][0]; $retDate['site']=$site;
               
              $list=array();
             
               //单来源
                  if(isset($d['defaultepisode'])){ 
                       foreach ($d['defaultepisode'] as $value) {
                          $list[$value['period']]=$value['url'];
                       }
               //多来源
                  }elseif(isset($d['allepidetail']) && $site!='' ){
                      
                      foreach ($d['allepidetail'][$site] as $value) {
                        $list[$value['playlink_num']]=$value['url'];
                      }
                      
                  }
    
                if(sizeof($list)){
                    
                   $retDate['code']=0;
                   $retDate['success']=1;
                   $retDate['data']=array('list'=>$list);
         
                }else{
  
                      return false;
                }
                
  
           //取播放页数据  
                
             }else{
             
              /*    item      */
               $item=array(
                 ''.implode(' ',$d['area']??array()).' '.implode(' ',$d['moviecategory']??array()),
                 '导演:'.implode(' ',$d['director']??array()),
                 '演员:'.implode(' ',$d['actor']??array()),
                 
             );   

               
            //猜你喜欢数据
             
            $parm=array('catid'=>$data['cat'],'cat'=>'','size'=>6,'rank'=>'','page'=>1,'area'=>'','act'=>$d['actor'][0]);
            $guess=data_get_list($parm)['list']??array();
     
              /*    from      */     
              $from_filtr= $CONFIG['js_config']['from_filtr']; 
              $from=array();$hasmore=0;
                   
             //剧集
             if(isset($d['playlinks']))
              {
                  $hasmore=1;
        
                  foreach ($d['playlinks'] as $key => $url) {
                      $from_name=$data_site[$key]??$key;
                      if(stripos($from_filtr, $from_name)===false){
                       $k=array($url,$key,$from_name);
                       $from[]=$k;
                     }
                   }
             //单集    
             }elseif(isset($d['playlinksdetail'])){
                 $hasmore=0;
                 foreach ($d['playlinksdetail'] as $key => $arr) 
                 {
                     $from_name=$data_site[$key]??$key;
                     if(stripos($from_filtr, $from_name)===false){
                        $k=array($arr['default_url'],$key,$from_name);
                        $from[]=$k;
                      }
                  }
             } 
              
              //播放数据输出   
             $retDate=array(
                 'title'=>$d['title']??'',
                 'desc'=>$d['description']??'',
                 'id'=>$d['ent_id']??'',
                 'from'=>$from,
                 'item'=>$item,
                 'guess'=>$guess,
                 'pic'=>$d['cdncover']??'',
                 'sites'=>$d['playlink_sites'], 
                 'total'=>$d['total']??'',    //剧集集数
                 'allupinfo'=>$d['allupinfo']??array(),    //剧集更新集数
                 'hasmore'=>$hasmore);
                 
       
               }  
             // echo "upinfo:".;
              
     }else{
         
              return false;
         
     }
                
                  return $retDate; 
              
 }
                 
   
  /*
  取排行数据
  @参数：类别
  *   */
 function data_get_rank($cat)
{
     $retDate=array();
     $retArray=data_get_contents(DATA_TYPE_RANK,array('cat'=>$cat,'size'=>'24'));
     
  
 
     
     //var_dump($retArray);
     if(isset($retArray['data'])&& sizeof($retArray['data'])>0){
     
             foreach ($retArray['data'] as $list) {
              $dlist=array(
                  'title'=>$list['title'],
                  'upinfo'=>$list['upinfo'],
                  'cat'=>$list['cat'],
                  'id'=>$list['ent_id'],
                  'pic'=>$list['cover'],
                  'hint'=>$list['pv'],
                  'doubanscore'=>$list['doubanscore'],   //豆瓣评分
                  'pubdate'>$list['pubdate'],           //更新日期
                  'desc'=>$list['description'],      //影片简介      
              );
              
              $retDate[]=$dlist;
             
            }
            
              return $retDate;
     }else{
         
            return $retArray;
     }
          
}
 
  /*
  取分类数据
  @参数：类别
  *   */

 function  data_get_condition($type){
     
     switch ($type) {

         case DATA_CAT_TV:
                $condition=array_chunk(array(
                         '全部','言情','剧情','伦理','喜剧','悬疑','都市','偶像','古装','军事','谍战',
                         '青春','家庭','动作','情景','武侠','科幻','其他',
             
                ),8);

                 break;
             
         case DATA_CAT_M:
             
                 $condition=array_chunk(array(
                        '全部','喜剧','爱情','动作','恐怖','科幻','剧情','犯罪','奇幻','战争','悬疑',
                        '动画','文艺','纪录','传记','歌舞','古装','历史','惊悚','伦理','其他'
             
                       ),8);
                   
                   break;

         case  DATA_CAT_CT  :
               $condition=array_chunk(array(
                      '全部','热血','科幻','美少女','魔幻','经典','励志','少儿','冒险','搞笑','推理','恋爱','治愈','幻想','校园',
                        '动物','机战','亲子','儿歌','运动','悬疑','怪物','战争','益智','青春','童话','竞技','动作','社会',
                        '友情','真人版','电影版','OVA版','TV版','新番','动画','完结动画'
             
                      ),8);
                   
            
             break;

          case  DATA_CAT_VA  :
         
                  $condition=array_chunk(array(
                        '全部','脱口秀','真人秀','搞笑','选秀','八卦','访谈','情感','生活','晚会','音乐',
                        '职场','美食','时尚','游戏','少儿','体育','纪实','科教','曲艺','歌舞','财经','汽车','播报','其他'
             
                   ),8);
                   
                    break;
         default:
             break;
     }
     
     return $condition;
     
 }

 function data_get_list($data)
{
     // https://api.web.360kan.com/v1/filter/list?catid=1&pageno=1
     $retDate=array('success'=>0,'list'=>array());
     $retArray=data_get_contents(DATA_TYPE_LIST,$data);
     
    // var_dump($data,$retArray);
     
     if(isset($retArray['errno']) && $retArray['errno']==0){
             foreach ($retArray['data']['movies'] as $list) {
                 
                 $score=$list['score']??$list['doubanscore']??$list['upinfo']??$list['pubdate']??'';
     
              $dlist=array(
                  'title'=>$list['title'],
                  'id'=>$list['id'],
                  'pic'=>$list['cdncover']??$list['cdncover'],
                  'hint'=>$list['pv']??'',
                  'desc'=>$list['description']??'暂无简介',
                  'update'=>$list['pubdate']??'',
                  'upinfo'=>$list['upinfo']??'',
                  'tag'=>$list['tag']??'',        //综艺特有标签
                  'total'=>$list['total']??'',    //电视剧/动漫特有标签
                  'score'=>$score, // 电影评分
                  'comment'=>$list['comment']??''
                 
              );
  
              $retDate['list'][]=$dlist;
             
            }
            
            if(isset($retArray['data']['total'])){
             $len=$retArray['data']['total'];
             $page=$retArray['data']['current_page'];
             $size=$data['size'];
             $retDate['hasmore']=$len/$size-$page;
            }else{
                 $retDate['hasmore']=0;
            }
              $retDate['success']=1;
              return $retDate;
    }else{
          
              return false;
    }
      
}

 /*
  取搜索数据
  @参数：参数数组
  *   */
 function data_get_search($data)
{
    //exp: https://api.so.360kan.com/index?force_v=1&kw=电影&pageno=1
     
        $retDate=array('success'=>0,'list'=>array());
       $retArray=data_get_contents(DATA_TYPE_SEARCH,$data);
  
      
     if(isset($retArray['code']) && $retArray['code']==0 ){
  
         if(isset($retArray['data']['longData']) && isset($retArray['data']['longData']['rows'])){

             $rows=$retArray['data']['longData']['rows'];
             
         }elseif(isset($retArray['data']['video']) && isset($retArray['data']['video'][$retArray['data']['currentTab']])){
             
              $currentTab=$retArray['data']['currentTab'];
              $rows=$retArray['data']['video'][$currentTab];
         
         }else{
             
              return false;
         }
  
         foreach ( $rows as $list) {
              $dlist=array(
                  'title'=>$list['titleTxt'],
                  'id'=>$list['en_id']??getUrlid($list['url']),
                  'pic'=>$list['cover'],
                  'score'=>$list['score']??'',
                  'desc'=>$list['description']??'暂无简介',
                  'year'=>$list['year']??'',
                  'type'=>$list['cat_name']??'',
                  'upinfo'=>$list['coverInfo']['txt']??'',
                  'cat'=>$list['cat_id']??'',
                  'comment'=>$list['comment']??'',
                  'tag'=>$list['tag']??'',
              );
      
              $retDate['list'][]=$dlist;
             
            }
            if(isset($retArray['data']['page'])){ 
                $retDate['hasmore']=$retArray['data']['page']['total'];
            }else{
               $retDate['hasmore']=0; 
            }
              $retDate['success']=1;
             
              
              return $retDate;
          
             
        
    }
     
}

function data_get_contents($type,$data)
{
     global $data_api;

     $url = _sprintf($data_api[$type], $data);
    // echo $url."<br />";
 
     $arrContextOptions=array(
         "ssl"=>array(
          "verify_peer"=>false,
          "verify_peer_name"=>false,
          "allow_self_signed"=>true,
       ),
      );
    $json = file_get_contents($url, false, stream_context_create($arrContextOptions));
    return json_decode($json,true);  
}
/*
 * @ 用数组替换标记文本，普通数组按顺序替换，关联数组按参数mark值+键名进行替换。
 * @ 普通数组： _sprintf("http://jx.cn?site=%s&type=%s",['qq.com'，'qq'],'%s');
 * @ 关联数组：_sprintf("http://jx.cn?site=%site&type=%type",['site'=>'qq.com'，'type'=>'qq']);
*/
function _sprintf($text,$subarr,$mark='%'){
    foreach ($subarr as $key =>$substr) { 
        $k=strlen($mark)>1?$mark:'%'.$key;
       $start=strpos($text, $k);
    if($start!==false){
       $text=substr_replace($text, $substr, $start,strlen($k)); 
     }   
    }
    return $text;
}


function setCache($array,$data=false){
    global $cache; $word='';
    foreach ($array as $key => $value) {$word.= $key.'='.$value.'&';}
    if($data===false){
      $ret=$cache->get($word);
      if($ret){
          return json_decode($cache->get($word),true); 
      }
      return false;
    }elseif(is_array($data)){
            $cache->set($word, json_encode($data));
    }
 
}

   function getUrlid($url){
       
       //"url": "http://www.360kan.com/m/hKPiZRH4QHP7Tx.html",
       return substr($url, strripos($url, '/')+ 1,14); 
   } 
 

  
