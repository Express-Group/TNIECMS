var userid = $('#userid').val();
var template_view = $('#templaterole_view').val();
var template_add = $('#templaterole_add').val();
var template_edit = $('#templaterole_edit').val();
var template_delete = $('#templaterole_delete').val();
$(document).ready(function(e){
	$('.template-list').eq(0).click();
	$('.col-md-3 .list-group-flush').niceScroll({
			overflowx: false
	});
});
$('.template-list').on('click' , function(e){
	toastr.remove();
	if(template_view=='' || template_view=='0'){
		toastr.error('You don\'t have permission to access this page.');
		return false;
	}
	$('.template-list').removeClass('active');
	$(this).addClass('active');
	var sid = $(this).data('sid');
	$('#selected_sid').val(sid);
	$.ajax({
		type:'post',
		url:BASEURL+ADMINFOLDER+'template/get_templates',
		data:{'sid' : sid},
		beforeSend : function(){
			$('.template').html('<div class="spinner-grow text-primary" role="status" style="width: 5rem;height: 5rem;"><span class="sr-only">Loading...</span></div>');
		},
		dataType:'json',
		success:function(result){
			console.log(result);
			$('.versions').html(result.versions);
			$('.after-template').show();
			if(result.currenttemplate!=null && result.currenttemplate!=''){
				$('#update_template').show();
				$('#selected_tid').val(result.currenttemplate.tid);
				if(result.currenttemplate.locked_by==userid){
					$('#lock_template').hide();
					$('#unlock_template').show();
					$('#lock_template').prop('disabled' , true);
					$('.template').css({'opacity' : '1' , 'pointer-events' :'auto'});
				}else{
					if(result.currenttemplate.locked_by==null || result.currenttemplate.locked_by!=userid){
						$('#lock_template').prop('disabled' , false);
						$('#lock_template').show();
						$('#unlock_template').hide();
						$('.template').css({'opacity' : '.5' , 'pointer-events' :'none'});
						$('#update_template').hide();
					}
				}
				if(result.currenttemplate.update_status==0 && result.currenttemplate.locked_by==userid){
					$('#update_template').show();	
				}else{
					$('#update_template').hide();	
				}
				userinfo(result);
				form_template(result.currenttemplate);
				//$( ".template-inner" ).sortable({revert: true});
				//$(".template-inner" ).disableSelection();
			}else{
				$('#lock_template').hide();
				$('#update_template').hide();
				$('.template').html('<div class="row align-items-md-center"> <div class="col-lg-4 d-none d-lg-block"><img class="img-fluid" src="'+BASEURL+'assets/images/mean_at_work.svg" alt="image"> </div><div class="col-lg-7 offset-lg-1 text-center text-lg-left"><h2 class="display-4">Template not found</h2></div></div>');
				userinfo(result);
			}
			
		},
		error:function(err ,errmsg){
			toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
		}
	});
});

