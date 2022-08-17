<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Article</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'article'); ?>">Content</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Article</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown">
                <a href="#" class="btn btn-success dropdown-toggle" title="Filter" data-toggle="dropdown">Filters</a>
				<div class="dropdown-menu dropdown-menu-big p-4 dropdown-menu-right">
                    <form method="get" id="article_search">
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
                        <button type="button" onclick="window.location.href='<?php echo base_url(ADMINFOLDER.'content/article'); ?>'" class="btn btn-link ml-2">Clear Filter</button>
                    </form>
                </div>
            </div>
            <div class="dropdown ml-2">
                <a href="<?php echo base_url(ADMINFOLDER.'content/article/add'); ?>" class="btn btn-primary">Create</a> 
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
									<th><a class="order_by" type="<?php if($this->input->get('order_type')=='title'){ echo $this->input->get('order_by'); }else{ echo 'DESC';} ?>" col="title">Title <?php if($this->input->get('order_type')=='title' && $this->input->get('order_by')=='ASC'){ echo '<i class="fa fa-caret-down"></i>'; }else{ echo '<i class="fa fa-caret-up"></i>';} ?></a></th>
									<th>Section</th>
									<th>Image</th>
									<th>Created By</th>
									<th>Modified By</th>									
									<th><a class="order_by" type="<?php if($this->input->get('order_type')=='last_updated_on'){ echo $this->input->get('order_by'); }else{ echo 'DESC';} ?>" col="last_updated_on">Modified On <?php if($this->input->get('order_type')=='last_updated_on' && $this->input->get('order_by')=='ASC'){ echo '<i class="fa fa-caret-down"></i>'; }else{ echo '<i class="fa fa-caret-up"></i>';} ?></a></th>
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
										echo '<td class="text-center">'.$article->username.'</td>';
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
										echo '<td><li class="list-inline-item mb-0">
												<a href="#" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown">Action</a>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="'.base_url(ADMINFOLDER.'content/article/edit/'.$article->content_id).'"><i class="ti-pencil"></i> Edit</a>
													<a target="_BLANK" class="dropdown-item" href="'.base_url($article->url).'"><i class="ti-eye"></i> Preview</a>
													<a class="dropdown-item" href="#"><i class="ti-save"></i> publish</a>
													<a class="dropdown-item" href="#"><i class="ti-archive"></i> unpublish</a>
												</div>
											</li></td>';
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

<!-- ./ Content --> 