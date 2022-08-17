<style>
	@media (min-width: 1200px)
	.col-lg-12 {width: unset;}
</style>
<?php
$count 		= str_replace(["style='background-color:" ,";'"] ,"" ,$content['widget_bg_color']);
$widget_instance_id	 	= $content['widget_values']['data-widgetinstanceid'];
$view_mode              = $content['mode'];
$widget_instance_details= $this->widget_model->getWidgetInstance('', '','', '', $widget_instance_id, $content['mode']);
$widget_position = $content['widget_position'];
$tagName = '';
$tagName = trim($widget_instance_details['AdvertisementScript']);
$CI = &get_instance();
$this->live_db = $CI->load->database('live_db' , TRUE);
$validString = 0;

	$count = 3;
	//$tagName = 'india%23,556,7899,||7';
	$tag = '';
	if($tagName != ''){
		$firstDelimiter = explode('||', $tagName);
		if(count($firstDelimiter) > 1){
			if(preg_match("/[A-Za-z]\|\|[0-9]/", $tagName)){
				$tag = $firstDelimiter[0];
				$count = $firstDelimiter[1];
				$validString = 1;
			}
			else{
				if(preg_match("/[A-Za-z]+%[0-9,]+\|\|[0-9]/", $tagName)){
					$tagNameArray = explode('%', $tagName);
					$tag = $tagNameArray[0];
					if(count($tagNameArray) > 1){
						$aftertagNameArray = explode('||', $tagNameArray[1]);
						$count = end($aftertagNameArray);
						$ignoredIds = explode(',', $aftertagNameArray[0]);
						$new = trim(implode(",",$ignoredIds), ',');
					}
					$validString = 1;
				}
				else{
					$validString = 0;
				}
			}
		}
		else{
			if(preg_match("/[^A-Za-z]/", $tagName)){
				$validString = 0;
			}else{
				$tag = $tagName;
				$validString = 1;
			}
		}
	}else{
		$validString = 0;
	}
	
	$search_condition = '';
	if($validString == 1){
		if($new != ''){
			$search_condition = "AND content_id NOT IN ($new)";
		}
		$result = $this->live_db->query("SELECT content_id, title, url, article_page_image_path, article_page_image_title, article_page_image_alt FROM article WHERE tags LIKE '".$tag."%' AND status = 'P' AND publish_start_date < NOW() $search_condition LIMIT $count ")->result();

		$imageUrl = image_url. imagelibrary_image_path;
		echo '<div class="VideoGallery"><div class="WidthFloat_L">';
		echo '<h4 class="topic"><a target="_BLANK" href="'.BASEURL.'topic/'.str_replace(' ' , '_' , $tag).'">'.$tag.'</a></h4>';
		$i = 1;
		foreach($result as $news){
			$image = (($news->article_page_image_path != '') ? str_replace('original', 'w600X300', $imageUrl.$news->article_page_image_path) : 'logo/nie_logo_600X300.jpg');
			$url = $news->url;
			$title = strip_tags($news->title);
			if($i == 1){
				echo '<div class="row">';
			}
			if($i < 4){
				echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">';
					echo '<a href="'.BASEURL.$url.'">';
						echo '<img data-src="'.$image.'" src="'.image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg" title="'.strip_tags($news->article_page_image_title).'" alt="'.strip_tags($news->article_page_image_alt).'">';
						echo '<p style="margin-top: 10px;font-family: \'Droid Serif\';">'.$title.'</p>';
					echo '</a>';
				echo '</div>';
			}
			if($i == 3){
				echo '</div>';
				$i = 0;
			}
			$i++;
		}
		echo '</div></div>';
	}

?>