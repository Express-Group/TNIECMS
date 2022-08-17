<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Author</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'components/author'); ?>">Components</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Author</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown">
                <a href="#" class="btn btn-success dropdown-toggle" title="Filter" data-toggle="dropdown">Filters</a>
				<div class="dropdown-menu dropdown-menu-big p-4 dropdown-menu-right">
                    <form method="get">
                        <div class="form-group">
                            <label>Author ID/name</label>
                            <input value="<?php echo $this->input->get('aid') ?>" type="text" class="form-control" name="aid">
                        </div>
                        <button type="submit" class="btn btn-primary">Get Results</button>
                        <button type="button" onclick="window.location.href='<?php echo base_url(ADMINFOLDER.'components/author'); ?>'" class="btn btn-link ml-2">Clear Filter</button>
                    </form>
                </div>
            </div>
            <div class="dropdown ml-2">
                <a href="<?php echo base_url(ADMINFOLDER.'components/author/add'); ?>" class="btn btn-primary">Create</a> 
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
						<strong>Success!</strong> New Author added successfully.
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('message')==2 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> Author updated successfully.
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
									<th>Author Name</th>
									<th>Author Image</th>
									<th>Status</th>
									<th>Modified By</th>
									<th>Modified On</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(count($data) > 0){
									foreach($data as $author){
										echo '<tr>';
										echo '<td>'.$author->aid.'</td>';
										echo '<td>'.$author->author_name.'</td>';
										if($author->author_image!=''){
											echo '<td class="text-center"><img style="width:40px;" src="'.base_url(AUTHOR_IMAGE_PATH.$author->author_image).'"</td>';
										}else{
											echo '<td class="text-center">-</td>';
										}
										echo '<td>';
										if($author->status==1){ 
											echo '<span class="icon-block mr-3 bg-success icon-block-xs icon-block-floating"><i data-feather="check" class="width-18 height-18"></i></span>';						
										}else{
											echo '<span class="icon-block mr-3 bg-danger icon-block-xs icon-block-floating"><i data-feather="x" class="width-18 height-18"></i></span>';
										}
										echo '</td>';
										echo '<td>'.$author->username.'</td>';
										echo '<td>'.$author->modified_on.'</td>';
										echo '<td><a href="'.base_url(ADMINFOLDER.'components/author/edit/'.$author->aid).'" type="button" class="btn btn-success btn-floating"><i class="ti-pencil"></i></a>&nbsp;&nbsp;<button type="button" onclick="delete_author('.$author->aid.')" class="btn btn-danger btn-floating"><i class="ti-trash"></i></button></td>';
										echo '</tr>';
									}
								}else{
									echo '<tr><th colspan="7" style="text-align:center;">NO RECORDS FOUND</th></tr>';
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
	<script type="text/javascript">
	function delete_author($id){
		toastr.remove();
		let cf = confirm('Are you sure want to delete the author?');
		if(cf){
			$.ajax({
				type : 'post',
				cache : false,
				data : {'aid' : $id},
				url : '<?php echo base_url(ADMINFOLDER."components/author/delete"); ?>',
				success : function(result){
					if(result==1){
						toastr.success('Author deleted Successfully');
						location.reload();
					}else if(result==2){
						toastr.error('Cannot delete this Author');
					}else{
						toastr.error('Something went wrong..please try agian');
					}
				},
				error:function(err ,errmsg){
					toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
				}
			});
		}
	}
	</script>
</div>
<!-- ./ Content -->  