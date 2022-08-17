<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
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
//$start_time = microtime(true);
/************* Widget HTML Starts here ***********************/
$show_simple_tab     = "";
$show_simple_tab    .='<div class="row video-widget-up-wrapper">
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottom-space-10">
			           <div class="GalleryVideo" '.$widget_bg_color.'>';
					   	
														
if($content['widget_title_link'] == 1 && strtolower(trim($widget_custom_title))!='none'){
	$show_simple_tab.=	'<fieldset class="FieldTopic"><legend class="topic"><a  href="'.$widget_section_url.'"  >'.$widget_custom_title.'</a></legend></fieldset>';
}else{
	if(strtolower(trim($widget_custom_title))!='none'):
		$show_simple_tab.=	'<fieldset class="FieldTopic"><legend class="topic">'.$widget_custom_title.'</legend></fieldset>';
	endif;
}
	
	$j = 0;
		              /************************* getting content block - getting content list based on rendering mode ********************/
		//getting content block starts here .
		if($render_mode == "manual")
		{
			$content_type = $content['content_type_id'];  // auto article content type
			$widget_instance_contents 	= $this->widget_model->get_widgetInstancearticles_rendering($widget_instance_id , " " ,$content['mode'], $max_article); 				
		}
		else
		{
		   $content_type = $content['content_type_id'];  // auto article content type
		   $widget_instance_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'] , $content_type ,  $content['mode'], $is_home);
		}
		
		              /********************* content list iteration block - Looping through content list and adding it the list ********************/
		// content list iteration block starts here
		$i =1;
		$count = 1;
	if(count($widget_instance_contents)>0)
	{
		foreach($widget_instance_contents as $get_content)
		{
			if($render_mode == "manual"){
			$content_type = $get_content['content_type_id'];  // from widgetinstancecontent table
			$content_details = $this->widget_model->get_contentdetails_from_database($get_content['content_id'], $content_type, $is_home, $view_mode);
			}else{
			 $content_type = $content['content_type_id'];  // from xml
			}
			$custom_title        = "";
			$custom_summary      = "";
			$original_image_path = "";
			$imagealt            = "";
			$imagetitle          = "";
			$Image600X390        = "";
			if($render_mode == "manual")            // from widgetinstancecontent table    
			{
				if($get_content['custom_image_path'] != '')
				{
					$original_image_path = $get_content['custom_image_path'];
					$imagealt            = $get_content['custom_image_title'];	
					$imagetitle          = $get_content['custom_image_alt'];												
				}
					$custom_title        = stripslashes($get_content['CustomTitle']);
					$custom_summary      = $get_content['CustomSummary'];
					$content_url         = $content_details[0]['url'];

			}
			else
				{
				    $content_url    = $get_content['url'];
					$custom_title   = $get_content['title'];
					$custom_summary = $get_content['summary_html'];
				}
			if($original_image_path =="" && $render_mode =="manual")     // from cms || Live table    
				{
					   $original_image_path  = $content_details[0]['ImagePhysicalPath'];
					   $imagealt             = $content_details[0]['ImageCaption'];	
					   $imagetitle           = $content_details[0]['ImageAlt'];	
				}	
			else if($original_image_path =="" && $render_mode =="auto")                 // from cms || Live table    
			{
				   $original_image_path  = $get_content['ImagePhysicalPath'];
				   $imagealt             = $get_content['ImageCaption'];	
				   $imagetitle           = $get_content['ImageAlt'];	
			}
		
		if ($original_image_path!='' && get_image_source($original_image_path, 1))
		{
			$imagedetails = get_image_source($original_image_path, 2);
			$imagewidth = $imagedetails[0];
			$imageheight = $imagedetails[1];	
			if ($imageheight > $imagewidth){
				$Image600X390 	= $original_image_path;
			}else{
				$Image600X390  = str_replace("original","w600X300", $original_image_path);
			}
			if ($Image600X390 != '' && get_image_source($Image600X390, 1))
			{
				$show_image = image_url. imagelibrary_image_path . $Image600X390;
			}
			else 
			{
				$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
			}
		}	
		else 
		{
			$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
		}
$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';		
				
				                               /******************** article title and summary and url ********************/
				$param = $content['close_param']; //page parameter
				$live_article_url = $domain_name. $content_url.$param;
			
				if( $custom_title == '' && $render_mode=="manual" )
					{
						$custom_title = $content_details[0]['title'];
					}	
				$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_title);   //to remove first<p> and last</p>  tag
				$display_title = '<a  href="'.$live_article_url.'" class="article_click" >'.$display_title.'</a>';			
				/*if( $custom_summary == '' && $render_mode=="manual")
				{
					$custom_summary =  $content_details[0]['summary_html'];
				}*/
				$summary  = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_summary);  //to remove first<p> and last</p>  tag
		
				                        /******************** display title and summary block starts here ********************************/
			
				if($count <= 4)
	{
		if($count==1)
		{
		$show_simple_tab.= '<div class="g_whole">'; 
		} 
	$show_simple_tab.= '<figure class="col-lg-3 col-md-3 col-sm-3 col-xs-12 video-widget-up" style="position:relative;">
	<a   href="'.$live_article_url.'">';
	$show_simple_tab.='<img width="600" height="300" src="'.$dummy_image.'" data-src="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'">';
	if($content_type==4){ $show_simple_tab .='<span class="icon-gl-vd icon-vd"></span>'; }
	if($content_type==3){ $show_simple_tab .='<span class="icon-gl-vd icon-gl"></span>'; }
	
	$show_simple_tab.='</a><div class="TransSmall">'.$display_title;
	if($is_summary_required== 1){
		$show_simple_tab .='<p class="articlewidget-summary">'.$summary.'</p>';
	}
	$show_simple_tab.= '</div></figure>';
	
		if($count==4)
		{ 
		$show_simple_tab.=  '</div>';
		$count=0;
		} 
		
	$count ++;
		
	}
	
	if($i==count($widget_instance_contents))
	{
		if($i%4!=0)
		{
		$show_simple_tab.= '</div>'; 
		}
	}
			
			// display title and summary block ends here					
			//Widget design code block 1 starts here																
		//Widget design code block 1 starts here			
		$i =$i+1;							  
	}
}elseif($view_mode=="adminview")
{
	$show_simple_tab .='<div class="margin-bottom-10">'.no_articles.'</div>';
}

$show_simple_tab .=' </div></div></div>';
echo $show_simple_tab;
?>
