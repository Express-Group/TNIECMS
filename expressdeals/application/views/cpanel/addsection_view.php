<?php
$urlparam = strtolower($this->uri->segment(3));
$formurl = ($urlparam=='add') ? base_url(ADMINFOLDER.'section/add') : base_url(ADMINFOLDER.'section/edit/'.$this->uri->segment(4));
$editStatus = ($urlparam=='add') ? 0 : 1;
?>
<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3><?php echo ($urlparam=='add') ? 'Add' : 'Edit'; ?> Section</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'home'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'section'); ?>">Section</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo ($urlparam=='add') ? 'Add' : 'Edit'; ?></li>
                </ol>
            </nav>
        </div>
	</div>
	<div class="row">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-6">
                    <div class="pricing-table card">
                        <div class="card-body">
							<form method="post" action="<?php echo $formurl; ?>" enctype="multipart/form-data">
							<div class="form-group">
								<label for="section-name">Section Name<sup>*</sup></label>
								<input type="text" value="<?php if($editStatus==1 && $sectionDetails['section_name']!=''){ echo $sectionDetails['section_name']; }else{ echo set_value('section_name');} ?>" class="form-control" name="section_name">
								<?php echo form_error('section_name' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="section-url">Section Url <sup>*</sup> <?php if($editStatus==1):?><span style="color:red;">(You can't change section url in edit mode)</span><?php endif; ?></label>
								<input type="text" <?php if($editStatus==1){ echo ' readonly ';}?> value="<?php if($editStatus==1 && $sectionDetails['section_path']!=''){ echo $sectionDetails['section_path']; }else{ echo set_value('section_url');} ?>" class="form-control" name="section_url">
								<?php echo form_error('section_url' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="parent-section">Parent Section <?php if($editStatus==1):?><span style="color:red;">(You can't change parent section in edit mode)</span><?php endif; ?></label>
								<select <?php if($editStatus==1){ echo ' style="background-color: #e9ecef;pointer-events:none;" ';}?> class="form-control" name="parent_section">
									<option value="">Please select any one</option>
									<?php echo section_dropdown(buildTree($sections)); ?>
								</select>
								<?php echo form_error('parent_section' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="section-type">Section Type <sup>*</sup><?php if($editStatus==1):?><span style="color:red;">(You can't change section type in edit mode)</span><?php endif; ?></label>
								<select <?php if($editStatus==1){ echo ' style="background-color: #e9ecef;pointer-events:none;" ';}?> class="form-control" name="section_type">
									<option value="">Please select any one</option> 
									<option value="1" <?php if($editStatus==1 && $sectionDetails['section_type']=='1'){ echo ' selected ';}?>>Article</option>
									<option value="2" <?php if($editStatus==1 && $sectionDetails['section_type']=='2'){ echo ' selected ';}?>>Gallery</option>
									<option value="3" <?php if($editStatus==1 && $sectionDetails['section_type']=='3'){ echo ' selected ';}?>>Video</option>
								</select>
								<?php echo form_error('section_type' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" id="article_host" name="article_host" <?php if($editStatus==0){ echo ' checked ';}?><?php if($editStatus==1 && $sectionDetails['article_hosting']==1){ echo ' checked ';}?>>
									<label class="custom-control-label" for="article_host">Allow this section to be displayed for content hosting</label>
								</div>
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" id="rss" name="rss" <?php if($editStatus==0){ echo ' checked ';}?><?php if($editStatus==1 && $sectionDetails['rss_status']==1){ echo ' checked ';}?>>
									<label class="custom-control-label" for="rss">Allow this section to be displayed for rss</label>
								</div>
							</div>
							<?php
							if($editStatus==1 && $sectionDetails['image']!=''){
								$imageUrl = ASSETURL.'images/section/'.$sectionDetails['image'];
								echo '<img src="'.$imageUrl.'" style="width:70px;">';
							}
							?>
							<div class="form-group">
								<label for="section_image">Section Image</label>
								<input type="file" class="form-control" name="section_image" accept="image/*">
								<?php echo form_error('section_image' ,'<p class="error">','</p>'); ?>
							</div>
                            <div class="form-group">
								<label for="status">Status<sup>*</sup></label>
								<select class="form-control" name="status">
									<option value="">Please select any one</option> 
									<option value="1" <?php if($editStatus==1 && $sectionDetails['status']=='1'){ echo ' selected ';}?>>Active</option>
									<option value="0" <?php if($editStatus==1 && $sectionDetails['status']=='0'){ echo ' selected ';}?>>Inactive</option>
								</select>
								<?php echo form_error('status' ,'<p class="error">','</p>'); ?>
							</div>							
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pricing-table card">
                        <div class="card-body">
							<div class="list-group list-group-flush">
								<a style="color:#fff;font-weight:700;padding:0.20rem .5rem;" class="list-group-item active d-flex justify-content-center">
									SEO TAGS
								</a>              
							</div>
							<div class="form-group">
								<label style="margin-top:2%;" for="meta_title">Meta Title<sup>*</sup></label>
								<input type="text" value="<?php if($editStatus==1 && $sectionDetails['meta_title']!=''){ echo $sectionDetails['meta_title']; }else{ echo set_value('meta_title');} ?>" class="form-control" name="meta_title">
								<?php echo form_error('meta_title' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="meta_description">Meta Description <sup>*</sup></label>
								<textarea class="form-control" name="meta_description"><?php if($editStatus==1 && $sectionDetails['meta_description']!=''){ echo $sectionDetails['meta_description']; } ?></textarea>
								<?php echo form_error('meta_description' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="meta_keywords">Meta Keywords <sup>*</sup></label>
								<textarea class="form-control" name="meta_keywords"><?php if($editStatus==1 && $sectionDetails['meta_keywords']!=''){ echo $sectionDetails['meta_keywords']; } ?></textarea>
								<?php echo form_error('meta_keywords' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="canonical_url">Canonical Url</label>
								<input type="text" value="<?php if($editStatus==1 && $sectionDetails['canonical_url']!=''){ echo $sectionDetails['canonical_url']; }else{ echo set_value('canonical_url');} ?>" class="form-control" name="canonical_url">
								<?php echo form_error('canonical_url' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch" style="float: left;   margin-right: 13%;">
									<input <?php if($editStatus==1 && $sectionDetails['no_index']==1){ echo ' checked ';}?> type="checkbox" class="custom-control-input" id="no_index" name="no_index">
									<label class="custom-control-label" for="no_index">No Index</label>
								</div>
								<div class="custom-control custom-switch" style="float: left;">
									<input <?php if($editStatus==1 && $sectionDetails['no_follow']==1){ echo ' checked ';}?> type="checkbox" class="custom-control-input" id="no_follow" name="no_follow">
									<label class="custom-control-label" for="no_follow">No Follow</label>
								</div>
							</div>
							<div class="form-group" style="float: left;width: 100%;    margin: 9px 0 0;">
								<button type="submit" class="btn btn-primary">submit</button>
								<?php if($editStatus==0): ?>
								<button type="reset" class="btn btn-primary">reset</button>
								<?php endif; ?>
							</div>
							</form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ./ Content -->   