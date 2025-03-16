<?php  
include '../../save/config.php';$set=$CONFIG['plus']['weixin'];if(empty($set) || $set['off']==0){exit();}
 //  -----可配置区域开始-------------  
//微信令牌，请与微信公众号后台同步
define("TOKEN", $set['token']); 
//解析地址
define("API", $set['api']);
//显示数量
define("NUM", $set['num']);
//公众号名称          
define("TITLE",$set['title']);
//默认图片	
define("PIC", $set['pic']);
//留言本地址
define("BOOK", $set['book']);
//关注时回复信息       
define("MSG_SEND",$set['msg_send']);
//无内容时回复信息  	
define("MSG_NOT", $set['msg_not']);
//发送帮助时回复信息
define("MSG_HELP", $set['msg_help']);

//  -----可配置区域结束-------------  

$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
class wechatCallbackapiTest
{	
	public function CheckUrl($url)
	{		
	return preg_match('/(http|https|ftp):\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$url);	
	}
	public function valid()
    {
        $echoStr = $_GET["echostr"];
		if($echoStr==""){		
			$this->responseMsg();
		 }elseif($this->checkSignature()){
        	echo $echoStr;
        	exit;
           }
    }
	
    public function responseMsg(){  
           $postStr = addslashes(file_get_contents('php://input'));	 if (empty($postStr)){exit("你好！请关注【".TITLE."】微信公众号获取服务");}	   
           $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
           $fromUsername = $postObj->FromUserName;
           $toUsername = $postObj->ToUserName;
           $time=$postObj->CreateTime;
           $keyword = trim($postObj->Content);
           $event = $postObj->Event;			
                     
          $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
          $newsTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime> <MsgType><![CDATA[news]]></MsgType> <ArticleCount>1</ArticleCount><Articles><item><Title><![CDATA[%s]]></Title> <Description><![CDATA[%s]]></Description><PicUrl><![CDATA[%s]]></PicUrl><Url><![CDATA[%s]]></Url></item></Articles></xml>";	
    
         switch($postObj->MsgType){
               case 'event':
                    if($event == 'subscribe'){
                   
                    	//关注后的回复
							$contentStr = MSG_SEND;
							$msgType = 'text';
							$textTpl = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
							echo $textTpl;
                            break;
 
                 }
             
               case 'text':

                      if ($keyword==="帮助"){

                        $contentStr = MSG_SEND;
                        $msgType = 'text';
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;  

   
                      }elseif($keyword==="留言"){

                        $title = '点击打开留言板';
                        $des1 ="";
                        //图片地址
                        $picUrl1 =PIC;
                        //跳转链接
                        $url=self::getContentLink(BOOK);
                        $resultStr= sprintf($newsTpl, $fromUsername, $toUsername, $time, $title, $des1, $picUrl1, $url) ;									
                       echo $resultStr; 



                      //输入文字
                      }else if(preg_match('/[\x{4e00}-\x{9fa5}]+/u',$keyword))
					  {	

                           $result = file_get_contents(API."/api.php?token=".TOKEN."&tp=json&wd=".$keyword);
                           $result= json_decode($result,true);                                                                           
                           if($result &&  $result["success"]){
                            
                             $txt .="恭喜,成功找到".sizeof($result["info"])."个视频:\r\n\n";                
                             $i=1;                           
                             foreach( $result["info"] as $row){           
                                      $title = $row['title'];
                                      $url=API."/?index".$row['id']."-" . $row['flag']."-1.htm";
                                      $url=self::getContentLink($url);                              
                                      $pic= $row['pic'];
                                      $txt .= "<a href='".$url."'>·".urldecode($title)."</a>\r\n\n";
                                      $i++;
                                      if($i>NUM){break;}
                                    }
                                     $contentStr = $txt.'<a href="'.API."/?wd=".$keyword.'">【点击显示全部】</a>';
								     $msgType = 'text';
								     $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
									 echo $resultStr; 	
                           
                           } else{

								//没有查找到的时候的回复
								        $title = "资源未找到,点击图片留言反馈! ";
										$des1 ="";
										//图片地址
										$picUrl1 =PIC;
										//跳转链接								
                                        $url=self::getContentLink(BOOK);
										$resultStr= sprintf($newsTpl, $fromUsername, $toUsername, $time, $title, $des1, $picUrl1, $url) ;									
                                       echo $resultStr;                                     
                            }  
                       
					   //其他
                      
                       }else if($this->CheckUrl($keyword)){
                                        $title = '点击开始播放';
										$des1 ="";
										//图片地址
										$picUrl1 =PIC;
										//跳转链接
										$url=API."/?url=".$keyword."";
                                        $url=self::getContentLink($url);
										$resultStr= sprintf($newsTpl, $fromUsername, $toUsername, $time, $title, $des1, $picUrl1, $url) ;									
                                       echo $resultStr; 


                       
                       }else{
                         
                                    $contentStr = MSG_HELP;
								     $msgType = 'text';
								     $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
									 echo $resultStr;  
 
                       };
   
					   break;
               
             default:
				      break;
               
           }// switch end
}
 
	private function checkSignature(){
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
  
  private function getContentLink($url){
    
    return $url;
    
    //目前失效,无好用免费接口
     $api="http://api.t.sina.com.cn/short_url/shorten.json?source=2815391962&url_long=";
     $result = file_get_contents($api.$url);
     $result= json_decode($result,true);      
     return $result[0]["url_short"];
    
  }
  
  
  

  
}
