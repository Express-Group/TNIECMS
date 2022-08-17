<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Image Library</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo base_url(ADMINFOLDER.'image_library'); ?>">Image Library</a></li>
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
					<?php if($this->session->flashdata('message')==1 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> New group added successfully.
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('message')==2 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> New group updated successfully.
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('message')==0 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Failure!</strong> Something went wrong.please try again.
					</div>
					<?php endif; ?>
					<div class="gallery-container row">
						<?php
						foreach($data as $image){
							$imagepath = ASSETURL.'images/content/'.str_replace('original/' ,'medium/' ,$image->file_path);
							echo '<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 drawings mb-4">';
							echo '<a class="image-popup-gallery-item">';
							echo '<div class="image-hover">';
							echo ' <img src="'.$imagepath.'" class="rounded" alt="image">';
							echo '<div class="image-hover-body rounded">
                                <div>
                                    <h4 class="mb-2">'.$image->caption.'</h4>
                                    <div><button class="btn btn-danger"><i class="ti-pencil"></i></button></div>
                                </div>
                            </div>';
							echo '</div>';
							echo '</a>';
							echo '</div>';
							
						}
						?>
					</div>
					<nav aria-label="groups-pager" class="mb-4">
					<?php echo $pager; ?>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="image_upload" role="dialog">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">UPLOAD IMAGES</h4>
				</div>
				<div class="modal-body">
					<form action="/" method="post" class="dropzone" id="image-upload-list"></form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="modal_close">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ./ Content --> 