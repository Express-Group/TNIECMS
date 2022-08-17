<link href="<?php echo image_url; ?>css/admin/bootstrap.min_3_3_4.css" rel="stylesheet" type="text/css">
<style>
.form-control{border: 1px solid #ccc !important;}
.padding-right-0{padding-right:0;}
.cache-table thead tr{background: #eee;}
.cache-table thead tr th , .cache-table tbody tr td{text-align:center;}
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
			<div class="row" style="margin-top:3%;">
				<div class="col-md-2 padding-right-0">
					<select class="form-control" name="extensiontype">
						<option value="">Select any one</option>
						<option value="home" type="1"> Home page</option>
						<option value="html" type="1"> Article page</option>
						<option value="(any)" type="1"> Section page </option>
						<option value="css" type="2"> Css </option>
						<option value="js" type="2"> Js </option>
						<option value="img" type="2"> Image </option>
						<option value="resources" type="2"> Resources </option>
					</select>
				</div>
				<div class="col-md-8 padding-right-0">
					<input class="form-control" name="url" type="text" placeholder="Enter valid url">
				</div>
				<div class="col-md-2">
					<button id="add_url" style="line-height: 1.3;" class="btn btn-primary"> <i class="fa fa-plus" aria-hidden="true"></i> Add Url</button>
				</div>
			</div>
			<hr>
			<table class="table cache-table">
				<thead>
					<tr>
						<th>Type</th>
						<th>Url</th>
						<th style="width: 150px;">Progress</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4"><button style="float:right;" id="purge" style="display:none;" class="btn btn-primary"><i class="fa fa-eraser" aria-hidden="true"></i> Purge</button></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo image_url; ?>js/bootstrap.min.js"></script>
<script>
var run=false;
	$(document).ready(function(e){
		$('input[name="url"]').on('keyup' , function(e){
			var url = $(this).val();
			if(url!=''){
				url = url.trim();
				url = url.replace('https://www.newindianexpress.com' ,'');
				url = url.replace('https://images.newindianexpress.com' ,'');
				url = url.replace('images.newindianexpress.com' ,'');
				url = url.replace('www.newindianexpress.com' ,'');
				if(url=='' || url=='/'){
					selectListBox('home');
				}else{
					var pos = url.split('.');
					if(pos.length==1){
						selectListBox('(any)');
					}else{
						temp = pos[pos.length -1].toLowerCase();
						if(temp=='html'){
							selectListBox('html');
						}else if(temp=='jpg' || temp=='jpeg' || temp=='png' || temp=='gif'){
							selectListBox('img');
						}else if(temp=='css'){
							selectListBox('css');
						}else if(temp=='js'){
							selectListBox('js');
						}else if(temp=='pdf' || temp=='doc' ||temp=='docx'){
							selectListBox('resources');
						}
					}
				}
				
			}
		});
		
		$('#add_url').on('click' , function(e){
			toastr.remove();
			var url = $('input[name="url"]').val();
			var type = $("select[name='extensiontype']").val();
			if(url!='' && type!=''){
				url = url.trim();
				typename = $("select[name='extensiontype'] :selected").text();
				typeid = $("select[name='extensiontype'] :selected").attr('type');
				id = Math.floor((Math.random() * 1000000) + 1);
				$table = '';
				$table +='<tr class="url-'+id+'">';
				$table +='<td>'+typename+'<span style="display:none;">'+typeid+'</span></td>';
				$table +='<td>'+url+'</td>';
				$table +='<td><div class="progress"><div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:1%">0% Complete</div></div></td>';
				$table +='<td><button onclick="remove_url('+id+')" class="btn btn-primary"><i class="fa fa-trash" aria-hidden="true"></i></button></td>';
				$table +='</tr>';
				$('.cache-table').find('tbody').append($table);
				$('input[name="url"]').val('');
				DeselectListBox();
				$('#purge').show();
			}else{
				toastr.error("Enter valid url (or) Select valid type");
			}
			
		});
		$('#purge').on('click' , function(e){
			toastr.remove();
			if($($('.cache-table').find('tbody')).find('tr').length!=0){
				var list = [];
				$($('.cache-table').find('tbody')).find('tr').each(function(index){
					var typeid = $($(this).find('td').eq(0)).find('span').text();
					var url = $(this).find('td').eq(1).text();
					temp1 =[typeid , url];
					list.push(temp1);
				});
				if(list.length!=0){
					$.ajax({
						type:'post',
						cache:false,
						data:{'data' : list},
						url:'<?php echo base_url(folder_name.'/cache_master/purge') ?>',
						dataType:'json',
						beforeSend:function(){
							$($('.cache-table').find('tbody')).find('tr').each(function(index){
								var progress = $($(this).find('td').eq(2));
								$($(progress).find('.progress')).find('.progress-bar').attr('aria-valuenow' , 50).css('width' , '50%').html('50% Inprogress');
							});
							run=true;
							loader();
						},
						success:function(result){
							if(result.type==1 || result.type1==1){
								setTimeout(function(){
									run=false;
									$($('.cache-table').find('tbody')).find('tr').each(function(index){
										var progress = $($(this).find('td').eq(2));
										$($(progress).find('.progress')).find('.progress-bar').attr('aria-valuenow' , 100).css('width' , '100%').html('100% Complete').removeClass('progress-bar-warning').addClass('progress-bar-success');
									});
									clearconsole();
								},7000);
							}
						},
						error:function(err,errcode){
							console.log(err);
							console.log(errcode);
						}
					})
				}else{
					toastr.error("Enter valid url (or) Select valid type");
				}
			}else{
				toastr.error("Enter valid url (or) Select valid type");
			}
		});
	});
	
	function DeselectListBox(){
		$("select[name='extensiontype'] option").prop("selected", false);
	}
	function selectListBox($param){
		DeselectListBox();
		$("select[name='extensiontype']").find('option').each(function(e){
			if($(this).val()==$param){
				$(this).prop('selected' , true);
			}
		})
	}
	function remove_url(id){
		var cnf = confirm("Are you sure want to delete? ");
		if(cnf){
			$('.url-'+id).remove();
			len = $($('.cache-table').find('tbody')).find('tr').length;
			if(len==0){
				$('#purge').hide();
			}
		}
	}
	
	function loader(){
			setTimeout(function(){
				$($('.cache-table').find('tbody')).find('tr').each(function(index){
					var progress = $($(this).find('td').eq(2));
					var value = $($(progress).find('.progress')).find('.progress-bar').attr('aria-valuenow');
					value = parseInt(value) + 2;
					if(value <=100){
						$($(progress).find('.progress')).find('.progress-bar').attr('aria-valuenow' , value).css('width' , value+'%').html(value+'% Inprogress');
						if(run){
							loader();
						}
					}
				});
			}, 500);
	}
	
	function clearconsole(){
		setTimeout(function(){
			var cnf = confirm("Are you sure want to clear the console?");
			if(cnf){
				$($('.cache-table').find('tbody')).find('tr').remove();
				$('#purge').hide();
			}
		} , 2000);
	}
</script>