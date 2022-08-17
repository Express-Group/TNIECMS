
var articleTitle = metaTitle = metaDescription = false;
$('input[name="url"]').keypress(function(){
	articleTitle = true;
});
$('input[name="meta_title"]').keypress(function(){
	metaTitle = true;
});
$('input[name="meta_description"]').keypress(function(){
	metaDescription = true;
});
CKEDITOR.replace('article_title', {
	toolbar : [ { name: 'basicstyles', items: [ ] } ],
	height:60,
	forcePasteAsPlainText :true,
});
CKEDITOR.instances.article_title.on('contentDom', function(){
	CKEDITOR.instances.article_title.document.on('keyup', function(event){
		var decoded_headline = metatext =  $.trim($("<div/>").html(CKEDITOR.instances.article_title.getData()).text());
		decoded_headline = decoded_headline.substring(0,100);
		decoded_headline = decoded_headline.replace(/[^a-zA-Z0-9 ]/g, "");
		if(!articleTitle){
			$('input[name="url"]').val(decoded_headline);
		}
		if(!metaTitle){
			$('input[name="meta_title"]').val(metatext);
		}
	});
});
CKEDITOR.replace('article_summary', {
	height: 100,
	toolbar : [{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'TextColor' ] } ]
});
CKEDITOR.instances.article_summary.on('contentDom', function(){
	CKEDITOR.instances.article_summary.document.on('keyup', function(event){
		var metadesc =  $.trim($("<div/>").html(CKEDITOR.instances.article_summary.getData()).text());
		if(!metaDescription){
			$('input[name="meta_description"]').val(metadesc);
		}
	});
});
CKEDITOR.replace( 'article_content', {
  toolbar : [ 
  {items: [ 'TextColor','BGColor','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Bold','Italic','Underline','Embed','Html5audio'] },
	
  {items: ['Cut', 'Copy','Paste','PasteText','PasteFromWord','Undo','Redo','Find','Replace']},
  {items : [ 'Format']},
  {items: ['Link','Unlink','Image']},
  {items: [ 'Source','Strike','Subscript','Superscript','NumberedList','BulletedList','Outdent','Indent','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe','Ckeditorfa'] }
  ],  
	extraPlugins: 'autogrow,html5audio,embed,colordialog,ckeditorfa,wordcount,notification', 
	contentsCss :  BASEURL+'assets/ckeditor/plugins/ckeditorfa/css/ckeditorfa.css',
	allowedContent : true,
	removePlugins : 'magicline',
	autoGrow_maxHeight :250,
	height: 250,
	extraAllowedContent : 'audio(*){*}[*];img(*){*}[*];object(*){*}[*];embed(*){*}[*];param(*){*}[*];script(*){*}[*];blockquote(*){*}[*];p(*){*}[*]',
	embed_provider : '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}'
});
CKEDITOR.instances.article_content.on('contentDom', function(){
	CKEDITOR.instances.article_content.document.on('keyup', function(event){
		$('.layout-wrapper .content-wrapper .content-body .content').niceScroll();	
	});
});
$("input[name='tags']").tagsinput('items');
$("select[name='parent_section']").on('change' , function(e){
	var id = $(this).val();
	if(id!=''){
		$('.multi-map').each(function(index){
				$(this).attr('disabled', false);
			if($(this).val()==id){
				$(this).prop('checked', false);
				$(this).attr('disabled', true);
			}
		});
		$('.product-container').html('');
	}else{
		$('.multi-map').attr('disabled', false);
	}
});
$('#article_img').on('click' , function(e){
	$('#image_modal_status').val(0);
	imager(1 ,$('input[name="image_search"]').val() ,0);
	$('.img-select').css('opacity' ,'1');
	$('#select_image').hide();
	$('#embed_select_image').hide();
	$('.img-preview').html('<h5>PREVIEW</h5><hr>');
});
$('#embed_image').on('click' ,function(e){
	$('#image_modal_status').val(1);
	imager(1 ,$('input[name="image_search"]').val() ,0);
	$('.img-select').css('opacity' ,'1');
	$('#select_image').hide();
	$('#embed_select_image').show();
	$('.img-preview').html('<h5>PREVIEW</h5><hr>');
});
$('#embed_select_image').on('click' , function(e){
	var image = $('.img-preview').find('img');
	var src = $(image).attr('src');
	var id = $(image).data('id');
	var alt = $(image).data('alt');
	var caption = $(image).data('caption');
	var name = $(image).data('name');
	CKEDITOR.instances.article_content.insertHtml('<img title="'+caption+'" alt="'+alt+'" src="'+src+'" />');
	$("#article_image_upload").modal("toggle");
	$('.layout-wrapper .content-wrapper .content-body .content').niceScroll();
});
$(document).on('click' , '.image-pager' , function(e){
	 e.preventDefault();
	 var href = $(this).attr('href');
	 if(href!=undefined && href!=''){
		 href = href.split('=');
		 imager(2 ,$('input[name="image_search"]').val() ,href[1]);
	 }
	 
});
$('#image_search1').on('click' , function(e){
	imager(2 ,$('input[name="image_search"]').val() ,0);
});
$(document).on('click' , '.img-select' , function(e){
	var type= $('#image_modal_status').val();
	$('.img-select').css('opacity' ,'1');
	var imgSource = $(this).attr('src');
	imgSource = imgSource.replace('medium/' , 'original/');
	var template = '<h5>PREVIEW</h5><hr><img style="width:100%;" class="img-responsive" src="'+imgSource+'" data-id="'+$(this).attr('image-id')+'" data-alt="'+$(this).attr('image-alt')+'" data-caption="'+$(this).attr('image-caption')+'" data-name="'+$(this).attr('image-name')+'">';
	template += '<hr><p>Image Name : '+$(this).attr('image-name')+'</p>';
	template += '<p>Caption : '+$(this).attr('image-caption')+'</p>';
	template += '<p>Image Alt : '+$(this).attr('image-alt')+'</p>';
	$('.img-preview').html(template);
	$(this).css('opacity' ,'.3');
	$('#select_image').hide();
	$('#embed_select_image').hide();
	(type=='0') ? $('#select_image').show() : $('#embed_select_image').show();
});
$('#select_image').on('click' , function(){
	var image = $('.img-preview').find('img');
	var src = $(image).attr('src');
	var id = $(image).data('id');
	var alt = $(image).data('alt');
	var caption = $(image).data('caption');
	var name = $(image).data('name');
	$.ajax({
		type:'post',
		url:BASEURL+ADMINFOLDER+"image_library/set_temp",
		cache:false,
		data:{'image_id' : id},
		dataType:'json',
		success:function(result){
			if(result.status==1){
				$('.image-block').html('<img src="'+result.path+'">');
				$('input[name="image_caption"]').val(caption);
				$('input[name="image_alt"]').val(alt);
				$('input[name="image_name"]').val(name);
				$('input[name="image_id"]').val(result.temp_id);
				$('.image-block-container').show();
				$('.image-block-btn').hide();
				$("#article_image_upload").modal("toggle");
				 $('.layout-wrapper .content-wrapper .content-body .content').niceScroll();
			}else{
				toastr.error('something went wrong.please try again');
			}
			
		},
		error:function(err , errcode){
			console.log(err);
			console.log(errcode);
		}
	});
	
});
$('#remove_image').on('click' , function(e){
	var akw = confirm('Are you sure want to delete the image?');
	if(akw){
		var id =$('input[name="image_id"]').val();
		if(id!=''){
			$.ajax({
				type:'post',
				cache:false,
				url:BASEURL+ADMINFOLDER+"image_library/remove_temp",
				data:{'temp_id' : id},
				success:function(result){
					if(result==1){
						$('.image-block').html('');
						$('input[name="image_caption"]').val('');
						$('input[name="image_alt"]').val('');
						$('input[name="image_name"]').val('');
						$('input[name="image_id"]').val('');
						$('.image-block-container').hide();
						$('.image-block-btn').show();
						toastr.success('Image deleted Successfully');
					}
				},
				error:function(err , errcode){
					console.log(err);
					console.log(errcode);
				}
			})
		}else{
			toastr.error('something went wrong.please try again');
		}
	}
});
$('#article_save').on('click' , function(e){
	var status = validate_article();
	if(!status){
		$('#create_article').submit();
	}
});
$('input[name="article_single_img"]').on('change' , function(e){
	toastr.remove();
	var error =false;
	var filename = $(this).val();
	var ext = filename.split('.').pop().toLowerCase();
	var extlist = ["jpg", "jpeg", "png"];
	if(extlist.indexOf(ext)=='-1'){
		error =true;
		toastr.error('Supports only jpg|jpeg|png');
	}
	if(Math.round(this.files[0].size/1000) > 2048){
		error =true;
		toastr.error('Please Compress Your Image before Upload if the file size is more than 2MB');
	}
	if(!error){
		$('#article_single_image').submit();
	}

});
$("#article_single_image").on('submit', function(e){
	e.preventDefault();
	 $.ajax({
        url: BASEURL+ADMINFOLDER+"image_library/upload_single",
		type: "post",
		data:  new FormData(this),
		contentType: false,
        cache: false,
		processData:false,
		dataType:'json',
		beforeSend:function(){
			toastr.success('Please Wait...');
		},
		success:function(result){
			if(result.id!=null){
				$('.img-select').css('opacity' ,'1');
				var type = $('#image_modal_status').val();
				var imgSource = result.fullimage.replace('medium/' , 'original/');
				var template = '<h5>PREVIEW</h5><hr><img style="width:100%;" class="img-responsive" src="'+imgSource+'" data-id="'+result.id+'" data-alt="'+result.alt+'" data-caption="'+result.caption+'" data-name="'+result.image_name+'">';
				template += '<hr><p>Image Name : '+result.image_name+'</p>';
				template += '<p>Caption : '+result.caption+'</p>';
				template += '<p>Image Alt : '+result.alt+'</p>';
				$('.img-preview').html(template);
				$(this).css('opacity' ,'.3');
				(type=='0')? $('#select_image').show().click() : $('#embed_select_image').show().click();
				$('input[name="article_single_img"]').val('')
			}else{
				toastr.error('Something went wrong.please try again');
			}
			
		},
		error:function(err , errcode){
			console.log(err);
			console.log(errcode);
		}
	 });
});

