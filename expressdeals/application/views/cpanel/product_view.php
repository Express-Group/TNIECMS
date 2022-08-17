<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Products</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                   <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown">
                <a href="#" class="btn btn-success dropdown-toggle" title="Filter" data-toggle="dropdown">Filters</a>
				<div class="dropdown-menu dropdown-menu-big p-4 dropdown-menu-right">
                    <form method="get">
                        <div class="form-group">
                            <label>Product Id / Name</label>
                            <input value="<?php echo $this->input->get('query') ?>" type="text" class="form-control" name="query">
                        </div>
						<div class="form-group">
							<label>Category</label>
							<select class="form-control" name="section_name">
                                <option value="">Please select any one</option> 
                               <?php echo article_section_dropdown(1 , buildTree($sections) , $this->input->get('section')); ?>
                            </select>
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
                        <button type="button" onclick="window.location.href='<?php echo base_url(ADMINFOLDER.'products'); ?>'" class="btn btn-link ml-2">Clear Filter</button>
                    </form>
                </div>
            </div>
            <div class="dropdown ml-2">
                <a href="<?php echo base_url(ADMINFOLDER.'products/add'); ?>" class="btn btn-primary">Create</a> 
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
						<strong>Success!</strong> Product created successfully.
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('message')==2 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> '<?php echo $this->session->flashdata('message_edit'); ?>' Product updated successfully.
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
									<th>Product ID</th>
									<th>Product Title</th>
									<th>Section</th>
									<th class="text-center">Image</th>
									<th>Modified By</th>									
									<th>Modified On</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(count($data) > 0){
									foreach($data as $product){
										echo '<tr>';
										echo '<td>'.$product->pid.'</td>';
										echo '<td><p style="margin:0;" data-toggle="tooltip" title="'.strip_tags($product->product_name).'">'.shortDescription(strip_tags($product->product_name)).'</p></td>';
										echo '<td style="color: #5066e1;">'.$product->section_name.'</td>';
										if($product->image_path!=''){
											$imagepath = str_replace('original/' , 'medium/' , $product->image_path);
											$imagepath = ASSETURL.IMAGE_PATH.$imagepath;
											echo '<td class="text-center"><img style="width: 65px;border-radius:5px;" src="'.$imagepath.'" alt="'.trim($product->image_alt).'"></td>';
										}else{
											echo '<td class="text-center">-</td>';
										}
										echo '<td>'.$product->username.'</td>';
										echo '<td>'.$product->modified_on.'</td>';
										echo '<td>';
										if($product->status==1){
											echo '<span class="badge bg-success">Active</span>';
										}
										if($product->status==2){
											echo '<span class="badge bg-danger">Inactive</span>';
										}
										if($product->status==3){
											echo '<span class="badge bg-info">Draft</span>';
										}
										echo '</td>';
										echo '<td><li class="list-inline-item mb-0">
												<a href="#" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown">Action</a>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="'.base_url(ADMINFOLDER.'products/edit/'.$product->pid).'"><i class="ti-pencil"></i> Edit</a>
													<a class="dropdown-item" onclick="delete_product('.$product->pid.')"><i class="ti-trash"></i> Delete</a>
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