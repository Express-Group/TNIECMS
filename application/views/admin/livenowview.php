<link href="<?php echo image_url; ?>css/admin/bootstrap.min_3_3_4.css" rel="stylesheet" type="text/css">	
<link href="<?php echo image_url; ?>css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo image_url; ?>css/admin/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<style>
#example_wrapper{margin-top:2%;}
.pagination1{width: 100%;float: left;text-align: center;}
.pagination1 a{background: #337ab7;color: #fff;padding: 2px 7px 2px;display: inline-block;border-radius: 5px;margin-right: 3px;border: 1px solid #337ab7;}
.pagination1 strong{background: #ffff;color: #337ab7;padding: 2px 7px 2px;display: inline-block;border-radius: 5px;margin-right: 3px;    border: 1px solid #337ab7;}
</style>
<div class="Container">
	<div class="BodyWhiteBG">
		<div class="BodyHeadBg Overflow clear">
			<div class="FloatLeft  BreadCrumbsWrapper PollResult">
				<div class="breadcrumbs"><a href="#">Dashboard</a> > <a href="#">Live</a></div>
				<h2>Live</h2>
			</div> 
		</div>
		<div class="Overflow DropDownWrapper">
			<div class="FloatLeft TableColumn"> 
				<div class="FloatLeft TableColumnSearch">
					<form method="get">
					<input value="<?php echo $this->input->get('query'); ?>" type="search" name="query" placeholder="Content Id/ Title" class="SearchInput" id="search_text" required>
					<button class="btn btn-primary" type="submit" id="article_search_id">Search</button>
					<button onclick="window.location.href='<?php echo base_url(folder_name.'/livenow/livenow1'); ?>'" class="btn btn-primary" type="reset" id="clear_search">Clear Search</button>
					</form>
				</div>
			</div>
			<div id="example_wrapper">
				<table class="table" id="livetable">
					<thead>
						<tr>
							<th>CONTENT ID</th>
							<th>TITLE</th>
							<th>STATUS</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach($articles as $article){
						echo '<tr>';
						echo '<td>'.$article['content_id'].'</td>';
						echo '<td>'.strip_tags($article['title']).'</td>';
						echo '<td>';
						if($article['status']=='P'){
							echo '<span style="background:green;" class="badge">PUBLISHED</span>';
						}
						if($article['status']=='U'){
							echo '<span style="background:red;" class="badge">UNPUBLISHED</span>';
						}
						if($article['status']=='D'){
							echo '<span style="background:#ddd;" class="badge">DRAFT</span>';
						}
						echo '</td>';
						echo '<td><a '.(($article['content_id'] <= 2192343) ? ' disabled ' :'').' target="_BLANK" href="'.base_url(folder_name.'/livenow/add/'.$article['content_id']).'" style="padding: 4px 7px !important;font-size: 12px;" class="btn btn-primary" ><i class="fa fa-pencil"></i></a></td>';
						echo '</tr>';
					}
					?>
					</tbody>
				</table>
				<div class="pagination1">
				<?php echo $pagiantion; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/bootstrap.min.js"></script>
<script type="text/javascript">
$('#livetable').dataTable({ 
	"bSort" : false ,
	"bPaginate": false ,
	"bInfo": false 
});
</script>