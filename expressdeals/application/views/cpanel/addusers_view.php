<?php
$type = 'Add';
$form = base_url(ADMINFOLDER.'users/add');
if($this->uri->segment(3)=='edit'){
	$type = 'Edit';
	$form = base_url(ADMINFOLDER.'users/edit/'.$this->uri->segment(4));
} 
?>
<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3><?php echo $type; ?> Users</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'home'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'users'); ?>">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $type; ?></li>
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
							<form method="post" action="<?php echo $form; ?>">
							<div class="form-group">
								<label for="first-name">First Name <sup>*</sup></label>
								<input type="text" value="<?php echo set_value('first_name'); ?><?php if(set_value('first_name')=='' && isset($userDetails['firstname']) && $userDetails['firstname']!=''){ echo $userDetails['firstname'];} ?>" class="form-control" name="first_name">
								<?php echo form_error('first_name' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="last-name">Last Name <sup>*</sup></label>
								<input type="text" value="<?php echo set_value('last_name'); ?><?php if(set_value('last_name')=='' && isset($userDetails['lastname']) && $userDetails['lastname']!=''){ echo $userDetails['lastname'];} ?>" class="form-control" name="last_name">
								<?php echo form_error('last_name' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="usrname">Username <sup>*</sup></label>
								<input type="text" value="<?php echo set_value('username'); ?><?php if(set_value('username')=='' && isset($userDetails['username']) && $userDetails['username']!=''){ echo $userDetails['username'];} ?>" class="form-control" name="username">
								<?php echo form_error('username' ,'<p class="error">','</p>'); ?>
							</div>							
							<button type="submit" class="btn btn-primary">Submit</button>
							
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pricing-table card">
                        <div class="card-body">
                            <div class="form-group">
								<label for="password">Password <sup>*</sup></label>
								<input type="password" value="<?php echo set_value('password'); ?>" class="form-control" name="password">
								<?php echo form_error('password' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="group">Group <sup>*</sup></label>
								<select class="form-control" name="group" <?php if($type=='Edit'){ echo ' disabled ';} ?>>
									<option value="">Please select any one</option>
									<?php
									foreach($groups as $group):
									echo '<option '.((isset($userDetails['gid']) && $userDetails['gid']==$group->gid) ? ' selected ':'').' value="'.$group->gid.'">'.$group->group_name.'</option>';
									endforeach;
									?>
								</select>
								<?php echo form_error('group' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="user-status">Status <sup>*</sup></label>
								<select class="form-control" name="status">
									<option value="">Please select any one</option> 
									<option <?php if(isset($userDetails['status']) && $userDetails['status']=='1'){ echo ' selected ';} ?> value="1">Active</option>
									<option <?php if(isset($userDetails['status']) && $userDetails['status']=='0'){ echo ' selected ';} ?> value="0">Inactive</option>
								</select>
								<?php echo form_error('status' ,'<p class="error">','</p>'); ?>
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