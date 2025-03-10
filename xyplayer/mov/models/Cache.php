<?php


//缓存操作类 	
class Cache
{
    private $type = 1;             //默认缓存类型,1为文件，2为Redis服务
    private $prot = 6379;          //缓存服务端口，默认为Redis服务端口
    private $ip = "127.0.0.1";     //缓存服务器ip,默认为127.0.0.1
    private $pass = "";            //缓存服务器密码,默认为空
    private $cacheTime = 3600;        //默认缓存时间,可用单位 d|h|m|s，默认单位：秒(s)
    private $cacheDir = './cache';    //缓存绝对路径   
    private $md5 = true;              //是否对键和内容进行加密   
    private $suffix = "";         //设置文件后缀    
    private $prefix = "";           //设置缓存前缀
 
    private $cache;
    public function __construct($config)
    {

        if ($this->type == 0) {
            return;
        }

        if (is_array($config)) {
            foreach ($config as $key => $val) {
                $this->$key = $val;
            }
        }

        if ($this->type == 2) {
           if (class_exists('Redis')){
            $this->cache = new Redis();
            $this->cache->connect($this->ip , $this->prot);
            if($this->pass!=""){$this->cache->auth($this->pass);} //设置密码
            }else{
                $this->type = 1;
            }
        }
        //时间转换
         $this->cacheTime=$this->_time($this->cacheTime);
         
         //清理过期缓存
        $this->clear();
  
    }
    //设置缓存   
    public function set($key, $val, $leftTime = NULL)
    {
        $key=$this->prefix.$key;
        if ($this->type == 0) {

            return  false;
        } else if ($this->type == 1) {
            $key = $this->md5 ? md5($key) : $key;
            $val = $this->md5 ? base64_encode($val) : $val;
            if (function_exists("gzcompress")) {
                $val = @gzcompress($val);
            }
           
            !file_exists($this->cacheDir) && mkdir($this->cacheDir, 0777);
            $file = $this->cacheDir . '/' . $key . $this->suffix;
            $leftTime = empty($leftTime) ? $this->cacheTime : $leftTime;
            if ($leftTime != 0) {
            $ret = file_put_contents($file, $val) or $this->error(__line__, "文件写入失败");
            $ret = touch($file, time() + $leftTime) or $this->error(__line__, "更改文件时间失败");
             }
        } else if ($this->type == 2) {
            $key_md5 = $this->md5 ? md5($key) : $key;
            $val_base64 = $this->md5 ? base64_encode($val) : $val;
            $val_base64 = @gzcompress($val_base64);
            $ret = $this->cache->set($key_md5, $val_base64);
            if ($leftTime != 0) {
                $this->cache->EXPIRE($key_md5, $leftTime);
            }
            // $this->cache->del($val_base64); 
        }
        return   $ret;
    }

    //得到缓存   
    public function get($key)
    {
        $key=$this->prefix.$key;
        if ($this->type == 0) {
            return;
        } else if ($this->type == 1) {
            
            //$this->clear();   
            if ($this->_isset($key)) {

                $key_md5 = $this->md5 ? md5($key) : $key;
                
                 // echo $key_md5;
                
                $file = $this->cacheDir . '/' . $key_md5 . $this->suffix;
                $val = file_get_contents($file);
                  if (function_exists("gzuncompress") && $val) {
                    $val = @gzuncompress($val);
                  }
                $val = $this->md5 ? base64_decode($val) : $val;
                return $val;
            }
            return null;
        }
        if ($this->type == 2) {
            $key_md5 = $this->md5 ? md5($key) : $key;
            $val = $this->cache->get($key_md5);
            if (function_exists("gzuncompress") && $val) {
                $val = @gzuncompress($val);
            }
            $val_base64 = $this->md5 ? base64_decode($val) : $val;
            return $val_base64;
        }
    }

    //判断文件是否有效   
    public function _isset($key)
    {
        $key = $this->md5 ? md5($key) : $key;
        $file = $this->cacheDir . '/' . $key . $this->suffix;
        if (file_exists($file)) {
            if ($this->cacheTime == 0 || filemtime($file) >= time()) {
                return true;
            } else {
                @unlink($file);
                return false;
            }
        }
        return false;
    }

    //删除指定缓存  
    public function _unset($key)
    {
        $key=$this->prefix.$key;
        if ($this->type == 0) {
            return;
        } elseif ($this->type == 1) {
            if ($this->_isset($key)) {
                $key_md5 = $this->md5 ? md5($key) : $key;
                $file = $this->cacheDir . '/' . $key_md5 . $this->suffix;
                return @unlink($file);
            }
        } elseif ($this->type == 2) {
            $key_md5 = $this->md5 ? md5($key) : $key;
            return $this->cache->del($key_md5);
        }
    }
    //清除过期缓存文件   
    public function clear()
    {
        $ret=false;
        $cacheTime = $this->cacheTime;
        if($cacheTime == 0){return false;}
        $files = scandir($this->cacheDir);
        foreach ($files as $val) {
            if ($val!=".." && $val!="." &&filemtime($this->cacheDir . "/" . $val)  < time()) {
                $ret = @unlink($this->cacheDir . "/" . $val);
            }
        }
        return $ret;
    }

    //清除所有缓存文件   
    public function clear_all()
    {
        $ret = true;
        if ($this->type == 0) {
            return $ret;
        } elseif ($this->type == 1) {
            if (!is_writable($this->cacheDir)) {
                return false;
            }
            $files = scandir($this->cacheDir);
            foreach ($files as $val) {
                if($val!=='.'&&$val!=='..'){@unlink($this->cacheDir . "/" . $val);}
            }
        } elseif ($this->type == 2) {
            $ret = $this->cache->flushAll();
        }
        return $ret;
    }
    
    public static function _time($time)
    {
        if (preg_match("/^(\d+)(.*?)$/i", $time, $key)) {

            if (sizeof($key) < 2) {
                return 0;
            }

            switch ($key[2]) {
                case "d":
                    return $key[1] * 24 * 60 * 60 ;
                case "h":
                    return $key[1] * 60 * 60 ;
                case "m":
                    return $key[1] * 60 ;
                case "s":
                    return $key[1] ;
                default:
                    return $key[1];
            }
        } else {
            return 0;
        }
    }

    private function error($line, $msg)
    {

        die("出错文件：" . __file__ . "/n出错行：$line/n错误信息：$msg");
    }
}

