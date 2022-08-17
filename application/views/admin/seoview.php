<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
.FooterWrapper{position:relative !important;}
.pagination{background: transparent; border-radius: 0 0 7px 7px; box-shadow: none; padding: 0;width: initial;}
#edit-content{top: 7%;}
.form-group{width:100%;}
.form-control{border: 1px solid #ccc !important;}
.search-container{text-align: right;margin: 1% -3% 2%;}
#search_id{border-radius: inherit;width:200px;}
#search_btn{margin: 0;padding: 0.8% !important;border-radius: inherit !important;position: absolute;}
th{background: #009688; color: #fff;text-align: center;}
td{text-align:center;}
.HeaderWrapper {background: #009688;}
.btn-primary,.btn-primary:hover,.btn-primary:active,.btn-primary:focus{background-color: #009688 !important;border-color: #009688 !important;}
.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover{ background-color: #009688;border-color: #009688;}
.pagination li a{color:#009688;}
.FooterWrapper a {color: #009688;}
menu-list li ul a, .menu-list li ul a:hover { background: #009688;border-bottom: 1px solid #009688;}
.main-top ul li:hover { background: #fff;color: #009688;}
.menu-list li ul a{background: #009688;border-bottom: 1px solid #fff;}
.menu-list li ul a:hover{background: #fff;border-bottom: 1px solid #009688;color:#009688 !important;}
.menu-list a:hover{ background: #009688;}
.header-title{width: 41%;float: left;margin: 0;text-transform: uppercase;font-weight: bold !important;}
.mainmenu{float:left; margin-left: 4%;}
</style>
<div class="container ajax-loded" style="margin-top:5%;">
	<div class="row">
		<div class="col-md-12 search-container">
			<a class="btn btn-primary mainmenu" href="<?php print HOMEURL.folder_name?>/seo"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>  Go To Mainmenu</a>
			<h2 class="header-title"><?php print $title ;?></h2>
			<input type="text" id="search_id" placeholder="Enter the Content Id">
			<button class="btn btn-primary" id="search_btn"><i class="fa fa-search" aria-hidden="true"></i></button>
		</div>
	</div>
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>Content ID</th>
        <th>Title</th>
        <th>Created On</th>
        <th>Action</th>
        <th>Preview</th>
      </tr>
    </thead>
    <tbody>
     <?php
		foreach($data as $datavalue){
			print '<tr>';
			print '<td>'.$datavalue->content_id.'</td>';
			print '<td class="title-'.$datavalue->content_id.'">'.$datavalue->title.'</td>';
			print '<td class="title-'.$datavalue->content_id.'">'.$datavalue->Createdon.'</td>';
			print '<td><button class="btn btn-primary" onclick="get_content('.$datavalue->content_id.')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>';
			print '<td><a href="'.HOMEURL.$datavalue->url.'?page=preview" target="_blank" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
			print '</tr>';
		
		}
	 ?>
    </tbody>
  </table>
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
			<?php print $pagination; ?>
		</div>
		</div>
	</div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="edit-content" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title article-title text-center" style="font-weight:bold !important;font-weight:24px;">Modal Header</h4>
        </div>
        <div class="modal-body article-content">
         <p>edit content</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <input type="hidden" value="<?php print $title ?>" id="content_type">
  <script>
	function get_content(content_id){
		var title=$('.title-'+content_id).find('p').html();
		var type=$('#content_type').val();
		$('.article-title').html(title);
		toastr.info('loading please wait... ');
		$.ajax({
			type:'post',
			url:'<?php print HOMEURL.folder_name ?>/seo/EditDetails',
			data:{'content_id':content_id,'type':type},
			cache:false,
			success:function(result){
				$('.article-content').html(result);
				$("#edit-content").modal({backdrop: false});
				//alert(result);
			}
		});
		
	}
	
	function addtags(){
		var count=$('#tag_count').val();
		var newcount=parseInt(count) + 1;
		$('.tag_body_'+count).after('<div class="tag_body_'+newcount+'" style="width:100%;margin-bottom:10px"><input type="text" name="tag" id="tag_'+newcount+'" class="form-control" value=""></div>');
		$('#tag_count').val(newcount);
	}
	function removetags(){
		var count=$('#tag_count').val();
		var newcount=parseInt(count) - 1;
		if(newcount!=0){
			$('.tag_body_'+count).remove();
			$('#tag_count').val(newcount);
		}else{
			//toastr["success"]["You have removed Maximum Tags"];
			toastr.error('You have removed Maximum Tags');
		}
		
	}
	
	function saveContent(content_id){
		toastr.info('loading please wait... ');
		var metatitle=$('#metatitle').val();
		var metadescription=$('#metadescription').val();
		var count=$('#tag_count').val();
		var type=$('#content_type').val();
		var tags=[];
		for(var i=1;i<=count;i++){
			tags.push($('#tag_'+i).val());
		}
		$.ajax({
			type:'post',
			url:'<?php print HOMEURL.folder_name ?>/seo/SaveDetails',
			data:{'metatitle':metatitle,'metadescription':metadescription,'tags':tags,'content_id':content_id,'type':type}, 
			cache:false,
			success:function(result){
				if(result==1){
					toastr.success('Article Updates Successfully');
					$("#edit-content").modal('hide');
				}
			}
		});
	
	}
	$(document).ready(function(){
		$('#search_btn').on('click',function(){
			
			var content_id=$('#search_id').val();
			var type=$('#content_type').val();
			if(content_id.trim()=='' || jQuery.isNumeric(content_id.trim())==false){
				toastr.error('Enter a valid content id');
			}else{
				toastr.info('loading please wait... ');
				$.ajax({
					type:'post',
					url:'<?php print HOMEURL.folder_name ?>/seo/SearchDetails',
					data:{'content_id':content_id,'type':type},
					cache:false,
					success:function(result){
						$('.article-title').html(content_id);
						$('.article-content').html(result);
						$("#edit-content").modal({backdrop: false});
						$('#search_id').val('');
					}
				});
			}
		});
	
	});

  </script>