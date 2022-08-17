<?php
$css = [];
$fonts = [];
$scripts = [];
$template = '';
$j = 1;
foreach($slides as $slide){
	$imagePath = image_url.'images/webstories/default/';
	$cssList = json_decode($slide->css , true);
	$fontList = json_decode($slide->fonts , true);
	$scriptList = json_decode($slide->scripts , true);
	$fields = json_decode($slide->fields , true);
	$fields = $fields['fields'];
	$content = str_replace('%page' , $j , $slide->content);
	for($i=0;$i<count($cssList['css']);$i++){
		array_push($css , $cssList['css'][$i]);
	}
	for($i=0;$i<count($fontList['fonts']);$i++){
		array_push($fonts , $fontList['fonts'][$i]);
	}
	for($i=0;$i<count($scriptList['scripts']);$i++){
		array_push($scripts , $scriptList['scripts'][$i]);
	}
	for($i=0;$i<count($fields);$i++){
		if($fields[$i]['type']=='image' || $fields[$i]['type']=='video'){
			if(isset($fields[$i]['imageType']) && $fields[$i]['imageType']=='files'){
				$imagePath = image_url.'images/webstories/files/';
			}
			$content = str_replace($fields[$i]['element'] , $imagePath.$fields[$i]['value'] , $content);
		}else{
			$styles = "";
			if(isset($fields[$i]['color']) && $fields[$i]['color']!=''){
				$styles .="color:".$fields[$i]['color'].";";
			}
			if(isset($fields[$i]['fontSize']) && $fields[$i]['fontSize']!=''){
				$styles .="font-size:".$fields[$i]['fontSize']."px;";
			}
			$textContent = ($styles!='') ? '<span style="'.$styles.'">'.$fields[$i]['value'].'</span>' : $fields[$i]['value'];
			$content = str_replace($fields[$i]['element'] , $textContent , $content);
		}
	}
	$template .=$content;
	$j++;
}
$css = array_unique($css);
$fonts = array_unique($fonts);
$scripts = array_unique($scripts);
?>
<!doctype html>
<html lang="en" amp>
	<head>
		<title><?php echo $story['title']; ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
		<link rel="canonical" href="<?php echo current_url();?>">
		<script async src="https://cdn.ampproject.org/v0.js"></script>
		<script async custom-element="amp-story" src="https://cdn.ampproject.org/v0/amp-story-1.0.js"></script>
		<?php echo (count($scripts) > 0) ? implode('' , $scripts) : '';?>
		<?php echo (count($fonts) > 0) ? implode('' , $fonts) : '';?>
		<style amp-boilerplate>
		body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
		</style>
		<noscript>
		<style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style>
		</noscript>
		<?php echo (count($css) > 0) ? '<style amp-custom>'.implode('' , $css).'</style>' : '';?>
	</head>
	<body>
		<amp-story standalone title="<?php echo $story['title']; ?>" publisher="The New Indian Express" publisher-logo-src="<?php echo image_url;?>images/FrontEnd/images/new_logo.jpg" poster-portrait-src="<?php echo image_url;?>images/FrontEnd/images/new_logo.jpg">
		<?php echo $template; ?>
		</amp-story>
	</body>
</html>