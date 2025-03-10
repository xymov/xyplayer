<?php

if(!isset($_GET["condition"])){ $_GET['condition'] = ""; }
if(!isset($_GET["page"]) || !is_numeric($_GET["page"]) || $_GET["page"] < 1){ $_GET["page"] = 1; }
require "../../data/index.php";
require "../../config.php";

$data = data(array("act" => "list","catid" => DATA_CAT_TV,"filter" => $_GET["condition"],"page" => $_GET["page"]));
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
<title>最新好看的电视剧推荐_热门电视剧大全排行榜_<?php echo $_GET["page"].'页_'.$CONFIG['title'];?></title>
<meta name="keywords" content="最新电视剧,好看的电视剧,热门电视剧">
<meta name="description" content="<?php echo $CONFIG['title'];?>的电视剧栏目为广大电视剧爱好者提供了各类最新好看的电视剧，收集了最新热门电视剧排行榜，是一家优质的电视剧分享网站，我们诚挚的欢迎所有喜欢看电视剧大全的朋友的到来。">
<link rel="stylesheet" type="text/css" href="../../templets/<?php echo $CONFIG['templets'];?>/css/jquery.mobile.min.css">
<link rel="stylesheet" type="text/css" href="../../templets/<?php echo $CONFIG['templets'];?>/css/common.css">
</head>

<body class="body" ltype="dianshi">

<div class="header">
	<a class="logo" href="../../" style="background-image:url(<?php echo $CONFIG['logo']?:' ../../templets/'.$CONFIG['templets'].'/images/logo.png';?>)"></a>
	<div class="search">
		<a id="searchDo"></a>
		<input type="text" placeholder="输入你想看的" id="search" />
	</div>
	<div class="navigate">
		<a href="../../">精选</a>
		<a href="../dianshi/" class="current">电视剧</a>
		<a href="../dianying/">电影</a>
		<a href="../zongyi/">综艺</a>
		<a href="../dongman/">动漫</a>
	</div>
</div>

<div class="clear" style="height:0.2rem"></div>

<div class="condition" id="conditionBox">
	<?php foreach($data['filter'] as $condition){ ?>
		<div class="s-slide-menu"><div>
			<?php foreach($condition as  $v){ ?>
        <a href="./?condition=<?php echo urlencode($v)?>"<?php echo ($v === $_GET['condition'] or ($v==='全部' and $_GET['condition']=='')) ? ' class="now"' : ''?>><?php echo  htmlspecialchars($v)?></a>
			<?php } ?>
		</div></div>
	<?php } ?>
</div>

<div class="list">

	<?php if(!isset($data['list']) || count($data['list']) === 0){ ?>
	<div class="no-data" id="noDataBox" style="margin-top:1rem;background:none">没有找到相关影片，请尝试其他分类！</div>

	<?php }else{ ?>
	<div class="items" id="listList">
		<?php foreach($data['list'] as $v){ ?>
		<a href="../../play/?cat=2&vid=<?php echo urlencode($v['id'])?>">
			<i style="background-image:url(<?php echo $v['pic']?>)"><b>更新至<?php echo $v['upinfo']?>集</b></i>
			<span><?php echo htmlspecialchars($v['title'])?></span>
		</a>
		<?php } ?>
		<span class="clear"></span>
	</div>

	<div class="more">
		<a class="prev" href="./?condition=<?php echo urlencode($_GET['condition'])?>&page=<?php echo $_GET['page'] - 1?>"<?php echo $_GET['page'] <= 1 ? ' style="display:none"' : ''?>><img src="../../templets/<?php echo $CONFIG['templets'];?>/images/more.png" />上一页</a>
		<a class="next" href="./?condition=<?php echo urlencode($_GET['condition'])?>&page=<?php echo $_GET['page'] + 1?>"<?php echo !$data['hasmore'] ? ' style="display:none"' : ''?>>下一页<img src="../../templets/<?php echo $CONFIG['templets'];?>/images/more.png" /></a>
	</div>
	<?php } ?>
</div>

<div class="clear" style="height:2rem"></div>

<div class="copyright">
	 <?php echo $CONFIG['copyright'];?>
</div>



<a class="scroll-to-top" id="scrollToTop"></a>

<script src="../../static/js/jquery.min.js"></script>
<script src="../../static/js/common.js"></script>
<script src="../../static/js/list.js"></script>

 
</body>
</html>