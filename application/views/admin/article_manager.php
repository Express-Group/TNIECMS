﻿<link href="<?php echo image_url; ?>css/admin/bootstrap.min_3_3_4.css" rel="stylesheet" type="text/css">	
<link href="<?php echo image_url; ?>css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo image_url; ?>css/admin/jquery.dataTables.css" rel="stylesheet" type="text/css" />

<style>
.popover{width:500px;}
.popover-content p{border-bottom: 1px solid #eee;margin-bottom: 5px;padding-bottom: 5px;}
.popover-title p{margin: 0;text-align: center;color: red;}
.popover-title span{float: right;background: #fff;padding: 0 7px 0;cursor: pointer;}
#share_modal .modal-dialog{top: 20%;}
#share_modal .modal-dialog .modal-content{box-shadow: none;border:none;margin: 0 auto;border-radius: 12px;}
.share-btn{cursor:pointer;}
</style>
<div class="Container">

<div class="BodyWhiteBG">

<div class="BodyHeadBg Overflow clear">

 
<div class="FloatLeft  BreadCrumbsWrapper PollResult">
<div class="breadcrumbs"><a href="#">Dashboard</a> > <a href="#"><?php echo $title; ?></a></div>
 <h2><?php echo $title; ?></h2>
</div> 
<!--<span class="amp_ls" style="color: #2e2e2e;padding: 5px 9px 5px;border: 1px solid #eee;border-radius: 14px;float: left;  margin: 0 21%;text-align: center;"><b style="width: 100%;float: left;text-align: center; margin-bottom: 4px; color: #3c8dbc;
"><?php echo date('jS M Y'); ?></b><br>AMP : <b style="color:green;">0</b> / NON AMP : <b style="color:red;">0</b></span>-->
<?php
if($this->session->flashdata("success"))
{     
?>
 <div id="flash_msg_id" class="FloatLeft SessionSuccess"><?php echo $this->session->flashdata("success");?></div>
<?php
}
?> 
<?php
if($this->session->flashdata("error"))
{
?>
 <div id="flash_msg_id" class="FloatLeft SessionError"><?php echo $this->session->flashdata("error");?></div>
<?php
}
?>
 
 <div id="activatedmessage" class="FloatLeft SessionSuccess" style="display:none">Activated Successfully.</div>
 <div id="deactivatedmessage" class="FloatLeft SessionSuccess" style="display:none">Deactivated Successfully.</div>
 <div id="deletedmessage" class="FloatLeft SessionSuccess" style="display:none ">Deleted Successfully.</div>

<?php if(defined("USERACCESS_ADD".$Menu_id) && constant("USERACCESS_ADD".$Menu_id) == 1) { ?>
 <p class="FloatRight SaveBackTop"><a href="<?php echo base_url().$addPage_url;?>" class="btn-primary btn"><i class="fa fa-plus-circle"></i> &nbsp;<?php echo $btn_name; ?></a></p>
 <?php } ?>
 

<?php if(defined("USERACCESS_PUBLISH".$Menu_id) && constant("USERACCESS_PUBLISH".$Menu_id) == 1) { ?>
   <p class="FloatRight SaveBackTop PubUnpublish"><button name="btnPublish" id="publish_button" title="Publish" type="button" class="btn btn-primary FloatRight i_button"><i style="" class="fa fa fa-flag"></i></button></p>
<?php } ?>
   <?php if(defined("USERACCESS_UNPUBLISH".$Menu_id) && constant("USERACCESS_UNPUBLISH".$Menu_id) == 1) { ?>
   <p class="FloatRight SaveBackTop PubUnpublish">
<button class="btn btn-primary FloatRight i_button FlagIcon2" id="unpublish_button"  title="Unpublish"></button></p>
<?php } ?>

 <?php if(defined("USERACCESS_DELETE".$Menu_id) && constant("USERACCESS_DELETE".$Menu_id) == 1) 
 {
 ?>
   <p class="FloatRight SaveBackTop PubUnpublish" style="display:none" id="draft_del">
<button class="btn btn-primary FloatRight i_button "   title="Delete"><i class="fa fa-trash-o" id="delete_button"></i></button></p>
<?php } ?>


  
</div>

<div class="Overflow DropDownWrapper">

<div class="container">

  <div class="row AskPrabuCheckBoxWrapper">
      
     
      
      <ul class="AskPrabuCheckBox FloatLeft">
      
     <li>
        
<!--<input type="checkbox" id="search_based_date" value="yes"> -->
<label class="include_label HeadTopAuto"  for="search_based_date">Search Based on Date Range</label>
    </li>
    <li id="checkin_checkout_div">
    <p class="CalendarWrapper" >
		<input type="text" placeholder="Start Date" id="date_timepicker_start" readonly value="">
		<input type="text" placeholder="End Date" id="date_timepicker_end" readonly value="">
    </p>
    </li>

         
        </ul>
       
    </div>
  
   
</div>

<div class="FloatLeft TableColumn">  

<div class="FloatLeft w2ui-field">
 <select id="article_status" class="controls">
        <option value="">Status: All</option>
        <option value="D" >Draft</option>
        <option value="P" >Published</option>
        <option value="U" >Unpublished</option>
       <!-- <option value="A" >AMP</option>
        <option value="N" >NON AMP</option>-->
    </select>	
  
</div>

<div class="FloatLeft w2ui-field">
  <select id="search_by" class="controls">
        <option value="">Search By: All</option>
        <option value="Title" >Headline</option>
		<option value="ContentId" >Content Id</option>
        <option value="created_by" >Created By</option>
        <option value="ByLine" >Byliner</option>
        <option value="Agency" >Agency</option>
        
    </select>
</div>

<div class="FloatLeft w2ui-field">
    <select id="article_section" class="controls">
      <option id="MainSectionOption" value="">-Select Section-</option>
  
 <?php if(isset($section_mapping)) { 
				 foreach($section_mapping as $mapping) {   
				 
				 if(folder_name == 'niecpan')
				$condition = $mapping['Sectionname'] != 'Galleries' && $mapping['Sectionname'] != 'Videos' && $mapping['Sectionname'] != 'Audios' && $mapping['Sectionname'] != 'Resources' ;
					else
				$condition = $mapping['Sectionname'] != 'புகைப்படங்கள்' && $mapping['Sectionname'] != 'வீடியோக்கள்' && $mapping['Sectionname'] != 'ஆடியோக்கள்';
				
				 
				 if($condition) {
					 
				 ?>

<option id="MainSectionOption" style="color:#933;font-size:18px;" <?php  /* if($mapping['Section_landing'] == 1 && $mapping['Sectionname'] != 'Columns' && $mapping['Sectionname'] != 'Magazine' && $mapping['Sectionname'] != 'The Sunday Standard' && $mapping['Sectionname'] != 'Editorials' ) { ?> disabled='disabled' <?php }  */ ?> class="blog_option" <?php if(set_value("ddMainSection") == $mapping['Section_id'] || (isset($get_article_details['content_id']) && $get_article_details['Section_id'] == $mapping['Section_id'] )) echo  "selected";  ?> sectoin_data="<?php echo @$mapping['Sectionname']; ?>" rel="<?php echo @$mapping['LinkedToColumnist']; ?>"  value="<?php echo $mapping['Section_id']; ?>" url_structure="<?php echo mb_ucwords(str_replace("-"," ",str_replace("/"," > ",trim($mapping['URLSectionStructure'])))); ?>"><?php echo strip_tags($mapping['Sectionname']); ?></option>
  <?php if(!(empty($mapping['sub_section'])) ) { ?>
 
  <?php foreach($mapping['sub_section'] as $sub_mapping) { ?>
  
    <option  id="MainSectionOption" <?php if(set_value("ddMainSection") == $sub_mapping['Section_id']  || (isset($get_article_details['content_id']) && $get_article_details['Section_id'] == $sub_mapping['Section_id'] )) echo  "selected"; ?>  sectoin_data="<?php echo @$mapping['Sectionname']; ?>"  rel="<?php echo @$sub_mapping['LinkedToColumnist']; ?>" value="<?php echo $sub_mapping['Section_id']; ?>" url_structure="<?php echo mb_ucwords(str_replace("-"," ",str_replace("/"," > ",trim($sub_mapping['URLSectionStructure'])))); ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strip_tags($sub_mapping['Sectionname']); ?></option>
		
		 <?php if(!(empty($sub_mapping['sub_sub_section']))) { ?>
		 
		   <?php foreach($sub_mapping['sub_sub_section'] as $sub_sub_mapping) { ?>
    <option id="MainSectionOption" <?php if($sub_sub_mapping['Section_landing'] == 1) { ?> disabled='disabled' <?php } ?>  <?php if(set_value("ddMainSection") == $sub_sub_mapping['Section_id']  || (isset($get_article_details['content_id']) && $get_article_details['Section_id'] == $sub_sub_mapping['Section_id'] )) echo  "selected"; ?>  rel="<?php echo @$sub_sub_mapping['LinkedToColumnist']; ?>" value="<?php echo $sub_sub_mapping['Section_id']; ?>"  sectoin_data="<?php echo @$mapping['Sectionname']; ?>" url_structure="<?php echo mb_ucwords(str_replace("-"," ",str_replace("/"," > ",trim($sub_sub_mapping['URLSectionStructure'])))); ?>" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strip_tags($sub_sub_mapping['Sectionname']); ?></option>
		 <?php
			 $grandchild = $this->db->query('CALL get_section("'.$sub_sub_mapping['Section_id'].'")');	
			 $sec = $grandchild->result_array();
			if(count($sec) > 0){ 
				foreach($sec as $sub_sub_mapping1) { ?>
					<option style="color:green" id="MainSectionOption" <?php if($sub_sub_mapping1['Section_landing'] == 1) { ?> disabled='disabled' <?php } ?>  <?php if(set_value("ddMainSection") == $sub_sub_mapping1['Section_id']  || (isset($get_article_details['content_id']) && $get_article_details['Section_id'] == $sub_sub_mapping1['Section_id'] ) || ($page_name != 'edit_article' && $this->session->userdata('main_section') == $sub_sub_mapping1['Section_id'] && folder_name == 'dmcpan'))  { echo  "selected";  $section_bool=false; }  ?>  rel="<?php echo @$sub_sub_mapping1['LinkedToColumnist']; ?>" value="<?php echo $sub_sub_mapping1['Section_id']; ?>"  sectoin_data="<?php echo @$sub_mapping['Sectionname']; ?>" url_structure="<?php echo mb_ucwords(str_replace("-"," ",str_replace("/"," > ",trim(@$sub_sub_mapping1['BreadCrumb'])))); ?>" author_name="<?php echo (isset($sub_sub_mapping1['AuthorID']) && $sub_sub_mapping1['AuthorID'] == '')? get_authorname_by_id($sub_sub_mapping1['AuthorID']) : '' ; ?>" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strip_tags($sub_sub_mapping1['Sectionname']); ?></option>
			<?php }} ?> 
		<?php } } ?>
  <?php  } } ?>
				 <?php } } } ?>

    </select>
</div>

<div class="FloatLeft TableColumnSearch"><input type="search" placeholder="Search" class="SearchInput" id="search_text" ></div>
<button class="btn btn-primary" type="button" id="article_search_id">Search</button>
<button class="btn btn-primary" id="adv_search">Adv Search</button>
<button class="btn btn-primary" id="clear_search">Clear Search</button>


<p id="srch_error" style="clear: left; color:#F00;margin:0"></p>
</div>


<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Content ID</th>
						<th>HEADLINE</th>
						<th>BREADCRUMB </th>
                        <th>Image</th>
						<th>Author</th>
                        <th>Created By</th>
						<th>Modified By</th>
                        <th>Modified On</th>
						<th>Status</th>
						<!--<th>AMP Status</th>-->
                        <!--<th>Hits</th> -->
                        <?php if((defined("USERACCESS_PUBLISH".$Menu_id) && constant("USERACCESS_PUBLISH".$Menu_id) == 1) || (defined("USERACCESS_UNPUBLISH".$Menu_id) && constant("USERACCESS_UNPUBLISH".$Menu_id) == 1 ) ||   (defined("USERACCESS_EDIT".$Menu_id) && constant("USERACCESS_EDIT".$Menu_id) == 1) ) { ?>
                        <th>Action</th>
                        <?php } ?>
					</tr>
				</thead>
	</table>
    
</div>
</div>                            
</div> 
<!-- Share Modal -->
<div class="modal fade" id="share_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content modal-sm">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"  style="color: #004c93;font-weight: 700 !important;">POST TO :</h4>
			</div>
			<div class="modal-body" style="background: #f4f4f4;">
				<input type="hidden" id="share_id" value="">
				<input type="hidden" id="share_id_tble" value="">
				<table class="table" style="margin:0;color: #004c93;">
					<tr>
						<th style="border:none;">KOO</th>
						<th class="text-right" style="border:none;"><button style="background: #004c93 none repeat scroll 0 0 !important;font-size: 13px;padding: 2px 11px !important;border-radius: 19px !important;" type="button" class="btn btn-primary post_api" data-type="koo">POST</button></th>
					</tr>
					<tr>
						<th style="border:none;">FACEBOOK</th>
						<th class="text-right" style="border:none;"><button style="background: #004c93 none repeat scroll 0 0 !important;font-size: 13px;padding: 2px 11px !important;border-radius: 19px !important;opacity: .5;pointer-events: none;" type="button" class="btn btn-primary post_api" data-type="facebook">POST</button></th>
					</tr>
					<tr>
						<th style="border:none;">TWITTER</th>
						<th class="text-right" style="border:none;"><button style="background: #004c93 none repeat scroll 0 0 !important;font-size: 13px;padding: 2px 11px !important;border-radius: 19px !important;opacity: .5;pointer-events: none;" type="button" class="btn btn-primary post_api" data-type="twitter">POST</button></th>
					</tr>
				</table>
			</div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-primary" data-dismiss="modal" style="border-radius: 50% !important;padding: 10px 12px !important;background: #004c93 none repeat scroll 0 0 !important;"><i class="fa fa-times" style="color:#fff;"></i></button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo image_url; ?>js/bootstrap.min.js"></script>

<!--calendar begind-->
<script  type="text/javascript">

function get_date(input) {
if(input == '') {
return false;
}	else {
// Split the date, divider is '/'
var parts = input.match(/(\d+)/g);
return parts[2]+'/'+parts[1]+'/'+parts[0];
} 
}

jQuery(function(){
 jQuery('#date_timepicker_start').datetimepicker({
  format:'d-m-Y',
  onShow:function(ct){
   this.setOptions({
	   maxDate:get_date($('#date_timepicker_end').val())?get_date($('#date_timepicker_end').val()):false,
   })
  },
  timepicker:false
 });
 jQuery('#date_timepicker_end').datetimepicker({
  format:'d-m-Y',
  onShow:function(ct){
   this.setOptions({
	   minDate:get_date($('#date_timepicker_start').val())?get_date($('#date_timepicker_start').val()):false,
   })
  },
  timepicker:false
 });
 
 jQuery("#date_timepicker_start").change(function(){
if (jQuery('#date_timepicker_end').val()=="") {
jQuery('#date_timepicker_end').val(jQuery('#date_timepicker_start').val());
}
});
jQuery("#date_timepicker_end").change(function(){
if (jQuery('#date_timepicker_start').val()=="") {
jQuery('#date_timepicker_start').val(jQuery('#date_timepicker_end').val());
}
});
 
});

</script>

<script type="text/javascript">

var unpublish_object = {};
var publish_object = {};

$(document).ready(function() {
	
	$(document.body).on("click","#unpublish_checkbox_id",function(){
		var content_id 			= $(this).val();
		var contentversion_id 	= $(this).attr('rel');
		var status 				= $(this).attr('status');
		
		if($(this).is(":checked")) {
			unpublish_object[content_id] = {
				'content_id' 		: content_id,
				'contentversion_id' : contentversion_id,
				'status'			: status
			};
		} else {
			delete unpublish_object[content_id];
		}
		
	});
	
		$(document.body).on("click","#publish_checkbox_id",function(){
		var content_id 			= $(this).val();
		var contentversion_id 	= $(this).attr('rel');
		var status 				= $(this).attr('status');
		
		if($(this).is(":checked")) {
			publish_object[content_id] = {
				'content_id' 		: content_id,
				'contentversion_id' : contentversion_id,
				'status'			: status
			};
		} else {
			delete publish_object[content_id];
		}
		
	});
	
	$("#publish_button").click(function() {
		
		if(parseInt(Object.keys(publish_object).length) != 0) {
			
			var publish_status = confirm("Are you sure you want to publish the selected content?");
					
			if(publish_status == true) {
			
				$("#normal_loading").show();
				var content_data = { 'content_id' : []};
				
				 $.each(publish_object,function(key,value){
							 content_data['content_id'].push(value.content_id);
				});
			
				$.ajax({ 
					url:'<?php echo base_url().folder_name."/common/publish_content";?>',
					type:"POST",
					data:{"contentids" : content_data,"content_type" : 1},
					success: function(data) 
						{
							clear_all_checkbox();
							article_datatables();
							$("#normal_loading").hide();
						}
				});  
			}
		
		} else {
			if(parseInt(Object.keys(publish_object).length) == 0)
				alert('Atleast Select one Unpublished (0r) Draft content checkbox');
			else 
				alert('Published contents cannot be published again');
		}
	});
	
	$("#unpublish_button").click(function() {
		if(parseInt(Object.keys(unpublish_object).length) != 0) {
			
			var publish_status = confirm("Are you sure you want to unpublish the selected content?");
					
			if(publish_status == true) {
			
				$("#normal_loading").show();
				var content_data = { 'content_id' : []};
				
				 $.each(unpublish_object,function(key,value){
						 content_data['content_id'].push(value.content_id);
				});
			
				$.ajax({ 
					url:'<?php echo base_url().folder_name."/common/unpublish_content";?>',
					type:"POST",
					data:{"contentids" : content_data,"content_type" : 1},
					success: function(data) 
						{
							clear_all_checkbox();
							article_datatables();
							$("#normal_loading").hide();
						}
				});  
			}
		
		} else {
			if(parseInt(Object.keys(unpublish_object).length) == 0)
				alert('Atleast Select one published content checkbox');
			else 
				alert('Published contents cannot be published again');
		}
	});

$("#delete_button").click(function() {
		if(parseInt(Object.keys(publish_object).length) != 0) {

		 var Check_Status		= $("#article_status").val();

			if(Check_Status =='D')
			{
			
			var publish_status = confirm("Are you sure you want to Delete the selected content?");
					
			if(publish_status == true) {
			
				$("#normal_loading").show();
				var content_data = { 'content_id' : []};
				
				 $.each(publish_object,function(key,value){
						 content_data['content_id'].push(value.content_id);
				});
			
				$.ajax({ 
					url:'<?php echo base_url().folder_name."/common/delete_draft_content";?>',
					type:"POST",
					data:{"contentids" : content_data,"content_type" : 1},
					success: function(data) 
						{
							clear_all_checkbox();
							article_datatables();
							$("#normal_loading").hide();
						}
				});  
			}
		
		  }
		
		} else {
			if(parseInt(Object.keys(publish_object).length) == 0)
				alert('Atleast Select one Draft content checkbox');
			//else 
			//	alert('Published contents cannot be published again');
		}
	});


$("#flash_msg_id").show();
$("#flash_msg_id").slideDown(function() {
    setTimeout(function() {
        $("#flash_msg_id").slideUp();
    }, 5000);
});

	function clear_all_checkbox() {
		$.each(publish_object,function(key,value){
			var content_id = value.content_id;
			$('input:checkbox[value="' + content_id + '"]').prop('checked', false);
			delete publish_object[content_id];
		});
		$.each(unpublish_object,function(key,value){
			var content_id = value.content_id;
			$('input:checkbox[value="' + content_id + '"]').prop('checked', false);
			delete unpublish_object[content_id];
		});
	}

	function article_datatables() {
		
		 $("#example_length").hide();
		 
	var Section 	= $("#article_section").val();
	var Search_text = $("#search_text").val();
	var SearchBy	= $("#search_by").val();
	var check_in	= $("#date_timepicker_start").val();
	var check_out   = $("#date_timepicker_end").val();
	var Status		= $("#article_status").val();
	var page_name   = "<?php echo $this->uri->segment(2); ?>";
	
    $('#example').dataTable( {
		oLanguage: {
        sProcessing: "<img src='<?php echo image_url; ?>images/admin/loadingroundimage.gif' style='width:40px; height:40px;'>"
    },
        "processing": true,
		 "autoWidth": false,
        "bServerSide": true,
		 "bDestroy": true,
		  "searching": false,
		"iDisplayLength": (folder_name == 'dmcpan') ? 10 : 50,
		 "order": [[ 0 , "desc" ]],
		 "columnDefs": [
		 { "targets": [ 0 ], "visible": true },
		{ "width": "20%", "targets": 1 },
		 { "orderable": false, "targets": 0 },
		 { "orderable": false, "targets": 3 },
		 { "orderable": false, "targets": 9 },
		 ],
		"fnDrawCallback":function(oSettings){
   
		   if($('span a.paginate_button').length <= 1) {
			 $("#example_paginate").hide();
		   } else {
			 $("#example_paginate").show();
		   }
		   
		    $("html, body").animate({ scrollTop: 0 }, "slow");
			
		   $("input[type=checkbox]").each(function() {
			   var content_id = $(this).val();
			  if(publish_object[content_id] != undefined)
				  $(this).prop('checked',true);
			
			  if(unpublish_object[content_id] != undefined)
				  $(this).prop('checked',true);
			
		   });
		  
		   if($(this).find('tbody tr').text()== "No matching records found")
			{
			 $(oSettings.nTHead).hide(); 
			 $('.dataTables_info').hide();
			  $("#example").find('tbody tr').html($('<td valign="top" colspan="10" class="dataTables_empty BackArrow">No matching records found <a href="" data-toggle="tooltip" title="Back to list"><i class="fa fa-reply fa-2x"></i></a></td>'));
			 }
			 else
			 {
			  $(oSettings.nTHead).show(); 
			 }
	 
		},
		
		"ajax": {
            "url": "<?php echo base_url().folder_name; ?>/article_manager/article_datatable",
			"type" : "POST",
			"data" : {
		 "Search_by" : SearchBy, "Section" : Section, "Search_text" : Search_text, "check_in" : check_in, "check_out" : check_out, "Status" : Status, "Page_name" : page_name  
			}
		 }
    } );
	/* $.ajax({
		type:'post',
		cache:false,
		url:'<?php echo base_url().folder_name; ?>/article_manager/amparticle_count',
		data:{'from_date' : check_in , 'end_date' : check_out},
		dataType:'json',
		success:function(result){
			$('.amp_ls').find('b').eq(0).html(result.date);
			$('.amp_ls').find('b').eq(1).html(result.amp);
			$('.amp_ls').find('b').eq(2).html(result.nonamp);
		},
		error:function(err,errcode){
			console.log('error');
		}
	}); */
	 
		
	}
			article_datatables();
			
	
	$('#search_text').keypress(function (e) {
		if($.trim($('#search_text').val()) != '') {
		 var key = e.which;
		 if(key == 13)  {
			 clear_all_checkbox();
			 article_datatables();
		  }  
		}
	});
	$("#clear_search").click(function() {
	document.getElementById('draft_del').style.display='none';
	$("#article_section").val('');
	$("#search_text").val('');
	$("#search_by").val('');
	$("#date_timepicker_start").val('');
	$("#date_timepicker_end").val('');
	$("#article_status").val('');
	
	clear_all_checkbox();
	
	 article_datatables();
	 $("#srch_error").html("");
	});
	
	$("#article_search_id").click(function()
	{
		if($('#search_text').val()!= '' && $.isNumeric($('#search_text').val())){
			$('#search_by').val('ContentId');
			$('option[value="ContentId"]').attr('selected',true);
		}
		if($('#search_by').val() != '')
		{
			if($('#search_text').val() == '')
			{
				$("#srch_error").html("Please enter text to search");
				return false;
			}
			else
			{
				
				article_datatables();
				$("#srch_error").html("");
			}
		}
		else
		{
			article_datatables();
			$("#srch_error").html("");
		}
		if($('#article_status').val() !='' && $('#article_status').val() == 'D')
		document.getElementById('draft_del').style.display ="block";
		else
		document.getElementById('draft_del').style.display ="none";
		
		clear_all_checkbox();
	});
		
			//$("#checkin_checkout_div").hide();
			$("#search_based_date").change(function()
			{
				if(this.checked) 
				{
					$("#checkin_checkout_div").show();
				} 
				else 
				{
					$("#checkin_checkout_div").hide();
				}
				$("#date_timepicker_start").val('');
     			$("#date_timepicker_end").val('');
			});
			
			var pathname = "article_manager"; 
			var alert_name = 'article';
					
			 $(document.body).on('click', '#status_change', function(event)
			 {
				var boolean_value 	= false;
				var id 				= $(this).attr('content_id');	
				var set_status 		= $(this).attr('status');	
				var set_name		= $(this).attr('name');	
				
				 if(set_status == 'U') {
					 
					var publish_status = confirm("Are you sure you want to publish the "+alert_name+"  - "+set_name+"?");
					
						if(publish_status == true) {
							boolean_value = true;
						}
						
						var final_status = 'P';
				} else if(set_status == 'P'){
					
					var unpublish_status = confirm("Are you sure you want to unpublish the "+alert_name+"  - "+set_name+"?");
					
						if(unpublish_status == true) {
							boolean_value = true;
						}
						var final_status = 'U';
				}
				 
				 if(boolean_value == true) {
				 
							
				$.ajax({ 
				url:'<?php echo base_url().folder_name."/common/changestatus";?>',
				type:"POST",
				data:{"contentid":id, "status":final_status,"content_type":1},
				success: function(data) 
					{
						if(data == 'success')
						{
							if(set_status == 'U')
							{
									$("#status"+id).removeClass('fa-caret-right').addClass('fa-pause');
									$("#status"+id).parent('a').attr('status', 'P');
									$("#status"+id).parent('a').attr('title', 'Unpublish');
									
									$("#status_img"+id).removeClass('fa-times').addClass('fa-check');
									$("#img_change"+id).attr('title', 'Published');
									
									$("#change_trash").attr('change_status'+id, 'P');
									
									delete publish_object[id];
									
									article_datatables();
							}
							else if(set_status == 'P')
							{
									$("#status"+id).removeClass('fa-pause').addClass('fa-caret-right');
									$("#status_img"+id).removeClass('fa-check').addClass('fa-times');
									
									$("#status"+id).parent('a').attr('title', 'Publish');
									$("#status"+id).parent('a').attr('status', 'U');;
									$("#img_change"+id).attr('title', 'Unpublished');
									
									$("#change_trash").attr('change_status'+id, 'U');
									
									delete unpublish_object[id];
									
									article_datatables();
							}
						}
		   
					}  
   				});
			}
 
				 
			 });
			 
		$('body').keypress(function (e) {
			if(e.which == 13) {
				$("#article_search_id").click();
			}
		});
		$('#adv_search').on('click',function(e){
			var content_id = $('#search_text').val().trim();
			if(content_id==''){
				toastr.error('please enter either content Id or title');
			}else{
				var openwindow = window.open("<?php echo base_url().folder_name?>/article_search?contentid="+content_id,"new");
			}
		});
		$(document).on('click' , '.share-btn' , function(e){
			$('#share_id').val($(this).data('contentid'));
			$('#share_id_tble').val($(this).data('tbl'));
			$('#share_modal').modal({backdrop: "static"});
		});
		$('.post_api').on('click' , function(e){
			var share_id = $('#share_id').val();
			var share_id_tble = $('#share_id_tble').val();
			var type = $(this);
			if(share_id!=''){
				toastr.remove();
				$.ajax({
					type:'post',
					cache:false,
					data:{'id' : share_id , 'tbl' : share_id_tble , 'type' : type.data('type')},
					url : '<?php echo base_url(folder_name);?>/article_manager/share',
					dataType : 'json',
					success:function(data){
						console.log(data);
						if(data.status==1){
							toastr.success(data.message);
						}else{
							toastr.error(data.message);
						}
					},
					error:function(err , errmsg){
						toastr.error('ERROR CODE : '+err.status+' , '+'ERROR MESSAGE : '+err.statusText);
					}
				})
			}
		});
	});
	/* function amp_validate($contentid ,$archiveID=''){
		toastr.info('please wait......');
		$.ajax({
			type : 'get',
			url : '<?php echo base_url().folder_name; ?>/article_manager/amp_validation?content_id='+$contentid+'&archive='+$archiveID,
			data:{'content_id' : $contentid , 'archive' : $archiveID},
			dataType:'json',
			success:function(result){
				console.log(result);
				toastr.remove();
				if(result.status==0){
					if(result.message!=''){
						$('.amp_'+$contentid).popover({title: "<p>AMP STATUS : ERROR <span class='ampremove' contentid='"+$contentid+"'>x</span></p>", content: result.message, html: true, placement: "top"});
						$('.amp_'+$contentid).fadeIn('slow').popover('show');
					}else{
						toastr.warning('Please click the "amp" button again');
					}
				}else{
					$('.amp_'+$contentid).parent('td').html('<span class="amp_1929529" style="background: #fff;border: 1px solid #d5cbcb;padding: 1px 7px 2px;   border-radius: 50px;color: green;font-weight: bold;font-size: 15px;cursor:pointer;">AMP</span>');
					toastr.success('success');
				}
			},
			error:function(err , errcode){
				console.log('error');
			}
			
		});
		 
	} */
	/* $(document).on( 'click' , '.ampremove'  , function(e){
		$('.amp_'+$(this).attr('contentid')).popover('hide');
	}); */
</script>                       
