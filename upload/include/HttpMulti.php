<?php

/**
 * Description of HttpMulti
 *
 * @author nohacks
 
  $response = HttpMulti::run(['http://www.baidu.com','http://www.baidu.com']);

  $response = HttpMulti::run('http://www.baidu.com');
 */

 /* 测试代码     
$res = HttpMulti::run([
    'https://v.youku.com/v_show/id_XNDMxNjY5MjY0NA==.html',
    'https://www.iqiyi.com/v_2bdys6ifuwg.html',
    'https://v.qq.com/x/cover/mzc00200fbyr29e/p4100nfp6q3.html']
);

foreach ($res as $value) {
    if (preg_match('/\<title\>(.*?)\<\/title\>/', $value, $match)) {
        echo "成功获取视频：{$match[1]}\n";
    } else {
        echo "视频信息解析失败\n";
    }
}
 */


class HttpMulti {

    //获取多个url，返回数组
    public static function run($urls,$concurrency=5) {
        $response = new VideoCrawler();
        $response->setConcurrency($concurrency); // 设置并发数
       if(is_array($urls)) {
            foreach ($urls as $val) {
                $response->addRequest($val);
            }
        $results = $response->execute();
        $res = array();
        foreach ($results as $val) {$res[] = $val['content'];}
        
        } else {
             $response->addRequest($urls);
             $results = $response->execute();
             $res = $results[0]['content'];
             if(!$res){
                 $res=self::getContents($urls);  
             }

        }
       
        return $res;
    }
    
        
private static function getContents($url) {
    
     $arrContextOptions=array(
        "ssl"=>[
           "verify_peer"=>false,
           "verify_peer_name"=>false,
           "allow_self_signed"=>true,
           'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
       ],
         
        'http'=>[
             'method' => 'GET',
             'timeout' => 10,
             'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36\r\n"    
             ]
     );

     $ret=file_get_contents($url, false, stream_context_create($arrContextOptions));
     
     return $ret;
  
}


    
    
    
    
    
}

class VideoCrawler {

    private $multiHandle;
    private $handles = [];
    private $options = [
        'timeout' => 30,
        'max_redirects' => 2,
        'concurrency' => 5, //并发数
        'retry' => 2,
        'verify_ssl' => false,
        'ip_type' => 'china',
        'referer_strategy' => 'mixed'
    ];
    private $proxyPool = [];
    private $userAgents = [];
    private $referers = [];
    private $results = [];
    private $queue = [];
    private $headers = [];
    private $cookies = [];
    private $requestDelays = [];
    private $commonCookies = [
        'PHPSESSID', '_ga', '_gid', '_gat', 'ci_session',
        'csrftoken', 'sessionid', 'UID', 'SID'
    ];

    public function __construct(array $options = []) {
        $this->options = array_merge($this->options, $options);
        $this->multiHandle = curl_multi_init();
        $this->initDefaultReferers();
        $this->initUserAgents();
    }

