CKEDITOR.replace('product_title', {
	toolbar : [ { name: 'basicstyles', items: [ ] } ],
	height:60,
	forcePasteAsPlainText :true,
});
CKEDITOR.replace('product_short_title', {
	toolbar : [ { name: 'basicstyles', items: [ ] } ],
	height:60,
	forcePasteAsPlainText :true,
});
CKEDITOR.replace('product_summary', {
	height: 100,
	toolbar : [{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'TextColor' ] } ]
});

$('#product_img').on('click' , function(e){
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

$('button[name="add_merchant"]').on('click' , function(e){
	var index = parseInt($('input[name="merchant_count"]').val());
	index +=1;
	var template = '<div class="form-group merchant mer-'+index+'"><input class="form-control" type="text" name="merchant_name_'+index+'" placeholder="Enter Merchant name"><input class="form-control" type="text" name="merchant_url_'+index+'" placeholder="Enter Merchant url"><input class="form-control" type="text" name="merchant_price_'+index+'" placeholder="Enter Merchant Price"><div class="custom-control custom-radio custom-control-inline"><input checked value="1" type="radio" id="statusactive'+index+'" name="merchant_status'+index+'" class="custom-control-input"><label class="custom-control-label" for="statusactive'+index+'">Active</label></div><div class="custom-control custom-radio custom-control-inline"><input value="0" type="radio" id="statusinactive'+index+'" name="merchant_status'+index+'" class="custom-control-input"><label  class="custom-control-label" for="statusinactive'+index+'">Inactive</label></div></div>';
	$('.merchant-dynamic').append(template);
	$('input[name="merchant_count"]').val(index);
});
$('button[name="remove_merchant"]').on('click' , function(e){
	toastr.remove();
	var index = parseInt($('input[name="merchant_count"]').val());
	if(index!=0){
		$('.mer-'+index).remove();
		toastr.success('Merchant Block removed successfully');
		$('input[name="merchant_count"]').val(index -=1);
	}else{
		toastr.error('No more blocks to remove');
	}
});
$('#product_save').on('click' , function(e){
	var status = validate_product();
	if(!status){
		$('#create_product').submit();
	}
});
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
function validate_product(){
	toastr.remove();
	var error = false;
	var productTitle = $.trim($("<div/>").html(CKEDITOR.instances.product_title.getData()).text());
	var productShortTitle = $.trim($("<div/>").html(CKEDITOR.instances.product_short_title.getData()).text());
	var productSummary = $.trim($("<div/>").html(CKEDITOR.instances.product_summary.getData()).text());
	var main_section = $('select[name="category"]').val();
	var image = $('.image-block').find('img').attr('src');
	var image_caption = $('input[name="image_caption"]').val().trim();
	var image_alt = $('input[name="image_alt"]').val().trim();
	var image_name = $('input[name="image_name"]').val().trim();
	var merchantCount = parseInt($('input[name="merchant_count"]').val());
	$('.error').remove();
	if(productTitle==''){
		error = true;
		$('.headline').append('<p class="error">Enter valid product title</p>');
		toastr.error('Enter valid product title');
	}
	if(main_section==''){
		error = true;
		$('select[name="category"]').parent('.form-group').append('<p class="error">Select valid section</p>');
		toastr.error('Select valid section');
	}
	if(productShortTitle==''){
		error = true;
		$('.short').append('<p class="error">Enter valid product Short title</p>');
		toastr.error('Enter valid product Short title');
	}
	if(productSummary==''){
		error = true;
		$('.summary').append('<p class="error">Enter valid product summary</p>');
		toastr.error('Enter valid product summary');
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
	}
	if(merchantCount > 0){
		for($i=1; $i <=merchantCount;$i++){
			var merchantName = $('input[name="merchant_name_'+$i+'"]').val().trim();
			var merchantUrl = $('input[name="merchant_url_'+$i+'"]').val().trim();
			var merchantPrice = $('input[name="merchant_price_'+$i+'"]').val().trim();
			if(merchantName==''){
				error = true;
				toastr.error('Enter valid merchant name');
			}
			if(merchantUrl==''){
				error = true;
				toastr.error('Enter valid merchant url');
			}
			if(merchantPrice==''){
				error = true;
				toastr.error('Enter valid merchant price');
			}
		}
		
	}
	
	return error;
	
}

