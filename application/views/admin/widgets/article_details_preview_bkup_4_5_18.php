<?php
					$widget_instance_id =  $content['widget_values']['data-widgetinstanceid'];
				    $content_id         = $content['content_id'];
					$content_type_id    = $content['content_type'];
					$view_mode          = $content['mode'];
					if($content_id!=''){
						?>
                        <article class="WidthFloat_L printthis">
<?php
					$content_details = $this->widget_model->widget_article_content_preview($content_id, $content_type_id);
					$content_det= $content_details[0];
					$section_id = $content_det['Section_id'];
					$domain_name =  base_url();
					$section_details = $this->widget_model->get_sectionDetails($section_id, $view_mode);
					$home_section_name = 'Home';
					$child_section_name = $section_details['Sectionname'];
					$child_section_name1 = $section_details['URLSectionStructure'];
					$url_structure       = $section_details['URLSectionStructure'];
					$sub_section_name = 'Home';
					if($section_details['IsSubSection'] =='1'&& $section_details['ParentSectionID']!=''&& $section_details['ParentSectionID']!=0 ){
					$sub_section = $this->widget_model->get_sectionDetails($section_details['ParentSectionID'], $view_mode);
					$sub_section_name = ($sub_section['Sectionname']!='')? $sub_section['Sectionname'] : '' ;
					$sub_section_name1= $sub_section['URLSectionStructure'];
					 if($sub_section['IsSubSection'] =='1'&& $sub_section['ParentSectionID']!=''&& $sub_section['ParentSectionID']!=0 ){
					$grand_sub_section = $this->widget_model->get_sectionDetails($sub_section['ParentSectionID'], $view_mode);
					$grand_parent_section_name = $grand_sub_section['Sectionname'];
					$grand_parent_section_name1 = $grand_sub_section['URLSectionStructure'];
					$section_link = '<a href="'.$domain_name.'">'.$home_section_name.'</a> <i class="fa fa-angle-right"></i> <a href="'.$domain_name.$grand_parent_section_name1.'">'.$grand_parent_section_name.'</a> <i class="fa fa-angle-right"></i> <a href="'.$domain_name.$sub_section_name1.'">'.$sub_section_name.'</a> <i class="fa fa-angle-right"></i> <a href="'.$domain_name.$child_section_name1.'">'.$child_section_name.'</a>';
					}else{
					$section_link = '<a href='.$domain_name.' >'.$home_section_name.'</a> <i class="fa fa-angle-right"></i> <a href='.$domain_name.$sub_section_name1.' >'.$sub_section_name.'</a> <i class="fa fa-angle-right"></i> <a href='.$domain_name.$child_section_name1.' >'.$child_section_name.'</a>';
					}
					}elseif(strtolower($child_section_name) != "home"){
					$section_link = '<a href= '.$domain_name.' >'.$home_section_name.'</a> <i class="fa fa-angle-right"></i> <a href='.$domain_name.$child_section_name1.' >'.$child_section_name.'</a>';
					}elseif(strtolower($child_section_name) == "home" || strtolower($child_section_name) == "home"){
					$section_link = '<a href= '.$domain_name.' >'.$home_section_name.'</a>';
					}
				  echo '<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
				  echo '<div class="bcrums"> 
				   '.$section_link.'  </div>
				  </div>
				  </div>';
				  ?>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ArticleDetail">
    <?php 		
					
					//////  For Article title  ////		
					$content_title = $content_det['title'];
					if( $content_title != '')
					{
						//$content_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $content_title);
						$content_title = stripslashes(strip_tags($content_title, '</p>'));
					}
					else
					{
						$content_title = '';
					}

					$content_url = '';
					$author_name = "";
					$agency_name = "";
					$page_index_number = "";

					if($content_type_id ==1){	
					$linked_to_columnist = $content_det['Author_ID'];
					//if($linked_to_columnist!=''){
					$author_name = $content_det['AuthorName'];
					//}else{
					$agency_id   = $content_det['Agency_ID'];
					$is_author   = ($content_det['AuthorName']!='')? 1 : 0;
					$is_agency   = ($content_det['Agency_ID']!='')? 1 : 0;
					$author_pos  = stripos($author_name, $child_section_name);
					//$author_url  = ($author_pos === false)? "author/".join("-", explode(" ", $author_name)) : "columns/".join("-", explode(" ", $author_name));
					$author_url  = ($author_pos === false)? "author/".join("-", explode(" ", $author_name)) : $child_section_name1;
					if($agency_id!=''){
					$agency_det  = $this->widget_model->get_agency_byid($agency_id);
					$agency_name = $agency_det['Agency_name'];
					}
					//}
					}else{
					$is_author      = 0;
					$is_agency      = ($content_det['Agency_name']!='')? 1 : 0;
					$agency_name    = $content_det['Agency_name'];
					}
				
					
				   $published_date = date('dS  F Y h:i A' , strtotime($content_det['publish_start_date']));
				
				   $last_updated_date  = date('dS  F Y h:i A' , strtotime($content_det['Modifiedon']));
					
					$allow_social_btn= 1; //$content_det['allow_social_button'];
					$allow_comments= $content_det['Allowcomments'];
					
                    $hit_value = $this->widget_model->get_hit_for_content_by_id($content_id, $content_type_id); 
					$email_shared = (count($hit_value)>0)? $hit_value['emailed'] : 0; 
					if ($email_shared > 999 && $email_shared <= 999999) {
						$email_shared = round($email_shared / 1000, 1).'K';
					} else if ($email_shared > 999999) {
					  $email_shared = round($email_shared / 1000000, 1).'M';
					} else {
						$email_shared = $email_shared;
					}
					$publish_start_date = $content_det['publish_start_date'];
					?>
    <h1 class="ArticleHead" id="content_head" itemprop="name"><?php echo $content_title;?></h1>
    <p class="ArticlePublish">
      <?php if($is_author==1 && $is_agency==1){ ?>
      By <span><a href="<?php echo base_url().$author_url;?>" target="_blank"><?php echo $author_name;?></a></span>&nbsp;&nbsp;|&nbsp;&nbsp;<span><?php echo $agency_name;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
      <?php }else if($author_name!=''){ ?>
      By <span><a href="<?php echo base_url().$author_url;?>" target="_blank"><?php echo $author_name;?></a></span>&nbsp;&nbsp;|&nbsp;&nbsp;
      <?php }else if($agency_name!=''){ ?>
       By <span><?php echo $agency_name;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
      <?php } ?>
      Published: <span><?php echo $published_date;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
     <?php  if($content_type_id!= 1){ ?>
      Last Updated: <span><?php echo $last_updated_date;?></span>&nbsp;&nbsp; <p></p>
      <?php  } ?> 
      </p>
   
      <?php  if($content_type_id=='1'){ ?>
       <p class="ArticlePublish margin-bottom-10"> Last Updated: <span><?php echo $last_updated_date;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
      <span class="FontSize" id="incfont" data-toggle="tooltip" title="Zoom In">A+</span><span class="FontSize" id="resetMe" data-toggle="tooltip" title="Reset">A&nbsp;</span><span class="FontSize" id="decfont" data-toggle="tooltip" title="Zoom Out">A-</span> <span id="print_article">&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-print"></i></span></p>
      <?php } ?>
   <!--<div class="vuukle-powerbar"></div>-->
    <?php if($allow_social_btn==1) { ?>
    <div class="Social_Fonts FixedOptions" style="display:none;">
      <div class="PrintSocial" style="visibility:hidden;">  <span class="Share_Icons"><a href="javascript:;" class="csbuttons" data-type="twitter" data-txt="<?php echo strip_tags($content_title);?>" data-via="NewIndianXpress" data-count="true"><i class="fa fa-twitter fa_social"></i></a></span> <span  class="Share_Icons"><a href="javascript:;" class="csbuttons" data-type="facebook" data-count="true"><i class="fa fa-facebook fa_social"></i></a></span> <span class="Share_Icons"><a href="javascript:;" class="csbuttons" data-type="google" data-lang="en" data-count="true"><i class="fa fa-google-plus fa_social"></i></a></span> <span class="Share_Icons PositionRelative"><i class="fa fa-envelope-o fa_social" id="popoverId"></i><span class="csbuttons-count"><?php echo $email_shared;?></span></span>
        <div id="popover-content" class="popover_mail_form fade right in ">
          <div class="arrow"></div>
          <h3 class="popover-title">Share Via Email</h3>
          <div class="popover-content">
            <form class="form-inline Mail_Tooltip" action="<?php echo base_url(); ?>user/commonwidget/share_article_via_email" name="mail_share" method="post" id="mail_share" role="form">
              <div class="form-group">
                <input type="text" placeholder="Name" name="sender_name" id="name" class="form-control">
                <input type="text" placeholder="Your Mail" name="share_email" id="share_email" class="form-control">
                <input type="text" placeholder="Friends's Mail" name="refer_email" id="refer_email" class="form-control">
                <textarea placeholder="Type your Message" class="form-control" name="message" id="message"></textarea>
                <input type="hidden"  class="content_id" name="content_id" value="<?php echo $content_id;?>" />
                <input type="hidden"  class="section_id" name="section_id" value="<?php echo $section_id;?>" />
                <input type="hidden"  class="article_created_on" name="article_created_on" value="<?php echo $publish_start_date;?>" />
                <input type="reset" value="Reset" class="submit_to_email submit_post">
                <!--<input type="submit" value="share" class="submit_to_email submit_post" name="submit">-->
                <input type="button" value="Share" id="share_submit" class="submit_to_email submit_post" onclick="mail_form_validate();" name="submit">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php  } ?>
  </div>
</div>
<?php
	  
	/* ------------------------------------- Article content Type --------------------------------------------*/	
				  
	if($content_type_id=='1'){
	$article_body_text =  stripslashes($content_det['ArticlePageContentHTML']);	
   
	//$Image600X390 = $content_det['ImagePhysicalPath'];
	$Image600X390 = str_replace(' ', "%20", $content_det['ImagePhysicalPath']);
	
	if (getimagesize(image_url . imagelibrary_image_path . $Image600X390) && $Image600X390 != '')
	{
	$imagedetails = getimagesize(image_url . imagelibrary_image_path.$Image600X390);
	$imagewidth = $imagedetails[0];
	$imageheight = $imagedetails[1];
	
	if ($imageheight > $imagewidth)
	{
		$Image600X390 	= $content_det['ImagePhysicalPath'];
	}
	else
	{				
		//$Image600X390 	= str_replace("original","w600X390", $content_det['ImagePhysicalPath']);
		$Image600X390 	= $content_det['ImagePhysicalPath'];
	}
	$image_path='';
	
		$image_path = image_url. imagelibrary_image_path . $Image600X390;
		
	}
	else{
	$image_path='';
	$image_caption='';	
	}
	$show_image = ($image_path != '') ? $image_path : "no_image";
	$image_caption= $content_det['ImageCaption'];
	$image_alt =  $content_det['ImageAlt'];
	$content_url       = base_url().$content_det['url'];
	$page_index_number = ($content_det['allow_pagination']==1)? $content['image_number'] : "no_pagination";
	$special_class     = (strtolower($section_details['Sectionname'])=="specials")? 'special_class': '';
	?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ArticleDetail ArticleDetailContent <?php echo $special_class;?>">
  <div id="content" class="content" itemprop="description">
    <?php if($show_image!='no_image'){ ?>
    <figure class="AticleImg">
      <div class="image-Zoomin"><i class="fa fa-search-plus"></i><i class="fa fa-search-minus"></i></div>
      <img src="<?php echo $show_image;?>" title="<?php echo $image_caption;?>" alt="<?php echo $image_alt;?>" itemprop="image">
      <?php if($image_caption!=''){ ?>
      <p class="AticleImgBottom"><?php echo strip_tags($image_caption);?></p>
      <?php } ?>
    </figure>
    <?php } ?>
    <div id="storyContent">
    <?php echo $article_body_text; ?> 
    </div>
    </div>
  <?php 
	 $Related_article_content = $this->widget_model->get_related_article_by_contentid($content_id, $content['content_from']);
	 if(count($Related_article_content)>0){
	 ?>
  <ul class="RelatedArticle" style="display:none;">
    <div class="RelatedArt">Related Article</div>
    <?php foreach ($Related_article_content as $get_article){
		if($get_article['Related_content_id']!=''){
		/*$related_content_details = $this->widget_model->widget_article_content_preview($get_article['Related_content_id'], $get_article['contentType']);
		print_r($Related_article_content);exit;
		$relatedarticle_title = strip_tags($related_content_details[0]['title']);
		$related_url = $related_content_details[0]['url'];
		if($get_article['contentType']==3){
		$param = "?pm=".$content['page_param']."-1";	
		}else{
		$param = "?pm=".$content['page_param'];
		}
		$domain_name =  base_url();
		$related_article_url = $domain_name.$related_url.$param;*/
		$relatedarticle_title = strip_tags($get_article['ExternalArticletitle']);
		$related_article_url = base_url().$get_article['ExternalArticleURL'];
		}else{
		$relatedarticle_title = strip_tags($get_article['ExternalArticletitle']);
		$related_article_url = $get_article['ExternalArticleURL'];
		}
		?>
    <li><a href="<?php echo $related_article_url;?>"  class="article_click" target="_blank"><i class="fa fa-angle-right"></i><?php echo $relatedarticle_title;?></a></li>
    <?php  } }?>
  </ul>
  <!--<div class="pagination pagina">
    <ul>
      <li><a href="javascript:;" id="prev" class="prevnext element-disabled">« Previous</a></li>
      <li><a href="javascript:;" id="next" class="prevnext">Next »</a></li>
    </ul>
    <br />
  </div>-->
  <div class="text-center">
  <ul class="article_pagination" id="article_pagination">
    </ul></div>
  <div id="keywordline"></div>
</div>
<?php }
	/* ------------------------------------- Gallery content Type --------------------------------------------*/	
else if($content_type_id=='3'){ 
						 if($content['content_from']=="preview"){
						  $get_gallery_images	 = $content_details;
						  }
						$image_number = $content['image_number'];
						$content_url  = base_url().$content_details[0]['url'];
						$page_index_number = $content['image_number'];
						?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 features">
<?php if(count($get_gallery_images)> 1){ ?>
<div class="text-center play-pause-icon">
  <span id="auto-play" class="cursor-pointer"><i class="fa fa-play" title="Play"></i>
</span>  </div>
<?php } ?>
  <div class="slide GalleryDetail GalleryDetailSlide" style="width:100% !important">
    <?php foreach($get_gallery_images as $gallery_image){ 
				  
                  $gallery_caption = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $gallery_image['ImageCaption']);
				  $gallery_alt =  $gallery_image['ImageAlt'];
				  $Image600X390= str_replace(' ', "%20", $gallery_image['ImagePhysicalPath']);
				  if (getimagesize(image_url . imagelibrary_image_path . $Image600X390) && $Image600X390 != '')
					{
				  $imagedetails = getimagesize(image_url . imagelibrary_image_path.$Image600X390);
					$imagewidth = $imagedetails[0];
                    $imageheight = $imagedetails[1];
					if ($imageheight > $imagewidth)
					{
						$Image600X390 	= $gallery_image['ImagePhysicalPath'];
					    $is_verticle    = 'style="width:100%"';
					}
					else if($imagewidth > 600 && $imagewidth < 700) // minimum width image
					{				
						$Image600X390 	= $gallery_image['ImagePhysicalPath'];
						$is_verticle    = 'style="width:100%"'; 
					}else if($imagewidth < 600) // minimum width image
					{				
						$Image600X390 	= $gallery_image['ImagePhysicalPath'];
						$is_verticle    = 'style="width:100%"'; //'class="gallery_minimum_pixel"';
					}
					else   // normal image
					{				
						$Image600X390 	= $gallery_image['ImagePhysicalPath'];
						$is_verticle    = '';
					}
						$show_gallery_image = image_url. imagelibrary_image_path . $Image600X390;
					}
					else {

						$show_gallery_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
						$is_verticle    = '';
					}
                  ?>
    <div class="item">
      <figure class="PositionRelative"> <img src="<?php echo $show_gallery_image;?>" title="<?php echo $gallery_caption;?>" alt="<?php echo $gallery_alt;?>" <?php echo $is_verticle;?>>
       <?php if($gallery_caption!=''){ ?>
        <div class="TransLarge Font14"><?php echo $gallery_caption;?></div>
        <?php } ?>
      </figure>
    </div>
    <?php 
					 } ?>
  </div>
  	<?php if(count($get_gallery_images)> 1){ ?>
    <div class="text-center">
    <ul class="gallery_pagination" id="gallery_pagination">
    </ul>
  </div>
<?php } ?>
<script>
var currentimageIndex = "<?php echo (($image_number)> count($get_gallery_images))? 1: $image_number;  ?>";
var TotalIndex = "<?php echo (count($get_gallery_images));  ?>";
$( document ).ready(function() {
$('html').addClass('gallery_video_remodal');
<?php if(($image_number) > 1 ){ ?>
 $('.GalleryDetailSlide').slick('slickGoTo', <?php echo $image_number-1;?>);
<?php } ?>
});
</script>
  <div id="keywordline"></div>
</div>
<?php 
							}
						/* ------------------------------------- Video content Type --------------------------------------------*/	
							else if($content_type_id=='4'){    
							if($content['content_from']=="preview"){
							  $video_script = htmlspecialchars_decode($content_det['VideoScript']);
							  $video_description = $content_det['summaryHTML'];
							  $content_url       = base_url().$content_det['url'];
							  }
							//print_r($get_video_det);exit;	
						?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="videodetail" style="text-align: center;"> <?php echo $video_script;?>
    </div>
     <p> <?php echo $video_description;?></p>
    <div id="keywordline"></div>
  </div>
  <script>
						 $( document ).ready(function() {
						 $('html').addClass('gallery_video_remodal');
						});
						</script>
  <?php 
							}
					/* ------------------------------------- Audio content Type --------------------------------------------*/	
							else 
							{
						 $audio_path       = image_url. audio_source_path.$content_det['Audio_path'];
					     $audio_description = $content_det['summaryHTML'];		
						 $content_url       = base_url().$content_det['url'];
							?>
                  <div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class=""> <audio class="margin-left-10 margin-top-5" controls="" src="<?php echo $audio_path;?>">
		</audio>
      <p> <?php echo $audio_description;?></p>
    </div>
    <div id="keywordline"></div>
  </div>
  <script>
						 $( document ).ready(function() {
						 $('html').addClass('gallery_video_remodal');
						});
						</script>          
						<?php	}
					?>
  <?php 
			  $article_tags= $content_det['Tags'];
              $get_tags =array();
			  if(isset($article_tags) && trim($article_tags) != '') 
			$get_tags	= $this->widget_model->get_tags_by_id($article_tags);
			  if(count($get_tags)>0){
			   ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ArticleDetail">
    <div class="tags">
      <div> <span>TAGS</span> </div>
      <?php foreach($get_tags as $tag){
		             if($tag->tag_name!=''){
				     $tag_title = join( "_",( explode(" ", trim($tag->tag_name) ) ) );
		             $tag_url_title = preg_replace('/[^A-Za-z0-9\_]/', '', $tag_title); 

							$tag_link = base_url().'topic/'.$tag_url_title; 
                            echo '<a href="'.$tag_link.'">'.$tag->tag_name.'</a>';
					      }
                            } ?>
    </div>
  </div>
  <?php } ?>
