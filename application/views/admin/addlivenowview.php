<link href="<?php echo image_url; ?>css/admin/bootstrap.min_3_3_4.css" rel="stylesheet" type="text/css">	
<link href="<?php echo image_url; ?>css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo image_url; ?>css/admin/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo image_url; ?>includes/ckeditor/contents.css" rel="stylesheet" type="text/css" id="contents_css" />
<script type="text/javascript"> var base_url = '<?php	 echo site_url(); ?>';</script>
<style>
#example_wrapper{margin-top:2%;}
/* #cke_1_contents{height: 115px !important;} */
a.cke_button{height: 17px !important;}
</style>
<div class="Container">
	<div class="BodyWhiteBG">
		<div class="BodyHeadBg Overflow clear">
			<div class="FloatLeft  BreadCrumbsWrapper PollResult" style="width: 100%;">
				<div class="breadcrumbs"><a href="#">Dashboard</a> > <a href="#">Live</a></div>
				<h2 style="text-align:center;"><?php echo strip_tags($article['title']); ?></h2>
			</div> 
		</div>
		<div class="Overflow DropDownWrapper">
			<div class="livenowContent" style="width: 70%;margin: 2% 15% 0 15%;background: #eee;padding: 2%;border: 1px solid #ddd;    border-radius: 5px;">
				<div class="form-group" style="width:100%;">
					<label>Title</label>
					<input type="text" class="form-control" id="add_title" style="border: 1px solid #ddd !important;background: #fff !important;">
				</div>
				<div class="form-group" style="width:100%;">
					<div class="WidthPercentage PositionRelative">
						<label class="WidthAuto">Content<sup style="color:red;">*</sup></label>
						<a style="top: 65px;" class="btn-primary btn FloatRight EmbedImage" href="#" data-remodal-target="modal1"  onclick="ChangePopup('bodytext')" >Embed Image</a>
					</div>
					<textarea class="ckeditor" id="body_text" name="txtBodyText"></textarea>
					<input type="hidden" id="current_image_popup" value="" />
				</div>
				<div class="form-group" style="width:100%;">
					<label>Status</label>
					<select class="form-control" id="status" style="border: 1px solid #ddd !important;background: #fff !important;">
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					</select>
				</div>
				<div class="form-group" style="width:100%;">
					<label style="margin-right: 3%;font-size: 14px;color: #686868;cursor:pointer;"><input id="pinto" style="float: left;margin-top: 3px !important;" type="checkbox">Pin to top</label>
				</div>
				<div class="form-group" style="width:100%;">
					<input type="hidden" value="<?php echo $article['content_id']; ?>" id="content_id">
					<input type="hidden" value="" id="lid">
					<button id="content_save" class="btn btn-primary">Save</button>
					<button style="display:none;" id="content_update" class="btn btn-primary">Update</button>
					<button style="display:none;" id="content_cancel" class="btn btn-primary">Cancel</button>
				</div>
			</div>
			<div id="example_wrapper">
				<table class="table" id="livetable">
					<thead>
						<tr>
							<th>LIVE ID</th>
							<th>TITLE</th>
							<th>CONTENT</th>
							<th>PIN STATUS</th>
							<th>STATUS</th>
							<th>MODIFIED BY</th>
							<th>MODIFIED ON</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($livelist as $list){
							echo '<tr>';
							echo '<td>'.$list['lid'].'</td>';
							echo '<td>'.$list['title'].'</td>';
							echo '<td>'.$list['content'].'</td>';
							echo '<td>';
							if($list['pin_status']==1){
								echo '<span style="background:green;" class="badge"><i style="color:#fff;" class="fa fa-check" aria-hidden="true"></i></span>';
							}else{
								echo '<span style="background:red;" class="badge"><i style="color:#fff;" class="fa fa-times" aria-hidden="true"></i></span>';
							}
							echo '</td>';
							echo '<td>';
							if($list['status']==1){
								echo '<span style="background:green;" class="badge">ACTIVE</span>';
							}else{
								echo '<span style="background:red;" class="badge">INACTIVE</span>';
							}
							echo '</td>';
							echo '<td>'.$list['Username'].'</td>';
							echo '<td>'.$list['modified_on'].'</td>';
							echo '<td><button onclick="edit_live('.$list['lid'].')" style="padding: 4px 7px !important;font-size: 12px;" class="btn btn-primary" ><i class="fa fa-pencil"></i></button></td>';
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	 <div class="remodal" data-remodal-id="modal1" data-remodal-options="hashTracking: false"  style="position:relative;">
            <div class="article_popup GalleryPopup ArticlePopup" style="height: 467px;">
            <div class="article_popup1">
            <ul class="article_popup_tabs">
            <li onclick="articleUpload()" class="active img_upload">From Local System</li>
            <li onclick="articleBrowse()" class="img_browse">From Library</li>
            </ul>
            </div>
            <div class="article_popup2">
            <div class="article_upload">
       
          <form  name="ImageForm" id="ImageForm" action="<?php echo base_url().folder_name; ?>/article_image/image_upload" method="POST" enctype="multipart/form-data">
              <div class="popup_addfiles">
                <div class="fileUpload btn btn-primary WidthAuto">
                    <span>+ Select Image</span>
                    <input type="file" id="imagelibrary" name="imagelibrary" accept="image/*" class="upload" style="width:100%;">
            </div>
            
             <div id="LoadingSelectImageLocal" style="display:none;"><img src="<?php echo base_url();?>images/admin/loadingimage.gif" style="border:none; width:23px; height:23px;" /><br />
			Please wait while image is being uploaded
            </div>
            
        </form>
          </div>
            <div class="GalleryDrag"  id="drop-area">
Drop files anywhere here to upload or click on the "Select Image" button above</div>
            </div>
            
                <div class="article_browse">
            <h3>Pick the item to insert</h3>
            <div class="article_browse1">
            <div class="article_browse_drop">
            <div class="w2ui-field FloatLeft">
</div>
<input type="text" placeholder="Search" id="search_caption" name="txtBrowserSearch"  class="box-shad1 FloatLeft BrowseInput" />
<i id="image_search_id" class="fa fa-search FloatLeft BrowseSearch"></i>
<a  class="btn btn-primary margin-left-10" id="clear_search" href="javascript:void(0);" style="display:none;">Clear Search</a>
            </div>
            <div class="popup_images transitions-enabled infinite-scroll clearfix"  id="image_lists_id">
            </div>
			<nav id="page-nav">
			  <a href="<?php echo base_url().folder_name; ?>/article_image/search_image_library_scroll/2"></a>
			</nav>
            </div>
            <div class="article_browse2">
            <h4>Image Details</h4>
            <img id="image_path" src="" />
            <h4 id="image_name"></h4>
            <p>Date:<span id="image_date"></span></p>
            <input type="hidden" value="" data-content_id="" data-image_alt="" data-image_caption=""  data-image_date="" data-image_source="" data-image_path="" id="browse_image_id" name="browse_image_id" />
            <div class="article_browse2_input">
            <label>Image Alt</label>
            <h5 id="textarea_alt"></h5>
            <label>Caption</label>
            <h5  id="textarea_caption"></h5>
            
            </div>
    
            </div>
            <div class="FloatRight popup_insert insert-fixed">
       <button type="button" class="btn btn-primary remodal-confirm"id="browse_image_insert"  >Insert</button>
            </div>
            </div>
			
            </div>
            </div>
            </div>
			 <div class="remodal" data-remodal-id="modal2" data-remodal-options="hashTracking: false"  style="position:relative;">
				
			 </div>

</div>
<script type="text/javascript" src="<?php echo image_url ?>js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/tabcontent.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/jquery.form.js" ></script>    
<script type="text/javascript" src="<?php echo image_url ?>js/jquery-ui.min.1.8.16.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/bootstrap/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/tags/angular.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/tags/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/tags/bootstrap-tagsinput-angular.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/tags/typeahead.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/jquery.remodal.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/modernizr.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>includes/ckeditor/ckeditor.js?top=1"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/bootstrap/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/moment-with-locales.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/menu.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/additional-methods.min.js"></script>
<script>CKEDITOR.dtd.$removeEmpty['span'] = false;</script>
<?php if(folder_name != 'niecpan')  { ?>
<script>CKEDITOR.dtd.$removeEmpty['span'] = false;</script>
<?php } ?>
<script type="text/javascript">
$('#livetable').dataTable({ 
	"bSort" : false ,
	"bPaginate": false ,
	"bInfo": false 
});
</script>
<script>
CKEDITOR.replace( 'body_text', {
  toolbar : [ 
  {items: [ 'TextColor','BGColor','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Bold','Italic','Underline','Embed','Html5audio'] },
	
  {items: ['Cut', 'Copy','Paste','PasteText','PasteFromWord','Undo','Redo','Find','Replace']},
  {items : [ 'Format']},
  {items: ['Link','Unlink','Image']},
  {items: [ 'Source','Strike','Subscript','Superscript','NumberedList','BulletedList','Outdent','Indent','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe','FontAwesome'] }
  ],  
	extraPlugins: 'autogrow,html5audio,embed,colordialog,fontAwesome,wordcount,notification', 
	contentsCss : image_url+'includes/ckeditor/plugins/fontAwesome/css/font-awesome.min.css',
	allowedContent : true,
	removePlugins : 'magicline',
	autoGrow_maxHeight : 1000,
	extraAllowedContent : 'audio(*){*}[*];img(*){*}[*];object(*){*}[*];embed(*){*}[*];param(*){*}[*];script(*){*}[*];blockquote(*){*}[*];p(*){*}[*]'
});
function ChangePopup(popup_name) {
	$("#current_image_popup").val(popup_name);
}
function articleUpload() {
	$('.article_upload').css({"display" : "block"});
	$('.article_browse').css({"display" : "none"});
	$('.img_upload').addClass('active');
	$('.img_browse').removeClass('active');
}
function articleBrowse() {
	$('.article_upload').css({"display" : "none"});
	$('.article_browse').css({"display" : "block"});
	$('.img_browse').addClass('active');
	$('.img_upload').removeClass('active');
}
function CheckImageContainer() {
if(	$("#section_image_gallery_id").val() == '' && $("#article_image_gallery_id").val() == '' && $("#home_image_gallery_id").val() == '') {
	$("#ArticleImageContainerId").hide();
} else {
	$("#ArticleImageContainerId").show();
}
	
	
}
function uploadFormData(formData) {

		$.ajax({
			url: base_url+folder_name+"/article_image/image_upload",
			type: "POST",
			data: formData,
			contentType:false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(data){
				
				if(typeof data.message !== "undefined") {
					alert(data.message);
					$("#LoadingSelectImageLocal").hide();
					return;
				}
		
				if($("#current_image_popup").val() == 'home') {
				$('#home_image_gallery_id').val(data.image_id);
				$('#home_image_gallery_id').attr('rel',data.imagecontent_id);
				$("#home_image_set").html('Change Image');
				$("#home_image_set").removeClass('BorderRadius3');
				$('#home_image_src').attr('src',data.image);
				$('#home_image_container').css("visibility", "visible");
				$("#home_image_set").next().show();
				$("#home_image_set").next().next().show();
				$("#home_uploaded_image").html('Image Set');

					
			   // $("#home_image_caption").val(data.caption);
				//$("#home_image_alt").val(data.alt_tag);
				$("#home_image_caption").val('');
				$("#home_image_alt").val('');
				
				var physical_name = data.physical_name;
				physical_name = physical_name.replace(/[^a-zA-Z0-9_-]/g,'');
				
				$("#home_physical_name").val(physical_name);
				
				$("#home_physical_name").attr('physical_extension',data.physical_extension);
				} else if($("#current_image_popup").val() == 'article')  {
				$('#article_image_gallery_id').val(data.image_id);
				$('#article_image_gallery_id').attr('rel',data.imagecontent_id);
				$('#article_image_src').attr('src',data.image);
				$('#article_image_container').css("visibility", "visible");
				$("#article_image_set").next().show();
				$("#article_image_set").next().next().show();
				$("#article_uploaded_image").html('Image Set');
				$("#article_image_set").html('Change Image');
				$("#article_image_set").removeClass('BorderRadius3');
				
				
			    //$("#article_image_caption").val(data.caption);
				//$("#article_image_alt").val(data.alt_tag);
				$("#article_image_caption").val('');
				$("#article_image_alt").val('');
				
				var physical_name = data.physical_name;
				physical_name = physical_name.replace(/[^a-zA-Z0-9_-]/g,'');
				
				$("#article_physical_name").val(physical_name);
				
				$("#article_physical_name").attr('physical_extension',data.physical_extension);
				} else  if($("#current_image_popup").val() == 'section') {
				$('#section_image_gallery_id').val(data.image_id);
				$('#section_image_gallery_id').attr('rel',data.imagecontent_id);
				$('#section_image_src').attr('src',data.image);
				$('#section_image_container').css("visibility", "visible");
				$("#section_image_set").next().show();
				$("#section_image_set").next().next().show();
				$("#section_uploaded_image").html('Image Set');
				$("#section_image_set").html('Change Image');
				$("#section_image_set").removeClass('BorderRadius3');
				
				
				//$("#section_image_caption").val(data.caption);
				//$("#section_image_alt").val(data.alt_tag);
				
				$("#section_image_caption").val('');				
			    $("#section_image_alt").val('');
				
				var physical_name = data.physical_name;
				physical_name = physical_name.replace(/[^a-zA-Z0-9_-]/g,'');
				
				$("#section_physical_name").val(physical_name);
				$("#section_physical_name").attr('physical_extension',data.physical_extension);
				} else {
					CKEDITOR.instances.body_text.insertHtml('<img src="'+data.image+'" />');
				}
				CheckImageContainer();
				
				$("#LoadingSelectImageLocal").hide();
				
				var inst = $.remodal.lookup[$('[data-remodal-id=modal1]').data('remodal')];
				if(!inst) {
					$('[data-remodal-id=modal1]').remodal().close();
				 } else{
                      inst.close();
                  }
				$("#imagelibrary").val('');
				
			}
		});
	
}

function edit_live(lid){
	toastr.remove();
	if(lid!=''){
		$.ajax({
			type:'post',
			url:'<?php echo  base_url(folder_name."/livenow/editlive"); ?>',
			data:{'lid':lid},
			dataType:'json',
			success:function(result){
				$('#add_title').val(result.title);
				CKEDITOR.instances.body_text.setData(result.content);
				if(result.pin_status==1){
					$('#pinto').prop('checked' ,true);
				}else{
					$('#pinto').prop('checked' ,false);
				}
				if(result.status==1){
					var temp = '<option value="1" selected>Active</option><option value="0">Inactive</option>';
				}else{
					var temp = '<option value="1">Active</option><option value="0" selected>Inactive</option>';
				}
				$('#status').html(temp);
				$('#lid').val(result.lid);
				$('#content_save').hide();
				$('#content_update , #content_cancel').show();
				window.scrollTo(0, 0);
			},
			error:function(code,status){
				toastr.error('Something went wrong please try again');
			}
		});
	}
}

$('#content_save').on('click' , function(e){
	toastr.remove();
	var content = $.trim($("<div/>").html(CKEDITOR.instances.body_text.getData()).html());
	var title = $('#add_title').val().trim();
	var pinto = $('#pinto').is(":checked") ? 1 : 0;
	var status = $('#status').val();
	var content_id = $('#content_id').val();
	if(content==''){
		toastr.error('Enter valid content');
	}else{
		$.ajax({
			type:'post',
			url:'<?php echo  base_url(folder_name."/livenow/save"); ?>',
			data:{'content_id':content_id,'title':title,'content':CKEDITOR.instances.body_text.getData(), 'pinto' : pinto ,'status' : status},
			success:function(result){
				if(result==1){
					$('#add_title').val('');
					CKEDITOR.instances.body_text.setData('');
					toastr.success('Content added successfully');
					location.reload();
				}
			},
			error:function(code,status){
				toastr.error('Something went wrong please try again');
			}
		});
	}
	
});

$('#content_update').on('click' , function(e){
	toastr.remove();
	var content = $.trim($("<div/>").html(CKEDITOR.instances.body_text.getData()).html());
	var title = $('#add_title').val().trim();
	var pinto = $('#pinto').is(":checked") ? 1 : 0;
	var status = $('#status').val();
	var content_id = $('#content_id').val();
	var lid = $('#lid').val();
	if(content==''){
		toastr.error('Enter valid content');
	}else{
		$.ajax({
			type:'post',
			url:'<?php echo  base_url(folder_name."/livenow/update"); ?>',
			data:{'content_id':content_id,'title':title,'content':CKEDITOR.instances.body_text.getData(), 'pinto' : pinto ,'status' : status , 'lid':lid},
			success:function(result){
				if(result==1){
					$('#add_title').val('');
					CKEDITOR.instances.body_text.setData('');
					toastr.success('Content updated successfully');
					location.reload();
				}
			},
			error:function(code,status){
				toastr.error('Something went wrong please try again');
			}
		});
	}
	
});
$('#content_cancel').on('click' , function(e){
	$('#lid').val('');
	$('#pinto').prop('checked' ,false);
	$('#status').html('<option value="1">Active</option><option value="0">Inactive</option>');
	$('#add_title').val('');
	CKEDITOR.instances.body_text.setData('');
	$('#content_save').show();
	$('#content_update , #content_cancel').hide();
});
$("#imagelibrary").change(function() {
		
		var _size = this.files[0].size;
		var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'), i=0;while(_size>900){_size/=1024;i++;}
		var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
		if(Math.round(this.files[0].size/1000) > 1024){
			toastr.warning('File Size : ' + exactSize + '. Please Compress Your Image before Upload if the file size is more than 1MB');
		}			
		var ext = $('#imagelibrary').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
			console.log('Invalid Extension!');
		} else {
			$("#LoadingSelectImageLocal").show();
			var formImage = new FormData();
			formImage.append('imagelibrary',document.getElementById("imagelibrary").files[0]);
			formImage.append('popuptype',$("#current_image_popup").val());
			
			setTimeout(function(){
			uploadFormData(formImage);
			},1000);
		}
	});
