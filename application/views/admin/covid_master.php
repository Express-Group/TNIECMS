<link href="<?php echo image_url; ?>css/admin/bootstrap.min_3_3_4.css" rel="stylesheet" type="text/css">	
<link href="<?php echo image_url; ?>css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo image_url; ?>css/admin/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<style>
.alert-success{float: left;margin: 0 34.2%;}
.alert-danger{float: left;margin: 0 34.4%;}
</style>
<div class="Container">
	<div class="BodyWhiteBG">
		<div class="BodyHeadBg Overflow clear">
			<div class="FloatLeft  BreadCrumbsWrapper PollResult">
				<div class="breadcrumbs"><a href="#">Dashboard</a> > <a href="#"><?php echo $title; ?></a></div>
					<h2><?php echo $title; ?></h2>
				</div> 
				<div class="FloatRight SaveBackTop PubUnpublish">
					<ul class="nav navbar-nav">
					  <li><a style="margin-right: 10px;" class="btn btn-primary" href="<?php echo base_url(folder_name.'/covidmaster/add'); ?>">Add Hospital</a></li>
					</ul>
				</div>
			</div>
			<div class="Overflow DropDownWrapper">
				<div class="container">
					<div class="FloatLeft TableColumn" style="margin-top: 20px;">
						<div class="FloatLeft w2ui-field">
							<select id="states" class="controls">
								<option value="">State</option>
								<?php
								foreach($states as $state):
									echo '<option '.(($state->State_Id==$this->input->get('states'))?' selected ' :'').' value="'.$state->State_Id.'">'.$state->StateName.'</option>';
								endforeach;
								?>
							</select>	
						</div>
						<div class="FloatLeft w2ui-field">
							<select id="cities" class="controls">
								<option value="">City</option>
								<?php
								foreach($cities as $city):
									echo '<option '.(($city->City_id == $this->input->get('cities'))?' selected ' :'').' value="'.$city->City_id.'">'.$city->CityName.'</option>';
								endforeach;
								?>
							</select>	
						</div>
						<div class="FloatLeft w2ui-field">
							<select id="type" class="controls">
								<option value="">Requirements</option>
								<option value="1" <?php if($this->input->get('type')=='1'){ echo ' selected ';} ?>>Hospital (normal beds)</option>
								<option value="2" <?php if($this->input->get('type')=='2'){ echo ' selected ';} ?>>Hospital bed (oxygen beds)</option>
								<option value="3" <?php if($this->input->get('type')=='3'){ echo ' selected ';} ?>>Hospital bed (ICU beds)</option>
								<option value="4" <?php if($this->input->get('type')=='4'){ echo ' selected ';} ?>>Ventilator</option>
							</select>	
						</div>
						<div class="FloatLeft w2ui-field">
							<select id="status" class="controls">
								<option value="">Status - All</option>
								<option value="1" <?php if($this->input->get('status')=='1'){ echo ' selected ';} ?>>Active</option>
								<option value="0" <?php if(@$_GET['status']=='0'){ echo ' selected ';} ?>>Inactive</option>
							</select>	
						</div>
						<div class="FloatLeft TableColumnSearch">
							<input type="search" placeholder="Search" class="SearchInput" id="search_text" value="<?php echo $this->input->get('search_text'); ?>">
						</div>
						<button class="btn btn-primary" type="button" id="search">Search</button>
						<button onclick="window.location.href ='<?php echo base_url(folder_name);?>/covidmaster'" class="btn btn-primary" id="clear_search">Clear Search</button>
					</div>
					<?php if($this->session->flashdata("type")!='' && $this->session->flashdata("type")=='1'):?>
					 <div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> New Hospital/Centre added successfully
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata("type")!='' && $this->session->flashdata("type")=='2'):?>
					 <div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> New Hospital/Centre updated successfully
					</div>
					<?php endif; ?>
					<?php if($this->session->flashdata("type")!='' && $this->session->flashdata("type")=='0'):?>
					<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Danger!</strong> Something went wrong.please try again
					</div>
					<?php endif; ?>
					<table id="example" class="display dataTable" cellspacing="0" width="100%" style="margin-top:10px;">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Centre Name</th>
								<th>State</th>
								<th>City</th>
								<th>Requirement Type</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i =1;
							foreach($data as $list){
								echo '<tr>';
								echo '<td>'.$i.'</td>';
								echo '<td>'.$list->centre.'</td>';
								echo '<td>'.$list->StateName.'</td>';
								echo '<td>'.$list->CityName.'</td>';
								echo '<td>'.$controller->get_types($list->cid).'</td>';
								if($list->status==1){
									echo '<td><span class="label label-success">Active</span></td>';
								}else{
									echo '<td><span class="label label-danger">Inactive</span></td>';
								}
								echo '<td><a class="btn btn-primary" href="'.base_url(folder_name).'/covidmaster/edit/'.$list->cid.'"><i class="fa fa-pencil"></i></a></td>';
								echo '</tr>';
								$i++;
							}
							?>
						</tbody>
					</table>
					<div class="pager pull-left"><?php echo str_replace('<a' ,'<a class="btn btn-primary" ' , $pagination); ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/bootstrap.min.js"></script>
<script  type="text/javascript">
$('#example').dataTable({
	"paging" : false,
    "ordering" : false,
    "info" : false
});
$(document).ready(function(e){
	$('#states').on('change' , function(e){
		if($(this).val()!=''){
			$.get("<?php echo base_url(folder_name) ?>/covidmaster/cities?id="+$(this).val(), function(data, status){
				$('#cities').html(data);
			});
		}
	});
	$('#search').on('click' , function(e){
		var states = $('#states').val();
		var cities = $('#cities').val();
		var type = $('#type').val();
		var status = $('#status').val();
		var search_text = $('#search_text').val().trim();
		window.location.href = "<?php echo base_url(folder_name)?>/covidmaster?states="+states+"&cities="+cities+"&type="+type+"&status="+status+"&search_text="+search_text;
	});
});
</script>