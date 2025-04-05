<?php
include "config.php";
include dirname(__FILE__) . '/../include/class.db.php';
error_reporting(0);


    
/*
 session_start(); 
 if(isset($_SESSION['lock_config'])){ $time=(int)$_SESSION['lock_config']-(int)time(); if($time>0){ exit(json_encode(array('success'=>0,'icon'=>5,'m'=>"请勿频繁提交，".$time."秒后再试！")));}}
 $_SESSION['lock_config']= time()+ $from_timeout;
*/


//传参初始化
$type = filter_input(INPUT_POST, 'type');

//检测参数
if ($type==""){ exit(json_encode(array('success' => 0, 'icon' => 0, 'm' => "请勿非法调用！")));}

$id = filter_input(INPUT_POST, 'id');
$flag = filter_input(INPUT_POST, 'flag');
$data = filter_input(INPUT_POST, 'data');
//json 初始化
$info = array('success' => 0, 'icon' => 6,'m'=>"参数错误");



switch ($type) {

    //防火墙规则 关闭	
    case 'black_match_stop':
        isid();    
        $CONFIG["BLACKLIST"]['match'][$id]['off'] = "0";
        $info['m'] = "已停用";
        $info['icon'] = 5;
        break;
    //防火墙白规则 开启
    case 'black_match_start':
        isid();
        $CONFIG["BLACKLIST"]['match'][$id]['off'] = "1";
        $info['m'] = "已开启";
        break;
    //防火墙规则 删除 
    case 'black_match_del':
         isid();
         $id=explode(",",$id);
        if (is_array($id)) {
            foreach ($id as $key) {
                unset($CONFIG["BLACKLIST"]['match'][$key]);              
            }
        } else {
             unset($CONFIG["BLACKLIST"]['match'][$id]);
       
        }
        array_values($CONFIG["BLACKLIST"]['match']);
        $info['id'] = filter_input(INPUT_POST, 'id');
        $info['m'] = "删除成功";
        break;

    //防火墙规则 添加项 	 
    case 'black_match_add' :

        $CONFIG["BLACKLIST"]['match'][] = array(
            'off' => filter_input(INPUT_POST, 'BLACKLIST_MATCTH_OFF'),
            'type' =>filter_input(INPUT_POST, 'BLACKLIST_MATCTH_TYPE'),
            'for' =>filter_input(INPUT_POST, 'BLACKLIST_MATCTH_FOR'),
            'val' => preg_split('/[\r\n]+/s', trim(filter_input(INPUT_POST, 'BLACKLIST_MATCTH_VAL'))),
            'black' => filter_input(INPUT_POST, 'BLACKLIST_MATCTH_BLACK'),
            'name' => filter_input(INPUT_POST, 'BLACKLIST_MATCTH_NAME'),
            'match' =>  filter_input(INPUT_POST, 'BLACKLIST_MATCTH_MATCH'),
            'num' =>  filter_input(INPUT_POST, 'BLACKLIST_MATCTH_NUM')
        );

        $info['m'] = "添加成功";
        break;

    //防火墙规则 修改	 
    case 'black_match_edit' :
          isid(); 
         $CONFIG["BLACKLIST"]['match'][$id] = array(
            'off' => filter_input(INPUT_POST, 'BLACKLIST_MATCTH_OFF'),
            'type' =>filter_input(INPUT_POST, 'BLACKLIST_MATCTH_TYPE'),
            'for' =>filter_input(INPUT_POST, 'BLACKLIST_MATCTH_FOR'),
            'val' => preg_split('/[\r\n]+/s', trim(filter_input(INPUT_POST, 'BLACKLIST_MATCTH_VAL'))),
            'black' => filter_input(INPUT_POST, 'BLACKLIST_MATCTH_BLACK'),
            'name' => filter_input(INPUT_POST, 'BLACKLIST_MATCTH_NAME'),
            'match' =>  filter_input(INPUT_POST, 'BLACKLIST_MATCTH_MATCH'),
            'num' =>  filter_input(INPUT_POST, 'BLACKLIST_MATCTH_NUM')
        );

        $info['m'] = "修改成功";
        break;


    //防火墙动作 添加 	 
    case 'black_black_add' :

        $CONFIG["BLACKLIST"]['black'][] = array(
            'type' => filter_input(INPUT_POST, 'BLACKLIST_BLACK_TYPE'),
            'action' =>  filter_input(INPUT_POST, 'BLACKLIST_BLACK_ACTION'),
            'info' => base64_encode(filter_input(INPUT_POST, 'BLACKLIST_BLACK_INFO')),
            'name' => filter_input(INPUT_POST, 'BLACKLIST_BLACK_NAME'),
        );

        $info['m'] = "添加成功";
        break;

    //防火墙动作 修改 	 
    case 'black_black_edit' :
          isid();
         $CONFIG["BLACKLIST"]['black'][$id] = array(
            'type' => filter_input(INPUT_POST, 'BLACKLIST_BLACK_TYPE'),
            'action' =>  filter_input(INPUT_POST, 'BLACKLIST_BLACK_ACTION'),
            'info' => base64_encode(filter_input(INPUT_POST, 'BLACKLIST_BLACK_INFO')),
            'name' => filter_input(INPUT_POST, 'BLACKLIST_BLACK_NAME'),
        );

        $info['m'] = "修改成功";
        break;

       
    //防火墙动作 删除 
    case 'black_black_del':
        isid();
         $id=explode(",",$id);
        if (is_array($id)) {
            foreach ($id as $key) {
               unset($CONFIG["BLACKLIST"]['black'][$key]);   
            }
        } else {
              unset($CONFIG["BLACKLIST"]['black'][$id]);   
        }
        array_values($CONFIG["BLACKLIST"]['black']);
        $info['id'] = filter_input(INPUT_POST, 'id');
        $info['m'] = "删除成功";
        break;

        

    //广告过滤规则 添加项 	 
    case 'adblack_match_add' :

         $arr=preg_split('/[\r\n]+/s', trim(filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_VAL')));
        
         foreach($arr as $key){$val=explode("=>",$key); $array[trim($val[0])]=trim($val[1]);}

        $CONFIG["BLACKLIST"]['adblack']['match'][] = array(
            'off' => filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_OFF'),
            'name' => filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_NAME'),
            'target' =>  filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_TARGET'),
            'num' =>  filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_NUM'),
            'ref' =>  filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_REF'),
            'val' =>$array
        );
        $info['m'] = "添加成功";
        break;
        
      //广告过滤规则 修改项 	 
    case 'adblack_match_edit' :
         isid();
      
        $CONFIG["BLACKLIST"]['adblack']['match'][$id] = array(
            'off' => filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_OFF'),
            'name' => filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_NAME'),
            'target' =>filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_TARGET'),
            'ref' =>  filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_REF'),
            'num' =>  filter_input(INPUT_POST, 'BLACKLIST_ADBLACK_MATCH_NUM'),
            'val' =>   GetPostArr("BLACKLIST_ADBLACK_MATCH_VAL",TRUE)
        );
        $info['m'] = "修改成功";
        break;   
        
     
    //广告过滤规则 关闭	
    case 'adblack_match_stop':
        isid();    
        $CONFIG["BLACKLIST"]['adblack']['match'][$id]['off'] = "0";
        $info['m'] = "已停用";
        $info['icon'] = 5;
        break;
    //广告过滤规则 开启
    case 'adblack_match_start':
        isid();
        $CONFIG["BLACKLIST"]['adblack']['match'][$id]['off'] = "1";
        $info['m'] = "已开启";
        break;
    //广告过滤规则 删除 
    case 'adblack_match_del':
         isid();
         $id=explode(",",$id);
        if (is_array($id)) {
            foreach ($id as $key) {
                unset($CONFIG["BLACKLIST"]['adblack']['match'][$key]);              
            }
        } else {
             unset($CONFIG["BLACKLIST"]['adblack']['match'][$id]);
       
        }
        array_values($CONFIG["BLACKLIST"]['adblack']['match']);
        $info['id'] = filter_input(INPUT_POST, 'id');
        $info['m'] = "删除成功";
        break;   
        
     //广告过滤 基本参数设置
    case 'adblack_system':           
        $CONFIG["BLACKLIST"]['adblack']['name'] = trim(filter_input(INPUT_POST, 'ADBLACK_NAME'));
        $info['m'] = "保存成功";
        break; 
 
        
    //对接 添加
    case 'link_add' :
     
        $CONFIG["LINK_URL"][] = array(
            'off' => filter_input(INPUT_POST, 'LINK_OFF'),
            'type' => filter_input(INPUT_POST, 'LINK_TYPE'),
	    'api' => filter_input(INPUT_POST, 'LINK_API'),
	    'match' =>filter_input(INPUT_POST, 'LINK_MATCH'),
            'num' => filter_input(INPUT_POST, 'LINK_NUM'),
            'name' => trim(filter_input(INPUT_POST, 'LINK_NAME')),
            'path' =>trim(filter_input(INPUT_POST, 'LINK_PATH')),
            'shell' => trim(filter_input(INPUT_POST, 'LINK_SHELL')),
             'html' => trim(filter_input(INPUT_POST, 'LINK_HTML')),  
            'fields' => trim(filter_input(INPUT_POST, 'LINK_FIELDS')),
           'strtr' => trim(filter_input(INPUT_POST, 'LINK_STRTR')),
            'cookie' => filter_input(INPUT_POST, 'LINK_COOKIE'),
            'proxy' => filter_input(INPUT_POST, 'LINK_PROXY'),  
            'val_off' => filter_input(INPUT_POST, 'LINK_VAL_OFF'), 
            'header' => GetPostArr("LINK_HEADER",false,":"),
            'add' => GetPostArr("LINK_ADD"),
            'val' => GetPostArr("LINK_VAL"),
      
        );
        $info['m'] = "添加成功";
        break;

    //对接 修改    
    case 'link_edit' :
         isid();
		  $match=filter_input(INPUT_POST, 'LINK_MATCH');
          $CONFIG["LINK_URL"][$id] = array(
            'off' => filter_input(INPUT_POST, 'LINK_OFF'),
            'type' => filter_input(INPUT_POST, 'LINK_TYPE'),
	    'api' => filter_input(INPUT_POST, 'LINK_API'),
            'match' =>filter_input(INPUT_POST, 'LINK_MATCH'),
            'num' => filter_input(INPUT_POST, 'LINK_NUM'),
            'name' => trim(filter_input(INPUT_POST, 'LINK_NAME')),
            'path' =>trim(filter_input(INPUT_POST, 'LINK_PATH')),
            'shell' => trim(filter_input(INPUT_POST, 'LINK_SHELL')),
            'html' => trim(filter_input(INPUT_POST, 'LINK_HTML')),  
            'fields' => trim(filter_input(INPUT_POST, 'LINK_FIELDS')),
	  'strtr' => trim(filter_input(INPUT_POST, 'LINK_STRTR')),
            'cookie' => filter_input(INPUT_POST, 'LINK_COOKIE'),
            'proxy' => filter_input(INPUT_POST, 'LINK_PROXY'),  
            'val_off' => filter_input(INPUT_POST, 'LINK_VAL_OFF'),   
            'header' => GetPostArr("LINK_HEADER",false,":"),
            'add' => GetPostArr("LINK_ADD"),
            'val' => GetPostArr("LINK_VAL"),
              
      
        );
        $info['match'] = $match;
        $info['m'] = "修改成功";
        break;

//对接 删除 
    case 'link_del':
        isid();
        $id=explode(",",$id);
        if (is_array($id)){foreach ($id as $key) {unset($CONFIG["LINK_URL"][$key]); }} else {unset($CONFIG["LINK_URL"][$id]);}
        array_values($CONFIG["LINK_URL"]);
        $info['id'] = filter_input(INPUT_POST, 'id');
        $info['m'] = "删除成功";
        break;
//对接 停止
    case 'link_stop':
        isid();
        $CONFIG["LINK_URL"][$id]['off'] = 0;
        $info['m'] = "已停用";
        $info['icon'] = 5;
        break;

    //对接 启动
    case 'link_start':
         isid();
        $CONFIG["LINK_URL"][$id]['off'] = 1;
        $info['m'] = "已启用";
        $info['icon'] = 6;
        break;

    //修改 管理员密码 
    case 'user_edit':
        $CONFIG["user"] = trim(filter_input(INPUT_POST, 'username'));
        $CONFIG["pass"] = md5(trim(filter_input(INPUT_POST, 'password')));
        $info['m'] = $user . "修改成功";
        break;
    //更新 云规则 
    case 'upyundata':
        $data = curl($webapi."/save/yun.match.js");
        if (preg_match("/\<\?php[\S\s]*\?\>/i", $data)) {
            if (file_put_contents("../save/yun.match.php", $data)) {
                $data = curl($api."/save/yun.ver.js?".uniqid());
                if($data){file_put_contents("../save/yun.ver.js", $data);}
                $info["success"] = 1;
                $info['m'] = "更新成功"; 
                exit(json_encode($info));
            }
        }
        $info['success'] = 1;
        $info['icon'] = 5;
        $info['m'] = "更新失败，请检查网络连接:".$webapi;
        exit(json_encode($info));
        
    case 'reset':    
        
          if(copy('../source/bak/config.php','../save/config.php')){
          copy('../source/bak/yun.config.php','../save/yun.config.php');
          copy('../source/bak/yun.data.php','../save/yun.data.php');
          copy('../source/bak/yun.match.php','../save/yun.match.php');
          copy('../source/bak/top.inc.php','../save/top.inc.php');
            $info["success"] = 1;
            $info['icon'] = 6;
            $info['m'] = "恢复成功！";
          
        }else{
             $info['success'] = 0;
             $info['icon'] = 5;
             $info['m'] = "恢复失败，请检查文件权限！";
        }
         exit(json_encode($info));
          
    case 'check':
        //检测配置文件

    
        $info['m'] = "查询成功!";
        $info["success"] = 1;
        $info['icon'] = 6;
        $info["config"]=file_exists(dirname(__FILE__).'/../save/config.php')?1:0;
        $info["save"]=is_writable(dirname(__FILE__).'/../save')?1:0;
        $info["cache"]=is_writable(dirname(__FILE__).'/../cache')?1:0;
        exit(json_encode($info));
    case 'recache':
        if(function_exists("opcache_reset")){opcache_reset();}
        $cache = new Cache(array("type"=>$CONFIG["cache"]["type"],"cacheDir"=>"../cache","ip"=>$CONFIG["cache"]["ip"],"pass"=>$CONFIG["cache"]["pass"],"prot"=>$CONFIG["cache"]["prot"]));
        if($cache->clear_all()){
            $info["success"] = 1;
            $info['icon'] = 6;
            $info['m'] = "缓存已成功清除！";
            
        }else{
            $info["success"] = 0;
            $info['icon'] = 5;
            $info['m'] = "清除失败,请检查文件权限!";
            
        }
        exit(json_encode($info));
        
       // 保存微信插件配置

     case 'plus_weixin_save':

        $CONFIG["plus"]['weixin'] = array(
            'off'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_OFF'),
            'title'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_TITLE'),
            'api'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_API'),
            'token'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_TOKEN'),
            'pic'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_PIC'),
            'book'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_BOOK'),
            'num'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_NUM'),
            'jmp_off'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_JMP_OFF'),
            'msg_send'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_MSG_SEND'),
            'msg_not'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_MSG_NOT'),
            'msg_help'=>filter_input(INPUT_POST, 'PLUS_WEIXIN_MSG_HELP'),
        );

        $info['m'] = "保存成功";
        break;

    
     case 'plus_app_save':

        $CONFIG["plus"]['app'] = array(
            'off'=>filter_input(INPUT_POST, 'PLUS_APP_OFF'),
            'token'=>filter_input(INPUT_POST, 'PLUS_APP_TOKEN'),
            'title'=>filter_input(INPUT_POST, 'PLUS_APP_TITLE'),
             'home'=>filter_input(INPUT_POST, 'PLUS_APP_HOME'),
            'search'=>filter_input(INPUT_POST, 'PLUS_APP_SEARCH'),
             'su'=>filter_input(INPUT_POST, 'PLUS_APP_SU'),
            'top'=>[
                 'value'=>filter_input(INPUT_POST, 'PLUS_APP_TOP_VALUE'),
                 'key'=>filter_input(INPUT_POST, 'PLUS_APP_TOP_KEY'),           
            ],
             'update'=>[
                 'ver'=>filter_input(INPUT_POST, 'PLUS_APP_UPDATE_VER'),
                 'info'=>filter_input(INPUT_POST, 'PLUS_APP_UPDATE_INFO'),  
                 'url'=>filter_input(INPUT_POST, 'PLUS_APP_UPDATE_URL'),  
            ],
            
            'ua'=>filter_input(INPUT_POST, 'PLUS_APP_UA'),
             'sites'=>filter_input_Arr('PLUS_APP_SITES'),
            'start'=>filter_input(INPUT_POST, 'PLUS_APP_START'),
       
        );

        $info['m'] = "保存成功";
        break;
    
    
    
    
    
    
    /*  ===========    数据表操作     ===============  */

    //添加
    case  'table_add':
        if($flag=='parse'){
           $CONFIG[$flag][] = array(
            'off' => filter_input(INPUT_POST, 'PARSE_OFF'),
            'name' => trim(filter_input(INPUT_POST, 'PARSE_NAME')),
            'url' => filter_input(INPUT_POST, 'PARSE_URL'),
             );
           $info['m'] = "添加成功";
            
        }else if($flag=='live'){
            
             $CONFIG[$flag][] = array(
            'off' => filter_input(INPUT_POST, 'LIVE_OFF'),
            'name' => trim(filter_input(INPUT_POST, 'LIVE_NAME')),
            'play' => trim(filter_input(INPUT_POST, 'LIVE_PLAY')),     
            'url' => filter_input(INPUT_POST, 'LIVE_URL'),
                 
             );
           $info['m'] = "添加成功";
       
           }else if($flag=='resource'){
            
             $CONFIG[$flag][] = array(
            'off' => filter_input(INPUT_POST, 'RESOURCE_OFF'),
            'name' => trim(filter_input(INPUT_POST, 'RESOURCE_NAME')),
            'url' => filter_input(INPUT_POST, 'RESOURCE_URL'),
            'type' => filter_input(INPUT_POST, 'RESOURCE_TYPE'), 
             );
           $info['m'] = "添加成功";
           
             }else if($flag=='vod'){
            
             $CONFIG[$flag][] = array(
            'off' => filter_input(INPUT_POST, 'VOD_OFF'),
            'name' => trim(filter_input(INPUT_POST, 'VOD_NAME')),
            'url' => filter_input(INPUT_POST, 'VOD_URL'),
            'data' => filter_input(INPUT_POST, 'VOD_DATA'),    
 
             );
           $info['m'] = "添加成功";
           
           
           
        }
      
       break;
      
//修改
    case  'table_edit':
       isid();
        if($flag=='parse'){
           $CONFIG[$flag][$id] = array(
            'off' => filter_input(INPUT_POST, 'PARSE_OFF'),
            'name' => trim(filter_input(INPUT_POST, 'PARSE_NAME')),
            'url' => filter_input(INPUT_POST, 'PARSE_URL'),
             );
           $info['m'] = "修改成功";
            
        }else if($flag=='live'){
             $CONFIG[$flag][$id] = array(
            'off' => filter_input(INPUT_POST, 'LIVE_OFF'),
            'name' => trim(filter_input(INPUT_POST, 'LIVE_NAME')),
            'play' => trim(filter_input(INPUT_POST, 'LIVE_PLAY')),     
            'url' => filter_input(INPUT_POST, 'LIVE_URL'),
                 
             );
           $info['m'] = "修改成功";
  
       }else if($flag=='resource'){
             $CONFIG[$flag][$id] = array(
            'off' => filter_input(INPUT_POST, 'RESOURCE_OFF'),
            'name' => trim(filter_input(INPUT_POST, 'RESOURCE_NAME')),
            'url' => filter_input(INPUT_POST, 'RESOURCE_URL'),
            'type' => filter_input(INPUT_POST, 'RESOURCE_TYPE'),   
             );
           $info['m'] = "修改成功";      
           
    
         }else if($flag=='vod'){
            
             $CONFIG[$flag][$id] = array(
            'off' => filter_input(INPUT_POST, 'VOD_OFF'),
            'name' => trim(filter_input(INPUT_POST, 'VOD_NAME')),
            'url' => filter_input(INPUT_POST, 'VOD_URL'),
            'data' => filter_input(INPUT_POST, 'VOD_DATA'),    
 
             );
           $info['m'] = "修改成功";    
           
           
        }
      
       break;  

     //删除
      case  'table_del':
         isid();
       if(isset($CONFIG[$flag]))
       {
         $id=explode(",",$id);
        if (is_array($id)) {
            foreach ($id as $key) {
                unset( $CONFIG[$flag][$key]);              
            }
        } else {
             unset( $CONFIG[$flag][$id]);
       
        }
        $CONFIG[$flag]=array_values( $CONFIG[$flag]);
        $info['id'] = filter_input(INPUT_POST, 'id');
        $info['m'] = "删除成功";
    
       }
       break;
       
    //开启
    case 'table_start':
        isid();
        $id=explode(",",$id);
        if(isset($CONFIG[$flag])){
             if (is_array($id)) {
                  foreach ($id as $key) {
                         $CONFIG[$flag][$key]['off'] = "1";  
            }
             }else{
                 $CONFIG[$flag][$id]['off'] = "1"; 
                 
             }
     
        }
        $info['m'] = "开启成功";
        break;
       
    //关闭
    case 'table_stop':
         isid();
        $id=explode(",",$id);
        if(isset($CONFIG[$flag])){
             if (is_array($id)) {
                 foreach ($id as $key) {
                    $CONFIG[$flag][$key]['off'] = "0";  
                 }
             }else{
                 $CONFIG[$flag][$id]['off'] = "0";    
             }
        }
        $info['m'] = "关闭成功";
        break; 
        
       //置顶	 
    case 'table_top' :
        isid();
        if(isset($CONFIG[$flag])){
        $old=$CONFIG[$flag][0];
        $CONFIG[$flag][0]=$CONFIG[$flag][$id];
        $CONFIG[$flag][$id]=$old;
         $info['m'] = "置顶成功";
          
          }else{ 
              $info['m'] = "参数错误,操作失败!";
          }
      break; 
  
  //上移	 
    case 'table_up' :
       isid();
        if(isset($CONFIG[$flag]) ){
        if($id>0){
         $old=$CONFIG[$flag][$id-1];
        $CONFIG[$flag][$id-1]=$CONFIG[$flag][$id];
        $CONFIG[$flag][$id]=$old;
        $info['m'] = "上移成功";  
        }else{
            $info['icon'] = 5;
            $info['m'] = "已经到顶了";
        }
       }else{
           $info['m'] = "参数错误,操作失败!";
       }
      break; 
    //下移	 
    case 'table_down' :
        isid();
        if(isset($CONFIG[$flag]) ){
          if($id+1<sizeof($CONFIG[$flag])){
         $old=$CONFIG[$flag][$id+1];
        $CONFIG[$flag][$id+1]=$CONFIG[$flag][$id];
        $CONFIG[$flag][$id]=$old;
        $info['m'] = "下移成功";  
        }else{
            $info['m'] = "已经到底了";
        }

         }else{
           $info['m'] = "参数错误,操作失败!";
       }
      break;    
           
      //导入
    case 'table_upload':
      
        $arr= json_decode(base64_decode($data),true);
        if(is_array($arr)){
             if(isset($CONFIG[$flag]) ){
                 $CONFIG[$flag]=array_merge($CONFIG[$flag],$arr);
                 
             }else{
                  $CONFIG[$flag]=$arr;
                         
                 }
            $info['m'] = "导入成功";
             //数组去重
             $CONFIG[$flag]=assoc_unique($CONFIG[$flag], 'url');
     
        }else{
              $info['m'] = "导入失败";
        }
       
    break;
      
     //检测状态并更新
    case  'table_check':
     isid();
    if(isset($CONFIG[$flag]) ){
        if($data=="失效"){
           $CONFIG[$flag][$id]['off']="0"; 
           $CONFIG[$flag][$id]['status']="失效"; 
            
        }else{
           $CONFIG[$flag][$id]['off']="1"; 
           $CONFIG[$flag][$id]['status']="可用"; 
            
        }
          $info['m'] = "状态更新成功";
       }else{
           $info['m'] = "参数错误,操作失败!";
       }    
        
       break;  
        
        //检测全部状态并更新
    case  'table_checkall':
    if(isset($CONFIG[$flag]) ){
         $arr= json_decode(base64_decode($data),true);
         
         foreach ($arr as $value) {
             if($value['status']=="失效"){ 
                  $CONFIG[$flag][$value['id']]['off']="0"; 
                  $CONFIG[$flag][$value['id']]['status']="失效"; 
             }else{
                  $CONFIG[$flag][$value['id']]['off']="1";
                 $CONFIG[$flag][$value['id']]['status']="可用";    
             }
         }
        
          $info['m'] = "状态更新成功,数量：".$arr[0]['status'];
        }else{
           $info['m'] = "参数错误,操作失败!";
       }    
        
       break;  

    //检测缓存服务器链接
     case 'checkCache' :
         
          
         
         $ip =  filter_input(INPUT_POST, 'ip');
         $prot = filter_input(INPUT_POST, 'prot');
         $pass = filter_input(INPUT_POST, 'pass');
          
       if (!class_exists('Redis')){
           $info['success'] = 0;
            $info['m'] = "未安装Redis插件" ;
            exit(json_encode($info));
       }else{
     
              $cache = new Redis();
               $conn = $cache->connect($ip, $prot);
               
               if($conn){
                   
                   if($pass==""){$auth=true;}else{$auth = $cache->auth($pass);}
                   
                    if($auth){
                        
                        if($cache->ping()){
                          
                             $info['success'] = 1;
                            $info['icon'] = 6;
                            $info['m'] = $ip.':'.$prot." 连接成功！" ; 
                            
                        }else{
                             $info['success'] = 0;
                             $info['icon'] = 5;
                             $info['m'] = "服务未运行" ; 
                        }
                        
                    }else{
                         $info['success'] = 0;
                         $info['icon'] = 5;
                         $info['m'] = $ip.':'.$prot."连接失败<br>Redis服务密码错误!" ; 
                        
                    }
                   
            
               }else{
                   $info['m'] = "连接失败,IP或端口错误" ; 
                   
               }
               
               
             
              
       }
   
        exit(json_encode($info));
      
       break; 
       
    default:
        exit(json_encode(array('success' => 0, 'icon' => 5, 'm' => "参数错误！")));
}


if (Main_db::save()) {

    $info['success'] = 1;
} else {

    $info['success'] = 0;
    $info['icon'] = 5;
    $info['m'] = "操作失败！";
}

exit(json_encode($info));

function GetPostArr($word,$BASE64=false,$delimiter="=>"){
        $val=trim(filter_input(INPUT_POST, $word)); 
        if($BASE64){$val= base64_decode($val);}
        if($val==""){return null;}   
        $arr=preg_split('/[\r\n]+/s', $val);
        foreach($arr as $key){
          $val=explode($delimiter,$key);
          $key=trim($val[0]);
          if($key!==""){$array[$key]= trim($val[1]);}
        }
        return $array;
}

function filter_input_Arr($word,$delimiter=","){
        $val=trim(filter_input(INPUT_POST, $word)); 
        if($val==""){return null;}   
        $arr=preg_split('/[\r\n]+/s', $val);
        foreach($arr as $key){
          $val=explode($delimiter,$key);
          $key=trim($val[0]);
          if($key!==""){$array[]=['name'=>$val[0],'api'=>$val[1]];}
        }
        return $array;
}



function isid(){   
    if(!filter_has_var(INPUT_POST, "id")){ exit(json_encode(array('success' => 0, 'icon' => 0, 'm' => "id错误，没有找到id！"))); }   
}

function curl($url, $ref = '') {
    $params["ua"] = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36";
    $params['ref'] = $ref;
    return GlobalBase::curl($url, $params);
}
function assoc_unique($arr, $key) {
 
$tmp_arr = array();
 
foreach ($arr as $k => $v) {
 
if (in_array($v[$key], $tmp_arr)) {
 
unset($arr[$k]);
 
} else {
 
$tmp_arr[] = $v[$key];
 
}
}
sort($arr); //sort函数对数组进行排序
return $arr;
 
}