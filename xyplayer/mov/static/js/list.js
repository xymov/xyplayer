function pageLoad(){

	// 初始化导航
	$('#conditionBox .s-slide-menu').mySlideMenu();

	pageLoaded = true;
}
if(typeof(pageLoaded) == 'undefined' && typeof(jsApi) != 'undefined'){ pageLoad(); }