$('#edit_url').on('click' , function(e){
	toastr.remove();
	toastr.success('Changing url will remove the existing url...');
	$('input[name="url"]').prop('disabled' , false);
});

$('#add_products').on('click' , function(e){
	toastr.remove();
	var section = $('select[name="parent_section"]').val();
	if(section!=''){
		productDetails(1 , section);
	}else{
		toastr.error('Please select valid section name');
	}
	
});
$(document).on('click' , '.delete_product',function(e){
	toastr.remove();
	$(this).parent('.product').remove();
	toastr.success('product removed successfully');
});
$('#product_search').on('click' ,function(e){
	toastr.remove();
	var section = $('select[name="parent_section"]').val();
	if(section!=''){
		productDetails(0 , section);
	}else{
		toastr.error('Please select valid section name');
	}
});

function productDetails(type=0 , section){
	var ids = [];
	$('.product-container').find('.product').each(function(e){
		ids.push($(this).data('pid'));
	});
	ids =ids.join(',');
	var query = $('#product_query').val().trim();
	$.ajax({
		type:'post',
		url :BASEURL+ADMINFOLDER+"content/article/get_product", 
		data:{'query' : query , 'section' : section , 'id' : ids},
		success:function(result){
			$('.product-table').html(result);
			if(type==1){
				$("#product_modal").modal({backdrop: "static"});
			}
		},
		error:function(err , errcode){
			console.log(err);
			console.log(errcode);
		}
	});
}

