<!-- Content -->
<?php
$smallImage = ASSETURL.'images/content/'.str_replace('original/' , 'small/' , $details['file_path']);
$mediumImage = ASSETURL.'images/content/'.str_replace('original/' , 'medium/' , $details['file_path']);
$largeImage = ASSETURL.'images/content/'.str_replace('original/' , 'large/' , $details['file_path']);
$exlargeImage = ASSETURL.'images/content/'.str_replace('original/' , 'exlarge/' , $details['file_path']);
$originalImage = ASSETURL.'images/content/'.$details['file_path'];
?>
<style>
#crop_image{max-width:100%;}
</style>
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Crop</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'image_library'); ?>">Image Library</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo base_url(ADMINFOLDER.'image_library'); ?>">Crop</a></li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown">
                <a href="#" class="btn btn-success dropdown-toggle" title="Filter" data-toggle="dropdown">Filters</a>
				<div class="dropdown-menu dropdown-menu-big p-4 dropdown-menu-right">
                    <form method="get">
                        <div class="form-group">
                            <label>Image Caption/Alt</label>
                            <input value="<?php echo $this->input->get('group_id') ?>" type="text" class="form-control" name="group_id">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">Please select any one</option> 
                                <option <?php if($this->input->get('status')=='1'){ echo ' selected'; } ?> value="1">Active</option>
                                <option <?php if($this->input->get('status')=='0'){ echo ' selected'; } ?> value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Get Results</button>
                        <button type="button" onclick="window.location.href='<?php echo base_url(ADMINFOLDER.'groups'); ?>'" class="btn btn-link ml-2">Clear Filter</button>
                    </form>
                </div>
            </div>
            <div class="dropdown ml-2">
                <button id="img_upload_1" class="btn btn-primary"><i class="ti-upload"></i> &nbsp;Upload</button> 
            </div>
        </div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<label for="meta-title" style="width:100%;">CROP IMAGE</label>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" checked>
							<label class="custom-control-label" for="customRadioInline1">Small</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
							<label class="custom-control-label" for="customRadioInline2">Medium</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline3" name="customRadioInline3" class="custom-control-input">
							<label class="custom-control-label" for="customRadioInline3">Large</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline3" name="customRadioInline3" class="custom-control-input">
							<label class="custom-control-label" for="customRadioInline3">Extra Large</label>
						</div>
					</div>
					<div class="form-group">
						<img id="crop_image" src="<?php echo $originalImage; ?>"> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ./ Content -->  