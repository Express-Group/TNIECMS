 <!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Tags</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'components/tags'); ?>">Components</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tags</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown">
                <a href="#" class="btn btn-success dropdown-toggle" title="Filter" data-toggle="dropdown">Filters</a>
				<div class="dropdown-menu dropdown-menu-big p-4 dropdown-menu-right">
                    <form method="get">
                        <div class="form-group">
                            <label>Tag ID/name</label>
                            <input value="<?php echo $this->input->get('tid') ?>" type="text" class="form-control" name="tid">
                        </div>
                        <button type="submit" class="btn btn-primary">Get Results</button>
                        <button type="button" onclick="window.location.href='<?php echo base_url(ADMINFOLDER.'components/tags'); ?>'" class="btn btn-link ml-2">Clear Filter</button>
                    </form>
                </div>
            </div>
            <div class="dropdown ml-2">
                <a href="<?php echo base_url(ADMINFOLDER.'components/tags/add'); ?>" class="btn btn-primary">Create</a> 
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
						<strong>Success!</strong> New Tag added successfully.
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('message')==2 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> Tag updated successfully.
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('message')==0 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Failure!</strong> Something went wrong.please try again.
					</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table class="table table-lg">
							<thead>
								<tr>
									<th><a>ID</a></th>
									<th>Tag Name</th>
									<th>Meta Title</th>
									<th>Meta Description</th>
									<th>Status</th>
									<th>Modified By</th>
									<th>Modified On</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(count($data) > 0){
									foreach($data as $tag){
										echo '<tr>';
										echo '<td>'.$tag->tag_id.'</td>';
										echo '<td>'.$tag->tag_name.'</td>';
										echo '<td>'.$tag->meta_name.'</td>';
										echo '<td>'.$tag->meta_description.'</td>';
										echo '<td>';
										if($tag->status==1){ 
											echo '<span class="icon-block mr-3 bg-success icon-block-xs icon-block-floating"><i data-feather="check" class="width-18 height-18"></i></span>';						
										}else{
											echo '<span class="icon-block mr-3 bg-danger icon-block-xs icon-block-floating"><i data-feather="x" class="width-18 height-18"></i></span>';
										}
										echo '</td>';
										echo '<td>'.$tag->username.'</td>';
										echo '<td>'.$tag->modified_on.'</td>';
										echo '<td><a href="'.base_url(ADMINFOLDER.'components/tags/edit/'.$tag->tag_id).'" type="button" class="btn btn-success btn-floating"><i class="ti-pencil"></i></a></td>';
										echo '</tr>';
									}
								}else{
									echo '<tr><th colspan="8" style="text-align:center;">NO RECORDS FOUND</th></tr>';
								}
								?>
							</tbody>
						</table>
					</div>
					<nav aria-label="user-pager" class="mb-4">
					<?php echo $pager; ?>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ./ Content -->  