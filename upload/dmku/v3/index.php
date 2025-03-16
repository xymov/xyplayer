<?php
error_reporting(0);
header("Content-Type:application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
require_once('../class/danmu.class.php');
$_config = require_once('../save/config.inc.php');

 if ($_config['数据库']['类型'] === 'mysql') {
      if ($_config['数据库']['方式'] === 'pdo') {
           require_once('../class/pdo.class.php');
           new sql('mysql');
    }
}elseif($_config['数据库']['类型'] === 'sqlite'){
        $_config['数据库']['地址'] ='../save/' . $_config['数据库']['地址'];
    if ($_config['数据库']['方式'] === 'pdo') {
        require_once('../class/pdo.class.php');
        new sql('sqlite');
      }
 }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $d_data = json_decode(file_get_contents('php://input'), true);

    // 限制发送频率
    $lock = 1;
    $ip = get_ip();
    $data = sql::查询_发送弹幕次数($ip);
    
 
    if (empty($data)) {
        sql::插入_发送弹幕次数($ip);
        $lock = 0;
    } else {
        $data = $data[0];

        if ($data['time'] + $_config['限制时间'] > time()) {
            if ($data['c'] < $_config['限制次数']) {
                $lock = 0;
                sql::更新_发送弹幕次数($ip);
            };
        }

        if ($data['time'] + $_config['限制时间'] < time()) {
            sql::更新_发送弹幕次数($ip, time());
            $lock = 0;
        }
    }

    if ($lock === 0) {
        if($d_data['type']==0){ $d_data['type']="right";}else if($d_data['type']==1){ $d_data['type']="top";}else if($d_data['type']==2){ $d_data['type']="bottom";}
        session_start();$d_data['author']=$_SESSION['username']?'管理员':'游客';
        $d_data['size']=$d_data['size']?:'27.5px';
        sql::插入_弹幕($d_data);
           die(json_encode(['code'=>0,'danmuku'=>true]));
    } else {
          die(json_encode(['code'=>200,'msg'=>'发送的太频繁了']));

    }

}

 if(filter_has_var(INPUT_GET, "id")){

        $id= $type=filter_input(INPUT_GET, "id");
         $mes = sql::查询_弹幕池($id);
         $length = count($mes);
        if ($length == 0) {
            $mov = "一条弹幕都没有，赶紧来一发吧！";
            $length=2;
        } else {
            $mov = "有 $length 条弹幕列队来袭~做好准备吧！";
        }
        $tips = [2, "right", "#fff", "", "$mov"];
        $tips1 = [$_config['tips']['time'], "top", $_config['tips']['color'], "", $_config['tips']['text']];
        @array_unshift($mes, $tips, $tips1);
         $data=[
               'code'=>0, 
               'name' => $id,
               'danum' => $length,
               'data'=> $mes
         ];
       die(json_encode($data));
    }else{
        die(json_encode(['code'=>200,'msg'=>$_SERVER["QUERY_STRING"]]));
    }
    
    function get_ip()
{
    global $_config;
    if ($_config['is_cdn']) {
        if (preg_match('/,/', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
