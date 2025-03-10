<?php 

include './include/class.main.php';
include './save/config.php'; 
include './save/top.inc.php'; 



$skin=array(
    'color'=>'#50b2c8',                 //文本颜色
    'input_border'=>'#6599aa',         //搜索边框颜色
    'input_color'=>'white',            //搜索文本颜色
    'background'=>'#0f3854',           //背景颜色
    'background_style'=>'#0a2e38 0%,#000000 80%',   //背景渐变样式
);

?>
<!DOCTYPE html>
<html>
    <head>
        
        
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/><meta name="renderer" content="webkit"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
        <script type="text/javascript" src="./include/jquery.min.js"></script>
        <script type="text/javascript"  src="./include/class.main.js" ></script>
        <link href="./include/jquery.autocomplete.css" rel="stylesheet">
        <script type="text/javascript" src="./include/jquery.autocomplete.js?ver=1.2"></script>
        <title><?php echo $CONFIG["TITLE"]; ?></title>
<style>

html,body{
overflow:auto !important;  
width:100%;
height: 100%; 
margin: 0;
padding: 0;

}
body{
  text-align: center;
  background: <?php echo $skin["background"];?>;
  background: -webkit-radial-gradient(<?php echo $skin["background_style"];?>); /* Safari 5.1-6.0 */
  background: -o-radial-gradient(<?php echo $skin["background_style"];?>); /* Opera 11.6-12.0 */
  background: -moz-radial-gradient(<?php echo $skin["background_style"];?>); /* Firefox 3.6-15 */
  background: radial-gradient(<?php echo $skin["background_style"];?>); /* 标准语法 */
  background-size: 100%;
}

p {
  margin: 0;
  padding: 0;
}
a{
  color:<?php echo $skin["color"]; ?>;

}
#clock {
  font-family: 'Share Tech Mono', monospace;
  text-align: center;
  color: #daf6ff;

 /* text-shadow: 0 0 20px #0aafe6, 0 0 20px rgba(10, 175, 230, 0); */
}
#clock .time {
  letter-spacing: 0.05em;
  font-size: 60px;
  padding: 5px 0;
}
#clock .date {
  letter-spacing: 0.1em;
  font-size: 15px;
}
#clock .text {
  letter-spacing: 0.1em;
  font-size: 12px;
  padding: 20px 0 0;
}

#word{
background: #fff;
color: #000;
max-height:170px;
overflow-y:auto;
overflow-x:hidden;
}

#main{
  text-align: center;

}

