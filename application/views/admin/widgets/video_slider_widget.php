<?php
$widget_instance_id   = $content['widget_values']['data-widgetinstanceid'];
?>
<style>
.galleries_slider<?php echo $widget_instance_id; ?>{background: #f8f8f8;padding: 5px;}
.galleries_slider<?php echo $widget_instance_id; ?> .gal_split1{margin-top: 1%;padding: 0;}
.galleries_slider<?php echo $widget_instance_id; ?> .slick-prev{right: 27px;left: unset;}
.galleries_slider<?php echo $widget_instance_id; ?> .slick-prev , .galleries_slider<?php echo $widget_instance_id; ?> .slick-next{top: 3%;background: red;color: #fff;}
.galleries_slider<?php echo $widget_instance_id; ?> .slick-next:before, .galleries_slider<?php echo $widget_instance_id; ?> .slick-prev:before{font-size: 15px;}
.galleries_slider<?php echo $widget_instance_id; ?> .gallcommon{float: left;width: 100%;margin-bottom: 2%;}
.galleries_slider<?php echo $widget_instance_id; ?> .PositionRelative{width: 44%;float: left;}
.galleries_slider<?php echo $widget_instance_id; ?> p{float: left;width: 54%;padding-left: 2%;font-size: 16px;}
@media only screen and (min-width: 1551px){
	.galleries_slider<?php echo $widget_instance_id; ?> p{font-size: 18px;}
}
@media only screen and (max-width: 767px){
	.galleries_slider<?php echo $widget_instance_id; ?> p{font-size: 14px;}
}
</style>
<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$CI = &get_instance();
$this->live_db = $CI->load->database('live_db' , TRUE);
$widget_bg_color      = $content['widget_bg_color'];
$widget_custom_title  = $content['widget_title'];

$main_sction_id 	  = "";
$widget_section_url   = $content['widget_section_url'];
$is_home              = $content['is_home_page'];
$view_mode            = $content['mode'];
$max_article         = ($content['show_max_article'] == 'undefined') ? 5 : $content['show_max_article'] ;
$render_mode          = $content['RenderingMode'];
if($widget_custom_title==1){
	$type=0;
}else{
	$type=1;
}
// widget config block ends
// Code block A - this code block is needed for creating simple tab widget. Do not delete
$domain_name =  base_url();

if($widget_custom_title == "")
	$widget_custom_title = "Gallery";
	
$show_simple_tab = "";
$show_simple_tab .='<div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottom-space-10">
            <div class="allgallery" '.$widget_bg_color.'>';
			
			$content_type = $content['content_type_id'];  // manual article content type
			$widget_contents = array();
			
				//getting content block - getting content list based on rendering mode
				//getting content block starts here . Do not change anything
				if($render_mode == "manual")
				{
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
					
				}
				else
				{
                   //  $widget_instance_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'], $content_type ,  $view_mode);		
				   $widget_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'] , $content_type ,  $content['mode'], $is_home);
				}
				
				
				$i =1;
				$count = 1;
		if(count($widget_contents)>0)
		     {			
				foreach($widget_contents as $get_content)
				{
					$custom_title        = "";
					$original_image_path = "";
					$imagealt            = "";
					$imagetitle          = "";
					$Image600X300        = "";
					if($render_mode == "manual")
					{
						if($get_content['custom_image_path'] != '')
						{
							$original_image_path = $get_content['custom_image_path'];
							$imagealt            = $get_content['custom_image_title'];	
							$imagetitle          = $get_content['custom_image_alt'];												
						}
						$custom_title            = stripslashes($get_content['CustomTitle']);
					}
						if($original_image_path =="")          // from cms imagemaster table    
						{
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
								$Image600X300  = str_replace("original","w600X300", $original_image_path);
							}
							if (get_image_source($Image600X300, 1) && $Image600X300 != '')
							{
								$show_image = image_url. imagelibrary_image_path . $Image600X300;
							}
							else {
								$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
							}
							$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
						}
						else{
							$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
						}
						$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
						
						$content_url = $get_content['url'];
						$param = $content['close_param']; //page parameter
						$live_article_url = $domain_name. $content_url.$param;
					
						if( $custom_title == '')
						{
							$custom_title = stripslashes($get_content['title']);
						}	
						$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_title);
						$display_title = '<a  href="'.$live_article_url.'" class="article_click" >'.$display_title.'</a>';
						
							
					//  Assign article links block ends hers
												
				
							if($i == 1) {
								$show_simple_tab.=	'<div id="ms-'.$widget_instance_id.'" class="slide galleries_slider'.$widget_instance_id.'">';
							}
							
							if($count <= 3)
							{
								if($count==1)
								{
								
								$show_simple_tab.= '<div class="gal_split1">'; 
								} 
								$videoDetails = $this->live_db->query("SELECT video_script FROM video WHERE content_id='".$get_content['content_id']."'")->row_array();
								$vscript = preg_replace('/height=\\"[^\\"]*\\"/', '', $videoDetails['video_script']);
								$vscript = str_replace('<iframe' , '<iframe class="nie-yts autoplay" ' ,$vscript);
								if($type==0){
									$vscript = '<h5 style="font-weight: 700;margin-bottom: 0;"><span style="background: red;color: #fff;padding: 5px 10px 5px;display: inline-block;    border-top-left-radius: 8px;border-top-right-radius: 8px;float: left;">Express Expressions</span></h5>'.$vscript;
								}else{
									$vscript = '<h5 style="font-weight: 700;margin-bottom: 0;"><span style="background: red;color: #fff;padding: 5px 10px 5px;display: inline-block;    border-top-left-radius: 8px;border-top-right-radius: 8px;float: left;">Timepass</span></h5>'.$vscript;
								}
								$vscript .= '<p><a  href="'.$live_article_url.'"  class="article_click"  >'.strip_tags($display_title).'</a></p>';
								
								$show_simple_tab.=	'<div class="gallcommon"><a class="article_click yms"  cid="'.$get_content['content_id'].'">
							 <figure class="PositionRelative"><img src="'.$dummy_image.'" data-lazy="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'">
							 <span class="icon-gl-vd icon-vd-center"></span></figure></a>
												<p><a class="article_click yms"  cid="'.$get_content['content_id'].'">'.strip_tags($display_title).'</a></p><textarea class="tys-'.$get_content['content_id'].'" style="display:none;">'.$vscript.'</textarea></div>';
								if($count==3 )
								{
									 
								$show_simple_tab.=  '</div>';
								
								$count=0;
								
								} 
								if($i == count($widget_contents))
								{
									if($i%3!=0)
									{
									$show_simple_tab .='</div>';
									} 
									$show_simple_tab .='</div>';
								}
							$count ++;	
							}

						
					$i =$i+1;
					
					
					
				}
				// content list iteration block ends here
		//}
	}
	 elseif($view_mode=="adminview")
	{
	 $show_simple_tab .='<div class="margin-bottom-10">'.no_articles.'</div>';
	}

$show_simple_tab .='</div>
</div></div>';
																			  
												
																			  
echo $show_simple_tab;
?>
<script>
$(document).ready(function(e){
	$(".galleries_slider<?php echo $widget_instance_id ?>").slick({dots:!1,infinite:!0,speed:500,autoplayspeed:500,slidesToShow:1,lazyLoad:"ondemand",slidesToScroll:1,responsive:[{breakpoint:450,settings:{slidesToShow:1,slidesToScroll:1}}]});
	
	$('#ms-<?php echo $widget_instance_id; ?>').find('.yms').on('click' ,function(e){
	var cid = $(this).attr('cid');
	var content = $('.tys-'+cid).val();
	$('.widget-container-191').find('.ReplyForm').eq(<?php echo $type ?>).html(content);
	$('html, body').animate({
        'scrollTop' : $('.widget-container-191').find('.ReplyForm').eq(<?php echo $type ?>).position().top
    });
});
});

</script>
