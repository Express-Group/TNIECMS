<style>
.dynamic-table-rendered-container{padding-left:15px;}
.dynamic-table-width{width:19%;float:left;padding-right:0;padding-left:0;margin-right:1%;}	
.table-header-wrapper{background:#143b5a;color:#fff;}
.table-header-wrapper-second{color:#fff; text-align:right;}
.table-header-title{background: #6fa6d1;color: #143b5a;font-weight: 700;}
.common-table-election tbody td{padding:5px !important;font-size:11px;}
.common-table-election tr td:nth-child(2), .common-table-election tr td:nth-child(3), .common-table-election tr td:last-child{ text-align:center;}
.span_bg{ margin:0; padding:0; position:absolute; z-index:99;float:left; width:100%; height:100%; opacity:0.4;top: 38px;left: 62px; }
.common-table-election>tbody>tr>td, .common-table-election>tbody>tr>th, .common-table-election>tfoot>tr>td, .common-table-election>tfoot>tr>th, .common-table-election>thead>tr>td, .common-table-election>thead>tr>th{border:unset;}
.common-table-election{border: 1px solid #143b5a;}
.table-body-content{background: #ebebeb;}
@media only screen and (max-width: 768px){
	.dynamic-table-rendered-container{padding-right: 15px;}
	.dynamic-table-width{width: 100%;margin-right: 0%;}
}
</style>

<?php
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color        = $content['widget_bg_color'];
$widget_custom_title    = $content['widget_title'];
$widget_instance_id     = $content['widget_values']['data-widgetinstanceid'];
$widgetsectionid        = $content['sectionID'];
$main_sction_id 	    = "";
$widget_section_url     = $content['widget_section_url'];
$is_home                = $content['is_home_page'];
$view_mode              = $content['mode'];
$domain_name            =  base_url();
$show_simple_tab        = "";
$max_article            = $content['show_max_article'];
$render_mode            = $content['RenderingMode'];
$pageSection = $content['page_param'];
/*----widgetbconfig ends here------*/
$CI = &get_instance();
$this->live_db = $CI->load->database('live_db' , TRUE);
$SectionDetails = $this->live_db->query("CALL get_section_by_id('".$pageSection."')")->row_array();
$Template .='<div class="row dynamic-table-rendered-container"><span class="col-md-12 text-center" style="font-size: 22px;"><i class="fa fa-refresh fa-spin" aria-hidden="true"></i></span>';
$Template .='</div>';
echo $Template;
?>
<script>
$(document).ready(function(){
	$.ajax({
		type:'post',
		cache:false,
		url:'<?php print BASEURL ?>user/commonwidget/GetDynamicTables',
		data:{'section' : '<?php echo (trim(@$SectionDetails['Sectionname'])!='') ? trim(str_replace(' Elections','',@$SectionDetails['Sectionname'])) : '' ?>'},
		success:function(result){
			$('.dynamic-table-rendered-container').html(result);
		}
	});

});
</script>