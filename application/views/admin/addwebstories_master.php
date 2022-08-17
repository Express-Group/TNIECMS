<link href="<?php echo image_url; ?>css/admin/bootstrap.min_3_3_4.css" rel="stylesheet" type="text/css">	
<link href="<?php echo image_url; ?>css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo image_url; ?>css/admin/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<style>
.modal-content , .modal-header , .modal-footer , .modal-body{width:100%;float:left;}
.stories{background: #eee;padding: 10px;border-radius: 5px;margin-bottom:10px;}
.stories img{border-radius: 5px;object-fit: cover;}
.stories h5{font-weight: 700 !important;}
sup{color:red;}
.form-group{width: 100%;}
.form-control{border: 1px solid #ddd !important;height: 40px;}
.workspace{width: 100%;float: left;background: #eee;padding: 20px;min-height: 900px;}
.slide-item{float: left;width: 82%;display: flex;align-content: center;justify-content: center;   background: #fff;padding: 10px;border-radius:5px;margin: 0 8%;margin-bottom:20px;}
.slide-item img{width: 250px;border-radius: 8px;height: 425px;object-fit: cover;}
.slide-item iframe{width: 250px;border-radius: 8px;height: 425px;object-fit: cover;}
.slide-item-content{width:calc(100% - 250px);padding-left: 12px;display: flex;align-content: center;  justify-content: center;flex-wrap: wrap;}
.slide-item-content h4{font-weight: 700 !important;border-bottom: 1px solid #eee;padding-bottom: 5px;   color: #646250;text-transform: uppercase;}
.slide-item-content .form-control{height: 33px;}
.image-preview{width: 200px;background: #eee;padding: 10px;float: left;margin-bottom:10px;}	
.image-preview span{width: 100%;background: #3c8dbc;color: #fff;float: left;text-align: center;padding: 6px 0px;cursor:pointer;}
p.error{color:red;}
</style>
<div class="Container">
	<div class="BodyWhiteBG">
		<div class="BodyHeadBg Overflow clear">
			<div class="FloatLeft  BreadCrumbsWrapper PollResult">
				<div class="breadcrumbs"><a href="#">Dashboard</a> > <a href="#"><?php echo $title; ?></a></div>
				<h2><?php echo $title; ?></h2>
			</div>
		</div>
		<div class="Overflow DropDownWrapper">
			<div class="container">
				<div class="row" style="margin-top:2%;">
					<div class="col-md-12 text-right">
						<button onclick="window.location.href='<?php echo base_url(folder_name);?>/webstories_master'" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Go Back</button>
						<?php if(defined("USERACCESS_ADD".$Menu_id) && constant("USERACCESS_ADD".$Menu_id) == 1){ ?>
						<button class="btn btn-primary" id="select_template"><i class="fa fa-plus-circle"></i> Select Template</button>
						<?php } ?>
						<button class="btn btn-primary" onclick="preview_story(<?php echo $creatorId;?>);"><i class="fa fa-eye"></i> Preview</button>
						<button data-type="2" class="btn btn-primary save_story"><i class="fa fa-archive"></i> Draft</button>
						<?php if(defined("USERACCESS_PUBLISH".$Menu_id) && constant("USERACCESS_PUBLISH".$Menu_id) == 1) { ?>
						<button data-type="1" class="btn btn-primary save_story"><i class="fa fa-save"></i> Publish</button>
						<?php } ?>
						<?php if(defined("USERACCESS_UNPUBLISH".$Menu_id) && constant("USERACCESS_UNPUBLISH".$Menu_id) == 1) { ?>
						<button data-type="0" class="btn btn-primary save_story" style="margin-right: 2% !important;"><i class="fa fa-bolt"></i> Unpublish</button>
						<?php } ?>
					</div>
				</div>
				<div class="row" style="margin-top:2%;">
					<div class="col-md-4" style="border-right: 2px solid #eee;">
						<div class="form-group">
							<label>Title <sup>*</sup></label>
							<input type="text" name="title" class="form-control" value="<?php if($type=='edit' && $story['title']!=''){ echo $story['title']; }?>">
						</div>
						<div class="form-group">
							<label>Section <sup>*</sup></label>
							<select name="section" class="form-control">
								<option value="">Please select any one</option>
								<?php
								$sectionList = $this->db->query("SELECT Section_id , URLSectionStructure , Sectionname FROM sectionmaster WHERE ParentSectionID IS NULL AND section_allowed_for_hosting=1 AND Status=1 AND RSSFeedAllowed=1 AND IsSeperateWebsite=0 ORDER BY DisplayOrder ASC")->result();
								foreach($sectionList as $section){
									echo '<option '.(($type=='edit' && $section->Section_id==$story['section_id'])? ' selected' :'').' style="font-weight:700;" value="'.$section->Section_id.'">'.$section->Sectionname.'</option>';
									$subsection = $this->db->query("SELECT Section_id , URLSectionStructure , Sectionname FROM sectionmaster WHERE ParentSectionID ='".$section->Section_id."' AND section_allowed_for_hosting=1 AND Status=1 AND RSSFeedAllowed=1 AND IsSeperateWebsite=0 ORDER BY DisplayOrder ASC")->result();
									foreach($subsection as $subSec){
										echo '<option '.(($type=='edit' && $subSec->Section_id==$story['section_id'])? ' selected' :'').' style="color: #7d7979;" value="'.$subSec->Section_id.'">&nbsp;&nbsp;'.$subSec->Sectionname.'</option>';
										$sub_section = $this->db->query("SELECT Section_id , URLSectionStructure , Sectionname FROM sectionmaster WHERE ParentSectionID ='".$subSec->Section_id."' AND section_allowed_for_hosting=1 AND Status=1 AND RSSFeedAllowed=1 AND IsSeperateWebsite=0 ORDER BY DisplayOrder ASC")->result();
										foreach($sub_section as $sub_Sec){
											echo '<option '.(($type=='edit' && $sub_Sec->Section_id==$story['section_id'])? ' selected' :'').' style="color: #7d7979;" value="'.$sub_Sec->Section_id.'">&nbsp;&nbsp;&nbsp;&nbsp;'.$sub_Sec->Sectionname.'</option>';
										}
									}
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Summary <sup>*</sup></label>
							<textarea name="summary" class="form-control"><?php if($type=='edit' && $story['summary']!=''){ echo $story['summary']; }?></textarea>
						</div>
						<div class="form-group">
							<?php
							if($story['poster_image']!='' && $type=='edit'){
								$imageUrl = image_url.'images/webstories/poster_image/'.$story['poster_image'];
								echo '<div  class="image-preview">';
								echo '<img src="'.$imageUrl.'">';
								echo '<span><i class="fa fa-trash"></i> Delete</span>';
								echo '</div>';
							}
							?>
							<label style="width:100%;">Poster Image <sup>*</sup> [Size : 640X853px]</label>
							<input <?php if($type=='edit' && $story['poster_image']!=''){ echo 'disabled'; }?> type="file" name="image" class="form-control" accept="image/*">
							<input type="hidden" name="poster_image" value="<?php if($type=='edit' && $story['poster_image']!=''){ echo $story['poster_image']; }?>">
						</div>
						<div class="form-group">
							<label>Author </label>
							<input type="text" name="author" class="form-control" value="<?php if($type=='edit' && $story['author']!=''){ echo $story['author']; }?>">
						</div>
						<h5 style="background: #eee;padding: 10px;" class="text-center">SEO TAGS</h5>
						<div class="padding-bottom-5" style="display:inline-block;margin-right:13px;">
							<input <?php if($type=='edit' && $story['no_index']=='1'){ echo ' selected '; }?> type="checkbox" id="cbNoIndex" name="cbNoIndex">
							<label for="cbNoIndex">No Index</label>
						</div>
						<div class="padding-bottom-5" style="display:inline-block;margin-right:13px;">
							<input <?php if($type=='edit' && $story['no_follow']=='1'){ echo ' selected '; }?> type="checkbox" id="cbNoFollows" name="cbNoFollows">
							<label for="cbNoFollows">No Follow</label>
						</div>
						<div class="form-group">
							<label>Meta Title <sup>*</sup></label>
							<input type="text" name="mtitle" class="form-control" value="<?php if($type=='edit' && $story['meta_title']!=''){ echo $story['meta_title']; }?>">
						</div>
						<div class="form-group">
							<label>Meta Description <sup>*</sup></label>
							<textarea name="msummary" class="form-control"><?php if($type=='edit' && $story['meta_description']!=''){ echo $story['meta_description']; }?></textarea>
						</div>
						<div class="form-group">
							<label>Tags (seperate by comma)</label>
							<textarea name="tags" class="form-control"><?php if($type=='edit' && $story['tags']!=''){ echo $story['tags']; }?></textarea>
						</div>
					</div>
					<div class="col-md-8">
						<div class="workspace">
						<?php
						foreach($stories as $field){
							$fields = json_decode($field['fields'] , true);
							$fields = $fields['fields'];
							echo '<div data-waid="'.$field['waid'].'" data-wtid="'.$field['wtid'].'" class="slide-item slide-'.$id.'">';
							echo '<textarea style="display:none;" id="slide_field_'.$field['waid'].'">'.$field['fields'].'</textarea>';
							echo '<iframe style="border:none;" src="'.base_url(folder_name).'/webstories_master/slide_preview/'.$field['waid'].'"></iframe>';
							echo '<div class="slide-item-content">';
							echo '<h4 class="text-center">'.$field['name'].'</h4>';
							for($i=0;$i<count($fields);$i++){
								echo '<div class="form-group inputs">';
								switch($fields[$i]['type']){
									case 'text' :
										echo '<label style="width:100%;">'.$fields[$i]['name'].' <sup>*</sup></label>';
										if($fields[$i]['name']!='Anchor Link'){
											echo '<input style="width:70%;float:left;" data-element="'.$fields[$i]['element'].'" type="text" class="form-control" value="'.$fields[$i]['value'].'">';
											echo '<input style="width:15%;float:left;" type="color" class="form-control '.((isset($fields[$i]['color']) && $fields[$i]['name']!='')? 'changed':'').'" value="'.((isset($fields[$i]['color']) && $fields[$i]['name']!='')?$fields[$i]['color']:'').'">';
											echo '<select id="'.str_replace('%','',$fields[$i]['element']).$field['waid'].'-fontsize" style="width:15%;float:left;" class="form-control">';
											echo '<option value="">Please Select</option>';
											for($n=1;$n<=100;$n++){
												echo '<option '.((isset($fields[$i]['fontSize']) && $fields[$i]['fontSize']==$n)? ' selected ':'').' value="'.$n.'">'.$n.'px</option>';	
											}
											echo '</select>';
										}else{
											echo '<input data-element="'.$fields[$i]['element'].'" type="text" class="form-control" value="'.$fields[$i]['value'].'">';	
										}
									break;
									case ($fields[$i]['type'] == 'image' || $fields[$i]['type'] == 'video') :
										$innerImagePath = image_url.'images/webstories/default/'.$fields[$i]['value'];
										if(isset($fields[$i]['imageType']) && $fields[$i]['imageType']=='files'){
											$innerImagePath = image_url.'images/webstories/files/'.$fields[$i]['value'];
										}
										echo '<label>'.$fields[$i]['name'].' <sup>*</sup></label>';
										echo '<input id="'.str_replace('%','',$fields[$i]['element']).$field['waid'].'" data-element="'.$fields[$i]['element'].'" type="file" class="form-control">';
										echo '<a target="_BLANK" href="'.$innerImagePath.'">'.$fields[$i]['value'].'</a>';
									break;
									
								}
								echo '</div>';
							}
							echo '<div class="form-group slide-satus">';
							if($field['status']==0){
								echo '<p style="color:#f50909;">Current Status : Draft</p>';
							}else{
								echo '<p style="color:green;">Current Status : Published</p>';
							}
							echo '</div>';
							echo '<div class="form-group text-center">';
							echo '<button title="Preview" class="btn btn-primary slide-preview"><i class="fa fa-eye"></i></button>';
							echo '<button data-type="1" title="Save & Draft" class="btn btn-primary slide-save"><i class="fa fa-archive"></i></button>';
							echo '<button data-type="2" title="Save & Publish" class="btn btn-primary slide-save"><i class="fa fa-save"></i></button>';
							echo '<button title="Delete" class="btn btn-primary slide-delete"><i class="fa fa-trash"></i></button>';
							echo '</div>';
							echo '</div>';
							echo '</div>';
						}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input id="workspace_id" type="hidden" value="<?php echo $creatorId;?>">
<!-- Select Template Modal -->
<div class="modal fade" id="templateModal" role="dialog">
	<div class="modal-dialog modal-lg" style="margin-top:5%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">SELECT TEMPLATE</h4>
			</div>
			<div class="modal-body text-center">
				<i class="fa fa-refresh fa-spin"></i>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- preview Template Modal -->
<div class="modal fade" id="previewModal" role="dialog">
	<div class="modal-dialog" style="margin-top:5%;"> 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">PREVIEW TEMPLATE</h4>
			</div>
			<div class="modal-body text-center">
				<i class="fa fa-refresh fa-spin"></i>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/bootstrap.min.js"></script>
<script type="text/javascript">
var slideImgPath = "<?php echo image_url;?>images/webstories/slides/";
$(document).ready(function(e){
	<?php if($type=='add'): ?>
	var addRecord = confirm("New Workspace was created. Are you sure want to continue?");
	if(addRecord != true){
		window.location.href = "<?php echo base_url(folder_name);?>/webstories_master/remove/"+$('#workspace_id').val();
	}else{
		$('input[name="title"],input[name="mtitle"]').val("Untitled");
	}
	<?php endif; ?>
	$('.save_story').on('click' , function(e){
		toastr.remove();
		$('p.error').remove();
		var error = false;
		var status = $(this).data('type');
		var slideCount = $('.slide-item').length;
		var title = $('input[name="title"]').val().trim();
		var mtitle = $('input[name="mtitle"]').val().trim();
		var summary = $('textarea[name="summary"]').val().trim();
		var msummary = $('textarea[name="msummary"]').val().trim();
		var poster_image = $('input[name="poster_image"]').val();
		var workspace_id = $('#workspace_id').val();
		var sectionId = $('select[name="section"]').val();
		if(workspace_id=='' || workspace_id==null || workspace_id==undefined){
			error = true;
			toastr.error("Something went wrong..please try again");
		}
		if(slideCount==0){
			error = true;
			toastr.error("Please add Some slides");
		}
		if(title==''){
			error = true;
			$('input[name="title"]').parent().append("<p class=\"error\">Please enter valid title.</p>");
		}
		if(title.length>90){
			error = true;
			$('input[name="title"]').parent().append("<p class=\"error\">Title should be less than 90 character.</p>");
		}
		if(mtitle==''){
			error = true;
			$('input[name="mtitle"]').parent().append("<p class=\"error\">Please enter valid meta title.</p>");
		}
		if(mtitle.length>90){
			error = true;
			$('input[name="mtitle"]').parent().append("<p class=\"error\">Meta Title should be less than 90 character.</p>");
		}
		if(summary==''){
			error = true;
			$('textarea[name="summary"]').parent().append("<p class=\"error\">Please enter valid summary.</p>");
		}
		if(summary.length>200){
			error = true;
			$('textarea[name="summary"]').parent().append("<p class=\"error\">Summary should be less than 200 character.</p>");
		}
		if(msummary==''){
			error = true;
			$('textarea[name="msummary"]').parent().append("<p class=\"error\">Please enter valid meta description.</p>");
		}
		if(msummary.length>200){
			error = true;
			$('textarea[name="msummary"]').parent().append("<p class=\"error\">Meta Description should be less than 200 character.</p>");
		}
		if(poster_image==""){
			error = true;
			$('input[name="image"]').parent().append("<p class=\"error\">Please upload valid image</p>");
		}
		if(sectionId==""){
			error = true;
			$('select[name="section"]').parent().append("<p class=\"error\">Please select valid section</p>");
		}
		if(error==false){
			var storyData = new FormData();
			storyData.append('noindex' , 0);
			storyData.append('nofollow' , 0);
			storyData.append('title' , $('input[name="title"]').val().trim());
			storyData.append('summary' , $('textarea[name="summary"]').val().trim());
			storyData.append('section' , $('select[name="section"]').val().trim());
			storyData.append('poster_image' , $('input[name="poster_image"]').val().trim());
			storyData.append('author' , $('input[name="author"]').val().trim());
			storyData.append('status' , status);
			if ($('input[name="cbNoIndex"]').is(':checked')){
				storyData.append('noindex' , 1);
			}
			if ($('input[name="cbNoFollows"]').is(':checked')){
				storyData.append('nofollow' , 1);
			}
			storyData.append('tags' , $('textarea[name="tags"]').val().trim());
			storyData.append('meta_title' , $('input[name="mtitle"]').val().trim());
			storyData.append('meta_description' , $('textarea[name="msummary"]').val().trim());
			storyData.append('workspace_id' , workspace_id);
			$.ajax({
				type : 'post',
				cache : false,
				url : '<?php echo base_url(folder_name);?>/webstories_master/update_story',
				contentType : false,
				processData : false,
				data: storyData,
				beforeSend:function(){
					toastr.warning("Please wait...");
				},
				async:false,
				success : function(result){
					toastr.remove();
					if(result==1){
						if(status==1){
							toastr.success("Webstories Published Successfully.");
						}
						if(status==0){
							toastr.warning("Webstories Unpublished Successfully.");
						}
						if(status==2){
							toastr.warning("Webstories Drafted Successfully.");
						}
					}else{
						toastr.error("Something went wrong.Please try again");
					}
				}
			});
		}
		
	});
	$('#select_template').on('click', function(e){
		var list = '';
		var result = webstories.templates();
		$(result.data).each(function(index){
			list += '<div class="col-md-3"><div class="stories">';
			list += '<img src="'+slideImgPath+result.data[index].image+'" class="img-responsive">';
			list += '<h5>'+((result.data[index].name.length > 25) ? result.data[index].name.substr(1, 22)+'...' : result.data[index].name)+'</h5>';
			list += '<button data-id="'+result.data[index].wtid+'" title="preview" class="btn btn-primary preview"><i class="fa fa-eye"></i></button>';
			list += '<button data-id="'+result.data[index].wtid+'" title="use template" class="btn btn-primary select_slide"><i class="fa fa-plus-circle"></i></button>';
			list += '</div></div>';
		});
		$('#templateModal').find('.modal-body').html(list);
		$('#templateModal').modal({backdrop: "static"});
	});
	
	$(document).on('click' , '.preview' , function(e){
		window.open('<?php echo base_url(folder_name);?>/webstories_master/preview/'+$(this).data('id'),'_blank');
	});
	$(document).on('click' , '.select_slide' , function(e){
		var slideId = $(this).data('id');
		var wsid = $('#workspace_id').val();
		toastr.remove();
		if(slideId!='' && wsid!=''){
			$.ajax({
				type : 'post',
				cache : false,
				url : '<?php echo base_url(folder_name);?>/webstories_master/set_slide',
				data : {'id' : slideId , 'wsid' : wsid}, 
				dataType : 'json',
				async: false,
				beforeSend : function(){
					toastr.warning("Please wait......");
				},
				success : function(result){
					toastr.remove();
					toastr.success("Added Successfully");
					$('.workspace').append(result.template);
					$('#templateModal').modal("toggle");
				},
				error : function(err , errmsg){
					console.log(err);
					console.log(errmsg);
				}
			});
		}else{
			toastr.error("Something went wrong..please try again");
		}
	});
	$(document).on('click' , '.slide-preview' , function(e){
		var waid = $(this).parents('.slide-item').data('waid');
		var previewTemplate = '<iframe style="width: 100%;height: 600px;border: none;border-radius: 8px;" src="<?php echo base_url(folder_name);?>/webstories_master/slide_preview/'+waid+'"></iframe>';
		$('#previewModal').find('.modal-body').html(previewTemplate);
		$('#previewModal').modal({backdrop: "static"});
	});
	$(document).on('click' , '.slide-delete' , function(e){
		toastr.remove();
		var waid = $(this).parents('.slide-item').data('waid');
		var ele = $(this).parents('.slide-item');
		var cnf = confirm("Are you sure want to delete?");
		if(cnf){
			if(waid!=''){
				$.ajax({
					type : 'post',
					cache : false,
					url : '<?php echo base_url(folder_name);?>/webstories_master/delete_slide',
					data : {'waid' : waid}, 
					async: false,
					beforeSend : function(){
						toastr.warning("Please wait......");
					},
					success : function(result){
						toastr.remove();
						if(result==1){
							ele.hide(500 , function(){ ele.remove(); });
							toastr.success("Slide removed successfully");
						}else{
							toastr.error("Something went wrong..please try again");
						}
					},
					error : function(err , errmsg){
						console.log(err);
						console.log(errmsg);
					}
				});
			}else{
				toastr.error("Something went wrong..please try again");
			}
		}
	});
	$(document).on('click' , '.slide-save' , function(e){
		var mainele = $(this).parents('.slide-item');
		var type = $(this).data('type');
		var waid = $(this).parents('.slide-item').data('waid');
		var fields = JSON.parse($('#slide_field_'+waid).val());
		console.log(fields);
		fields = fields.fields;
		var nfields = [];
		mainele.css({'opacity' : '.5' , 'pointer-events' :'none'});
		console.log(fields);
		//return false;
		$(fields).each(function(index){
			switch(fields[index].type){
				case 'image':
					var fileid = fields[index].element.replace('%','');
					fileid = fileid+ waid;
					fileid = "#"+fileid;
					var hetfileName = document.querySelector(fileid).value;
					//alert(fileid);
					//return false;
					if(hetfileName==''){
						var checkimagelink = $(fileid).next('a').attr('href');
						if(checkimagelink!=''){
							checkimagelink = checkimagelink.split('/');
							var imageDataType = checkimagelink[5];
						}else{
							var imageDataType = "default";
						}
						//alert(checkimagelink);
						nfields.push({type:fields[index].type, name:fields[index].name, value:$(fileid).next('a').text(), element:fields[index].element, imageType:imageDataType});
					}else{
						var file = document.querySelector(fileid).files[0];
						var fileData = new FormData();
						fileData.append('img', file);
						$.ajax({
							url: '<?php echo base_url(folder_name);?>/webstories_master/upload',
							type:"post",
							cache : false,
							contentType : false,
							processData : false,
							data: fileData,
							beforeSend:function(){
								toastr.warning("Please wait...");
							},
							async:false,
							success: function(result){
								toastr.success("waiting...");
								nfields.push({type:fields[index].type, name:fields[index].name, value:result, element:fields[index].element, imageType:"files"});
							}
						});
					}
				break;
				case 'video':
					var fileid = fields[index].element.replace('%','');
					fileid = fileid+ waid;
					fileid = "#"+fileid;
					var hetfileName = document.querySelector(fileid).value;
					//alert(fileid);
					//return false;
					if(hetfileName==''){
						var checkimagelink = $(fileid).next('a').attr('href');
						if(checkimagelink!=''){
							checkimagelink = checkimagelink.split('/');
							var imageDataType = checkimagelink[5];
						}else{
							var imageDataType = "default";
						}
						nfields.push({type:fields[index].type, name:fields[index].name, value:$(fileid).next('a').text(), element:fields[index].element, imageType:imageDataType});
					}else{
						var file = document.querySelector(fileid).files[0];
						var fileData = new FormData();
						fileData.append('img', file);
						$.ajax({
							url: '<?php echo base_url(folder_name);?>/webstories_master/upload',
							type:"post",
							cache : false,
							contentType : false,
							processData : false,
							data: fileData,
							beforeSend:function(){
								toastr.warning("Please wait...");
							},
							async:false,
							success: function(result){
								toastr.success("waiting...");
								nfields.push({type:fields[index].type, name:fields[index].name, value:result, element:fields[index].element, imageType:"files"});
							}
						});
					}
				break;
				case 'text' :
					var text = $(mainele).find('input[data-element="'+fields[index].element+'"]').val().trim();
					if(fields[index].name!='Anchor Link'){
						var color = "";
						var fontSize = "";
						var selectName = fields[index].element.replace('%' , '');
						selectName = '#'+selectName+waid+'-fontsize';
						if($($(mainele).find('input[data-element="'+fields[index].element+'"]')).next('input').hasClass('changed')){
							var color = $($(mainele).find('input[data-element="'+fields[index].element+'"]')).next('input').val();
						}
						if($(selectName).val()!=''){
							fontSize = $(selectName).val();
						}
						nfields.push({type:fields[index].type, name:fields[index].name, value:text, element:fields[index].element, color:color, fontSize:fontSize});
					}else{
						nfields.push({type:fields[index].type, name:fields[index].name, value:text, element:fields[index].element});
					}
					
				break;
				default:
					var text = $(mainele).find('input[data-element="'+fields[index].element+'"]').val().trim();
					if(fields[index].name!='Anchor Link'){
						var color = "";
						var fontSize = "";
						var selectName = fields[index].element.replace('%' , '');
						selectName = '#'+selectName+waid+'-fontsize';
						if($($(mainele).find('input[data-element="'+fields[index].element+'"]')).next('input').hasClass('changed')){
							var color = $($(mainele).find('input[data-element="'+fields[index].element+'"]')).next('input').val();
						}
						if($(selectName).val()!=''){
							fontSize = $(selectName).val();
						}
						nfields.push({type:fields[index].type, name:fields[index].name, value:text, element:fields[index].element, color:color, fontSize:fontSize});
					}else{
						nfields.push({type:fields[index].type, name:fields[index].name, value:text, element:fields[index].element});
					}
				break;
			}
		});
		console.log(nfields);
		if(nfields.length > 0){
			toastr.remove();
			$.ajax({
				type:'post',
				cache:false,
				data: {'field' : nfields , 'waid' : waid , 'type' : type},
				url : '<?php echo base_url(folder_name);?>/webstories_master/update_attribute',
				dataType : 'json',
				beforeSend:function(){
					toastr.warning("Please wait...");
				},
				async:false,
				success:function(result){
					toastr.remove();
					if(result.result==1){
						mainele.find('img').remove();
						mainele.find('iframe').remove();
						$("<iframe style=\"border:none;\" src='<?php echo base_url(folder_name);?>/webstories_master/slide_preview/"+waid+"'></iframe>").insertAfter(mainele.find('textarea'));
						mainele.css({'opacity' : '1' , 'pointer-events' :'auto'});
						toastr.success("Slide saved successfully");
						mainele.find('.inputs').remove();
						$(result.template).insertAfter(mainele.find('h4'));
						if(type==1){
							mainele.find('.slide-satus').html('<p style="color:#f50909;">Current Status : Draft</p>');
						}else{
							mainele.find('.slide-satus').html('<p style="color:green;">Current Status : Published</p>');
						}
					}
				},
				error : function(err , errmsg){
					console.log(err);
					console.log(errmsg);
				}
			});
		}else{
			toastr.remove("Something went wrong...please try again");
		}
	});
});
function preview_story(id){
	toastr.remove();
	if($('.slide-item').length > 0){
		window.open('<?php echo base_url(folder_name);?>/webstories_master/preview_story/'+id,'_blank');
	}else{
		toastr.warning("Workspace is empty. Please add some templates");
	}
}
var webstories = {};
webstories.templates = function(id=''){
	$.ajax({
		type : 'post',
		cache : false,
		url : '<?php echo base_url(folder_name);?>/webstories_master/templates',
		data : {'id' : id},
		dataType : 'json',
		async: false,
		success : function(result){
			template = result;
		},
		error : function(err , errmsg){
			console.log(err);
			console.log(errmsg);
		}
	});
	return template;
}
$(document).on('change' , 'input[type="color"]' , function(){
       $(this).addClass('changed');
});
$('input[name="image"]').on('change' , function(e){
	toastr.remove();
	var path = $(this).val();
	var previewImg = $(this);
	if(path!=''){
		var file = $(this)[0].files[0];
		var fileData = new FormData();
		fileData.append('img', file);
		$.ajax({
			url: '<?php echo base_url(folder_name);?>/webstories_master/upload/1',
			type:"post",
			cache : false,
			contentType : false,
			processData : false,
			data: fileData,
			beforeSend:function(){
				toastr.warning("Please wait...");
			},
			async:false,
			success: function(result){
				console.log(result);
				toastr.remove();
				toastr.success("Image Uploaded Successfully");
				$('input[name="poster_image"]').val(result);
				previewImg.prop('disabled' , true);
				var imageUrl = URL.createObjectURL(file);
				var template = "<div class='image-preview'>";
				template += "<img src='"+imageUrl+"'>";
				template += "<span><i class=\"fa fa-trash\"></i> Delete</span>";
				template += "</div>";
				$(template).insertBefore(previewImg.prev('label'));
				
			}
		});
	}else{
		toastr.error("Please upload valid poster image");	
	}
});
$(document).on('click' , '.image-preview span' , function(e){
	var imageFile = $('input[name="poster_image"]').val();
	if(imageFile!=''){
		$.ajax({
			url: '<?php echo base_url(folder_name);?>/webstories_master/remove_image',
			type:"post",
			cache : false,
			data: {'imgFile' : imageFile},
			beforeSend:function(){
				toastr.warning("Please wait...");
			},
			async:false,
			success: function(result){
				toastr.success("Image Removed Successfully");
				$('.image-preview').remove();
				$('input[name="poster_image"]').val('');
				$('input[name="image"]').val('').prop('disabled' , false);
			}
		});
	}
});
var metaTitleAction = true;
var metaSummaryAction = true;
$('input[name="title"]').on('keyup' , function(e){
	$(this).next('p.error').remove();
	var txtvalue = $(this).val();
	if(txtvalue.length > 90){
		$("<p class=\"error\">Title should be less than 150 character.</p>").insertAfter($(this));
		txtvalue = txtvalue.substr(0 ,90);
		$(this).val(txtvalue);
	}
	if(metaTitleAction){
		$('input[name="mtitle"]').val(txtvalue);
	}
});
$('textarea[name="summary"]').on('keyup' , function(e){
	$(this).next('p.error').remove();
	var txtvalue = $(this).val();
	if(txtvalue.length > 200){
		$("<p class=\"error\">Summary should be less than 200 character.</p>").insertAfter($(this));
		txtvalue = txtvalue.substr(0 ,200);
		$(this).val(txtvalue);
	}
	if(metaSummaryAction){
		$('textarea[name="msummary"]').val(txtvalue);
	}
});
$('input[name="mtitle"]').on('focus' , function(e){
	metaTitleAction = false;
});
$('textarea[name="msummary"]').on('focus' , function(e){
	metaSummaryAction = false;
});
</script>