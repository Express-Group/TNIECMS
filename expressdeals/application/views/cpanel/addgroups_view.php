<?php
$urlparam = strtolower($this->uri->segment(3));
$formurl = ($urlparam=='add') ? base_url(ADMINFOLDER.'groups/add') : base_url(ADMINFOLDER.'groups/edit/'.$this->uri->segment(4));
?>
<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3><?php echo ($urlparam=='add') ? 'Add' : 'Edit'; ?> Groups</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'home'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'groups'); ?>">Groups</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo ($urlparam=='add') ? 'Add' : 'Edit'; ?></li>
                </ol>
            </nav>
        </div>
	</div>
	<div class="row">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-6">
                    <div class="pricing-table card">
                        <div class="card-body">
							<form method="post" action="<?php echo $formurl; ?>">
							<div class="form-group">
								<label for="group-name">Group Name <sup>*</sup></label>
								<input type="text" value="<?php echo set_value('group_name'); ?><?php if(isset($detial['group_name']) && $detial['group_name']!='' && set_value('group_name')=='' && $urlparam=='edit'){ echo $detial['group_name'];} ?>" class="form-control" name="group_name">
								<?php echo form_error('group_name' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="group-description">Group Description <sup>*</sup></label>
								<textarea class="form-control" name="group_description"><?php echo set_value('group_description'); ?><?php if(isset($detial['group_description']) && $detial['group_description']!='' && set_value('group_description')=='' && $urlparam=='edit'){ echo $detial['group_description'];} ?></textarea>
								<?php echo form_error('group_description' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="group-status">Status <sup>*</sup></label>
								<select class="form-control" name="status">
									<option value="">Please select any one</option> 
									<option <?php if(isset($detial['status']) && $detial['status']!='' && $urlparam=='edit' && $detial['status']=='1'){ echo ' selected ';} ?> value="1">Active</option>
									<option <?php if(isset($detial['status']) && $detial['status']!='' && $urlparam=='edit' && $detial['status']=='0'){ echo ' selected ';} ?> value="0">Inactive</option>
								</select>
								<?php echo form_error('status' ,'<p class="error">','</p>'); ?>
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="reset" class="btn btn-primary">Reset</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pricing-table selected-pricing-table card bg-primary">
                        <div class="card-body" style="height:300px;overflow-y:scroll;">
                            <div class="table-responsive">
								<table class="table group-table">
									<thead>
										<tr>
											<th>Name</th>
											<th>VIEW</th>
											<th>ADD</th>
											<th>EDIT</th>
											<th>DELETE</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$menus = get_menu();
									$i=1;
									$roles =[];
									if(isset($detial['roles']) && $detial['roles']!='' && $urlparam=='edit'){
										$roles = json_decode($detial['roles'] , true);
										
									}
									foreach($menus as $menu):
										$role = menucheck($menu->mid ,$roles);
										echo '<tr>';
										if($menu->parent_id==null){
											echo '<td>'.$menu->menu_name.'<input type="hidden" name="menu_'.$i.'" value="'.$menu->mid.'"></td>';
										}else{
											echo '<td>&nbsp;&nbsp;&nbsp;'.$menu->menu_name.'<input type="hidden" name="menu_'.$i.'" value="'.$menu->mid.'"></td>';
										}
										echo '<td>';
										echo '<div class="checkbox"><label><input type="checkbox" name="view_'.$i.'" '.((isset($role['view']) && $role['view']==1) ? ' checked ':'').'></label></div>';
										echo '</td>';
										echo '<td>';
										echo '<div class="checkbox"><label><input type="checkbox" name="add_'.$i.'" '.((isset($role['add']) && $role['add']==1) ? ' checked ':'').'></label></div>';
										echo '</td>';
										echo '<td>';
										echo '<div class="checkbox"><label><input type="checkbox" name="edit_'.$i.'" '.((isset($role['edit']) && $role['edit']==1) ? ' checked ':'').'></label></div>';
										echo '</td>';
										echo '<td>';
										echo '<div class="checkbox"><label><input type="checkbox" name="delete_'.$i.'" '.((isset($role['delete']) && $role['delete']==1) ? ' checked ':'').'></label></div>';
										echo '</td>';
										echo '</tr>';
										$i++;
									endforeach;
									?> 
									</tbody>
								</table>
								<input type="hidden" name="menu_count" value="<?php echo count($menus); ?>">
							</div>
							
							</form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- ./ Content --> 