$(document.body).on('click', '#image_lists_images_id', function(event) {
		
		var ImageDetails = $(this).data();
		
			$("#textarea_alt").text(ImageDetails.image_alt);
			$("#textarea_caption").text(ImageDetails.image_caption);
			$("#image_name").html(ImageDetails.image_caption);
			$("#height_width").html(ImageDetails.image_height+" X "+ImageDetails.image_width);
			$("#image_size").html(ImageDetails.image_size+" Kb");
			$("#image_date").html(ImageDetails.image_date);
			$("#image_path").attr('src',ImageDetails.image_source);
			
			$("#browse_image_id").val(ImageDetails.content_id);
			console.log(ImageDetails.content_id);
			
			$("#browse_image_id").data("image_source",ImageDetails.image_source);
			$("#browse_image_id").data("content_id",ImageDetails.content_id);
			$("#browse_image_id").data("image_alt",ImageDetails.image_alt);
			$("#browse_image_id").data("image_caption",ImageDetails.image_caption);
			$("#browse_image_id").data("image_size",ImageDetails.image_size);
			$("#browse_image_id").data("image_date",ImageDetails.image_date);
			$("#browse_image_id").data("image_width",ImageDetails.image_width);
			$("#browse_image_id").data("image_height",ImageDetails.image_height);
			$("#browse_image_id").data("image_path",ImageDetails.image_path);
			console.log($("#browse_image_id").data());
			$("#image_lists_id img").removeClass('active');
	 		$(this).addClass('active')
			
	});
		$(document.body).on('click',"#browse_image_insert",function() {
		
		$("#LoadingSelectImageLibrary").show();
		
		var popuptype	 = $("#current_image_popup").val();
		
		if(popuptype == 'bodytext') {
			
			if($("#browse_image_id").val() != '' && $("#browse_image_id").val() != 0 ) {
			
			ImageData = "content_id="+$("#browse_image_id").val()+"&type=1";
			
					$.ajax({
						url		: base_url+folder_name+"/common/get_image_by_content_ajax",
						type	: "POST",
						data	: ImageData,
						dataType: "HTML",
						async	: false, 	
						success	: function(data) {
							
							CKEDITOR.instances.body_text.insertHtml('<img src="'+data+'" />');
							$("#LoadingSelectImageLibrary").hide(); 
						}
					});
			
				
			}
			
		} else {
		
			if($("#browse_image_id").val() != '' && $("#browse_image_id").val() != 0 ) {
			
				if($("#browse_image_id").data('image_source')) {
			
					var ImageDetails = $("#browse_image_id").data();
					
					
					ImageData = "alt="+ImageDetails.image_alt+"&caption="+ImageDetails.image_caption+"&date="+ImageDetails.image_date+"&height="+ImageDetails.image_height+"&width="+ImageDetails.image_width+"&size="+ImageDetails.image_size+"&path="+ImageDetails.image_path+"&content_id="+ImageDetails.content_id+"&popuptype="+popuptype;
			 
					$.ajax({
					url		: base_url+folder_name+"/article_image/Insert_temp_from_image_library",
					type	: "POST",
					data	: ImageData,
					dataType: "json",
					async	: false, 	
					success	: function(data) {
						
						console.log(data);
						
						if(popuptype == 'home') {
							$('#home_image_gallery_id').val(data.image_id);
							$('#home_image_gallery_id').attr('rel',data.imagecontent_id);
							$("#home_image_src").attr('src',data.source);
							$('#home_image_container').css("visibility", "visible");
							$("#home_image_set").next().show();
							$("#home_image_set").next().next().show();
							$("#home_image_set").html('Change Image');
							$("#home_uploaded_image").html('Image Set');
							$("#home_image_set").removeClass('BorderRadius3');
								
								$("#home_image_caption").val((data.caption.length > 200) ? data.caption.substr(0 ,200) : data.caption);
								
								var physical_name = data.physical_name;
								physical_name = physical_name.replace(/[^a-zA-Z0-9_-]/g,'');
								
								$("#home_physical_name").val(physical_name);
								
								$("#home_physical_name").attr('physical_extension',data.physical_extension);
								$("#home_physical_name").attr('readonly',true);
								
				$("#home_image_alt").val(data.alt);
						} else if(popuptype == 'article')  {
							$('#article_image_gallery_id').val(data.image_id);
							$('#article_image_gallery_id').attr('rel',data.imagecontent_id);
							$("#article_uploaded_image").html('Image Set');
							$("#article_image_src").attr('src',$("#image_path").attr('src'));
							$('#article_image_container').css("visibility", "visible");
							$("#article_image_set").next().show();
							$("#article_image_set").next().next().show();
							$("#article_image_set").html('Change Image');
							$("#article_image_set").removeClass('BorderRadius3');
							
								$("#article_image_caption").val((data.caption.length > 200) ? data.caption.substr(0 ,200) : data.caption);
								
								var physical_name = data.physical_name;
								physical_name = physical_name.replace(/[^a-zA-Z0-9_-]/g,'');
								
								$("#article_physical_name").val(physical_name);
								
								$("#article_physical_name").attr('physical_extension',data.physical_extension);
								$("#article_physical_name").attr('readonly',true);
								
				$("#article_image_alt").val(data.alt);
						} else { 
							$('#section_image_gallery_id').val(data.image_id);
							$('#section_image_gallery_id').attr('rel',data.imagecontent_id);
							$("#section_uploaded_image").html('Image Set');
							$("#section_image_src").attr('src',$("#image_path").attr('src'));
							$('#section_image_container').css("visibility", "visible");
							$("#section_image_set").next().show();
							$("#section_image_set").next().next().show();
							$("#section_image_set").html('Change Image');
							$("#section_image_set").removeClass('BorderRadius3');
							
								$("#section_image_caption").val((data.caption.length > 200) ? data.caption.substr(0 ,200) : data.caption);
								
								var physical_name = data.physical_name;
								physical_name = physical_name.replace(/[^a-zA-Z0-9_-]/g,'');
								
								$("#section_physical_name").val(physical_name);
								$("#section_physical_name").attr('physical_extension',data.physical_extension);
				$("#section_image_alt").val(data.alt);
				
					$("#section_physical_name").attr('readonly',true);
				
						} 
						
						CheckImageContainer();
					
						$("#LoadingSelectImageLibrary").hide(); 
						
						}
						
						
					}); 
					
				}
			
			}
		
		}
		
	});
