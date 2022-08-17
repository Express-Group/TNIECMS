<div class="row">
	<?php
	$widget_instance_id =  $content['widget_values']['data-widgetinstanceid'];
	$is_home = $content['is_home_page'];
	$view_mode = $content['mode'];
	$header_details = $this->widget_model->select_setting($view_mode);
	$search_term    = $this->input->get('search_term');
	?>
	<div class="MobileInput"> 
		<form class="" action="<?php echo base_url(); ?>topic"  name="SimpleSearchForm" id="mobileSearchForm" method="get" role="form">
			<input type="text" placeholder="Search..." name="search_term" id="mobile_srch_term" value="<?php echo $search_term;?>"/> <a href="javascript:void(0);" id="mobile_search"><img data-src="<?php echo image_url; ?>images/FrontEnd/images/search-mob.png" src="<?php echo image_url; ?>images/FrontEnd/images/lazy.png" /></a>
		</form>
	</div>
	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-3 share-padd-right-0">
		<div class="social_icons SocialCenter mobile-share">
			<div class="dropdown menucat">
				 <button class="btn btn-default dropdown-toggle menu-default" type="button" data-toggle="dropdown"><span><i class="fa fa-bars"></i></span></button>
				 <ul class="dropdown-menu">
					<!--<li class="all-menu-sub"><a target="_BLANK" style="color:red !important;" href="<?php echo base_url()."business/union-budget"; ?>"><?php echo "Union Budget"; ?></a></li>-->
					<!--<li class="all-menu-sub"><a href="<?php echo base_url()."covid19"; ?>"><?php echo "Covid19 Stats"; ?></a></li>-->
					<li class="all-menu-sub"><a href="<?php echo base_url()."topic/Chess"; ?>"><?php echo "Chess"; ?></a></li>
					<li class="all-menu-sub"><a href="<?php echo base_url()."topic/Commonwealth_Games"; ?>"><?php echo "Common Wealth Games"; ?></a></li>
					<li class="all-menu-sub"><a href="<?php echo base_url()."nation"; ?>"><?php echo "Nation"; ?></a></li>
					<li class="all-menu-sub"><a href="<?php echo base_url()."world"; ?>"><?php echo "World"; ?></a></li>
					<li class="dropdown-submenu all-menu">
						<a  href="<?php echo base_url()."states"; ?>"><?php echo "States"; ?> <i class="fa fa-angle-right"></i></a>
						<ul class="dropdown-menu all-sub-menu">
							<li><a href="<?php echo base_url()."states/tamil-nadu"; ?>"><?php echo "Tamil Nadu"; ?></a></li>
							<li><a href="<?php echo base_url()."states/kerala"; ?>"><?php echo "Kerala"; ?></a></li>
							<li><a href="<?php echo base_url()."states/karnataka"; ?>"><?php echo "Karnataka"; ?></a></li>
							<li><a href="<?php echo base_url()."states/andhra-pradesh"; ?>"><?php echo "Andhra Pradesh"; ?></a></li>
							<li><a href="<?php echo base_url()."states/telangana"; ?>"><?php echo "Telangana"; ?></a></li>
							<li><a href="<?php echo base_url()."states/odisha"; ?>"><?php echo "Odisha"; ?></a></li>
						</ul>
					</li>
					<li class="dropdown-submenu all-menu">
						<a  href="<?php echo base_url()."cities"; ?>"><?php echo "Cities"; ?> <i class="fa fa-angle-right"></i></a>
						<ul class="dropdown-menu all-sub-menu">
							<li><a href="<?php echo base_url()."cities/chennai"; ?>"><?php echo "Chennai"; ?></a></li>
							<li><a href="<?php echo base_url()."cities/delhi"; ?>"><?php echo "Delhi"; ?></a></li>
							<li><a href="<?php echo base_url()."cities/bengaluru"; ?>"><?php echo "Bengaluru"; ?></a></li>
							<li><a href="<?php echo base_url()."cities/hyderabad"; ?>"><?php echo "Hyderabad"; ?></a></li>
							<li><a href="<?php echo base_url()."cities/kochi"; ?>"><?php echo "Kochi"; ?></a></li>
							<li><a href="<?php echo base_url()."cities/thiruvananthapuram"; ?>"><?php echo "Thiruvananthapuram"; ?></a></li>
						</ul>
					</li>
					<li class="all-menu-sub"><a href="<?php echo base_url()."business"; ?>"><?php echo "Business"; ?></a></li>
					<li class="dropdown-submenu all-menu">
						<a  href="<?php echo base_url()."sport"; ?>"><?php echo "Sport"; ?> <i class="fa fa-angle-right"></i></a>
						<ul class="dropdown-menu all-sub-menu">
							<li><a href="<?php echo base_url()."sport/cricket"; ?>"><?php echo "Cricket"; ?></a></li>
							<li><a href="<?php echo base_url()."sport/football"; ?>"><?php echo "Football"; ?></a></li>
							<li><a href="<?php echo base_url()."sport/tennis"; ?>"><?php echo "Tennis"; ?></a></li>
							<li><a href="<?php echo base_url()."sport/other"; ?>"><?php echo "Other"; ?></a></li>
							<li><a href="<?php echo base_url()."sport/womens-t20-world-cup"; ?>"><?php echo "Women's T20 WC"; ?></a></li>
						</ul>
					</li>
					<li class="dropdown-submenu all-menu">
						<a  href="<?php echo base_url()."entertainment"; ?>"><?php echo "Entertainment"; ?> <i class="fa fa-angle-right"></i></a>
						<ul class="dropdown-menu all-sub-menu">
							<li><a href="<?php echo base_url()."entertainment/english"; ?>"><?php echo "English"; ?></a></li>
							<li><a href="<?php echo base_url()."entertainment/hindi"; ?>"><?php echo "Hindi"; ?></a></li>
							<li><a href="<?php echo base_url()."entertainment/kannada"; ?>"><?php echo "Kannada"; ?></a></li>
							<li><a href="<?php echo base_url()."entertainment/malayalam"; ?>"><?php echo "Malayalam"; ?></a></li>
							<li><a href="<?php echo base_url()."entertainment/tamil"; ?>"><?php echo "Tamil"; ?></a></li>
							<li><a href="<?php echo base_url()."entertainment/telugu"; ?>"><?php echo "Telugu"; ?></a></li>
							<li><a href="<?php echo base_url()."entertainment/review"; ?>"><?php echo "Review"; ?></a></li>
						</ul>
					</li>
					<li class="dropdown-submenu all-menu">
						<a  href="<?php echo base_url()."galleries"; ?>"><?php echo "Galleries"; ?> <i class="fa fa-angle-right"></i></a>
						<ul class="dropdown-menu all-sub-menu">
							<li><a href="<?php echo base_url()."galleries/nation"; ?>"><?php echo "Nation"; ?></a></li>
							<li><a href="<?php echo base_url()."galleries/world"; ?>"><?php echo "World"; ?></a></li>
							<li><a href="<?php echo base_url()."galleries/sport"; ?>"><?php echo "Sport"; ?></a></li>
							<li><a href="<?php echo base_url()."galleries/Entertainment"; ?>"><?php echo "Entertainment"; ?></a></li>
							<li><a href="<?php echo base_url()."galleries/0ther"; ?>"><?php echo "Other"; ?></a></li>
						</ul>
					</li>
					<li class="dropdown-submenu all-menu">
						<a  href="<?php echo base_url()."videos"; ?>"><?php echo "Videos"; ?> <i class="fa fa-angle-right"></i></a>
						<ul class="dropdown-menu all-sub-menu">
							<li><a href="<?php echo base_url()."videos/videos-nation"; ?>"><?php echo "Nation"; ?></a></li>
							<li><a href="<?php echo base_url()."videos/videos-world"; ?>"><?php echo "World"; ?></a></li>
							<li><a href="<?php echo base_url()."videos/videos-sport"; ?>"><?php echo "Sport"; ?></a></li>
							<li><a href="<?php echo base_url()."videos/Entertainment"; ?>"><?php echo "Entertainment"; ?></a></li>
							<li><a href="<?php echo base_url()."videos/videos-other"; ?>"><?php echo "Other"; ?></a></li>
						</ul>
					</li>
					<li class="dropdown-submenu all-menu">
						<a  href="<?php echo base_url()."lifestyle"; ?>"><?php echo "Lifestyle"; ?> <i class="fa fa-angle-right"></i></a>
						<ul class="dropdown-menu all-sub-menu">
							<li><a href="<?php echo base_url()."lifestyle/tech"; ?>"><?php echo "Tech"; ?></a></li>
							<li><a href="<?php echo base_url()."lifestyle/health"; ?>"><?php echo "Health"; ?></a></li>
							<li><a href="<?php echo base_url()."lifestyle/travel"; ?>"><?php echo "Travel"; ?></a></li>
							<li><a href="<?php echo base_url()."lifestyle/food"; ?>"><?php echo "Food"; ?></a></li>
							<li><a href="<?php echo base_url()."lifestyle/books"; ?>"><?php echo "Books"; ?></a></li>
							<li><a href="<?php echo base_url()."lifestyle/spirituality"; ?>"><?php echo "Spirituality"; ?></a></li>
						</ul>
					</li>
					<li class="all-menu-sub"><a href="<?php echo base_url()."Specials"; ?>"><?php echo "Specials"; ?></a></li>
					<li class="all-menu-sub"><a href="<?php echo base_url()."good-news"; ?>"><?php echo "Good News"; ?></a></li>
					<li class="all-menu-sub"><a href="<?php echo base_url()."opinions"; ?>"><?php echo "Opinions"; ?></a></li>							
					<li class="all-menu-sub"><a href="<?php echo base_url()."opinions/editorials"; ?>"><?php echo "Editorials"; ?></a></li>
					<li class="all-menu-sub"><a href="<?php echo base_url()."explainers"; ?>"><?php echo "explainers"; ?></a></li>
					<li class="dropdown-submenu all-menu">
						<a  href="<?php echo base_url()."opinions/columns"; ?>"><?php echo "Columns"; ?> <i class="fa fa-angle-right"></i></a>
						<ul class="dropdown-menu all-sub-menu">
							<li><a href="<?php echo base_url()."prabhu-chawla/column"; ?>"><?php echo "Prabhu Chawla"; ?></a></li>
							<li><a href="<?php echo base_url()."opinions/columns/t-j-s-george"; ?>"><?php echo "T J S George"; ?></a></li>
							<li><a href="<?php echo base_url()."opinions/columns/s-gurumurthy"; ?>"><?php echo "S Gurumurthy"; ?></a></li>
							<li><a href="<?php echo base_url()."opinions/columns/ravi-shankar"; ?>"><?php echo "Ravi Shankar"; ?></a></li>
							<li><a href="<?php echo base_url()."opinions/columns/shankkar-aiyar"; ?>"><?php echo "Shankkar Aiyar"; ?></a></li>
							<li><a href="<?php echo base_url()."opinions/columns/shampa-dhar-kamath"; ?>"><?php echo "Shampa Dhar-Kamath"; ?></a></li>
							<li><a href="<?php echo base_url()."opinions/columns/karamatullah-k-ghori"; ?>"><?php echo "Karamatullah K Ghori"; ?></a></li>
						</ul>
					
					</li>
					<li class="all-menu-sub"><a href="https://www.edexlive.com/" target="_blank"><?php echo "Edex"; ?></a></li>
					<li class="all-menu-sub"><a href="https://www.indulgexpress.com/" target="_blank"><?php echo "Indulge"; ?></a></li>
					<li class="all-menu-sub"><a href="https://epaper.newindianexpress.com" target="_blank" ><?php echo "E-paper"; ?></a></li>
					<li class="all-menu-sub"><a target="_BLANK" style="color:red !important;" href="<?php echo base_url()."express-connect"; ?>"><?php echo "Express Connect"; ?></a></li>
					<li class="all-menu-sub"><a target="_BLANK" style="color:red !important;" href="<?php echo base_url()."expressdeals"; ?>"><?php echo "Expressdeals"; ?></a></li>
				 </ul>
			</div>
		</div>
		<ul class="MobileNav">
			<li class="MobileShare dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span><i class="fa fa-share-alt" aria-hidden="true"></i><i class="fa fa-caret-down" aria-hidden="true"></i></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo $header_details['facebook_url'];?>" rel="nofollow" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a href="<?php echo $header_details['google_plus_url'];?>" rel="nofollow" target="_blank"><i class="fa fa-google-plus"></i></a></li>
					<li><a href="<?php echo $header_details['twitter_url'];?>" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li> 
					<li><a href="<?php echo $header_details['rss_url'];?>" target="_blank"><i class="fa fa-rss"></i></i></a></li>
	  
				</ul>
			</li>
		</ul>
	</div>
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
		<div class="main_logo">
		  <?php 
			echo '<a href="'.base_url().'"><img width="616" height="81" data-src="'.image_url.'images/FrontEnd/images/new_logo.jpg" src="'.image_url.'images/FrontEnd/images/lazy_logo.png" alt="site_logo"></a>';
		  ?>
	<!--<div class="loc" id="current_time">
					<?php 
					$day = date('l');
					$month = date('F');
		echo '<span>'.$day.', '.$month.', '.date('d').', '.date('Y').' &nbsp;&nbsp;'.date('h:i:s A ').'</span>';
					?>
		  </div>-->
			
		</div>
	</div>
	 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-2 search-padd-left-0">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<ul class="MobileNav">
					 <?php if($content['page_param']=="1home") { ?>
					<li>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button></li><?php } ?>
					<li class="MobileSearch"><a class="SearchHide" href="javascript:void(0);"><i class="fa fa-search" aria-hidden="true"></i></a></li> 
				</ul>
				<div class="large-screen-search">
					<div class="social-icons-wrapper margin-bottom-10">
						<a class="social-icon-set" href="https://play.google.com/store/apps/details?id=com.tnie" rel="nofollow" target="_blank"><img width="22" height="26" data-src="<?php echo image_url ?>images/FrontEnd/images/social-icon-set/Android_new.png" src="<?php echo image_url; ?>images/FrontEnd/images/lazy.png"></a>
						
						<a class="social-icon-set" href="https://apps.apple.com/in/app/the-new-indian-express/id1588944498" rel="nofollow" target="_blank"><img width="22" height="26" data-src="<?php echo image_url ?>images/FrontEnd/images/social-icon-set/Apple_new.png" src="<?php echo image_url; ?>images/FrontEnd/images/lazy.png"></a>
						
						<a class="social-icon-set" href="<?php echo $header_details['facebook_url'];?>" rel="nofollow" target="_blank"><img width="22" height="26" data-src="<?php echo image_url ?>images/FrontEnd/images/social-icon-set/Fb_new.png" src="<?php echo image_url; ?>images/FrontEnd/images/lazy.png"></a>
						
						<a href="<?php echo $header_details['twitter_url'];?>" target="_blank" class="social-icon-set social-icon-set-youtube"><img width="22" height="26" data-src="<?php echo image_url ?>images/FrontEnd/images/social-icon-set/twitter_new.png" src="<?php echo image_url; ?>images/FrontEnd/images/lazy.png"></a>
						
						<a class="social-icon-set" href="https://instagram.com/newindianexpress/" rel="nofollow" target="_blank"><img width="22" height="26" data-src="<?php echo image_url ?>/images/FrontEnd/images/social-icon-set/Insta_new.png" src="<?php echo image_url; ?>images/FrontEnd/images/lazy.png"></a>
						
						<a class="social-icon-set" href="https://www.youtube.com/user/thenewindianxpress" rel="nofollow" target="_blank"><img width="22" height="26" data-src="<?php echo image_url ?>/images/FrontEnd/images/social-icon-set/YT_new.png" src="<?php echo image_url; ?>images/FrontEnd/images/lazy.png"></a>
						
						<a class="social-icon-set" href="<?php echo $header_details['rss_url'];?>" target="_blank"><img width="22" height="26" data-src="<?php echo image_url ?>/images/FrontEnd/images/social-icon-set/rss_new.png" src="<?php echo image_url; ?>images/FrontEnd/images/lazy.png"></a>
						
						
						<div class="loc" id="current_time" style="font-size: 10px;"><?php echo '<span>'.$day.', '.$month.', '.date('d').', '.date('Y').'</span>'; ?></div>
					</div>
				
					<div class="search1"> 
						<form class="navbar-form formb hide-search-custom" action="<?php echo base_url(); ?>topic"  name="SimpleSearchForm" id="SimpleSearchForm" method="get" role="form">
							<div class="input-group" style="width:100%;">
								<input name="serach-next" type="hidden" value="1" /> 
								<input type="text"  class="form-control tbox" placeholder="Search" name="q" id="srch-term" value="<?php echo $search_term;?>">
								<div class="input-group-btn">
									<input type="hidden" class="form-control tbox"  name="home_search" value="H" id="home_search">
									<button  class="btn btn-default btn-bac" id="search-submit" type="submit"><i class="fa fa-search"></i></button>
									<!--<button class="btn btn-default btn-bac" id="search_btn"><i class="fa fa-search"></i></button>-->
								</div>
							</div>
							<label id="error_throw"></label>
						</form>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {
							$('#SimpleSearchForm').submit(function(e){
								e.preventDefault();
								if($('#srch-term').val().trim()==''){
									$('#error_throw').html('Please provide search keyword(s)').addClass('error');
									$('#srch-term').addClass('error');
								}else if($('#srch-term').val().trim().length < 3){
									$('#error_throw').html('Please Enter more than 2 letters').addClass('error');
									$('#srch-term').addClass('error');
								}else{
									$('#error_throw').html('').removeClass('error');
									$('#srch-term').removeClass('error');
									window.location.href=base_url+'topic?term='+$('#srch-term').val()+'&request=ALL&search=short';
								}
							});
						});
					</script>
				</div>
			</div>
		</div>
	</div>
</div>  