</div>
</article>
<div class="NextArticle FixedOptions" style="display:none;">
  <?php
					$prev_article = $this->widget_model->get_section_previous_article($content['content_id'], $content_det['Section_id'],$content_type_id);
					$next_article = $this->widget_model->get_section_next_article($content['content_id'], $content_det['Section_id'],$content_type_id);
					?>
  <?php if(count($prev_article)> 0){
					$prev_content_id = $prev_article['content_id'];
					$prev_section_id = $prev_article['section_id'];
					$param = $content['close_param'];
					$prev_string_value = $domain_name.$prev_article['url'].$param;
	                 ?>
  <a class="prev_article_click LeftArrow" href="<?php echo $prev_string_value;?>" title="<?php echo strip_tags($prev_article['title']);?>"><i class="fa fa-chevron-left"></i></a>
  <?php } ?>
  <?php if(count($next_article)> 0){
					$next_content_id = $next_article['content_id'];
					$next_section_id = $next_article['section_id'];
					$param = $content['close_param'];
					$next_string_value = $domain_name.$next_article['url'].$param;
					?>
  <a class="next_article_click RightArrow" href="<?php echo $next_string_value;?>" title="<?php echo strip_tags($next_article['title']);?>"><i class="fa fa-chevron-right"></i></a>
  <?php } ?>