</script>
<!-- Mansory & Infinite Scroll Script -->
<script src="<?php echo image_url ?>js/jquery-1.7.1.min.js"></script>
<script src="<?php echo image_url ?>js/jquery.masonry.min.js"></script>
<script src="<?php echo image_url ?>js/jquery.infinitescroll.min.js"></script>
<script>
var jqis = $.noConflict();
call_infinite_scroll();
function call_mansory() {
	
	var $container = jqis('.popup_images');
	
		$container.imagesLoaded(function(){
				  $container.masonry({
					itemSelector: '#image_lists_images_id',
					columnWidth: 1
				  });
				}); 
				
}

function call_infinite_scroll() {
	
	 var $container = jqis('.popup_images');
		
	 $container.infinitescroll({
      navSelector  : '#page-nav',    // selector for the paged navigation 
      nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
      itemSelector : '#image_lists_images_id',
	   binder :  $container ,
	  debug : true,
		  // selector for all items you'll retrieve
      loading: {
		  
          finishedMsg: 'No more images to load.',
          img: '<?php echo image_url ?>images/admin/loadingimage.gif',
		  msgText: "<em>Loading the next set of images...</em>"
        },
		state: { isDone:false }
      },
      // trigger Masonry as a callback
      function( newElements ) {
        // hide new items while they are loading
        var $newElems = jqis( newElements ).css({ opacity: 0 });
        // ensure that images load before adding to masonry layout
        $newElems.imagesLoaded(function(){
          // show elems now they're ready
          $newElems.animate({ opacity: 1 });
		  console.log("container add");
			$container.masonry( 'appended', $newElems, true );	
        });
      }
    );
    
}

