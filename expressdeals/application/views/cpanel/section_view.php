<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Section</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Section</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown">
                <a href="#" class="btn btn-success dropdown-toggle" title="Filter" data-toggle="dropdown">Filters</a>
				<div class="dropdown-menu dropdown-menu-big p-4 dropdown-menu-right">
                    <form method="get">
                        <div class="form-group">
                            <label>Section Id/Name</label>
                            <input value="<?php echo $this->input->get('section_id') ?>" type="text" class="form-control" name="section_id">
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
                        <button type="button" onclick="window.location.href='<?php echo base_url(ADMINFOLDER.'section'); ?>'" class="btn btn-link ml-2">Clear Filter</button>
                    </form>
                </div>
            </div>
            <div class="dropdown ml-2">
                <a href="<?php echo base_url(ADMINFOLDER.'section/add'); ?>" class="btn btn-primary">Create</a> 
            </div>
			<div class="dropdown ml-2">
                <a href="<?php echo base_url(ADMINFOLDER.'section/arrange'); ?>" class="btn btn-danger">Arrange Section</a> 
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
						<strong>Success!</strong> New section added successfully.
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('message')==2 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> Section updated successfully.
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
									<th>Section Name</th>
									<th>Section Url</th>
									<th>Parent Section Name</th>
									<th>Status</th>
									<th>Modified By</th>
									<th>Modified On</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(count($data) > 0){
									foreach($data as $section){
										echo '<tr>';
										echo '<td>'.$section->sid.'</td>';
										echo '<td><b style="color:#5066e1;">'.$section->section_name.'</b></td>';
										echo '<td>'.$section->section_full_path.'</td>';
										if($section->parent_id!=null){
											echo '<td>'.get_parentsection($section->parent_id , $sections).'</td>';
										}else{
											echo '<td>-</td>';
										}
										
										echo '<td>';
										if($section->status==1){
											echo '<span class="icon-block mr-3 bg-success icon-block-xs icon-block-floating"><i data-feather="check" class="width-18 height-18"></i></span>';						
										}else{
											echo '<span class="icon-block mr-3 bg-danger icon-block-xs icon-block-floating"><i data-feather="x" class="width-18 height-18"></i>  </span>';
										}
										echo '</td>';
										echo '<td>'.$section->username.'</td>';
										echo '<td>'.$section->modified_on.'</td>';
										echo '<td><a href="'.base_url(ADMINFOLDER.'section/edit/'.$section->sid).'" type="button" class="btn btn-success btn-floating"><i class="ti-pencil"></i></a>&nbsp;&nbsp;<button type="button" onclick="delete_section('.$section->sid.' , event)" class="btn btn-danger btn-floating"><i class="ti-trash"></i></button></td>';
										echo '</tr>';
									}
								}else{
									
								}
								?>
							</tbody>
						</table>
					</div>
					<nav aria-label="section-pager" class="mb-4">
					<?php echo $pager; ?>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

function delete_section($gid ,ev){
	toastr.remove();
	let cf = confirm('Are you sure want to delete section?');
	if(cf){
		$.ajax({
			type : 'post',
			url : '<?php echo base_url(ADMINFOLDER."section/delete"); ?>',
			data : {'gid' : $gid},
			success : function(result){
			},
			error : function(err , errmsg){
				toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
			}
		});
	}
}
</script>
<!-- ./ Content -->