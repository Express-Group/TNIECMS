<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Merchants</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                   <li class="breadcrumb-item active" aria-current="page">Merchants</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown">
                <a href="#" class="btn btn-success dropdown-toggle" title="Filter" data-toggle="dropdown">Filters</a>
				<div class="dropdown-menu dropdown-menu-big p-4 dropdown-menu-right">
                    <form method="get">
                        <div class="form-group">
                            <label>Merchant Id / Name</label>
                            <input value="<?php echo $this->input->get('query1') ?>" type="text" class="form-control" name="query1">
                        </div>
						<div class="form-group">
                            <label>Product Id / Name</label>
                            <input value="<?php echo $this->input->get('query') ?>" type="text" class="form-control" name="query">
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
                        <button type="button" onclick="window.location.href='<?php echo base_url(ADMINFOLDER.'merchants'); ?>'" class="btn btn-link ml-2">Clear Filter</button>
                    </form>
                </div>
            </div>
            <div class="dropdown ml-2">
               <!-- <a href="<?php echo base_url(ADMINFOLDER.'merchants/add'); ?>" class="btn btn-primary">Create</a>-->
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
						<strong>Success!</strong> Merchant created successfully.
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata('message')==2 && $this->session->flashdata('message')!=''): ?>
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong>Merchant updated successfully.
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
									<th>Merchant ID</th>
									<th>Merchant Name</th>
									<th>Merchant Url</th>
									<th>Merchant Price</th>
									<th>Product Name</th>
									<th>Modified By</th>									
									<th>Modified On</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(count($data) > 0){
									foreach($data as $merchant){
										echo '<tr>';
										echo '<td>'.$merchant->mid.'</td>';
										echo '<td><p style="margin:0;" data-toggle="tooltip" title="'.$merchant->merchant_name.'">'.shortDescription(strip_tags($merchant->merchant_name)).'</p></td>';
										echo '<td><a title="'.$merchant->merchant_url.'" target="_BLANK" href="'.$merchant->merchant_url.'" style="color: #5066e1;">'.chunk_split($merchant->merchant_url, 10, '<wbr>').'</a></td>';
										echo '<td>'.$merchant->merchant_price.'</td>';
										echo '<td>'.chunk_split($merchant->product_name , 10 ,'<wbr>').'</td>';
										echo '<td>'.$merchant->username.'</td>';
										echo '<td>'.$merchant->modified_on.'</td>';
										echo '<td>';
										if($merchant->merchant_status==1){
											echo '<span class="badge bg-success">Active</span>';
										}
										if($merchant->merchant_status==0){
											echo '<span class="badge bg-danger">Inactive</span>';
										}
										echo '</td>';
										echo '<td><li class="list-inline-item mb-0">
												<a href="#" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown">Action</a>
												<div class="dropdown-menu">
													<a class="dropdown-item"><i class="ti-trash"></i> Delete</a>
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