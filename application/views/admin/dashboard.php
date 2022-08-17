<?php /*$set_uset_id = $this->session->userdata('userID'); 
if($set_uset_id == "")
{
	redirect('admin/user_login');
}*/
?>


<style>
.MainTitle{
	 font-size: 40px;
    text-align: center;
	height:500px;
	}
.MainTitle p:first-child{
	padding-top:200px;
	}
.MainTitle p{
	line-height:50px;
	font-family:Arial, Helvetica, sans-serif;
	}
.faqs{
	position: fixed;
    bottom: 14%;
    right: 3%;
    background: #3c8dbc;
    color: #fff !important;
    padding: 4px 17px 6px;
    border-radius: 4px;
}
.modal-dialog{
	z-index: 99999;
	margin-top: 7% !important;
}
#conrona_virus .form-group{width:100% !important;}
#conrona_virus .form-control{border: 1px solid #eee !important;}
</style>
<link href="<?php echo image_url ?>css/admin/bootstrap.min_3_3_4.css" rel="stylesheet" type="text/css">	
<script type="text/javascript" src="<?php echo image_url ?>js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?php echo image_url ?>js/bootstrap/bootstrap.min.js"></script>
<a class="faqs" href="<?php echo base_url(folder_name.'/faqs'); ?>">FAQs</a>
<div class="MainTitle">
<div class="menus-custom text-center" style="float: left;width: 100%; margin-top: 8%;">
<button class="btn-primary btn" style="font-size: 16px !important; margin-left: 2%;" id="c_virus">Corona virus</button>
<a class="btn-primary btn" href="<?php echo base_url(folder_name.'/covidmaster'); ?>" style="font-size: 16px !important;">Covid Fight Club</a>
</div>
<p>Welcome</p>
<p>To</p>
<p>New Indian Express</p>
<p>CMS System</p>
<br/>
<p>Version : 1.0</p>
</div>

<div id="conrona_virus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">CORONA VIRUS</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
			<label>Active case in india <sup>*</sup></label>
			<input type="number" class="form-control" id="active_case_india">
		</div>
		<div class="form-group">
			<label>Deaths in india <sup>*</sup></label>
			<input type="number" class="form-control" id="deaths_case_india">
		</div>
		<div class="form-group">
			<label>Recovered case in india <sup>*</sup></label>
			<input type="number" class="form-control" id="re_case_india">
		</div>
		<div class="form-group">
			<label>Active case in World <sup>*</sup></label>
			<input type="number" class="form-control" id="active_case_world">
		</div>
		<div class="form-group">
			<label>Deaths in World <sup>*</sup></label>
			<input type="number" class="form-control" id="deaths_case_world">
		</div>
		<div class="form-group">
			<label>Recovered case in World <sup>*</sup></label>
			<input type="number" class="form-control" id="re_case_world">
		</div>
		<div class="form-group">
			<label>Landing Url <sup>*</sup></label>
			<input type="text" class="form-control" id="re_url">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="save_corona()">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
$('#c_virus').on('click' , function(){
	$.ajax({
			type:'post',
			cache:false,
			url : '<?php echo base_url(folder_name) ?>/specialwidget/get_corona',
			dataType:'json',
			success:function(res){
				$('#active_case_india').val(res.active_case_india);
				$('#deaths_case_india').val(res.deaths_case_india);
				$('#re_case_india').val(res.re_case_india);
				$('#active_case_world').val(res.active_case_world);
				$('#deaths_case_world').val(res.deaths_case_world);
				$('#re_case_world').val(res.re_case_world);
				$('#re_url').val(res.url);
				$("#conrona_virus").modal({backdrop: "static"});
			},
			error:function(err , errcode){
				alert('404');
			}
		})
});
function save_corona(){
	toastr.remove();
	var active_case_india = $('#active_case_india').val();
	var deaths_case_india = $('#deaths_case_india').val();
	var re_case_india = $('#re_case_india').val();
	var active_case_world = $('#active_case_world').val();
	var deaths_case_world = $('#deaths_case_world').val();
	var re_case_world = $('#re_case_world').val();
	var re_url = $('#re_url').val();
	if(active_case_india!='' && deaths_case_india!='' && re_case_india!='' && active_case_world!='' && deaths_case_world!='' && re_case_world!='' && re_url!=''){
		$.ajax({
			type:'post',
			cache:false,
			url : '<?php echo base_url(folder_name) ?>/specialwidget/corona',
			data:{'active_case_india' : active_case_india , 'deaths_case_india' : deaths_case_india ,'re_case_india' : re_case_india , 'active_case_world' : active_case_world , 'deaths_case_world' : deaths_case_world , 're_case_world' : re_case_world , 're_url' :re_url},
			success:function(res){
				if(res==1){
					toastr.success('Details updated successfully');
					$("#conrona_virus").modal("toggle");
				}else{
					toastr.error('something went wrong..please try again');
				}
			},
			error:function(err , errcode){
				alert('404');
			}
		});
	}else{
		toastr.error('Enter valid details');
	}
}
</script>