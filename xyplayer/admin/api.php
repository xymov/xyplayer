<?php
include "config.php";
include dirname(__FILE__) . '/../include/class.db.php';
//传参初始化
$type = filter_input(INPUT_POST, 'type');
$token=filter_input(INPUT_POST, 'token');
$page = filter_input(INPUT_POST, 'page');
$limit=filter_input(INPUT_POST, 'limit');


header('Content-type: application/json');

 //exit(Main_db::search($CONFIG, "live","cctv",1,50));
 
//exit(Main_db::get($CONFIG, "live",2,50));

//禁止跨域访问,token有效期60秒
if(!Crumb::verifyCrumb($type, $token,60)){
  //  header("HTTP/1.1 403 Forbidden");
  //  exit();   
}
//解析配置导入
if($type=='parse_upload'){
    //解析
       exit(uploadfile('parse')) ;
    
}else if($type=='live_upload'){    
    //直播   
        exit(uploadfile('live')) ;
 
}else if($type=='vod_upload'){    
     //本地数据  
        exit(uploadfile('vod')) ;        
  
}else if($type=='resource_upload'){            
      //云资源
        exit(uploadfile('resource')) ;  
        
}else{
   if(filter_has_var(INPUT_POST, "search")){
        exit(Main_db::search($CONFIG, $type,filter_input(INPUT_POST, 'search'),$page,$limit));
   }else{
       
       exit(Main_db::get($CONFIG, $type,$page,$limit));
       
   }
    
    }

  //  取文件后缀名  
   function get_file_extension($file_name) {
    return substr(strrchr($file_name,'.'),1);
}
      
    

//读取文件，使用生成器
    function readTxt($name)
  {
    $handle = fopen($name, 'rb');
    while (feof($handle)===false) {
        yield fgets($handle);
    }
    fclose($handle);
 }
      
 function uploadfile($type){
     
       $code=$_FILES['file']['error'];
       $file=$_FILES["file"]["tmp_name"];
       $subfix=get_file_extension($_FILES["file"]["name"]);
       $mime=$_FILES["file"]["type"];
       
  
       $json=file_get_contents("https://raw.iqiq.io/2hacc/TVBox/main/tvbox.json");
       
       $out=array('type'=>$type,'code' => $code,'mime'=>$mime,'subfix'=>$subfix,'msg' => "",'data'=>array());
      
       
      //return json_encode($out);
       
       if($code==0)
      {
           if($mime=='application/vnd.ms-excel' ||  $subfix=='csv' || $subfix=='xls'){
               foreach (readTxt($file) as $row => $value) {
                  if($row>0 && trim($value)!="" ){
                      $line=explode(",",trim($value));
                      if(sizeof($line)>0){
                          
                          if($type=='parse'){
                              
                              $out['data'][]=array('name'=>trim($line[0],'"'),'url'=>trim($line[1],'"'),'off'=>'1'); 
                              
                          }elseif($type=='live'){
                              
                              $out['data'][]=array('name'=>trim($line[0],'"'),'url'=>trim($line[1],'"'),'play'=>trim($line[2],'"'),'status'=>'','off'=>'1'); 
                          
                              
                           }elseif($type=='resource'){
                              
                              $out['data'][]=array('name'=>trim($line[0],'"'),'url'=>trim($line[1],'"'),'off'=>'1');     
                              
              
                              
                           }elseif($type=='vod'){
                              
                              $out['data'][]=array('name'=>trim($line[0],'"'),'url'=>trim($line[1],'"'),'data'=>trim($line[2],'"'),'off'=>'1');     
                              
                              
                          }
                          
                          
                      }        
                  }    
              }
               
          }elseif ($mime=='application/json' || $subfix=='json') {     
              $json_string = file_get_contents( $file);
                 $data = json_decode($json_string, true);
                 $sites=$data['sites'];
                     
                 foreach ($sites as $k=>$v) {
                    $out['data'][$k] =[
                        'url'=>$v['url']?:$v['api'],
                        'name'=>$v['name'],
                        'status'=>$v['status'],
                    ];  
                 };
                 
         
                 
           }elseif ($mime=='audio/mpegurl'|| $subfix=='m3u' || $subfix=='m3u8' ) 
             {    
                $name=array(); $url=array();
                 foreach (readTxt($file) as  $key =>  $value) 
                {
                 //取路径   
                 if($value&&substr($value,0,1)!="#"){
                     $url[]=trim($value); 
                 //取名称    
                 }elseif($value&&substr($value,0,7)=="#EXTINF"){
                     $arr=explode(",",$value);
                     $name[]=trim($arr[1]);    
                 }
                }
                for ($i = 0; $i < count($url); $i++) {
                     $out['data'][]=array('name'=>$name[$i],'play'=>'default','url'=>$url[$i],'status'=>'','off'=>'1'); 
                    
                }
  
             }   
           
  
           
            return json_encode($out);
   
     }
 
   }
 
 