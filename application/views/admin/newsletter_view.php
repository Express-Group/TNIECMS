<link href="<?php echo image_url ?>css/admin/bootstrap.min_3_3_4.css" rel="stylesheet" type="text/css">
<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
<style>
.btn-custom , .btn-custom:hover ,.btn-custom:active,.btn-custom:focus{border-radius: 0 !important;box-shadow: 0px 1px 3px #00000069;background-color: #557086 !important;border-color: #557086 !important;}
.modal.in .modal-dialog{z-index: 999999;top:13%;}
.modal-content{border-radius:0;}
.modal-body input , .modal-body textarea , .modal-body select ,.ls{border: 1px solid #ddd !important;}
.form-group{width:100%;display:flex;}
.form-group .col-md-6{clear:both;}
.table th{background:#557086;color:#fff;text-align:center;}
.ls{width:180px;display:inline;}
.BodyHeadBg ,.Container{width:90%;}
</style>
<div class="Container">
	<div class="BodyWhiteBG">
		<div class="BodyHeadBg Overflow clear">
			<div class="FloatLeft  BreadCrumbsWrapper PollResult">
				<div class="breadcrumbs"><a href="#">Dashboard</a> > <a href="#">Create Newsletter </a></div>
				<h2>Create Newsletter</h2>
			</div>
		</div>
		<div class="Overflow DropDownWrapper">
			<h5 class="text-center">
				<select class="form-control ls" id="content_type">
					<option value="1" <?php if($this->input->get('type')=='1' || $this->input->get('type')==''){ echo 'selected'; } ?>>article</option>
					<option value="2" <?php if($this->input->get('type')=='2'){ echo 'selected'; } ?> >gallery</option>
					<option value="3" <?php if($this->input->get('type')=='3'){ echo 'selected'; } ?> >video</option>
				</select>
				<input type="text" id="search_text" class="form-control ls" placeholder="Enter content ID/title" value="<?php echo $this->input->get('query'); ?>">
				<button class="btn btn-primary btn-custom" id="search">Search</button>
				<button class="btn btn-primary btn-custom" id="clear_search">Clear Search</button>
				<button class="btn btn-primary btn-custom" onclick="preview(event)"><i class="fa fa-eye" aria-hidden="true"></i> Preview</button>
				<button class="btn btn-primary btn-custom" onclick="download(event)"><i class="fa fa-download" aria-hidden="true"></i> Download</button>
				
			</h5>
			<div class="row" style="margin-top:3%;">
				<div class="col-md-6">
					<table class="table table-bordered">
						<thead>
							<tr><th colspan="3" style="text-align:center;">SELECT ARTICLE 
							<?php if($this->input->get('type')=='1' || $this->input->get('type')==''){ echo ' (ARTICLE)'; } ?>
							<?php if($this->input->get('type')=='2'){ echo ' (GALLERY)'; } ?>
							<?php if($this->input->get('type')=='3'){ echo ' (VIDEO)'; } ?>
							</th></tr>
							<tr>
								<th>Content Id</th>
								<th>Title</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach($articles as $article):
								echo '<tr>';
								echo '<td>'.$article->content_id.'</td>';
								echo '<td>'.strip_tags($article->title).'</td>';
								echo '<td><button class="btn btn-primary btn-custom" onclick="add_article('.$article->content_id.')"><i class="fa fa-plus" aria-hidden="true"></i></button></td>';
								echo '</tr>';
							endforeach;
							if(count($articles)==0){
								echo '<tr><td class="text-center" colspan="3">No records found</td></tr>';
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="col-md-6">
					<table class="table table-bordered">
						<thead>
							<tr><th colspan="4" style="text-align:center;">SELECTED ARTICLE (LIMIT - 5)</th></tr>
							<tr>
								<th>Content Type</th>
								<th>Content Id</th>
								<th>Title</th>
								<th style="width: 16%;">Action</th>
							</tr>
						</thead>
						<tbody id="load_table">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="article_modal" role="dialog">
    <div class="modal-dialog">    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center" style="text-transform:uppercase;">Create Article</h4>
        </div>
        <div class="modal-body">
          <div class="form-group" style="display:block;">
			<label style="width:100%;font-weight:bold !important;">Custom title</label>
			<input id="ctitle" type="text" class="form-control">
			<input type="hidden" id="cid" value="">
			<input type="hidden" id="ctype" value="">
		  </div>
		  <div class="form-group" style="display:block;">
			<label style="width:100%;font-weight:bold !important;">Custom Summary</label>
			<textarea id="csummary" class="form-control"></textarea>
		  </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-custom" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-custom" onclick="publish_article()">Save</button>
        </div>
      </div>
    </div>
 </div>
 <!--End-->
 
 <!-- Modal -->
<div class="modal fade" id="edit_article_modal" role="dialog">
    <div class="modal-dialog">    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center" style="text-transform:uppercase;">Edit Article</h4>
        </div>
        <div class="modal-body">
          <div class="form-group" style="display:block;">
			<label style="width:100%;font-weight:bold !important;">Custom title</label>
			<input id="etitle" type="text" class="form-control">
			<input type="hidden" id="enid" value="">
			<input type="hidden" id="etype" value="">
			<input type="hidden" id="ecid" value="">
		  </div>
		  <div class="form-group" style="display:block;">
			<label style="width:100%;font-weight:bold !important;">Custom Summary</label>
			<textarea id="esummary" class="form-control"></textarea>
		  </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-custom" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-custom" onclick="edit_publish_article()">Update</button>
        </div>
      </div>
    </div>
 </div>
 <!--End-->

<script type="text/javascript" src="<?php echo image_url ?>js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/bootstrap/bootstrap.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$('#clear_search').on('click',function(e){
	window.location.href="<?php echo base_url().folder_name ?>/newsletter";
});
$('#search').on('click',function(e){
	var query =$('#search_text').val();
	if(query!=''){
		window.location.href="<?php echo base_url().folder_name ?>/newsletter?type=<?php echo $this->input->get('type') ?>&query="+query;
	}else{
		toastr.error('Enter valid content ID / title');
	}
	
});
$('#search_text').on('keyup',function(e){
	if(e.which===13){
		$('#search').click();
	}
});

$('#content_type').on('change',function(e){
	window.location.href="<?php echo base_url().folder_name ?>/newsletter?type="+$(this).val();
});
function add_article(id){
	var type = $('#content_type').val();
	$.ajax({
		type:'post',
		cache:false,
		data:{'id' : id ,'content_type' : type},
		url:'<?php echo base_url().folder_name ?>/newsletter/article_details',
		dataType:'json',
		success:function(result){
			if(result.response==1){
				$('#ctitle').val(result.title);
				$('#csummary').val(result.summary);
				$('#cid').val(id);
				$('#ctype').val(type);
				$('#article_modal').modal({backdrop: 'static', keyboard: false});
			}else{
				toastr.error('something went wrong..please try again');
			}
		},
		error:function(err){
			
		}
		
	});
	
	
}

function publish_article(){
	var title = $('#ctitle').val();
	var summary = $('#csummary').val();
	var id = $('#cid').val();
	var type = $('#ctype').val();
	$.ajax({
		type:'post',
		cache:false,
		data:{'id' : id ,'content_type' : type , 'title' : title , 'summary' : summary},
		url:'<?php echo base_url().folder_name ?>/newsletter/add_article',
		success:function(result){
			if(result==2){
				toastr.error('Already added');
			}else if(result==3){
				toastr.error('Limit exceed');
			}else if(result==1){
				toastr.success('Added successfully');
				$('#article_modal').modal('toggle');
			}else{
				toastr.error('something went wrong..please try again');
			}
			loadtable();
		},
		error:function(err,errcode){
			
		}
	});
}

function loadtable(){
	$.ajax({
		type:'post',
		cache:false,
		url:'<?php echo base_url().folder_name ?>/newsletter/load_table',
		success:function(result){
			$('#load_table').html(result);
		},
		error:function(err,errcode){
			
		}
	});
}

function remove_article(nid){
	var cnf = confirm('Are you sure want to delete?');
	if(cnf){
		$.ajax({
			type:'post',
			cache:false,
			data:{'nid':nid},
			url:'<?php echo base_url().folder_name ?>/newsletter/remove_article',
			success:function(result){
				if(result==1){
					toastr.success('deleted successfully');
				}else{
					toastr.error('something went wrong..please try again');
				}
				loadtable();
			},
			error:function(err,errcode){
				
			}
		});
	}
}

function preview(e){
	loadtable();
	var count = $('#load_table').find('tr').length;
	if(count==5){
		window.open('<?php echo base_url().folder_name ?>/newsletter/preview','_blank');
	}else{
		toastr.warning('select minimum 5 articles');
	}
}

function download(){
	loadtable();
	var count = $('#load_table').find('tr').length;
	if(count==5){
		window.location.href='<?php echo base_url().folder_name ?>/newsletter/preview/1';
	}else{
		toastr.warning('select minimum 5 articles');
	}
}

function edit_article(nid){
	$.ajax({
		type:'post',
		data:{'nid' : nid},
		cache:false,
		url:'<?php echo base_url().folder_name ?>/newsletter/edit_article',
		dataType:'json',
		success:function(result){
			if(result.response==1){
				$('#etitle').val(result.title);
				$('#esummary').val(result.summary);
				$('#enid').val(nid);
				$('#etype').val(result.type);
				$('#ecid').val(result.content_id);
				$('#edit_article_modal').modal({backdrop: 'static', keyboard: false});
			}else{
				toastr.error('something went wrong..please try again');
			}
		},
		error:function(err){
			
		}
		
	})
}

function edit_publish_article(){
	var nid = $('#enid').val();
	var title = $('#etitle').val();
	var summary = $('#esummary').val();
	var type = $('#etype').val();
	var cid = $('#ecid').val();
	$.ajax({
		type:'post',
		cache:false,
		data:{'nid':nid,'title':title , 'summary' : summary ,'type':type ,'cid' : cid},
		url:'<?php echo base_url().folder_name ?>/newsletter/edit_publish_article',
		success:function(result){
			if(result==1){
				$('#edit_article_modal').modal('toggle');
				toastr.success('updated successfully');
			}else{
				toastr.error('something went wrong..please try again');
			}
			loadtable();
		},
		error:function(err){
			
		}
	});
}
loadtable();
</script>