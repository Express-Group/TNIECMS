<section class="blocks">
<?php
$CI = &get_instance();
$CI->load->library('pagination');
$defaultPath = ASSETURL.'images/logo/medium.jpg';
$rawData['max_article'] = 15;
$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
$section = (isset($rawData['section']) && $rawData['section']!='') ? $rawData['section'] : '' ;
$section = ($data['isHome']==0 && $section=='' && $data['commonTemplate']==1) ? $data['sectionDetails']['sid'] : $section;
$takenIDs = (isset($_COOKIE['section_articles']) && $_COOKIE['section_articles']!='') ? $_COOKIE['section_articles'] : '';
$config = [];
$config['base_url'] = base_url($data['sectionDetails']['section_full_path']);
$config['total_rows'] = $this->homemodel->getAutoPaginationCount($section ,  $takenIDs , $rawData['max_article']);;
$config['per_page'] = $rawData['max_article'];
$config['num_links'] = 5;
$config['use_page_numbers'] = FALSE;
$config['page_query_string'] = TRUE;
$CI->pagination->initialize($config);
$articles = $this->homemodel->getAutoPaginationArticles($section , $rawData['max_article'] , $row , $takenIDs);
$i =1;
$count= 1;
$template ='';
$template.= '<div class="row article-content margin-bottom-15">';
foreach($articles as $article){
	$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$article['title']);
	$title = (strlen($title) >83) ? substr($title ,0 ,80).'...' : $title;
	$summary = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$article['summary']);
	$summary = (strlen($summary) >168) ? substr($summary ,0 ,165).'...' : $summary;
	$url = $data['url'].$article['url'];
	$imageDetails = hasImage($article['image_path']);
	$time = date('F d, Y' , strtotime($article['published_date']));
	$imagePath = $imageCaption = $imageAlt = "";
	if($imageDetails['status']==1){
		$imagePath = ASSETURL.IMAGE_PATH. str_replace('original/' ,'medium/' , $article['image_path']);
		$imageCaption = trim($article['image_caption']);
		$imageAlt = trim($article['image_alt']);
	}else{
		$imagePath = ASSETURL.'images/logo/medium.jpg';
	}
	$template.= '<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">';
	$template.= '<div class="single-inner">';
	$template.= '<a class="single-inner-image" href="'.$url.'"><img class="img-fluid lazy-loaded" src="'.$defaultPath.'" data-src="'.$imagePath.'" alt="'.$imageAlt.'" title="'.$imageCaption.'"></a>';
	$template.= '<div class="single-inner-content">';
	$template.= '<a href="'.$url.'"><h4>'.preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title).'</h4></a>';
	$template.= '<time>UPDATED '.$time.'</time>';
	if($article['author_name']!=''){
		$template.= '<span class="author-name">by '.$article['author_name'].'</span>';
	}
	$template.= '<p class="content-summary">'.$summary.'</p>';
	$template.= '</div>'; 
	$template.= '</div>'; 
	$template.= '</div>'; 
	$i++;
	
}
$template.= '</div>';
echo $template;
?>
<div class="pagination">
<?php echo $CI->pagination->create_links(); ?>
</div>
</section>     