</div>
<!--style overwriting editor body content-->
<style>
.ArticleDetailContent li{float: none; list-style: initial;}
.ArticleDetailContent blockquote {
    padding-left: 20px !important;
    padding-right: 8px !important;
    border-left-width: 5px;
    border-color: #ccc;
    font-style: italic;
	margin:10px 0 !important;
	padding: 12px 16px !important;
	font-size:13px !important;
}
.ArticleDetailContent blockquote p{font-size:13px !important;text-align:center;}
@media screen and ( max-width: 768px){
 audio { width:100%;}
}
</style>
<script type="text/javascript">
	var base_url        = "<?php echo base_url(); ?>";
	var content_id      = "<?php echo $content_id; ?>";
	var content_type_id = "<?php echo $content_type_id; ?>";
	var page_Indexid    = "<?php echo $page_index_number; ?>";
	var section_id      = "<?php echo $section_id; ?>";
	//location.reload(true);
	var content_url     = "<?php echo $content_url; ?>";
	var page_param      = "<?php echo $content['page_param']; ?>";
	var content_from    = "<?php echo $content['content_from']; ?>";
	var bitly_url       = "";
</script>
<div class="recent_news">
<div id="topover" class="slide-open" style="visibility: hidden;">
  <p>O<br>
    P<br>
    E<br>
    N</p>
</div>
</div>
<script src="<?php echo base_url(); ?>js/FrontEnd/js/remodal-article_updated.js"></script>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<?php }else{?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ArticleDetail ArticleDetailContent" style="height:900px;">
<?php echo "No Articles Available For this section! "; ?>
<span><i class="fa fa-smile-o" aria-hidden="true"></i></span>
</div>
</div>
<?php }
//echo "open me";exit;?>
