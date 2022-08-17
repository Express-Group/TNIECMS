<section class="blocks">
	<?php
	$time = date('F d, Y' , strtotime($data['articleDetails']['last_updated_on']));
	?>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">
			<p class="article-info"><time>Updated <?php echo $time; ?></time> <?php if($data['articleDetails']['author_name']!=''){ echo ' <span>&nbsp;| By <span style="color:red;">'.$data['articleDetails']['author_name'].'</span></span>';} ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">
			<div class="article-content1">
				<?php echo $data['articleDetails']['content']; ?>
				<?php
				if(count($data['productDetails']) > 0):
					foreach($data['productDetails'] as $product){
						echo '<div class="product-detail">';
						echo '<h5>'.$product['title'].'</h5>';
						echo '<div class="product-detail-inner">';
						if($product['image_path']!=''){
							echo '<div class="product-image">';
							echo '<img src="'.ASSETURL.IMAGE_PATH.$product['image_path'].'" class="img-fluid">';
							echo '</div>';
						}
						echo '<div class="product-description">';
						echo '<h4>'.preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$product['product_name']).'</h4>';
						echo '<h6>'.preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$product['product_short_note']).'</h6>';
						echo '<p>'.preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$product['product_summary']).'</p>';
						echo merchantDetails($product['pid']);
						echo '</div>';
						
						echo '</div>';
						echo '</div>';
					}
				endif;
				?>
			</div>
		</div>
	</div>
</section>  