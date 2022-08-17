<section class="blocks">
	<?php
	$imageDetails['status']=0;
	if($data['articleDetails']['image_path']!=''){
		$imageDetails = hasImage($data['articleDetails']['image_path']);
	}
	$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$data['articleDetails']['title']);
	$summary = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$data['articleDetails']['summary']);
	$time = date('F d, Y' , strtotime($data['articleDetails']['last_updated_on']));
	?>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">
			<h1 class="content-title"><?php echo strip_tags($title); ?></h1>
			<p><?php echo $summary; ?></p>
		</div>
	</div>
	<?php if($imageDetails['status']==1 && $data['articleDetails']['content_type']==1): ?>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">
			<figure>
				<img src="<?php echo ASSETURL.IMAGE_PATH.$data['articleDetails']['image_path']; ?>" alt="Trulli" title="" class="img-fluid article-img">
				<?php if($data['articleDetails']['image_caption']=='e'): ?>
				<figcaption><?php echo strip_tags($data['articleDetails']['image_caption']); ?></figcaption>
				<?php endif; ?>
			</figure>
		</div>
	</div>
	<?php endif; ?>
</section> 