<?php
$currentSection = 0;
if($this->uri->segment(4)=='edit' && is_numeric($this->uri->segment(5))){
	$type  = 'Edit';
	$formurl = base_url(ADMINFOLDER.'content/article/edit/'.$this->uri->segment(5));
	if($details['articleDetails']['section_id']!=''){
		$currentSection = $details['articleDetails']['section_id'];
	}
	$url = explode('/' , $details['articleDetails']['url']);
	$url = trim($url[count($url)-2]);
	$multimap = [];
	foreach($details['mappingDetails'] as $map):
		array_push($multimap , $map['section_id']);
	endforeach;
}else{
	$type = 'Add';
	$formurl = base_url(ADMINFOLDER.'content/article/add');
}
?>
<script>var articleType = "<?php echo $type; ?>";</script>
<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3><?php echo $type; ?> Article</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'home'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'content/article'); ?>">Content</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'content/article'); ?>">Article</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $type; ?></li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
		<div class="dropdown ml-2">
                <button type="button" class="btn btn-primary"><i class="ti-blackboard"></i> &nbsp;Preview</button> 
            </div>
			<div class="dropdown ml-2">
                <button id="article_save" type="button" class="btn btn-danger"><i class="ti-save"></i> &nbsp;Save</button> 
            </div>
        </div>
	</div>
	<div class="row">
        <div class="col-md-12">
			<form method="post" action="<?php echo $formurl; ?>" id="create_article">
            <div class="row" style="margin-bottom: 10%;">
                <div class="col-md-8">
                    <div class="pricing-table card">
                        <div class="card-body">
							<?php if($type=='Edit'){ echo '<p style="font-size: 12px;color: #adacac;">'.articleinfo($details['articleDetails']).'</p>'; } ?>
							<div class="form-group headline">
								<label for="headline">Article Title <sup>*</sup></label>
								<textarea class="form-control" name="article_title" rows="10"><?php if($type=='Edit' && isset($details['articleDetails']['title'])){ echo $details['articleDetails']['title'];} ?></textarea>
							</div>
							<div class="form-group">
								<label for="url">Article Url <sup>*</sup></label>
								<input <?php if($type=='Edit' && isset($details['articleDetails']['url'])){ echo ' readonly ';} ?> type="text" class="form-control" name="url" value="<?php if($type=='Edit' && isset($details['articleDetails']['url'])){ echo $url;} ?>">
								<?php
								if($type=='Edit' && $details['articleDetails']['url']){
									echo '<a target="_BLANK" style="margin-top: 10px;" class="btn btn-secondary" href="'.base_url($details['articleDetails']['url']).'"><i class="ti-link"></i> open Link</a>';
									echo '<button id="edit_url" type="button" title="Edit Url" style="margin-top: 10px;margin-left:6px;" class="btn btn-primary"><i class="ti-pencil"></i></button>';
								}
								?>
							</div>
							<div class="form-group">
								<label for="parent-section">Main Section</label>
								<select class="form-control" name="parent_section">
									<option value="">Please select any one</option>
									<?php echo article_section_dropdown(1 , buildTree($sections) ,$currentSection); ?>
								</select>
								<?php echo form_error('parent_section' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group summary">
								<label for="summary">Article Summary <sup>*</sup></label>
								<textarea class="form-control" name="article_summary" rows="10"><?php if($type=='Edit' && isset($details['articleDetails']['summary'])){ echo $details['articleDetails']['summary'];} ?></textarea>
							</div>
							<div class="form-group article-content">
								<label for="content">Article Content <sup>*</sup></label>
								<button id="embed_image" class="btn btn-danger" type="button"><i class="ti-image"></i> &nbsp;Embed Image</button>
								<textarea class="form-control" name="article_content" rows="10"><?php if($type=='Edit' && isset($details['articleDetails']['summary'])){ echo $details['articleDetails']['content'];} ?></textarea>
							</div>
							<div class="form-group image-block-btn" <?php if($type=='Edit' && isset($details['relatedDetails']['image_id']) && $details['relatedDetails']['image_id']!=''){ echo " style='display:none;'";} ?>>
								<button id="article_img" type="button" class="btn btn-primary"><i class="ti-plus"></i> &nbsp;Select Image</button>
							</div>
							<div class="form-group image-block-container" <?php if($type=='Edit' && isset($details['relatedDetails']['image_id']) && $details['relatedDetails']['image_id']!=''){ echo " style='display:block;'";}else{  echo " style='display:none;'";} ?>>
								<div style="height:300px;" class="image-block">
									<?php
									if($type=='Edit' && isset($imageDetails['temp_id']) && $imageDetails['temp_id']!=''){
										echo '<img src="'.$imageDetails['path'].'">';
									}
									?>
								</div>
								<input type="text" name="image_caption" class="form-control" placeholder="Image caption" value="<?php if($type=='Edit' && isset($details['articleDetails']['image_caption']) && $details['articleDetails']['image_caption']!=''){ echo $details['articleDetails']['image_caption'];} ?>">
								<input type="hidden" name="image_id" class="form-control" value="<?php if($type=='Edit' && isset($imageDetails['temp_id']) && $imageDetails['temp_id']!=''){ echo $imageDetails['temp_id'];} ?>">
								<input type="text" name="image_alt" class="form-control" placeholder="Image Alt" value="<?php if($type=='Edit' && isset($details['articleDetails']['image_alt']) && $details['articleDetails']['image_alt']!=''){ echo $details['articleDetails']['image_alt'];} ?>">
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
								<label for="meta-title" style="width:100%;">Article Status<sup>*</sup></label>
								<div class="custom-control custom-radio custom-control-inline">
									<input value="1" type="radio" id="status1" name="article_status" class="custom-control-input" <?php if($type=='Edit' && isset($details['articleDetails']['status']) && $details['articleDetails']['status']=='1'){ echo ' checked '; }else{ echo ' checked '; } ?>>
									<label class="custom-control-label" for="status1">Active</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input value="2" type="radio" id="status2" name="article_status" class="custom-control-input" <?php if($type=='Edit' && isset($details['articleDetails']['status']) && $details['articleDetails']['status']=='2'){ echo ' checked '; }?>>
									<label  class="custom-control-label" for="status2">Inactive</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input <?php if($type=='Edit'){ echo 'readonly'; }?> value="3" type="radio" id="status3" name="article_status" class="custom-control-input" <?php if($type=='Edit' && isset($details['articleDetails']['status']) && $details['articleDetails']['status']=='3'){ echo ' checked '; }?>>
									<label class="custom-control-label" for="status3">Draft</label>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label for="author">Map to other section</label>
								<div class="table-responsive" style="overflow-y:scroll;height:200px;background:#eee;">
									<table class="table">
										<tbody>
										<?php 
										if($type=='Edit'){
											echo section_dropdown_option(buildTree($sections) , $currentSection , $multimap);
										}else{
											echo section_dropdown_option(buildTree($sections) , 0 , []);
										}
										?>
										</tbody>
									</table>
								</table>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label for="author">Author</label>
								<input type="text" class="form-control" name="author">
							</div>
							<div class="form-group">
								<label for="country">Country</label>
								<select class="form-control" name="country">
									<option value="">Please select any one</option>
									<?php
									foreach($country as $countries):
									if($type=='Edit'){
										echo '<option '.(($countries->cid == $details['relatedDetails']['country_id'])? ' selected ':' ') .' value="'.$countries->cid.'">'.$countries->name.'</option>';
									}else{
										
									}echo '<option value="'.$countries->cid.'">'.$countries->name.'</option>';
										
									endforeach;
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="state">State</label>
								<select class="form-control" name="state">
									<option value="">Please select any one</option>
								</select>
							</div>
							<div class="form-group">
								<label for="city">City</label>
								<input type="text" class="form-control" name="city" value="<?php if($type=='Edit' && isset($details['articleDetails']['city_name']) && $details['articleDetails']['city_name']!=''){ echo $details['articleDetails']['city_name'];} ?>">
							</div>
							<div class="form-group">
								<div class="custom-control custom-checkbox custom-control-inline">
									<input <?php if($type=='Edit' && isset($details['articleDetails']['allow_comments']) && $details['articleDetails']['allow_comments']=='1'){ echo 'checked'; }else{ echo 'checked'; } ?> type="checkbox" id="comments" name="comments" class="custom-control-input">
									<label class="custom-control-label" for="comments">Comments</label>
								</div>
								<div class="custom-control custom-checkbox custom-control-inline">
									<input <?php if($type=='Edit' && isset($details['articleDetails']['allow_pagination']) && $details['articleDetails']['allow_pagination']=='1'){ echo 'checked'; } ?> type="checkbox" id="pager" name="pager" class="custom-control-input">
									<label class="custom-control-label" for="pager">Pagination</label>
								</div>
							</div>
							<div class="form-group">
								<label for="tags">Tags</label>
								<input type="text" class="form-control" name="tags" value="<?php if($type=='Edit' && isset($details['articleDetails']['tags']) && $details['articleDetails']['tags']!=''){ echo $details['articleDetails']['tags'];} ?>">
							</div>
							<h5>SEO TAGS</h5>
							<hr>
							<div class="form-group">
								<div class="custom-control custom-checkbox custom-control-inline">
									<input <?php if($type=='Edit' && isset($details['articleDetails']['no_index']) && $details['articleDetails']['no_index']=='1'){ echo 'checked'; } ?> type="checkbox" id="no_index" name="no_index" class="custom-control-input">
									<label class="custom-control-label" for="no_index">No index</label>
								</div>
							</div>
							<div class="form-group">
								<div class="custom-control custom-checkbox custom-control-inline">
									<input <?php if($type=='Edit' && isset($details['articleDetails']['no_follow']) && $details['articleDetails']['no_follow']=='1'){ echo 'checked'; } ?> type="checkbox" id="no_follow" name="no_follow" class="custom-control-input">
									<label class="custom-control-label" for="no_follow">No Follow</label>
								</div>
							</div>
							<div class="form-group">
								<label for="canonical_url">Canonical Url</label>
								<input type="text" class="form-control" name="canonical_url" value="<?php if($type=='Edit' && isset($details['articleDetails']['canonical_url']) && $details['articleDetails']['canonical_url']!=''){ echo $details['articleDetails']['canonical_url'];} ?>">
							</div>
							<div class="input-group">
								<label for="meta-title" style="width:100%;">Meta Title <sup>*</sup></label>
								<input type="text" class="form-control" aria-label="meta-title" aria-describedby="basic-addon2" name="meta_title" value="<?php if($type=='Edit' && isset($details['articleDetails']['meta_title']) && $details['articleDetails']['meta_title']!=''){ echo $details['articleDetails']['meta_title'];} ?>">
								<div class="input-group-append">
									<span class="input-group-text" id="basic-addon2">100</span>
								</div>
							</div>
							<br>
							<div class="input-group">
								<label for="meta-description" style="width:100%;">Meta Description <sup>*</sup></label>
								<input type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm" name="meta_description" value="<?php if($type=='Edit' && isset($details['articleDetails']['meta_description']) && $details['articleDetails']['meta_description']!=''){ echo $details['articleDetails']['meta_description'];} ?>">
								<div class="input-group-append">
									<span class="input-group-text" id="inputGroup-sizing-lg">200</span>
								</div>
							</div>
							<h5 style="margin-top: 6%;">PRODUCT DETAILS</h5>
							<hr>
							<div class="form-group">
								<div class="product-container">
									<?php
									if($type=='Edit' && isset($details['productDetails']) && count($details['productDetails']) > 0){
										foreach($details['productDetails'] as $product){
											echo '<div data-pid="'.$product['pid'].'" class="product">';
											echo '<h6 class="text-center bg-secondary">'.strip_tags($product['product_name']).'</h6>';
											if($product['image_path']!=''){
												echo '<img src="'.ASSETURL.IMAGE_PATH.$product['image_path'].'">';
											}
											echo '<input type="hidden" name="product_id[]" value="'.$product['pid'].'">';
											echo '<input type="text" name="product_title[]"  placeholder="Enter Title" class="form-control" value="'.$product['title'].'">';
											echo '<button type="button" class="btn btn-primary pull-right delete_product">Delete</button>';
											echo '</div>';
										}
									}
									?>
								</div>
								<button type="button" id="add_products" class="btn btn-primary">Add Products</button>
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
	<div class="modal fade" id="product_modal" role="dialog">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">SELECT PRODUCT</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" id="product_query" placeholder="product name / Id">
							</div>
						</div>
						<div class="col-md-4" style="padding-left: 0;">
							<div class="form-group">
								<button id="product_search" class="btn btn-primary" type="button">Search</button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 product-table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ./ Content -->    