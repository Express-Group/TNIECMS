<?php 
$widget_instance_id  =  $content['widget_values']['data-widgetinstanceid'];
$max_article         = 10;
$domain_name         =  base_url();
$is_home             = $content['is_home_page'];
$is_summary_required = $content['widget_values']['cdata-showSummary'];
$widget_section_url  = $content['widget_section_url'];
$view_mode           = $content['mode'];


if($this->uri->segment(2) != '') {
	$author_name = str_replace('-',' ',$this->uri->segment(2));

$author_details = get_author_by_name($author_name);
$author_id = @$author_details['Author_id'];
}

$GetArchiveDetails=$this->widget_model->GetAuthorArchiveDetails($author_name,$content['page_param'],1);


// Newly add for paging  start 

$autho_articles_count	= $this->widget_model->get_Stories_For_Author_all($content['mode'],$author_name);

$TotalCount = count($autho_articles_count);


$last_content_id = @$autho_articles_count[$TotalCount-1]['content_id'];

$article_limit = ($this->input->get('per_page') != '') ? $this->input->get('per_page') : 0;

//$perpage				=	15;
if($this->uri->segment(3)=='archive'){
	$TotalCount=$this->widget_model->GetAuthorArchiveDetails($author_name,$content['page_param'],2);
	$config['total_rows'] = $TotalCount;
	$config['base_url']=$domain_name.'Author/'.$this->uri->segment(2).'/archive';
	$config['per_page'] = 20; 
	$config['custom_num_links'] = 5;
	$config['page_query_string'] = TRUE;
	$config['enable_query_strings']=TRUE;
	$config['cur_tag_open'] = "<a href='javascript:void(0);' class='active'>";
	$config['cur_tag_close'] = "</a>";
        $config['first_url']=$domain_name.'Author/'.$this->uri->segment(2);
	$this->pagination->initialize($config);
	$PaginationLink = $this->pagination->create_links();
	$article_limit = ($this->input->get('per_page') != '') ? $this->input->get('per_page') : 0;
	$columnnist_articles_list=$this->widget_model->GetContentBasedOnArchive($article_limit,$author_name,$config['per_page']);

	
}else{
$config['total_rows'] = $TotalCount;
$config['per_page'] = 15; 
$config['custom_num_links'] = 5;
$config['page_query_string'] = TRUE;
$config['enable_query_strings']=TRUE;
$config['cur_tag_open'] = "<a href='javascript:void(0);' class='active'>";
$config['cur_tag_close'] = "</a>";
$this->pagination->initialize($config);
//$PaginationLink = $this->pagination->create_links();
$PaginationLink = $this->pagination->custom_create_links();
$manual_instance = "&instance=archive";
$load_more_url = $domain_name.'topic/?sid='.$content['page_param'].'&cid=1'.$manual_instance;


// newly add for paging end 

	$columnnist_articles_list = $this->widget_model->get_Stories_For_Author($article_limit, $author_id, $content['mode'],$author_name);
	
	$author_det       = $this->widget_model->get_author($author_id);
	$author_name      = @$author_det[0]['AuthorName'];
	$ShortBiography   = @$author_det[0]['ShortBiography'];
	$author_image_id  = @$author_det[0]['image_id'];
	
	}
	//$topicname = $this->widget_model->gettopic_name();
	if($author_image_id!=''){
	/*$image_data = $this->widget_model->get_image_by_contentid($author_image_id);																
	$Image600X300  = str_replace("original","w150X150", $image_data['ImagePhysicalPath']);
				
	$imagealt ="";
	$imagetitle="";
	if (isset($Image150X150) && getimagesize(image_url . imagelibrary_image_path . $Image150X150) && $Image150X150 != '')
	{
		$show_image = image_url. imagelibrary_image_path . $Image150X150;
		$imagealt   = $image_data['ImageAlt'];
		$imagetitle = $image_data['ImageCaption'];
	}*/
	}
	?>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="main_column">
      <h4 class="Authorname"><?php echo $author_name;?></h4>
      <div class="current all_column">
        <?php
		  if(count($columnnist_articles_list)>0 && $author_id!=''){
		 foreach($columnnist_articles_list as $article_list){ 
		 
			if($this->uri->segment(3)=='archive'){
				$content_url = $article_list->url;
				$param = $content['close_param']; //page parameter
				$live_article_url = $domain_name. $content_url.$param;
				$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$article_list->title); 
				$summary  = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$article_list->summary_html); 
				
			}else{
			  $content_type =1 ;
              $content_details = $this->widget_model->get_contentdetails_from_database($article_list['content_id'], $content_type, $is_home, $view_mode);
				$custom_title        = "";
				$custom_summary      = "";
				$original_image_path = "";
				$imagealt            = "";
				$imagetitle          = "";																
				
				$content_url = $content_details[0]['url'];
				$param = $content['close_param']; //page parameter
				$live_article_url = $domain_name. $content_url.$param;
			
				if( $custom_title == '')
				{
					$custom_title = stripslashes($content_details[0]['title']);
				}	
				$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_title);   //to remove first<p> and last</p>  tag
								
				if( $custom_summary == '')
				{
					$custom_summary =  $content_details[0]['summary_html'];
				}
				$summary  = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_summary); 
				//to remove first<p> and last</p>  tag
				
				}
			?>
        <div class="sub_column"> <i class="fa fa-chevron-right"></i>
          <div class="ColumnList">
            <h5><a class="article_click" href="<?php echo $live_article_url; ?>" ><?php echo $display_title;?></a></h5>
            <p class="column_det summary"><?php echo $summary;?></p>
            <p class="post_time">
              <?php 
				 if($this->uri->segment(3)=='archive'):
					$time=$article_list->last_updated_on;
				 else:
					$time= $content_details[0]['last_updated_on'];
				 endif;
				 $post_time= $this->widget_model->time2string($time); echo $post_time;
				?>
              </p>
          </div>
        </div>
        <?php } 
		  }else{?>
          <h4>Sorry Author Not Found</h4>
          <?php } ?>
		  <?php
			$archive='';
			if(($GetArchiveDetails > 0)  && $this->uri->segment(3)==''){
				$load_more_url = $domain_name.'Author/'.$this->uri->segment(2).'/archive';
				$archive = '<a class="load_more_archive" href="'.$load_more_url.'">More from archive</a>';
			}
		  ?>
		   <div class="pagina"> <?php echo $PaginationLink.$archive;?> </div>
      </div>
    </div>
  </div>
</div>

