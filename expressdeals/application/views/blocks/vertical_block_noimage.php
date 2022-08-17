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
	$url = $data['url'].$article['url'];
	$time = date('F d, Y' , strtotime($article['published_date']));
	$template.= '<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12 margin-bottom-10">';
	$template.= '<a class="bold-title icon-title" href="'.$url.'"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><h6>'.$title.'</h6></a>';
	$template.= '</div>'; 
	$i++;
	
}
$template.= '</div>';
echo $template;
?>
</section>     