$('.select_template').on('click' , function(e){
	toastr.remove();
	var type = $(this).data('type');
	if(type!=''){
		$.ajax({
			type:'post',
			cache:false,
			data:{'sid' : $('#selected_sid').val() , 'type' : type},
			url :BASEURL+ADMINFOLDER+'template/add_templates',
			dataType: 'json',
			success:function(result){
				console.log(result);
				$('.versions').html(result.versions);
				if(result.currenttemplate!=null && result.currenttemplate!=''){
					$('#update_template').show();
					$('#selected_tid').val(result.currenttemplate.tid);
					if(result.currenttemplate.locked_by==userid){
						$('#lock_template').hide();
						$('#unlock_template').show();
						$('#lock_template').prop('disabled' , true);
						$('.template').css({'opacity' : '1' , 'pointer-events' :'auto'});
					}else{
						if(result.currenttemplate.locked_by==null || result.currenttemplate.locked_by!=userid){
							$('#lock_template').prop('disabled' , false);
							$('#lock_template').show();
							$('#unlock_template').hide();
							$('.template').css({'opacity' : '.5' , 'pointer-events' :'none'});
							$('#update_template').hide();
						}
					}
					if(result.currenttemplate.update_status==0 && result.currenttemplate.locked_by==userid){
						$('#update_template').show();	
					}else{
						$('#update_template').hide();	
					}
					userinfo(result);
					form_template(result.currenttemplate);
					$("#template_modal").modal("toggle");
				}else{
					$('#update_template').hide();
				}
			},
			error:function(err ,errmsg){
				toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
			}
		})
	}else{
		toastr.error('Something went wrong.please try again');
	}
	
});
$(document).on('click' , '.add_blocks' , function(e){ 
	if(template_add=='' || template_add=='0'){
		toastr.error('You don\'t have permission to access \'ADD BLOCKS\'.');
		return false;
	}else{
		$('#selected_block').val($(this).data('slot'));
		var target = $(this).data('sidebar-target');
		$('body').addClass('no-scroll');
		$('.sidebar-group').addClass('show');
		$('.sidebar-group .sidebar').removeClass('show');
		$('.sidebar-group .sidebar' + target).addClass('show');

		if ($('.sidebar-group').hasClass('show')) {
		  $('.sidebar-group .sidebar' + target).niceScroll({
			overflowx: false
		  });
		} else {
		  $('.sidebar-group .sidebar' + target).getNiceScroll().remove();
		}
		//return false;
	}
	
});
$(document).on('click' , '.btn-settings' , function(e){
	toastr.remove();
	if(template_edit=='' || template_edit=='0'){
		toastr.error('You don\'t have permission to access \'EDIT BLOCKS\'.');
		return false;
	}
	var block = $(this).parents('.blocks');
	var title = $(block).data('title');
	var slots = $(block).data('slots');
	var id = $(block).data('id');
	var type = $(block).data('type');
	var json = $(block).attr('data-json');
	var src = $(block).data('src');
	var timestamp = Date.now();
	$(block).addClass('blk-'+timestamp);
	$.ajax({
		type:'post',
		cache:false,
		data:{'title' : title , 'slots' : slots , 'id' : id , 'json' : json , 'src' : src , 'type' : type , timestamp : timestamp},
		url:BASEURL+ADMINFOLDER+'template/block_config',
		dataType:'json',
		success:function(result){
			//alert(result);
			console.log(result);
			$('#block_modal').find('.modal-body').html(result.content);
			$("#block_modal").modal({backdrop: "static"});
		},
		error:function(err , errmsg){
			console.log(err);
			toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
		}
	});
	
});
$(document).on('click' , '.btn-delete' , function(e){
	toastr.remove();
	if(template_delete=='' || template_delete=='0'){
		toastr.error('You don\'t have permission to access \'DELETE BLOCKS\'.');
		return false;
	}
	var cnf = confirm("Are you sure want to delete?");
	if(cnf){
		$(this).parents('.blocks').remove();
		update_template();
	}
});
$(document).on('change' , '#mode' ,function(e){
	if($(this).val()=='1'){
		$('.profile-tab-1').hide();
	}else{
		$('.profile-tab-1').show();
	}
});