function addproduct(id){
	toastr.remove();
	if(id!=''){
		var title = $('.product-'+id).data('title');
		var image = $('.product-'+id).data('imagepath');
		var template = '<div data-pid="'+id+'" class="product">';
		template += '<h6 class="text-center bg-secondary">'+title+'</h6>';
		if(image!=''){
			template += '<img src="'+image+'">';
		}
		template += '<input type="hidden" name="product_id[]" value="'+id+'">';
		template += '<input type="text" name="product_title[]" value="" placeholder="Enter Title" class="form-control">';
		template += '<button type="button" class="btn btn-primary pull-right delete_product">Delete</button>';
		template += '</div>';
		$('.product-'+id).remove();
		$('.product-container').append(template);
		toastr.success('Product Added successfully');
		$('.layout-wrapper .content-wrapper .content-body .content').getNiceScroll().remove();
	}else{
		toastr.error('Something went wrong..please try again');
	}
}

function imager($type=1 , caption , page){
	$.ajax({
		type:'post',
		url :BASEURL+ADMINFOLDER+"content/article/get_image", 
		data:{'caption' : caption , 'page' : page},
		success:function(result){
			$('.img-container').find('.img-list').html(result);
			if($type==1){
				$("#article_image_upload").modal({backdrop: "static"});
			}
		},
		error:function(err , errcode){
			console.log(err);
			console.log(errcode);
		}
	});
}


