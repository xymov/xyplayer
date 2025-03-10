<?php

/*        加载防火墙模块      */
//运行目录
define("FCPATH", str_replace("\\", "/", dirname(__FILE__)));
//加载核心类
 require_once FCPATH.'/../include/class.main.php';
 //加载配置文件
require_once FCPATH.'/../save/config.php';
//加载防火墙规则
Blacklist::parse($CONFIG["BLACKLIST"]);

/*       加载防火墙模块结束      */

if ($_GET['ac'] == "getdate") {
include ('save/data.php');
    $json = [
       'code' => 1,
       'data' => $yzm
    ];
die(json_encode($json));

 }


require_once('init.php');


require_once('class/danmu.class.php');


 
$d = new danmu();
if ($_GET['ac'] == "edit") {
    $cid = $_POST['cid'] ?: showmessage(-1, null);
    $data = $d->编辑弹幕($cid) ?:  succeedmsg(0, '完成');
    exit;
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
        $d->添加弹幕($d_data);
        succeedmsg(23, true);
    } else {
        succeedmsg(-2, "发送的太频繁了");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['ac'] == "report") {
        $text = $_GET['text'];
        sql::举报_弹幕($text);
        showmessage(-3, '举报成功！感谢您为守护弹幕作出了贡献');
    } else if ($_GET['ac'] == "dm" or $_GET['ac'] == "get") {
      
        $id = $_GET['id'] ?: showmessage(-1, null);
        $data = $d->弹幕池($id) ?: showmessage(23, array());
   
        showmessage(23, $data);
        
       
        
    } else if ($_GET['ac'] == "list") {
        $data = $d->弹幕列表() ?: showmessage(0, []);
        showmessage(0, $data);
    } else if ($_GET['ac'] == "reportlist") {
        $data = $d->举报列表() ?: showmessage(0, []);     
        showmessage(0, $data);
    } else if ($_GET['ac'] == "del") {
        $id = $_GET['id'] ?: succeedmsg(-1, null);
        $type = $_GET['type'] ?: succeedmsg(-1, null);
        $data = $d->删除弹幕($id) ?: succeedmsg(0, []);
        succeedmsg(23, true);
    } else if ($_GET['ac'] == "so") {
        $key = $_GET['key'] ?: showmessage(0, null);
        $data = $d->搜索弹幕($key) ?: showmessage(0, []);
        showmessage(0, $data);
    }
}
