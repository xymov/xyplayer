function pageLoad(){

	var template = {'site':null,'from': null,'episodes': null,'item': null};


	$(function(){

		if($.URI.vid){
                    
                        //取播放数据
                         var data = JSON.parse($('#fromList').attr('from')).data;
                    
			// 关闭播放提示
			$('#playBoxIframe .tip .close').tap(function(){ $('#playBoxIframe .tip').fadeOut(200); })

			// 初始化模板
			for(var i in template){
				if($('#' + i + 'List .template').length){
					template[i] = $('#' + i + 'List .template').html();
					$('#' + i + 'List .template').remove();
				}
			}

			// 上一集
			$('#episodesControl a.prev').tap(function(){
                            prev(data.hasmore==2);
			})
                        
			// 下一集
			$('#episodesControl a.next').tap(function(){
                             next(data.hasmore==2);
			})


			// 播放
			var tipInterval;
			$('#fromList,#episodesList').tap(function(e){

				if($(this).hasClass('current')){ return true; }
				$(this).parent().find('.current').removeClass('current');
				$(this).addClass('current');
				if($(this).attr('data-site')){ $('#playBoxIframe .tip a span').html($(this).attr('data-site')); }

                            
				if(!$(this).attr('data-hasmore') || ($(this).attr('data-hasmore') != 1 && $(this).attr('data-hasmore') != 2)){
				//单集	
                                   if($(this).attr('data-api')){
                                                 //提示跳转官方链接
						$('#playBoxIframe .tip').show().find('a').attr('href',$(this).attr('data-href'));
						if(tipInterval){ clearInterval(tipInterval); }
						tipInterval = setInterval(function(){ $('#playBoxIframe .tip').fadeOut(200) },3000);

						// 记录当前剧集
						if($(this).attr('value')){
							var episodes_log = $.cookie('episodes_log'),episodes_number = $(this).attr('value');
							if(episodes_log){
								try{
									var episodes_log = JSON.parse(episodes_log);
									if(episodes_log[$.URI.vid]){ delete episodes_log[$.URI.vid]; }
									episodes_log[$.URI.vid] = episodes_number;
									var episodes_log_keys = Object.keys(episodes_log);
									if(episodes_log_keys.length > 2){	// 最多记录10个
										for(i = 0;i < episodes_log_keys.length - 2;++ i){
											delete episodes_log[episodes_log_keys[i]];
										}
									}
								}catch(e){
									episodes_log = {};
									episodes_log[$.URI.vid] = episodes_number;
								}
							}else{
								episodes_log = {};
								episodes_log[$.URI.vid] = episodes_number;
							}
							$.cookie('episodes_log',JSON.stringify(episodes_log),2592000);

							// 更新标题
							$('#titleItem').html($.htmlEncode($('#titleItem').attr('value')) + '<span>' + $.htmlEncode((/^\d+$/.test(episodes_number) ? '第' + episodes_number + '集' : episodes_number)) + '</span>');
                                                        
                                                        // 更新剧集操作
                                                        episodesControl(data.hasmore==2);

							
						}

                                                var api=$(this).attr('data-api');
                                                var host=location.href.match(/(.*?)\/mov\/play\//)[1];
                                                  
                                                  
                                                //处理解析中的"$host","$title","$part" 变量
                                                 api = api.replace("$host",host).replace('$part',$(this).attr('data-part')|| 1).replace("$title", encodeURIComponent($("#titleItem").attr('value').replace("全集","")));     
                    
                   
                    
						$('#playBoxIframe iframe').remove();
						$('#playBoxIframe').append('<iframe name="playBox" frameborder="no" border="0" scrolling="no" allowfullscreen="true" allowtransparency="true" src="./box/?src=' + encodeURIComponent(api + encodeURIComponent($(this).attr('data-href'))) + '"></iframe>');

						$('html,body').animate({scrollTop: 0},300);
					}else{
						location.href = $(this).attr('data-href');
					}
				}else{
                                    
                                        //剧集
					$('#loadBox2').show();
					$('#episodesBox').hide();
					var api = $(this).attr('data-api');
      
                                        var site=$('#siteList .current').attr("data-site")?? data.from[0][1];
                                        var size= data.allupinfo[site];     
                                        //console.log({act: 'more',id: $.URI.vid,cat:$.URI.cat,site: site,size:size});
					$.getJSON(jsUrl,{act: 'more',id: $.URI.vid,cat:$.URI.cat,site: site,size:size},function(rt){
						 
                                            
                                            try{
                                                     
                                                   
							//var rt = JSON.parse(rData);
							switch(parseInt(rt.code)){
								case 0:
									$('#episodesList a').remove();
                                                 
									// 载入剧集
									if(template.episodes){
										if(rt.data.title == 1){ $('#episodesList').addClass('float-none') }
                                                                      
                                                                                var part=(data.hasmore==2) ? Object.keys(rt.data.list).length :0;
                                                                               
										for(var i in rt.data.list){
                                                                        
                                                                                          if(data.hasmore==2){
                                                                  
                                                                                              //把内容插入到…内部的首端 ，倒序
                                              
											      $(parseTemplate(template.episodes,{api: api,href: rt.data.list[i],number: i,part:part})).prependTo($('#episodesList'));
                                                                                               part --;
                                                                                           }else{
                                                                                               part ++;
                                                                                               
                                                                                               //内容插入到…内部的末端 ,正序
                                                                                              $(parseTemplate(template.episodes,{api: api,href: rt.data.list[i],number: i,part:part})).appendTo($('#episodesList')); 
                                                                       }
                                                                          }

										// 显示剧集
										$('#loadBox2').hide();
										$('#episodesBox').show();
										// 是否有剧集记录
										var episodes_log = $.cookie('episodes_log');
										if(episodes_log){
											try{

												var episodes_log = JSON.parse(episodes_log);
												if(episodes_log[$.URI.vid] && $('#episodesList a[value="' + episodes_log[$.URI.vid] + '"]').length == 1){
													// 自动点击记录剧集
													if($('#episodesList a[value="' + episodes_log[$.URI.vid] + '"]').attr('data-api')){
														$('#episodesList a[value="' + episodes_log[$.URI.vid] + '"]').trigger('tap'); }
												}else{
													// 自动点击第一个
													if($('#episodesList a:eq(0)').attr('data-api')){ $('#episodesList a:eq(0)').trigger('tap'); }
												}

											}catch(e){
												// 自动点击第一个
												if($('#episodesList a:eq(0)').attr('data-api')){ $('#episodesList a:eq(0)').trigger('tap'); }
											}
										}else{
											// 自动点击第一个
											if($('#episodesList a:eq(0)').attr('data-api')){ $('#episodesList a:eq(0)').trigger('tap'); }
										}
                                                                                  //更新剧集操作
										  episodesControl(data.hasmore==2);

									}else{
										console.log('未知的列表模板');
									}
								break;
								default:
                                                                  // console.log(rt);
                                                                       $('#loadBox2').hide();
									$.showError("网络错误，请稍后再试！");
                                                                        
                                                                        
							}
						}catch(e){
                                                    //console.log(rt);
                                                         $('#loadBox2').hide();
							$.showDataError("网络错误，请稍后再试！");
						}
					})
				}
			},'a');


          //播放来源
          if($('#siteList').length && $('#fromList').attr('from')){
                     
                       $('#siteList a').remove();
                       //var data = JSON.parse($('#fromList').attr('from')).data;
                     
                       
                       for(var i in data.from){
                          
                         var from_name=data.from[i][2];
                           // console.log(from_name);
                        //过滤来源标签
                         if(from_filtr.indexOf(from_name)===-1){
           
                              $(parseTemplate(template.site,{num:i,site:data.from[i][1],siteTitle:data.from[i][2]})).insertBefore($('#siteList .clear'));
                         
                         };
                        
                        
                         
			}
                        if(data.from.length>1){  $('#siteList').show(); $('.from-title').show();}
                
                         $('#siteList a:eq(0)').addClass('current'); lineLoad(0);
        
                   }

           $('#siteList a').click(function(){ 
                if($(this).hasClass('current')){ return true; }
		$(this).parent().find('.current').removeClass('current');
		$(this).addClass('current');
                lineLoad($(this).attr("data-num"));
          })
          
          
          // 更新剧集操作 ,参数：是否降序排列
          
          function episodesControl(desc){
        
                 var next=$('#episodesList .current').next('a').length;
                 var prev=$('#episodesList .current').prev('a').length;
         
                 if(desc?prev:next){
			$('#episodesControl a.next').css('display','block');
		}else{
			$('#episodesControl a.next').hide();
		 }
                     if(desc?next:prev){
			    $('#episodesControl a.'+'prev').css('display','block');
			}else{
			      $('#episodesControl a.prev').hide();
			}
               }
          
          
          function next(desc){
              
              if(desc){
                   if($('#episodesList .current').prev().length){$('#episodesList .current').prev().trigger('tap');}
              }else{
                   if($('#episodesList .current').next().length){$('#episodesList .current').next().trigger('tap');}
              }
          }
           function prev(desc){
                if(desc){
                   if($('#episodesList .current').next().length){$('#episodesList .current').next().trigger('tap');}
              }else{
                   if($('#episodesList .current').prev().length){$('#episodesList .current').prev().trigger('tap');}
                  
              }
   
          }
          
      
          
        // 载入线路   
          function lineLoad(i){
			if($('#fromList').length && $('#fromList').attr('from')){
				$('#fromList a').remove();
				if(template.from){

		
                                           //  var part=$("#episodesList a").find('.current').attr('value') || 1;
              
                                              if(jsApi && jsApi.length){
                                                      
                                           
                                                for(var j in jsApi){

							$(parseTemplate(template.from,{hasmore: data.hasmore,from: data.from[i],api: jsApi[j],number: ++j})).insertBefore($('#fromList .clear'));
						}
                        
                                            }else{

							$('#playBoxIframe').hide();
							$(parseTemplate(template.from,{hasmore: data.hasmore,from: data.from[i],api: '',number: ++ number})).insertBefore($('#fromList .clear'));
					}
                                           
                                     

					// 显示并自动点击第一个
					if(data.hasmore != 1 && data.hasmore != 2){ $('#loadBox2').hide(); }
					$('#fromList').show();
					if($('#fromList a:eq(0)').attr('data-hasmore') == 1 || $('#fromList a:eq(0)').attr('data-hasmore') == 2 || $('#fromList a:eq(0)').attr('data-api')){ $('#fromList a:eq(0)').trigger('tap'); }

				}else{
					console.log('未知的列表模板');
				}
			}
                        
            }
                        
                        
		}else{
			location.href = './index.html';
		}
                
    
	})

	pageLoaded = true;
}
if(typeof(pageLoaded) == 'undefined' && typeof(jsApi) != 'undefined'){ pageLoad(); }