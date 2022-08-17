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
foreach($articles as $article){
	$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$article['title']);
//	$title = (strlen($title) >90) ? substr($title ,0 ,87).'...' : $title;
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
	if($count <= 3){
		if($count==1){
			$template.= '<div class="row article-content margin-bottom-15">'; 
		}
		$template.= '<div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 col-12">';
		$template.= '<a href="'.$url.'"><img class="img-fluid lazy-loaded" src="'.$defaultPath.'" data-src="'.$imagePath.'" alt="'.$imageAlt.'" title="'.$imageCaption.'"></a>';
		$template.= '<a class="bold-title" href="'.$url.'"><h5>'.preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title).'</h5></a>';
		$template.= '<time>UPDATED '.$time.'</time>';
		if($article['author_name']!=''){
			$template.= '<span class="author-name">by '.$article['author_name'].'</span>';
		}
		$template.= '<p class="content-summary">'.$summary.'</p>';
		$template.= '</div>';
		if($count==3 || $i == count($articles)){ 
			$template.= '</div>';
			$count=0;
		}
		$count ++;
	}	
	$i++;
	
}
echo $template;
?>
<div class="pagination">
<?php echo $CI->pagination->create_links(); ?>
</div>
</section>      