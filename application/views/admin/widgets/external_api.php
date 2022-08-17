<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$widget_bg_color     = $content['widget_bg_color'];
$widget_custom_title = $content['widget_title'];
$widget_instance_id  = $content['widget_values']['data-widgetinstanceid'];
$view_mode           = $content['mode'];
$max_article         = $content['show_max_article'];
$render_mode         = $content['RenderingMode'];
$title=explode(' ',$widget_custom_title);
$title_new=$widget_custom_title;
$widget_custom_title=explode(' ',$widget_custom_title);
unset($widget_custom_title[0]);
$widget_custom_title=implode(' ',$widget_custom_title);
$type=str_replace(array("style='background-color:",";'"),"",$widget_bg_color);
if($type==''){
	$type=2;
}

/*get site url */
	if($render_mode=='nie'):
		$external_site='https://www.newindianexpress.com';
		$api_url='https://www.newindianexpress.com/news-sitemap.xml';
	elseif($render_mode=='sm'):
		$external_site='https://www.samakalikamalayalam.com';
		$api_url='https://www.samakalikamalayalam.com/new-sitemap.xml';
		$site_image = 'https://images.samakalikamalayalam.com/images/FrontEnd/images/NIE-logo21.jpg';
	elseif($render_mode=='ed'):
		$external_site='https://www.edexlive.com';
		$api_url='https://www.edexlive.com/new-sitemap.xml';
	elseif($render_mode=='in'):
		$external_site='https://www.indulgexpress.com';
		$api_url='https://www.indulgexpress.com/new-sitemap.xml';
	elseif($render_mode=='dn'):
		$external_site='https://www.dinamani.com';
		$api_url='https://www.dinamani.com/new-sitemap.xml?latest=true&id=2';
		$site_image = 'https://images.dinamani.com/images/FrontEnd/images/dmlogo1.jpg';
	elseif($render_mode=='kp'):
		$external_site='https://www.kannadaprabha.com';
		$api_url='https://nxt.kannadaprabha.com/customfeed2/top15news';
	elseif($render_mode=='cs'):
		$external_site='https://www.cinemaexpress.com';
		$api_url='https://www.cinemaexpress.com/news-sitemap.xml';
		$site_image = 'https://images.cinemaexpress.com/images/FrontEnd/images/NIE-logo21.png';
	endif;
/*end*/
$part='';
$part_new='';
if($type==2):
$class=rand().$widget_instance_id.'-2';
endif;
if($type==3):
$class1=rand().$widget_instance_id.'-3';
endif;
$part .='<div class="nie_external_api nie_api_'.$class.'">';
$part .='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-0"><a target="_BLANK" href="'.$external_site.'"><div class="tamilnews_heading external_heading_'.$class.'"><img src="'.$site_image.'"></div></a></div>';

if($render_mode=='cs'){
$part_new .='<div class="external_api_nie nie_api_'.$class1.'">';
$part_new .='<h4 style="background: linear-gradient(to bottom, rgba(56,2,9,1) 0%, rgba(56,2,9,1) 2%, rgba(214,23,58,1) 29%, rgba(227,12,55,1) 34%, rgba(227,12,55,1) 37%, rgba(214,23,58,1) 43%, rgba(56,2,9,1) 82%, rgba(56,2,9,1) 100%);" class="magazine-up-title"><a target="_BLANK" href="'.$external_site.'"><img style="width: 25%;" class="magazine-s" src="'.$site_image.'"></a></h4>';
$part .='</div>';
}else{
	$part_new .='<div class="external_api_nie nie_api_'.$class1.'">';
	$part_new .='<h4 class="external_api_header_nie"><a target="_BLANK" href="'.$external_site.'"><img src="'.$site_image.'"></a></h4>';
	$part .='</div>';
}

$part_new .='</div>';

?>

<?php
if($status==405):
	print $Status_message;
else:
	if($type==0 || $type==2){
		echo $part;
	}else{
		echo $part_new;
	}
	