function validate_article(){
	toastr.remove();
	var error = false;
	var articleTitle = $.trim($("<div/>").html(CKEDITOR.instances.article_title.getData()).text());
	var articleSummary = $.trim($("<div/>").html(CKEDITOR.instances.article_summary.getData()).text());
	var articleContent = $.trim($("<div/>").html(CKEDITOR.instances.article_content.getData()).text());
	var url = $('input[name="url"]').val().trim();
	var main_section = $('select[name="parent_section"]').val();
	var image = $('.image-block').find('img').attr('src');
	var image_caption = $('input[name="image_caption"]').val().trim();
	var image_alt = $('input[name="image_alt"]').val().trim();
	var image_name = $('input[name="image_name"]').val().trim();
	var meta_title = $('input[name="meta_title"]').val().trim();
	var meta_description = $('input[name="meta_description"]').val().trim();
	$('.error').remove();
	if(articleTitle==''){
		error = true;
		$('.headline').append('<p class="error">Enter valid article title</p>');
		toastr.error('Enter valid article title');
	}
	if(url==''){
		error = true;
		$('input[name="url"]').parent('.form-group').append('<p class="error">Enter valid url</p>');
		toastr.error('Enter valid url');
	}
	if(main_section==''){
		error = true;
		$('select[name="parent_section"]').parent('.form-group').append('<p class="error">Select valid section</p>');
		toastr.error('Select valid section');
	}
	if(articleSummary==''){
		error = true;
		$('.summary').append('<p class="error">Enter valid article summary</p>');
		toastr.error('Enter valid article summary');
	}
	if(articleContent==''){
		error = true;
		$('.article-content').append('<p class="error">Enter valid article content</p>');
		toastr.error('Enter valid article content');
	}
	if(image!=undefined){
		if(image_caption==''){
			error = true;
			toastr.error('Enter valid image caption');
		}
		if(image_alt==''){
			error = true;
			toastr.error('Enter valid image alt');
		}
		if(image_name==''){
			error = true;
			toastr.error('Enter valid image name');
		}
		/* if(image_name!=''){
			$.ajax({
				type:'post',
				cache:false,
				url: BASEURL+ADMINFOLDER+'image_library/check_imagename',
				data:{'image_name' : image_name},
				success:function(result){
					if(result==0){
						error = true;
						toastr.error('Image Name already exists!');
					}
				},
				error:function(err ,errcode){
					console.log(err);
					console.log(errcode);	
				}
			})
		} */
	}
	if(meta_title==''){
		error = true;
		toastr.error('Enter valid meta title');
		$('input[name="meta_title"]').parent('.input-group').append('<p style="width:100%;" class="error">Enter valid meta title</p>');
	}
	if(meta_title!=''){
		if(meta_title.length >100){
			error = true;
			toastr.error('Meta title should be less than 100 character');
			$('input[name="meta_title"]').parent('.input-group').append('<p style="width:100%;" class="error">Meta title should be less than 100 character</p>');
		}
	}
	if(meta_description==''){
		error = true;
		toastr.error('Enter valid meta description');
		$('input[name="meta_description"]').parent('.input-group').append('<p style="width:100%;" class="error">Enter valid meta description</p>');
	}
	if(meta_description!=''){
		if(meta_description.length >100){
			error = true;
			toastr.error('Meta description should be less than 200 character');
			$('input[name="meta_description"]').parent('.input-group').append('<p style="width:100%;" class="error">Meta description should be less than 200 character</p>');
		}
	}
	return error;
	
}