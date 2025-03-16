  <?php

if(empty($_GET["vid"])){ header("Location: ../../");die(); }
require "../data/index.php";

require "../config.php";
$cat=$_GET["cat"];
$data = data(array("act" => "play","id" => $_GET["vid"],'cat'=>$_GET["cat"]));
//if($cat>2){$data['hasmore']=0;}  //动漫综艺隐藏剧集列表
if(!$data){ ShowMsg("参数错误,资源获取失败！", -1);exit;}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta name="referrer" content="no-referrer">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<?php if(isset($data['title'])){ $title=htmlspecialchars($data['title']); ?>
<title>正在播放 - <?php echo htmlspecialchars($data['title'])."-".$CONFIG['title'];?></title>
<meta name="keywords" content='<?php  echo "$title,《{$title}》在线播放,《{$title}》免费播放" ;?>'>
<meta name="description" content='<?php echo $title;?>播放页 - <?php echo htmlspecialchars($data['desc'])?>'>
<?php }else{ ?>
<title>资源不存在-<?php echo $CONFIG['title'];?></title>
<?php } ?>
<link rel="stylesheet" type="text/css" href="../templets/<?php echo $CONFIG['templets'];?>/css/jquery.mobile.min.css">
<link rel="stylesheet" type="text/css" href="../templets/<?php echo $CONFIG['templets'];?>/css/common.css">
<link rel="stylesheet" type="text/css" href="../templets/<?php echo $CONFIG['templets'];?>/css/play.css">
</head>

<body class="body">

<div class="header one">
	<a class="logo" href="../" style="background-image:url(<?php echo $CONFIG['logo']?:' ../templets/'.$CONFIG['templets'].'/images/logo.png';?>)"></a>
	<div class="search">
		<a id="searchDo"></a>
		<input type="text" placeholder="输入你想看的" id="search" />
	</div>
</div>

<?php if(count($data['from']) !== 0){ ?>
<div id="playBox">

	<div class="play-box" id="playBoxIframe">
		<div class="tip">如无法播放请尝试切换线路，或<a>点击前往<span></span>播放</a><i class="close"></i></div>
	</div>

     <div id='playinfo'>
            <?php $info= $CONFIG['playinfo'] ;
            $title= htmlspecialchars($data['title']);
            $str = str_replace('$title',$title,$info);
            echo $str;
            ?>

     </div>

			<div class="clear" style="height:0.3rem"></div>

	<h3 class="from-title" id="titleItem" value="<?php echo htmlspecialchars($data['title'])?>"><?php echo htmlspecialchars($data['title'])?></h3>
        
        
        <div class="from" id="siteList" style="display:none">

          <div class="template">  <a data-num="{{num}}" data-site="{{site}}" >{{siteTitle}}</a></div>
          
        <span class="clear"></span>
     
    </div>
        
          <h3 class="from-title" style="display:none"  >切换线路</h3>
        
	<div class="from" id="fromList" style="display:none" from="<?php echo htmlspecialchars('{"data":'.json_encode($data).'}')?>">
         
           <div class="template">  <a data-api="{{api}}" data-part="{{part}}" data-href="{{href}}" data-hasmore="{{hasmore}}" data-site="{{site}}"  >线路{{number}}</a></div>
		<span class="clear"></span>
	</div>

        
      
        
	<div class="loading" id="loadBox2">
		<span class="s-loading"><i class="first"></i><i class="second"></i><i class="third"></i></span>
	</div>

	<div class="episodes" id="episodesBox" style="display:none;">
		<div class="clear" style="height:0.3rem"></div>
		<h3 class="episodes-title">选集<span class="episodes-control" id="episodesControl"><a class="prev">上一集</a><a class="next">下一集</a></span></h3>
		
             
                <div class="episodes-list" id="episodesList">
			<div class="template"><a data-api="{{api}}" data-part="{{part}}"   data-href="{{href}}" value="{{number}}">{{number}}</a></div>
			<span class="clear"></span>
		</div>
	</div>
</div>
<?php }else{ ?>
<div class="no-data" id="noDataBox">未找到可用播放线路</div>
<?php } ?>

<?php if(isset($data['item'])){ ?>
<div class="clear" style="height:2rem"></div>
<div id="itemList">
	<div class="more">
		<i style="background-image:url(<?php echo $data['pic']?>)"></i>
		<h5><?php echo htmlspecialchars($data['title'])?></h5>
		<span><?php echo implode('</span><span>',$data['item'])?></span>
	</div>
	<div class="more desc">
		<div>简介：<?php echo htmlspecialchars($data['desc'])?></div>
	</div>
</div>
<?php } ?>

<?php if(isset($data['guess']) && count($data['guess'])){ ?>
<div class="list">

	<h3 class="title">猜你喜欢</h3>

	<div class="items" id="guessList">
		<?php foreach($data['guess'] as $v){ ?>
		<a href="./?cat=<?php echo $_GET["cat"]?>&vid=<?php echo urlencode($v['id'])?>">
			<i style="background-image:url(<?php echo $v['pic']?>)"></i>
			<span><?php echo htmlspecialchars($v['title'])?></span>
		</a>
		<?php } ?>
		<span class="clear"></span>
	</div>
</div>
<?php } ?>

<div class="clear" style="height:2rem"></div>

<div class="copyright">
	  <?php echo $CONFIG['copyright'];?>
</div>

<a class="scroll-to-top" id="scrollToTop"></a>

<script src="../static/js/jquery.min.js"></script>
<script src="../static/js/common.js"></script>
<script src="../static/js/play.js"></script>


<div id="footer">
    <?php echo $CONFIG['footcode'];?>
</div>  
 

</body>
</html>