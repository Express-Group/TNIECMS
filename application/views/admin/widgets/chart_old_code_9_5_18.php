<style>
.chart-svg{width:100%;float:left;}
.highcharts-credits{display:none;}
.party{ width:9px; height:9px; float:left;margin-left: 10px;margin-top: 4px; }  
.chart-content{width:100%;float:left;}
.chart-title{float:left;margin-left: 9px;}
</style>
<?php $widget_custom_title    = $content['widget_title']; ?>
<div class="row chart_widget" >
<div class="col-md-12 chart_widget" id="cahrt_widget_<?php print $widget_custom_title ; ?>">

</div>
</div>

<script>
	function UpdateChart_<?php print $widget_custom_title ?>(){
		$.ajax({ 
			type: 'post',
			url:'<?php print base_url() ?>user/commonwidget/piechart',
			data:{'tid':<?php print $widget_custom_title ; ?>},
			cache:false,
			dataType :'html',
			success:function(result){
			$('#cahrt_widget_<?php print $widget_custom_title ; ?>').html(result); 
			console.log(4);
			},
			error:function(code,status){
				console.log(status);
			}			
		});
	}
	UpdateChart_<?php print $widget_custom_title ?>();
	
	 setInterval(function(){ $.ajax({ 
			type: 'post',
			url:'<?php print base_url() ?>user/commonwidget/piechart',
			data:{'tid':<?php print $widget_custom_title ; ?>},
			cache:false,
			dataType :'html',
			success:function(result){
			$('#cahrt_widget_<?php print $widget_custom_title ; ?>').html(result); 
			console.log(4);
			},
			error:function(code,status){
				console.log(status);
			}			
		}); }, 15000);
</script>