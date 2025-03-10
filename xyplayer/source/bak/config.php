<?php
$CONFIG=array (
  'ver' => '4.06',
  'user' => 'admin',
  'pass' => '7fef6171469e80d32c0559f88b377245',
  'TITLE' => 'XyPlayer 智能解析 X4',
  'resou' => '飞驰人生|流浪地球|绿皮书|疯狂的外星人',
  'sitetime' => '2014/05/22 14:30:00',
  'keywords' => 'vip视频解析,vip视频在线解析,vip解析,万能vip视频解析,vip视频全能解析,vip视频,手机vip视频解析,手机在线解析vip视频,优酷vip解析,爱奇艺vip解析,腾讯vip解析,乐视vip解析,芒果vip解析',
  'description' => 'XyPlayer 智能解析为您免费解析主流视频网站的VIP视频,支持爱奇艺、腾讯、优酷、乐视、芒果、搜狐、PPTV等等，可搜索最新的免费福利视频、电影和电视剧资源，欢迎使用！',
  'HEADER' => 'PG1ldGEgaHR0cC1lcXVpdj0iQWNjZXNzLUNvbnRyb2wtQWxsb3ctT3JpZ2luIiBjb250ZW50PSIqIj48IS0tIOWFgeiuuOi3qOWfn+iuv+mXriAtLT4KPCEtLSAgPG1ldGEgbmFtZT0icmVmZXJyZXIiIGNvbnRlbnQ9Im5ldmVyIj4g5Y+R6YCBcmVmZXJyZXLvvIznqoHnoLQ0MDPpmZDliLYs57uV6L+H6Ziy55uX6ZO+ICAtLT4KPG1ldGEgaHR0cC1lcXVpdj0icHJhZ21hIiBjb250ZW50PSJuby1jYWNoZSIgLz48bWV0YSBodHRwLWVxdWl2PSJleHBpcmVzIiBjb250ZW50PSIwIiAvPiAgICA8IS0tIOS4jee8k+WtmOe9kemhtSAtLT4K',
  'API_PATH' => 'api.php',
  'ROOT_PATH' => '',
  'templets' => 
  array (
    'off' => '',
    'html' => 'html',
    'css' => '',
    'pc' => 'byg',
    'wap' => 'default',
  ),
  'plus' => 
  array (
    'weixin' => 
    array (
      'off' => '1',
      'title' => 'VIP影视',
      'api' => 'http://parse.xymov.net',
      'token' => 'weixin',
      'pic' => 'http://parse.xymov.net/plus/weixin/play.jpg',
      'book' => 'http://www.xymov.net/book.htm',
      'num' => '5',
      'jmp_off' => '0',
      'msg_send' => '欢迎关注,本公众号提供在线影视观看,免广告看VIP视频，持续关注，精彩多多。
输入格式：
【电影名】,  如:西游记 即可在线观看!
【视频网址】,支持爱奇艺,腾讯,优酷等各大视频网站无等待广告免VIP播放。
【帮助】 显示帮助信息
【留言】打开留言本，留言求片。',
      'msg_not' => '资源未找到,点击图片留言反馈! ',
      'msg_help' => '欢迎关注,输入格式：
【电影名】,  如:西游记 即可在线观看!
【视频网址】,支持爱奇艺,腾讯,优酷等各大视频网站无等待广告免VIP播放。
【帮助】 显示帮助信息
【留言】打开留言本，留言求片。',
    ),
    'app' => 
    array (
      'off' => '1',
      'token' => 'app',
      'title' => 'VIP影视',
      'home' => 'http://v.nohacks.cn',
      'search' => 'http://m.iqiyi.com/search.html?&key=',
      'su' => 'http://suggestion.baidu.com/su?wd=',
      'top' => 
      array (
        'value' => 'https://www.iqiyi.com/ranks/all',
        'key' => 'name:"(.*?)",pageUrl:".*?"',
      ),
      'update' => 
      array (
        'ver' => '3.0',
        'info' => '更新如下：
1.优化界面，修复BUG;
2.搜索栏支持打开网址;',
        'url' => '',
      ),
      'ua' => 'vipvod/3.0(xysoft:Android)',
      'sites' => 
      array (
        0 => 
        array (
          'name' => '剧集线路1',
          'api' => 'https://parse.xymov.net/?url=',
        ),
        1 => 
        array (
          'name' => '剧集线路2',
          'api' => 'https://z1.m1907.cn/?jx=',
        ),
        2 => 
        array (
          'name' => '高清线路1',
          'api' => 'https://www.jiexila.com/?url=',
        ),
        3 => 
        array (
          'name' => '高清线路2',
          'api' => 'https://jx.618g.com/?url=',
        ),
      ),
      'start' => '0',
    ),
  ),
  'socode' => 
  array (
    'top_off' => '1',
    'diy_off' => '1',
    'diy_val' => 'PCEtLSAgICAg6Ieq5a6a5LmJIOeDremXqOaQnOe0oiAgIAoKPGZvbnQgZmFjZT0idmVyZGFuYSIgc3R5bGU9ImNvbG9yOiM1MGIyYzg7Ij7ng63pl6jmkJzntKLvvJo8L2ZvbnQ+Cgo8YSBocmVmPSJqYXZhc2NyaXB0OnZvaWQoMCk7IiBvbmNsaWNrPSJ0b3AubG9jYXRpb24uaHJlZj0nLi8/d2Q9Jyt0aGlzLmlubmVySFRNTDsiPuWkjeS7h+iAheiBlOebnzwvYT4KPGEgaHJlZj0iamF2YXNjcmlwdDp2b2lkKDApOyIgb25jbGljaz0idG9wLmxvY2F0aW9uLmhyZWY9Jy4vP3dkPScrdGhpcy5pbm5lckhUTUw7Ij7mnIDlpb3nmoTmiJHku6w8L2E+Cjxici8+PGJyLz4KCue7k+adnyAgIC0tPgoKPCEtLSAgICAg6Ieq5a6a5LmJIOWFtuWugyAgICAtLT4KPGZvbnQgZmFjZT0idmVyZGFuYSIgc3R5bGU9ImNvbG9yOiM1MGIyYzg7Ij7op6PmnpDmlK/mjIHvvJrkvJjphbfjgIHniLHlpYfoibrjgIHohb7orq/jgIHoipLmnpzjgIHkuZDop4bjgIHmkJzni5DjgIFNUDTjgIFNM1U444CBRkxW562J562JPC9mb250Pjxici8+PGJyLz4KCg==',
    'not_val' => '6Imy5oOFfOa3q3znp7185by65aW4fOWPpuexu3zkubHkvKZ85ZK75Zi/fOiOieWTpXxBVg==',
    'not_off' => '1',
  ),
  'cache' => 
  array (
    'type' => '1',
    'ip' => '127.0.0.1',
    'pass' => '',
    'prot' => '6379',
    'prefix' => 'parse_',
    'time' => '24h',
  ),
  'BOOK_INFO' => 
  array (
    'off' => '0',
    'info' => 'PGZvbnQgY29sb3I9IiMwMEZGMDAiPuWmguaenOaSreaUvuWksei0pe+8jOivt+WIh+aNouS4jeWQjOe6v+i3ryHkupHmkq3mlL7lt7LmlK/mjIHnvJPlrZjnp5LliqDovb3vvIzmrKLov47kvb/nlKghPC9mb250Pg==',
  ),
  'timecookie' => '24',
  'timeout' => '10',
  'from_timeout' => '5',
  'BLACKLIST' => 
  array (
    'off' => '1',
    'match' => 
    array (
      0 => 
      array (
        'off' => '0',
        'type' => '0',
        'for' => '',
        'val' => 
        array (
          0 => 'localhost',
        ),
        'black' => '0',
        'name' => '授权网站',
        'match' => '0',
        'num' => '100',
      ),
      1 => 
      array (
        'off' => '0',
        'type' => '1',
        'val' => 
        array (
          0 => 'av.com',
        ),
        'black' => '1',
        'name' => '视频黑名单',
        'match' => '1',
        'num' => '10',
      ),
      2 => 
      array (
        'off' => '0',
        'type' => '0',
        'val' => 
        array (
          0 => 'av.com',
        ),
        'black' => '2',
        'name' => '域名黑名单',
        'match' => '1',
        'num' => '6',
      ),
      3 => 
      array (
        'off' => '0',
        'type' => '3',
        'val' => 
        array (
          0 => '127.0.0.1',
        ),
        'black' => '0',
        'name' => 'IP黑名单',
        'match' => '1',
        'num' => '100',
      ),
      4 => 
      array (
        'off' => '0',
        'type' => '2',
        'val' => 
        array (
          0 => 'xysoft',
        ),
        'black' => '0',
        'name' => '授权APP',
        'match' => '0',
        'num' => '110',
      ),
      5 => 
      array (
        'off' => '0',
        'type' => '1',
        'for' => '',
        'val' => 
        array (
          0 => '.*?qq.com/x/cover/brq7blajvjhrcit.*?(?#流浪地球)',
          1 => '.*?qq.com/x/cover/wu1e7mrffzvibjy.*?',
        ),
        'black' => '6',
        'name' => '开启版权保护',
        'match' => '1',
        'num' => '100',
      ),
      6 => 
      array (
        'off' => '0',
        'type' => '0',
        'for' => '',
        'val' => 
        array (
          0 => '',
        ),
        'black' => '7',
        'name' => '开启框架访问',
        'match' => '1',
        'num' => '100',
      ),
      7 => 
      array (
        'off' => '1',
        'type' => '0',
        'for' => 'api.php|dmku/index.php|mov/data/index.php|/video/m3u8.php',
        'val' => 
        array (
          0 => '$host',
        ),
        'black' => '8',
        'name' => '开启API防盗',
        'match' => '0',
        'num' => '80',
      ),
      8 => 
      array (
        'off' => '1',
        'type' => '4',
        'for' => 'api.php',
        'val' => 
        array (
          0 => 'pass:123456',
        ),
        'black' => '8',
        'name' => '密匙访问',
        'match' => '0',
        'num' => '100',
      ),
      9 => 
      array (
        'off' => '0',
        'type' => '4',
        'for' => '/mov/index.php',
        'val' => 
        array (
          0 => 'pass:123456',
        ),
        'black' => '0',
        'name' => '影视大全限制',
        'match' => '0',
        'num' => '100',
      ),
    ),
    'black' => 
    array (
      0 => 
      array (
        'type' => '1',
        'action' => '1',
        'info' => 'ZWNobyAi5pys56uZ5bey5byA5ZCv6Ziy55uX6ZO+77yM6I635Y+W5o6I5p2D6K+36IGU57O75pys56uZ566h55CG5ZGYIjs=',
        'name' => '提示防盗链',
      ),
      1 => 
      array (
        'type' => '1',
        'action' => '1',
        'info' => 'ZWNobyAi55uu5qCH572R56uZ5raJ5auM6Z2e5rOV5L+h5oGvLOacjeWKoeWZqOW3suaLkue7neino+aekCI7',
        'name' => '提示非法信息',
      ),
      2 => 
      array (
        'type' => '1',
        'action' => '1',
        'info' => 'ZWNobyAi55uu5qCH572R56uZ5Zyo6buR5ZCN5Y2V5LitLOivt+iBlOezu+e9keermeeuoeeQhuWRmOino+mZpO+8gSI7',
        'name' => '提示黑名单',
      ),
      3 => 
      array (
        'type' => '1',
        'action' => '1',
        'info' => 'ZWNobyAi5pys56uZ5bey5byA5ZCv6Ziy55uX6ZO+77yM6I635Y+W5o6I5p2D6K+36IGU57O75pys56uZ566h55CG5ZGYIjsKICAgICAgIGhlYWRlcigiUmVmcmVzaDozO3VybD1odHRwOi8vbm9oYWNrcy5jbiIpOw==',
        'name' => '跳转首页',
      ),
      4 => 
      array (
        'type' => '1',
        'action' => '1',
        'info' => 'aGVhZGVyKCJIVFRQLzEuMSA0MDQgTm90IEZvdW5kIik7ZXhpdCgiNDA0LOaWh+S7tuacquaJvuWIsCIpOw==',
        'name' => '提示404',
      ),
      5 => 
      array (
        'type' => '0',
        'action' => '0',
        'info' => 'PHNjcmlwdD4gCnZhciBfaG10ID0gX2htdCB8fCBbXTsKICAgKGZ1bmN0aW9uKCkgewogICAgdmFyIGhtID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgic2NyaXB0Iik7CiAgICBobS5zcmMgPSAiaHR0cHM6Ly9obS5iYWlkdS5jb20vaG0uanM/ZGVhNmJhZDEwNTc4NjFhOGYwZWMyYjZmODMzMmVlYzEiOwogICAgdmFyIHMgPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5VGFnTmFtZSgic2NyaXB0IilbMF07IAogICAgcy5wYXJlbnROb2RlLmluc2VydEJlZm9yZShobSxzKTsKfSkoKTsKPC9zY3JpcHQ+',
        'name' => '植入广告',
      ),
      6 => 
      array (
        'type' => '1',
        'action' => '1',
        'info' => 'ZWNobyAi55uu5qCH6KeG6aKR5Y+X54mI5p2D5L+d5oqkLOacjeWKoeWZqOW3suaLkue7neino+aekCI7',
        'name' => '提示版权保护',
      ),
      7 => 
      array (
        'type' => '1',
        'action' => '1',
        'info' => 'ZWNobyAiPGZvbnQgc3R5bGU9J2NvbG9yOnJlZDsnPuS4jeaUr+aMgeebtOaOpeiuv+mXrizor7flnKjmoYbmnrbkuK3osIPnlKjmnKzop6PmnpA8L2ZvbnQ+Ijs=',
        'name' => '提示框架访问',
      ),
      8 => 
      array (
        'type' => '1',
        'action' => '1',
        'info' => 'ZWNobyAiPGZvbnQgc3R5bGU9J2NvbG9yOnJlZDsnPuivt+WLv+mdnuazleiwg+eUqO+8jOiOt+WPluaOiOadg+ivt+iBlOezu+acrOermeeuoeeQhuWRmDwvZm9udD4iOwo=',
        'name' => '提示非法调用',
      ),
    ),
    'adblack' => 
    array (
      'match' => 
      array (
        0 => 
        array (
          'off' => '1',
          'name' => '过滤站长统计',
          'target' => 'Lio=',
          'ref' => '',
          'num' => '100',
          'val' => 
          array (
            '<script.*?cnzz.com.*?</script>' => '',
          ),
        ),
      ),
      'name' => 'jx',
    ),
    'type' => NULL,
  ),
  'NULL_URL' => 
  array (
    'type' => '0',
    'url' => 'so.php',
    'info' => 'IDxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+CiAgICBIMXttYXJnaW46MTAlIDAgYXV0bzsgY29sb3I6I0M3NjM2QzsgdGV4dC1hbGlnbjpjZW50ZXI7IGZvbnQtZmFtaWx5OiBNaWNyb3NvZnQgSmhlbmdoZWk7fQogICAgcHtmb250LXNpemU6IDEuMnJlbTsvKjEuMiDDlyAxMHB4ID0gMTJweCAqLzt0ZXh0LWFsaWduOmNlbnRlcjsgZm9udC1mYW1pbHk6IE1pY3Jvc29mdCBKaGVuZ2hlaTt9CiAgICA8L3N0eWxlPiAgCiAgIDxoMT7or7floavlhpl1cmzlnLDlnYA8L2gxPgogICA8cD7mnKzop6PmnpDmjqXlj6Pku4XnlKjkuo7lrabkuaDkuqTmtYHvvIznm5fnlKjlv4XnqbbvvIF+PC9wPg==',
  ),
  'HEADER_CODE' => '',
  'FOOTER_CODE' => '',
  'LINK_URL' => 
  array (
    0 => 
    array (
      'off' => '0',
      'type' => '1',
      'api' => '1',
      'match' => 'e1wkXC5wb3N0XCgiKC4rPykifQ==',
      'num' => '999',
      'name' => '官方CMS插件接口',
      'path' => 'http://mov.nohacks.cn/parse/api.php',
      'shell' => '',
      'html' => '',
      'fields' => 'IHVybD0kdXJs',
      'strtr' => 'JHVybA==',
      'cookie' => '',
      'proxy' => '',
      'val_off' => '0',
      'header' => NULL,
      'add' => NULL,
      'val' => NULL,
    ),
    1 => 
    array (
      'off' => 0,
      'type' => '0',
      'api' => '0',
      'match' => 'e1wkXC5wb3N0XCgiKC4rPykiLChcey4qXH0pLH0=',
      'num' => '100',
      'name' => '思古解析',
      'path' => 'https://api.bbbbbb.me/zy/?url=',
      'shell' => 'JHVybD1iYXNlNjRfZW5jb2RlKCR1cmwpOwoka2V5PSRfQ09PS0lFWydrZXknXTs=',
      'html' => 'PGh0bWw+CjxoZWFkPgo8c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCIgc3JjPSJodHRwczovL2Nkbi5ib290Y3NzLmNvbS9jcnlwdG8tanMvMy4xLjkvY3J5cHRvLWpzLmpzIj48L3NjcmlwdD4KPHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiIHNyYz0iLi4vaW5jbHVkZS9jbGFzcy5jb29raWUuanMiPjwvc2NyaXB0Pgo8L2hlYWQ+Cjxib2R5Pgo8c2NyaXB0Pgp2YXIgX18weDJiYmNiID0gWydNUmZDaHc9PScsICdZMExEb01LU1FYUENvY09HJywgJ3dwZ1h3by9EaXNLV1lNT3BQUT09JywgJ3dwd013cGpEbThLUk04S3BmTUtSd3FIQ25UYkRnekxEbk1PYndwN0Rzc09CUXNLdXdwNVhFeFBDaFNOdkdWUmthY0svd3BERHFBNU8nLCAndzVFOUJzT0QnLCAnd3FURHM4T0x3NVFvJywgJ0Q4S0xjY0s2YkdoVU5nPT0nLCAnQmNLTXdvTEN1Zz09JywgJ3c2N0RxY09hdzVsaEhXY0cnLCAnQlNiRGdNS0R3cTNDaFhNV1ZjT1R3cnA3d29RPScsICdWaUhDdE1PT0RzSzV3NUZxZUN2Q3IzNXh3cGdVdzdBPScsICd3N1J4d3B2RG9rM0Nvc09CRTMvQ24ycE13cVV2d3JQRG5BPT0nLCAnd3JrOHc1az0nLCAnYXNPUndybz0nLCAnY3pSMHc2b2UnLCAnV2NPbHc3VT0nLCAnd3BIRHFzSy93b0U9JywgJ3dvUVp3cDdEbU1LSCcsICdjeUZPSlE9PScsICdTc09Xd3B3PSddOwooZnVuY3Rpb24oXzB4NGFmMTRhLCBfMHg1YzIyN2IpIHsKCXZhciBfMHg1OTRjZWQgPSBmdW5jdGlvbihfMHg0MWMxODEpIHsKCQkJd2hpbGUgKC0tXzB4NDFjMTgxKSB7CgkJCQlfMHg0YWYxNGFbJ3B1c2gnXShfMHg0YWYxNGFbJ3NoaWZ0J10oKSk7CgkJCX0KCQl9OwoJXzB4NTk0Y2VkKCsrXzB4NWMyMjdiKTsKfShfXzB4MmJiY2IsIDB4MWFjKSk7CnZhciBfMHg4MWJiID0gZnVuY3Rpb24oXzB4YmZhODYwLCBfMHg0ZmI0MTIpIHsKCQlfMHhiZmE4NjAgPSBfMHhiZmE4NjAgLSAweDA7CgkJdmFyIF8weDIxMGI5NSA9IF9fMHgyYmJjYltfMHhiZmE4NjBdOwoJCWlmIChfMHg4MWJiWydpbml0aWFsaXplZCddID09PSB1bmRlZmluZWQpIHsKCQkJKGZ1bmN0aW9uKCkgewoJCQkJdmFyIF8weDUyNjMzYyA9IHR5cGVvZiB3aW5kb3cgIT09ICd1bmRlZmluZWQnID8gd2luZG93IDogdHlwZW9mIHByb2Nlc3MgPT09ICdvYmplY3QnICYmIHR5cGVvZiByZXF1aXJlID09PSAnZnVuY3Rpb24nICYmIHR5cGVvZiBnbG9iYWwgPT09ICdvYmplY3QnID8gZ2xvYmFsIDogdGhpczsKCQkJCXZhciBfMHgyOTVjZTQgPSAnQUJDREVGR0hJSktMTU5PUFFSU1RVVldYWVphYmNkZWZnaGlqa2xtbm9wcXJzdHV2d3h5ejAxMjM0NTY3ODkrLz0nOwoJCQkJXzB4NTI2MzNjWydhdG9iJ10gfHwgKF8weDUyNjMzY1snYXRvYiddID0gZnVuY3Rpb24oXzB4NGYyMWM5KSB7CgkJCQkJdmFyIF8weDU5YzgwMiA9IFN0cmluZyhfMHg0ZjIxYzkpWydyZXBsYWNlJ10oLz0rJC8sICcnKTsKCQkJCQlmb3IgKHZhciBfMHg1MWJjMTEgPSAweDAsIF8weDM1MjM3OSwgXzB4MmU4N2NiLCBfMHgyOGQwYjAgPSAweDAsIF8weDVhNzhjNSA9ICcnOyBfMHgyZTg3Y2IgPSBfMHg1OWM4MDJbJ2NoYXJBdCddKF8weDI4ZDBiMCsrKTt+XzB4MmU4N2NiICYmIChfMHgzNTIzNzkgPSBfMHg1MWJjMTEgJSAweDQgPyBfMHgzNTIzNzkgKiAweDQwICsgXzB4MmU4N2NiIDogXzB4MmU4N2NiLCBfMHg1MWJjMTErKyAlIDB4NCkgPyBfMHg1YTc4YzUgKz0gU3RyaW5nWydmcm9tQ2hhckNvZGUnXSgweGZmICYgXzB4MzUyMzc5ID4+ICgtMHgyICogXzB4NTFiYzExICYgMHg2KSkgOiAweDApIHsKCQkJCQkJXzB4MmU4N2NiID0gXzB4Mjk1Y2U0WydpbmRleE9mJ10oXzB4MmU4N2NiKTsKCQkJCQl9CgkJCQkJcmV0dXJuIF8weDVhNzhjNTsKCQkJCX0pOwoJCQl9KCkpOwoJCQl2YXIgXzB4MTU5YTgzID0gZnVuY3Rpb24oXzB4NDNlZmE0LCBfMHgyNGY2YjMpIHsKCQkJCQl2YXIgXzB4NThlNDQ4ID0gW10sCgkJCQkJCV8weDU4MGYzNCA9IDB4MCwKCQkJCQkJXzB4MTU0MDE3LCBfMHgxNDI4MzggPSAnJywKCQkJCQkJXzB4Mjc3MTE5ID0gJyc7CgkJCQkJXzB4NDNlZmE0ID0gYXRvYihfMHg0M2VmYTQpOwoJCQkJCWZvciAodmFyIF8weDQ4YTZlZSA9IDB4MCwgXzB4MTdiYzE0ID0gXzB4NDNlZmE0WydsZW5ndGgnXTsgXzB4NDhhNmVlIDwgXzB4MTdiYzE0OyBfMHg0OGE2ZWUrKykgewoJCQkJCQlfMHgyNzcxMTkgKz0gJyUnICsgKCcwMCcgKyBfMHg0M2VmYTRbJ2NoYXJDb2RlQXQnXShfMHg0OGE2ZWUpWyd0b1N0cmluZyddKDB4MTApKVsnc2xpY2UnXSgtMHgyKTsKCQkJCQl9CgkJCQkJXzB4NDNlZmE0ID0gZGVjb2RlVVJJQ29tcG9uZW50KF8weDI3NzExOSk7CgkJCQkJZm9yICh2YXIgXzB4M2U3NjZmID0gMHgwOyBfMHgzZTc2NmYgPCAweDEwMDsgXzB4M2U3NjZmKyspIHsKCQkJCQkJXzB4NThlNDQ4W18weDNlNzY2Zl0gPSBfMHgzZTc2NmY7CgkJCQkJfQoJCQkJCWZvciAoXzB4M2U3NjZmID0gMHgwOyBfMHgzZTc2NmYgPCAweDEwMDsgXzB4M2U3NjZmKyspIHsKCQkJCQkJXzB4NTgwZjM0ID0gKF8weDU4MGYzNCArIF8weDU4ZTQ0OFtfMHgzZTc2NmZdICsgXzB4MjRmNmIzWydjaGFyQ29kZUF0J10oXzB4M2U3NjZmICUgXzB4MjRmNmIzWydsZW5ndGgnXSkpICUgMHgxMDA7CgkJCQkJCV8weDE1NDAxNyA9IF8weDU4ZTQ0OFtfMHgzZTc2NmZdOwoJCQkJCQlfMHg1OGU0NDhbXzB4M2U3NjZmXSA9IF8weDU4ZTQ0OFtfMHg1ODBmMzRdOwoJCQkJCQlfMHg1OGU0NDhbXzB4NTgwZjM0XSA9IF8weDE1NDAxNzsKCQkJCQl9CgkJCQkJXzB4M2U3NjZmID0gMHgwOwoJCQkJCV8weDU4MGYzNCA9IDB4MDsKCQkJCQlmb3IgKHZhciBfMHgxOTYyYjMgPSAweDA7IF8weDE5NjJiMyA8IF8weDQzZWZhNFsnbGVuZ3RoJ107IF8weDE5NjJiMysrKSB7CgkJCQkJCV8weDNlNzY2ZiA9IChfMHgzZTc2NmYgKyAweDEpICUgMHgxMDA7CgkJCQkJCV8weDU4MGYzNCA9IChfMHg1ODBmMzQgKyBfMHg1OGU0NDhbXzB4M2U3NjZmXSkgJSAweDEwMDsKCQkJCQkJXzB4MTU0MDE3ID0gXzB4NThlNDQ4W18weDNlNzY2Zl07CgkJCQkJCV8weDU4ZTQ0OFtfMHgzZTc2NmZdID0gXzB4NThlNDQ4W18weDU4MGYzNF07CgkJCQkJCV8weDU4ZTQ0OFtfMHg1ODBmMzRdID0gXzB4MTU0MDE3OwoJCQkJCQlfMHgxNDI4MzggKz0gU3RyaW5nWydmcm9tQ2hhckNvZGUnXShfMHg0M2VmYTRbJ2NoYXJDb2RlQXQnXShfMHgxOTYyYjMpIF4gXzB4NThlNDQ4WyhfMHg1OGU0NDhbXzB4M2U3NjZmXSArIF8weDU4ZTQ0OFtfMHg1ODBmMzRdKSAlIDB4MTAwXSk7CgkJCQkJfQoJCQkJCXJldHVybiBfMHgxNDI4Mzg7CgkJCQl9OwoJCQlfMHg4MWJiWydyYzQnXSA9IF8weDE1OWE4MzsKCQkJXzB4ODFiYlsnZGF0YSddID0ge307CgkJCV8weDgxYmJbJ2luaXRpYWxpemVkJ10gPSAhISBbXTsKCQl9CgkJdmFyIF8weDJiNzU0NiA9IF8weDgxYmJbJ2RhdGEnXVtfMHhiZmE4NjBdOwoJCWlmIChfMHgyYjc1NDYgPT09IHVuZGVmaW5lZCkgewoJCQlpZiAoXzB4ODFiYlsnb25jZSddID09PSB1bmRlZmluZWQpIHsKCQkJCV8weDgxYmJbJ29uY2UnXSA9ICEhIFtdOwoJCQl9CgkJCV8weDIxMGI5NSA9IF8weDgxYmJbJ3JjNCddKF8weDIxMGI5NSwgXzB4NGZiNDEyKTsKCQkJXzB4ODFiYlsnZGF0YSddW18weGJmYTg2MF0gPSBfMHgyMTBiOTU7CgkJfSBlbHNlIHsKCQkJXzB4MjEwYjk1ID0gXzB4MmI3NTQ2OwoJCX0KCQlyZXR1cm4gXzB4MjEwYjk1OwoJfTsKCQoJdmFyIGtleV9iYXNlID0gXzB4ODFiYignMHgyJywgJ20wMU4nKTsKCXZhciBpdl9iYXNlID0gXzB4ODFiYignMHgzJywgJ1FoQ0InKTsKCXZhciBzaWd1ID0gZnVuY3Rpb24oXzB4ODYzZGM2KSB7CgkJCXZhciBfMHhkZDkxOTIgPSBDcnlwdG9KU1tfMHg4MWJiKCcweDQnLCAnJkxTMicpXShrZXlfYmFzZSk7CgkJCXZhciBfMHhhYmIyYmYgPSBDcnlwdG9KU1tfMHg4MWJiKCcweDUnLCAnNDdCaScpXVsnVXRmOCddW18weDgxYmIoJzB4NicsICckKG0hJyldKF8weGRkOTE5Mik7CgkJCXZhciBfMHg0YTQwZWIgPSBDcnlwdG9KU1tfMHg4MWJiKCcweDcnLCAnNipqIScpXVtfMHg4MWJiKCcweDgnLCAnTHhYcScpXVtfMHg4MWJiKCcweDknLCAnJkxTMicpXShpdl9iYXNlKTsKCQkJdmFyIF8weDUyNDM0MyA9IENyeXB0b0pTWydBRVMnXVsnZW5jcnlwdCddKF8weDg2M2RjNiwgXzB4YWJiMmJmLCB7CgkJCQknaXYnOiBfMHg0YTQwZWIsCgkJCQknbW9kZSc6IENyeXB0b0pTW18weDgxYmIoJzB4YScsICd4ZnBTJyldW18weDgxYmIoJzB4YicsICc3JGRUJyldLAoJCQkJJ3BhZGRpbmcnOiBDcnlwdG9KU1tfMHg4MWJiKCcweGMnLCAna1l6SCcpXVsnWmVyb1BhZGRpbmcnXQoJCQl9KTsKCQkJcmV0dXJuIF8weDUyNDM0M1tfMHg4MWJiKCcweGQnLCAnVFI3WScpXSgpOwoJCX07Cgp2YXIgc3RyPSRmaWVsZHM7CkNvb2tpZS5zZXQoImtleSIsc3RyLmtleSx7ZXhwaXJlczoiNXMiLHBhdGg6Ii8ifSk7CkNvb2tpZS51cGRhdGUoKTsKLy9jb25zb2xlLmxvZyhDb29raWUuZ2V0KCJrZXkiKSk7Cjwvc2NyaXB0PgoKPC9ib2R5Pgo8L2h0bWw+',
      'fields' => 'dXJsPSR1cmwma2V5PSRrZXk=',
      'strtr' => 'JHVybCwka2V5',
      'cookie' => '',
      'proxy' => '',
      'val_off' => '1',
      'header' => 
      array (
        'Content-Type' => 'application/x-www-form-urlencoded',
      ),
      'add' => NULL,
      'val' => 
      array (
        'url' => 'url',
        'code' => 'code',
        'play' => 'type',
      ),
    ),
    2 => 
    array (
      'off' => '0',
      'type' => '0',
      'api' => '0',
      'match' => 'e1wkXC5wb3N0XCgiKC4rPykiLChcey4qXH0pLH0=',
      'num' => '100',
      'name' => 'PPS解析',
      'path' => 'http://jx.arpps.com/pps/?url=',
      'shell' => 'JG1kNT0kX0NPT0tJRVsibWQ1Il07IAoka2V5PSRfQ09PS0lFWyJrZXkiXTsgCg==',
      'html' => 'PGh0bWw+CjxoZWFkPgo8c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCIgc3JjPSJodHRwOi8vanguYXJwcHMuY29tL3Bwcy9ja3BsYXllci9tZDUubWluLmpzIj48L3NjcmlwdD4KPHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiIHNyYz0iaHR0cDovL2p4LmFycHBzLmNvbS9wcHMvY2twbGF5ZXIvQXV0aENvZGUuanMiPjwvc2NyaXB0Pgo8c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCIgc3JjPSIuL2luY2x1ZGUvY29va2llLmpzIj48L3NjcmlwdD4KPC9oZWFkPgo8Ym9keT4KPHNjcmlwdD4KCnZhciBzdHI9JGZpZWxkczsKQ29va2llLnNldCgibWQ1IixzaWduKHN0ci5rZXkpLHtleHBpcmVzOiI1cyIscGF0aDoiLyJ9KTsKQ29va2llLnNldCgia2V5IixzdHIua2V5LHtleHBpcmVzOiI1cyIscGF0aDoiLyJ9KTsKQ29va2llLnVwZGF0ZSgpOwoKY29uc29sZS5sb2coc2lnbihzdHIua2V5KSk7CmNvbnNvbGUubG9nKHN0ci5rZXkpOwoKPC9zY3JpcHQ+Cgo8L2JvZHk+CjwvaHRtbD4K',
      'fields' => 'aWQ9JHVybCZtZDU9JG1kNSZrZXk9JGtleQ==',
      'strtr' => 'JHVybCwkbWQ1LCRrZXk=',
      'cookie' => '',
      'proxy' => '',
      'val_off' => '0',
      'header' => 
      array (
        'Content-Type' => 'application/x-www-form-urlencoded',
      ),
      'add' => NULL,
      'val' => 
      array (
        'url' => 'url',
      ),
    ),
    3 => 
    array (
      'off' => '1',
      'type' => '1',
      'api' => '1',
      'match' => 'e1wkXC5wb3N0XCgiKC4rPykifQ==',
      'num' => '100',
      'name' => 'm3u8.tv',
      'path' => 'https://json.m3u8.tv:7788/json.php',
      'shell' => '',
      'html' => '',
      'fields' => 'dXJsPSR1cmw=',
      'strtr' => 'JHVybA==',
      'cookie' => '',
      'proxy' => '',
      'val_off' => '0',
      'header' => NULL,
      'add' => 
      array (
        'type' => 'video',
      ),
      'val' => 
      array (
        'url' => 'url',
      ),
    ),
  ),
  'jx_url' => 
  array (
    0 => '剧集线路=>https://z1.m1907.cn/?jx=',
    1 => '高清线路=>https://www.jiexila.com/?url=',
    2 => '备用线路=>https://jx.618g.com/?url=',
  ),
  'jx_link' => 
  array (
    '视频搜索' => 'xyplay.href("so.php?url="+xyplay.url,true);',
    '影视大全' => 'xyplay.href("mov");',
  ),
  'live_url' => 
  array (
    '新的直播,http://www.hao123.com,default' => '',
    '1234,http://www.baidu.com,h5' => '',
  ),
  'play' => 
  array (
    'off' => 
    array (
      'yun' => '1',
      'link' => '1',
      'live' => '1',
      'help' => '1',
      'debug' => '1',
      'log' => '1',
      'autolist' => '0',
      'ckplay' => '1',
      'jmp' => '1',
      'autoline' => NULL,
      'autoflag' => '0',
      'mylink' => '1',
      'lshttps' => '0',
      'jx' => '1',
      'posterr' => '1',
      'submit' => '1',
      'allyun' => '1',
      'allsearch' => '1',
    ),
    'line' => 
    array (
      'pc' => 
      array (
        'line' => '1',
        'adtime' => '0',
        'adPage' => 'source/plug/pc.html',
        'info' => '正在加载中,请稍后....',
        'infotime' => '0',
        'wait' => '0',
      ),
      'wap' => 
      array (
        'line' => '1',
        'adtime' => '0',
        'adPage' => 'source/plug/pc.html',
        'info' => '正在加载中,请稍后....',
        'infotime' => '0',
        'wait' => '0',
      ),
      'all' => 
      array (
        'autoline' => 
        array (
          'off' => '0',
          'val' => 
          array (
            'v.qq.com' => '1',
            'iqiyi.com' => '3',
          ),
        ),
      ),
    ),
    'play' => 
    array (
      'pc' => 
      array (
        'player' => 'dmplayer',
        'autoplay' => '1',
        'player_diy' => 'https://cdn.bskchina.cn/m3u8.html?',
      ),
      'wap' => 
      array (
        'player' => 'dmplayer',
        'autoplay' => '1',
        'player_diy' => 'https://cdn.bskchina.cn/m3u8.html?',
      ),
      'all' => 
      array (
        'autoline' => 
        array (
          'off' => '0',
          'val' => 
          array (
            'iqiyi.com' => 'ckplayerx',
            'v.qq.com' => 'dplayer',
          ),
        ),
        'headtime' => NULL,
        'endtime' => NULL,
        'ver' => '1',
        'p2pinfo' => '0',
        'seektime' => '1',
        'logo_off' => '0',
        'logo_style' => 'bGVmdDowcHg7IHRvcDo1MHB4O21heC13aWR0aDoxMDBweDttYXgtaGVpZ2h0OjEwMHB4',
        'danmaku' => '1',
        0 => 
        array (
          'off' => '0',
          'val' => 
          array (
            'Xyplayer' => 'https://xymov.net',
          ),
        ),
        'contextmenu' => 
        array (
          'off' => '0',
          'val' => 
          array (
            'Xyplayer X4' => 'http://www.xymov.net',
          ),
        ),
      ),
    ),
    'all' => 
    array (
      'AppName' => 'xysoft|xyplayer',
      'ver' => 'XyPlayer 智能解析 X4.0.8正式版',
      'by' => '星源网络提供技术支持',
      'info' => '如果播放失败，请切换不同线路!',
      'decode' => 'IC8vICB2YXIgdG90YWw9IiI7Zm9yICh2YXIgaT0wO2k8MTAwMDAwMDtpKyspe3RvdGFsPSB0b3RhbCtpLnRvU3RyaW5nKCk7aGlzdG9yeS5wdXNoU3RhdGUoMCwwLHRvdGFsKTt9ICAgICAgLy/mrbvmnLrku6PnoIEKLy9sb2NhdGlvbi5ocmVmPSJodHRwOi8vbm9oYWNrcy5jbiI7ICAvL+i3s+i9rOe9keermQp4eXBsYXkuZWNobygiPGJyPjxicj48YnI+5qOA5rWL5Yiw6Z2e5rOV6LCD6K+VLOivt+WFs+mXreWQjuWIt+aWsOmHjeivlSEiKTsgIC8v55So5oi356qX5Y+j5pi+56S65L+h5oGvCnNldEludGVydmFsKCJkZWJ1Z2dlcjtjb25zb2xlLmxvZyhcJ+ivt+WLv+mdnuazleiwg+ivlSzotK3kubDor7fogZTns7tRUToyMzQ1MzE2MVwnKTsiKTsgICAgICAvL+iwg+ivleeql+WPo+aYvuekuuS/oeaBrwkKCgo=',
      'link_info' => '服务器正在解析中,请稍后....',
      'yun_title' => '云播放',
      'defile_info' => '解析失败，请切换线路！',
      'load_info' => '正在加载中，请稍后...',
    ),
    'style' => 
    array (
      'logo_show' => '1',
      'line_show' => '1',
      'list_show' => '1',
      'flaglist_show' => '1',
      'playlist_show' => '1',
      'line_style' => 'color:#2693FF;border:1px solid #2693FF;',
      'line_hover' => 'color:#FFF;background-color:#2693FF;',
      'line_on' => 'color:#FFF;background-color:#2693FF;',
      'play_style' => 'color:#FFF;border:1px solid #2693FF;',
      'play_hover' => 'color:#FFF;background-color:#2693FF;',
      'play_on' => 'color:#FFF;background-color:#2693FF;',
      'off' => NULL,
    ),
    'match' => 
    array (
      'yunflag' => '',
      'video' => '',
      'urljmp' => 'BGM->http://api.jp255.com/api/?url=',
      'urlurl' => '/share/',
      'urlflag' => 'url|yun|ziyuan',
      'playflag' => 'ogg|mp4|webm|m3u8|ck',
      'flagjmp' => 'fooyun->http://www.fooyun.xyz/share/',
    ),
    'define' => 
    array (
    ),
  ),
  'SOCODE' => NULL,
  'FOOTER_LINK' => 
  array (
    'off' => '1',
    'info' => 
    array (
      '官方网站' => 'https://xymov.net',
      '影视大全' => 'mov',
    ),
  ),
  'live' => 
  array (
    0 => 
    array (
      'name' => 'CCTV1',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv1hd.m3u8',
      'play' => 'aliplayer',
      'off' => '1',
      'status' => '可用',
    ),
    1 => 
    array (
      'name' => 'CCTV-11戏曲',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv11.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    2 => 
    array (
      'name' => 'CCTV-12HD',
      'url' => 'http://39.134.65.162/PLTV/88888888/224/3221225518/index.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    3 => 
    array (
      'name' => 'CCTV-12社会与法',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv12.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    4 => 
    array (
      'name' => 'CCTV-12高清',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv12hd.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    5 => 
    array (
      'name' => 'CCTV-13新闻',
      'url' => 'http://cctvalih5ca.v.myalicdn.com/live/cctv13_2/index.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    6 => 
    array (
      'name' => 'CCTV-13新闻',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv13.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    7 => 
    array (
      'name' => 'CCTV-15',
      'url' => 'http://ott.fj.chinamobile.com/PLTV/88888888/224/3221225818/1.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    8 => 
    array (
      'name' => 'CCTV-17',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv17.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    9 => 
    array (
      'name' => 'CCTV-17高清',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv17hd.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    10 => 
    array (
      'name' => 'CCTV-2财经',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv2.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    11 => 
    array (
      'name' => 'CCTV-2高清',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv2hd.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    12 => 
    array (
      'name' => 'CCTV-3HD',
      'url' => 'http://ottrrs.hl.chinamobile.com/PLTV/88888888/224/3221225785/index.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    13 => 
    array (
      'name' => 'CCTV-3综艺',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv3.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    14 => 
    array (
      'name' => 'CCTV-4美洲',
      'url' => 'https://cctvcnch5ca.v.wscdns.com/live/cctvamerica_2/index.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    15 => 
    array (
      'name' => 'CCTV-7高清',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv7hd.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    16 => 
    array (
      'name' => 'CCTV-8电视剧',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv8.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    17 => 
    array (
      'name' => 'CCTV-9HD',
      'url' => 'http://ottrrs.hl.chinamobile.com/PLTV/88888888/224/3221225734/index.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    18 => 
    array (
      'name' => 'CCTV-9纪录',
      'url' => 'http://ivi.bupt.edu.cn/hls/cctv9.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
    19 => 
    array (
      'name' => 'CCTV-10',
      'url' => 'http://ott.fj.chinamobile.com/PLTV/88888888/224/3221225814/1.m3u8',
      'play' => 'default',
      'off' => '1',
      'status' => '可用',
    ),
  ),
  'parse' => 
  array (
    0 => 
    array (
      'name' => '剧集线路',
      'url' => 'https://im1907.top/?jx=',
      'off' => '1',
      'status' => '可用',
    ),
    1 => 
    array (
      'name' => '高清线路',
      'url' => 'https://jx.m3u8.tv/jiexi/?url=',
      'off' => '1',
      'status' => '可用',
    ),
    2 => 
    array (
      'off' => '1',
      'name' => '备用线路',
      'url' => 'https://jx.xmflv.com/?url=',
    ),
  ),
  'resource' => 
  array (
    0 => 
    array (
      'name' => '乐播',
      'url' => 'https://lbapi9.com/api.php/provide/vod/at/xml',
      'off' => '1',
    ),
    1 => 
    array (
      'name' => '卧龙资源',
      'url' => 'https://collect.wolongzyw.com/api.php/provide/vod/at/xml',
      'off' => '1',
    ),
  ),
  'vod' => 
  array (
    0 => 
    array (
      'name' => '遇龙',
      'url' => '第1集$http://v.qq.com/x/cover/mzc002001fzfs38/n0036n6avkt.html$qq#第2集$http://v.qq.com/x/cover/mzc002001fzfs38/p00362l97xu.html$qq#第3集$http://v.qq.com/x/cover/mzc002001fzfs38/r00360tnaq6.html$qq#第4集$http://v.qq.com/x/cover/mzc002001fzfs38/a0036l2ilzd.html$qq#第5集$http://v.qq.com/x/cover/mzc002001fzfs38/y0036jc7m2d.html$qq#第6集$http://v.qq.com/x/cover/mzc002001fzfs38/u00365m4or6.html$qq#第7集$http://v.qq.com/x/cover/mzc002001fzfs38/j0036ntpmuk.html$qq#第8集$http://v.qq.com/x/cover/mzc002001fzfs38/c0036wfrr1b.html$qq#第9集$http://v.qq.com/x/cover/mzc002001fzfs38/i00367j8c5i.html$qq#第10集$http://v.qq.com/x/cover/mzc002001fzfs38/n0036g86ggo.html$qq#第11集$http://v.qq.com/x/cover/mzc002001fzfs38/e00361c2qcu.html$qq#第12集$http://v.qq.com/x/cover/mzc002001fzfs38/c0036xat0ro.html$qq#第13集$http://v.qq.com/x/cover/mzc002001fzfs38/s0036je02t0.html$qq#第14集$http://v.qq.com/x/cover/mzc002001fzfs38/y0036zcnxep.html$qq#第15集$http://v.qq.com/x/cover/mzc002001fzfs38/o0036v3gk9p.html$qq#第16集$http://v.qq.com/x/cover/mzc002001fzfs38/h0036t5p4nj.html$qq#第17集$http://v.qq.com/x/cover/mzc002001fzfs38/d0036ltq2u0.html$qq#第18集$http://v.qq.com/x/cover/mzc002001fzfs38/r0036cagr9w.html$qq#第19集$http://v.qq.com/x/cover/mzc002001fzfs38/e0036j5kg9r.html$qq#第20集$http://v.qq.com/x/cover/mzc002001fzfs38/e00369t889v.html$qq#第21集$http://v.qq.com/x/cover/mzc002001fzfs38/s0036ohfaxt.html$qq#第22集$http://v.qq.com/x/cover/mzc002001fzfs38/z0036eou42h.html$qq#第23集$http://v.qq.com/x/cover/mzc002001fzfs38/v0036ekvt5h.html$qq#第24集$http://v.qq.com/x/cover/mzc002001fzfs38/l0036omusgo.html$qq#第25集$http://v.qq.com/x/cover/mzc002001fzfs38/g003634vswh.html$qq#第26集$http://v.qq.com/x/cover/mzc002001fzfs38/c0036x6y3ut.html$qq#第27集$http://v.qq.com/x/cover/mzc002001fzfs38/a00369yq968.html$qq#第28集$http://v.qq.com/x/cover/mzc002001fzfs38/f0036idl80l.html$qq#第29集$http://v.qq.com/x/cover/mzc002001fzfs38/q0036w2mjcy.html$qq#第30集$http://v.qq.com/x/cover/mzc002001fzfs38/d0036arkhjf.html$qq#第31集$http://v.qq.com/x/cover/mzc002001fzfs38/r00369wf0dm.html$qq#第32集$http://v.qq.com/x/cover/mzc002001fzfs38/f0036g203v2.html$qq#第33集$http://v.qq.com/x/cover/mzc002001fzfs38/y00368y5g0c.html$qq#第34集$http://v.qq.com/x/cover/mzc002001fzfs38/s0036dkx306.html$qq#第35集$http://v.qq.com/x/cover/mzc002001fzfs38/p0036a9texj.html$qq#第36集$http://v.qq.com/x/cover/mzc002001fzfs38/x0036x840yt.html$qq#第37集$http://v.qq.com/x/cover/mzc002001fzfs38/l0036s1cgii.html$qq',
      'data' => '第1集$https://n1.szjal.cn/20210510/GBPuKiLZ/index.m3u8$bjm3u8#第2集$https://n1.szjal.cn/20210510/Su50pDdV/index.m3u8$bjm3u8#第3集$https://n1.szjal.cn/20210510/SIJ6gqGT/index.m3u8$bjm3u8#第4集$https://n1.szjal.cn/20210510/dJyacApu/index.m3u8$bjm3u8#第5集$https://n1.szjal.cn/20210510/XmDMe7t4/index.m3u8$bjm3u8#第6集$https://n1.szjal.cn/20210510/Vch81nmJ/index.m3u8$bjm3u8#第7集$https://n1.szjal.cn/20210510/QjsX0tk1/index.m3u8$bjm3u8#第8集$https://n1.szjal.cn/20210510/nc0sGhYs/index.m3u8$bjm3u8#第9集$https://n1.szjal.cn/20210511/L6IKlaz6/index.m3u8$bjm3u8#第10集$https://n1.szjal.cn/20210511/5XuSDJfx/index.m3u8$bjm3u8#第11集$https://n1.szjal.cn/20210512/dI7xN7dc/index.m3u8$bjm3u8#第12集$https://n1.szjal.cn/20210512/Ezbx4QPF/index.m3u8$bjm3u8#第13集$https://n1.szjal.cn/20210520/5iFcvEB0/index.m3u8$bjm3u8#第14集$https://n1.szjal.cn/20210520/tNPoGH9B/index.m3u8$bjm3u8#第15集$https://n1.szjal.cn/20210520/VehA2M48/index.m3u8$bjm3u8#第16集$https://n1.szjal.cn/20210520/5t02itUr/index.m3u8$bjm3u8#第17集$https://n1.szjal.cn/20210520/yAa41B1l/index.m3u8$bjm3u8#第18集$https://n1.szjal.cn/20210520/UktaJQO0/index.m3u8$bjm3u8#第19集$https://n1.szjal.cn/20210525/hyTjEfWJ/index.m3u8$bjm3u8#第20集$https://n1.szjal.cn/20210525/NdE1irjU/index.m3u8$bjm3u8#第21集$https://n1.szjal.cn/20210525/8luWVAqi/index.m3u8$bjm3u8#第22集$https://n1.szjal.cn/20210525/mMF7bJJE/index.m3u8$bjm3u8#第23集$https://n1.szjal.cn/20210525/j3mqLioe/index.m3u8$bjm3u8#第24集$https://n1.szjal.cn/20210525/GWjKWurK/index.m3u8$bjm3u8#第25集$https://n1.szjal.cn/20210525/2ivNl19D/index.m3u8$bjm3u8#第26集$https://n1.szjal.cn/20210525/F1lMVGrT/index.m3u8$bjm3u8#第27集$https://n1.szjal.cn/20210525/ZK7UDtP3/index.m3u8$bjm3u8#第28集$https://n1.szjal.cn/20210526/smWtjDJm/index.m3u8$bjm3u8#第29集$https://n1.szjal.cn/20210525/8Ik2RJ1u/index.m3u8$bjm3u8#第30集$https://n1.szjal.cn/20210525/rzm6TJzQ/index.m3u8$bjm3u8#第31集$https://n1.szjal.cn/20210531/cuknYrLP/index.m3u8$bjm3u8#第32集$https://n1.szjal.cn/20210531/fuDICU8d/index.m3u8$bjm3u8#第33集$https://n1.szjal.cn/20210531/KZPuZLFv/index.m3u8$bjm3u8#第34集$https://n1.szjal.cn/20210531/hsSKh5xM/index.m3u8$bjm3u8#第35集$https://n1.szjal.cn/20210531/hrZS9Hlz/index.m3u8$bjm3u8#第36集$https://n1.szjal.cn/20210531/vVllMJpg/index.m3u8$bjm3u8#第37集$https://n1.szjal.cn/20210531/ykn4KODf/index.m3u8$bjm3u8',
      'off' => '1',
    ),
    1 => 
    array (
      'off' => '1',
      'name' => '白玉思无瑕',
      'url' => '第1集$http://www.mgtv.com/b/342104/11630288.html$mgtv#第2集$http://www.mgtv.com/b/342104/11638945.html$mgtv#第3集$http://www.mgtv.com/b/342104/11638971.html$mgtv#第4集$http://www.mgtv.com/b/342104/11638985.html$mgtv#第5集$http://www.mgtv.com/b/342104/11641548.html$mgtv#第6集$http://www.mgtv.com/b/342104/11641579.html$mgtv#第7集$http://www.mgtv.com/b/342104/11641599.html$mgtv#第8集$http://www.mgtv.com/b/342104/11641632.html$mgtv#第9集$http://www.mgtv.com/b/342104/11649216.html$mgtv#第10集$http://www.mgtv.com/b/342104/11649239.html$mgtv#第11集$http://www.mgtv.com/b/342104/11704330.html$mgtv#第12集$http://www.mgtv.com/b/342104/11704341.html$mgtv#第13集$http://www.mgtv.com/b/342104/11711079.html$mgtv#第14集$http://www.mgtv.com/b/342104/11711122.html$mgtv#第15集$http://www.mgtv.com/b/342104/11761946.html$mgtv#第16集$http://www.mgtv.com/b/342104/11761966.html$mgtv#第17集$http://www.mgtv.com/b/342104/11765853.html$mgtv#第18集$http://www.mgtv.com/b/342104/11765923.html$mgtv#第19集$http://www.mgtv.com/b/342104/11765966.html$mgtv#第20集$http://www.mgtv.com/b/342104/11765994.html$mgtv#第21集$http://www.mgtv.com/b/342104/11766070.html$mgtv#第22集$http://www.mgtv.com/b/342104/11766096.html$mgtv#第23集$http://www.mgtv.com/b/342104/11830621.html$mgtv#第24集$http://www.mgtv.com/b/342104/11830822.html$mgtv#第25集$http://www.mgtv.com/b/342104/11830961.html$mgtv#第26集$http://www.mgtv.com/b/342104/11831173.html$mgtv#第27集$http://www.mgtv.com/b/342104/11881315.html$mgtv#第28集$http://www.mgtv.com/b/342104/11881327.html$mgtv#第29集$http://www.mgtv.com/b/342104/11881332.html$mgtv#第30集$http://www.mgtv.com/b/342104/11881338.html$mgtv#第31集$http://www.mgtv.com/b/342104/11881345.html$mgtv#第32集$http://www.mgtv.com/b/342104/11881351.html$mgtv',
      'data' => '第01集$https://vod.bunediy.com/20210411/lZAttTa7/index.m3u8$kbm3u8#第02集$https://vod.bunediy.com/20210411/iWLxY8LN/index.m3u8$kbm3u8#第03集$https://vod.bunediy.com/20210411/DutnoX7u/index.m3u8$kbm3u8#第04集$https://vod.bunediy.com/20210411/7wYBkzIu/index.m3u8$kbm3u8#第05集$https://vod.bunediy.com/20210411/ojOm07zA/index.m3u8$kbm3u8#第06集$https://vod.bunediy.com/20210411/9d5qIuQw/index.m3u8$kbm3u8#第07集$https://vod.bunediy.com/20210411/Cd4Ns2uy/index.m3u8$kbm3u8#第08集$https://vod.bunediy.com/20210411/P8V7uZ2J/index.m3u8$kbm3u8#第09集$https://vod.bunediy.com/20210412/4vLPic85/index.m3u8$kbm3u8#第10集$https://vod.bunediy.com/20210412/HbPB50xB/index.m3u8$kbm3u8#第11集$https://vod.bunediy.com/20210418/UO3p8GyX/index.m3u8$kbm3u8#第12集$https://vod.bunediy.com/20210418/YUSbMnoM/index.m3u8$kbm3u8#第13集$https://vod.bunediy.com/20210419/C5th0zPU/index.m3u8$kbm3u8#第14集$https://vod.bunediy.com/20210419/yLm4UGUb/index.m3u8$kbm3u8#第15集$https://vod.bunediy.com/20210424/22qTPPD9/index.m3u8$kbm3u8#第16集$https://vod.bunediy.com/20210424/PCYLNf5N/index.m3u8$kbm3u8#第17集$https://vod.bunediy.com/20210425/gliFYwaz/index.m3u8$kbm3u8#第18集$https://vod.bunediy.com/20210425/siyQ9aqZ/index.m3u8$kbm3u8#第19集$https://vod.bunediy.com/20210426/n5W611on/index.m3u8$kbm3u8#第20集$https://vod.bunediy.com/20210426/6iWLk4zj/index.m3u8$kbm3u8#第21集$https://vod.bunediy.com/20210426/7foWCPLl/index.m3u8$kbm3u8#第22集$https://vod.bunediy.com/20210426/Nuv124SI/index.m3u8$kbm3u8#第23集$https://vod.bunediy.com/20210503/oeIuz2Cy/index.m3u8$kbm3u8#第24集$https://vod.bunediy.com/20210503/JFOVDNwL/index.m3u8$kbm3u8#第25集$https://vod.bunediy.com/20210503/N2LEYDqY/index.m3u8$kbm3u8#第26集$https://vod.bunediy.com/20210503/IFYEe9RJ/index.m3u8$kbm3u8#第27集$https://vod.bunediy.com/20210510/NQVNSPp5/index.m3u8$kbm3u8#第28集$https://vod.bunediy.com/20210510/5kcKGWZF/index.m3u8$kbm3u8#第29集$https://vod.bunediy.com/20210510/A5xmRf02/index.m3u8$kbm3u8#第30集$https://vod.bunediy.com/20210510/g8TTCOJr/index.m3u8$kbm3u8#第31集$https://vod.bunediy.com/20210510/bd9qzqec/index.m3u8$kbm3u8#第32集$https://vod.bunediy.com/20210510/DS20zzgF/index.m3u8$kbm3u8',
    ),
    2 => 
    array (
      'off' => '1',
      'name' => '山河令',
      'url' => '第1集$http://v.youku.com/v_show/id_XNTEwMTg0NjE5Mg==.html$youku#第2集$http://v.youku.com/v_show/id_XNTEwMjU2NDYwMA==.html$youku#第3集$http://v.youku.com/v_show/id_XNTEwMjU2NDYwNA==.html$youku#第4集$http://v.youku.com/v_show/id_XNTEwMjU2NDYwOA==.html$youku#第5集$http://v.youku.com/v_show/id_XNTEwMjU2NDYxMg==.html$youku#第6集$http://v.youku.com/v_show/id_XNTEwMjU2NDYxNg==.html$youku#第7集$http://v.youku.com/v_show/id_XNTEwMDI5MzY1Mg==.html$youku#第8集$http://v.youku.com/v_show/id_XNTEwMTU4NTI3Mg==.html$youku#第9集$http://v.youku.com/v_show/id_XNTEwMDk5ODA0NA==.html$youku#第10集$http://v.youku.com/v_show/id_XNTEwMDI5NjA0NA==.html$youku#第11集$http://v.youku.com/v_show/id_XNTEwMjU2NDYyMA==.html$youku#第12集$http://v.youku.com/v_show/id_XNTEwMjU2NDYyNA==.html$youku#第13集$http://v.youku.com/v_show/id_XNTEwMzgyOTEyOA==.html$youku#第14集$http://v.youku.com/v_show/id_XNTEwMzgyOTI0NA==.html$youku#第15集$http://v.youku.com/v_show/id_XNTEwMzgyOTM0NA==.html$youku#第16集$http://v.youku.com/v_show/id_XNTEwMzgyOTQxNg==.html$youku#第17集$http://v.youku.com/v_show/id_XNTEwMDc0MjM5Mg==.html$youku#第18集$http://v.youku.com/v_show/id_XNTEwMzgyOTU2NA==.html$youku#第19集$http://v.youku.com/v_show/id_XNTEwMzgyOTY0OA==.html$youku#第20集$http://v.youku.com/v_show/id_XNTEwMzgyOTc0MA==.html$youku#第21集$http://v.youku.com/v_show/id_XNTEwMzgyOTgxMg==.html$youku#第22集$http://v.youku.com/v_show/id_XNTEwMzgyOTg3Ng==.html$youku#第23集$http://v.youku.com/v_show/id_XNTEwMzgyOTkzMg==.html$youku#第24集$http://v.youku.com/v_show/id_XNTEwMzgyOTk5Ng==.html$youku#第25集$http://v.youku.com/v_show/id_XNTEwMzgzMDA1Mg==.html$youku#第26集$http://v.youku.com/v_show/id_XNTEwMzgzMDEwOA==.html$youku#第27集$http://v.youku.com/v_show/id_XNTEwMzgzMDE4OA==.html$youku#第28集$http://v.youku.com/v_show/id_XNTEwMzgzMDI3Mg==.html$youku#第29集$http://v.youku.com/v_show/id_XNTEwMzgzMDMyMA==.html$youku#第30集$http://v.youku.com/v_show/id_XNTEwMzgzMDM2MA==.html$youku#第31集$http://v.youku.com/v_show/id_XNTEwMzgzMDQwOA==.html$youku#第32集$http://v.youku.com/v_show/id_XNTEwMzgzMDQ4MA==.html$youku#第33集$http://v.youku.com/v_show/id_XNTEwMzgzMDU0OA==.html$youku#第34集$http://v.youku.com/v_show/id_XNTEwMzgzMDYyOA==.html$youku#第35集$http://v.youku.com/v_show/id_XNTEwMzgzMDcwOA==.html$youku#第36集$http://v.youku.com/v_show/id_XNTEwMzgzMDc3Mg==.html$youku',
      'data' => '',
    ),
  ),
);