endif;
	if($type==2 || $type==3){
	?>
		<script>
			var widget_instance_id="<?php print $class ?>";
			var widget_instance_id1="<?php print $class1 ?>";
			var widget_title="<?php print $widget_custom_title ?>";
			var widget_title_new="<?php print $title_new ?>";
			var external_url="<?php print $external_site ?>";
			var template_type="<?php print $type ?>";
			//alert(template_type);
			function load_external_api_nie(widget_instance_id,widget_instance_id1,widget_title,external_url,template_type,widget_title_new){
				var element_count="<?php print $max_article ?>";
				element_count=parseInt(element_count);
				var render_mode="<?php  print $render_mode ?>";
				if(render_mode=='ed' || render_mode=='in'){
					var font_size='style="font-size:14px;"';
				}else{
					var font_size='';
				}
				if(render_mode=="kp"){
					var rule_url='https://nxt.kannadaprabha.com/customfeed2/top15news';
				}else{
					var rule_url='<?php print BASEURL ?>user/commonwidget/external_api';
				}
				if(render_mode=='dn'){
					var dummy_image='https://images.dinamani.com/uploads/user/imagelibrary/logo/dinamani_logo_600X390.jpg';
					var dummy_image1='https://images.dinamani.com/uploads/user/imagelibrary/logo/dinamani_logo_600X390.jpg';
				}else if(render_mode=='sm'){
			var dummy_image='https://images.samakalikamalayalam.com/uploads/user/imagelibrary/logo/nie_logo_600X390.jpg';
		var dummy_image1='https://images.samakalikamalayalam.com/uploads/user/imagelibrary/logo/nie_logo_600X390.jpg';
				}else if(render_mode=='ed'){
					var dummy_image='https://images.edexlive.com/uploads/user/imagelibrary/logo/nie_logo_150X150.jpg';
					var dummy_image1='https://images.edexlive.com/uploads/user/imagelibrary/logo/nie_logo_100X65.jpg';
				}else if(render_mode=='in'){
					var dummy_image='https://images.indulgexpress.com/uploads/user/imagelibrary/logo/nie_logo_150X150.jpg';
					var dummy_image1='https://images.indulgexpress.com/uploads/user/imagelibrary/logo/nie_logo_100X65.jpg';
				}else if(render_mode=='nie'){
					var dummy_image='https://images.newindianexpress.com/uploads/user/imagelibrary/logo/nie_logo_150X150.jpg';
					var dummy_image1='https://images.newindianexpress.com/uploads/user/imagelibrary/logo/nie_logo_100X65.jpg';
				}else if(render_mode=='cs'){
					var dummy_image='https://images.cinemaexpress.com/uploads/user/imagelibrary/logo/nie_logo_150X150.jpg';
					var dummy_image1='https://images.cinemaexpress.com/uploads/user/imagelibrary/logo/nie_logo_100X65.jpg';
				}else{
					var dummy_image='https://images.newindianexpress.com/uploads/user/imagelibrary/logo/nie_logo_150X150.jpg';
					var dummy_image1='https://images.newindianexpress.com/uploads/user/imagelibrary/logo/nie_logo_100X65.jpg';
				}
				$.post(rule_url,{ url: "<?php print $api_url ?>" }, function(data){
					 var template='';
					var template_new='';
					template +='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-0"><a target="_BLANK" href="'+external_url+'"<div class="tamilnews_heading external_heading_'+widget_instance_id+'"><img src="<?php echo $site_image ?>"></div></a></div>';
					if(render_mode=='cs'){
						template_new +='<h4 style="background: linear-gradient(to bottom, rgba(56,2,9,1) 0%, rgba(56,2,9,1) 2%, rgba(214,23,58,1) 29%, rgba(227,12,55,1) 34%, rgba(227,12,55,1) 37%, rgba(214,23,58,1) 43%, rgba(56,2,9,1) 82%, rgba(56,2,9,1) 100%);" class="magazine-up-title"><a target="_BLANK" href="'+external_url+'"><img style="width: 25%;" class="magazine-s" src="<?php echo $site_image ?>"></a></h4>';
					}else{
						template_new +='<h4 class="external_api_header_nie '+((render_mode=='dn')?'din-external':'')+'"><a target="_BLANK" href="'+external_url+'"><img width="78" height="51" src="<?php echo $site_image ?>"></a></h4>';
					}
					
					if(render_mode=='kp'){ var xml='item'; }else{var xml='url';}
					$(data).find(xml).each(function(index) {
						
						if(index < element_count){
						if(render_mode=='kp'){
							var title = $(this).find('Title').text().trim();
						}else{
							if(jQuery.type($(this).find('news').context.children[2].children[2])==="undefined"){
								var title = '';
							}else{
							var title = $(this).find('news').context.children[2].children[2].innerText;
							title=title.replace(/&nbsp;/g,'');
							}
						}
						if(render_mode=='kp'){
							var image = $(this).find("image").text().trim();
						}else{
							if(jQuery.type($(this).find('news').context.children[3])==="undefined"){
								var image = '';
							}else{
								var image = $(this).find('news').context.children[3].innerText;
							}
						}
						if(image=='' || image==undefined){ image=dummy_image;}
						if(render_mode=='kp'){
							var name='Kanadaprabha';
						}else{
							if(jQuery.type($(this).find('news').context.children[2].children[0].children[0])==="undefined"){
								var name = '';
							}else{
								var name = $(this).find('news').context.children[2].children[0].children[0].innerText;
							}
						}
						image=image.replace('original','w600X390');
						if(render_mode=='kp'){
							var published_date=$(this).find("Pubdate").text().toString();
							published_date=published_date.split('+');
							published_date=published_date[0].split('  ');
						}else{
							if(jQuery.type($(this).find('news').context.children[1])==="undefined"){
								published_date=new Date();
							}else{
								var published_date=$(this).find('news').context.children[1].innerText;
								published_date=published_date.split('T');
								published_date=published_date[0];
							}
							
						}
						
						if(render_mode=='kp'){
							var url=$(this).find("link").text();
						}else{
							var url=$(this).find("loc").text();
							url=url.split(' ');
							url=url[0];
						}
						
						
						template +='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-0 newswrap">';
						template +='<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 padding-0"><img src="'+image+'" class="img-responsive img-circle imgtamil_circle"></div>';
						if(render_mode=='kp'){
							var temp_date=published_date[0];
						}else{
							var now=new Date();
							var new_date = new Date(published_date);
							var month = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"][new_date.getMonth()];
							var temp_date = month + ' '+ new_date.getDate() +' '+ new_date.getFullYear();
						}
						template +='<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 padding-0"><div class="tamilnews_lead" '+font_size+'><a target="_BLANK" href="'+url+'">'+title.replace( /<.*?>/g, '' )+'</a></div><div class="external_publishtime"><div class="publishtime_hrs"><i class="fa fa-clock-o hrs_icon" aria-hidden="true"></i>  '+temp_date+'</div></div></div>';
						template +='<a target="_BLANK" href="'+url+'"><i class="fa fa-share arrow_circle" ></i></a></div>';
						
	
						template_new +='<div class="externalwrap">';
						if(index==0){					
							template_new +='<img width="78" height="51" src="'+image+'" class="img-responsive img_external" >';
							template_new +='<div class="external_leadwrap">';
						}else{
							template_new +='<div class="external_leadwrap" style="width:100%;margin-top:0;">';
							
						}
						
						/* template_new +='<div class="publishtime_external">';
						template_new +='<div class="publishtime_hrs_external">'+name+'</div>';
						template_new +='<div class="publishtime_date_external"><i class="fa fa-calendar hrs_icon" aria-hidden="true"></i> '+temp_date+'</div>';
						template_new +='</div>'; */
						template_new +='<div class="external_lead" '+font_size+'>';
						if(index!=0){
						template_new +='<i class></i>';
						}
						template_new +='<a target="_BLANK" href="'+url+'">'+title.replace( /<.*?>/g, '' )+'</a>';
						template_new +='</div></div></div>';
						}
					});
					 if(template_type==2){
						$('.nie_api_'+widget_instance_id).html(template);
					}else{
						$('.nie_api_'+widget_instance_id1).html(template_new);
					} 
					
				
					
					
			});
		}
			load_external_api_nie(widget_instance_id,widget_instance_id1,widget_title,external_url,template_type,widget_title_new);
			
		</script>
	<?php
	}
 ?>
