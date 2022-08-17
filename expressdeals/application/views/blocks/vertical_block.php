<section class="blocks">
<div class="row">
	<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">
		<?php
		if(isset($rawData['block_title']) && $rawData['block_title']!=''){
			$link = (isset($rawData['block_link']) && $rawData['block_link']!='') ? 'href="'.$rawData['block_link'].'"' : '';
			echo '<h4 class="title"><a '.$link.'>'.$rawData['block_title'].'</a></h4>';
		}
		if(isset($rawData['summary']) && $rawData['summary']!=''){
			echo '<p class="summary">'.$rawData['summary'].'</p>';
		}
		?>
	</div>
</div>
<?php
$defaultPath = ASSETURL.'images/logo/medium.jpg';
$rawData['max_article'] = (isset($rawData['max_article']) && $rawData['max_article']!='') ? $rawData['max_article'] :3;
if(isset($rawData['mode']) && $rawData['mode']=='2'){
	$articleList = ($rawData['articles']!='') ? explode(',' ,$rawData['articles']) : [];
	if(count($articleList) >0){
		$articleList = array_map(function($value){return substr($value, 0, strpos($value, "-")); } ,$articleList);
		$articleList = implode(',' ,$articleList);
		$articles = $this->homemodel->getManualArticles($articleList , $rawData['max_article']);
	}else{
		$articles = [];
	}
	
}else{
	$section = (isset($rawData['section']) && $rawData['section']!='') ? $rawData['section'] : '' ;
	$articles = $this->homemodel->getAutoArticles($section , $rawData['max_article']);
}
$i =1;
$count= 1;
$template ='';
$template.= '<div class="row article-content margin-bottom-15">';
foreach($articles as $article){
	$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$article['title']);
	$title = (strlen($title) >75) ? substr($title ,0 ,72).'...' : $title;
	$summary = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$article['summary']);
	$summary = (strlen($summary) >153) ? substr($summary ,0 ,150).'...' : $summary;
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
	$template.= '<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12 margin-bottom-10">';
	$template.= '<a href="'.$url.'"><img class="img-fluid lazy-loaded" src="'.$defaultPath.'" data-src="'.$imagePath.'" alt="'.$imageAlt.'" title="'.$imageCaption.'"></a>';
	$template.= '<a class="bold-title" href="'.$url.'"><h5>'.preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$article['title']).'</h5></a>';
	if(isset($rawData['summary_status']) && $rawData['summary_status']=='1'):
		$template.= '<time>UPDATED '.$time.'</time>';
		if($article['author_name']!=''){
			$template.= '<span class="author-name">by '.$article['author_name'].'</span>';
		}
		$template.= '<p class="content-summary">'.$summary.'</p>';
	endif;
	$template.= '</div>'; 
	$i++;
	
}
$template.= '</div>';
echo $template;
?>
</section>    