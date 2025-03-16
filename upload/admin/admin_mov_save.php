<?php 
include "config.php";

//检测参数
if (!filter_has_var(INPUT_POST, "edit")) { exit(json_encode(array('success' => 0, 'icon' => 0, 'm' => "请勿非法调用！")));}
    $datas = $_POST;
    $data = $datas['config'];
    $data['js_config']['parse']= explode("\r\n",$data['js_config']['parse']);
    $data['banner']['data']= json_decode($data['banner']['data'],true);
    if (file_put_contents('../mov/config.php', "<?php\n \$CONFIG =  ".var_export($data, true).";\n?>")) {
      
            exit(json_encode(array('success' => 1, 'icon' => 1,'m' => "保存成功！")));
        
     } else {
         
          exit(json_encode(array('success' => 0, 'icon' => 5, 'm' => "修改失败！可能是文件权限问题，请给予data.php写入权限！")));
     }
   
    
     