h1{ color:red;}
h2{color:green;}
h3{color:#a7e9c3}
h4{color:blue;font-size:50px}

*{ box-sizing: border-box;}
		
 div.search {padding: 5px 0;}	
        form {
            position: relative;
            width: 300px;
            margin: 0 auto;
        }

        input, button {
            border: none;
            outline: none;
            color:<?php echo $skin["input_color"]; ?>;
        }
        input {
            width: 100%;
            height: 42px;
            padding-left: 13px;
        }

        button {
            height: 42px;
            width: 42px;
            cursor: pointer;
            position: absolute;
        }

       /*搜索框6*/
        .bar6 input {
            background: transparent;
            border-radius:3px;
            border:2px solid <?php echo $skin["input_border"]; ?> ;
            top: 0;
            right: 0;
        }
        .bar6 button {
            background:<?php echo $skin["input_border"]; ?>;
            border-radius: 0 5px 5px 0;
            width: 60px;
            top: 0;
            right: 0;
        }
        .bar6 button:before {
            content: "搜索";
            font-size: 13px;
            color: <?php echo $skin["input_color"] ?>;
        }
 
    /* 搜索内容样式 */    
   .list_btn{
     display: inline-block; 
     text-decoration: inherit;

    /* 内外边距及宽高属性 */
     margin: 1%;  padding: 5px;
     height: 30px;
     min-width:31%;
     max-width:95%;

     /* 文字及边框属性 */
     color:<?php echo $skin["color"]; ?>;
     font-size:13px;
     border-radius: 5px; 
     border: 2px solid <?php echo $skin["color"]; ?>; 
     
    /* 文字剪裁 */
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap !important;
    outline: 0 !important
    
  } 
    /*  移动设备自适应宽高  */  
    @media screen and (max-width: 650px){.list_btn{min-width:95%;}} 
      
    /*清除浮动代码*/
   .clearfloat{clear:both} 

  .resou{
        padding-top: 15px;
   }
  .resou a{
      color:<?php echo $skin["color"] ?>;
      padding: 5px;
      text-decoration:none; 
  }
 
  a{text-decoration:none;}
  
</style>
<script>
function check_str(field){
	  with(field){
	  var arr=['{','}','=',',',';','"','<','>','script','iframe','@','&','%','$','#','*',':','.','if','/','\\'];
    if("<?php echo $CONFIG["socode"]["not_off"];?>"=='1'){
       var str="<?php echo base64_decode($CONFIG["socode"]["not_val"]); ?>";
       if(str!=''){strs = str.split("|");arr = arr.concat(strs);}
    }
	  for (var key in arr) {
		  if( value.toLowerCase().indexOf(arr[key].toLowerCase()) > -1){			  
			  return true;
		  } 
	  }	 
	  return false;
	  
	}
 }
function validate_form(thisform){	
with(thisform){
if(wd.value.indexOf('http')===-1){action='./so.php';wd.name='wd';}else{action='play.html';wd.name='url';wd.value='index.php?url='+ wd.value;}
if(typeof wd!=="undefined" && wd.name=='wd'){
   if (check_str(wd)){
       
	 alert("请勿输入非法字符！");
     return false
    }
   
	}
 }
}
</script>



</head>
<body>
    
<div id="clock">
    <div id="main">
    
    </div>
<div class="clearfloat"></div>

<div id='body'>
<p class="date"></p>
<p class="time" id="time">00:00:00</p>
<p class="text" id="text">2018-08-08 星期一</p><br>
<div class="search bar6">
<form target="_self" action="./" onsubmit="return validate_form(this);" method="get" >
<input id="wd"  type="text" name="v"  placeholder="请输入视频名称或视频链接" value="<?php echo filter_input(INPUT_GET, 'wd'); ?>" >
<button type="submit"></button> 
<div id="word"  ></div>
</form>

<?php if($CONFIG["socode"]["top_off"]): ?>
<div class="resou" id="socode_top"> 
    <font face="verdana" style="color:<?php echo $skin["color"] ?>;"> 热门搜索：</font>
    
    <?php arsort($TOPDATA);$i=0; foreach ($TOPDATA as $key=>$val ): ?>
    <a target='' href="./so.php?wd=<?php echo rawurlencode($key); ?>"  title='人气：<?php echo $val; ?>℃'><?php echo $key; ?></a>
    <?php $i++; if($i==5){break;}?>
    <?php endforeach; ?>
   
    <a  target='_self' href="javascript:void(0);" onclick="echotop();">更多...</a>

 </div> 
<?php endif; ?>

<?php if($CONFIG["socode"]["diy_off"]): ?>
<div id="socode_diy">    
<br/>
<?php echo base64_decode($CONFIG["socode"]["diy_val"]); ?>
</div>
<?php endif; ?>

</div>

<?php if($CONFIG["FOOTER_LINK"]['off']): ?>
<div id="footer_link">    
<br/>
<font face="verdana" style="color:<?php echo $skin["color"] ?>;"> 友情链接：</font>
<?php  foreach( $CONFIG["FOOTER_LINK"]['info'] as $key=>$val) : ?>
<a   target='_blank'  href="<?php echo $val; ?>" ><?php echo $key; ?></a>
<?php endforeach; ?>
</div>
<?php endif; ?>


<br><span id="sitetime"> </span><br>
<br><div  id="footer" ></div>


</div>



</div>
    
<script>

//显示日期时间
var week = ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
var timerID = setInterval(updateTime, 1000);
var sitetime="<?php echo $CONFIG["sitetime"];?>";
updateTime();

function updateTime() {
    var cd = new Date();
    $('#time').text(zeroPadding(cd.getHours(), 2) + ':' + zeroPadding(cd.getMinutes(), 2) + ':' + zeroPadding(cd.getSeconds(), 2));
    $('#text').text(zeroPadding(cd.getFullYear(), 4) + '-' + zeroPadding(cd.getMonth()+1, 2) + '-' + zeroPadding(cd.getDate(), 2) + ' ' + week[cd.getDay()]);
    SiteTime(sitetime);
};

function zeroPadding(num, digit) {
    var zero = '';
    for(var i = 0; i < digit; i++) {
        zero += '0';
    }
    return (zero + num).slice(-digit);
}
//网站运行时间
function SiteTime(time){
var seconds =1000;
var minutes = seconds *60;
var hours = minutes *60;
var days = hours *24;
var years = days *365;
var dateBegin = new Date(time.replace(/-/g, "/"));//将-转化为/，使用new Date
var dateEnd = new Date();//获取当前时间
var diff = dateEnd.getTime() - dateBegin.getTime();//时间差的毫秒数;
var diffYears =Math.floor(diff/years);
var diffDays =Math.floor((diff/days)-diffYears*365);
var diffHours =Math.floor((diff-(diffYears*365+diffDays)*days)/hours);
var diffMinutes =Math.floor((diff-(diffYears*365+diffDays)*days-diffHours*hours)/minutes);
var diffSeconds =Math.floor((diff-(diffYears*365+diffDays)*days-diffHours*hours-diffMinutes*minutes)/seconds);
document.getElementById("sitetime").innerHTML=" 已运行"+diffYears+" 年 "+diffDays+" 天 "+diffHours+" 小时 "+diffMinutes+" 分钟 "+diffSeconds+" 秒"; 
}

</script>

<script>

//入口
function init() {
var wd= _GET("wd");
var url= _GET("url");
if(wd==="" && url==="" ){
//w="...请输入视频地址...  ";
w='<br><br><font size="4" color="<?php echo $skin["color"] ?>">...视</font><font color="<?php echo $skin["color"] ?>">频地址不能为空...</font>';

$(".date").html(w);
}
if(wd!==""){getvideo(wd);}

       w="<?php echo $CONFIG["play"]["all"]["by"]; ?>";

       w+='  <a  style="color:#daf6ff;"  href="javascript:void(0);" onclick="echoby();" >   免责声明 </a><br><br>';

         $("#footer").html(w);
         toggleCenter();
}
    
//显示版权
function echoby() {
    
      alert("本站所有视频均来自外部引用，本站不存储不制作任何视频！\r\n 如有侵权问题，请与源站联系,谢谢合作！");
        
    }     

  //搜索排行  
 function echotop(){
   if ($("#main").html().indexOf("搜索排行榜")!=-1){
            $("#main").html("");
   }else{
    var w = "<br><br><div style='text-align:center;'><h3>搜索排行榜-TOP100</h3>";
    <?php arsort($TOPDATA);$i=0; foreach ($TOPDATA as $key=>$val ): ?>
      title="<?php echo $key; ?>";



      w+= "<a  target='_parent' class='list_btn' href='./so.php?wd=<?php echo rawurlencode($key); ?>' title='人气：<?php echo $val; ?>℃'><strong>" + title+ "</strong></a>";
    <?php $i++; if($i==100){break;}?>
     <?php endforeach; ?>
    w+=  "</div>";
    $("#main").html(w);
}
    toggleCenter();	
 }

 
//刷新列表
function  relist(data){
      if(data&&data.success)
        {   	 
	     var v=data.info;    
       var w = "<br><br><div style='text-align:center;'><h3>搜索到相关视频" + v.length + "个，请点击访问</h3>";
       for (i = 0, len = v.length; i < len; i++) 
		   {
		   
                 /*
                   _blank：新窗口打开。
                   _parent：在父窗口中打开链接。
                   _self：默认，当前页面跳转。
                    _top：在当前窗体打开链接，并替换当前的整个窗体(框架页)。
                  */
                                       
                     var href="./?index"+v[i].id +"-" + v[i].flag+"-1.htm";
                     
                     var title=removeHTMLTag(v[i].title,true)+"(" +(v[i].from)+")";  
       
                     w+= "<a  class='list_btn '  target='_self'   href='" +href +"' title='"+ title+"' ><strong>" + title + "</strong></a>";

      }
             w+=  "</div>";
             
       }else{     
	        	   
	       var w='<h3 >很抱歉，未搜索到相关资源</h3>';     
	    	$("#info").html('请修改影片名后重新搜索');

        }      
         $("#main").html(w);
         $("#body").show();
         toggleCenter();	 
		 
}

//取视频数据
function getvideo(word){
          $.ajax({
              url: './<?php echo $CONFIG["API_PATH"]; ?>?out=jsonp&wd='+word,
              timeout:30000,
              dataType: 'jsonp',
              jsonp: 'cb',
              beforeSend: function() {
                $("#body").hide();
                $("#main").html('<h3 >正在搜索中,请稍后...</h3>'); 
              },
              success: function (data) {
                 relist(data);
              },
              error: function () {
                relist();
              }
          });
}

//自适应大小位置
function toggleCenter() {

if($("#main").height() + $("#clock").height()>$(window).height()){
 
    $("#clock").css("position","static");

}else{

   $("#clock").css("position","absolute");$("#clock").css("top",($(window).height() -$("#clock").height())/2-20);

}
  
 if($(window).width()<=$("#clock").width()){$("#clock").css("left",0);}else{ $("#clock").css("left",($(window).width()-$("#clock").width())/2);} 

}
$(window).resize(function(){ toggleCenter();}); 


init();




</script>
</body>
</html>