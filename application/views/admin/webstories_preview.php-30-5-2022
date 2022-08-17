<?php
$css = json_decode($slides['css'] , true);
$fonts = json_decode($slides['fonts'] , true);
?>
<!doctype html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
		<script async src="https://cdn.ampproject.org/v0.js"></script>
		<script async custom-element="amp-story" src="https://cdn.ampproject.org/v0/amp-story-1.0.js"></script>
		<?php echo (count($fonts['fonts']) > 0) ? implode('' , $fonts['fonts']) : '';?>
		<style>
			body{-webkit-animation: -amp-start 8s steps(1, end) 0s 1 normal both;-moz-animation: -amp-start 8s steps(1, end) 0s 1 normal both;-ms-animation: -amp-start 8s steps(1, end) 0s 1 normal both;        animation: -amp-start 8s steps(1, end) 0s 1 normal both;}
			@-webkit-keyframes -amp-start{
				from{visibility: hidden;}
				to{visibility: visible;}
			}
			@-moz-keyframes -amp-start{
				from{visibility: hidden;}
				to{visibility: visible;}
			}
			@-ms-keyframes -amp-start{
				from{visibility: hidden;}
				to{visibility: visible;}
			}
			@-o-keyframes -amp-start{
				from{visibility: hidden;}
				to{visibility: visible;}
			}
			@keyframes -amp-start{
				from{visibility: hidden;}
				to{visibility: visible;}
			}
		</style>
		<?php echo (count($css['css']) > 0) ? '<style amp-custom>'.implode('' , $css['css']).'</style>' : '';?>
	</head>
	<body>
		<amp-story standalone title="<?php echo $slides['name'];?>">
		<?php
		$content = $slides['content'];
		$imagePath = image_url.'images/webstories/default/';
		$fields = json_decode($slides['fields'] , true);
		$fields = $fields['fields'];
		$content = str_replace('%page' , '1' , $content);
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
		echo $content;
		?>
		</amp-story>
	</body>
</html>