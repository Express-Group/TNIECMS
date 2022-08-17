<?php
$urlparam = strtolower($this->uri->segment(4));
$formurl = ($urlparam=='add') ? base_url(ADMINFOLDER.'components/tags/add') : base_url(ADMINFOLDER.'components/tags/edit/'.$this->uri->segment(5));
?>
<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3><?php echo ($urlparam=='add') ? 'Add' : 'Edit'; ?> Tags</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'home'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'components/author'); ?>">Components</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'components/tags'); ?>">Tags</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo ($urlparam=='add') ? 'Add' : 'Edit'; ?></li>
                </ol>
            </nav>
        </div>
	</div>
	<div class="row">
        <div class="col-md-12">
			<form method="post" action="<?php echo $formurl; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="pricing-table card">
                        <div class="card-body">
							<div class="form-group">
								<label for="tag-name">Tag Name<sup>*</sup></label>
								<input type="text" value="<?php echo set_value('tag_name'); ?><?php if(set_value('tag_name')=='' && isset($details['tag_name']) && $details['tag_name']!=''){ echo $details['tag_name']; } ?>" class="form-control" name="tag_name">
								<?php echo form_error('tag_name' ,'<p class="error">','</p>'); ?>
							</div>
                            <div class="form-group">
								<label for="status">Status<sup>*</sup></label>
								<select class="form-control" name="status">
									<option value="">Please select any one</option> 
									<option value="1" <?php if(isset($details['status']) && $details['status']=='1'){ echo ' selected '; } ?>>Active</option>
									<option value="0" <?php if(isset($details['status']) && $details['status']=='0'){ echo ' selected '; } ?>>Inactive</option>
								</select>
								<?php echo form_error('status' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="meta-name">Meta Title</label>
								<input type="text" value="<?php echo set_value('meta_title'); ?><?php if(set_value('meta_title')=='' && isset($details['meta_name']) && $details['meta_name']!=''){ echo $details['meta_name']; } ?>" class="form-control" name="meta_title">
								<?php echo form_error('meta_title' ,'<p class="error">','</p>'); ?>
							</div>							
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pricing-table card">
                        <div class="card-body">
							<div class="form-group" style="margin-top:5%;">
								<label for="meta-description">Meta Description</label>
								<textarea class="form-control" name="meta_description"><?php echo set_value('meta_description'); ?><?php if(set_value('meta_description')=='' && isset($details['meta_description']) && $details['meta_description']!=''){ echo $details['meta_description']; } ?></textarea>
								<?php echo form_error('meta_description' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group" style="float: left;width: 100%;    margin: 9px 0 0;">
								<button type="submit" class="btn btn-primary">submit</button>
							</div>
                        </div>
                    </div>
                </div>
            </div>
			</form>
        </div>
    </div>
</div>

<!-- ./ Content -->     