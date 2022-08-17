<?php
$currentSection = 0;
if($this->uri->segment(3)=='edit' && is_numeric($this->uri->segment(4))){
	$type  = 'Edit';
	$formurl = base_url(ADMINFOLDER.'products/edit/'.$this->uri->segment(4));
	if($productDetails['section_id']!=''){
		$currentSection = $productDetails['section_id'];
	}
}else{
	$type = 'Add';
	$formurl = base_url(ADMINFOLDER.'products/add');
}
?>
<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3><?php echo $type; ?> Products</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'home'); ?>">Home</a></li>
                   <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'products'); ?>">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $type; ?></li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
			<div class="dropdown ml-2">
                <button id="product_save" type="button" class="btn btn-danger"><i class="ti-save"></i> &nbsp;Save</button> 
            </div>
        </div>
	</div>
	<div class="row">
        <div class="col-md-12">
			<form method="post" action="<?php echo $formurl; ?>" id="create_product" enctype="multipart/form-data">
            <div class="row" style="margin-bottom: 10%;">
                <div class="col-md-8">
                    <div class="pricing-table card">
                        <div class="card-body">
							<div class="form-group headline">
								<label for="product-title">Product Title <sup>*</sup></label>
								<textarea class="form-control"  name="product_title" rows="10"><?php if(isset($productDetails['product_name']) && $productDetails['product_name']!=''){ echo $productDetails['product_name']; } ?></textarea>
							</div>
							<div class="form-group short">
								<label for="product_short_title">Product Short Note <sup>*</sup></label>
								<textarea class="form-control" name="product_short_title" rows="10"><?php if(isset($productDetails['product_short_note']) && $productDetails['product_short_note']!=''){ echo $productDetails['product_short_note']; } ?></textarea>
							</div>
							<div class="form-group">
								<label for="category">Category</label>
								<select class="form-control" name="category">
									<option value="">Please select any one</option>
									<?php echo article_section_dropdown(1 , buildTree($sections) ,$currentSection); ?>
								</select>
								<?php echo form_error('category' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group summary">
								<label for="summary">Product Summary <sup>*</sup></label>
								<textarea class="form-control" name="product_summary" rows="10"><?php if(isset($productDetails['product_summary']) && $productDetails['product_summary']!=''){ echo $productDetails['product_summary']; } ?></textarea>
							</div>
							
							<div class="form-group image-block-btn" <?php if($type=='Edit' && isset($productDetails['image_id']) && $productDetails['image_id']!='' && $productDetails['image_id']!=0){ echo " style='display:none;'";} ?>>
								<button id="product_img" type="button" class="btn btn-primary"><i class="ti-plus"></i> &nbsp;Product Image</button>
							</div>
							<div class="form-group image-block-container" <?php if($type=='Edit' && isset($productDetails['image_id']) && $productDetails['image_id']!='' && $productDetails['image_id']!=0){ echo " style='display:block;'";}else{  echo " style='display:none;'";} ?>>
								<div style="height:300px;" class="image-block">
									<?php
									if($type=='Edit' && isset($imageDetails['temp_id']) && $imageDetails['temp_id']!=''){
										echo '<img src="'.$imageDetails['path'].'">';
									}
									?>
								</div>
								<input type="text" name="image_caption" class="form-control" placeholder="Image caption" value="<?php if($type=='Edit' && isset($productDetails['image_caption']) && $productDetails['image_caption']!=''){ echo $productDetails['image_caption'];} ?>">
								<input type="hidden" name="image_id" class="form-control" value="<?php if($type=='Edit' && isset($imageDetails['temp_id']) && $imageDetails['temp_id']!=''){ echo $imageDetails['temp_id'];} ?>">
								<input type="text" name="image_alt" class="form-control" placeholder="Image Alt" value="<?php if($type=='Edit' && isset($productDetails['image_alt']) && $productDetails['image_alt']!=''){ echo $productDetails['image_alt'];} ?>">
								<input style="margin-bottom:2%;" type="text" name="image_name" class="form-control" placeholder="Image Name" value="<?php if($type=='Edit' && isset($imageDetails['image_name']) && $imageDetails['image_name']!=''){ echo $imageDetails['image_name'];} ?>">
								<button type="button" id="remove_image" style="margin-left:2%;" class="btn btn-primary">Remove</button>
							</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-table card">
                        <div class="card-body">
							<div class="form-group">
								<label for="meta-title" style="width:100%;">product Status<sup>*</sup></label>
								<div class="custom-control custom-radio custom-control-inline">
									<input checked value="1" type="radio" id="status1" name="product_status" class="custom-control-input">
									<label class="custom-control-label" for="status1">Active</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input value="2" type="radio" id="status2" name="product_status" class="custom-control-input">
									<label  class="custom-control-label" for="status2">Inactive</label>
								</div>
							</div>
							<div class="merchant-details">
								<hr>
								<h5>MERCHANT DETAILS</h5>
								<div class="merchant-dynamic">
								<?php
								if($type=='Edit'){
									$i=1;
									foreach($merchantDetails as $merchant){
										echo '<div class="form-group merchant mer-'.$i.'"><input class="form-control" type="text" name="merchant_name_'.$i.'" placeholder="Enter Merchant name" value="'.$merchant['merchant_name'].'"><input class="form-control" value="'.$merchant['merchant_url'].'" type="text" name="merchant_url_'.$i.'" placeholder="Enter Merchant url"><input class="form-control" type="text" value="'.$merchant['merchant_price'].'" name="merchant_price_'.$i.'" placeholder="Enter Merchant Price"><div class="custom-control custom-radio custom-control-inline"><input '.(($merchant['merchant_status']==1)? ' checked ' : '').' value="1" type="radio" id="statusactive'.$i.'" name="merchant_status'.$i.'" class="custom-control-input"><label class="custom-control-label" for="statusactive'.$i.'">Active</label></div><div class="custom-control custom-radio custom-control-inline"><input value="0" '.(($merchant['merchant_status']==0)? ' checked ' : '').' type="radio" id="statusinactive'.$i.'" name="merchant_status'.$i.'" class="custom-control-input"><label  class="custom-control-label" for="statusinactive'.$i.'">Inactive</label></div></div>';
										$i++;
									}
								}
								?>
								</div>
								<div class="form-group merchant-btn">
								
									<input type="hidden" name="merchant_count" value="<?php echo ($type=='Edit') ? count($merchantDetails) : 0; ?>">
									<button type="button" class="btn btn-primary" name="add_merchant"><i class="ti-plus"></i> &nbsp;ADD MERCHANT</button>
									<button type="button" class="btn btn-secondary" name="remove_merchant"><i class="fa fa-trash"></i> &nbsp;REMOVE</button>
								</div>
							</div>
							
                        </div>
                    </div>
                </div>
            </div>
			</form>
        </div>
    </div>
	<!-- Modal -->
	<div class="modal fade" id="article_image_upload" role="dialog">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">IMAGE LIBRARY</h4>
				</div>
				<div class="modal-body">
					<form id="article_single_image" action="" method="post" enctype="multipart/form-data">
						<input type="file" name="article_single_img" accept="image/*">
					</form>
					<hr>
					<div class="form-group">
						<input name="image_search" style="width: 50%;float: left;margin-right: 8px;" class="form-control" type="text" placeholder="Enter Caption / Image Name">
						<button class="btn btn-primary" type="button" id="image_search1"> Search</button>
						<input type="hidden" id="image_modal_status" value="">
					</div>
					<hr>
					<div class="img-container">
						<div class="img-list">
						</div>
						<div class="img-preview">
							<h5>PREVIEW</h5>
							<hr>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button style="display:none;" type="button" id="select_image" class="btn btn-primary">Select</button>
					<button style="display:none;" type="button" id="embed_select_image" class="btn btn-primary">Select</button>
					<button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ./ Content -->    