<?php 
include "config.php";

//检测参数
if (!filter_has_var(INPUT_POST, "edit")) { exit(json_encode(array('success' => 0, 'icon' => 0, 'm' => "请勿非法调用！")));}

    $datas = $_POST;
    $data = $datas['yzm'];
    
    if (file_put_contents('../dmku/save/data.php', "<?php\n \$yzm =  ".var_export($data, true).";\n?>")) {
      
            exit(json_encode(array('success' => 1, 'icon' => 1,'m' => "保存成功！")));
        
     } else {
         
          exit(json_encode(array('success' => 0, 'icon' => 5, 'm' => "修改失败！可能是文件权限问题，请给予data.php写入权限！")));
     }
   
    
     



