<link href="<?php echo image_url; ?>css/admin/bootstrap.min_3_3_4.css" rel="stylesheet" type="text/css">	
<link href="<?php echo image_url; ?>css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo image_url; ?>css/admin/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<style>
.form-group{width:100%;}
.form-control{border: 1px solid #ccc !important;}
sup{color:red;}
.checkbox-inline input[type=checkbox]{float: left;position: relative !important;margin-top: 3px !important;}
.checkbox-inline{padding-left: 1px;}
p.error{color:red;margin:0;}
</style>
<div class="Container">
	<div class="BodyWhiteBG">
		<div class="BodyHeadBg Overflow clear">
			<div class="FloatLeft  BreadCrumbsWrapper PollResult">
				<div class="breadcrumbs"><a href="#">Dashboard</a> > <a href="#">Add Hospital</a></div>
					<h2>Add Hospital</h2>
			</div> 
			<div class="FloatRight SaveBackTop PubUnpublish">
				<ul class="nav navbar-nav">
				  <li><a style="margin-right: 10px;" class="btn btn-primary" href="<?php echo base_url(folder_name.'/covidmaster'); ?>">Go Back</a></li>
				</ul>
			</div>
		</div>
			<div class="Overflow DropDownWrapper">
				<div class="container"><form method="post" action="<?php echo current_url(); ?>">
					<div class="row" style="margin-top: 15px;width: 100%;">
						<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
							<div class="form-group">
								<label>Select State <sup>*</sup></label>
								<select name="states" class="form-control">
									<option value="">Please select any one</option>
									<?php
									foreach($states as $state):
										echo '<option value="'.$state->State_Id.'">'.$state->StateName.'</option>';
									endforeach;
									?>
								</select>
								<?php echo form_error('states', '<p class="error">', '</p>'); ?>
							</div>
							<div class="form-group">
								<label>Select City <sup>*</sup></label>
								<select name="cities" class="form-control">
									<option value="">Please select any one</option>
								</select>
								<?php echo form_error('cities', '<p class="error">', '</p>'); ?>
							</div>
							<div class="form-group">
								<label>Status <sup>*</sup></label>
								<select name="status" class="form-control">
									<option value="">Please select any one</option>
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
								<?php echo form_error('status', '<p class="error">', '</p>'); ?>
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
							<div class="form-group">
								<label>Enter Centre / Hospital Name <sup>*</sup></label>
								<input type="text" name="centre" class="form-control">
								<?php echo form_error('centre', '<p class="error">', '</p>'); ?>
							</div>
							<div class="form-group">
								<label>Address <sup>*</sup></label>
								<textarea type="text" name="address" class="form-control"></textarea>
								<?php echo form_error('address', '<p class="error">', '</p>'); ?>
							</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
							<div class="form-group">
								<label>Description </label>
								<textarea type="text" name="description" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label>Contact Number (seperate with comma) <sup>*</sup></label>
								<input type="text" name="contact_number" class="form-control">
								<?php echo form_error('contact_number', '<p class="error">', '</p>'); ?>
							</div>
							<div class="form-group">
								<label class="checkbox-inline">
									<input name="type[]" type="checkbox" value="1">Hospital (normal beds)
								</label>
								<label class="checkbox-inline">
									<input name="type[]" type="checkbox" value="2">Hospital bed (oxygen beds)
								</label>
								<label class="checkbox-inline">
									<input name="type[]" type="checkbox" value="3">Hospital bed (ICU beds)
								</label>
								<label class="checkbox-inline">
									<input name="type[]" type="checkbox" value="4">Ventilator
								</label>
								<?php echo form_error('type[]', '<p class="error">', '</p>'); ?>
							</div>
						</div>
					</div>
					<div class="row" style="width: 100%;">
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
							<button type="submit" value="submit" class="btn btn-primary">Submit</button>
						</div>
					</div></form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/bootstrap.min.js"></script>
<script>
$(document).ready(function(e){
	$('select[name="states"]').on('change' , function(e){
		if($(this).val()!=''){
			$.get("<?php echo base_url(folder_name) ?>/covidmaster/cities?id="+$(this).val(), function(data, status){
				$('select[name="cities"]').html(data);
			});
		}
	});
});
</script>