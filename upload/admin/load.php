<?php
/* html调用模块 用来加载html目录含有php代码的html文件*/
$url=trim(filter_input(INPUT_GET, 'url'));
if(preg_match('/^\w+\.htm$/i', $url)){
  $file="./html/".filter_input(INPUT_GET, 'url');
  if(file_exists($file)){include $file; exit;}else{exit("404 not found");}	
}else{
	 exit("input error!");	
}