$(document).on('change' , '#section' ,function(e){
	var id = ($(this).val()=='') ? 0  : $(this).val();
	$.ajax({
		type:'post',
		cache:false,
		data:{'id' : id},
		url:BASEURL+ADMINFOLDER+'template/get_particular_section',
		success:function(result){
			//alert(result);
			$('#section_main').html(result);
			loadcontent(id);
		},
		error:function(err , errmsg){
			toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
		}
	});
});
$('#block_config_save').on('click' , function(e){
	toastr.remove();
	var error = false;
	var block_type = $('#block_type').val();
	var block_title = $('#block_title').val().trim();
	var block_link = $('#block_link').val().trim();
	var max_article = $('#max_article').val();
	var mode = $('#mode').val();
	var section = $('#section').val();
	var status = $('#status').val();
	var summary = $('#summary').val();
	var content = $('#content').val();
	var summary_status = $('#summary_status').val();
	/* if(block_title==''){
		error =true;
		toastr.error("Please enter block title");
	} */
	if(block_type=='1'){
		if(max_article==''){
			error =true;
			toastr.error("Please enter valid Max article");
		}
		if(mode==''){
			error =true;
			toastr.error("Please select mode");
		}
	}
	if(!error){
		var obj = {};
		obj.block_title = block_title;
		obj.block_link = block_link;;
		obj.max_article = max_article;
		obj.mode = mode;
		obj.section = section;
		obj.status = status;
		obj.content = content;
		obj.summary = summary;
		obj.summary_status = summary_status;
		obj.articles = '';
		if(block_type=='1'){
			$($('#selected_content').find('tbody')).find('tr').each(function(index){
				if(obj.articles==''){
					obj.articles +=$(this).data('id') +'-'+ $(this).data('type');
				}else{
					obj.articles += ','+$(this).data('id') +'-'+ $(this).data('type');
				}
				
			});
		}
		var result = JSON.stringify(obj);
		if(result!=''){
			var timestamp = $('#timestamp').val();
			$('.blk-'+timestamp).find('.block-title').html(obj.block_title);
			$('.blk-'+timestamp).attr('data-json' , b64EncodeUnicode(result)).removeClass('blk-'+timestamp);
			 update_template();
			 $("#block_modal").modal("toggle");
			 toastr.success('Block Updated successfully');
		}
		
	}
});
$('.block_template_close').on('click' , function(e){
	var timestamp = $('#timestamp').val();
	$('.blk-'+timestamp).removeClass('blk-'+timestamp);
	$("#block_modal").modal("toggle");
});
$('.versions').on('change' , function(e){
	if(template_view=='' || template_view=='0'){
		toastr.error('You don\'t have permission to access this page.');
		return false;
	}
	$.ajax({
		type:'post',
		url:BASEURL+ADMINFOLDER+'template/get_version_templates',
		data:{'tid' : $(this).val() , 'sid' : $('#selected_sid').val()},
		beforeSend : function(){
			$('.template').html('<div class="spinner-grow text-primary" role="status" style="width: 5rem;height: 5rem;"><span class="sr-only">Loading...</span></div>');
		},
		dataType:'json',
		success:function(result){
			console.log(result);
			$('.versions').html(result.versions);
			$('.after-template').show();
			if(result.currenttemplate!=null && result.currenttemplate!=''){
				$('#update_template').show();
				$('#selected_tid').val(result.currenttemplate.tid);
				if(result.currenttemplate.locked_by==userid){
					$('#lock_template').hide();
					$('#unlock_template').show();
					$('#lock_template').prop('disabled' , true);
					$('.template').css({'opacity' : '1' , 'pointer-events' :'auto'});
				}else{
					if(result.currenttemplate.locked_by==null || result.currenttemplate.locked_by!=userid){
						$('#lock_template').prop('disabled' , false);
						$('#lock_template').show();
						$('#unlock_template').hide();
						$('.template').css({'opacity' : '.5' , 'pointer-events' :'none'});
						$('#update_template').hide();
					}
				}
				if(result.currenttemplate.update_status==0 && result.currenttemplate.locked_by==userid){
					$('#update_template').show();	
				}else{
					$('#update_template').hide();	
				}
				userinfo(result);
				form_template(result.currenttemplate);
			}else{
				$('#update_template').hide();
				$('.template').html('<div class="row align-items-md-center"> <div class="col-lg-4 d-none d-lg-block"><img class="img-fluid" src="'+BASEURL+'assets/images/mean_at_work.svg" alt="image"> </div><div class="col-lg-7 offset-lg-1 text-center text-lg-left"><h2 class="display-4">Template not found</h2></div></div>');
			}
			
		},
		error:function(err ,errmsg){
			toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
		}
	});
});
$('#lock_template').on('click' , function(e){
	toastr.remove();
	if(template_edit=='' || template_edit=='0'){
		toastr.error('You don\'t have permission to access \'LOCK TEMPLATE\'.');
		return false;
	}
	var sid = $('#selected_sid').val();
	var tid = $('#selected_tid').val();
	if(sid!='' && tid!=''){
		$.ajax({
			type:'post',
			cache:false,
			data:{'tid' : tid , 'sid' :sid},
			url:BASEURL+ADMINFOLDER+'template/lock_template',
			dataType:'json',
			success:function(result){			
				if(result.lock_status[0]==1){
					if(result.currenttemplate!=null && result.currenttemplate!=''){
						$('#update_template').show();
						$('#selected_tid').val(result.currenttemplate.tid);
						if(result.currenttemplate.locked_by==userid){
							$('#lock_template').hide();
							$('#unlock_template').show();
							$('#lock_template').prop('disabled' , true);
							$('.template').css({'opacity' : '1' , 'pointer-events' :'auto'});
						}else{
							if(result.currenttemplate.locked_by==null || result.currenttemplate.locked_by!=userid){
								$('#lock_template').prop('disabled' , false);
								$('#lock_template').show();
								$('#unlock_template').hide();
								$('.template').css({'opacity' : '.5' , 'pointer-events' :'none'});
								$('#update_template').hide();
							}
						}
					}
					if(result.currenttemplate.update_status==0 && result.currenttemplate.locked_by==userid){
						$('#update_template').show();	
					}else{
						$('#update_template').hide();	
					}
					userinfo(result);
					form_template(result.currenttemplate);
				}else{
					toastr.error('Current Template was locked by '+result.lock_status[1]);
				}
			},
			error:function(err ,errmsg){
				console.log(err);
				toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
			}
		});
	}
});
$('#unlock_template').on('click' , function(e){
	toastr.remove();
	if(template_edit=='' || template_edit=='0'){
		toastr.error('You don\'t have permission to access \'UNLOCK TEMPLATE\'.');
		return false;
	}
	var cnf= confirm("Are you sure want to unlock the template?");
	if(cnf){
		var sid = $('#selected_sid').val();
		var tid = $('#selected_tid').val();
		if(sid!='' && tid!=''){
			$.ajax({
				type:'post',
				cache:false,
				data:{'tid' : tid , 'sid' :sid},
				url:BASEURL+ADMINFOLDER+'template/unlock_template',
				dataType :'json',
				success:function(result){
				if(result.status==1){
					$('#lock_template').prop('disabled' , false);
					$('#lock_template').show();
					$('#unlock_template').hide();
					$('.template').css({'opacity' : '.5' , 'pointer-events' :'none'});
					$('#update_template').hide();
					userinfo(result);
					
				}else{
					toastr.error('Something went wrong..please try again');
				}
			},
			error:function(err ,errmsg){
				console.log(err);
				toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
			}
		});
	}
	}
});
$('#update_template').on('click' , function(e){
	toastr.remove();
	if(template_edit=='' || template_edit=='0'){
		toastr.error('You don\'t have permission to access \'PUBLISH TEMPLATE\'.');
		return false;
	}
	var cnf = confirm("Are you sure want to publish the template?");
	if(cnf){
		var sid = $('#selected_sid').val();
		var tid = $('#selected_tid').val();
		if(sid!='' && tid!=''){
			$.ajax({
				type:'post',
				cache:false,
				data:{'tid' : tid , 'sid' :sid},
				url:BASEURL+ADMINFOLDER+'template/publish_template',
				dataType :'json',
				success:function(result){
					if(result.status==1 && result.template_status==1){
						toastr.success('Template Published successfully');
						$('.versions').html(result.versions);
						$('.after-template').show();
						if(result.currenttemplate!=null && result.currenttemplate!=''){
							$('#update_template').show();
							$('#selected_tid').val(result.currenttemplate.tid);
							if(result.currenttemplate.locked_by==userid){
								$('#lock_template').hide();
								$('#unlock_template').show();
								$('#lock_template').prop('disabled' , true);
								$('.template').css({'opacity' : '1' , 'pointer-events' :'auto'});
							}else{
								if(result.currenttemplate.locked_by==null || result.currenttemplate.locked_by!=userid){
									$('#lock_template').prop('disabled' , false);
									$('#lock_template').show();
									$('#unlock_template').hide();
									$('.template').css({'opacity' : '.5' , 'pointer-events' :'none'});
									$('#update_template').hide();
								}
							}
							if(result.currenttemplate.update_status==0 && result.currenttemplate.locked_by==userid){
								$('#update_template').show();	
							}else{
								$('#update_template').hide();	
							}
							userinfo(result);
							form_template(result.currenttemplate);
						}
						
					}else{
						toastr.error('Something went wrong..please try again');
					}
				},
				error:function(err ,errmsg){
					console.log(err);
					toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
				}
			});
		}
	}
});
function create_template(){
	if(template_add=='' || template_add=='0'){
		toastr.error('You don\'t have permission to access \'ADD TEMPLATE\'.');
		return false;
	}
	$("#template_modal").modal({backdrop: "static"});
}

