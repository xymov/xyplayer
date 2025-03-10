<?php 
error_reporting(0);
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<meta http-equiv="Cache-Control" "no-transform " />
<link rel="alternate" type="application/vnd.wap.xhtml+xml" media="handheld" href="target"/>
<meta http-equiv="Cache-Control" content="no-transform" /> 
<meta http-equiv="Cache-Control" content="no-siteapp" /> 
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="full-screen" content="yes">
<meta name="browsermode" content="application">
<meta name="x5-fullscreen" content="true">
<meta name="x5-page-mode" content="app">


    <title>弹幕播放器</title>
    <link rel="stylesheet" href="css/yzmplayer.css">
    <style>
      
        
      
        .yzmplayer-full-icon span svg,
        .yzmplayer-playlist-icon span svg,
        .yzmplayer-fulloff-icon span svg {
            display: none;
        }
        
        .yzmplayer-full-icon span,
        .yzmplayer-playlist-icon span,
        .yzmplayer-fulloff-icon span {
            background-size: contain !important;
            float: left;
            width: 22px;
            height: 22px;
        }
     
     
        
        
       .yzmplayer-playlist-icon span{
  
             background: url(img/playlist.png) center no-repeat ;
        }
        

        .yzmplayer-full-icon span {
            background: url(img/5eca627664041.png) center no-repeat;
        }

        .yzmplayer-fulloff-icon span {
            background: url(img/5eca6278b7137.webp) center no-repeat;
        }

        #vod-title {
            overflow: unset;
            width: 285px;
            white-space: normal;
            color: #fb7299;
        }

        #vod-title e {
            padding: 2px;
        }

        .layui-layer-dialog {
            text-align: center;
            font-size: 16px;
            padding-bottom: 10px;
        }

        .layui-layer-btn.layui-layer-btn- {
            padding: 15px 5px !important;
            text-align: center;
        }

        .layui-layer-btn a {
     
            font-size: 12px;
            padding: 0 11px !important;
        }

        .layui-layer-btn a:hover {
            border-color: #00a1d6 !important;
            background-color: #00a1d6 !important;
            color: #fff !important;
        }

        .yzmplayer-controller .yzmplayer-icons .yzmplayer-toggle input+label.checked:after {
            left: 17px;
        }

        .yzmplayer-setting-jlast:hover #jumptime,
        .yzmplayer-setting-jfrist:hover #fristtime {
            display: block;
            outline-style: none
        }

        #player_pause .tip {
            color: #f4f4f4;
            position: absolute;
            font-size: 14px;
            background-color: hsla(0, 0%, 0%, 0.42);
            padding: 2px 4px;
            margin: 4px;
            border-radius: 3px;
            right: 0;
        }

        #player_pause {
            position: absolute;
            z-index: 9999;
            top: 50%;
            left: 50%;
            border-radius: 5px;
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            max-width: 80%;
            max-height: 80%;
        }

        #player_pause img {
            width: 100%;
            height: 100%;
        }

        #jumptime::-webkit-input-placeholder,
        #fristtime::-webkit-input-placeholder {
            color: #ddd;
            opacity: .5;
            border: 0;
        }

        #jumptime::-moz-placeholder {
            color: #ddd;
        }

        #jumptime:-ms-input-placeholder {
            color: #ddd;
        }

        #jumptime,
        #fristtime {
            width: 50px;
            border: 0;
            background-color: #414141;
            font-size: 12px;
            padding: 3px 3px 3px 3px;
            margin: 2px;
            border-radius: 12px;
            color: #fff;
            position: absolute;
            left: 5px;
            top: 3px;
            display: none;
            text-align: center;
        }

        #link {
            display: inline-block;
            width: 100px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            font-size: 14px;
            border-radius: 22px;
            margin: 0px 10px;
            color: #fff;
            overflow: hidden;
            box-shadow: 0px 2px 3px rgba(0, 0, 0, .3);
            background: rgb(0, 161, 214);
            position: absolute;
            z-index: 9999;
            top: 20px;
            right: 35px;
        }

        #close c {
            float: left;
            display: none;
        }

        .dmlink,
        .playlink,
        .palycon {
            float: left;
            width: 400px;
        }

        #link3-error {
            display: none;
        }
 
         #stats {
            display:none;
            right: 15px;
            text-align: center;
            top: 10px ;
            font-size: 12px;
            color: #fdfdfd;
            text-shadow: 1px 1px 1px #000, 1px 1px 1px #000;
            position: fixed;
            z-index: 2147483645;
        }
        .playlist-show-xs,
        .flaglist-show{
         background-color: #222;
         color: #fff;
         height:28px;  
         margin-left:10px;
         line-height:28px;  
         border:1px solid #222;  
        -moz-border-radius:2px;  
        -webkit-border-radius:2px;  
         border-radius:2px; 
         overflow-y: scroll;
            
   
       
      }
 
   .playlist-show-xs{
            max-width: 120px;
            
         /* 列表文字剪裁 */
            overflow: hidden;
            white-space: nowrap;
            /* 不换行 */
            text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            text-decoration: none;
   
   }
         

      
       .yzmplayer-watching-title{
             /* 列表文字剪裁 */
            overflow: hidden;
            white-space: nowrap;
            /* 不换行 */
            text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            text-decoration: none;
        }
        
         
        
        
        .playlist-show{

            /*  设置纵向滚动条  */
            overflow-x: hidden;
            overflow-y: auto;
            
            scrollbar-arrow-color: #000 !important; /*顶部/底部图标颜色*/
            scrollbar-face-color: #333 !important; /*滚动条颜色*/
            scrollbar-shadow-color: #999 !important;/*滚动条阴影颜色*/

            max-height: calc(100% - 60px);
            margin-left:5px;
      
        }
        
        
        playlist-item,
        .playlist-show li {
           
            display: inline-table;
         
            color: #ddd;
            background-color: #222;
            border-radius: 2px;
            /*  列表字体颜色 */
            height: 28px;
            width: 80px;
            line-height: 28px;
            font-size: 12px;
            padding:2px 5px;
            margin: 5px;
            text-align: center;
      
            
            /* 列表文字剪裁 */

            overflow: hidden;
            white-space: nowrap;
            /* 不换行 */
            text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            text-decoration: none;
            table-layout: fixed;
            cursor: pointer;
            /* 鼠标设置为手型 */
       
}
            
            /* 列表元素热点 */
        .flaglist-show li:hover,
        .playlist-show li:hover {
            background-color: #2693FF;
        }
            


        
        
        
    </style>
	
   
    <script src="js/yzmplayer.js"></script>
    <script src="js/jquery.min.js"></script>
       <script src="js/jquery.md5.js"></script>
    <script type="text/javascript" src="../../include/class.main.js"></script>
    <script src="js/setting.js?time=<?php echo time();?>"></script>
    
  
    <?php
    
    $user=$_SESSION['username']?'管理员':'游客';
    
    if (strpos($_GET['url'], 'm3u8')) {
           if (filter_input(INPUT_GET, 'p2pinfo') === "1") {
           echo '<script src="../../include/p2p.min.js"></script>';
            
        } else {
            echo '<script src="js/hls.min.js"></script>';
        }
    } elseif (strpos($_GET['url'], 'flv')) {
        echo '<script src="js/flv.min.js"></script>';
    }
    //不显示右键菜单
    if ($_GET['menu_off']=='0') {
        
         echo '<style>.yzmplayer-menu.yzmplayer-menu-show{display:none;}</style>';
  
    }
    
    
    ?>
    <script src="js/layer.js"></script>

    <script>
        var css = '<style type="text/css">';
        var d, s;
        d = new Date();
        s = d.getHours();
        if (s < 17 || s > 23) {
            css += '#loading-box{background: #fff;}'; //白天
        } else {
            css += '#loading-box{background: #000;}'; //晚上
        }
        css += '</style>';
    </script>
