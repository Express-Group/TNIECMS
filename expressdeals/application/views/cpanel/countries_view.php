<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Countries</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'components/author'); ?>">Components</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Countries</li>
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
                            <input value="<?php echo $this->input->get('id') ?>" type="text" class="form-control" name="id">
                        </div>
                        <button type="submit" class="btn btn-primary">Get Results</button>
                        <button type="button" onclick="window.location.href='<?php echo base_url(ADMINFOLDER.'components/countries'); ?>'" class="btn btn-link ml-2">Clear Filter</button>
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
									<th>Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(count($data) > 0){
									foreach($data as $countries){
										echo '<tr>';
										echo '<td>'.$countries->cid.'</td>';
										echo '<td>'.$countries->name.'</td>';
										echo '<td><a href="'.base_url(ADMINFOLDER.'components/author/edit/'.$countries->cid).'" type="button" class="btn btn-success btn-floating"><i class="ti-pencil"></i></a>&nbsp;&nbsp;<button type="button" onclick="delete_author('.$countries->cid.')" class="btn btn-danger btn-floating"><i class="ti-trash"></i></button></td>';
										echo '</tr>';
									}
								}else{
									echo '<tr><th colspan="3" style="text-align:center;">NO RECORDS FOUND</th></tr>';
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