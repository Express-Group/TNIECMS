<style>
.leadcontent_news{width:100%;float:left;background:#eee;display: flex;overflow-x: scroll;padding:1%;}
.leadcontent_news .items{width:29%;float:left;margin-right:1%;background:#fff;flex: 0 0 auto;box-shadow: 1px 1px 1px #00000045;position: relative;}
.leadcontent_news .items .img-s{width:30%;float:left;}
.leadcontent_news .items .img-s img{margin: 4%;border: 1px solid #ddd;}
.leadcontent_news .items .ln-content{float: left;width: 70%;padding-left: 10px;padding-top: 2%;position: absolute; right: 0;bottom: 0;}
.leadcontent_news .items .ln-content h5{margin: 10px 0 5px;font-family: Droid Serif !important;font-size:15px;} 
.leadcontent_news .items .ln-content p:first-of-type{margin-bottom: 4px;font-size:16px;}
.leadcontent_news .items .ln-content p:last-child{font-family: 'Oswald', sans-serif;font-weight: bold;color: green;margin-bottom: 3px;font-size: 16px;}
@media only screen and (max-width: 1550px) and (min-width: 1297px){
	.leadcontent_news .items .ln-content h5 ,.leadcontent_news .items .ln-content p:first-of-type{font-size:13px;}
	.leadcontent_news .items .ln-content p:last-child{font-size: 12px;}
}
@media only screen and (max-width: 991px){
	.leadcontent_news{padding:2%;}
	.leadcontent_news .items{width: 73%;}
	.leadcontent_news .items .ln-content{padding-top: 1%;bottom: 0px;}
	.leadcontent_news .items .ln-content h5 ,.leadcontent_news .items .ln-content p:first-of-type{font-size:11px;}
	.leadcontent_news .items .ln-content p:last-child{font-size: 11px;}
}
</style>
<?php
$widget_bg_color         = $content['widget_bg_color'];
$widget_custom_title     = $content['widget_title'];
$widget_instance_id      =  $content['widget_values']['data-widgetinstanceid'];
$widget_section_url      = $content['widget_section_url'];
$is_home                 = $content['is_home_page'];
$main_sction_id 	     = $content['sectionID'];
$is_home                 = $content['is_home_page'];
$is_summary_required     = $content['widget_values']['cdata-showSummary'];
$domain_name             =  base_url();
$view_mode               = $content['mode'];
$show_simple_tab         = "";
$max_article             = $content['show_max_article'];
$render_mode             = $content['RenderingMode'];
$pageId  = $content['widget_values']['data-widgetpageid'];
if(trim($main_sction_id)==''){
	$CI = &get_instance();
	$this->live_db = $CI->load->database('live_db',TRUE);
	$sectionID = $this->live_db->query("SELECT menuid FROM page_master WHERE id='".$pageId."'")->result();
	$main_sction_id = $sectionID[0]->menuid;
}
$template ='';
$template .='<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
$template .='<fieldset class="FieldTopic"><legend class="topic">'.$widget_custom_title.'</legend></fieldset>';
$template .='<div class="leadcontent_news margin-bottom-15" id="leadcontent_news'.$widget_instance_id.'"></div>';
$template .='</div></div>';
echo $template;
?>
<script>
$(document).ready(function(e){
	$.ajax({
		type:'post',
		url:'<?php base_url() ?>user/commonwidget/leadcontent_news',
		data:{'sectionID' : '<?php echo $main_sction_id ?>'},
		cache:false,
		success:function(result){
			if(result!=''){
				$('#leadcontent_news<?php echo $widget_instance_id ?>').html(result).show();
			}else{
				$('#leadcontent_news<?php echo $widget_instance_id ?>').hide();
			}
		},
		error:function(err){
			console.log(err.statusText);
		}
	})
});
</script>