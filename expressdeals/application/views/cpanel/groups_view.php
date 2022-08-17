<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Groups</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Groups</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown">
                <a href="#" class="btn btn-success dropdown-toggle" title="Filter" data-toggle="dropdown">Filters</a>
				<div class="dropdown-menu dropdown-menu-big p-4 dropdown-menu-right">
                    <form method="get">
                        <div class="form-group">
                            <label>Group Id/Name</label>
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
                <a href="<?php echo base_url(ADMINFOLDER.'groups/add'); ?>" class="btn btn-primary">Create</a> 
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
					<div class="table-responsive">
						<table class="table table-lg">
							<thead>
								<tr>
									<th><a>ID</a></th>
									<th>Group Name</th>
									<th>Status</th>
									<th>Modified By</th>
									<th>Modified On</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(count($data) > 0){
									foreach($data as $group){
										echo '<tr>';
										echo '<td>'.$group->gid.'</td>';
										echo '<td>'.$group->group_name.'</td>';
										echo '<td>';
										if($group->status==1){
											echo '<span class="icon-block mr-3 bg-success icon-block-xs icon-block-floating"><i data-feather="check" class="width-18 height-18"></i></span>';						
										}else{
											echo '<span class="icon-block mr-3 bg-danger icon-block-xs icon-block-floating"><i data-feather="x" class="width-18 height-18"></i>  </span>';
										}
										echo '</td>';
										echo '<td>'.$group->username.'</td>';
										echo '<td>'.$group->modified_on.'</td>';
										echo '<td><a href="'.base_url(ADMINFOLDER.'groups/edit/'.$group->gid).'" type="button" class="btn btn-success btn-floating"><i class="ti-pencil"></i></a>&nbsp;&nbsp;<button type="button" onclick="delete_group('.$group->gid.' , event)" class="btn btn-danger btn-floating"><i class="ti-trash"></i></button></td>';
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
<script type="text/javascript">
function delete_group($gid ,ev){
	toastr.remove();
	$.ajax({
		type : 'post',
		url : '<?php echo base_url(ADMINFOLDER."groups/delete"); ?>',
		data : {'gid' : $gid},
		success : function(result){
			result = result.trim();
			if(result=='-1' || result=='-2'){
				toastr.error("You don't have permission to access this setting");
			}
			if(result=='0'){
				toastr.error("Unable to delete (Selected group is associated with multiple users)");
			}
			if(result=='1'){
				toastr.error("Group deleted successfully");
				location.reload();
			}
		},
		error : function(err , errcode){
			console.log(errcode);
			console.log(err);
		}
	});
}
</script>
<!-- ./ Content -->