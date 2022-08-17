<?php
$userData = $this->session->userdata('userdata');
$templateroles = json_decode($userData['roles'] , true);
$view = $add = $edit = $delete = '';
for($i=0;$i<count($templateroles);$i++){
	if($templateroles[$i]['id']=='10'){
		$view = $templateroles[$i]['view'];
		$add = $templateroles[$i]['add'];
		$edit = $templateroles[$i]['edit'];
		$delete = $templateroles[$i]['delete'];
	}
}
?>
<input type="hidden" id="templaterole_view" value="<?php echo $view ?>">
<input type="hidden" id="templaterole_add" value="<?php echo $add ?>">
<input type="hidden" id="templaterole_edit" value="<?php echo $edit ?>">
<input type="hidden" id="templaterole_delete" value="<?php echo $delete ?>">
<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Page Template</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Page Template</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown ml-2">
            </div>
        </div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="card">
				<div class="card-body">
					<div class="list-group list-group-flush" style="height: 500px;overflow-y: scroll;">
						<?php  template_section(buildTree($sections)); ?>
						<a href="#" data-sid="20000" class="list-group-item template-list">Common Template</a>
						<a href="#" data-sid="20001" class="list-group-item template-list">Article Template</a>
                    </div>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<div class="template-header" style="float:left;width:100%;">
						<div class="col-md-3 pull-left after-template" style="display:none;padding-left:0;">
							<div class="form-group">
								<select class="form-control versions">
								</select>
								<input type="hidden" id="selected_sid" value=""> 
								<input type="hidden" id="selected_tid" value=""> 
								<input type="hidden" id="selected_block" value=""> 
								<input type="hidden" id="selected_type" value=""> 
								<input type="hidden" id="userid" value="<?php echo $this->session->userdata('uid'); ?>"> 
							</div>
						</div>
						<div class="col-md-9 pull-left after-template" style="display:none;padding-left:0;">
							<li class="list-inline-item mb-0" style="margin:0;margin-right: 10px;">
								<a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</a>
								<div class="dropdown-menu">
									<a style="cursor:pointer;" class="dropdown-item" onclick="create_template()"><i class="ti-archive"></i> Create New Template</a>
									<a style="cursor:pointer;" class="dropdown-item"><i class="ti-eye"></i> Preview</a>
								</div>
							</li>
							<button style="margin-right: 10px;" id="lock_template" class="btn btn-danger"> <i class="ti-lock"></i>&nbsp;Lock Template</button>
							<button style="display:none;margin-right: 10px;" id="unlock_template" class="btn btn-danger"> <i class="ti-unlock"></i>&nbsp;Unlock Template</button>
							<button style="display:none;margin-right: 10px;" id="update_template" class="btn btn-primary"> <i class="ti-unlock"></i>&nbsp;Publish</button>
						</div>
						<p style="display:none;" class="user-info"></p>
					</div>
					<div class="template text-center" style="float:left;width:100%;">
						<div class="spinner-grow text-primary" role="status" style="width: 5rem;height: 5rem;">
							<span class="sr-only">Loading...</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="block_modal" tabindex="-1" role="dialog"
		 aria-labelledby="exampleModal1Label" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="ti-settings"></i> BLOCK CONFIG</h5>
					<button type="button" class="close block_template_close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<button id="block_config_save" type="button" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-secondary block_template_close">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="template_modal" tabindex="-1" role="dialog"
		 aria-labelledby="exampleModal1Label" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">SELECT TEMPLATE</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="types text-center">
						<img src="<?php echo ASSETURL.'images/template/type1.png'; ?>">
						<button class="select_template btn btn-primary" data-type="3" type="button">Select</button>
					</div>
					<div class="types text-center">
						<img src="<?php echo ASSETURL.'images/template/type2.png'; ?>">
						<button class="select_template btn btn-primary" data-type="3,2-1,3" type="button">Select</button>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- BEGIN: Chat List -->
	<div class="sidebar-group">
    <div class="sidebar" id="chat-list">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title d-flex justify-content-between">
                    Blocks
                    <a style="width: 25px;font-size: 24px;height: 23px;display:block;" class="btn-sidebar-close" href="#"><i class="ti-close"></i></a>
                </h6>
                <div class="list-group list-group-flush">
					<?php
						$blocks = blocks();
						echo '<hr>';
						foreach($blocks as $block){
							echo '<a class="list-group-item px-0 align-items-start">';
							echo '<h6><b>'.$block['block_name'].'</b></h6>';
							echo '<img style="width:100%;" src="'.ASSETURL.$block['block_image'].'">';
							echo '<p style="text-align: center;margin-top: 8px;"><button onclick="add_block('.$block['bid'].')" class="btn btn-primary">Select</button></p>';
							echo '<hr>';
							echo '</a>';
						}
					?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- END: Chat List -->
</div>

<!-- ./ Content -->  