function form_template(template){
	if(template.template!='' && template.template!=null){
		var design = JSON.parse(template.template);
		var type = design.type;
		$('#selected_type').val(type);
		var ele = design.template;
		//if(ele!='' && ele!=null){
			var html = '';
			switch (type) {
				case '3':
					html += '<div class="template-inner bg-info-bright template-width-100 corner-1" value="3">';
					if(ele!='' && ele!=null){
						if(ele[0]!='' && ele[0]!=undefined){
							html +=build_block(ele[0]);
						}
					}
					html += '<button data-slot="corner-1" data-sidebar-target="#chat-list" class="btn btn-danger add_blocks"> Add Blocks</button>'; 
					html += '</div>';
				break;
				case '3,2-1,3':
					html += '<div class="template-inner bg-info-bright template-width-100 corner-1 margin-15" value="3,2-1,3">';
					if(ele!='' && ele!=null){
						if(ele[0]!='' && ele[0]!=undefined){
							html +=build_block(ele[0]);
						}
					}
					html += '<button data-slot="corner-1" data-sidebar-target="#chat-list" class="btn btn-danger add_blocks"> Add Blocks</button>'; 
					html += '</div>';
					html +='<div class="inside-row">';
						html += '<div class="template-inner bg-info-bright template-width-65 corner-2" value="3,2-1,3">';
						if(ele!='' && ele!=null){
							if(ele[1]!='' && ele[1]!=undefined){
								html +=build_block(ele[1]);
							}
						}
						html += '<button data-slot="corner-2" data-sidebar-target="#chat-list" class="btn btn-danger add_blocks"> Add Blocks</button>'; 
						html += '</div>';
						
						html += '<div class="template-inner bg-info-bright template-width-35 corner-3" value="3,2-1,3">';
						if(ele!='' && ele!=null){
							if(ele[2]!='' && ele[2]!=undefined){
								html +=build_block(ele[2]);
							}
						}
						html += '<button data-slot="corner-3" data-sidebar-target="#chat-list" class="btn btn-danger add_blocks"> Add Blocks</button>'; 
						html += '</div>';
					html += '</div>';
					
					html += '<div class="template-inner bg-info-bright template-width-100 corner-4 margin-15" value="3,2-1,3">';
					if(ele!='' && ele!=null){
						if(ele[3]!='' && ele[3]!=undefined){
							html +=build_block(ele[3]);
						}
					}
					html += '<button data-slot="corner-4" data-sidebar-target="#chat-list" class="btn btn-danger add_blocks"> Add Blocks</button>'; 
					html += '</div>';
					
				break;
			}
			$('.template').html(html);
			$('.layout-wrapper .content-wrapper .content-body .content').css('overflow','auto');
			$('.layout-wrapper .content-wrapper .content-body .content').getNiceScroll().remove();
		//}
	}
}