    private function initDefaultReferers() {
        $this->referers = [
            'https://www.baidu.com/s?wd=',
            'https://www.so.com/s?q=',
            'https://s.taobao.com/search?q=',
            'https://weibo.com/',
            'https://www.zhihu.com/',
            'https://v.qq.com/',
            'https://www.iqiyi.com/'
        ];
    }
    public function setConcurrency($num) {
        $this->options['concurrency'] = $num;
    }
    private function initUserAgents() {
        $this->userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.5 Mobile/15E148 Safari/604.1'
        ];
    }

    public function setProxyPool(array $proxies) {
        $this->proxyPool = $proxies;
    }

    public function addRequest($url, $callback = null, $options = []) {

        $this->queue[] = [
            'url' => $url,
            'callback' => $callback,
            'options' => $options,
            'retries' => 0,
            'delay' => mt_rand(1000000, 3000000)
        ];
    }

    //动态生成curl休眠
    public function formSleep($active, &$retryCount) {
        if ($active) {
            if (curl_multi_select($this->multiHandle, 0.1) === -1) {
                $retryCount++;
                $sleepTime = min(500 * $retryCount, 2000); // 最大2秒
                usleep($sleepTime);
                echo $sleepTime;
            } else {
                $retryCount = 0;
            }
        }
    }

    //执行队列
    public function execute() {
        $retryCount = 0;
        try {

            do {

                $this->initRequests();
                $active = false;
                $status = curl_multi_exec($this->multiHandle, $active);
                if ($status !== CURLM_OK) {
                    throw new RuntimeException("错误码：$status");
                }
                //等待I/O事件,动态调整休眠
                $this->formSleep($active, $retryCount);

                while ($done = curl_multi_info_read($this->multiHandle)) {
                    $this->processResponse($done);
                    curl_multi_remove_handle($this->multiHandle, $done['handle']);
                    curl_close($done['handle']);
                    unset($this->handles[(int) $done['handle']]);
                }
            } while (($active && $status == CURLM_OK) || !empty($this->queue));

            curl_multi_close($this->multiHandle);
        } catch (RuntimeException $e) {

            // 紧急清理资源
            foreach ($this->handles as $ch) {
                curl_multi_remove_handle($this->multiHandle, $ch);
                curl_close($ch);
            }
            curl_multi_close($this->multiHandle);
            throw $e; // 重新抛出异常
        }

        //数组按时间戳排序
        return $this->sortResults();;
    }

    //数组按时间戳排序
    private function sortResults() {
        $this->results= array_map(function ($value) {
            if (!empty($value['url'])) {
                $delay = $this->requestDelays[$value['url']];
                $value['delay'] = $delay;
            }
            return $value;
        }, $this->results);

        $delay = array_column($this->results, 'delay');
        array_multisort($delay, SORT_ASC, $this->results);
        return $this->results;
    }

    private function initRequests() {
        while (count($this->handles) < $this->options['concurrency'] && !empty($this->queue)) {
             //从等待队列中移除
            $task = array_shift($this->queue);
            $ch = $this->createHandle($task);
             //添加到工作队列
            $this->handles[(int) $ch] = $task;
            //添加到批处理
            curl_multi_add_handle($this->multiHandle, $ch);
            //添加到时间戳队列,用于排序
            $this->requestDelays[$task['url']] = microtime(true);
        }
    }

    //创建cURL句柄
    private function createHandle($task) {
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $task['url'],
            CURLOPT_RETURNTRANSFER => true, //返回字符串，而非直接输出到屏幕上
            CURLOPT_AUTOREFERER => true, //当Location:重定向时，自动设置header中的Referer:信息
            CURLOPT_FOLLOWLOCATION => true, //跟踪重定向页面  
            CURLOPT_MAXREDIRS => 5, //最大重定向跟踪次数
            CURLOPT_AUTOREFERER => true, //当Location:重定向时，自动设置header中的Referer:信息
            CURLOPT_POST => FALSE, //默认选择GET的方式发送
            CURLOPT_TIMEOUT => $this->options['timeout'], //设置curl允许执行的最长秒数
            CURLOPT_CONNECTTIMEOUT => 10, //连接超时时间 默认为10s
            CURLOPT_ENCODING => "", //HTTP请求头中"Accept-Encoding"的值，为空发送所有支持的编码类型,解决网页乱码问题
            CURLOPT_SSL_VERIFYPEER => false, //不验证服务器的SSL证书
            CURLOPT_SSL_VERIFYHOST => 0, //不检查证书中是否设置域名
            //CURLOPT_SSLVERSION=>3,
            CURLINFO_HEADER_OUT => true, //获取头信息 
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0, //设置 http 协议版本
            CURLOPT_HTTPHEADER => $this->generateHeaders($task['url']),
            //CURLOPT_COOKIE => $this->generateCookies(),
            CURLOPT_HEADER => false,
        ];

        if (!empty($this->proxyPool)) {
            $proxy = $this->getRandomProxy();
            $options['CURLOPT_PROXY'] = $proxy;
            if (strpos($proxy, 'socks5://') === 0) {
                $options['CURLOPT_PROXYTYPE'] = CURLPROXY_SOCKS5;
            }
        }

        curl_setopt_array($ch, $options);
        return $ch;
    }

    private function generateHeaders($url) {
        $headers = [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language: zh-CN,zh;q=0.9,en;q=0.8',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'DNT: 1',
            'Upgrade-Insecure-Requests: 1',
            'Sec-Fetch-Dest: document',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-Site: cross-site',
            'X-Forwarded-For: ' . $this->generateChinaIP(),
            'X-Real-IP: ' . $this->generateChinaIP(),
            'Referer: ' . $this->generateReferer($url),
            'User-Agent: ' . $this->getRandomUserAgent()
        ];

        return array_merge($this->headers, $headers);
    }

   
    
   

      private function generateCookies() {
        $cookies = [
            '__ysuid' => time().mt_rand(100,999),
            '__ysns' => mt_rand(1,5),
            '_m_h5_tk' => substr(md5(microtime()), 0, 32),
            '_m_h5_tk_enc' => substr(md5(microtime()), 0, 32),
            'cna' => $this->generateCnaCode(),
        ];

        foreach ($this->commonCookies as $name) {
            $cookies[$name] = bin2hex(random_bytes(8));
        }

        $cookieArray = [];
        foreach ($cookies as $name => $value) {
            $cookieArray[] = "$name=$value";
        }
        return implode('; ', $cookieArray);
    }
    
    private function generateCnaCode() {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        return substr(str_shuffle($chars), 0, 2) . '_' . substr(md5(microtime()), 0, 16);
    }

    private function generateChinaIP() {
        $chinaIPRanges = [
            [607649792, 608174079],
            [1038614528, 1039007743],
            [1783627776, 1784676351],
            [2035023872, 2035154943],
            [2078801920, 2079064063]
        ];
        $range = $chinaIPRanges[array_rand($chinaIPRanges)];
        return long2ip(mt_rand($range[0], $range[1]));
    }

    private function generateReferer($url) {
        $parsed = parse_url($url);
        $domain = $parsed['host'] ?? 'youku.com';

        if (mt_rand(0, 1)) {
            $paths = ['/', '/index', '/channel', '/profile'];
            return 'https://' . $domain . $paths[array_rand($paths)];
        }
        return $this->referers[array_rand($this->referers)];
    }

    private function processResponse($done) {
        if (!isset($done['handle']))
            return;

        $ch = $done['handle'];
        $task = $this->handles[(int) $ch] ?? null;
        if (!$task)
            return;

        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        $content = curl_multi_getcontent($ch);

        $result = [
            'content' => $this->validateContent($content),
            'info' => $info,
            'error' => $error,
            'url' => $task['url'],
            'proxy' => $task['options']['proxy'] ?? null,
            'referer' => $this->findRefererHeader($info['request_header'] ?? '')
        ];

        if ($error || ($info['http_code'] ?? 0) >= 400) {
            if ($task['retries'] < $this->options['retry']) {
                $task['retries']++;
                array_unshift($this->queue, $task);
            } else {
                $this->results[] = $result;
            }
        } else {
            $this->results[] = $result;
            if ($task['callback']) {
                call_user_func($task['callback'], $result);
            }
        }
    }

    private function validateContent($content) {
        if (strpos($content, '人机验证') !== false ||
                strpos($content, 'security_check') !== false) {
            throw new Exception('Anti-spam verification detected');
        }
        return $content;
    }

    private function findRefererHeader($headers) {
        foreach (explode("\n", (string) $headers) as $header) {
            if (stripos($header, 'Referer:') === 0) {
                return trim(substr($header, 8));
            }
        }
        return null;
    }

    private function getRandomProxy() {
        return $this->proxyPool[array_rand($this->proxyPool)];
    }

    private function getRandomUserAgent() {
        return $this->userAgents[array_rand($this->userAgents)];
    }
}


  