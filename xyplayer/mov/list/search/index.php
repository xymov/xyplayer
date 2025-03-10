<?php
if(!isset($_GET["keyword"])){ header("Location: ../../");die(); }
if(!isset($_GET["page"]) || !is_numeric($_GET["page"]) || $_GET["page"] < 1){ $_GET["page"] = 1; }
require "../../data/index.php";require "../../config.php";
$data = data(array("act" => "search","kw" => $_GET["keyword"],"page" => $_GET["page"]));
if($data===false){ ShowMsg("资源获取失败,请重新输入！", -1);exit;}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta name="referrer" content="no-referrer">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<title>搜索结果 - <?php echo htmlspecialchars($_GET['keyword'])."-".$CONFIG['title'];?></title>
<meta name="keywords" content="<?php echo htmlspecialchars($_GET['keyword'].",".$CONFIG['title'])?>">
<meta name="description" content="<?php echo $CONFIG['title'];?>的搜索栏目为广大综艺爱好者提供了各类最新好看的，收集了最新热门排行榜，是一家优质的综艺分享网站，我们诚挚的欢迎所有喜欢看综艺大全的朋友的到来。">

<link rel="stylesheet" type="text/css" href="../../templets/<?php echo $CONFIG['templets'];?>/css/jquery.mobile.min.css">
<link rel="stylesheet" type="text/css" href="../../templets/<?php echo $CONFIG['templets'];?>/css/common.css">
<style>
    
    span{

overflow: hiddden;

text-overflow: ellipsis;

white-space: nowrap;

}
    
</style>

</head>

<body class="body">

<div class="header">
	<a class="logo" href="../../" style="background-image:url(<?php echo $CONFIG['logo']?:' ../../templets/'.$CONFIG['templets'].'/images/logo.png';?>)"></a>
	<div class="search">
		<a id="searchDo"></a>
		<input type="text" placeholder="输入你想看的" id="search" value="<?php echo htmlspecialchars($_GET['keyword'])?>" />
	</div>
	<div class="navigate">
		<a href="../../">精选</a>
		<a href="../dianshi/">电视剧</a>
		<a href="../dianying/">电影</a>
		<a href="../zongyi/">综艺</a>
		<a href="../dongman/">动漫</a>
	</div>
</div>

<div class="clear" style="height:0.5rem"></div>

<div class="keywords" id="keywordItem"><b>“<?php echo htmlspecialchars($_GET['keyword'])?>”</b> 的搜索结果：</div>

<div class="list">

	<?php if(!isset($data['list']) || count($data['list']) === 0){ ?>
	<div class="no-data" id="noDataBox" style="margin-top:1rem;background:none">没有找到相关影片，请尝试其他关键词！</div>

	<?php }else{ ?>
	<div class="items" id="listList">
		<?php foreach($data['list'] as $v){ ?>
		<a href="../../play/?cat=<?php echo $v['cat']?>&vid=<?php echo urlencode($v['id'])?>">
			<i style="background-image:url(<?php echo $v['pic']?>)"><b style="color: #fff;font-size: 0.3rem;text-align: center;text-overflow: ellipsis;"><?php  echo $v['comment'] ?></b></i>
			<span><?php echo htmlspecialchars($v['title'])?></span>
		</a>
		<?php } ?>
		<span class="clear"></span>
	</div>

	<div class="more">
		<a class="prev" href="./?keyword=<?php echo urlencode($_GET['keyword'])?>&page=<?php echo $_GET['page'] - 1?>"<?php echo $_GET['page'] <= 1 ? ' style="display:none"' : ''?>><img src="../../templets/<?php echo $CONFIG['templets'];?>/images/more.png" />上一页</a>
		<a class="next" href="./?keyword=<?php echo urlencode($_GET['keyword'])?>&page=<?php echo $_GET['page'] + 1?>"<?php echo !$data['hasmore'] ? ' style="display:none"' : ''?>>下一页<img src="../../templets/<?php echo $CONFIG['templets'];?>/images/more.png" /></a>
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
</body>
</html>