<!DOCTYPE html>
<?php require "../../config.php" ;?>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta name="referrer" content="no-referrer">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<title><?php echo $CONFIG["title"];?></title>
<meta name="keywords" content="<?php echo $CONFIG["keywords"];?>" />
<meta name="description" content="<?php echo $CONFIG["description"];?>" />


<link rel="stylesheet" type="text/css" href="../../static/css/jquery.mobile.min.css">
</head>

<body>

<iframe frameborder="no" border="0" scrolling="no" allowfullscreen="true" allowtransparency="true" sandbox="allow-forms allow-scripts allow-same-origin allow-popups" style="position:fixed;width:100%;height:100%;border:none;overflow:hidden;background:#000"></iframe>

<script src="../../static/js/jquery.min.js"></script>
<script>
$(function(){ if($.URI.src){ $('iframe').attr('src',$.URI.src); } })
</script>
</body>
</html>