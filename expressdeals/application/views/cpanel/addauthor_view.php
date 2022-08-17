<?php
$urlparam = strtolower($this->uri->segment(4));
$formurl = ($urlparam=='add') ? base_url(ADMINFOLDER.'components/author/add') : base_url(ADMINFOLDER.'components/author/edit/'.$this->uri->segment(5));
?>
<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3><?php echo ($urlparam=='add') ? 'Add' : 'Edit'; ?> Author</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'home'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'components/author'); ?>">Components</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'components/author'); ?>">Author</a></li>
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
								<label for="author-name">Author Name<sup>*</sup></label>
								<input type="text" value="<?php echo set_value('author_name'); ?><?php if(set_value('author_name')=='' && isset($details['author_name']) && $details['author_name']!=''){ echo $details['author_name']; } ?>" class="form-control" name="author_name">
								<?php echo form_error('author_name' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="author-description">Author Description <sup>*</sup></label>
								<textarea class="form-control" name="author_description"><?php echo set_value('author_description'); ?><?php if(set_value('author_description')=='' && isset($details['author_description']) && $details['author_description']!=''){ echo $details['author_description']; } ?></textarea>
								<?php echo form_error('author_description' ,'<p class="error">','</p>'); ?>
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
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pricing-table card">
                        <div class="card-body">
							<?php
							if(isset($details['author_image']) && $details['author_image']!=''){
								echo '<div class="form-group">';
								echo '<img style="width: 75px;" src="'.base_url(AUTHOR_IMAGE_PATH.$details['author_image']).'">';
								echo '</div>';
							}
							?>
							<div class="form-group">
								<label for="section_image">Author Image</label>
								<input type="file" class="form-control" name="author_image" accept="image/*">
								<?php echo form_error('author_image' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label style="margin-top:2%;" for="author_image_caption">Author Image Caption</label>
								<input type="text" value="<?php echo set_value('author_image_caption'); ?><?php if(set_value('author_image_caption')=='' && isset($details['caption']) && $details['caption']!=''){ echo $details['caption']; } ?>" class="form-control" name="author_image_caption">
								<?php echo form_error('author_image_caption' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label style="margin-top:2%;" for="author_image_alt">Author Image Alt</label>
								<input type="text" value="<?php echo set_value('author_image_alt'); ?><?php if(set_value('author_image_alt')=='' && isset($details['alt']) && $details['alt']!=''){ echo $details['alt']; } ?>" class="form-control" name="author_image_alt">
								<?php echo form_error('author_image_alt' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group" style="float: left;width: 100%;    margin: 9px 0 0;">
								<button type="submit" class="btn btn-primary">submit</button>
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