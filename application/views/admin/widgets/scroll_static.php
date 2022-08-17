<?php 
$widget_bg_color 		= $content['widget_bg_color'];
$widget_instance_id	 	= $content['widget_values']['data-widgetinstanceid'];
$view_mode              = $content['mode'];
$widget_instance_details= $this->widget_model->getWidgetInstance('', '','', '', $widget_instance_id, $content['mode']);
$widget_position = $content['widget_position'];	 
$height = ($widget_instance_details['AdvertisementScript']=='')? 430 : $widget_instance_details['AdvertisementScript'];
// widget config block ends
?>
<style>
	.container1 .sc-1, .container1 .sc-1 .sc-2 {margin: 0;list-style: none;clear:both;width:100%;color:#000;padding: 0 2px 0;margin-bottom:4%;}
	.container1 {height: <?php echo $height; ?>px;line-height: 18px; border-radius:0px; overflow: Hidden;color:#fff; padding: 2px 0;}
	 .container1:hover{overflow-y:scroll;}
	.date-color{font-size: 13px;color: #000;float:left;width:18.4%;font-weight:bold;text-align:center;}
	.content-color{float:left;width:81.6%;} 

	.container1::-webkit-scrollbar {width: 12px;}
 .container1::-webkit-scrollbar-track { -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); border-radius: 10px;}
 .container1::-webkit-scrollbar-thumb {border-radius: 10px; -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);}
 .container1 .sc-1{background:#f2f2f2;float:left;}
 .container1 .sc-1 .sc-2{background:#fff;margin: 7px 6px 7px;width: 96%;padding: 2%;box-shadow: 1px 1px 1px #00000052;}
 .date-color a{float: left;width: 100%;font-size: 15px;margin-top: 4px;color: #1DA1F2;}
 .sc-2 li{list-style: inherit;}
 .sc-2 ul , .sc-2 ol{padding:0;margin:0;}
</style>
<fieldset class="FieldTopic">
    <legend class="topic"><?php ($widget_instance_details['CustomTitle']=='')? print 'Highlights' : print $widget_instance_details['CustomTitle']; ?></legend>
</fieldset>
<div class="container1 scroll-static-<?php echo $widget_instance_id ?>">
	
</div>
<!--<div class="sensex">
	<table class="table" style="font-family: Droid Serif !important;border: 1px solid #eee;margin-top:5px;">
		<tr>
			<td>SENSEX</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>NIFTY</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
</div>-->

<script type="text/javascript" src="<?php print image_url.'js/jQuery.scrollText.js' ?>"></script>
	<script type="text/javascript">
		/* function sensex(){
			$.ajax({
				url : "https://indices.moneycontrol.co.in/sensex_nifty/indtick.json",
				type:"GET",
				dataType:"jsonp",
				cache:true,
				timeout:3000,
				jsonpCallback:"indicereq",
				crossDomain : true,
				success: function(datas) {
					var change_nse = parseFloat(datas[1].Nchg);
					if(change_nse > 0){
							$($($('.sensex').find('table')).find('tr').eq(1)).find('td').eq(2).html('<i class="fa fa-caret-up" aria-hidden="true"></i>').css({'color':'green'});
							$($($('.sensex').find('table')).find('tr').eq(1)).find('td').eq(3).css({'color':'green'});
					}else{
							$($($('.sensex').find('table')).find('tr').eq(0)).find('td').eq(2).html('<i class="fa fa-caret-down" aria-hidden="true"></i>').css({'color':'red'});
							$($($('.sensex').find('table')).find('tr').eq(0)).find('td').eq(3).css({'color':'red'});
					}
					$($($('.sensex').find('table')).find('tr').eq(1)).find('td').eq(1).html(datas[0]["BValue"]);
					
					var change_bse = parseFloat(datas[0].Bchg);
					if(change_bse > 0){
							$($($('.sensex').find('table')).find('tr').eq(0)).find('td').eq(2).html('<i class="fa fa-caret-up" aria-hidden="true"></i>').css({'color':'green'});
							$($($('.sensex').find('table')).find('tr').eq(0)).find('td').eq(3).css({'color':'green'});
					}else{
							$($($('.sensex').find('table')).find('tr').eq(1)).find('td').eq(2).html('<i class="fa fa-caret-down" aria-hidden="true"></i>').css({'color':'red'});
							$($($('.sensex').find('table')).find('tr').eq(1)).find('td').eq(3).css({'color':'red'});
					}
					$($($('.sensex').find('table')).find('tr').eq(0)).find('td').eq(1).html(datas[0]["BValue"]);
					$($($('.sensex').find('table')).find('tr').eq(1)).find('td').eq(1).html(datas[1]["NValue"]);
					
					$($($('.sensex').find('table')).find('tr').eq(0)).find('td').eq(3).html(datas[0]["Bchg"] + "(" + datas[0]["Bpchg"]  + "%)");
					$($($('.sensex').find('table')).find('tr').eq(1)).find('td').eq(3).html(datas[1]["Nchg"] + "(" + datas[1]["Npchg"]  + "%)");
				}
			});
		} */
		$(document).ready(function(){
			//sensex();
			var sensex_interval = setInterval(function(){sensex()},20000);
			$.ajax({
				type:'post',
				cache:false,
				url:'<?php print BASEURL ?>user/scroll_data/render_news',
				success:function(result){
					$('.container1').html(result);
						 $(".container1").scrollText({
							'duration': 2500,
							'ulheight': $('.scroll-static-<?php echo $widget_instance_id ?>').find('ul').eq(0).height()
						}); 
				}
			
			});
			$(document).on('click','.custom_social',function(){
				var url= encodeURIComponent(window.location.href);
				var text=encodeURIComponent($(this).parents('.date-color').next('.content-color').text());
				$(".fb_share").attr("href", "https://www.facebook.com/sharer/sharer.php?u="+url+'&title='+text);
				$(".twitter_share").attr("href", "https://twitter.com/intent/tweet?text="+ url+'  '+ text+'via @NewIndianXpress');
			});
		});
		 
	</script>