</head>

<body> 
      <div id="player"></div>
    <div id="ADplayer"></div>
    <div id="ADtip"></div>
    
    <script>
       // window.addEventListener('error', function(e) {window.location.href = "../../h5/" + window.location.search;});
       
        var xyplay = ("undefined" !== typeof parent.xyplay) ? parent.xyplay : parent.parent.xyplay;
        var videoUrl = "<?php echo ($_GET['url']); ?>";
        var autoplay = "<?php echo ($_GET['autoplay']); ?>" === "0" ? 0 : 1;
        var live = "<?php echo ($_GET['live']); ?>"=== "1" ? 1 : 0;
        var part=Number(xyplay.part)+1 ;
        var id= (typeof(xyplay.title)!=='undefined' && xyplay.title.indexOf("直链")===-1) ? xyplay.title :"<?php echo substr(md5($_GET['url']),8,16); ?>";
       
        var up = {
            "usernum": "<?php include("tj.php"); ?>", //在线人数
            "mylink": "", //播放器路径，用于下一集
            "diyid": [0, id, 1] //自定义弹幕id
        }
        var config = {
            "api": '../../dmku/', //弹幕接口
            "av": '', //B站弹幕id 45520296
            "url": videoUrl, //视频链接
            "id": id, //视频id
            "sid": part, //集数id
            "pic": "", //视频封面
            "title": "", //视频标题
            "next": "xyplay.video_next", //下一集的调用方法名
            "live":live,   //是否直播
            "autoplay":autoplay,  //是否自动播放
            "user": "<?php echo $user; ?>", //用户名
            "group": '1', //用户组
     
        };
       
        //判断是否显示下集
         if ("undefined" !== typeof xyplay && "undefined" !== typeof xyplay.list_array) {
                if (xyplay.list_array && xyplay.list_array.length > 0 && xyplay.list_array[0]["video"].length > 1 && live === 0) {
                config.next="xyplay.video_next";
                }
            }
       /*
         //自定义右键
           if("undefined" !== typeof xyplay && "undefined" !== typeof xyplay.contextmenu && xyplay.contextmenu.off){
                config["contextmenu"] = new Array();
                for (var key in xyplay.contextmenu.val) {
                    config["contextmenu"].push({
                        text: key,
                        link: xyplay.contextmenu.val[key]
                    });
                    
                    console.log(config['contextmenu']);
                    
                }
            }
        */
   
        YZM.start();
  
         //移动浏览器video兼容
         $('body').find('video')
                .attr('playsinline', '')
                .attr('x5-playsinline', '')
                .attr('webkit-playsinline', '')
                .attr('x-webkit-airplay', 'allow');
  
       timeUpdate();


       delete window.document.referrer;
       window.document.__defineGetter__('referrer', function () {
     return 'pcvideochuangott.titan.mgtv.com';
    }); 


     //时间更新
        function timeUpdate() {
            var date = new Date();
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var day = date.getDate();
            var hour = "00" + date.getHours();
            hour = hour.substr(hour.length - 2);
            var minute = "00" + date.getMinutes();
            minute = minute.substr(minute.length - 2);
            var second = "00" + date.getSeconds();
            second = second.substr(second.length - 2);

            // $("#stats").html(year+"-"+month+"-"+day+" "+" "+hour+":"+minute+":"+second);

             $("#stats").html(hour + ":" + minute + ":" + second);
             setTimeout("timeUpdate()", 1000); 
   
        }
  

    </script>
</body>

</html>