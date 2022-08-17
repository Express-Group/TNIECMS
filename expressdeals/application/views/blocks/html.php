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
$template ='';
if(isset($rawData['content']) && $rawData['content']!=''){
	$template.= '<div class="row article-content margin-bottom-15">';
	$template.= '<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">';
	$template.= $rawData['content'];
	$template.= '</div>'; 
	$template.= '</div>'; 
}
echo $template;
?>
</section>