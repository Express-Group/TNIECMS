<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Content Approval Notes</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>approval">Content Approval</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notes</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
            <div class="dropdown">
                <a href="#" class="btn btn-success dropdown-toggle" title="Filter" data-toggle="dropdown">Filters</a>
				<div class="dropdown-menu dropdown-menu-big p-4 dropdown-menu-right">
                    <form method="get" id="article_search2">
						<div class="form-group">
                            <label>Type</label>
                            <select class="form-control" name="search_by">
                                <option value="">Please select any one</option> 
                                <option <?php if($this->input->get('search_by')=='1'){ echo ' selected'; } ?> value="1">Content ID</option>
                                <option <?php if($this->input->get('search_by')=='2'){ echo ' selected'; } ?> value="2">Title</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Query</label>
                            <input value="<?php echo $this->input->get('query') ?>" type="text" class="form-control" name="query">
                        </div>
                        <button type="submit" class="btn btn-primary">Get Results</button>
                        <button type="button" onclick="window.location.href='<?php echo base_url(ADMINFOLDER.'approval/notes'); ?>'" class="btn btn-link ml-2">Clear Filter</button>
                    </form>
                </div>
            </div>
        </div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-lg" style="font-size: 13px;">
							<thead>
								<tr class="text-center">
									<th>Content ID</th>
									<th>Title</th>
									<th>Image</th>
									<th>Last Updated On</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if(count($data) > 0){
									foreach($data as $article){
										$title =  strip_tags($article->title);
										echo '<tr class="notes-'.$article->content_id.'">';
										echo '<td>'.$article->content_id.'</td>';
										echo '<td><p style="margin:0;" data-toggle="tooltip" title="'.$title.'">'.shortDescription($title).'</p></td>';
										if($article->image_path!=''){
											$imagepath = str_replace('original/' , 'medium/' , $article->image_path);
											$imagepath = ASSETURL.IMAGE_PATH.$imagepath;
											echo '<td class="text-center"><img style="width: 65px;border-radius:5px;" src="'.$imagepath.'" alt="'.trim($article->image_alt).'"></td>';
										}else{
											echo '<td class="text-center">-</td>';
										}
										echo '<td class="text-center">'.$article->last_updated_on.'</td>';
										
										echo '<td><button type="button" onclick="view_notes('.$article->content_id.')" class="btn btn-danger btn-floating btn-notes-'.$article->content_id.'"><i class="ti-angle-down"></i></button></td>';
										echo '</tr>';
										echo '<tr class="notes-view-'.$article->content_id.'" style="display:none;">';
										echo '<td colspan="5" class="text-center"></td>';
										echo '<tr>';
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
<!-- modals -->
<div class="modal fade" id="preview_article">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title">ARTICLE PREVIEW</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
			</div>
			<!-- Modal footer -->
			<div class="modal-footer" style="border:none;">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="approve_article">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title">ARTICLE APPROVAL</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div class="form-group">
					<label for="notes">Notes <sup>*</sup></label>
					<textarea class="form-control" id="notes"></textarea>
					<input type="hidden" id="article_id">
				</div>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer" style="border:none;">
			  <button type="button" class="btn btn-success" onclick="approve()">Approve</button>
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- ./ Content --> 