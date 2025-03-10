<?php

defined('DEBUG') or define('DEBUG', 0); // 0: 线上模式; 1: 调试模式; 

defined('ERR_MSG') or define('ERR_MSG', '抱歉，当前页面出了点问题，请稍后再试...');

error_reporting(DEBUG ? E_ALL : 0);

//自定义异常和错误处理
  set_error_handler('_error_handler', E_ALL);  // 注册错误处理方法来处理所有错误
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

 function ShowError($e,$type='')
{
     
     is_dir(APP_PATH."log/") || mkdir(APP_PATH."log/"); 
     
      $etext=($type==-1)? "错误" : "{$type}异常";
      error_log($etext."发生！错误属于：" .$e["type"].','. $e["msg"] . "，所在文件 " . $e["file"] . "，位于行 " . $e["line"] . "\r\n",3,APP_PATH."log/".date('Y-m-d').".log");
    
  if(DEBUG){
         
         echo '<SCRIPT Language="JavaScript">document.body.innerHTML="";</SCRIPT>';       
         $code=getLine($e["file"],$e["line"]); 
         
        
         $msg="<!DOCTYPE html><html><meta http-equiv='Content-Type' content='text/html; charset=utf-8'><head><title>网站提示</title></head><body>";
         $msg.="<font style='color:red;'>警告:程序发生{$etext}！</font><br>";
         $msg.= "错误编号: ".$e["type"]."<br>";
         $msg.= "错误信息: ".$e["msg"]."<br>";
         $msg.= "出错文件: ".$e["file"]."<br>";
         $msg.= "出错行号: ".$e["line"]."<br>";
         $msg.= "出错代码: <font style='color:#0000FF;'>".$code."<br></font></body></html>";
         die($msg); 
    //     }elseif($type!==-1){     
     }elseif($type!=-1){
     $err_msg=ERR_MSG;      
  $msg=<<<html
     <SCRIPT Language="JavaScript">document.body.innerHTML="";</SCRIPT>      
     <!DOCTYPE html><html><head><title>提示信息</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <base target='_self'/><style>body{background:#f9fafd;color:#818181}.msg_jump{width:90%;max-width:624px;min-height:60px;padding:20px 50px 50px;margin:5% auto 0;font-size:14px;line-height:24px;border:1px solid #cdd5e0;border-radius:10px;background:#fff;box-sizing:border-box;text-align:center}.msg_jump .title{margin-bottom:11px}.msg_jump .text{margin-bottom:11px}.msg_jump_tit{width:100%;height:35px;margin:25px 0 10px;text-align:center;font-size:25px;color:#0099CC;letter-spacing:5px}</style></head>
    <body leftmargin='0' topmargin='0'><center><script>setTimeout("location='javascript:history.go(-1)'",3000);</script>
    <br/><div class='msg_jump'><div class='msg_jump_tit'>系统提示</div><font style='color:red;'>$err_msg</font><br /><br /><a href='javascript:history.go(-1)'><font style='color:#777777;'>如果你的浏览器没反应，请点击这里...</font></a><br/></div></div><br/><br/></div></div></center></body></html>
   html;
   die($msg); 
 
    }
      
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