<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Content Approval</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>approval">Content Approval</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Approval</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown">
                <a href="#" class="btn btn-success dropdown-toggle" title="Filter" data-toggle="dropdown">Filters</a>
				<div class="dropdown-menu dropdown-menu-big p-4 dropdown-menu-right">
                    <form method="get" id="article_search1">
						<div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="search_by">
                                <option value="">Please select any one</option> 
                                <option <?php if($this->input->get('search_by')=='1'){ echo ' selected'; } ?> value="1">Content ID</option>
                                <option <?php if($this->input->get('search_by')=='2'){ echo ' selected'; } ?> value="2">Title</option>
                                <option <?php if($this->input->get('search_by')=='3'){ echo ' selected'; } ?> value="3">Created By</option>
                                <option <?php if($this->input->get('search_by')=='4'){ echo ' selected'; } ?> value="4">Author Name</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Query</label>
                            <input value="<?php echo $this->input->get('query') ?>" type="text" class="form-control" name="query">
                        </div>
						<div class="form-group">
							<label>Section</label>
							<select class="form-control" name="section_name">
                                <option value="">Please select any one</option> 
                               <?php echo article_section_dropdown(1 , buildTree($sections) , $this->input->get('section')); ?>
                            </select>
						</div>
						<div class="form-group">
                            <label>Start Date</label>
                            <input value="<?php echo $this->input->get('start') ?>" type="date" class="form-control" name="start_date" id="start_date">
                        </div>
						<div class="form-group">
                            <label>End Date</label>
                            <input value="<?php echo $this->input->get('end') ?>" type="date" class="form-control" name="end_date" id="end_date">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">Please select any one</option> 
                                <option <?php if($this->input->get('status')=='1'){ echo ' selected'; } ?> value="1">Active</option>
                                <option <?php if($this->input->get('status')=='2'){ echo ' selected'; } ?> value="2">Inactive</option>
                                <option <?php if($this->input->get('status')=='3'){ echo ' selected'; } ?> value="3">Draft</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Get Results</button>
                        <button type="button" onclick="window.location.href='<?php echo base_url(ADMINFOLDER.'approval'); ?>'" class="btn btn-link ml-2">Clear Filter</button>
                    </form>
                </div>
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
						<strong>Success!</strong> Article created successfully.
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('message')==2 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> '<?php echo $this->session->flashdata('message_edit'); ?>' Article updated successfully.
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('message')==0 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Failure!</strong> Something went wrong.please try again.
					</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table class="table table-lg" style="font-size: 13px;">
							<thead>
								<tr>
									<th>Title</th>
									<th>Section</th>
									<th>Image</th>
									<th>Modified By</th>									
									<th>Modified On</th>
									<th>Status</th>
									<th>Approve Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(count($data) > 0){
									foreach($data as $article){
										if($article->approve_status==0 || $article->approve_status==2){
											$details = approval_article($article->content_id);
											$title  = strip_tags($details['title']);
											$article->section_name = $details['section_name'];
											$article->image_path = $details['image_path'];
											$article->image_alt = $details['image_alt'];
											$modifiedBy = $details['username'];
											$article->modified_on = $details['modified_on'];
											$article->status = $details['status'];
										}else{
											$title =  strip_tags($article->title);
											$modifiedBy = $article->username;
										}
										echo '<tr>';
										echo '<td><p style="margin:0;" data-toggle="tooltip" title="'.$title.'">'.shortDescription($title).'</p></td>';
										echo '<td style="color: #5066e1;">'.$article->section_name.'</td>';
										if($article->image_path!=''){
											$imagepath = str_replace('original/' , 'medium/' , $article->image_path);
											$imagepath = ASSETURL.IMAGE_PATH.$imagepath;
											echo '<td class="text-center"><img style="width: 65px;border-radius:5px;" src="'.$imagepath.'" alt="'.trim($article->image_alt).'"></td>';
										}else{
											echo '<td class="text-center">-</td>';
										}
										echo '<td class="text-center">'.$modifiedBy.'</td>';
										echo '<td class="text-center">'.$article->modified_on.'</td>';
										echo '<td class="text-center">';
										if($article->status==1){
											echo '<span class="badge bg-success">Active</span>';
										}
										if($article->status==2){
											echo '<span class="badge bg-danger">Inactive</span>';
										}
										if($article->status==3){
											echo '<span class="badge bg-info">Draft</span>';
										}
										echo '</td>';
										echo '<td class="text-center">';
										if($article->approve_status==1){
											echo '<span class="badge bg-success">Approved</span>';
										}else{
											echo '<span class="badge bg-danger">Not Approved</span>';
										}
										echo '</td>';
										//echo '<td><button style="margin-right: 10px;" type="button" onclick="view_article('.$article->content_id.')" class="btn btn-success">Preview</button><button type="button" onclick="approve_article('.$article->content_id.')" class="btn btn-danger">Approve</button></td>';
										echo '<td><button style="margin-right: 10px;" type="button" onclick="view_article('.$article->content_id.')" class="btn btn-success">Preview & Approve</button></td>';
										echo '</tr>';
									}
								}else{
									
								}
								?>
							</tbody>
						</table>
					</div>
					<nav aria-label="groups-pager" class="mb-4">
					<?php echo $pager; ?>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- modals -->
<div class="modal fade" id="preview_article">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title" style="color: #0066ff;">ARTICLE PREVIEW & APPROVAl</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
			</div>
			<!-- Modal footer -->
			<div class="modal-footer" style="border:none;">
			  <button type="button" class="btn btn-success aprrove-btn" onclick="approve()">Approve</button>
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!--<div class="modal fade" id="approve_article">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title">ARTICLE APPROVAL</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="notes">Notes <sup>*</sup></label>
					<textarea class="form-control" id="notes"></textarea>
					<input type="hidden" id="article_id">
				</div>
			</div>
			<div class="modal-footer" style="border:none;">
			  <button type="button" class="btn btn-success" onclick="approve()">Approve</button>
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>-->
<!-- ./ Content --> 