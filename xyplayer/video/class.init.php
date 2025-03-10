<?php

!defined('APP_PATH') AND define('APP_PATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')), '/') . '/');

class INIT{
    public static function parse($url,$type="")	
        { 
    $info=array('success'=>0,'code'=>0);
      //获取数据
     if($url!="" ){ 	
    //mp4 m3u8 flv 直链	
    if (stristr($url,'.mp4')!==false || stristr($url,'.m3u8')!==false|| stristr($url,'.flv')!==false) {    
         
		  require_once APP_PATH.'/video/class.video.php';
		  
	      $info=VIDEO::parse($url);
	  
   //27盘资源处理
	 }else if(stristr($url,'27pan')!==false || explode("/",parse_url($url)['path'])[1]=='share'){   
   
         require_once APP_PATH.'/video/class.27pan.php';
		 
	     $info=PAN27::parse($url);	
     
                
    // 360看看处理
	}else if(stristr($url,'v.360kan.com')!==false){ 
             
           require_once APP_PATH. '/video/class.360.php';

	       $info=ShortVideo360::parse($url);	
           
	   
    // QQ空间处理
	}else if(stristr($url,'qzone.qq.com')!==false){ 
             
		require_once APP_PATH. '/video/class.qzone.php';

		$info=QZONE::parse($url);	
		  
	
      # 乐多资源处理
	}else if(strstr($url,'XMM')!==false ||  strstr($url,'XMOTA')!==false ||  $type==="leduo"){ 

           require_once  APP_PATH.'/video/class.leduo.php';
  
	      $info=LEDUO::parse($url);        

      #咪咕视频
	}else if(stristr($url,'miguvideo.com')!==false){ 
             
		require_once  APP_PATH.'/video/class.migu.php';
		$info=MIGU::parse($url);	
    


	 //添加更多   
	      
	  
    }else{
	
	     $info['m']='暂不支持直解';
	
    }
	
}else{
	
	 $info["m"]="input err!";

}

// 调用第三方资源
if($info["success"]==0 && (stristr($url,'http://')!==false || stristr($url,'https://')!==false ) ){

	 require_once APP_PATH.'/video/class.yun.php' ;
		
	 $info=YUN::parse($url);	

}else{

	$info['m']='暂不支持此站点';
}


return $info;

        }

}