function userinfo(result){
	var info ='';
	if(result.lockdetails.username!='' &&  result.lockdetails.username!=undefined){
		info += 'Locked By : '+ result.lockdetails.firstname +' '+result.lockdetails.lastname;
	}
	if(result.currenttemplate.update_status==0){
		if(info!=''){ info +='&nbsp;&nbsp;|&nbsp;&nbsp;'};
		info += 'Template Changes are not published';
	}
	
	if(info!=''){
		
		$('.user-info').html(info).show();
	}else{
		$('.user-info').hide(); 
	}
}

function add_block(id){
	toastr.remove();
	if(template_add=='' || template_add=='0'){
		toastr.error('You don\'t have permission to access \'ADD BLOCKS\'.');
		return false;
	}
	var bindArea = $('#selected_block').val();
	toastr.success('please wait...');
	$.ajax({
		type:'post',
		cache:false,
		data:{'bid' :id },
		url:BASEURL+ADMINFOLDER+'template/get_block',
		dataType : 'json',
		success:function(result){
			if(result.bid!=''){
				$(result.content).insertBefore($('.'+bindArea).find('.add_blocks'));
				$('.layout-wrapper .content-wrapper .content-body .content').css('overflow','auto');
				$.removeOverlay();
				$('.sidebar-group').removeClass('show');
				$('.sidebar-group .sidebar').removeClass('show');
				 update_template();
			}else{
				toastr.error('Something went wrong.please try again');
			}
		},
		error:function(err , errmsg){
			toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
		}
	})
}

