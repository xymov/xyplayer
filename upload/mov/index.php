<?php

require "./data/index.php";
$data = data(array("act" => "index"));
$banner=($CONFIG['banner']['type']??'0') ? $CONFIG['banner']['data']: $data['banner'];

if(!$data){ ShowMsg("资源获取失败,请检查网络！", -1);exit;}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta name="referrer" content="no-referrer">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.user-scalable=0">


<title><?php echo $CONFIG['title']."-".$CONFIG['keywords'];?></title>
<meta name="keywords" content="<?php echo $CONFIG['keywords'];?>">
<meta name="description" content="<?php echo $CONFIG['description'];?>">
<link rel="stylesheet" type="text/css" href="./templets/<?php echo $CONFIG['templets'];?>/css/jquery.mobile.min.css">
<link rel="stylesheet" type="text/css" href="./templets/<?php echo $CONFIG['templets'];?>/css/common.css">
</head>

<body class="body">

<div class="header">
	<a class="logo" href="./" style="background-image:url(<?php echo $CONFIG['logo']?:' ./templets/'.$CONFIG['templets'].'/images/logo.png';?>"></a>
	<div class="search">
		<a id="searchDo"></a>
		<input type="text" placeholder="输入你想看的" id="search" />
	</div>
	<div class="navigate">
		<a href="./" class="current">精选</a>
		<a href="./list/dianshi/">电视剧</a>
		<a href="./list/dianying/">电影</a>
		<a href="./list/zongyi/">综艺</a>
		<a href="./list/dongman/">动漫</a>
	</div>
</div>

<div class="s-slider">
	<ul id="bannerList">
            
        
		<?php foreach($banner as $v){ ?>
		<li><a href="./play/?cat=<?php echo $v['cat']?>&vid=<?php echo urlencode($v['id'])?>"><i style="background-image:url(<?php echo $v['pic']?>)"></i><span><?php echo htmlspecialchars($v['title'])?></span></a></li>
		<?php } ?>
	</ul>
	<ol></ol>
	<div style="display:none"><span class="now"></span><span>/</span><span class="total"></span></div>
</div>

<div class="list">

	<h3 class="title">电视剧</h3>

	<div class="items" id="dianshiList">
		<?php foreach($data['tv'] as $k => $v){ ?>
		<a href="./play/?cat=<?php echo $v['cat']?>&vid=<?php echo urlencode($v['id'])?>"<?php echo $k >= 6 ? ' style="display:none"' : '' ?>>
			<i style="background-image:url(<?php echo $v['pic']?>)"><b><?php echo $v['hint']?></b></i>
			<span><?php echo htmlspecialchars($v['title'])?></span>
		</a>
		<?php } ?>
		<span class="clear"></span>
	</div>

	<div class="more">
		<a href="./list/dianshi/"><img src="./templets/<?php echo $CONFIG['templets'];?>/images/more_1.png" />更多电视剧</a>
		<a class="switch-button" data-list-type="dianshi"><img src="./templets/<?php echo $CONFIG['templets'];?>/images/more_2.png" />换一批</a>
	</div>
</div>

<div class="clear" style="height:0.8rem"></div>

<div class="list">

	<h3 class="title">电影</h3>

	<div class="items" id="dianyingList">
		<?php foreach($data['m'] as $k => $v){ ?>
		<a href="./play/?cat=<?php echo $v['cat']?>&vid=<?php echo urlencode($v['id'])?>"<?php echo $k >= 6 ? ' style="display:none"' : '' ?>>
			<i style="background-image:url(<?php echo $v['pic']?>)"><b><?php echo $v['hint']?></b></i>
			<span><?php echo htmlspecialchars($v['title'])?></span>
		</a>
		<?php } ?>
		<span class="clear"></span>
	</div>

	<div class="more">
		<a href="./list/dianying/"><img src="./templets/<?php echo $CONFIG['templets'];?>/images/more_1.png" />更多电影</a>
		<a class="switch-button" data-list-type="dianying"><img src="./templets/<?php echo $CONFIG['templets'];?>/images/more_2.png" />换一批</a>
	</div>
</div>

<div class="clear" style="height:0.8rem"></div>

<div class="list">

	<h3 class="title">综艺</h3>

	<div class="items" id="zongyiList">
		<?php foreach($data['va'] as $k => $v){ ?>
		<a href="./play/?cat=<?php echo $v['cat']?>&vid=<?php echo urlencode($v['id'])?>"<?php echo $k >= 6 ? ' style="display:none"' : '' ?>>
			<i style="background-image:url(<?php echo $v['pic']?>)"><b><?php echo $v['hint']?></b></i>
			<span><?php echo htmlspecialchars($v['title'])?></span>
		</a>
		<?php } ?>
		<span class="clear"></span>
	</div>

	<div class="more">
		<a href="./list/zongyi/"><img src="./templets/<?php echo $CONFIG['templets'];?>/images/more_1.png" />更多综艺</a>
		<a class="switch-button" data-list-type="zongyi"><img src="./templets/<?php echo $CONFIG['templets'];?>/images/more_2.png" />换一批</a>
	</div>
</div>

<div class="clear" style="height:0.8rem"></div>

<div class="list">

	<h3 class="title">动漫</h3>

	<div class="items" id="dongmanList">
		<?php foreach($data['ct'] as $k => $v){ ?>
		<a href="./play/?cat=<?php echo $v['cat']?>&vid=<?php echo urlencode($v['id'])?>"<?php echo $k >= 6 ? ' style="display:none"' : '' ?>>
			<i style="background-image:url(<?php echo $v['pic']?>)"><b><?php echo $v['hint']?></b></i>
			<span><?php echo htmlspecialchars($v['title'])?></span>
		</a>
		<?php } ?>
		<span class="clear"></span>
	</div>

	<div class="more">
		<a href="./list/dongman/"><img src="./templets/<?php echo $CONFIG['templets'];?>/images/more_1.png" />更多动漫</a>
		<a class="switch-button" data-list-type="dongman"><img src="./templets/<?php echo $CONFIG['templets'];?>/images/more_2.png" />换一批</a>
	</div>
</div>

<div class="clear" style="height:2rem"></div>

<div class="copyright">
    <?php echo $CONFIG['copyright'];?>
</div>

<a class="scroll-to-top" id="scrollToTop"></a>

<script src="./static/js/jquery.min.js"></script>
<script src="./static/js/common.js"></script>
<script src="./static/js/index.js"></script>

<div id="footer">
    <?php echo $CONFIG['footcode'];?>
</div>  
 

</body>
</html>