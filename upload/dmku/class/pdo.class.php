<?php

error_reporting(E_ALL & ~E_NOTICE);

class sql {
    public static $sql ;
    private static $type ;
    function __construct($type) {
        global $_config ;
        self::$type = $type;
        if ($type === 'mysql') {
            self::mysql数据库连接($_config['数据库']['地址'],$_config['数据库']['用户名'],$_config['数据库']['密码'],$_config['数据库']['名称'],$_config['数据库']['端口']);
        }else if ($type === 'sqlite') {
            self::sqlite数据库连接($_config['数据库']['地址']);
        }  
    }

    private static function mysql数据库连接($hostname,$username,$password,$db,$port=3306) {
        try {
            $sql = new PDO("mysql:host=$hostname;dbname=$db;port=$port", $username, $password);
            $sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$sql = $sql ;
        } catch (PDOException $e) {
            die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
        }
    }
    
 
    private static function sqlite数据库连接($path) {
        try {
            $sql = new PDO("sqlite:$path");
            $sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$sql = $sql ;
        } catch (PDOException $e) {
            
            
            die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
        }
    }
    
    public static function 插入_弹幕($data){
        try {
            $query = null;
            if (self::$type == 'sqlite'){$query = ' OR';}
            $stmt = self::$sql->prepare("INSERT{$query} IGNORE INTO danmaku_list (id, type, text, color, size, videotime,ip, time,user) VALUES (:id, :type, :text, :color,:size, :videotime,:ip, :time,:user)");
            $stmt->bindParam(':text', $data['text']);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':type', $data['type']);
            $stmt->bindParam(':color', $data['color']);
            $stmt->bindParam(':size', $data['size']);
            $stmt->bindParam(':videotime', $data['time']);
            $stmt->bindParam(':ip', filter_input(INPUT_SERVER, "REMOTE_ADDR"));
            //@$stmt->bindParam(':time', date('m-d H:i',time()));
            @$stmt->bindParam(':time', time());
            @$stmt->bindParam(':user',$data['author']);
            $stmt->execute();
            
            
            
        } catch (PDOException $e) {
             
            
            die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
        }
        
    }
    
    public static function 举报_弹幕($text){
        try {
            $query = null;
            if (self::$type == 'sqlite'){$query = ' OR';}
            $stmt = self::$sql->prepare("INSERT{$query} IGNORE INTO danmaku_report (id,cid,text, type,time,ip) VALUES (:id,:cid,:text, :type,:time,:ip)");
            $stmt->bindParam(':id', $_GET['title']);
            $stmt->bindParam(':cid', $_GET['cid']);
            $stmt->bindParam(':text', $_GET['text']);
            $stmt->bindParam(':type', $_GET['type']);
            //@$stmt->bindParam(':time', date('m-d H:i',time()));
            @$stmt->bindParam(':time', time());
            $stmt->bindParam(':ip', $_GET['user']);
            $stmt->execute();
        } catch (PDOException $e) {
            die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
        }
    }
    public static function 插入_发送弹幕次数($ip){
        try {
            $query = null;
            if (self::$type == 'sqlite') $query = ' OR';
            $stmt = self::$sql->prepare("INSERT{$query} IGNORE INTO danmaku_ip (ip, time) VALUES (:ip, :time)");
            $stmt->bindParam(':ip', $ip);
            @$stmt->bindParam(':time', time());
            $stmt->execute();
        } catch (PDOException $e) {
            die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
        }
    }
    
    public static function 搜索_弹幕池($key){
        try {
            $stmt = self::$sql->prepare("SELECT * FROM danmaku_list WHERE text like ? or id like ?  or cid like ? ORDER BY time DESC");
            $stmt->execute(array("%$key%","%$key%","%$key%"));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e) {
            die(json_encode(['code'=>-1,'msg'=>"搜索 $key 发生错误，数据库错误:".$e->getMessage()]));
        }
    }
    public static function 查询_弹幕池($id){
        try {
            self::$sql->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            $stmt = self::$sql->prepare("SELECT * FROM danmaku_list WHERE id=:id ORDER BY time asc");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
            
            // die(json_encode(['code'=>-1,'msg'=>$data]));
            
            return $data;
        } catch (PDOException $e) {
            die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
        }
    }
    public static function 显示_弹幕列表(){
        try {
            //取数量
            $stmt = self::$sql->prepare("SELECT COUNT(*) FROM danmaku_list");
            $stmt->execute();
            $length =$stmt->fetch(PDO::FETCH_NUM)[0];
 

            //按页数查询
	    $page=filter_input(INPUT_GET, "page")?:1;          
            $limit=filter_input(INPUT_GET, "limit")?:10; 
	    $index = ($page-1)*$limit;
 
            self::$sql->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            $stmt = self::$sql->prepare("SELECT * FROM danmaku_list ORDER BY time DESC limit :index,:limit");
            $stmt->bindParam(':index', $index,PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit,PDO::PARAM_INT);   
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return [
            'code'=>0, 
            'count' => $length,
            'data' => $data
           ];
      
         } catch (PDOException $e) {
             die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
             
        }
    }
    public static function 显示_举报列表(){
        try {
	 
            $page=filter_input(INPUT_GET, "page")?:1;
            $limit=filter_input(INPUT_GET, "limit")?:10;
            //取数量
            $stmt = self::$sql->prepare("SELECT COUNT(*) FROM danmaku_report");
            $stmt->execute();
            $length =$stmt->fetch(PDO::FETCH_NUM)[0];            
        
           //输出数据            
	    $index = ($page-1)*$limit;
            self::$sql->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            $stmt = self::$sql->prepare("SELECT * FROM danmaku_report ORDER BY time DESC limit :index,:limit");
            $stmt->bindParam(':index', $index,PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit,PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
             return [
            'code'=>0,      
            'count' => $length,
            'data' => $data
           ];
             
         } catch (PDOException $e) {
            die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
        }
    }
    public static function 删除_弹幕数据($id)
    {
      try {
            $type=filter_input(INPUT_GET, "type")?:'list';
            //处理占位符
            $ids= explode(",",$id);
            $qs = "";foreach ($ids as $value) { $qs .= "?,"; };$qs= trim($qs,",");
          if($type=="list")
           {
            self::$sql->prepare("DELETE FROM danmaku_report WHERE cid in ($qs)")->execute($ids);
            self::$sql->prepare("DELETE FROM danmaku_list WHERE cid in ($qs)")->execute($ids); 
           }else if($type=="report"){
              self::$sql->prepare("DELETE FROM danmaku_report WHERE cid in ($qs)") ->execute($ids);
           }
        } catch (PDOException $e) {
            die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
           }
    }
    public static function 编辑_弹幕($cid){
        try {
            global $_config ;
            $text = filter_input(INPUT_POST, "text");
            $color = filter_input(INPUT_POST, "color");
            self::$sql->prepare("UPDATE danmaku_list SET text=?,color=? WHERE cid=?")->execute(array($text,$color,$cid));
            self::$sql->prepare("UPDATE danmaku_report SET text=?,color=? WHERE cid=?")->execute(array($text,$color,$cid)); 
          
        } catch (PDOException $e) {
           die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
        }
    }
    
    public static function 查询_发送弹幕次数($ip){
        try {
            $stmt = self::$sql->prepare("SELECT * FROM danmaku_ip WHERE ip=:ip LIMIT 1");
            $stmt->bindParam(':ip', $ip);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e) {
            die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
        }
    }
    
    public static function 更新_发送弹幕次数($ip,$time = 'time'){
        try {
            $query = "UPDATE danmaku_ip SET c=c+1,time=$time WHERE ip = :ip";
            if (is_int($time)) $query = "UPDATE danmaku_ip SET c=1,time=$time WHERE ip = :ip"; 
            $stmt = self::$sql->prepare($query);
            
            $stmt->bindParam(':ip', $ip);
            $stmt->execute();
        } catch (PDOException $e) {
            die(json_encode(['code'=>-1,'msg'=>'数据库错误:'.$e->getMessage()]));
        }
    }
	
} 