function update_template(){
	var tid = $('#selected_tid').val();
	var type = $('#selected_type').val();
	var tmp =[];
	switch (type) {
		case '3':
			var json = [];
			$('.template-inner').find('.blocks').each(function(e){
				var slot = $(this).data('slots');
				var dataType = $(this).data('type');
				var id = $(this).data('id');
				var title = $(this).data('title');
				var path = $(this).data('path');
				var rawdata = $(this).attr('data-json');
				//alert(rawdata); 
				var src = $(this).data('src');
				json.push({slot : slot , dataType : dataType , id : id , title :title , rawdata :rawdata , src : src , path : path});
			});
			tmp[0] = json;
		break;
		case '3,2-1,3':
			var json = [];
			var json1 = [];
			var json2  = [];
			var json3 = [];
			$('.corner-1').find('.blocks').each(function(e){
				json.push({slot : $(this).data('slots') , dataType : $(this).data('type') , id : $(this).data('id') , title :$(this).data('title') , rawdata :$(this).attr('data-json') , src : $(this).data('src') , path : $(this).data('path')});
			});
			tmp[0]=json;
			$('.corner-2').find('.blocks').each(function(e){
				json1.push({slot : $(this).data('slots') , dataType : $(this).data('type') , id : $(this).data('id') , title :$(this).data('title') , rawdata :$(this).attr('data-json') , src : $(this).data('src') , path : $(this).data('path')});
			});
			tmp[1]=json1;
			$('.corner-3').find('.blocks').each(function(e){
				json2.push({slot : $(this).data('slots') , dataType : $(this).data('type') , id : $(this).data('id') , title :$(this).data('title') , rawdata :$(this).attr('data-json') , src : $(this).data('src') , path : $(this).data('path')});
			});
			tmp[2]=json2;
			$('.corner-4').find('.blocks').each(function(e){
				json3.push({slot : $(this).data('slots') , dataType : $(this).data('type') , id : $(this).data('id') , title :$(this).data('title') , rawdata :$(this).attr('data-json') , src : $(this).data('src') , path : $(this).data('path')});
			});
			tmp[3]=json3;
		break;
	}
	if(tid!='' && type!=''){
			$.ajax({
				type:'post',
				cache:false,
				asyn:true,
				url:BASEURL+ADMINFOLDER+'template/update_template',
				data:{'tid' : tid , 'type' :type ,'json' :tmp},
				dataType:'json',
				success:function(result){
					if(result.status==1){
						userinfo(result)
						if(result.currenttemplate.update_status==0 && result.currenttemplate.locked_by==userid){
							$('#update_template').show();	
						}else{
							$('#update_template').hide();	
						}
						toastr.success('Block updated successfully');
					}else{
						toastr.error('Something went wrong.please try again');
					}
				},
				error:function(err , errmsg){
					toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
				}
			});
		}else{
			toastr.error('Something went wrong.please try again');
		}
}

function loadcontent(id){
	$.ajax({
		type:'post',
		cache:false,
		asyn:true,
		url:BASEURL+ADMINFOLDER+'template/get_content',
		data:{'id' : id},
		success:function(result){
			$('.content-list').html(result);
		},
		error:function(err , errmsg){
			toastr.error('Error Code : '+ err.status+ ' Error Message : '+errmsg);
		}
	});
}

