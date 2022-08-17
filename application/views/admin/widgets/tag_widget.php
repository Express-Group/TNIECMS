<?php
$widget_bg_color 		= $content['widget_bg_color'];
$widget_instance_id	 	= $content['widget_values']['data-widgetinstanceid'];
$view_mode              = $content['mode'];
$widget_instance_details= $this->widget_model->getWidgetInstance('', '','', '', $widget_instance_id, $content['mode']);
$widget_position = $content['widget_position'];
$json =[];
if($widget_instance_details['AdvertisementScript']!=''){
	$json = json_decode($widget_instance_details['AdvertisementScript'] , true);
}
?>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10">
    <div class="section_content_<?php echo $widget_instance_id;?>" id="section_content_<?php echo $widget_instance_id;?>">
     <?php
		if(isset($json['type']) && $json['type']!=''):
			if($json['type']=='2'){ echo '<hr>'; }
			if($json['type']=='1'){ echo '<fieldset class="FieldTopic"><legend class="topic"><a href="'.@$json['link'].'">'.@$json['title'].'</a></legend></fieldset>'; }
			if($json['type']=='3'){ echo '<span style="'.@$json['style'].'">'.@$json['content'].'</span>'; }
			if($json['type']=='4'){ echo '<div style="'.@$json['style'].'">'.@$json['content'].'</div>'; }
			if($json['type']=='5'){
				$image = image_url.'images/static_img/'.@$json['image'];
				if(@$json['link'] !=''){
					echo '<a href="'.@$json['link'].'">';
				}
				echo '<img src="'.$image.'" alt="'.@$json['alt'].'" title="'.@$json['imgtitle'].'" class="img-responsive">';
				if(@$json['title'] !=''){
					echo '<h4 class="subtopic">'.@$json['title'].'</h4>';
				}
				if(@$json['link'] !=''){
					echo '</a>';
				}
			}
		endif;
	 ?>
    </div>
  </div>
</div> 