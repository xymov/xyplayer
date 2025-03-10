<?php
/*##################################################
# xypaly 智能视频解析 X   by nohacks.cn
# 官方网站: http://nohacks.cn
# 源码获取：http://nohacks.taobao.com 
# 模块功能：PHP文本数据操作
###################################################*/
//不显示读取错误
ini_set("error_reporting","E_ALL & ~E_NOTICE");

!defined('APP_PATH') && exit('error');
//配置操作类
class Main_db
{
     //变量转文本
     public static function word($name) {global $$name; $key=var_export($$name,true);return "$$name=$key;\r\n";}
     //保存配置
     public static function save($file="../save/config.php")
     {     
      global $CONFIG;
         
      
        //排除注释和php标记
        $data = preg_replace('!\/\/.*?[\r\n]|\/\*[\S\s]*?\*\/!', '', preg_replace('/(?:\<\?php|\?\>)/', '', file_get_contents($file)));       
        //按php语句分组
        $lines = preg_split('/[;]+/s', $data,-1,PREG_SPLIT_NO_EMPTY);	 
        $word ="<?php\r\n";
       //更新变量
        foreach ($lines as $value){
          $value= trim($value);
          //检测是否PHP变量声明
          if($value!==''&&substr($value,0,1)==='$'){
              //分离 变量名和值
              $line=explode('=',$value,2);
              //取变量名
              $name = str_replace('$', '', trim($line[0]));
              //变量转文本 重新赋值
              $word.=self::word($name); }       
          }   
        return file_put_contents($file,$word);  	  
     }
     //取数据内容,不使用变量节省内存
     public static function get($db,$type,$page,$limit){
         $count=count($db[$type]);
         $start=$page>0?($page-1)*$limit:0;
         $stop=$limit>0?$start+$limit:$count;        
         echo "{\"code\":0,\"msg\":\"\",\"count\":$count,\"data\":[";
         for ($i = $start; $i<$count; $i++) 
         {
           $value=$db[$type][$i];
           $value["id"]=($i+1);
               if( $i+1==$stop || $i+1==$count){
                   echo  json_encode($value, JSON_FORCE_OBJECT);
                   break; 
               }else{
                    echo  json_encode($value, JSON_FORCE_OBJECT).",";
               }     
         } 
        echo "]}";  
        return $count;
     
 }
 
 
    //搜索内容
      public static function searchArr($arr,$word){
           foreach ($arr as $key =>$value) {
               
            foreach ($value as $val) {if(strstr($val, $word) !== false){$value["id"]=$key+1;yield $value;}}
          }
       
      }
     
     //取数据内容,不使用变量节省内存
     public static function search($db,$type,$word,$page,$limit){
         
         $count=count($db[$type]);$i=0;
         $start=$page>0?($page-1)*$limit:0;
         $stop=$limit>0?$start+$limit:$count;   
        
         echo "{\"code\":0,\"msg\":\"\",\"data\":[";
  
          $out="";
         foreach (self::searchArr($db[$type],$word) as $value) {
            if($i+1>=$start)
           {
               if( $i+1==$stop){
                   break; 
               }else{
                   $out.=json_encode($value, JSON_FORCE_OBJECT).",";
               }     
           }   
           $i++;  
       
          }
            $out=substr($out, 0, strlen($out)-1);
            echo $out."],\"count\":$i}";  
            return $i;
  
     }
     

}