function add_template_articles(id){
	toastr.remove();
	var hasContent = false;
	$($('#selected_content').find('tbody')).find('tr').each(function(index){
		if($(this).data('id')==id){
			hasContent = true;
		}
	});
	if(!hasContent){
		var template = '<tr class="content-selected-list-'+id+'" data-type="'+$('.content-list-'+id).data('type')+'" data-id="'+id+'">';
		template += '<td>'+id+'</td>';
		template += '<td>'+$('.content-list-'+id).find('td').eq(1).html()+'</td>';
		template += '<td>'+$('.content-list-'+id).find('td').eq(2).html()+'</td>';
		template += '<td>'+$('.content-list-'+id).find('td').eq(3).html()+'</td>';
		template += '<td><button onclick="remove_template_articles('+id+')" style="padding: 6px 8px;" class="btn btn-primary">Remove</button></td>';
		template += '</tr>';
		$('.content-list-'+id).hide();
		$($('#selected_content').find('tbody')).append(template);
	}else{
		toastr.error('Content Already Taken..please try agian');
	}
}

function remove_template_articles(id){
	toastr.remove();
	$('.content-selected-list-'+id).remove();
	$('.content-list-'+id).show();
	toastr.success("Content removed Successfully");

}
if( !window.unescape ){
    window.unescape = function( s ){
        return s.replace( /%([0-9A-F]{2})/g, function( m, p ) {
            return String.fromCharCode( '0x' + p );
        } );
    };
}
if( !window.escape ){
    window.escape = function( s ){
        var chr, hex, i = 0, l = s.length, out = '';
        for( ; i < l; i ++ ){
            chr = s.charAt( i );
            if( chr.search( /[A-Za-z0-9\@\*\_\+\-\.\/]/ ) > -1 ){
                out += chr; continue; }
            hex = s.charCodeAt( i ).toString( 16 );
            out += '%' + ( hex.length % 2 != 0 ? '0' : '' ) + hex;
        }
        return out;
    };
}
function b64EncodeUnicode(str) {
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}

function b64DecodeUnicode(str) {
   // return decodeURIComponent(atob(str).split('').map(function(c) {
      //  return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
  //  }).join(''));
	 return decodeURIComponent(escape(window.atob( str )));
}

function build_block(ele){
	html ='';
	for($j=0;$j<ele.length;$j++){
		var title= ele[$j]['title']
		/* if(ele[$j]['rawdata']!='' && ele[$j]['rawdata']!=null){
			var rawdata = b64DecodeUnicode(ele[$j]['rawdata']);
			if (rawdata.block_title!=''){
				title = rawdata.block_title;
			}
		} */
		if(ele[$j]['dataType']=='3'){
			html +='<div class="blocks" data-slots="'+ele[$j]['slot']+'" data-type="'+ele[$j]['dataType']+'" data-id="'+ele[$j]['id']+'" data-json="'+ele[$j]['rawdata']+'" data-title="'+ele[$j]['title']+'" data-src="'+ele[$j]['src']+'" data-path="'+ele[$j]['path']+'"><h5><span class="block-title">'+title+'</span><span class="block-settings"><a class="btn btn-danger btn-delete"><i class="ti-trash"></i></a></span></h5><hr><img src="'+ele[$j]['src']+'"></div>';
		}else{
			html +='<div class="blocks" data-slots="'+ele[$j]['slot']+'" data-type="'+ele[$j]['dataType']+'" data-id="'+ele[$j]['id']+'" data-json="'+ele[$j]['rawdata']+'" data-title="'+ele[$j]['title']+'" data-src="'+ele[$j]['src']+'" data-path="'+ele[$j]['path']+'"><h5><span class="block-title">'+title+'</span><span class="block-settings"><a class="btn btn-primary btn-settings"> <i class="ti-settings"></i></a>&nbsp;<a class="btn btn-danger btn-delete"><i class="ti-trash"></i></a></span></h5><hr><img src="'+ele[$j]['src']+'"></div>';
		}
		
	}
	return html;
}