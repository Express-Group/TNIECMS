<style>.breaking-type-3{margin:7px 0 7px;}.breaking-type-3 p ,.breaking-type-3 p a{border-bottom:none;color: #000!important;font-size: 13px;}</style>
<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color 		= $content['widget_bg_color'];
$widget_custom_title 	= $content['widget_title'];
$widget_instance_id 	= $content['widget_values']['data-widgetinstanceid'];
$main_sction_id 		= "";
$widget_section_url 	= $content['widget_section_url'];
$is_home 				= $content['is_home_page'];
$is_summary_required     = $content['widget_values']['cdata-showSummary'];
$view_mode            	= $content['mode'];
$max_article            = $content['show_max_article'];
$render_mode            = $content['RenderingMode'];
// widget config block ends

$domain_name =  base_url();
$show_simple_tab = "";
$show_simple_tab .='<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 SpecialLeadStory ">
					<div class="headline1 margin-bottom-15">';	

if($content['widget_title_link'] == 1){
	if(strtolower(strip_tags($widget_custom_title))!='none'){
		$show_simple_tab.=	'<h5><a href="'.$widget_section_url.'">'.$widget_custom_title.'</a></h4>';
	}
}
else{
	if(strtolower(strip_tags($widget_custom_title))!='none'){
		$show_simple_tab.=	'<h5>'.$widget_custom_title.'</h4>';
	}
}
$content_type 		= $content['content_type_id'];  // manual article content type
$widget_contents 	= array();
//getting content block - getting content list based on rendering mode
//getting content block starts here . Do not change anything
if($render_mode == "manual"){
	$widget_instance_contents 	= $this->widget_model->get_widgetInstancearticles_rendering($widget_instance_id, " ", $view_mode, $max_article);
	
	$get_content_ids = array_column($widget_instance_contents, 'content_id'); 
	$get_content_ids = implode("," ,$get_content_ids); 
	
	if($get_content_ids!='')
	{
		$widget_instance_contents1 = $this->widget_model->get_contentdetails_from_database($get_content_ids, $content_type, $is_home, $view_mode);	
		foreach ($widget_instance_contents as $key => $value) {
			foreach ($widget_instance_contents1 as $key1 => $value1) {
				if($value['content_id']==$value1['content_id']){
					$widget_contents[] = array_merge($value, $value1);
				}
			}
		}
	}	
	
} else {	
	$widget_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'] , $content_type ,  $content['mode'], $is_home);
}
//getting content block ends here
/*
if (function_exists('array_column')) 
{
	$get_content_ids = array_column($widget_instance_contents, 'content_id'); 
}
else
{
	$get_content_ids = array_map( function($element) { return $element['content_id']; }, $widget_instance_contents);
}
$get_content_ids = implode("," ,$get_content_ids);

if($get_content_ids!='')
{

	$widget_instance_contents1 = $this->widget_model->get_contentdetails_from_database($get_content_ids, $content_type, $is_home, $view_mode);	
	$widget_contents = array();
	foreach ($widget_instance_contents as $key => $value) {
		foreach ($widget_instance_contents1 as $key1 => $value1) {
			if($value['content_id']==$value1['content_id']){
			   $widget_contents[] = array_merge($value, $value1);
			}
		}
	}
*/
	$i =1;
	if(count($widget_contents) > 0 ){
		// content list iteration block - Looping through content list and adding it the list
		// content list iteration block starts here
		foreach($widget_contents as $get_content)
		{
			
			$original_image_path = "";
			$imagealt            = "";
			$imagetitle          = "";
			$custom_title        = "";
			$custom_summary      = "";
			if($render_mode == "manual"){
				if($get_content['custom_image_path'] != ''){
					$original_image_path = $get_content['custom_image_path'];
					$imagealt            = $get_content['custom_image_title'];	
					$imagetitle          = $get_content['custom_image_alt'];												
				}
				$custom_title   = $get_content['CustomTitle'];
				$custom_summary = $get_content['CustomSummary']; 
			}
			if($original_image_path ==""){  // from cms || live table   
			   $original_image_path  = $get_content['ImagePhysicalPath'];
			   $imagealt             = $get_content['ImageCaption'];	
			   $imagetitle           = $get_content['ImageAlt'];	
			}
			
			$show_image="";
			if($original_image_path !='' && get_image_source($original_image_path, 1))
			{
				$imagedetails = get_image_source($original_image_path, 2);
				$imagewidth = $imagedetails[0];
				$imageheight = $imagedetails[1];	
			
				if ($imageheight > $imagewidth)
				{
					$Image600X300 	= $original_image_path;
				}
				else
				{	
				    $Image600X300  = str_replace("original","w900X450", $original_image_path);
			    }				
				if (get_image_source($Image600X300, 1) && $Image600X300 != ''){
					$show_image = image_url. imagelibrary_image_path . $Image600X300;
				}
				else {
					$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
				}
				$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
			}
			else{
				$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
				$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
			}
			
			$content_url = $get_content['url'];
			$param = $content['close_param'];
			$live_article_url = $domain_name.$content_url.$param;
			$display_title = ( $custom_title != '') ? $custom_title : ( ($get_content['title'] != '') ? $get_content['title']: '' ) ;
			$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$display_title);
			$display_title = '<a  href="'.$live_article_url.'" class="article_click" >'.$display_title.'</a>';
			// Assign summary block starts here
			if( $custom_summary == '' && $render_mode=="auto")
				{
					$custom_summary =  $get_content['summary_html'];
				}
		   $custom_summary  = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_summary);  //to remove first<p> and last</p>  tag
			// display title and summary block starts here
			/*if($i == 1)
			{*/
				//$show_simple_tab .='<figure><a  href="'.$live_article_url.'"  class="article_click" >'.$img_icon.'<img src="'.$dummy_image.'" data-src="'.$show_image.'"></a></figure>';
				$show_simple_tab .='<a href="'.$live_article_url.'"  class="article_click"><picture>';
				$show_simple_tab .='<source media="(max-width: 1550px) and (min-width: 1297px)" srcset="'.str_replace('600X390' ,'600X390',$show_image).'">';
				$show_simple_tab .='<img src="'.$dummy_image.'" data-src="'.$show_image.'">';
				$show_simple_tab .='</picture></a>';
				$show_simple_tab .='<h4>'.$display_title.'</h4>';
				if($is_summary_required== 1){	
				 $show_simple_tab .= '<p class="para_bold padding-0 summary">'.$custom_summary.'</p>';
				}
				if($content['RenderingMode'] == "manual"){
					$get_related_article 	= $this->widget_model->get_widgetInstanceRelatedarticles_rendering($widget_instance_id, '','',$get_content['content_id'], $view_mode); 
					$static_id = "1531332";	
					if(count($get_related_article)>0) {
							$show_simple_tab .= '<div class="common_p breaking-type-3">';
							foreach($get_related_article as $key => $get_article){
								$content_type_id = $get_article['content_type_id'];
								$related_contents = $this->widget_model->get_contentdetails_from_database($get_article['content_id'], $content_type_id, $is_home, $view_mode);	
								if($get_article['CustomTitle'] != '') {
									$Title = $get_article['CustomTitle'];
								} else {
									$Title =  $related_contents[0]['Title'];
								}
								$content_url = $related_contents[0]['url'];
								$param = $content['close_param']; //page parameter
								$related_article_url = $domain_name. $content_url.$param;
								$Title =  preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$Title);
								$show_simple_tab .= '<p>  <i class="fa fa-circle"></i> <a  href="'.$related_article_url.'" class="article_click" >'.$Title.'</a>';
								if($content_type_id=='3'){
									$show_simple_tab .= '<i class="fa fa-picture-o lead_relate_icon"></i>';
								}
								elseif($content_type_id=='4'){
									$show_simple_tab .= '<i class="fa fa-video-camera lead_relate_icon"></i>';
								}
								elseif($content_type_id=='5'){
									$show_simple_tab .= '<i class="fa fa-volume-up lead_relate_icon"></i>';
								}
								$show_simple_tab .= '</p>';															
			
		
							}
							$show_simple_tab .= '</div>';
					}
	
				}
				
			/*}	*/	
			$i =$i+1;							  
		}// content list iteration block ends here
//	}
}
 elseif($view_mode=="adminview"){
	$show_simple_tab .='<div class="margin-bottom-10">'.no_articles.'</div>';
	/*$show_simple_tab = '';
	return false; */
}		

$show_simple_tab .='</div></div></div>';
echo $show_simple_tab;
?>
