<?php
$CI = &get_instance();
$selectedSection =0;
if(isset($blockDetails['section']) && $blockDetails['section']!=''){
	$selectedSection = $blockDetails['section'];
}
$listSelected = [];
if(isset($blockDetails['articles']) && $blockDetails['articles']!=''){
	$selectedArticles = explode(',' ,$blockDetails['articles']);
	for($i=0;$i<count($selectedArticles);$i++){
		if($selectedArticles[$i]!=''){
			$id= explode('-' ,$selectedArticles[$i]);
			array_push($listSelected , $id[0]);
		}
		
	}
	
}
$listSelected1 = implode(',' ,$listSelected);
?>
<input type="hidden" value="<?php echo $type ?>" id="block_type">
<input type="hidden" value="<?php echo $timestamp ?>" id="timestamp">
<input type="hidden" value="<?php echo $json ?>" id="json">
<ul class="nav nav-tabs mb-3" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" id="home-tab" data-toggle="tab" href="#Settings" role="tab"
       aria-controls="Settings" aria-selected="true"><i class="ti-settings"></i> Settings</a>
	</li>
	<?php if($type==1): ?>
	<li class="nav-item profile-tab-1" <?php if(isset($blockDetails['mode']) && $blockDetails['mode']=='1'){ echo ' style="display:none;" '; } ?>>
		<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
       aria-controls="profile" aria-selected="false"><i class="ti-book"></i> Profile</a>
	</li>
	<?php endif; ?>
</ul>
<div class="tab-content">
	<div class="tab-pane fade show active" id="Settings" role="tabpanel" aria-labelledby="home-tab">
		<div class="form-group">
			<label>Block Title <sup>*</sup></label>
			<input type="text" class="form-control" id="block_title" value="<?php if(isset($blockDetails['block_title']) && $blockDetails['block_title']!=''){ echo $blockDetails['block_title']; } ?>">
		</div>
		<div class="form-group">
			<label>Block Link</label>
			<input type="text" class="form-control" id="block_link" value="<?php if(isset($blockDetails['block_link']) && $blockDetails['block_link']!=''){ echo $blockDetails['block_link']; } ?>">
		</div>
		<?php if($type==1): ?>
		<div class="form-group">
			<label>Block Summary </label>
			<textarea class="form-control" id="summary"><?php if(isset($blockDetails['summary']) && $blockDetails['summary']!=''){ echo $blockDetails['summary']; } ?></textarea>
		</div>
		<div class="form-group">
			<label>Summary</label>
			<select class="form-control" id="summary_status">
				<option value="1" <?php if(isset($blockDetails['summary_status']) && $blockDetails['summary_status']=='1'){ echo ' selected '; } ?>>Show</option>
				<option value="0" <?php if(isset($blockDetails['summary_status']) && $blockDetails['summary_status']=='0'){ echo ' selected '; } ?>>Hide</option>
			</select>
		</div>
		<div class="form-group">
			<label>Max Articles <sup>*</sup></label>
			<input type="number" class="form-control" id="max_article" value="<?php if(isset($blockDetails['max_article']) && $blockDetails['max_article']!=''){ echo $blockDetails['max_article']; } ?>">
		</div>
		<div class="form-group">
			<label>Mode</label>
			<select class="form-control" id="mode">
				<option value="">please Select any one</option>
				<option value="1" <?php if(isset($blockDetails['mode']) && $blockDetails['mode']=='1'){ echo ' selected '; } ?>>Auto</option>
				<option value="2" <?php if(isset($blockDetails['mode']) && $blockDetails['mode']=='2'){ echo ' selected '; } ?>>Manual</option>
			</select>
		</div>
		<div class="form-group">
			<label>Section</label>
			<select class="form-control" id="section">
				<option value="">Please select any one</option>
				<?php echo section_dropdown_template(buildTree($sections) , $selectedSection); ?>
			</select>
		</div>
		<?php endif; ?>
		<?php if($type==2): ?>
		<div class="form-group">
			<label>Content</label>
			<textarea class="form-control" id="content"><?php if(isset($blockDetails['content']) && $blockDetails['content']!=''){ echo $blockDetails['content']; } ?></textarea>
		</div>
		<?php endif; ?>
		<div class="form-group">
			<label>Status <sup>*</sup></label>
			<select class="form-control" id="status">
				<option value="1" <?php if(isset($blockDetails['status']) && $blockDetails['status']=='1'){ echo ' selected '; } ?>>Active</option>
				<option value="0" <?php if(isset($blockDetails['status']) && $blockDetails['status']=='0'){ echo ' selected '; } ?>>Inactive</option>
			</select>
		</div>
	</div>
	<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<select class="form-control" id="section_main">
						<option value="">Please select any one</option>
						<?php 
							if($selectedSection!=0){
								if(isset($SectionDetails) && $SectionDetails!=''){
									echo $SectionDetails;
								}
								section_dropdown_template(buildTree($sections , $selectedSection));
							}else{
								section_dropdown_template(buildTree($sections));
							}
						?>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Enter title /content Id">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<button type="button" class="btn btn-primary"><i class="ti-search"></i> Search</button>
				</div>
			</div>
		</div>
		<div class="form-group selected-content">
			<div class="table-responsive">
				<table class="table" id="selected_content">
					<thead>
						<tr>
							<th style="text-align: center;background: #eee;color: #2540d9 !important;" colspan="5" style="text-align:center;">SELECTED CONTENT</th>
						</tr>
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Content type</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$contents = $CI->selected_content($listSelected1);
					foreach($contents as $article){
						echo '<tr class="content-selected-list-'.$article->content_id.'" data-type="'.$article->content_type.'" data-id="'.$article->content_id.'">';
						echo '<td>'.$article->content_id.'</td>';
						echo '<td>'.shortDescription(strip_tags($article->title)).'</td>';
						echo '<td>';
						if($article->content_type=='1'){
							echo 'ARTICLE';
						}
						if($article->content_type=='2'){
							echo 'GALLERY';
						}
						if($article->content_type=='3'){
							echo 'VIDEO';
						}
						echo '</td>';
						echo '<td>';
						if($article->image_path!=''){
							echo '<img src= "'.ASSETURL.IMAGE_PATH.str_replace('original/' , 'medium/' ,$article->image_path).'" style="width: 65px;border-radius:5px;">';
						}else{
							echo '-';
						}
						
						echo '</td>';
						echo '<td><button onclick="remove_template_articles('.$article->content_id.')" style="padding: 6px 8px;" class="btn btn-primary">Remove</button></td>';
						echo '</tr>';
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="form-group content-list">
		<?php
			$CI->get_content($selectedSection , $listSelected , 1);
		?>
		</div>
	</div>
</div> 