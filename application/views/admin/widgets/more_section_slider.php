<div id="other_stories_slide" class="g_whole">
</div>
<script>
$.ajax({
	url			: base_url+'user/commonwidget/get_rightside_stories',
	method		: 'post',
	dataType: 'html',
	data : {section: Section_id, mode: view_mode, type:2, contentid : content_id},
	success:function(response){
		if(response!=''){
			var result = response.replace(/class="most1"/gi , 'class="col-lg-3 col-md-3 col-sm-12 video-widget-up ms-list"');
			result = result.replace(/w100X65/gi , 'w600X300');
			result = result.replace(/id="other_stories_right"/gi , 'id=""');
			result = result.replace(/<p>/gi , '<div class="TransSmall">');
			result = result.replace(/<\/p>/gi , '</div>');
			result = result.replace(/<\/fieldset>/gi , '</fieldset><div id="other_stories_slide1">');
			$("#other_stories_slide").html(result+'</div>');
			$("#other_stories_slide1").slick({dots:!0,arrows:!1,infinite:!0,speed:500,autoplayspeed:500,lazyLoad:"ondemand",slidesToShow:4,autoplay:!0,slidesToScroll:1 ,responsive : [{breakpoint: 767, settings: {slidesToShow: 1, slidesToScroll: 1}},{breakpoint: 480, settings: {slidesToShow: 1, slidesToScroll: 1}}]});
		}
	}
});
</script> 