jqis(".set_image, .EmbedImage").click(function(){
		
 var $container = jqis('.popup_images');
	
	if(jqis.trim($container.html()) == '') {
		
	$container.html('<div id="LoadingSelectImageLocal" style="display: block;"><img src="<?php echo image_url ?>images/admin/loadingimage.gif" style="border:none; width:23px; height:23px;text-align: center;float: none;margin: 0px;padding: 0px;"><br>Loading ...</div>');
	
			$.ajax({
			url: base_url+folder_name+"/article_image/get_image_library_scroll/1", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			dataType: "HTML",
			success: function(data)   // A function to be called if request succeeds
			{
				
				$container.html(data);
				setTimeout(function(){
				//call_mansory();
				},1000);
			}
		});
		
	} else {
		//console.log("test");
		//call_mansory();
	}
});
var show_clear_link =  jqis("#search_caption").val();
if(show_clear_link!=''){
jqis("#clear_search").show();
}
	jqis("#clear_search").click(function() {
		jqis("#search_caption").val('');
 var $container = jqis('.popup_images');
		 $container.empty();
	if(jqis.trim($container.html()) == '') {
		
	$container.html('<div id="LoadingSelectImageLocal" style="display: block;"><img src="<?php echo image_url ?>images/admin/loadingimage.gif" style="border:none; width:23px; height:23px;text-align: center;float: none;margin: 0px;padding: 0px;"><br>Loading ...</div>');
	
			$.ajax({
			url: base_url+folder_name+"/article_image/get_image_library_scroll/1", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			dataType: "HTML",
			success: function(data)   // A function to be called if request succeeds
			{
				
				$container.html(data);
				jqis("#clear_search").hide();
				setTimeout(function(){
				//call_mansory();
				},1000);
			}
		});
		
	} else {
		//console.log("test");
		//call_mansory();
	}
});
	/*
	function ImageExist(url) 
	{
	   var img = new Image();
	   img.src = url;
	   return img.complete;
	}
	*/
	
	function ImageExist(image_url){

		var http = new XMLHttpRequest();

		http.open('HEAD', image_url, false);
		http.send();

		return http.status != 404;

	}	
	
	function Image_Search() {
		
			 jqis("#image_lists_id").empty();
		 var $container = jqis('.popup_images');
		 $container.empty();
	if(jqis.trim($container.html()) == '') {
	$container.html('<div id="LoadingSelectImageLocal" style="display: block;"><img src="<?php echo image_url ?>images/admin/loadingimage.gif" style="border:none; width:23px; height:23px;text-align: center;float: none;margin: 0px;padding: 0px;"><br>Loading ...</div>');
		}	
			var Caption = jqis("#search_caption").val();
			
			postdata = "Caption="+Caption;
			jqis.ajax({
				url: base_url+folder_name+"/article_image/search_image_library",
				type: "POST",
				data: postdata,
				dataType: "json",
				success: function(data){
					console.log("test");
					var Content = '';
					var Count 	= 0;
					var Image_URL = "<?php echo image_url.imagelibrary_image_path;?>";
					
						jqis.each(data, function(i, item) {
							
							if(ImageExist(Image_URL+item.ImagePhysicalPath)) {
						
							var active_class = "";
							if(Count == 0) {
									
								jqis("#textarea_alt").text(item.ImageAlt);
								jqis("#textarea_caption").text(item.ImageCaption);
								jqis("#image_name").html(item.ImageCaption);
								jqis("#image_date").html(item.Modifiedon);
								jqis("#image_path").attr('src',Image_URL+item.ImagePhysicalPath);
								jqis("#browse_image_id").val(item.content_id);
								
								jqis("#browse_image_id").val(jqis(this).attr('rel'));
								
								jqis("#browse_image_id").data("image_source",Image_URL+item.ImagePhysicalPath);
								jqis("#browse_image_id").data("content_id",item.content_id);
								jqis("#browse_image_id").data("image_alt",item.ImageAlt);
								jqis("#browse_image_id").data("image_caption",item.ImageCaption);
								jqis("#browse_image_id").data("image_date",item.Modifiedon);
								jqis("#browse_image_id").data("image_path",Image_URL+item.ImagePhysicalPath);
								
								active_class = 'active';		
							}
							
							Content +='<img id="image_lists_images_id" data-content_id="'+item.content_id+'"  data-image_caption="'+item.ImageCaption+'" data-image_alt="'+item.ImageAlt+'"  data-image_date="'+item.Modifiedon+'" data-image_source="'+Image_URL+item.ImagePhysicalPath+'"  src="'+Image_URL+item.ImagePhysicalPath+'" />';
							Count++;
								
							}
							
						});
					
					if(Content != "") {
					jqis('.popup_images').html(Content);
					} else {
					jqis("#image_lists_id").html("No Data");
					}
					
					jqis('.popup_images').masonry('reload');
					jqis('.popup_images').infinitescroll('destroy'); // Destroy
					
					// Undestroy
					jqis('.popup_images').infinitescroll({ 				
						state: {                                              
								isDestroyed: false,
								isDone: false                           
						}
					});
					
					console.log("destory");	
					jqis('.popup_images').infinitescroll('bind');
					jqis('.popup_images').infinitescroll('retrieve');
			        jqis("#clear_search").show(); 
					
				}
			});
	}
	
	
	jqis("#image_search_id").click(function() {
		Image_Search();
	});
	
	jqis("#search_caption").keyup(function(e){
	    if(e.keyCode == 13){
			Image_Search();
		  }
	});

</script>
<!-- Mansory & Infinite Scroll Script -->