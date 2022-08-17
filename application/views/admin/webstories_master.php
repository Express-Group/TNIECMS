<link href="<?php echo image_url; ?>css/admin/bootstrap.min_3_3_4.css" rel="stylesheet" type="text/css">	
<link href="<?php echo image_url; ?>css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo image_url; ?>css/admin/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<style>
.pager{width:100%;float:left;}
.pager a , .pager strong{margin-right: 5px;background: #3c8dbc;color: #fff;padding: 4px 10px;border-radius: 3px;}
.pager strong{background: #5bc0de;}
</style>
<div class="Container">
	<div class="BodyWhiteBG">
		<div class="BodyHeadBg Overflow clear">
			<div class="FloatLeft  BreadCrumbsWrapper PollResult">
				<div class="breadcrumbs"><a href="#">Dashboard</a> > <a href="#"><?php echo $title; ?></a></div>
				<h2><?php echo $title; ?></h2>
			</div> 
			<?php if(defined("USERACCESS_ADD".$Menu_id) && constant("USERACCESS_ADD".$Menu_id) == 1) { ?>
			<p class="FloatRight SaveBackTop"><a href="<?php echo base_url(folder_name.'/webstories_master/add'); ?>" class="btn-primary btn"><i class="fa fa-plus-circle"></i> Add</a></p>
			<?php } ?>
		</div>
		<div class="Overflow DropDownWrapper">
			<div class="container">
				<div class="FloatLeft TableColumn">
					<div class="FloatLeft w2ui-field">
						<select id="status" class="controls">
							<option value="">Status: All</option>
							<option <?php echo (isset($_GET['type']) && $_GET['type']=='2')? 'selected':''; ?> value="2" >Draft</option>
							<option <?php echo (isset($_GET['type']) && $_GET['type']=='1')? 'selected':''; ?> value="1" >Published</option>
							<option <?php echo (isset($_GET['type']) && $_GET['type']=='0')? 'selected':''; ?> value="0" >Unpublished</option>
						</select>
					</div>
					<div class="FloatLeft TableColumnSearch">
						<input value="<?php $this->input->get('query'); ?>" type="search" placeholder="Search" class="SearchInput" id="search_text" >
					</div>
					<button class="btn btn-primary" type="button" id="search">Search</button>
					<button onclick="window.location.href='<?php echo base_url(folder_name); ?>/webstories_master'" class="btn btn-primary" id="clear_search">Clear Search</button>
				</div>
				<table id="example" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Headline</th>
							<th>Section</th>
							<th>Poster Image</th>
							<th>Modified By</th>
							<th>Modified On</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php	
					foreach($data as $stories){
						echo '<tr>';
						echo '<td title="'.$stories->title.'">'.shortDescription($stories->title).'</td>';
						echo '<td>'.(($stories->Sectionname!='')? $stories->Sectionname : '-').'</td>';
						echo '<td>';
						if($stories->poster_image){
							echo '<img src="'.image_url.'images/webstories/poster_image/'.$stories->poster_image.'" style="width:75px;height:75px;object-fit:cover;border-radius: 5px;">';
						}else{
							echo '-';
						}
						echo '</td>';
						echo '<td>'.$stories->Username.'</td>';
						echo '<td>'.$stories->modified_on.'</td>';
						if($stories->status=='2'){
							echo '<td><span class="label label-info">DRAFT</span></td>';
						}
						if($stories->status=='1'){
							echo '<td><span class="label label-success">PUBLISHED</span></td>';
						}
						if($stories->status=='0'){
							echo '<td><span class="label label-warning">UNPUBLISHED</span></td>';
						}
						echo '<td>';
						echo '<button onclick="window.open(\''.base_url(folder_name).'/webstories_master/edit/'.$stories->wsid.'\' , \'_blank\')" style="padding: 5px 8px !important;" class="btn btn-primary"><i class="fa fa-pencil"></i></button>';
						if(defined("USERACCESS_VIEW".$Menu_id) && constant("USERACCESS_VIEW".$Menu_id) == 1){
							echo '<a target="_BLANK" href="'.base_url(folder_name).'/webstories_master/preview_story/'.$stories->wsid.'" style="padding: 5px 8px !important;" class="btn btn-primary"><i class="fa fa-eye"></i></a>';
						}
						if($stories->url!=''){
							echo '<a title="Live Link" target="_BLANK" href="'.BASEURL.$stories->url.'" style="padding: 2.1px 6px !important;margin-left: 5px;margin-right: 5px;" class="btn btn-primary"><i class="fa fa-eye"></i> Live</a>';
						}
						echo '</td>';
						echo '</tr>';
					}
					?>
					</tbody>
				</table>
				<div class="pager"><?php echo $links; ?></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/bootstrap.min.js"></script>
<script type="text/javascript">
$('#example').dataTable({
	oLanguage: {
        sProcessing: "<img src='<?php echo image_url; ?>images/admin/loadingroundimage.gif' style='width:40px; height:40px;'>"
    },
	"autoWidth": false,
	"searching": false,
	"bPaginate": false,
	"aaSorting": []
});
$(document).ready(function(){
	$('#search').on('click' , function(e){
		var status = $('#status').val();
		var search_txt = $('#search_text').val().trim();
		window.location.href = "<?php echo base_url(folder_name) ?>/webstories_master?type="+status+'&query='+search_txt;
	});
});
</script>