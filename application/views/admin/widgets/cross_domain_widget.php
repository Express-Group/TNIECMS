<style>
.crs-switch{flex: 1;display: flex;overflow-x: scroll;}
.crs-switch .video-widget-up{flex: 0 0 auto;}
@media only screen and (max-width: 767px){
#crs-switch::-webkit-scrollbar{background: lightyellow;width: 12px;}
#crs-switch::-webkit-scrollbar-track{-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);border-radius: 10px;}
#crs-switch::-webkit-scrollbar-thumb{border-radius: 10px;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);}	
}
</style>
<?php 
$widget_bg_color         = $content['widget_bg_color'];
$widget_custom_title     = $content['widget_title'];
$widget_instance_id      =  $content['widget_values']['data-widgetinstanceid'];
$widget_section_url      = $content['widget_section_url'];
$is_home                 = $content['is_home_page'];
$main_sction_id 	     = "";
$is_home                 = $content['is_home_page'];
$is_summary_required     = $content['widget_values']['cdata-showSummary'];
$domain_name             =  base_url();
$view_mode               = $content['mode'];
$show_simple_tab         = "";
$max_article             = $content['show_max_article'];
$render_mode             = $content['RenderingMode'];
$show_simple_tab     = "";
$domainType = str_replace(["style='background-color:" ,";'"],'',$widget_bg_color);
if($domainType=='1'){
	$domainName = 'https://www.cinemaexpress.com/';
	$dummyImage = 'https://images.cinemaexpress.com/uploads/user/imagelibrary/logo/nie_logo_600X300.jpg';
	$imagePath = 'https://images.cinemaexpress.com/uploads/user/imagelibrary/';
	$jsonUrl = "https://www.cinemaexpress.com/articles/37/".time()."/section.json";
}else if($domainType=='2'){
	$domainName = 'https://www.indulgexpress.com/';
	$dummyImage = 'https://images.indulgexpress.com/uploads/user/imagelibrary/logo/nie_logo_600X300.jpg';
	$imagePath = 'https://images.indulgexpress.com/uploads/user/imagelibrary/';
	$jsonUrl = "https://www.indulgexpress.com/articles/221/".time()."/section.json";
}else{
	$domainName = 'https://www.edexlive.com/';
	$dummyImage = 'https://images.edexlive.com/uploads/user/imagelibrary/logo/nie_logo_600X300.jpg';
	$imagePath = 'https://images.edexlive.com/uploads/user/imagelibrary/';
	$jsonUrl =  "https://www.edexlive.com/articles/37/".time()."/section.json"; 
}

$show_simple_tab    .='<div class="row video-widget-up-wrapper">
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottom-space-10">
			           <div class="GalleryVideo crossd-'.$widget_instance_id.'">';
					   	
														
if(strtolower(trim($widget_custom_title))!='none'){
	$show_simple_tab.=	'<fieldset class="FieldTopic"><legend class="topic"><a target="_BLANK" href="'.$domainName.'">'.$widget_custom_title.'</a></legend></fieldset>';
}
$show_simple_tab.= '<div id="crs-switch" class="g_whole crs-switch">'; 	
$show_simple_tab.= '<div class="col-md-12 col-xs-12 text-center"><i style="font-size: 21px;color: #09155E!important; margin-bottom: 10px;" class="fa fa-refresh fa-spin"></i></div>'; 	
$show_simple_tab.= '</div>'; 	
$show_simple_tab .=' </div></div></div>';
echo $show_simple_tab;
?>
<script type="text/javascript">
var t='';
fetch('<?php echo $jsonUrl; ?>' , {cache: "no-cache"}).then((resp) => resp.json()).then(function(data) {
	$(data['content']).each(function(index){
		var url = "<?php echo $domainName ?>"+data['content'][index].url;
		var image = "<?php echo $dummyImage ?>";
		var articleTitle = data['content'][index].title.replace(/(<([^>]+)>)/ig,"");
		if(articleTitle.length > 70){
			articleTitle  = articleTitle.substr(0, 67)+'...';
		}
		var alt = title = " ";
		if(data['content'][index].article_page_image_path!=''){
			image = "<?php echo $imagePath; ?>"+data['content'][index].article_page_image_path.replace('original/' , 'w600X300/');
			alt = data['content'][index].article_page_image_alt;
			title = data['content'][index].article_page_image_title;
		}
		//console.log(data['content'][index].content_id);
		t +='<figure class="col-lg-3 col-md-3 col-sm-12 col-xs-12 video-widget-up" style="position:relative;">';
		t +='<a class="article_click" href="'+url+'" target="_BLANK">';
		t +='<img src="'+image+'" data-src="'+image+'" title = "'+title+'" alt = "'+alt+'" width="600" height="300">';
		t +='</a>';
		t +='<div class="TransSmall"><a class="article_click" href="'+url+'" target="_BLANK">'+articleTitle+'</a></div>';
		t +='</figure>';
	});
	$('.crossd-<?php echo $widget_instance_id ?>').find('.g_whole').html(t);
	
});
</script>
 